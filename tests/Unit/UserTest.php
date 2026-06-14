<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_name_is_masked_for_public_display(): void
    {
        $user = new User(['name' => 'Monday']);

        $this->assertSame('M*****', $user->hidden_name);
    }
}
