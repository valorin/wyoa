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
            'Story\Model\PageTable' => array(
                'parameters' => array(
                    'adapter'           => 'Zend\Db\Adapter\Adapter',
                    'oPageVersionTable' => 'Story\Model\PageVersionTable',
                ),
            ),
            'Story\Model\PageVersionTable' => array(
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
        ),
    ),
);
