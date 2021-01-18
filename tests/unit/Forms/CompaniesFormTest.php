<?php
declare(strict_types=1);

namespace Invo\Tests\Unit\Forms;

use Codeception\Test\Unit;
use Invo\Forms\CustomersForm;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

final class CompaniesFormTest extends Unit
{
    public function testImplementation(): void
    {
        $class = $this->createMock(CustomersForm::class);

        $this->assertInstanceOf(Form::class, $class);
    }

    public function testIdElementType(): void
    {
        $createForm = new CustomersForm();
        $editForm = new CustomersForm(null, ['edit' => true]);

        $this->assertInstanceOf(Text::class, $createForm->getElements()['id']);
        $this->assertInstanceOf(Hidden::class, $editForm->getElements()['id']);
    }
}
