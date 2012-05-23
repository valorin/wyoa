<?php
namespace Story\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Story\Model\Page as PageRow;
use Story\Model\HistoryManager;

/**
 * Story Module - History View Helper
 *
 * Generates the page history list
 *
 * @package     WYOA
 * @subpackage  Story\View\Helper\History
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class History extends AbstractHelper
{
    /**
     * @var HistoryManager
     */
    protected $historyManager;


    /**
     * Invoke the helper
     *
     * @param  PageRow $page Page Row object to load history from
     * @return String
     */
    public function __invoke(PageRow $page = null)
    {
        /**
         * Retrieve History for the specific page
         */
        $history = $this->historyManager->getStory($page);
        $history = array_reverse($history);


        /**
         * Generate Items
         */
        $items = Array();
        foreach ($history as $row) {

            $text = "";
            if (isset($row['choice'])) {
                $text .= "<span class='choice'>{$row['choice']}</span>";
                $text .= "<br />";
            }

            $url   = $this->view->url('page', Array('id' => $row['page_id']));
            $text .= "<a href='{$url}'>{$row['description']}</a>";

            $items[] = $text;
        }


        /**
         * Generate Output
         */
        $output  = "<h3>The story so far...</h3>\n";
        $output .= "<ol>\n";
        $output .= "<li>".implode("</li>\n<li>", $items)."</li>\n";
        $output .= "</ol>\n";

        return $output;
    }


    /**
     * Set the HistoryManager class
     *
     * @param  HistoryManager $historyManager History Manager class
     * @return PageController
     */
    public function setHistoryManager(HistoryManager $historyManager)
    {
        $this->historyManager = $historyManager;

        return $this;
    }
}
