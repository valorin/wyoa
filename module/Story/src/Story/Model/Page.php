<?php
namespace Story\Model;

use Zend\Db\TableGateway\TableGateway,
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
     * @var ChoiceTable
     */
    protected $_choiceTable;


    /**
     * Retrieve the current story text
     *
     * @return  String|Null
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
         * Return null if no story found
         */
        return null;
    }


    /**
     * Retrieve the page choices
     *
     * @return  Array
     */
    public function getChoices()
    {
        return $this->_choiceTable->get($this);
    }


    /**
     * Increment the number of visits
     *
     * @TODO: Fix row data update when ZF2 supports it
     * @return  Page
     */
    public function incrementVisits()
    {
        $this->populateCurrentData(Array('visits' => $this->visits + 1));
        $this->save();

        return $this;
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


    /**
     * Set the 'choice' table gateway
     *
     * @param   ChoiceTable    $choiceTable
     * @return  Page
     */
    public function setChoiceTable(ChoiceTable $choiceTable)
    {
        $this->_choiceTable = $choiceTable;
        return $this;
    }
}
