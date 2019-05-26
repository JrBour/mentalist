<?php

namespace Tests\Feature;

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
        $category= factory(Category::class)->create();
        $article = factory(Article::class)->create(['author_id' => $user->id, 'category_id' => $category->id]);

        return ['article_id' => $article->id, 'user_id' => $user->id];
    }

    public function testLikeShow()
    {
        $relationship = $this->createRelationshipObjectForLike();
        $like = factory(Like::class)->create(['user_id' => $relationship['user_id'], 'article_id' => $relationship['article_id']]);
        $response = $this->json('GET', route('likes.show', ['like' => $like->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'article_id',
            'user_id'
        ]);
    }

    public function testLikeShowFailed()
    {
        $response = $this->json('GET', route('likes.show', ['user' => 999]));
        $response->assertStatus(404);
    }

    public function testLikeShowList()
    {
        $response = $this->get(route('likes.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'article_id',
                    'user_id'
                ]
            ]
        ]);

    }

    public function testLikeCreate()
    {
        $relationship = $this->createRelationshipObjectForLike();
        $data = [
            'article_id' => $relationship['article_id'],
            'user_id' => $relationship['user_id']
        ];
        $this->post(route('likes.store'), $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'article_id',
                'user_id'
            ]);
    }

    public function testLikeUpdate()
    {
        $relationshipForUpdate = $this->createRelationshipObjectForLike();
        $relationshipForCreation = $this->createRelationshipObjectForLike();
        $data = [
            'article_id' => $relationshipForUpdate['article_id'],
            'user_id' => $relationshipForUpdate['user_id']
        ];
        $like = factory(Like::class)->create(['article_id' => $relationshipForCreation['article_id'], 'user_id' => $relationshipForCreation['user_id']]);
        $this->put(route('likes.update', ['like' => $like->id]), $data)
            ->assertStatus(200)
            ->assertJsonFragment([
                'article_id' => $relationshipForUpdate['article_id'],
                'user_id' => $relationshipForUpdate['user_id']
            ])
            ->assertJsonStructure([
                'id',
                'article_id',
                'user_id'
            ]);
    }

    public function testLikeUpdateFail()
    {
        $relationshipForUpdate = $this->createRelationshipObjectForLike();
        $data = [
            'article_id' => $relationshipForUpdate['article_id'],
            'user_id' => $relationshipForUpdate['user_id']
        ];
        $this->put(route('likes.update', ['like' => 999]), $data)
            ->assertStatus(404);
    }

    public function testLikeDelete()
    {
        $relationship = $this->createRelationshipObjectForLike();
        $article = factory(Like::class)->create(['article_id' => $relationship['article_id'], 'user_id' => $relationship['user_id']]);
        $this->delete(route('likes.destroy', ['like' => $article->id]))
            ->assertStatus(204);
    }

    public function testLikeDeleteFail()
    {
        $this->delete(route('likes.destroy', ['user' => 999]))
            ->assertStatus(404);
    }
}
