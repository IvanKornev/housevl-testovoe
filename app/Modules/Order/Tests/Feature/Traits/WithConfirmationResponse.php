<?php

declare(strict_types=1);

namespace App\Modules\Order\Tests\Feature\Traits;

use Illuminate\Testing\TestResponse;
use App\Modules\Order\Entities\Order;

trait WithConfirmationResponse
{
    private function checkCreatedOrderResponse(TestResponse $response): void
    {
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $validPaymentUrl = filter_var($content['paymentUrl'], FILTER_VALIDATE_URL);
        $this->assertIsString($validPaymentUrl);
        $this->assertCount(0, $content['meta']['cart']['items']);
        $createdOrder = Order::where('payment_url', $validPaymentUrl)->first();
        $this->assertIsObject($createdOrder);
    }
}
