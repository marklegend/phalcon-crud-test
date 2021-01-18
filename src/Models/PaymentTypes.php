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

namespace Invo\Models;

use Phalcon\Mvc\Model;

/**
 * Types of Payments
 */
class PaymentTypes extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $invoice_id;

     /**
     * @var string
     */
    public $description;

     /**
     * @var string
     */
    public $date_created;

    /**
     * @var string
     */
    public $amount;

    /**
     * PaymentTypes initializer
     */
    public function initialize()
    {
        $this->hasMany(
            'id',
            Payments::class,
            'payment_types_id',
            [
                'foreignKey' => [
                    'message' => 'Payment Type cannot be deleted because it\'s used in Payments'
                ],
            ]
        );
    }
}
