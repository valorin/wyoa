<?php
/**
 * Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 * * Redistributions of source code must retain the above copyright
 *   notice, this list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above
 *   copyright notice, this list of conditions and the following disclaimer
 *   in the documentation and/or other materials provided with the
 *   distribution.
 * * Neither the name of the "Write Your Own Adventure" nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Application\Model;

/**
 * Settings
 *
 * Application-wide Settings manager
 *
 * @package     WYOA
 * @subpackage  Settings
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence
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