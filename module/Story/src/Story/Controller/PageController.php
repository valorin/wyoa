<?php
namespace Story\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel,
    Story\Model\PageTable,
    Story\Model\HistoryManager;

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
    protected $_pageTable;

    /**
     * @var HistoryManager
     */
    protected $_historyManager;


    /**
     * Index Action
     *
     */
    public function indexAction()
    {
        /**
         * Retrieve page id
         */
        $nPage   = $this->getEvent()->getRouteMatch()->getParam('id', 1);
        $choice = $this->getEvent()->getRouteMatch()->getParam('choice', null);


        /**
         * Load Page
         */
        $oPage = $this->_pageTable->get($nPage);

        if (!$oPage) {
            return Array();
        }


        /**
         * Increment Visits Counter
         * TODO: Add History record
         */
        //$oPage->incrementVisits();


        /**
         * Add to History Manager
         */
        $this->_historyManager->addPage($oPage, $choice);


        /**
         * Return page to layout and view
         */
        $this->layout()->oPage = $oPage;
        return Array('oPage' => $oPage);
    }


    /**
     * Create new page Action
     *
     */
    public function newAction()
    {

    }


    /**
     * Inject PageTable Class
     *
     * @param  PageTable    $pageTable
     */
    public function setPageTable(PageTable $pageTable)
    {
        $this->_pageTable = $pageTable;
        return $this;
    }


    /**
     * Set the HistoryManager class
     *
     * @param   HistoryManager  $historyManager History Manager class
     * @return  PageController
     */
    public function setHistoryManager(HistoryManager $historyManager)
    {
        $this->_historyManager = $historyManager;
        return $this;
    }
}
