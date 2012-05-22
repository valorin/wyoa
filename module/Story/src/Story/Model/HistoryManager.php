<?php
namespace Story\Model;

use Zend\Session;

/**
 * Story Module - History Manager
 *
 * Manages the user story history either in Session for guests, or via
 * the `history` dbtable for logged in users.
 *
 * @package     WYOA
 * @subpackage  Story\Model\HistoryManager
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class HistoryManager
{
    /**
     * @var PageTable
     */
    protected $_pageTable;

    /**
     * @var Session\Container
     */
    protected $_session;


    /**
     * Construct the History Manager
     *
     */
    public function __construct()
    {
        /**
         * Initiate the Session manager
         */
        $this->_session = new Session\Container(get_class($this));
    }


    /**
     * Add a history entry for the current page, linked from the choice
     *
     * @param   Integer|Page    $page   Page Id or Row Object
     * @param   Integer|Choice  $choice Choice Id or Row Object
     * @return  HistoryManager
     */
    public function addPage($page, $choice = null)
    {
        /**
         * Transform Page and Choice into what we need
         */
        if (is_numeric($page)) {
            $page = $this->_pageTable->get($page);
        }

        if ($choice instanceof Choice) {
            $choice = $choice->id;
        }


        /**
         * Save Page Details
         */
        $this->_add(
            Array(
                'type'        => "page",
                'page_id'     => $page->id,
                'description' => $page->title,
                'choice_id'   => $choice,
            )
        );
    }


    /**
     * Add Row to the Session / Database
     *
     * @param   Array   $row
     * @return  HistoryManager
     */
    protected function _add($row)
    {
        if (!isset($this->_session->history)) {
            $this->_session->history = Array();
        }

        \Zend\Debug::dump($this->_session->history);

        $history = $this->_session->history;
        $history[] = $row;

        $this->_session->history = $history;
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
}
