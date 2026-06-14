<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class PriceHelperTest extends TestCase
{
    public function test_price_is_rounded_to_two_decimal_places(): void
    {
        $this->assertSame(12.35, ceilTwoPrice(12.345));
    }
}
