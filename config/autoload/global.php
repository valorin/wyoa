<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overridding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'valcommon' => Array(
        'setting' => Array(
            'title'   => "Write Your Own Adventure",
            'tagline' => "The collaborative 'choose your own adventure' generator.",
        ),
    ),
);
