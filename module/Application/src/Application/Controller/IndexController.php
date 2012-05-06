<?php
namespace Application\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

/**
 * Index Controller
 *
 * Application Index Controller
 *
 * @package     WYOA
 * @subpackage  Application\Controller
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class IndexController extends ActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
