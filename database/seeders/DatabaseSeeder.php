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
            ['id_role_una' => 1, 'role_name_una' => 'User'],
            ['id_role_una' => 2, 'role_name_una' => 'Admin'],
        ]);

        // 2. Seed Availability
        DB::table('availability_una')->insert([
            ['id_availability_una' => 1, 'availability_una' => 'Free'],
            ['id_availability_una' => 2, 'availability_una' => 'Occupied'],
        ]);

        // 3. Seed Room Types
        DB::table('room_types_una')->insert([
            ['id_room_type_una' => 1, 'room_type_una' => 'Seminar'],
            ['id_room_type_una' => 2, 'room_type_una' => 'Auditorium'],
            ['id_room_type_una' => 3, 'room_type_una' => 'Library'],
            ['id_room_type_una' => 4, 'room_type_una' => 'Laboratory'],
            ['id_room_type_una' => 5, 'room_type_una' => 'Office'],
            ['id_room_type_una' => 6, 'room_type_una' => 'Studio'],
            ['id_room_type_una' => 7, 'room_type_una' => 'Others'],
        ]);

        // 4. Seed Universities
        DB::table('universities_una')->insert([
            [
                'id_university_una' => 1,
                'university_name_una' => 'SRH University of Applied Sciences Munich',
                'city_country' => 'Munich, Germany',
                'population' => 100,
                'post_code' => 81379,
            ],
            [
                'id_university_una' => 2,
                'university_name_una' => 'Technical University of Munich',
                'city_country' => 'Munich, Germany',
                'population' => 3000,
                'post_code' => 80333,
            ],
            [
                'id_university_una' => 3,
                'university_name_una' => 'University of Southampton Malaysia',
                'city_country' => 'Johor Bahru, Malaysia',
                'population' => 1000,
                'post_code' => 79100,
            ],
        ]);

        // 5. Seed Buildings
        DB::table('buildings_una')->insert([
            [
                'id_building_una' => 1,
                'building_code_una' => 'A1',
                'building_name_una' => 'Engineering Building',
                'id_university_una' => 2,
            ],
            [
                'id_building_una' => 2,
                'building_code_una' => 'A2',
                'building_name_una' => 'Research Institute',
                'id_university_una' => 2,
            ],
            [
                'id_building_una' => 3,
                'building_code_una' => 'A3',
                'building_name_una' => 'Health Sciences Center',
                'id_university_una' => 2,
            ],
            [
                'id_building_una' => 4,
                'building_code_una' => 'B02',
                'building_name_una' => 'Main Campus',
                'id_university_una' => 3,
            ],
            [
                'id_building_una' => 5,
                'building_code_una' => 'B03',
                'building_name_una' => 'Breakout Rooms',
                'id_university_una' => 3,
            ],
            [
                'id_building_una' => 6,
                'building_code_una' => null,
                'building_name_una' => 'Main Building',
                'id_university_una' => 1,
            ],
            [
                'id_building_una' => 7,
                'building_code_una' => 'A4',
                'building_name_una' => 'Medical Center',
                'id_university_una' => 2,
            ],
            [
                'id_building_una' => 8,
                'building_code_una' => 'A5',
                'building_name_una' => 'Hall of Science',
                'id_university_una' => 2,
            ],
            [
                'id_building_una' => 9,
                'building_code_una' => 'A6',
                'building_name_una' => 'Technological Center',
                'id_university_una' => 2,
            ],
            [
                'id_building_una' => 10,
                'building_code_una' => 'A7',
                'building_name_una' => 'Student Area',
                'id_university_una' => 2,
            ],
        ]);

        // 6. Seed Departments
        DB::table('departments_una')->insert([
            [
                'id_department_una' => 1,
                'department_name_una' => 'Faculty of Computer Science',
                'id_university_una' => 3,
            ],
            [
                'id_department_una' => 2,
                'department_name_una' => 'Faculty of Business',
                'id_university_una' => 3,
            ],
            [
                'id_department_una' => 3,
                'department_name_una' => 'Faculty of Engineering',
                'id_university_una' => 3,
            ],
            [
                'id_department_una' => 4,
                'department_name_una' => 'Faculty of Engineering',
                'id_university_una' => 2,
            ],
            [
                'id_department_una' => 5,
                'department_name_una' => 'Computer Science Department',
                'id_university_una' => 1,
            ],
            [
                'id_department_una' => 6,
                'department_name_una' => 'Business Department',
                'id_university_una' => 1,
            ],
            [
                'id_department_una' => 7,
                'department_name_una' => 'Science Department',
                'id_university_una' => 1,
            ],
        ]);

        // 7. Seed Rooms（基础样例数据）
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
                'directions_una' => 'Enter the building and turn right',
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
                'directions_una' => 'Enter the building and turn right',
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
                'directions_una' => 'Enter the building, go straight, turn right, go straight, turn left and go straight',
            ],
            [
                'id_room_una' => 6,
                'room_number_una' => '0.02',
                'room_name_una' => 'Studio',
                'floor_number_una' => 1,
                'id_university_una' => 1,
                'id_availability_una' => 1,
                'id_room_type_una' => 6,
                'id_building_una' => 6,
                'directions_una' => 'Enter the building, go straight, turn left, go straight and turn right',
            ],
            [
                'id_room_una' => 7,
                'room_number_una' => '0.03',
                'room_name_una' => 'Teaching Room',
                'floor_number_una' => 1,
                'id_university_una' => 1,
                'id_availability_una' => 1,
                'id_room_type_una' => 1,
                'id_building_una' => 6,
                'directions_una' => 'Enter the building and go straight',
            ],
            [
                'id_room_una' => 8,
                'room_number_una' => '0.04',
                'room_name_una' => 'Creative Room',
                'floor_number_una' => 1,
                'id_university_una' => 1,
                'id_availability_una' => 1,
                'id_room_type_una' => 7,
                'id_building_una' => 6,
                'directions_una' => 'Enter the building, go straight, turn right, go straight and turn left',
            ],
            [
                'id_room_una' => 9,
                'room_number_una' => '1.01',
                'room_name_una' => 'Manager\'s Officer',
                'floor_number_una' => 2,
                'id_university_una' => 1,
                'id_availability_una' => 2,
                'id_room_type_una' => 5,
                'id_building_una' => 6,
                'directions_una' => 'Enter the building, go straight, turn right to the stairs, go up, turn right and go straight',
            ],
            [
                'id_room_una' => 10,
                'room_number_una' => '1.02',
                'room_name_una' => 'Teaching Room',
                'floor_number_una' => 2,
                'id_university_una' => 1,
                'id_availability_una' => 2,
                'id_room_type_una' => 1,
                'id_building_una' => 6,
                'directions_una' => 'Enter the building, go straight, turn right to the stairs, go up, turn left and go straight',
            ],
            [
                'id_room_una' => 11,
                'room_number_una' => '1.03',
                'room_name_una' => 'Computer Lab',
                'floor_number_una' => 2,
                'id_university_una' => 1,
                'id_availability_una' => 2,
                'id_room_type_una' => 4,
                'id_building_una' => 6,
                'directions_una' => 'Enter the building, go straight, turn right to the stairs, go up, turn left and go straight',
            ],
            [
                'id_room_una' => 12,
                'room_number_una' => '1.04',
                'room_name_una' => 'Teaching Room',
                'floor_number_una' => 2,
                'id_university_una' => 1,
                'id_availability_una' => 1,
                'id_room_type_una' => 1,
                'id_building_una' => 6,
                'directions_una' => 'Enter the building, go straight, turn right to the stairs, go up and turn left',
            ],
            [
                'id_room_una' => 13,
                'room_number_una' => '1.05',
                'room_name_una' => 'Student\'s Library',
                'floor_number_una' => 2,
                'id_university_una' => 1,
                'id_availability_una' => 1,
                'id_room_type_una' => 3,
                'id_building_una' => 6,
                'directions_una' => 'Enter the building, go straight, turn right to the stairs, go up and turn right',
            ],
            [
                'id_room_una' => 14,
                'room_number_una' => '2R015',
                'room_name_una' => 'Student Classroom',
                'floor_number_una' => 2,
                'id_university_una' => 3,
                'id_availability_una' => 2,
                'id_room_type_una' => 1,
                'id_building_una' => 4,
                'directions_una' => 'Enter the building, go straight, turn left and go straight',
            ],
            [
                'id_room_una' => 15,
                'room_number_una' => '2R014',
                'room_name_una' => 'Student Association',
                'floor_number_una' => 2,
                'id_university_una' => 3,
                'id_availability_una' => 1,
                'id_room_type_una' => 7,
                'id_building_una' => 4,
                'directions_una' => 'Enter the building, go straight, turn left, go straight, turn right and go straight',
            ],
            [
                'id_room_una' => 16,
                'room_number_una' => '3R023',
                'room_name_una' => 'Computer Science Laboratory',
                'floor_number_una' => 3,
                'id_university_una' => 3,
                'id_availability_una' => 1,
                'id_room_type_una' => 4,
                'id_building_una' => 4,
                'directions_una' => 'Enter the building, go straight to the stairs, go up, turn left and go straight',
            ],
            [
                'id_room_una' => 17,
                'room_number_una' => '3R024',
                'room_name_una' => 'Student Classroom',
                'floor_number_una' => 3,
                'id_university_una' => 3,
                'id_availability_una' => 1,
                'id_room_type_una' => 1,
                'id_building_una' => 4,
                'directions_una' => 'Enter the building, go straight to the stairs, go up and go straight',
            ],
            [
                'id_room_una' => 18,
                'room_number_una' => '3R025',
                'room_name_una' => 'Student Classroom',
                'floor_number_una' => 3,
                'id_university_una' => 3,
                'id_availability_una' => 2,
                'id_room_type_una' => 1,
                'id_building_una' => 4,
                'directions_una' => 'Enter the building, go straight to the stairs, go up, turn right and go straight',
            ],
            [
                'id_room_una' => 19,
                'room_number_una' => '3R026',
                'room_name_una' => 'Student Classroom',
                'floor_number_una' => 3,
                'id_university_una' => 3,
                'id_availability_una' => 2,
                'id_room_type_una' => 1,
                'id_building_una' => 4,
                'directions_una' => 'Enter the building, go straight to the stairs, go up, turn right and go straight',
            ],
            [
                'id_room_una' => 20,
                'room_number_una' => '3R027',
                'room_name_una' => 'Computer Science Laboratory',
                'floor_number_una' => 3,
                'id_university_una' => 3,
                'id_availability_una' => 2,
                'id_room_type_una' => 4,
                'id_building_una' => 4,
                'directions_una' => 'Enter the building, go straight to the stairs, go up, turn right and go straight',
            ],
        ]);

        /**
         * 7b. 为每个已有的 University / Building / Floor 组合补充至少一个房间（dummy data）
         *
         * 说明：
         * - 楼层（floor）在系统中是根据 rooms_una.floor_number_una 动态计算的
         * - 这里我们人为定义一组常用楼层：0, 1, 2, 3
         * - 对于每一栋已有的 building，如果在某一楼层上没有任何房间，则补充一条占位房间记录
         *
         * 这样可以保证：
         * - 对前端来说，每个已有的 University / Building / Floor 组合，都会有至少一间 room 可以展示
         */
        $buildings = DB::table('buildings_una')->get();
        $defaultFloors = [0, 1, 2, 3];

        foreach ($buildings as $building) {
            foreach ($defaultFloors as $floor) {
                $exists = DB::table('rooms_una')
                    ->where('id_building_una', $building->id_building_una)
                    ->where('floor_number_una', $floor)
                    ->exists();

                if ($exists) {
                    continue;
                }

                // 为缺失楼层创建一条占位房间记录
                DB::table('rooms_una')->insert([
                    'room_number_una'    => sprintf('B%02d-F%d-R01', $building->id_building_una, $floor),
                    'room_name_una'      => 'Dummy Room ' . ($building->building_name_una ?? $building->building_code_una ?? 'Building ' . $building->id_building_una) . ' - Floor ' . $floor,
                    'floor_number_una'   => $floor,
                    'id_university_una'  => $building->id_university_una,
                    'id_availability_una'=> 1, // 默认 Free
                    'id_room_type_una'   => 1, // 默认 Seminar
                    'id_building_una'    => $building->id_building_una,
                    'directions_una'     => 'Dummy directions: go straight and follow the signs.',
                ]);
            }
        }

        // 8. Seed Users (示例数据)
        DB::table('users_una')->insert([
            [
                'username_una' => 'admin',
                'email_una' => 'admin@example.com',
                'password_una' => Hash::make('admin123'),
                'google_auth_una' => null,
                'id_role_una' => 2, // Admin
            ],
            [
                'username_una' => 'user',
                'email_una' => 'user@example.com',
                'password_una' => Hash::make('user123'),
                'google_auth_una' => null,
                'id_role_una' => 1, // User
            ],
        ]);

        $this->command->info('Database seeded successfully!');
    }
}
