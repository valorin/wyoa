<?php
namespace Story\Model;

use Story\Model\Page,
    Zend\Db\TableGateway\TableGateway,
    Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet;

/**
 * Story Module - PageTable
 *
 * Manages the `page` database table
 *
 * @package     WYOA
 * @subpackage  Story\Model\PageTable
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class PageTable extends TableGateway
{
    /**
     * @var PageVersionTable
     */
    protected $_oPageVersionTable;


    /**
     * Constructor
     *
     * @param String    $tableName
     * @param Adapter   $adapter
     * @param String    $schema
     * @param ResultSet $selectResultPrototype
     */
    public function __construct(Adapter $adapter = null,
        $oPageVersionTable = null)
    {
        /**
         * Run parent constructor
         */
        parent::__construct('page', $adapter);


        /**
         * Save Variables
         */
        $this->_oPageVersionTable = $oPageVersionTable;


        /**
         * Set up the Page Row Object
         */
        $oPage = new Page($this, 'id');
        $oPage->setPageVersionTable($oPageVersionTable);
        $this->setSelectResultPrototype(new ResultSet($oPage));
    }


    /**
     * Retireve page from the database
     *
     * @param   Integer $nId    Page Id
     * @return  Row
     */
    public function get($nId)
    {
        /**
         * Fetch Row
         */
        $oRowset = $this->select(array('id' => $nId));
        return $oRowset ? $oRowset->current() : null;
    }
}
