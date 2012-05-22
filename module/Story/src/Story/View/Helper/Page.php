<?php
namespace Story\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Story Module - Page View Helper
 *
 * Renders the page content, includes markdown() and special()
 *
 * @package     WYOA
 * @subpackage  Story\View\Helper\Page
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class Page extends AbstractHelper
{
    /**
     * Invoke the helper
     *
     * @param   String  $story  Story String
     * @return  String
     */
    public function __invoke($story)
    {
        /**
         * Render Special content
         */
        $story = $this->getView()->special($story);


        /**
         * Render Chances
         */
        $story = $this->getView()->chance($story);


        /**
         * Render Markdown
         */
        $story = $this->getView()->markdown($story);


        /**
         * Return Rendered Story
         */
        return $story;
    }
}
