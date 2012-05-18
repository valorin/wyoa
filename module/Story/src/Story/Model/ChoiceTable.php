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


        /**
         * Set up the Choice Row
         */
        $this->setSelectResultPrototype(
            new ResultSet(new Choice('id', $this, $adapter))
        );
    }


    /**
     * Retrieve choices based on the condition and chance
     *
     * @param   Page|Integer    $xCondition Condition to apply
     * @return  ResultSet
     */
    public function get($xCondition)
    {
        /**
         * Retrieve ResultSet
         */
        if ($xCondition instanceof Page) {
            return $this->select(Array('page_id = ?' => $xCondition->id));
        } elseif (is_numeric($xCondition)) {
            return $this->select(Array('id = ?' => $xCondition))->current();
        }

        return null;
    }
}
