<?php
declare(strict_types=1);

namespace Invo\Tests\Unit\Controllers;

use Codeception\Test\Unit;
use Invo\Controllers\PaymenttypesController;
use Phalcon\Mvc\Controller;

final class PaymentTypesControllerTest extends Unit
{
    public function testImplementation(): void
    {
        $class = $this->createMock(PaymenttypesController::class);

        $this->assertInstanceOf(Controller::class, $class);
    }
}
