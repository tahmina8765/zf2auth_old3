<?php

namespace Zf2auth;
use Zf2auth\Entity\Resources;
use Zf2auth\Table\ResourcesTable;
use Zf2auth\Entity\RoleResources;
use Zf2auth\Table\RoleResourcesTable;
use Zf2auth\Entity\Roles;
use Zf2auth\Table\RolesTable;
use Zf2auth\Entity\UserRoles;
use Zf2auth\Table\UserRolesTable;
use Zf2auth\Entity\Users;
use Zf2auth\Table\UsersTable;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }


    public function getServiceConfig()
    {
        return array(
            'factories' => array('Zf2auth\Table\ResourcesTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ResourcesTable($dbAdapter);
                    return $table;
                },
                'Zf2auth\Table\RoleResourcesTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new RoleResourcesTable($dbAdapter);
                    return $table;
                },
                'Zf2auth\Table\RolesTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new RolesTable($dbAdapter);
                    return $table;
                },
                'Zf2auth\Table\UserRolesTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UserRolesTable($dbAdapter);
                    return $table;
                },
                'Zf2auth\Table\UsersTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UsersTable($dbAdapter);
                    return $table;
                },
                
            ),
        );
    }

}
