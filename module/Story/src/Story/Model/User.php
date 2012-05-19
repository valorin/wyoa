<?php
namespace Story\Model;

use Zend\Db\RowGateway\RowGateway,
    Zend\Db\Adapter\Adapter;

/**
 * Story Module - User Object (Db Row)
 *
 * Manages a specific user row object.
 *
 * @package     WYOA
 * @subpackage  Story\Model\User
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class User extends RowGateway
{
    /**
     * Constructor
     *
     * @param Adapter $adapter
     * @param Sql\Sql $sql
     */
    public function __construct(Adapter $adapter = null)
    {
        return parent::__construct('id', 'user', $adapter);
    }
}
