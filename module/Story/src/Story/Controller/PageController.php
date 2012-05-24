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
     * @var PageTable
     */
    protected $pageTable;

    /**
     * @var HistoryManager
     */
    protected $historyManager;


    /**
     * Index Action
     *
     */
    public function indexAction()
    {
        /**
         * Retrieve page id
         */
        $page   = $this->getEvent()->getRouteMatch()->getParam('id', 1);
        $choice = $this->getEvent()->getRouteMatch()->getParam('choice', null);


        /**
         * Load Page
         */
        $page = $this->getPageTable()->get($page);

        if (!$page) {
            return Array();
        }


        /**
         * Increment Visits Counter
         * TODO: Add History record
         */
        //$page->incrementVisits();


        /**
         * Add to History Manager
         */
        $this->getHistoryManager()->addPage($page, $choice);


        /**
         * Return page to layout and view
         */
        $this->layout()->page = $page;

        return Array('page' => $page);
    }


    /**
     * Create new page Action
     *
     */
    public function newAction()
    {

    }


    /**
     * Get the PageTable class
     *
     * @return  PageTable
     */
    public function getPageTable()
    {
        if (is_null($this->pageTable)) {
            $this->pageTable = $this->getServiceLocator()->get("PageTable");
        }

        return $this->pageTable;
    }


    /**
     * Set the PageTable class
     *
     * @param  PageTable      $pageTable
     * @return PageController
     */
    public function setPageTable(PageTable $pageTable)
    {
        $this->pageTable = $pageTable;

        return $this;
    }


    /**
     * Get the HistoryManager class
     *
     * @return  HistoryManager
     */
    public function getHistoryManager()
    {
        if (is_null($this->historyManager)) {
            $this->historyManager = $this->getServiceLocator()->get(
                "HistoryManager"
            );
        }

        return $this->historyManager;
    }


    /**
     * Set the HistoryManager class
     *
     * @param  HistoryManager      $historyManager
     * @return PageController
     */
    public function setHistoryManager(HistoryManager $historyManager)
    {
        $this->historyManager = $historyManager;

        return $this;
    }
}
