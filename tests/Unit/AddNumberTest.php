<?php

namespace Tests\Unit;

use App\DummyServices\AddNumber;
use Tests\TestCase;

class AddNumberTest extends TestCase
{
    public function testAdd() {
        $repository = $this->app->make(AddNumber::class);

        $testA = 1;
        $testB = 2;

        $result = $repository->add($testA, $testB);

        $this->assertSame(3, $result, 'Add number failed.');
    }
}
