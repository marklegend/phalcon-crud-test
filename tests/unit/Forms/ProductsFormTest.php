<?php
declare(strict_types=1);

namespace Invo\Tests\Unit\Forms;

use Codeception\Test\Unit;
use Invo\Forms\PaymentsForm;
use Phalcon\Forms\Form;

final class PaymentsFormTest extends Unit
{
    public function testImplementation(): void
    {
        $class = $this->createMock(PaymentsForm::class);

        $this->assertInstanceOf(Form::class, $class);
    }
}
