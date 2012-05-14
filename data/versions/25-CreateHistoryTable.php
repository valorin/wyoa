<?php
namespace Application\Version;
use Zend\Db\Adapter\Adapter,
    ValVersion\Model\AbstractVersion;

/**
 * Version Script - Create History Table
 *
 * Creates the `history` table in the db.
 *
 * @package     WYOA
 * @subpackage  Application\Version
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class CreateHistoryTable extends AbstractVersion
{
    /**
     * Upgrade Script
     *
     * @return  Boolean
     */
    public function upgrade()
    {
        /**
         * Build `history` table SQL
         */
        $sSql = <<<SQL
CREATE TABLE `history` (
    `id`                BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    `user_id`           BIGINT UNSIGNED NOT NULL,
    `type`              ENUM('page', 'choice'),
    `page_id`           BIGINT UNSIGNED DEFAULT NULL,
    `choice_id`         BIGINT UNSIGNED DEFAULT NULL,
    `description`       VARCHAR(255) NOT NULL,
    `timestamp`         TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY (`type`),
    KEY (`user_id`),
    KEY (`page_id`),
    KEY (`choice_id`),
    FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE SET NULL,
    FOREIGN KEY (`choice_id`) REFERENCES `choice` (`id`) ON DELETE SET NULL
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
     * @return  Boolean
     */
    public function downgrade()
    {
        /**
         * Drop tables
         */
        $this->_drop('history');

        return true;
    }

}
