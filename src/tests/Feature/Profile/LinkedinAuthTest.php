<?php

namespace Tests\Feature\Profile;

use App\Http\Controllers\V1\AuthController;
use App\Models\LinkedinOAuth;
use Tests\TestCase;

class LinkedinAuthTest extends TestCase
{
    /** @test */
    public function request_an_authorization_code()
    {
        $response = $this->get('/api/v1/auth');

        $response->assertStatus(302);
    }

    /** @test */
    public function application_provides_bad_code()
    {
        $testData = http_build_query([
            'code' => '123456789',
            'state' => LinkedinOAuth::STATE
        ]);

        $response = $this->get('/api/v1/auth/callback?' . $testData);

        $response->assertUnauthorized();
    }

    /** @test */
    public function application_is_rejected_by_linkedin()
    {
        $testData = http_build_query([
            'error' => 'user_cancelled_login',
            'error_description' => 'error',
            'state' => LinkedinOAuth::STATE
        ]);

        $response = $this->get('/api/v1/auth/callback?' . $testData);

        $response->assertStatus(400);
    }
}
