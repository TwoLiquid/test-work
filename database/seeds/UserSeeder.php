<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($this->command->confirm('Do you want to create 300 test users with random data?')) {
            $faker = Faker\Factory::create();

            for($i = 0; $i < 300; $i++) {
                $userData = [];

                $configUserData = config('users.data');
                $configUserGender = config('users.gender');
                $configUserHobbies = config('users.hobbies');

                foreach ($configUserData as $dataItem) {
                    if ($dataItem == 'date_of_birth' && mt_rand(0, 1) == 1) {
                        $createdRandomDate = mt_rand(-631152000, 1009843200);

                        $userData += [
                            'date_of_birth' => \Illuminate\Support\Carbon::createFromTimestamp($createdRandomDate)->toDateString()
                        ];
                    }

                    if ($dataItem == 'gender' && mt_rand(0, 1) == 1) {
                        $createdRandomGender = mt_rand(0, 1);

                        $userData += [
                            'gender' => $configUserGender[$createdRandomGender]
                        ];
                    }

                    if ($dataItem == 'hobby' && mt_rand(0, 1) == 1) {

                        $userHobbies = [];

                        foreach ($configUserHobbies as $hobby) {
                            if (mt_rand(0, 1) == 1) {
                                $userHobbies[] = $hobby;
                            }
                        }

                        $userData += [
                            'hobby' => $userHobbies
                        ];
                    }
                }

                \App\Models\User::create([
                    'name' => $faker->name,
                    'data' => empty($userData) ? null : $userData
                ]);
            }

        }
    }
}
