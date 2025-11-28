<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Roles
        DB::table('roles_una')->insert([
            ['id_role_una' => 1, 'role_name_una' => 'User', 'created_at' => now(), 'updated_at' => now()],
            ['id_role_una' => 2, 'role_name_una' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. Seed Availability
        DB::table('availability_una')->insert([
            ['id_availability_una' => 1, 'availability_una' => 'Free', 'created_at' => now(), 'updated_at' => now()],
            ['id_availability_una' => 2, 'availability_una' => 'Occupied', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Seed Room Types
        DB::table('room_types_una')->insert([
            ['id_room_type_una' => 1, 'room_type_una' => 'Seminar', 'created_at' => now(), 'updated_at' => now()],
            ['id_room_type_una' => 2, 'room_type_una' => 'Auditorium', 'created_at' => now(), 'updated_at' => now()],
            ['id_room_type_una' => 3, 'room_type_una' => 'Library', 'created_at' => now(), 'updated_at' => now()],
            ['id_room_type_una' => 4, 'room_type_una' => 'Laboratory', 'created_at' => now(), 'updated_at' => now()],
            ['id_room_type_una' => 5, 'room_type_una' => 'Office', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 4. Seed Universities
        DB::table('universities_una')->insert([
            [
                'id_university_una' => 1,
                'university_name_una' => 'SRH University of Applied Sciences Munich',
                'city_country' => 'Munich, Germany',
                'population' => 100,
                'post_code' => 81379,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_university_una' => 2,
                'university_name_una' => 'Technical University of Munich',
                'city_country' => 'Munich, Germany',
                'population' => 3000,
                'post_code' => 80333,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_university_una' => 3,
                'university_name_una' => 'University of Southampton Malaysia',
                'city_country' => 'Johor Bahru, Malaysia',
                'population' => 1000,
                'post_code' => 79100,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // 5. Seed Buildings
        DB::table('buildings_una')->insert([
            [
                'id_building_una' => 1,
                'building_code_una' => 'A1',
                'building_name_una' => 'Engineering Building',
                'id_university_una' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_building_una' => 2,
                'building_code_una' => 'A2',
                'building_name_una' => 'Research Institute',
                'id_university_una' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_building_una' => 3,
                'building_code_una' => 'A3',
                'building_name_una' => 'Health Sciences Center',
                'id_university_una' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_building_una' => 4,
                'building_code_una' => 'B02',
                'building_name_una' => 'Main Campus',
                'id_university_una' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_building_una' => 5,
                'building_code_una' => 'B03',
                'building_name_una' => 'Breakout Rooms',
                'id_university_una' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_building_una' => 6,
                'building_code_una' => null,
                'building_name_una' => 'Main Building',
                'id_university_una' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // 6. Seed Departments
        DB::table('departments_una')->insert([
            [
                'id_department_una' => 1,
                'department_name_una' => 'Faculty of Computer Science',
                'id_university_una' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_department_una' => 2,
                'department_name_una' => 'Faculty of Business',
                'id_university_una' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_department_una' => 3,
                'department_name_una' => 'Faculty of Engineering',
                'id_university_una' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_department_una' => 4,
                'department_name_una' => 'Faculty of Engineering',
                'id_university_una' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // 7. Seed Rooms
        DB::table('rooms_una')->insert([
            [
                'id_room_una' => 2,
                'room_number_una' => '0.05',
                'room_name_una' => 'Teaching Room',
                'floor_number_una' => 1,
                'id_university_una' => 1,
                'id_availability_una' => 1,
                'id_room_type_una' => 1,
                'id_building_una' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_room_una' => 3,
                'room_number_una' => '0.01',
                'room_name_una' => 'Big Auditor',
                'floor_number_una' => 1,
                'id_university_una' => 1,
                'id_availability_una' => 2,
                'id_room_type_una' => 2,
                'id_building_una' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_room_una' => 4,
                'room_number_una' => '1.04',
                'room_name_una' => 'CS Lab',
                'floor_number_una' => 2,
                'id_university_una' => 2,
                'id_availability_una' => 1,
                'id_room_type_una' => 4,
                'id_building_una' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_room_una' => 5,
                'room_number_una' => '2R016',
                'room_name_una' => 'Big Auditorium',
                'floor_number_una' => 2,
                'id_university_una' => 3,
                'id_availability_una' => 1,
                'id_room_type_una' => 2,
                'id_building_una' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // 8. Seed Users (示例数据)
        DB::table('users_una')->insert([
            [
                'username_una' => 'admin',
                'email_una' => 'admin@example.com',
                'password_una' => Hash::make('admin123'),
                'google_auth_una' => null,
                'id_role_una' => 2, // Admin
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'username_una' => 'user',
                'email_una' => 'user@example.com',
                'password_una' => Hash::make('user123'),
                'google_auth_una' => null,
                'id_role_una' => 1, // User
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        $this->command->info('Database seeded successfully!');
    }
}
