<?php
namespace Story\Model;

use Story\Model\Page,
    Story\Model\User,
    Zend\Db\TableGateway\TableGateway,
    Zend\Db\RowGateway\RowGateway;

/**
 * Story Module - Page Object (Db Row)
 *
 * Manages a specific page row object.
 *
 * @package     WYOA
 * @subpackage  Story\Model\Page
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class Page extends RowGateway
{
    /**
     * @var PageVersionTable
     */
    protected $_oPageVersionTable;


    /**
     * Retrieve the current story text
     *
     * @return  String
     */
    public function getStory()
    {
        /**
         * Fetch active page version
         */
        $oRowset = $this->_oPageVersionTable->select(
            Array('active' => 1, 'page_id' => $this->id)
        );


        /**
         * Return row if set
         */
        if ($oRowset) {
            return $oRowset->current()->story;
        }


        /**
         * Create new row
         */
        return "";
    }


    /**
     * Retrieve the page choices
     *
     * @param   Boolean $bAll   Return all, or honour 'chance' value
     * @return  Array
     */
    public function getChoices($bAll = false)
    {
        return Array();
    }


    /**
     * Sets the Page Story attributed to the user.
     * Will override any existing story with the new version.
     *
     * @param   String          $sStory Story content
     * @param   Integer|User    $xUser  User Id | User Row Object
     * @return  Page
     */
    public function setStory($sStory, $xUser = null)
    {
        /**
         * Check User instance type
         */
        if ($xUser instanceof User) {
            $xUser = $xUser->id;
        }


        /**
         * Mark current versions as inactive
         */
        $this->_oPageVersionTable->setInactive($this);


        /**
         * Insert new story
         */
        $this->_oPageVersionTable->insert(
            Array(
                'page_id' => $this->id,
                'user_id' => $xUser,
                'story'   => $sStory,
            )
        );


        /**
         * Return self
         */
        return $this;
    }

    /**
     * Set the 'page_version' table gateway
     *
     * @param   TableGateway    $oPageVersionTable
     * @return  PageTable
     */
    public function setPageVersionTable($oPageVersionTable)
    {
        $this->_oPageVersionTable = $oPageVersionTable;
        return $this;
    }
}
