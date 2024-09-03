<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Book::factory()->count(50)->create()->each(function ($book) {

            // Прикрепляем случайные жанры к каждой книге
            $genres = Genre::inRandomOrder()->take(rand(1, 10))->pluck('id');
            $book->genres()->attach($genres);
        });
    }
}
