<?php

namespace Tests\Feature\Posts;

use PHPUnit\Framework\TestCase;

class PostsTests extends TestCase
{
    /** @test */
    public function can_create_a_post()
    {
        $response = $this->postJson('/api/v1/posts', [
            'jwt' => 'test'
        ]);

        $response->assertStatus(401);
    }

}
