<?php
declare(strict_types=1);

/**
 * This file is part of the Invo.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Invo\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;

class PaymentTypesForm extends Form
{
    /**
     * Initialize the payments form
     *
     * @param null $entity
     * @param array $options
     */
    public function initialize($entity = null, array $options = [])
    {
        if (!isset($options['edit'])) {
            $this->add((new Text('id'))->setLabel('Id'));
        } else {
            $this->add(new Hidden('id'));
        }

        $commonFilters = [
            'striptags',
            'string',
        ];


        $description = new Text('description');
        $description->setLabel('Description');
        $description->setFilters(['striptags', 'string']);
        $description->addValidators([
            new PresenceOf(['message' => 'description is required']),
        ]);

        $this->add($description);

        $date_created = new Text('date_created');
        $date_created->setLabel('Date created');
        $date_created->setFilters(['striptags', 'string']);
        $date_created->addValidators([
            new PresenceOf(['message' => 'date is required']),
        ]);

        $this->add($date_created);

        $amount = new Text('amount');
        $amount->setLabel('Amount');
        $amount->setFilters(['striptags', 'string']);
        $amount->addValidators([
            new PresenceOf(['message' => 'Amount is required']),
        ]);

        $this->add($amount);
    }
}
