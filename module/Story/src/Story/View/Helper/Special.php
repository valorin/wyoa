<?php
namespace Story\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Story Module - Special View Helper
 *
 * Includes special page content into pages using [special:blah] tags
 *
 * @package     WYOA
 * @subpackage  Story\View\Helper\Special
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class Special extends AbstractHelper
{
    /**
     * @var String
     */
    protected $_sDir;


    /**
     * Invoke the helper
     *
     * @param  String $sStory
     * @return String
     */
    public function __invoke($sStory)
    {
        /**
         * Match our [special:blah] tags
         */
        if (preg_match_all('^\[special\:(\w*)\]^', $sStory, $aMatches)) {
            /**
             * Loop Matches
             */
            foreach ($aMatches[1] as $i => $sKey) {
                $sFile    = $this->_sDir."/{$sKey}.md";
                $sReplace = "";
                if (file_exists($sFile)) {
                    $sReplace = file_get_contents($sFile);
                }
                $sStory = str_replace(
                    $aMatches[0][$i], $sReplace, $sStory
                );
            }
        }


        /**
         * Return Story
         */

        return $sStory;
    }


    /**
     * Set the special views dir
     *
     * @param String $sDir
     */
    public function setDir($sDir)
    {
        $this->_sDir = $sDir;

        return $this;
    }
}
