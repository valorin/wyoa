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
    protected $_pageTable;


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
    public function setPageTable($pageTable)
    {
        $this->_pageTable = $pageTable;
        return $this;
    }
}
