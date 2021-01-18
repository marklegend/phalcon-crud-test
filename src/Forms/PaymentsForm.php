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

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;

class PaymentsForm extends Form
{
    /**
     * Initialize the customers form
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

        /**
         * Customer id text field
         */
        $cust_id = new Text('cust_id');
        $cust_id->setLabel('Customer ID');
        $cust_id->setFilters($commonFilters);
        $cust_id->addValidators([
            new PresenceOf(['message' => 'Customer ID is required']),
        ]);

        $this->add($cust_id);

        /**
         * date created text field
         */
       

        $date_created = new Text('date_created');
        $date_created->setLabel('Date created');
        $date_created->setFilters($commonFilters);
        $date_created->addValidators([
            new PresenceOf(['message' => 'please enter date is required']),
        ]);

        $this->add($date_created);


         /**
         * amount text field
         */
        $amount = new Text('amount');
        $amount->setLabel('Amount');
        $amount->setFilters($commonFilters);
        $amount->addValidators([
            new PresenceOf(['message' => 'Amount is required']),
        ]);

        $this->add($amount);
    }
}
