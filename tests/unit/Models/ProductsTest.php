<?php
declare(strict_types=1);

namespace Invo\Tests\Unit\Models;

use Codeception\Test\Unit;
use Invo\Models\Payments;
use Phalcon\Mvc\Model;

final class PaymentsTest extends Unit
{
    public function testImplementation(): void
    {
        $class = $this->createMock(Payments::class);

        $this->assertInstanceOf(Model::class, $class);
    }
}
