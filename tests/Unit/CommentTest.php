<?php

namespace Tests\Unit;

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

    public function testCommentCreation()
    {
        $relationship = $this->createRelationshipObjectForComment();
        $comment = factory(Comment::class)->create(['author_id' => $relationship['author_id'], 'article_id' => $relationship['article_id']]);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'content' => $comment->content,
            'author_id' => $comment->author_id,
            'article_id' => $comment->article_id
        ]);
    }
}