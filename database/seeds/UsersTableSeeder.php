<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['employ_code' => 'AT-00001',
            'name' => 'Tram Pham T.M.',
            'email' => 'tram.pham@asiantech.vn',
            'team' => 'PHP',
            'avatar_url' => 'image1.jpg',
            'is_admin' => '0',
            ],
            ['employ_code' => 'AT-00002',
            'name' => 'Hieu Le T.',
            'email' => 'hieu.le@asiantech.vn',
            'team' => 'IOS',
            'avatar_url' => 'image2.jpg',
            'is_admin' => '0',
            ],
            ['employ_code' => 'AT-00003',
            'name' => 'Dong Ho V.',
            'email' => 'dong.ho@asiantech.vn',
            'team' => 'FE',
            'avatar_url' => 'image3.jpg',
            'is_admin' => '0',
            ],
            ['employ_code' => 'AT-00004',
            'name' => 'Sa Pham T.M',
            'email' => 'sa.pham@asiantech.vn',
            'team' => 'SA',
            'avatar_url' => 'image4.jpg',
            'is_admin' => '1',
            ],
            ['employ_code' => 'AT-00005',
            'name' => 'BO Le',
            'email' => 'bo.le@asiantech.vn',
            'team' => 'BO',
            'avatar_url' => 'image5.jpg',
            'is_admin' => '1',
            ],
            ['employ_code' => 'AT-00006',
            'name' => 'Duong Tran V.',
            'email' => 'duong.tran@asiantech.vn',
            'team' => 'QC',
            'avatar_url' => 'image6.jpg',
            'is_admin' => '0',
            ]
        ]);
    }
}
