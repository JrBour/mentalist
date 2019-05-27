<?php

namespace Tests\Feature;

use App\Article;
use App\Category;
use App\Comment;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    private function createRelationshipObjectForComment()
    {
        $category = factory(Category::class)->create();
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create(['category_id' => $category->id, 'author_id' => $user->id]);

        return ['article_id' => $article->id, 'author_id' => $user->id];
    }

    public function testCommentShow()
    {
        $relationship = $this->createRelationshipObjectForComment();
        $comment = factory(Comment::class)->create(['author_id' => $relationship['author_id'], 'article_id' => $relationship['article_id']]);
        $response = $this->json('GET', route('comments.show', ['comment' => $comment->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'content',
            'article_id',
            'author_id'
        ]);
    }

    public function testCommentShowFailed()
    {
        $response = $this->json('GET', route('comments.show', ['user' => 999]));
        $response->assertStatus(404);
    }

    public function testCommentShowList()
    {
        $response = $this->get(route('comments.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'content',
                    'article_id',
                    'author_id'
                ]
            ]
        ]);

    }

    public function testCommentCreate()
    {
        $relationship = $this->createRelationshipObjectForComment();
        $data = [
            'content' => 'tester c\'est douter',
            'article_id' => $relationship['article_id'],
            'author_id' => $relationship['author_id']
        ];
        $this->post(route('comments.store'), $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'content',
                'article_id',
                'author_id'
            ]);
    }

    public function testCommentUpdate()
    {
        $relationshipForUpdate = $this->createRelationshipObjectForComment();
        $relationshipForCreation = $this->createRelationshipObjectForComment();
        $data = [
            'content' => 'tester c\'est douter',
            'article_id' => $relationshipForUpdate['article_id'],
            'author_id' => $relationshipForUpdate['author_id']
        ];
        $comment = factory(Comment::class)->create(['article_id' => $relationshipForCreation['article_id'], 'author_id' => $relationshipForCreation['author_id']]);
        $this->put(route('comments.update', ['user' => $comment->id]), $data)
            ->assertStatus(200)
            ->assertJsonFragment([
                'content' => 'tester c\'est douter',
                'article_id' => $relationshipForUpdate['article_id'],
                'author_id' => $relationshipForUpdate['author_id']
            ])
            ->assertJsonStructure([
                'id',
                'content',
                'article_id',
                'author_id'
            ]);
    }

    public function testCommentUpdateFail()
    {
        $relationshipForUpdate = $this->createRelationshipObjectForComment();
        $data = [
            'content' => 'tester c\'est douter',
            'article_id' => $relationshipForUpdate['article_id'],
            'author_id' => $relationshipForUpdate['author_id']
        ];
        $this->put(route('comments.update', ['user' => 999]), $data)
            ->assertStatus(404);
    }

    public function testCommentDelete()
    {
        $relationship = $this->createRelationshipObjectForComment();
        $comment = factory(Comment::class)->create(['author_id' => $relationship['author_id'], 'article_id' => $relationship['article_id']]);
        $this->delete(route('comments.destroy', ['comment' => $comment->id]))
            ->assertStatus(204);
    }

    public function testUserDeleteFail()
    {
        $this->delete(route('comments.destroy', ['user' => 999]))
            ->assertStatus(404);
    }
}
