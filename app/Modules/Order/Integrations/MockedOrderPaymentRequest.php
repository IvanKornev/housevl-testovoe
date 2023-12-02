<?php

declare(strict_types=1);

namespace App\Modules\Order\Integrations;

use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;

use App\Modules\Order\Integrations\Contracts\IOrderPaymentRequest;
use App\Modules\Order\DTO\CreateOrderDTO;

final class MockedOrderPaymentRequest implements IOrderPaymentRequest
{
    private FakerGenerator $faker;

    public function __construct()
    {
        $this->faker = FakerFactory::create();
    }

    public function query(CreateOrderDTO $data): string
    {
        $paymentUrl = $this->faker->url();
        return $paymentUrl;
    }
}
