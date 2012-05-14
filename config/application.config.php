<?php
$aReturn = array(
    'modules' => array(
        'Application',
        'Story',
        'ValCommon',
//        'EdpSuperluminal',
//        'EdpMarkdown',
//        'ZendDeveloperTools',
    ),
    'module_listener_options' => array(
        'config_cache_enabled' => false,
        'cache_dir'            => 'data/cache',
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);

$aAllowed = Array('127.0.0.1');
$sKey     = "abc123";
if (in_array($_SERVER['REMOTE_ADDR'], $aAllowed)
    && isset($_GET['key']) && $_GET['key'] == $sKey) {
    $aReturn['modules'][] = 'ValVersion';
}

return $aReturn;
