<?php

namespace Database\Seeders;

use App\Constant\UserRole;
use App\Models\ParentStudent;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public $relationships = ['Cha', 'Mẹ', 'Chú', 'Cô', 'Bác', 'Anh trai', 'Chị gái'];

    public function run(): void
    {
        $students = User::where('role', UserRole::STUDENT)->get();

        foreach($students as $student) {
            $randomRelationship = random_int(0, count($this->relationships) - 1);
            ParentStudent::create([
                'gender' => random_int(0, 2),
                'address' => vnfaker()->address(),
                'email' => vnfaker()->email(['parent.gmail.com']),
                'user_id' => $student->id,
                'phonenumber' => fake()->phoneNumber(),
                'relationship' => $this->relationships[$randomRelationship],
                'name' => vnfaker()->fullname(3)
            ]);
        }
    }
}
