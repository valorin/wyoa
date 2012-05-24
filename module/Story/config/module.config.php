<?php
return array(
    'service_manager' => array(
        'aliases' => array(
            'DbAdapter' => 'Zend\Db\Adapter\Adapter',
        ),
    ),
    'controller' => array(
        'classes' => array(
            'page'   => 'Story\Controller\PageController',
            'choice' => 'Story\Controller\ChoiceController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'helper_map' => array(
            'special' => 'Story\View\Helper\Special',
            'page'    => 'Story\View\Helper\Page',
            'chance'  => 'Story\View\Helper\Chance',
            'history' => 'Story\View\Helper\History',
        ),
    ),
    'router' => array(
        'routes' => array(
            'page' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/page/[:id[/:choice]]',
                    'constraints' => array(
                        'id'     => '[0-9]*',
                        'choice' => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'page',
                        'action'     => 'index',
                        'id'         => 1,
                    ),
                ),
            ),
            'newpage' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/page/new[/:choice]',
                    'constraints' => array(
                        'choice' => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'page',
                        'action'     => 'new',
                        'choice'     => null,
                    ),
                ),
            ),
            'choice' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/choice/:id',
                    'constraints' => array(
                        'id'     => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'choice',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
);
