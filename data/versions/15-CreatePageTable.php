<?php
namespace Application\Version;
use Zend\Db\Adapter\Adapter,
    ValVersion\Model\AbstractVersion;

/**
 * Version Script - Create Page Table
 *
 * Creates the `page` & `page_version` tables in the db.
 *
 * @package     WYOA
 * @subpackage  Application\Version
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class CreatePageTable extends AbstractVersion
{
    /**
     * Upgrade Script
     *
     * @return Boolean
     */
    public function upgrade()
    {
        /**
         * Build `page` table SQL
         */
        $sSql = <<<SQL
CREATE TABLE `page` (
    `id`        BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    `user_id`   BIGINT UNSIGNED DEFAULT NULL,
    `book_id`   BIGINT UNSIGNED DEFAULT NULL,
    `title`     VARCHAR(255) NOT NULL,
    `visits`    BIGINT UNSIGNED DEFAULT 0,
    `created`   TIMESTAMP DEFAULT 0,
    `updated`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `lastvisit` TIMESTAMP DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY (`user_id`),
    KEY (`book_id`),
    FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL,
    FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE SET NULL
) ENGINE=INNODB
SQL;


        /**
         * Run Query
         */
        $this->_oDb->query($sSql, Adapter::QUERY_MODE_EXECUTE);


        /**
         * Build `page_version` table SQL
         */
        $sSql = <<<SQL
CREATE TABLE `page_version` (
    `id`        BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    `page_id`   BIGINT UNSIGNED NOT NULL,
    `user_id`   BIGINT UNSIGNED DEFAULT NULL,
    `story`     LONGTEXT NOT NULL,
    `active`    TINYINT DEFAULT 1,
    `timestamp` TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY (`page_id`),
    FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=INNODB
SQL;


        /**
         * Run Query
         */
        $this->_oDb->query($sSql, Adapter::QUERY_MODE_EXECUTE);


        /**
         * Create default pages
         */
        $aPages = Array(
            Array(
                'id'      => 1,
                'title'   => "'Greetings Adventurer!'",
                'created' => "NOW()",
            ),
            Array(
                'id'      => 2,
                'title'   => "'Other books to visit...'",
                'created' => "NOW()",
            ),
        );
        $aVersions = Array(
            Array(
                'page_id' => 1,
                'story'   => "'[special:welcome]\n[special:about]'",
            ),
            Array(
                'page_id' => 2,
                'story'   => "'[special:other_books]'",
            ),
        );


        $this->_insert('page', $aPages);
        $this->_insert('page_version', $aVersions);

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
        $this->_drop(Array('page_version', 'page'));

        return true;
    }
}
