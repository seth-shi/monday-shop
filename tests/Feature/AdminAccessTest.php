<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_page_is_available(): void
    {
        $this->get('/admin/login')->assertOk()->assertSee('管理后台');
    }

    public function test_admin_dashboard_requires_authentication(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }
}
