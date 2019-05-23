<?php

use App\Article;
use App\Category;
use App\Comment;
use App\Like;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 30)->create();
        factory(Category::class, 30)->create();
        factory(Article::class, 50)->create();
        factory(Comment::class, 50)->create();
        factory(Like::class, 50)->create();
    }
}
