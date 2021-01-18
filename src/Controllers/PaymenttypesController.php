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

namespace Invo\Controllers;

use Invo\Forms\PaymentTypesForm;
use Invo\Models\PaymentTypes;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

/**
 * PaymentTypesController
 *
 * Manage operations for payment of types
 */
class PaymenttypesController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Manage your invoice line');

        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction(): void
    {
        $this->view->form = new PaymentTypesForm;
    }

    /**
     * Search paymenttype based on current criteria
     */
    public function searchAction(): void
    {
        if ($this->request->isPost()) {
            $query = Criteria::fromInput(
                $this->di,
                PaymentTypes::class,
                $this->request->getPost()
            );

            $this->persistent->searchParams = $query->getParams();
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $paymentTypes = PaymentTypes::find($parameters);
        if (count($paymentTypes) === 0) {
            $this->flash->notice('The search did not find any payment types');

            $this->dispatcher->forward([
                'controller' => 'paymenttypes',
                'action'     => 'index',
            ]);

            return;
        }

        $paginator = new Paginator([
            'data'  => $paymentTypes,
            'limit' => 10,
            'page'  => $this->request->getQuery('page', 'int', 1),
        ]);

        $this->view->page = $paginator->paginate();
        $this->view->paymentTypes = $paymentTypes;
    }

    /**
     * Shows the form to create a new paymenttype
     */
    public function newAction(): void
    {
        $this->view->form = new PaymentTypesForm(null, ['edit' => true]);
    }

    /**
     * Edits a paymenttype based on its id
     *
     * @param int $id
     */
    public function editAction($id): void
    {
        $paymentTypes = PaymentTypes::findFirstById($id);
        if (!$paymentTypes) {
            $this->flash->error('Payment type to edit was not found');

            $this->dispatcher->forward([
                'controller' => 'paymenttypes',
                'action'     => 'index',
            ]);

            return;
        }

        $this->view->form = new PaymentTypesForm($paymentTypes, ['edit' => true]);
    }

    /**
     * Creates a new paymenttype
     */
    public function createAction(): void
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => 'paymenttypes',
                'action'     => 'index',
            ]);

            return;
        }

        $form = new PaymentTypesForm();
        $paymentTypes = new PaymentTypes();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $paymentTypes)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error((string)$message);
            }

            $this->dispatcher->forward([
                'controller' => 'paymenttypes',
                'action'     => 'new',
            ]);

            return;
        }

        if (!$paymentTypes->save()) {
            foreach ($paymentTypes->getMessages() as $message) {
                $this->flash->error((string)$message);
            }

            $this->dispatcher->forward([
                'controller' => 'paymenttypes',
                'action'     => 'new',
            ]);

            return;
        }

        $form->clear();
        $this->flash->success('Payment type was created successfully');

        $this->dispatcher->forward([
            'controller' => 'paymenttypes',
            'action'     => 'index',
        ]);
    }

    /**
     * Saves current paymenttypes in screen
     */
    public function saveAction(): void
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => 'paymenttypes',
                'action'     => 'index',
            ]);

            return;
        }

        $id = $this->request->getPost('id', 'int');
        $paymentTypes = PaymentTypes::findFirstById($id);
        if (!$paymentTypes) {
            $this->flash->error('paymentTypes does not exist');

            $this->dispatcher->forward([
                'controller' => 'paymenttypes',
                'action'     => 'index',
            ]);

            return;
        }

        $form = new PaymentTypesForm();
        if (!$form->isValid($this->request->getPost(), $paymentTypes)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => 'paymenttypes',
                'action'     => 'new',
            ]);

            return;
        }

        if (!$paymentTypes->save()) {
            foreach ($paymentTypes->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => 'paymenttypes',
                'action'     => 'new',
            ]);

            return;
        }

        $form->clear();
        $this->flash->success('Payment Type was updated successfully');

        $this->dispatcher->forward([
            'controller' => 'paymenttypes',
            'action'     => 'index',
        ]);
    }

    /**
     * Deletes a paymenttypes
     *
     * @param int $id
     */
    public function deleteAction($id): void
    {
        $paymentTypes = PaymentTypes::findFirstById($id);
        if (!$paymentTypes) {
            $this->flash->error('Payment types was not found');

            $this->dispatcher->forward([
                'controller' => 'paymenttypes',
                'action'     => 'index',
            ]);

            return;
        }

        if (!$paymentTypes->delete()) {
            foreach ($paymentTypes->getMessages() as $message) {
                $this->flash->error((string)$message);
            }

            $this->dispatcher->forward([
                'controller' => 'paymenttypes',
                'action'     => 'search',
            ]);

            return;
        }

        $this->flash->success('Payment types was deleted');

        $this->dispatcher->forward([
            'controller' => 'paymenttypes',
            'action'     => 'index',
        ]);
    }
}
