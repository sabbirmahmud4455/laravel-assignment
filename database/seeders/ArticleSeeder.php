<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();

        $lastId = DB::table('articles')->latest('id')->value('id') ? DB::table('articles')->latest('id')->value('id') : 0;

        DB::table('articles')->insert([
            [
                'id' => $lastId + 1,
                'user_id' => '1',
                'title' => 'seeder title 1',
                'slug' => 'seeder-title-1',
                'description' => 'seeder description 1',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'id' => $lastId + 2,
                'user_id' => '2',
                'title' => 'seeder title 2',
                'slug' => 'seeder-title-2',
                'description' => 'seeder description 2',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'id' => $lastId + 3,
                'user_id' => '3',
                'title' => 'seeder title 3',
                'slug' => 'seeder-title-3',
                'description' => 'seeder description 3',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'id' => $lastId + 4,
                'user_id' => '4',
                'title' => 'seeder title 4',
                'slug' => 'seeder-title-4',
                'description' => 'seeder description 4',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'id' => $lastId + 5,
                'user_id' => '5',
                'title' => 'seeder title 5',
                'slug' => 'seeder-title-5',
                'description' => 'seeder description 5',
                'created_at' => $date,
                'updated_at' => $date,
            ],
        ]);
    }
}
