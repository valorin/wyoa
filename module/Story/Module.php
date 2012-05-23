<?php
namespace Story;

/**
 * Story Module
 *
 * Manages the pages within the Story.
 *
 * @package     WYOA
 * @subpackage  Story\Module
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
