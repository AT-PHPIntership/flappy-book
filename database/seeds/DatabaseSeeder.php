<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(BooksTableSeeder::class);
        $this->call(BorrowsTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(LikesTableSeeder::class);
        $this->call(QrcodesTableSeeder::class);
        $this->call(RatingsTableSeeder::class);
    }
}
