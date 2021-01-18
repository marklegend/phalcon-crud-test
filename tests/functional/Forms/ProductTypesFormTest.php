<?php
declare(strict_types=1);

namespace Invo\Tests\Functional\Forms;

use Codeception\Test\Unit;
use Invo\Forms\PaymentTypesForm;
use Phalcon\Di;
use Phalcon\Filter;

final class PaymentTypesFormTest extends Unit
{
    public function setUp(): void
    {
        Di::reset();
    }

    public function inputDataProvider(): array
    {
        $key = 'name';

        return [
            [[$key => 'string'], true],
            [[$key => '<h1>Title</h1>'], true],
            [[$key => 1], true],
            [[], false],
        ];
    }

    /**
     * @dataProvider inputDataProvider
     *
     * @param array $data
     * @param bool  $expected
     */
    public function testValidation(array $data, bool $expected): void
    {
        $di = new Di();
        $di['filter'] = function () {
            return new Filter();
        };

        $form = new PaymentTypesForm();
        $form->setDI($di);

        $this->assertSame($expected, $form->isValid($data));
    }
}
