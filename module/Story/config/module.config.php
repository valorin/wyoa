<?php
return array(
    'di' => array(
        'instance' => array(
            'Story\Controller\PageController' => array(
                'parameters' => array(
                    'pageTable' => 'Story\Model\PageTable',
                ),
            ),
            'Story\Controller\ChoiceController' => Array(
                'parameters' => Array(
                    'choiceTable' => 'Story\Model\ChoiceTable',
                ),
            ),
            'Story\Model\PageVersionTable' => array(
                'parameters' => array(
                    'adapter'           => 'Zend\Db\Adapter\Adapter',
                ),
            ),
            'Story\Model\ChoiceTable' => array(
                'parameters' => array(
                    'adapter' => 'Zend\Db\Adapter\Adapter',
                    'choice'  => 'Story\Model\Choice',
                ),
            ),
            'Story\Model\Choice' => Array(
                'parameters' => Array(
                    'adapter'    => 'Zend\Db\Adapter\Adapter',
                ),
            ),
            'Story\Model\PageTable' => array(
                'parameters' => array(
                    'adapter' => 'Zend\Db\Adapter\Adapter',
                    'page'    => 'Story\Model\Page',
                ),
            ),
            'Story\Model\Page' => Array(
                'parameters' => Array(
                    'adapter'          => 'Zend\Db\Adapter\Adapter',
                    'pageVersionTable' => 'Story\Model\PageVersionTable',
                    'choiceTable'      => 'Story\Model\ChoiceTable',
                ),
            ),
            'Story\View\Helper\Special' => Array(
                'parameters' => Array(
                    'sDir' => __DIR__ .'/../view/story/special',
                ),
            ),
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
                        'controller' => 'Story\Controller\PageController',
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
                        'controller' => 'Story\Controller\PageController',
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
                        'controller' => 'Story\Controller\ChoiceController',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controller' => array(
        'classes' => array(
            'PageController'   => 'Story\Controller\PageController',
            'ChoiceController' => 'Story\Controller\ChoiceController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'application' => __DIR__ . '/../view',
        ),
        'helper_map' => array(
            'special' => 'Story\View\Helper\Special',
        ),
    ),
);
