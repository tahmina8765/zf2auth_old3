<?php

namespace Zf2auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zf2auth\Entity\Resources;
use Zf2auth\Form\ResourcesForm;
use Zf2auth\Form\ResourcesSearchForm;
use Zend\Db\Sql\Select;

class ResourcesController extends Zf2authAppController {

    public $vm;

    function __construct() {
        parent::__construct();
        $this->vm = new viewModel();

    }

    /**
     * Search Action
     * Receive the POST value from 'Search Form' and returns the GET params to the index action.
     * So when index get the search params, it will always receive as GET and same format either comes from the search form or the pagination link.
     * Author: Tahmina Khatoon
     */
    public function searchAction() {
        
        $request = $this->getRequest();

        $url = 'index';

        if ($request->isPost()) {
            $formdata    = (array) $request->getPost();
            $search_data = array ();
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
        $searchform = new ResourcesSearchForm();
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
        $formdata = array ();
        if (!empty($search_by)) {
            $formdata = (array) json_decode($search_by);
            if (!empty($formdata['name'])) {
                $where->addPredicate(
                        new \Zend\Db\Sql\Predicate\Like('name', '%' . $formdata['name'] . '%')
                );
            }
        }
        if (!empty($where)) {
            $select->where($where);
        }

        $paginator = $this->getResourcesTable()->fetchAll($select, true);
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
            'pageAction'    => 'resources/index',
            'form'          => $searchform,
            'totalRecord'   => $totalRecord,
            'currentPage'   => $currentPage,
            'totalPage'     => $totalPage
        ));
        return $this->vm;

    }

    /**
     * add Action
     * Insert row in 'resources'
     * @return type
     * Author: Tahmina Khatoon
     */
    public function addAction() {
        $form = new ResourcesForm();


        $request = $this->getRequest();
        if ($request->isPost()) {
            $resources = new Resources();
            $form->setInputFilter($resources->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $resources->exchangeArray($form->getData());
                $confirm  = $this->getResourcesTable()->saveResources($resources);
                $redirect = false;
                if (!empty($confirm['status'])) {
                    switch ($confirm['status']) {
                        case '1':
                            $redirect = true;
                            $this->flashMessenger()->addMessage(array ('success' => $this->message->success));
                            break;
                        default:
                            $this->flashMessenger()->addMessage(array ('error' => $this->message->error));
                            break;
                    }
                }

                if ($redirect) {
                    // Redirect to list of resourcess
                    return $this->redirect()->toRoute('resources');
                }
            }
        }
        $this->vm->setVariables(array (
            'flashMessages' => $this->flashMessenger()->getMessages(),
            'form'          => $form
        ));

        return $this->vm;

    }

    /**
     * Edit Action
     * Edit row in 'resources'
     * @return type
     * Author: Tahmina Khatoon
     */
    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('resources', array (
                        'action' => 'add'
            ));
        }
        $resources = $this->getResourcesTable()->getResources($id);

        $form = new ResourcesForm();
        $form->bind($resources);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($resources->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $confirm = $this->getResourcesTable()->saveResources($form->getData());

                $redirect = false;
                if (!empty($confirm['status'])) {
                    switch ($confirm['status']) {
                        case '1':
                            $redirect = true;
                            $this->flashMessenger()->addMessage(array ('success' => $this->message->success));
                            break;
                        default:
                            $this->flashMessenger()->addMessage(array ('error' => $this->message->error));
                            break;
                    }
                }

                if ($redirect) {
                    // Redirect to list of resourcess
                    return $this->redirect()->toRoute('resources');
                }
            }
        }
        $this->vm->setVariables(array (
            'flashMessages' => $this->flashMessenger()->getMessages(),
            'id'            => $id,
            'form'          => $form,
        ));

        return $this->vm;

    }

    /**
     * Delete Action
     * Delete row from 'resources'
     * @return type
     * Author: Tahmina Khatoon
     */
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('resources');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {

            $id      = (int) $request->getPost('id');
            $confirm = $this->getResourcesTable()->deleteResources($id);


            if (!empty($confirm['status'])) {
                switch ($confirm['status']) {
                    case '1':
                        $this->flashMessenger()->addMessage(array ('success' => $this->message->success));
                        break;
                    default:
                        $this->flashMessenger()->addMessage(array ('error' => $this->message->error));
                        break;
                }
            }

            // Redirect to list of resourcess
            return $this->redirect()->toRoute('resources');
        }
        $this->vm->setVariables(array (
            'flashMessages' => $this->flashMessenger()->getMessages(),
            'id'            => $id,
            'resources'     => $this->getResourcesTable()->getResources($id)
        ));

        return $this->vm;

    }

    /**
     * Get RouterConfig
     * @return type
     * Author: Tahmina Khatoon
     */
    public function getRouterConfig() {
        if (!$this->routerConfig) {
            $sm                 = $this->getServiceLocator();
            $this->routerConfig = $sm->get('RouterConfig');
        }
        return $this->routerConfig;

    }

    /**
     * Refresh database 'resources' table
     * @return type
     * Author: Tahmina Khatoon
     */
    public function refreshResourcesAction() {

        $form              = new ResourcesForm();
        $newly_added       = array ();
        $delete_from_exist = array ();
//      Read All link from Module.comfig
        $routerConfig      = $this->getRouterConfig();
        $allNode           = array ();
        foreach ($routerConfig['routes'] as $node => $data) {
            $allNode[] = $node;
            if (!empty($data['child_routes'])) {
                foreach ($data['child_routes'] as $childnode => $childdata) {
                    $allNode[] = $node . '/' . $childnode;
                }
            }
        }
//      Read All link from Database
        $db_resources = $this->getResourcesTable()->fetchAll();
        $existNode    = array ();
//      Compare and add new
        foreach ($allNode as $node) {
            $exist = false;
            foreach ($db_resources as $data) {
//                echo "<pre>";
//                print_r($data);
//                echo "</pre>";
//                die();
                $link_db                   = $data->name;
                $existNode[$data->id] = $link_db;
                if ($link_db == $node) {
                    $exist = true;
                }
            }
            if (!$exist) {

                $resources = new Resources();
                $form->setInputFilter($resources->getInputFilter());
                $formdata  = array (
                    'id'   => 0,
                    'name' => $node,
                );
                $form->setData($formdata);

                if ($form->isValid()) {
                    $resources->exchangeArray($form->getData());
                    $confirm = $this->getResourcesTable()->saveResources($resources);
                    if ($confirm) {
                        $newly_added[] = $node;
                    }
                } else {
                    print_r($form->getMessages());
                    echo "Validation fail. ";
                    echo $node . "<br>";
                }
            }
        }


//      Compare and delete old
        foreach ($db_resources as $data) {
            $exist   = true;
            $link_db = $data->name;
            if (!in_array($link_db, $allNode)) {
                $id      = (int) $data->id;
                $confirm = $this->getResourcesTable()->deleteResources($id);
                if ($confirm) {
                    $delete_from_exist[] = "[" . $id . "]" . $link_db;
                }
            }
        }

//      Read All link from Database (After Refresh)
        $db_resources = $this->getResourcesTable()->fetchAll();
        $this->vm->setVariables(array (
            'resources'         => $db_resources,
            'allNode'           => $allNode,
            'newly_added'       => $newly_added,
            'delete_from_exist' => $delete_from_exist
        ));
        return $this->vm;

    }

}
