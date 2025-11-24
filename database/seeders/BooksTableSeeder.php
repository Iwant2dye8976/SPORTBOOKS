<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Faker\Factory as Faker;

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        // Tạo Faker Tiếng Việt
        $faker = Faker::create('vi_VN');

        // Đọc dữ liệu từ books.json
        $json = File::get(database_path('seeders/books.json'));
        $books = json_decode($json, true); // Chuyển JSON thành array

        // Lấy danh sách title và image_url tương ứng
        $book_titles = array_keys($books); // Lấy danh sách tiêu đề sách
        $book_images = array_values($books); // Lấy danh sách link ảnh

        for ($i = 0; $i < 20; $i++) {
            // Random một sách từ danh sách có sẵn
            $index = array_rand($book_titles);
            $title = $book_titles[$index];
            $image_url = $book_images[$index];

            DB::table('books')->insert([
                'title'       => $title, // Lấy tiêu đề từ file JSON
                'author'      => $faker->name, // Tác giả ngẫu nhiên
                'category'    => $faker->randomElement(['Tình cảm', 'Tâm lý', 'Tài chính', 'Thể thao']), // Random thể loại
                'description' => $faker->paragraph(4), // Mô tả sách ngẫu nhiên
                'price'       => $faker->randomFloat(2, 5, 100), // Giá ngẫu nhiên từ 5 đến 100
                // 'isOnDiscount' => $faker->boolean(20), // 20% có giảm giá
                'image_url'   => $image_url, // Lấy link ảnh từ file JSON
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
