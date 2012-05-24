<?php
namespace Story;

/**
 * Story Module
 *
 * Manages the pages within the Story.
 *
 * @package     WYOA
 * @subpackage  Story\Module
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class Module
{
    public function getServiceConfiguration()
    {
        return array(
            'factories' => array(
                'PageVersionTable' => function ($sm) {
                    $class = new Model\PageVersionTable($sm->get('DbAdapter'));
                    return $class;
                },
                'ChoiceTable' => function ($sm) {
                    $class = new Model\ChoiceTable(
                        $sm->get('DbAdapter'),
                        new Model\Choice($sm->get('DbAdapter'))
                    );
                    return $class;
                },
                'PageTable' => function ($sm) {
                    $page  = new Model\Page(
                            $sm->get('DbAdapter'), $sm->get('ChoiceTable'),
                            $sm->get('PageVersionTable')
                    );
                    $class = new Model\PageTable($sm->get('DbAdapter'), $page);
                    return $class;
                },
                'HistoryManager' => function ($sm) {
                    $class = new Model\HistoryManager(
                        $sm->get('PageTable'), $sm->get('ChoiceTable')
                    );
                    return $class;
                },
                'Story\View\Helper\Special' => function ($sm) {
                    $class = new View\Helper\Special;
                    $class->setDir(__DIR__ .'/view/story/special');
                    return $class;
                },
                'Story\View\Helper\History' => function ($sm) {
                    $class = new View\Helper\History;
                    $class->setHistoryManager($sm->get('HistoryManager'));
                    return $class;
                },
                /*
                'PageController' => function ($sm) {
                    $class = new Controller\PageController();
                    $class->setPageTable($sm->get('PageTable'));
                    $class->setHistoryManager($sm->get('HistoryManager'));
                    return $class;
                },
                'ChoiceController' => function ($sm) {
                    $class = new Controller\ChoiceController();
                    $class->setChoiceTable($sm->get('ChoiceTable'));
                    $class->setHistoryManager($sm->get('HistoryManager'));
                    return $class;
                },
                */
            ),
        );
    }


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
}
