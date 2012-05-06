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
                    'adapter' => 'Zend\Db\Adapter\Adapter',
                ),
            ),
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'album' => __DIR__ . '/../view',
                    ),
                ),
            ),
        ),
    ),
);
