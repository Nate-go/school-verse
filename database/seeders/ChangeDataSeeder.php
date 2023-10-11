<?php

namespace Database\Seeders;

use App\Constant\UserRole;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChangeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereNot('role', UserRole::ADMIN)->get();

        foreach($users as $user) {
            $numberOfword = random_int(3, 4);
            $mail = $user->role == UserRole::STUDENT ? 'student.gmail.com' : 'teacher.gmail.com';
            $name = vnfaker()->fullname($numberOfword);

            User::where('id', $user->id)->update([
                'username' => $name,
                'email' => $this->emailRender($name) . str($user->id) . '@' .  $mail
            ]);
        }

        // $subjectNames = [
        //     'Physics' => 'Vật lý',
        //     'Chemistry' => 'Hóa học',
        //     'History' => 'Lịch sử',
        //     'Geography' => 'Địa lý',
        //     'Biology' => 'Sinh học',
        //     'Civic Education' => 'Giáo dục công dân',
        //     'Technology' => 'Công nghệ',
        //     'National Defense Education' => 'Giáo dục quốc phòng',
        //     'Physical Education' => 'Giáo dục thể chất',
        //     'Computer Science' => 'Khoa học máy tính',
        //     'Mathematics' => 'Toán',
        //     'Literature' => 'Ngữ văn',
        //     'English' => 'Anh văn',
        // ];

        // $subjects = Subject::get(); 

        // foreach ($subjects as $subject) {
        //     Subject::where('id', $subject->id)->update([
        //         'name' => $subjectNames[$subject->name]
        //     ]);
        // }
    }

    private function emailRender($str)
    {
        $coDau = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ", "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ");
        $khongDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D");

        $str = str_replace($coDau, $khongDau, $str);

        $str = strtolower($str);

        $str = str_replace(' ', '', $str);

        return $str;
    }
}
