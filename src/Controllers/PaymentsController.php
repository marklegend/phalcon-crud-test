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

use Invo\Forms\PaymentsForm;
use Invo\Models\Payments;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class PaymentsController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->tag->setTitle('Manage your payments');
    }

    /**
     * Shows the index action
     */
    public function indexAction(): void
    {
        $this->view->form = new PaymentsForm();
    }

    /**
     * Search payments based on current criteria
     */
    public function searchAction(): void
    {
        if ($this->request->isPost()) {
            $query = Criteria::fromInput(
                $this->di,
                Payments::class,
                $this->request->getPost()
            );

            $this->persistent->searchParams = $query->getParams();
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $payments = Payments::find($parameters);
        if (count($payments) == 0) {
            $this->flash->notice('The search did not find any payments');

            $this->dispatcher->forward([
                'controller' => 'payments',
                'action'     => 'index',
            ]);

            return;
        }

        $paginator = new Paginator([
            'data'  => $payments,
            'limit' => 10,
            'page'  => $this->request->getQuery('page', 'int', 1),
        ]);

        $this->view->page = $paginator->paginate();
        $this->view->payments = $payments;
    }

    /**
     * Shows the form to create a new customer
     */
    public function newAction(): void
    {
        $this->view->form = new PaymentsForm(null, ['edit' => true]);
    }

    /**
     * Edits a customer based on its id
     *
     * @param int $id
     */
    public function editAction($id): void
    {
        $customer = Payments::findFirstById($id);
        if (!$customer) {
            $this->flash->error('Payment was not found');

            $this->dispatcher->forward([
                'controller' => 'payments',
                'action'     => 'index',
            ]);

            return;
        }

        $this->view->form = new PaymentsForm($customer, ['edit' => true]);
    }

    /**
     * Creates a new customer
     */
    public function createAction(): void
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => 'payments',
                'action'     => 'index',
            ]);

            return;
        }

        $form = new PaymentsForm();
        $customer = new Payments();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $customer)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error((string)$message);
            }

            $this->dispatcher->forward([
                'controller' => 'payments',
                'action'     => 'new',
            ]);

            return;
        }

        if (!$customer->save()) {
            foreach ($customer->getMessages() as $message) {
                $this->flash->error((string)$message);
            }

            $this->dispatcher->forward([
                'controller' => 'payments',
                'action'     => 'new',
            ]);

            return;
        }

        $form->clear();
        $this->flash->success('Payment was created successfully');

        $this->dispatcher->forward([
            'controller' => 'payments',
            'action'     => 'index',
        ]);
    }

    /**
     * Saves current customer in screen
     */
    public function saveAction(): void
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => 'payments',
                'action'     => 'index',
            ]);

            return;
        }

        $id = $this->request->getPost('id', 'int');
        $customer = Payments::findFirstById($id);
        if (!$customer) {
            $this->flash->error('Payment does not exist');

            $this->dispatcher->forward([
                'controller' => 'payments',
                'action'     => 'index',
            ]);

            return;
        }

        $data = $this->request->getPost();
        $form = new PaymentsForm();
        if (!$form->isValid($data, $customer)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error((string)$message);
            }

            $this->dispatcher->forward([
                'controller' => 'payments',
                'action'     => 'new',
            ]);

            return;
        }

        if (!$customer->save()) {
            foreach ($customer->getMessages() as $message) {
                $this->flash->error((string)$message);
            }

            $this->dispatcher->forward([
                'controller' => 'payments',
                'action'     => 'new',
            ]);

            return;
        }

        $form->clear();
        $this->flash->success('Payment was updated successfully');

        $this->dispatcher->forward([
            'controller' => 'payments',
            'action'     => 'index',
        ]);
    }

    /**
     * Deletes a customer
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $payments = Payments::findFirstById($id);
        if (!$payments) {
            $this->flash->error('Payment was not found');

            $this->dispatcher->forward([
                'controller' => 'payments',
                'action'     => 'index',
            ]);

            return;
        }

        if (!$payments->delete()) {
            foreach ($payments->getMessages() as $message) {
                $this->flash->error((string)$message);
            }

            $this->dispatcher->forward([
                'controller' => 'payments',
                'action'     => 'search',
            ]);

            return;
        }

        $this->flash->success('Payment was deleted');

        $this->dispatcher->forward([
            'controller' => 'payments',
            'action'     => 'index',
        ]);
    }
}
