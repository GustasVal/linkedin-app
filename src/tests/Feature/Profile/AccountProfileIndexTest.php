<?php

namespace Tests\Feature\Profile;

use App\Http\Controllers\V1\AuthController;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AccountProfileIndexTest extends TestCase
{
    /** @test */
    public function login_with_linkedin()
    {
        $response = $this->get('/api/v1/login');

        $response->assertStatus(302);
    }
}
