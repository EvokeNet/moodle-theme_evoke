<?php

/**
 * Evoke
 *
 * @package    theme_evoke
 * @copyright  2022 Willian Mano - conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

// This is the component name of the plugin - it always starts with 'theme_'
// for themes and should be the same as the name of the folder.
$plugin->component = 'theme_evoke';

// This is the version of the plugin.
$plugin->version = 2022093007;

// This is the named version.
$plugin->release = '4.0.7';

// This is a stable release.
$plugin->maturity = MATURITY_STABLE;

// This is the version of Moodle this plugin requires.
$plugin->requires = 2022041200;

// This is a list of plugins, this plugin depends on (and their versions).
$plugin->dependencies = [
    'theme_boost' => 2022041900
];
