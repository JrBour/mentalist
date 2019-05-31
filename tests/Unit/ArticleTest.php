<?php

namespace Tests\Unit;

use App\Article;
use App\Category;
use App\User;
use \Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    private function createRelationshipObjectForArticle()
    {
        $category = factory(Category::class)->create();
        $user = factory(User::class)->create();

        return ['category_id' => $category->id, 'author_id' => $user->id];
    }

    public function testArticleCreation()
    {
        $relationship = $this->createRelationshipObjectForArticle();
        $article = factory(Article::class)->create(['author_id' => $relationship['author_id'], 'category_id' => $relationship['category_id']]);
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => $article->title,
            'content' => $article->content,
            'author_id' => $article->author_id,
            'category_id' => $article->category_id,
        ]);
    }

    public function testArticleDelete()
    {
        $relationship = $this->createRelationshipObjectForArticle();
        $article = factory(Article::class)->create(['author_id' => $relationship['author_id'], 'category_id' => $relationship['category_id']]);
        $this->assertTrue($article->delete());
    }
}