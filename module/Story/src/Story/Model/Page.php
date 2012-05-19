<?php
namespace Story\Model;

use Zend\Db\TableGateway\TableGateway,
    Zend\Db\RowGateway\RowGateway,
    Zend\Db\Adapter\Adapter;

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
    protected $_pageVersionTable;

    /**
     * @var ChoiceTable
     */
    protected $_choiceTable;


    /**
     * Constructor
     *
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter = null)
    {
        return parent::__construct('id', 'page', $adapter);
    }


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
        $oRowset = $this->_pageVersionTable->select(
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
        $this->populate(Array('visits' => $this->visits + 1));
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
        $this->_pageVersionTable->setInactive($this);


        /**
         * Insert new story
         */
        $this->_pageVersionTable->insert(
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
     * Inject PageVersionTable Class
     *
     * @param  PageVersionTable    $pageVersonTable
     */
    public function setPageVersionTable($pageVersionTable)
    {
        $this->_pageVersionTable = $pageVersionTable;
        return $this;
    }


    /**
     * Inject ChoiceTable Class
     *
     * @param  ChoiceTable  $choiceTable
     */
    public function setChoiceTable($choiceTable)
    {
        $this->_choiceTable = $choiceTable;
        return $this;
    }
}
