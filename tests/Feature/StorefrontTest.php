<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_is_available(): void
    {
        $this->get('/')->assertOk()->assertSee('Monday Shop');
    }

    public function test_user_can_be_persisted(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', ['email' => $user->email]);
    }
}
