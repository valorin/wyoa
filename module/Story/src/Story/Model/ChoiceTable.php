<?php
namespace Story\Model;

use Zend\Db\TableGateway\TableGateway,
    Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet;

/**
 * Story Module - ChoiceTable
 *
 * Manages the `choice` database table
 *
 * @package     WYOA
 * @subpackage  Story\Model\ChoiceTable
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class ChoiceTable extends TableGateway
{
    /**
     * Constructor
     *
     * @param   Adapter Database Adapter
     */
    public function __construct(Adapter $adapter = null)
    {
        /**
         * Run parent constructor
         */
        parent::__construct('choice', $adapter);
    }
}
