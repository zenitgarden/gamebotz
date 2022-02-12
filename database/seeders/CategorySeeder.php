<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
                [
                'title' => 'PC',
                'slug' => 'pc',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'parent_id' => null
                ],
                [
                'title' => 'Console',
                'slug' => 'console',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'parent_id' => null
                ],
                [
                'title' => 'PS 5',
                'slug' => 'ps-5',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'parent_id' => 2
                ],
                [
                'title' => 'Mobile',
                'slug' => 'mobile',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'parent_id' => null
                ],
                [
                    'title' => 'News',
                    'slug' => 'news',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'parent_id' => null
                ],
                [
                    'title' => 'Esports',
                    'slug' => 'esports',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'parent_id' => null
                ],
        ]);
    }
}
