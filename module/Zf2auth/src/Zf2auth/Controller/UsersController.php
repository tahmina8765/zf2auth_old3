<?php

namespace Zf2auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zf2auth\Entity\Users;
use Zf2auth\Form\UsersForm;
use Zf2auth\Form\UsersSearchForm;


use Zend\Db\Sql\Select;


class UsersController extends Zf2authAppController
{
    public $vm;

    function __construct()
    {
        parent::__construct();
        $this->vm = new viewModel();

    }

    /**
     * Search Action
     * Receive the POST value from 'Search Form' and returns the GET params to the index action.
     * So when index get the search params, it will always receive as GET and same format either comes from the search form or the pagination link.
     * Author: Tahmina Khatoon
     */

    public function searchAction()
    {
        $this->layout('layout/ajax');
        $request = $this->getRequest();

        $url = 'index';

        if ($request->isPost()) {
            $formdata    = (array) $request->getPost();
            $search_data = array();
            foreach ($formdata as $key => $value) {
                if ($key != 'submit') {
                    if (!empty($value)) {
                        $search_data[$key] = $value;
                    }
                }
            }
            if (!empty($search_data)) {
                $search_by = json_encode($search_data);
                $url .= '/search_by/' . $search_by;
            }
        }
        $this->redirect()->toUrl($url);
    }


    /**
     * index Action
     * Receive the search params
     * Build the search query
     * Generate the search result as a list
     * @return type
     * Author: Tahmina Khatoon
     */

    public function indexAction() {
        $searchform = new UsersSearchForm();
        $searchform->get('submit')->setValue('Search');

        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'id';
        $order    = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_DESCENDING;

        $page          = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
        $item_per_page = $this->params()->fromRoute('item_per_page') ? (int) $this->params()->fromRoute('item_per_page') : 10;
        $page_range    = $this->params()->fromRoute('page_range') ? (int) $this->params()->fromRoute('page_range') : 7;

        $select->order($order_by . ' ' . $order);
        $search_by = $this->params()->fromRoute('search_by') ?
                $this->params()->fromRoute('search_by') : '';


        $where    = new \Zend\Db\Sql\Where();
        $formdata = array();
        if (!empty($search_by)) {
            $formdata = (array) json_decode($search_by);
            if (!empty($formdata['username'])) {
                $where->addPredicate(
                        new \Zend\Db\Sql\Predicate\Like('username', '%' . $formdata['username'] . '%')
                );
            }
            if (!empty($formdata['email'])) {
                $where->addPredicate(
                        new \Zend\Db\Sql\Predicate\Like('email', '%' . $formdata['email'] . '%')
                );
            }
            if (!empty($formdata['password'])) {
                $where->addPredicate(
                        new \Zend\Db\Sql\Predicate\Like('password', '%' . $formdata['password'] . '%')
                );
            }
            if (!empty($formdata['salt'])) {
                $where->addPredicate(
                        new \Zend\Db\Sql\Predicate\Like('salt', '%' . $formdata['salt'] . '%')
                );
            }
            if (!empty($formdata['email_check_code'])) {
                $where->addPredicate(
                        new \Zend\Db\Sql\Predicate\Like('email_check_code', '%' . $formdata['email_check_code'] . '%')
                );
            }
            if (!empty($formdata['is_disabled'])) {
                $where->addPredicate(
                        new \Zend\Db\Sql\Predicate\Like('is_disabled', '%' . $formdata['is_disabled'] . '%')
                );
            }
            if (!empty($formdata['created'])) {
                $where->addPredicate(
                        new \Zend\Db\Sql\Predicate\Like('created', '%' . $formdata['created'] . '%')
                );
            }
            if (!empty($formdata['modified'])) {
                $where->addPredicate(
                        new \Zend\Db\Sql\Predicate\Like('modified', '%' . $formdata['modified'] . '%')
                );
            }
            
        }
        if (!empty($where)) {
            $select->where($where);
        }

        $paginator = $this->getUsersTable()->fetchAll($select, true);
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($item_per_page)
                ->setPageRange($page_range);

        $totalRecord = $paginator->getTotalItemCount();
        $currentPage = $paginator->getCurrentPageNumber();
        $totalPage   = $paginator->count();

        $searchform->setData($formdata);
        $this->vm->setVariables(array (
            'flashMessages' => $this->flashMessenger()->getMessages(),
            'search_by'     => $search_by,
            'order_by'      => $order_by,
            'order'         => $order,
            'page'          => $page,
            'item_per_page' => $item_per_page,
            'paginator'     => $paginator,
            'pageAction' => 'users/index',
            'form'          => $searchform,
            'totalRecord'   => $totalRecord,
            'currentPage'   => $currentPage,
            'totalPage'     => $totalPage
        ));
        return $this->vm;
    }


