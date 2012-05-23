<?php
namespace Application\Version;
use Zend\Db\Adapter\Adapter,
    ValVersion\Model\AbstractVersion;

/**
 * Version Script - Create User Table
 *
 * Creates the `user` table in the db.
 *
 * @package     WYOA
 * @subpackage  Application\Version
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class CreateUserTable extends AbstractVersion
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
CREATE TABLE `user` (
    `id`            BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    `email`         VARCHAR(255) NOT NULL,
    `display`       VARCHAR(255) NOT NULL,
    `password`      VARCHAR(60) DEFAULT NULL,
    `hash`          VARCHAR(40) DEFAULT NULL,
    `level`         ENUM('author', 'editor', 'bestseller'),
    `registered`    TIMESTAMP DEFAULT 0,
    `updated`       TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                        ON UPDATE CURRENT_TIMESTAMP,
    `lastvisit`     TIMESTAMP DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY (`email`)
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
        $this->_drop('user');

        return true;
    }
}
