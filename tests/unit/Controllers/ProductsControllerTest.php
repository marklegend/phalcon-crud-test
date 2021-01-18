<?php
declare(strict_types=1);

namespace Invo\Tests\Unit\Controllers;

use Codeception\Test\Unit;
use Invo\Controllers\PaymentsController;
use Phalcon\Mvc\Controller;

final class PaymentsControllerTest extends Unit
{
    public function testImplementation(): void
    {
        $class = $this->createMock(PaymentsController::class);

        $this->assertInstanceOf(Controller::class, $class);
    }
}
