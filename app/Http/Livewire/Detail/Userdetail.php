<?php

namespace App\Http\Livewire\Detail;

use App\Constant\Gender;
use App\Constant\UserRole;
use App\Constant\UserStatus;
use App\Models\Profile;
use App\Models\User;
use App\Services\ConstantService;
use Auth;
use DateTime;
use DB;
use Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Userdetail extends Component
{
    use WithFileUploads;
    
    public $image;

    public $imageUrl;

    public $username;

    public $role;

    public $email;

    public $selectedStatus;

    public $status;

    public $isProfileOpen = true;

    public $isChangePasswordOpen = false;

    public $address;

    public $selectedGender;

    public $genders;

    public $phoneNumber;

    public $dateOfBirth;

    public $currentPassword;

    public $newPassword;

    public $newPasswordAgain;

    public $itemId;

    public $profileId;

    public $isAdmin;

    protected $constantService;

    public function boot(ConstantService $constantService) {
        $this->constantService = $constantService;
    }

    public function mount($itemId) {
        $this->itemId = $itemId;
        $this->setGender();
        $this->setStatus();
        $this->formGenerate();
        $this->profileFormGenerate();
        $this->isAdmin = Auth::user()->role === UserRole::ADMIN;
    }

    public function profileFormGenerate() {
        $result = Profile::selectColumns(['address', 'gender', 'phonenumber', 'date_of_birth'])
                ->where('id', $this->profileId)
                ->first();

        $this->address = $result->address;
        $this->selectedGender = $result->gender;
        $this->phoneNumber = $result->phonenumber;
        $dateTime = new DateTime($result->date_of_birth);
        $this->dateOfBirth = $dateTime->format('Y-m-d');
    }

    public function formGenerate() {
        $result = User::selectColumns(['image_url', 'username', 'role', 'email', 'status', 'profile_id'])
            ->where('users.id', $this->itemId)
            ->first();

        $this->imageUrl = $result->image_url;
        $this->username = $result->username;
        $this->email = $result->email;
        $this->selectedStatus = $result->status;
        $this->role = $this->constantService->getNameConstant(UserRole::class, $result->role);
        $this->image = null;
        $this->profileId = $result->profile_id;
    }

    private function setGender() {
        $this->genders = $this->constantService->getConstantsJson(Gender::class);
    }

    private function setStatus()
    {
        $this->statuses = $this->constantService->getConstantsJson(UserStatus::class);
    }

    public function render()
    {
        return view('livewire.detail.userdetail');
    }

    public function changeProfileState() {
        $this->isProfileOpen = ! $this->isProfileOpen;
    }

    public function changePasswordState() {
        $this->isChangePasswordOpen = ! $this->isChangePasswordOpen;
    }

    public function changePasswordFormGenerate () {
        $this->currentPassword = null;
        $this->newPassword = null;
        $this->newPasswordAgain = null;
    }

    public function saveImage()
    {
        if ($this->image) {
            $imageName = time() . '.' . $this->image->extension();
            $this->image->storeAs('public/images', $imageName);
            $url = asset('storage/images/' . $imageName);

            return $url;
        } else {
            return $this->imageUrl;
        }
    }

    public function save() {
        $user = [
            'username' => trim($this->username),
            'status' => $this->selectedStatus,
        ];

        $result = $this->isValidData($user);

        if (!$result['isValid']) {
            $this->notify('error', $result['message']);

            return;
        }

        $user['image_url'] = $this->saveImage();

        $result = false;
        DB::transaction(function () use ($user, &$result) {
            User::where('id', $this->itemId)->update($user);
            Profile::where('id', $this->profileId)->update([
                'address' => $this->address,
                'gender' => $this->selectedGender,
                'phonenumber' => $this->phoneNumber,
                'date_of_birth' => $this->dateOfBirth
            ]);

            $result = true;
        });

        if ($result) {
            $this->notify('success', 'update user successfully');
        } else {
            $this->notify('error', 'update user fail');
        }

    }

    private function isValidData($user) {
        if ($user['username'] === '') {
            return ['isValid' => false, 'message' => 'Username is invalid'];
        }

        $usernameExists = User::where('id', '<>', $this->itemId)
            ->where('username', $user['username'])
            ->exists();

        if ($usernameExists) {
            return ['isValid' => false, 'message' => 'This username has been exist'];
        }

        return ['isValid' => true];
    }

    public function saveChangePassword() {
        if(!$this->isCurrentPasswordTrue()) {
            $this->notify('error', 'Author fail');
            return;
        }

        $password = trim($this->newPassword);

        $result = $this->isValidPassword($password);

        if(!$result['isValid']) {
            $this->notify('error', $result['message']);
            return;
        }

        if($password !== trim($this->newPasswordAgain)) {
            $this->notify('error', 'Password again is not true');
            return;
        }

        $result = User::where('id', $this->itemId)
                        ->update(['password' => Hash::make($password)]);

        if ($result) {
            $this->notify('success', 'Change password successfully');
        } else {
            $this->notify('error', 'Change password fail');
        }
    }

    private function isValidPassword($password) {
        if(strlen($password) < 6 or !$password) {
            return ['isValid' => false, 'message' => 'Password must have at least 6 characters']; 
        }

        return ['isValid' => true];
    }

    private function isCurrentPasswordTrue() {
        $currentPassword = User::selectColumns(['password'])
                        ->where('id', $this->itemId)
                        ->first();

        if($currentPassword) {
            return Hash::check($this->currentPassword, $currentPassword->password) or Auth::user()->role == UserRole::ADMIN;
        }
        return false;
    }
}
