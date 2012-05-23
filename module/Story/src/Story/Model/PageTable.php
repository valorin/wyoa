<?php
namespace Story\Model;

use Zend\Db\TableGateway\TableGateway,
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
     * Constructor
     *
     * @param Adapter   $adapter
     * @param ResultSet $selectResultPrototype
     * @param Sql\Sql   $selectResultPrototype
     */
    public function __construct(Adapter $adapter, Page $page)
    {
        return parent::__construct('page', $adapter, new ResultSet($page));
    }


    /**
     * Retireve page from the database
     *
     * @param  Integer $nId Page Id
     * @return Row
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
