<?php

namespace Tests\Unit;

use App\Models\ServiceMatch;
use PHPUnit\Framework\TestCase;

class ServiceMatchModelTest extends TestCase
{
    public function test_service_match_model_can_be_instantiated(): void
    {
        $model = new ServiceMatch();

        $this->assertInstanceOf(ServiceMatch::class, $model);
    }
}
