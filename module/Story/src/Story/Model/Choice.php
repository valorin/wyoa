<?php
namespace Story\Model;

use Zend\Db\TableGateway\TableGateway,
    Zend\Db\RowGateway\RowGateway,
    Zend\Db\Adapter\Adapter;

/**
 * Story Module - Choice Object (Db Row)
 *
 * Manages a specific choice row object.
 *
 * @package     WYOA
 * @subpackage  Story\Model\Choice
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class Choice extends RowGateway
{
    /**
     * Constructor
     *
     * @param Adapter $adapter
     * @param Sql\Sql $sql
     */
    public function __construct(Adapter $adapter = null)
    {
        return parent::__construct('id', 'choice', $adapter);
    }


    /**
     * Returns true if a randomly generated number >= the chance value
     *
     * @return Boolean
     */
    public function checkChance()
    {
        return ($this->chance >= mt_rand(0, 100));
    }


    /**
     * Increment the number of visits
     *
     * @TODO: Fix row data update when ZF2 supports it
     * @return Page
     */
    public function incrementVisits()
    {
        $this->populate(Array('visits' => $this->visits + 1));
        $this->save();

        return $this;
    }
}
