<?php

namespace Tests\Feature;

use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCategoryShow()
    {
        $category = factory(Category::class)->create();
        $response = $this->json('GET', route('categories.show', ['category' => $category->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name'
        ]);
    }

    public function testCategoryShowFailed()
    {
        $response = $this->json('GET', route('categories.show', ['category' => 999]));
        $response->assertStatus(404);
    }

    public function testCategoryShowList()
    {
        $response = $this->get(route('categories.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name'
                ]
            ]
        ]);
    }

    public function testCategoryCreate()
    {
        $data = [
            'name' => 'Pipoute'
        ];
        $this->post(route('categories.store'), $data)
            ->assertStatus(201)
            ->assertJsonStructure([
            'id',
            'name'
        ]);
    }

    public function testCategoryUpdate()
    {
        $data = [
            'name' => 'Pipoute'
        ];
        $category = factory(Category::class)->create();
        $this->put(route('categories.update', ['category' => $category->id]), $data)
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Pipoute'
            ])
            ->assertJsonStructure([
                'id',
                'name'
            ]);
    }

    public function testCategoryUpdateFail()
    {
        $data = [
            'name' => 'Pipoute'
        ];
        $this->put(route('categories.update', ['category' => 999]), $data)
            ->assertStatus(404);
    }

    public function testCategoryDelete()
    {
        $category = factory(Category::class)->create();
        $this->delete(route('categories.destroy', ['category' => $category->id]))
            ->assertStatus(204);
    }
}
