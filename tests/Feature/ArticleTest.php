<?php

namespace Tests\Feature;

use App\Article;
use App\Category;
use App\User;
use Tests\TestCase;
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

    public function testCommentShow()
    {
        $relationship = $this->createRelationshipObjectForArticle();
        $article = factory(Article::class)->create(['author_id' => $relationship['author_id'], 'category_id' => $relationship['category_id']]);
        $response = $this->json('GET', route('articles.show', ['article' => $article->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'title',
            'content',
            'category_id',
            'author_id'
        ]);
    }

    public function testArticleShowFailed()
    {
        $response = $this->json('GET', route('articles.show', ['user' => 999]));
        $response->assertStatus(404);
    }

    public function testArticleShowList()
    {
        $response = $this->get(route('articles.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'content',
                    'category_id',
                    'author_id'
                ]
            ]
        ]);

    }

    public function testArticleCreate()
    {
        $relationship = $this->createRelationshipObjectForArticle();
        $data = [
            'title' => 'RTFM',
            'content' => 'tester c\'est douter',
            'category_id' => $relationship['category_id'],
            'author_id' => $relationship['author_id']
        ];
        $this->post(route('articles.store'), $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'title',
                'content',
                'category_id',
                'author_id'
            ]);
    }

    public function testArticleUpdate()
    {
        $relationshipForUpdate = $this->createRelationshipObjectForArticle();
        $relationshipForCreation = $this->createRelationshipObjectForArticle();
        $data = [
            'title' => 'RTFM',
            'content' => 'tester c\'est douter',
            'category_id' => $relationshipForUpdate['category_id'],
            'author_id' => $relationshipForUpdate['author_id']
        ];
        $article = factory(Article::class)->create(['category_id' => $relationshipForCreation['category_id'], 'author_id' => $relationshipForCreation['author_id']]);
        $this->put(route('articles.update', ['article' => $article->id]), $data)
            ->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'RTFM',
                'content' => 'tester c\'est douter',
                'category_id' => $relationshipForUpdate['category_id'],
                'author_id' => $relationshipForUpdate['author_id']
            ])
            ->assertJsonStructure([
                'id',
                'title',
                'content',
                'category_id',
                'author_id'
            ]);
    }

    public function testArticleUpdateFail()
    {
        $relationshipForUpdate = $this->createRelationshipObjectForArticle();
        $data = [
            'title' => 'RTFM',
            'content' => 'tester c\'est douter',
            'category_id' => $relationshipForUpdate['category_id'],
            'author_id' => $relationshipForUpdate['author_id']
        ];
        $this->put(route('articles.update', ['user' => 999]), $data)
            ->assertStatus(404);
    }

    public function testArticleDelete()
    {
        $relationship = $this->createRelationshipObjectForArticle();
        $article = factory(Article::class)->create(['author_id' => $relationship['author_id'], 'category_id' => $relationship['category_id']]);
        $this->delete(route('articles.destroy', ['article' => $article->id]))
            ->assertStatus(204);
    }

    public function testArticleDeleteFail()
    {
        $this->delete(route('articles.destroy', ['user' => 999]))
            ->assertStatus(404);
    }
}
