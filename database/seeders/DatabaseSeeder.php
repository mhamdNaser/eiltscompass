<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call([ // If you have other seeders, you can include them here
        //     PaypalTableSeeder::class,
        // ]);

        // Check if the users table is empty
        $existingUserCount = User::count();

        // Only seed users table if it's empty
        if ($existingUserCount === 0) {
            // Load users_data.php file
            $usersData = require database_path('mydata/users_data.php');

            // Seed users table using the User model factory
            User::factory()->count(10)->create(); // Creates 10 dummy users using the factory

            // Seed the data from users_data.php
            foreach ($usersData as $userData) {
                User::create($userData);
            }
        }
    }
}