    /**
     * add Action
     * Insert row in 'users'
     * @return type
     * Author: Tahmina Khatoon
     */

    public function addAction()
    {
        $form = new UsersForm();


        $request = $this->getRequest();
        if ($request->isPost()) {
            $users = new Users();
            $form->setInputFilter($users->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $users->exchangeArray($form->getData());
                $confirm = $this->getUsersTable()->saveUsers($users);
                $redirect = false;
                if(!empty($confirm['status'])){
                    switch($confirm['status']){
                    case '1':
                    $redirect = true;
                    $this->flashMessenger()->addMessage(array('success' => $this->message->success));
                    break;
                    default:
                    $this->flashMessenger()->addMessage(array('error' => $this->message->error));
                    break;
                    }
                }

                if($redirect){
                // Redirect to list of userss
                return $this->redirect()->toRoute('users');
                }
            }
        }
        $this->vm->setVariables(array(
            'flashMessages'   => $this->flashMessenger()->getMessages(),
            'form' => $form
        ));

        return $this->vm;
    }

    /**
     * Edit Action
     * Edit row in 'users'
     * @return type
     * Author: Tahmina Khatoon
     */
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('users', array(
                        'action' => 'add'
                    ));
        }
        $users = $this->getUsersTable()->getUsers($id);

        $form = new UsersForm();
        $form->bind($users);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($users->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $confirm = $this->getUsersTable()->saveUsers($form->getData());

                $redirect = false;
                if(!empty($confirm['status'])){
                    switch($confirm['status']){
                    case '1':
                    $redirect = true;
                    $this->flashMessenger()->addMessage(array('success' => $this->message->success));
                    break;
                    default:
                    $this->flashMessenger()->addMessage(array('error' => $this->message->error));
                    break;
                    }
                }

                if($redirect){
                // Redirect to list of userss
                return $this->redirect()->toRoute('users');
                }
            }
        }
        $this->vm->setVariables(array(
            'flashMessages'   => $this->flashMessenger()->getMessages(),
            'id'   => $id,
            'form' => $form,
        ));

        return $this->vm;
    }

    /**
     * Delete Action
     * Delete row from 'users'
     * @return type
     * Author: Tahmina Khatoon
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('users');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {

                $id = (int) $request->getPost('id');
                $confirm = $this->getUsersTable()->deleteUsers($id);


                if(!empty($confirm['status'])){
                    switch($confirm['status']){
                    case '1':
                    $this->flashMessenger()->addMessage(array('success' => $this->message->success));
                    break;
                    default:
                    $this->flashMessenger()->addMessage(array('error' => $this->message->error));
                    break;
                    }
                }

                // Redirect to list of userss
                return $this->redirect()->toRoute('users');


        }
        $this->vm->setVariables(array(
            'flashMessages'   => $this->flashMessenger()->getMessages(),
            'id'    => $id,
            'users' => $this->getUsersTable()->getUsers($id)
        ));

        return $this->vm;
    }

}
