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

use Invo\Forms\CustomersForm;
use Invo\Models\Customers;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CustomersController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->tag->setTitle('Manage your customers');
    }

    /**
     * Shows the index action
     */
    public function indexAction(): void
    {
        $this->view->form = new CustomersForm();
    }

    /**
     * Search customers based on current criteria
     */
    public function searchAction(): void
    {
        if ($this->request->isPost()) {
            $query = Criteria::fromInput(
                $this->di,
                Customers::class,
                $this->request->getPost()
            );

            $this->persistent->searchParams = $query->getParams();
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $customers = Customers::find($parameters);
        if (count($customers) == 0) {
            $this->flash->notice('The search did not find any customers');

            $this->dispatcher->forward([
                'controller' => 'customers',
                'action'     => 'index',
            ]);

            return;
        }

        $paginator = new Paginator([
            'data'  => $customers,
            'limit' => 10,
            'page'  => $this->request->getQuery('page', 'int', 1),
        ]);

        $this->view->page = $paginator->paginate();
        $this->view->customers = $customers;
    }

    /**
     * Shows the form to create a new customer
     */
    public function newAction(): void
    {
        $this->view->form = new CustomersForm(null, ['edit' => true]);
    }

    /**
     * Edits a customer based on its id
     *
     * @param int $id
     */
    public function editAction($id): void
    {
        $customer = Customers::findFirstById($id);
        if (!$customer) {
            $this->flash->error('Customer was not found');

            $this->dispatcher->forward([
                'controller' => 'customers',
                'action'     => 'index',
            ]);

            return;
        }

        $this->view->form = new CustomersForm($customer, ['edit' => true]);
    }

    /**
     * Creates a new customer
     */
    public function createAction(): void
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => 'customers',
                'action'     => 'index',
            ]);

            return;
        }

        $form = new CustomersForm();
        $customer = new Customers();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $customer)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error((string)$message);
            }

            $this->dispatcher->forward([
                'controller' => 'customers',
                'action'     => 'new',
            ]);

            return;
        }

        if (!$customer->save()) {
            foreach ($customer->getMessages() as $message) {
                $this->flash->error((string)$message);
            }

            $this->dispatcher->forward([
                'controller' => 'customers',
                'action'     => 'new',
            ]);

            return;
        }

        $form->clear();
        $this->flash->success('Customer was created successfully');

        $this->dispatcher->forward([
            'controller' => 'customers',
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
                'controller' => 'customers',
                'action'     => 'index',
            ]);

            return;
        }

        $id = $this->request->getPost('id', 'int');
        $customer = Customers::findFirstById($id);
        if (!$customer) {
            $this->flash->error('Customer does not exist');

            $this->dispatcher->forward([
                'controller' => 'customers',
                'action'     => 'index',
            ]);

            return;
        }

        $data = $this->request->getPost();
        $form = new CustomersForm();
        if (!$form->isValid($data, $customer)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error((string)$message);
            }

            $this->dispatcher->forward([
                'controller' => 'customers',
                'action'     => 'new',
            ]);

            return;
        }

        if (!$customer->save()) {
            foreach ($customer->getMessages() as $message) {
                $this->flash->error((string)$message);
            }

            $this->dispatcher->forward([
                'controller' => 'customers',
                'action'     => 'new',
            ]);

            return;
        }

        $form->clear();
        $this->flash->success('Customer was updated successfully');

        $this->dispatcher->forward([
            'controller' => 'customers',
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
        $customers = Customers::findFirstById($id);
        if (!$customers) {
            $this->flash->error('Customer was not found');

            $this->dispatcher->forward([
                'controller' => 'customers',
                'action'     => 'index',
            ]);

            return;
        }

        if (!$customers->delete()) {
            foreach ($customers->getMessages() as $message) {
                $this->flash->error((string)$message);
            }

            $this->dispatcher->forward([
                'controller' => 'customers',
                'action'     => 'search',
            ]);

            return;
        }

        $this->flash->success('Customer was deleted');

        $this->dispatcher->forward([
            'controller' => 'customers',
            'action'     => 'index',
        ]);
    }
}
