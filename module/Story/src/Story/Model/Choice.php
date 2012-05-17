<?php
namespace Story\Model;

use Zend\Db\TableGateway\TableGateway,
    Zend\Db\RowGateway\RowGateway;

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
     * Returns true if a randomly generated number >= the chance value
     *
     * @return  Boolean
     */
    public function checkChance()
    {
        return ($this->chance >= mt_rand(0, 100));
    }
}
