<?php

namespace Tests\Feature;

use App\Models\PrimaryCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRouteCheckTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_route(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_post_show(): void
    {
        $response = $this->get('/post/1');
        $response->assertStatus(200);
    }

    // カテゴリのテスト
    public function test_search(): void
    {
        $response = $this->get('/search');
        $response->assertStatus(200);
    }

    public function test_category(): void
    {
        $response = $this->get('/category');
        $response->assertStatus(200);
    }

    public function test_category_id(): void
    {
        $primaryCategoryIds = PrimaryCategory::all()->pluck('id');
        foreach ($primaryCategoryIds as $categoryId) {
            $response = $this->get('/category' . '/' . $categoryId);
            $response->assertStatus(200);
        }
    }


}
