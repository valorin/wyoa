<?php
return array(
    'di' => array(
        'instance' => array(
            'Story\Controller\PageController' => array(
                'parameters' => array(
                    'pageTable'      => 'Story\Model\PageTable',
                    'historyManager' => 'Story\Model\HistoryManager',
                ),
            ),
            'Story\Controller\ChoiceController' => Array(
                'parameters' => Array(
                    'choiceTable'    => 'Story\Model\ChoiceTable',
                    'historyManager' => 'Story\Model\HistoryManager',
                ),
            ),
            'Story\Model\HistoryManager' => Array(
                'parameters' => Array(
                    'pageTable'   => 'Story\Model\PageTable',
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
            'Story\View\Helper\History' => Array(
                'parameters' => Array(
                    'historyManager' => 'Story\Model\HistoryManager',
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
);
