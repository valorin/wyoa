<?php
namespace Story\Model;

use Story\Model\Page,
    Zend\Db\TableGateway\TableGateway,
    Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet;

/**
 * Story Module - PageVersionTable
 *
 * Manages the `page_version` database table
 *
 * @package     WYOA
 * @subpackage  Story\Model\PageVersionTable
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class PageVersionTable extends TableGateway
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
        /**
         * Run parent constructor
         */
        parent::__construct('page_version', $adapter);
    }


    /**
     * Sets all page versions as inactive for the specified page
     *
     * @param   Page|Integer    $page   Page Id or Row
     * @return  PageVersionTable
     */
    public function setInactive($page)
    {
        /**
         * Check page instance
         */
        if ($page instanceof Page) {
            $page = $page->id;
        }


        /**
         * Update records
         */
        $this->update(Array('active' => 0), Array('page_id = ?' => $page));

        return $this;
    }
}
