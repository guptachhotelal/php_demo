<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReviewTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_app(): void
    {  
        $response = $this->get('/')
            ->assertRedirect('/books');
        $response->assertStatus(302);
    }

    public function test_book_home(): void
    {  
        $response = $this->get('/books');
        $response->assertSeeText('Books');
    }

    public function test_book_search(): void
    {  
        $response = $this->get('/books?title=Voluptas');
        $response->assertSeeText('Books');
        $response->assertSeeText('Voluptas');
    }
}
