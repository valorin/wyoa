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
     * @param String    $tableName
     * @param Adapter   $adapter
     * @param String    $schema
     * @param ResultSet $selectResultPrototype
     */
    public function __construct(Adapter $adapter = null)
    {
        return parent::__construct('page', $adapter);
    }
}
