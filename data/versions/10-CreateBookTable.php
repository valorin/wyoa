<?php
namespace Application\Version;
use Zend\Db\Adapter\Adapter,
    ValVersion\Model\AbstractVersion;

/**
 * Version Script - Create Book Table
 *
 * Creates the `book` table in the db.
 *
 * @package     WYOA
 * @subpackage  Application\Version
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class CreateBookTable extends AbstractVersion
{
    /**
     * Upgrade Script
     *
     * @return Boolean
     */
    public function upgrade()
    {
        /**
         * Build SQL
         */
        $sSql = <<<SQL
CREATE TABLE `book` (
    `id`            BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    `url`           VARCHAR(255) NOT NULL,
    `registered`    TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY (`url`)
) ENGINE=INNODB
SQL;


        /**
         * Run Query
         */
        $this->_oDb->query($sSql, Adapter::QUERY_MODE_EXECUTE);

        return true;
    }


    /**
     * Downgrade Script
     *
     * @return Boolean
     */
    public function downgrade()
    {
        /**
         * Drop tables
         */
        $this->_drop('book');

        return true;
    }
}
