<?php
declare(strict_types=1);

namespace Invo\Tests\Unit\Models;

use Codeception\Test\Unit;
use Invo\Models\PaymentTypes;
use Phalcon\Mvc\Model;

final class PaymentTypesTest extends Unit
{
    public function testImplementation(): void
    {
        $class = $this->createMock(PaymentTypes::class);

        $this->assertInstanceOf(Model::class, $class);
    }
}
