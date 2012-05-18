<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'page' => 'Story\Controller\PageController',
            ),
            'Story\Controller\PageController' => array(
                'parameters' => array(
                    'oPageTable' => 'Story\Model\PageTable',
                ),
            ),
            'Story\Controller\ChoiceController' => Array(
                'parameters' => Array(
                    'choiceTable' => 'Story\Model\ChoiceTable',
                ),
            ),
            'Story\Model\PageTable' => array(
                'parameters' => array(
                    'adapter'           => 'Zend\Db\Adapter\Adapter',
                    'oPageVersionTable' => 'Story\Model\PageVersionTable',
                    'choiceTable'       => 'Story\Model\ChoiceTable',
                ),
            ),
            'Story\Model\PageVersionTable' => array(
                'parameters' => array(
                    'adapter'           => 'Zend\Db\Adapter\Adapter',
                ),
            ),
            'Story\Model\ChoiceTable' => array(
                'parameters' => array(
                    'adapter'           => 'Zend\Db\Adapter\Adapter',
                ),
            ),
            'Story\View\Helper\Special' => Array(
                'parameters' => Array(
                    'sDir' => __DIR__ .'/../view/special',
                ),
            ),
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'album' => __DIR__ . '/../view',
                    ),
                ),
            ),
            'Zend\View\HelperLoader' => array(
                'parameters' => array(
                    'map' => array(
                        'special' => 'Story\View\Helper\Special',
                    ),
                ),
            ),
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'broker' => 'Zend\View\HelperBroker',
                ),
            ),
            'Zend\View\HelperBroker' => array(
                'parameters' => array(
                    'loader' => 'Zend\View\HelperLoader',
                ),
            ),
            // Setup for router and routes
            'Zend\Mvc\Router\RouteStackInterface' => array(
                'parameters' => array(
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
                                    'controller' =>
                                            'Story\Controller\PageController',
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
                                    'controller' =>
                                            'Story\Controller\PageController',
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
                                    'controller' =>
                                            'Story\Controller\ChoiceController',
                                    'action'     => 'index',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
