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

    public function query(CreateOrderDTO $data): array
    {
        $results = [
            'payment_id' => 'id-' . $this->faker->word(),
            'sum' => $this->faker->randomFloat(2, 100),
            'payment_url' => $this->faker->url(),
            'status' => 'pending',
            'currency' => 'RUB',
        ];
        return $results;
    }
}
