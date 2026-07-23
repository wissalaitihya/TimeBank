<?php

namespace Tests\Unit;

use App\Models\Dispute;
use App\Models\Review;
use App\Models\ServiceRequest;
use App\Models\Transaction;
use PHPUnit\Framework\TestCase;

class ModelRelationClassesTest extends TestCase
{
    public function test_relation_models_can_be_instantiated(): void
    {
        $this->assertInstanceOf(ServiceRequest::class, new ServiceRequest());
        $this->assertInstanceOf(Transaction::class, new Transaction());
        $this->assertInstanceOf(Review::class, new Review());
        $this->assertInstanceOf(Dispute::class, new Dispute());
    }
}
