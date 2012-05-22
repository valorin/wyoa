<?php
namespace Story\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Story Module - Chance View Helper
 *
 * Render Chance strings
 *
 * @package     WYOA
 * @subpackage  Story\View\Helper\Chance
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class Chance extends AbstractHelper
{
    /**
     * Invoke the helper
     *
     * @param   String  $story
     * @return  String
     */
    public function __invoke($story)
    {
        /**
         * Extract the chance strings
         */
        $regex = '&\[([^|\]]+?)\s*\|\s*(\d+)%\s*\]&';
        if (preg_match_all($regex, $story, $matches)) {
            foreach ($matches[1] as $i => $val) {
                $replace = "";
                if ($matches[2][$i] >= mt_rand(0, 100)) {
                    $replace = "<span class='chance'>{$val}</span>";
                }
                $story = str_replace($matches[0][$i], $replace, $story);
            }
        }


        /**
         * Return Story
         */
        return $story;
    }


    /**
     * Set the special views dir
     *
     * @param   String  $sDir
     */
    public function setDir($sDir)
    {
        $this->_sDir = $sDir;
        return $this;
    }
}
