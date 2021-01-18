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

class CustomersForm extends Form
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
         * Name text field
         */
        $name = new Text('name');
        $name->setLabel('Name');
        $name->setFilters($commonFilters);
        $name->addValidators([
            new PresenceOf(['message' => 'Name is required']),
        ]);

        $this->add($name);

        /**
         * password text field
         */
        $password = new Text('password');
        $password->setLabel('Password');
        $password->setFilters($commonFilters);
        $password->addValidators([
            new PresenceOf(['message' => 'Password is required']),
        ]);

        $this->add($password);

        /**
         * Address text field
         */
        $address = new Text('address');
        $address->setLabel('address');
        $address->setFilters($commonFilters);
        $address->addValidators([
            new PresenceOf(['message' => 'Address is required']),
        ]);

        $this->add($address);

        /**
         * username text field
         */
        $username = new Text('username');
        $username->setLabel('username');
        $username->setFilters($commonFilters);
        $username->addValidators([
            new PresenceOf(['message' => 'Username is required']),
        ]);

        $this->add($username);

         /**
         * balance text field
         */
        $balance = new Text('balance');
        $balance->setLabel('balance');
        $balance->setFilters($commonFilters);
        $balance->addValidators([
            new PresenceOf(['message' => 'Balance is required']),
        ]);

        $this->add($balance);
    }
}
