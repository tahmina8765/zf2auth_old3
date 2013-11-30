<?php

namespace Zf2auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

class Zf2authAppController extends AbstractActionController {

    protected $resourcesTable;
    protected $role_resourcesTable;
    protected $rolesTable;
    protected $user_rolesTable;
    protected $usersTable;
    public $message;

    public function __construct() {
        $this->message = new \Zend\Config\Config(include __DIR__.'../../../../config/message.config.php');
//        parent::__construct();

    }

    protected function getResourcesTable() {
        if (!$this->resourcesTable) {
            $sm                   = $this->getServiceLocator();
            $this->resourcesTable = $sm->get('Zf2auth\Table\ResourcesTable');
        }
        return $this->resourcesTable;

    }

    protected function getRoleResourcesTable() {
        if (!$this->role_resourcesTable) {
            $sm                        = $this->getServiceLocator();
            $this->role_resourcesTable = $sm->get('Zf2auth\Table\RoleResourcesTable');
        }
        return $this->role_resourcesTable;

    }

    protected function getRolesTable() {
        if (!$this->rolesTable) {
            $sm               = $this->getServiceLocator();
            $this->rolesTable = $sm->get('Zf2auth\Table\RolesTable');
        }
        return $this->rolesTable;

    }

    protected function getUserRolesTable() {
        if (!$this->user_rolesTable) {
            $sm                    = $this->getServiceLocator();
            $this->user_rolesTable = $sm->get('Zf2auth\Table\UserRolesTable');
        }
        return $this->user_rolesTable;

    }

    protected function getUsersTable() {
        if (!$this->usersTable) {
            $sm               = $this->getServiceLocator();
            $this->usersTable = $sm->get('Zf2auth\Table\UsersTable');
        }
        return $this->usersTable;

    }

}
