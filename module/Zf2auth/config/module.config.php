<?php
namespace Zf2auth;

return array(
    'controllers' => array(
        'invokables' => array(
            
            'Zf2auth\Controller\Resources' => 'Zf2auth\Controller\ResourcesController',
            'Zf2auth\Controller\RoleResources' => 'Zf2auth\Controller\RoleResourcesController',
            'Zf2auth\Controller\Roles' => 'Zf2auth\Controller\RolesController',
            'Zf2auth\Controller\UserRoles' => 'Zf2auth\Controller\UserRolesController',
            'Zf2auth\Controller\Users' => 'Zf2auth\Controller\UsersController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'resources'          => array (
                'type'          => 'segment',
                'options'       => array (
                    'route'    => '/resources',
                    'defaults' => array(
                        'controller' => 'Zf2auth\Controller\Resources',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array (
                    'search'          => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'       => '/search[/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                            'constraints' => array (
                                'id'       => '[0-9]+',
                                'page'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order'    => 'ASC|DESC',
                            ),
                            'defaults'    => array (
                                'action' => 'search',
                            ),
                        ),
                    ),
                    'index'           => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'       => '/index[/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                            'constraints' => array (
                                'id'       => '[0-9]+',
                                'page'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order'    => 'ASC|DESC',
                            ),
                            'defaults'    => array (
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'add'             => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'    => '/add',
                            'defaults' => array (
                                'action' => 'add',
                            ),
                        ),
                    ),
                    'edit'            => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'    => '/edit[/:id]',
                            'defaults' => array (
                                'action' => 'edit',
                            ),
                        ),
                    ),
                    'delete'          => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'    => '/delete[/:id]',
                            'constraints' => array (
                                'id'       => '[0-9]+',
                                'page'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order'    => 'ASC|DESC',
                            ),
                            'defaults' => array (
                                'action' => 'delete',
                            ),
                        ),
                    ),
                ),
            ),
            'role_resources'          => array (
                'type'          => 'segment',
                'options'       => array (
                    'route'    => '/role-resources',
                    'defaults' => array(
                        'controller' => 'Zf2auth\Controller\RoleResources',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array (
                    'search'          => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'       => '/search[/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                            'constraints' => array (
                                'id'       => '[0-9]+',
                                'page'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order'    => 'ASC|DESC',
                            ),
                            'defaults'    => array (
                                'action' => 'search',
                            ),
                        ),
                    ),
                    'index'           => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'       => '/index[/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                            'constraints' => array (
                                'id'       => '[0-9]+',
                                'page'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order'    => 'ASC|DESC',
                            ),
                            'defaults'    => array (
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'add'             => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'    => '/add',
                            'defaults' => array (
                                'action' => 'add',
                            ),
                        ),
                    ),
                    'edit'            => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'    => '/edit[/:id]',
                            'defaults' => array (
                                'action' => 'edit',
                            ),
                        ),
                    ),
                    'delete'          => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'    => '/delete[/:id]',
                            'constraints' => array (
                                'id'       => '[0-9]+',
                                'page'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order'    => 'ASC|DESC',
                            ),
                            'defaults' => array (
                                'action' => 'delete',
                            ),
                        ),
                    ),
                ),
            ),
            'roles'          => array (
                'type'          => 'segment',
                'options'       => array (
                    'route'    => '/roles',
                    'defaults' => array(
                        'controller' => 'Zf2auth\Controller\Roles',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array (
                    'search'          => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'       => '/search[/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                            'constraints' => array (
                                'id'       => '[0-9]+',
                                'page'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order'    => 'ASC|DESC',
                            ),
                            'defaults'    => array (
                                'action' => 'search',
                            ),
                        ),
                    ),
                    'index'           => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'       => '/index[/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                            'constraints' => array (
                                'id'       => '[0-9]+',
                                'page'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order'    => 'ASC|DESC',
                            ),
                            'defaults'    => array (
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'add'             => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'    => '/add',
                            'defaults' => array (
                                'action' => 'add',
                            ),
                        ),
                    ),
                    'edit'            => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'    => '/edit[/:id]',
                            'defaults' => array (
                                'action' => 'edit',
                            ),
                        ),
                    ),
                    'delete'          => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'    => '/delete[/:id]',
                            'constraints' => array (
                                'id'       => '[0-9]+',
                                'page'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order'    => 'ASC|DESC',
                            ),
                            'defaults' => array (
                                'action' => 'delete',
                            ),
                        ),
                    ),
                ),
            ),
            'user_roles'          => array (
                'type'          => 'segment',
                'options'       => array (
                    'route'    => '/user-roles',
                    'defaults' => array(
                        'controller' => 'Zf2auth\Controller\UserRoles',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array (
                    'search'          => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'       => '/search[/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                            'constraints' => array (
                                'id'       => '[0-9]+',
                                'page'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order'    => 'ASC|DESC',
                            ),
                            'defaults'    => array (
                                'action' => 'search',
                            ),
                        ),
                    ),
                    'index'           => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'       => '/index[/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                            'constraints' => array (
                                'id'       => '[0-9]+',
                                'page'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order'    => 'ASC|DESC',
                            ),
                            'defaults'    => array (
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'add'             => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'    => '/add',
                            'defaults' => array (
                                'action' => 'add',
                            ),
                        ),
                    ),
                    'edit'            => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'    => '/edit[/:id]',
                            'defaults' => array (
                                'action' => 'edit',
                            ),
                        ),
                    ),
                    'delete'          => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'    => '/delete[/:id]',
                            'constraints' => array (
                                'id'       => '[0-9]+',
                                'page'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order'    => 'ASC|DESC',
                            ),
                            'defaults' => array (
                                'action' => 'delete',
                            ),
                        ),
                    ),
                ),
            ),
            'users'          => array (
                'type'          => 'segment',
                'options'       => array (
                    'route'    => '/users',
                    'defaults' => array(
                        'controller' => 'Zf2auth\Controller\Users',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array (
                    'search'          => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'       => '/search[/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                            'constraints' => array (
                                'id'       => '[0-9]+',
                                'page'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order'    => 'ASC|DESC',
                            ),
                            'defaults'    => array (
                                'action' => 'search',
                            ),
                        ),
                    ),
                    'index'           => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'       => '/index[/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                            'constraints' => array (
                                'id'       => '[0-9]+',
                                'page'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order'    => 'ASC|DESC',
                            ),
                            'defaults'    => array (
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'add'             => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'    => '/add',
                            'defaults' => array (
                                'action' => 'add',
                            ),
                        ),
                    ),
                    'edit'            => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'    => '/edit[/:id]',
                            'defaults' => array (
                                'action' => 'edit',
                            ),
                        ),
                    ),
                    'delete'          => array (
                        'type'    => 'segment',
                        'options' => array (
                            'route'    => '/delete[/:id]',
                            'constraints' => array (
                                'id'       => '[0-9]+',
                                'page'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order'    => 'ASC|DESC',
                            ),
                            'defaults' => array (
                                'action' => 'delete',
                            ),
                        ),
                    ),
                ),
            ),
            
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            
            'resources' => __DIR__ . '/../view',
            'role_resources' => __DIR__ . '/../view',
            'roles' => __DIR__ . '/../view',
            'user_roles' => __DIR__ . '/../view',
            'users' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'paginator-slide' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),
    ),

);
