<?php
namespace Application\Model;

/**
 * Settings
 *
 * Application-wide Settings manager
 *
 * @package     WYOA
 * @subpackage  Application\Model\Settings
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class Settings
{
    /**
     * @var Array
     */
    static protected $_aDefaults;


    /**
     * Retrieve Setting from the database
     *
     * @param   String  $sKey       Setting Key
     * @param   String  $sDefault   Default value if not found
     * @return  String
     */
    static public function get($sKey, $sDefault = null)
    {
        /**
         * Check we have defaults
         */
        if (!isset(self::$_aDefaults)) {
            $sPath            = 'config/defaultsettings.config.php';
            self::$_aDefaults = include __DIR__.'/../../../../../'.$sPath;
        }


        /**
         * Check for key
         */
        if (isset(self::$_aDefaults[$sKey])) {
            return self::$_aDefaults[$sKey];
        }


        return $sDefault;
    }
}
