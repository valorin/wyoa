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
     * @param PageTable   $pageTable
     * @param ChoiceTable $choiceTable
     */
    public function __construct(PageTable $pageTable, ChoiceTable $choiceTable)
    {
        /**
         * Save tables
         */
        $this->pageTable = $pageTable;
        $this->choiceTable = $choiceTable;


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
     * Retrieve history records, optionally with the given page as the starting
     *  point. By default it runs back in time, so newest pages first.
     *
     * @param  Page|Integer $page     Page row object
     * @param  Boolean      $backward Run backwards in time
     * @param  Integer      $limit    Maximum records to return
     * @return Array
     */
    public function getStory($page = null, $backward = true, $limit = 15)
    {
        /**
         * Transform Page into what we need
         */
        if ($page instanceof Page) {
            $page = $page->id;
        }


        /**
         * Retrieve the history array
         */
        $history = $this->session->history;


        /**
         * Reverse if requested
         */
        if ($backward) {
            $history = array_reverse($history);
        }


        /**
         * Loop & Save History
         */
        $return = Array();
        $choice = null;
        foreach ($history as $row) {
            /**
             * Break if we hit the limit
             */
            if (count($return) >= $limit) {
                break;
            }


            /**
             * Check for Page Id
             */
            if (!isset($row['page_id'])) {
                continue;
            }


            /**
             * Check for the page record
             */
            $i = count($return) - 1;
            if ($row['type'] == "page" && ($row['page_id'] == $page || is_null($page))) {
                if (count($return) && $return[$i]['page_id'] == $page) {
                    $choice = $row['choice_id'];
                    continue;
                }

                $return[] = Array(
                    'page_id'     => $row['page_id'],
                    'description' => $row['description'],
                );

                $choice = $row['choice_id'];
                $page   = $row['page_id'];
                continue;
            }


            /**
             * Check for the choice record
             */
            if ($row['type'] == "choice" && $row['choice_id'] == $choice) {
                $return[$i]['choice'] = $row['description'];

                $choice = null;
                $page   = $row['page_id'];

                continue;
            }
        }


        return $return;
    }


    /**
     * Add a history entry for the current page, linked from the choice
     *
     * @param  Integer|Page   $page   Page Id or Row Object
     * @param  Integer|Choice $choice Choice Id or Row Object
     * @return HistoryManager
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
     * @param  Integer|Choice $choice Choice Id or Row Object
     * @return HistoryManager
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
     * @param  Array          $row
     * @return HistoryManager
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
}
