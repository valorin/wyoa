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
    protected $pageTable;

    /**
     * @var ChoiceTable
     */
    protected $choiceTable;

    /**
     * @var Session\Container
     */
    protected $session;


    /**
     * Construct the History Manager
     *
     */
    public function __construct()
    {
        /**
         * Initiate the Session manager
         */
        $this->session = new Session\Container(get_class($this));


        /**
         * Check the Session Array isset
         */
        if (!isset($this->session->history)) {
            $this->session->history = Array();
        }
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
            $page = $this->pageTable->get($page);
        }

        if ($choice instanceof Choice) {
            $choice = $choice->id;
        }


        /**
         * Save Page Details
         */
        $this->add(
            Array(
                'type'        => "page",
                'page_id'     => $page->id,
                'description' => $page->title,
                'choice_id'   => $choice,
            )
        );
    }


    /**
     * Add a history entry for the current choice
     *
     * @param   Integer|Choice  $choice Choice Id or Row Object
     * @return  HistoryManager
     */
    public function addChoice($choice)
    {
        /**
         * Transform Choice into what we need
         */
        if (is_numeric($choice)) {
            $choice = $this->choiceTable->get($choice);
        }


        /**
         * Save Page Details
         */
        $this->add(
            Array(
                'type'        => "choice",
                'page_id'     => $choice->page_id,
                'choice_id'   => $choice->id,
                'description' => $choice->description,
            )
        );
    }


    /**
     * Add Row to the Session / Database
     *
     * @param   Array   $row
     * @return  HistoryManager
     */
    protected function add($row)
    {
        /**
         * Add row to the session
         */
        $history                = $this->session->history;
        $history[]              = $row;
        $this->session->history = $history;

        return $this;
    }


    /**
     * Inject PageTable Class
     *
     * @param  PageTable    $pageTable
     */
    public function setPageTable(PageTable $pageTable)
    {
        $this->pageTable = $pageTable;
        return $this;
    }


    /**
     * Inject ChoiceTable Class
     *
     * @param  ChoiceTable    $choiceTable
     */
    public function setChoiceTable(ChoiceTable $choiceTable)
    {
        $this->choiceTable = $choiceTable;
        return $this;
    }
}
