<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 200; $i++) {
            DB::table('books')->insert([
                'title'       => $faker->sentence(3), // Tiêu đề sách ngẫu nhiên
                'author'      => $faker->name, // Tác giả ngẫu nhiên
                'category'    => $faker->randomElement(['normal', 'science', 'fiction']), // Chọn ngẫu nhiên thể loại
                'description' => $faker->paragraph(4), // Mô tả sách
                'price'       => $faker->randomFloat(2, 5, 100), // Giá từ 5 đến 100
                'isOnDiscount'=> $faker->boolean(20), // 20% cơ hội là có giảm giá
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
