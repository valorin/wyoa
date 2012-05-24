<?php
namespace Story\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\Adapter\Adapter;

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
     * @param Adapter $adapter
     * @param Choice  $choice
     */
    public function __construct(Adapter $adapter, Choice $choice)
    {
        $feature = new RowGatewayFeature($choice);
        return parent::__construct('choice', $adapter, $feature);
    }


    /**
     * Retrieve choices based on the condition and chance
     *
     * @param  Page|Integer $xCondition Condition to apply
     * @return ResultSet
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
