<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }



    public function testDatabase()
    {
        // 创建调用至应用程序...

        $this->assertDatabaseHas('users', [
            'email' => '1033404553@qq.com'
        ]);
    }
}
