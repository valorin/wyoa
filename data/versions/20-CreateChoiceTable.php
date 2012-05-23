<?php
namespace Application\Version;
use Zend\Db\Adapter\Adapter,
    ValVersion\Model\AbstractVersion;

/**
 * Version Script - Create Choice Table
 *
 * Creates the `choice` table in the db.
 *
 * @package     WYOA
 * @subpackage  Application\Version
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class CreateChoiceTable extends AbstractVersion
{
    /**
     * Upgrade Script
     *
     * @return Boolean
     */
    public function upgrade()
    {
        /**
         * Build `choice` table SQL
         */
        $sSql = <<<SQL
CREATE TABLE `choice` (
    `id`                BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    `page_id`           BIGINT UNSIGNED NOT NULL,
    `description`       VARCHAR(255) NOT NULL,
    `destination_id`    BIGINT UNSIGNED DEFAULT NULL,
    `chance`            TINYINT UNSIGNED DEFAULT 100,
    `visits`            BIGINT UNSIGNED DEFAULT 0,
    `created`           TIMESTAMP DEFAULT 0,
    `updated`           TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                            ON UPDATE CURRENT_TIMESTAMP,
    `lastvisit`         TIMESTAMP DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY (`page_id`),
    FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`destination_id`) REFERENCES `page` (`id`) ON DELETE SET NULL
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
        $this->_drop('choice');

        return true;
    }
}
