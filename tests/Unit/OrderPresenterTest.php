<?php

namespace Tests\Unit;

use App\Enums\OrderShipStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Support\OrderPresenter;
use Tests\TestCase;

class OrderPresenterTest extends TestCase
{
    public function test_it_handles_database_string_status_values(): void
    {
        $order = new Order();
        $order->status = (string) OrderStatusEnum::PAID;
        $order->ship_status = (string) OrderShipStatusEnum::DELIVERED;

        $this->assertSame('待收货', OrderPresenter::status($order));
        $this->assertSame('confirm', OrderPresenter::actions($order)[0]['type']);
    }
}
