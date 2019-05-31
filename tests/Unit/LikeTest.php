<?php

namespace Tests\Unit;

use App\Article;
use App\Category;
use App\Like;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    private function createRelationshipObjectForLike()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        $article = factory(Article::class)->create(['author_id' => $user->id, 'category_id' => $category->id]);

        return ['article_id' => $article->id, 'user_id' => $user->id];
    }

    public function testLikeCreation()
    {
        $relationship = $this->createRelationshipObjectForLike();
        $like = factory(Like::class)->create(['user_id' => $relationship['user_id'], 'article_id' => $relationship['article_id']]);
        $this->assertDatabaseHas('likes', [
            'id' => $like->id,
            'article_id' => $like->article_id,
            'user_id' => $like->user_id
        ]);
    }
}