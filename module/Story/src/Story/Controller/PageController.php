<?php
namespace Story\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel,
    Story\Model\PageTable;

/**
 * Story Module - Page Controller
 *
 * Retrieves, creates, and edits, Story Pages
 *
 * @package     WYOA
 * @subpackage  Story\Controller
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class PageController extends ActionController
{
    /**
     * @var Story\Model\PageTable
     */
    protected $_oPageTable;


    /**
     * Index Action
     *
     */
    public function indexAction()
    {
        /**
         * Retrieve page id
         */
        $nPage = $this->getEvent()->getRouteMatch()->getParam('id', 1);


        /**
         * Load Page
         */
        $oPage = $this->_oPageTable->get($nPage);


        /**
         * Return page to layout and view
         */
        $this->layout()->oPage = $oPage;
        return Array('oPage' => $oPage);
    }


    /**
     * Inject PageTable Class
     *
     * @param  Story\Model\PageTable    $oPageTable
     */
    public function setAlbumTable(PageTable $oPageTable)
    {
        $this->_oPageTable = $oPageTable;
        return $this;
    }
}
