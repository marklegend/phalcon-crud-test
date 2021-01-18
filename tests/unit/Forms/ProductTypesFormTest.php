<?php
declare(strict_types=1);

namespace Invo\Tests\Unit\Forms;

use Codeception\Test\Unit;
use Invo\Forms\PaymentTypesForm;
use Phalcon\Forms\Form;

final class PaymentTypesFormTest extends Unit
{
    public function testImplementation(): void
    {
        $class = $this->createMock(PaymentTypesForm::class);

        $this->assertInstanceOf(Form::class, $class);
    }
}
