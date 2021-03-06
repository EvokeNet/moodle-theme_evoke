<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Theme functions.
 *
 * @package    theme_evoke
 * @copyright 2017 Willian Mano - http://conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Inject additional SCSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_evoke_get_extra_scss($theme) {
    $scss = $theme->settings->scss;

    $scss .= theme_evoke_set_headerimg($theme);

    $scss .= theme_evoke_set_loginbgimg($theme);

    return $scss;
}

/**
 * Adds the cover to CSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_evoke_set_headerimg($theme) {
    global $OUTPUT;

    $headerimg = $theme->setting_file_url('headerimg', 'headerimg');

    if (is_null($headerimg)) {
        $headerimg = $OUTPUT->image_url('headerimg', 'theme');
    }

    $headercss = "#page-site-index.notloggedin #page-header {background-image: url('$headerimg');}";

    return $headercss;
}

/**
 * Adds the login page background image to CSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_evoke_set_loginbgimg($theme) {
    $loginbgimg = $theme->setting_file_url('loginbgimg', 'loginbgimg');

    if ($loginbgimg) {
        $headercss = "#page-login-index.evoke-login #page-wrapper #page {background-image: url('$loginbgimg')!important;background-size: cover;}";

        return $headercss;
    }
}

/**
 * Returns the main SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_evoke_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;
    $fs = get_file_storage();

    $context = context_system::instance();
    if ($filename == 'default.scss') {
        // We still load the default preset files directly from the boost theme. No sense in duplicating them.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    } else if ($filename == 'plain.scss') {
        // We still load the default preset files directly from the boost theme. No sense in duplicating them.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/plain.scss');
    } else if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_evoke', 'preset', 0, '/', $filename))) {
        // This preset file was fetched from the file area for theme_evoke and not theme_boost (see the line above).
        $scss .= $presetfile->get_content();
    } else {
        // Safety fallback - maybe new installs etc.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    }

    // Evoke scss.
    $evoke = file_get_contents($CFG->dirroot . '/theme/evoke/scss/evoke.scss');

    // Combine them together.
    $allscss = $scss . "\n" . $evoke;

    return $allscss;
}

/**
 * Get SCSS to prepend.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_evoke_get_pre_scss($theme) {
    $scss = '';
    $configurable = [
        // Config key => [variableName, ...].
        'brandcolor' => ['evoke-brand-primary'],
        'navbarheadercolor' => 'navbar-header-color',
        'navbarbg' => 'navbar-bg',
        'navbarbghover' => 'navbar-bg-hover'
    ];

    // Prepend variables first.
    foreach ($configurable as $configkey => $targets) {
        $value = isset($theme->settings->{$configkey}) ? $theme->settings->{$configkey} : null;
        if (empty($value)) {
            continue;
        }
        array_map(function($target) use (&$scss, $value) {
            $scss .= '$' . $target . ': ' . $value . ";\n";
        }, (array) $targets);
    }

    // Prepend pre-scss.
    if (!empty($theme->settings->scsspre)) {
        $scss .= $theme->settings->scsspre;
    }

    return $scss;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return mixed
 */
function theme_evoke_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    $theme = theme_config::load('evoke');

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'logo') {
        return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'headerimg') {
        return $theme->setting_file_serve('headerimg', $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'marketing1icon') {
        return $theme->setting_file_serve('marketing1icon', $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'marketing2icon') {
        return $theme->setting_file_serve('marketing2icon', $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'marketing3icon') {
        return $theme->setting_file_serve('marketing3icon', $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'marketing4icon') {
        return $theme->setting_file_serve('marketing4icon', $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'loginbgimg') {
        return $theme->setting_file_serve('loginbgimg', $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'favicon') {
        return $theme->setting_file_serve('favicon', $args, $forcedownload, $options);
    }

    if ($filearea === 'hvp') {
        return theme_evoke_serve_hvp_css($args[1], $theme);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and preg_match("/^sliderimage[1-9][0-9]?$/", $filearea) !== false) {
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and preg_match("/^sponsorsimage[1-9][0-9]?$/", $filearea) !== false) {
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }

    if ($context->contextlevel == CONTEXT_SYSTEM and preg_match("/^clientsimage[1-9][0-9]?$/", $filearea) !== false) {
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }

    send_file_not_found();
}

/**
 * Get theme setting
 *
 * @param string $setting
 * @param bool $format
 * @return string
 */
function theme_evoke_get_setting($setting, $format = false) {
    $theme = theme_config::load('evoke');

    if (empty($theme->settings->$setting)) {
        return false;
    }

    if (!$format) {
        return $theme->settings->$setting;
    }

    if ($format === 'format_text') {
        return format_text($theme->settings->$setting, FORMAT_PLAIN);
    }

    if ($format === 'format_html') {
        return format_text($theme->settings->$setting, FORMAT_HTML, array('trusted' => true, 'noclean' => true));
    }

    return format_string($theme->settings->$setting);
}


/**
 * Extend the Evoke navigation
 *
 * @param flat_navigation $flatnav
 */
function theme_evoke_extend_flat_navigation(\flat_navigation $flatnav) {
    theme_evoke_delete_menuitems($flatnav);

    theme_evoke_add_coursesections_to_navigation($flatnav);

    theme_evoke_rename_menuitems($flatnav);

    theme_evoke_add_evokehome_menuitems($flatnav);

    theme_evoke_add_evokeportfolio_menuitems($flatnav);

    theme_evoke_add_evokegame_course_menuitems($flatnav);
}

/**
 * Remove items from navigation
 *
 * @param flat_navigation $flatnav
 */
function theme_evoke_delete_menuitems(\flat_navigation $flatnav) {

    $itemstodelete = [
        'coursehome',
        'badgesview',
        'competencies',
        'grades',
        'home',
        'myhome',
        'calendar',
        'privatefiles'
    ];

    foreach ($flatnav as $item) {
        if (in_array($item->key, $itemstodelete)) {
            $flatnav->remove($item->key);

            continue;
        }

        if (isset($item->parent->key) && $item->parent->key == 'mycourses' &&
            isset($item->type) && $item->type == \navigation_node::TYPE_COURSE) {

            $flatnav->remove($item->key, \navigation_node::TYPE_COURSE);
        }

        if ($item->key === 'mycourses') {
            foreach ($item->children as $key => $child) {
                if (!theme_evoke_is_course_available_to_display_in_navbar($child->key)) {
                    $item->children->remove($child->key);
                }
            }
        }
    }
}

/**
 * Verify if a course can be displayed in the navbar
 *
 * @param int $courseid
 *
 * @return bool
 */
function theme_evoke_is_course_available_to_display_in_navbar($courseid) {
    global $DB, $USER;

    $course = $DB->get_record('course', ['id' => $courseid], '*');

    if (!$course) {
        return false;
    }

    if ($course->startdate != 0 && $course->startdate > time()) {
        return false;
    }

    if ($course->enddate != 0 && $course->enddate < time()) {
        return false;
    }

    $completion = new \completion_info($course);

    if (!$completion->is_enabled()) {
        return true;
    }

    $percentage = \core_completion\progress::get_course_progress_percentage($course, $USER->id);

    if (!is_null($percentage) && $percentage == 100) {
        return false;
    }

    return true;
}

/**
 * Rename navigation items text
 *
 * @param flat_navigation $flatnav
 */
function theme_evoke_rename_menuitems(\flat_navigation $flatnav) {

    $item = $flatnav->find('mycourses');

    if ($item) {
        $item->text = get_string('myactivecourses', 'theme_evoke');
    }
}

/**
 * Add portfolio index link in navigation
 *
 * @param flat_navigation $flatnav
 */
function theme_evoke_add_evokehome_menuitems(\flat_navigation $flatnav) {
    $actionurl = new moodle_url('/?redirect=0');

    $menuitemoptions = [
        'action' => $actionurl,
        'text' => get_string('sitehome'),
        'shorttext' => get_string('sitehome'),
        'icon' => new pix_icon('a/setting', ''),
        'type' => \navigation_node::TYPE_SETTING,
        'key' => 'evokehome'
    ];

    $participantsitem = $flatnav->find('participants', \navigation_node::TYPE_CONTAINER);

    $parentkey = null;
    if ($participantsitem) {
        $parentkey = $participantsitem->key;

        $menuitemoptions['parent'] = $participantsitem->parent;
    }

    $menuitem = new \flat_navigation_node($menuitemoptions, 0);

    $flatnav->add($menuitem, $parentkey);
}

/**
 * Add portfolio index link in navigation
 *
 * @param flat_navigation $flatnav
 */
function theme_evoke_add_evokeportfolio_menuitems(\flat_navigation $flatnav) {
    global $COURSE;

    $evokeportfolio = \core_plugin_manager::instance()->get_plugin_info('mod_evokeportfolio');

    if (!$evokeportfolio) {
        return false;
    }

    if ($COURSE->id < 2) {
        return false;
    }

    $context = context_course::instance($COURSE->id);

    $participantsitem = $flatnav->find('participants', \navigation_node::TYPE_CONTAINER);

    $cangrade = has_capability('mod/evokeportfolio:grade', $context);
    $cansubmit = has_capability('mod/evokeportfolio:submit', $context);

    if ($cangrade) {
        $actionurl = new moodle_url('/mod/evokeportfolio/index.php', ['id' => $COURSE->id]);

        $menuitemoptions = [
            'action' => $actionurl,
            'text' => get_string('portfoliograding', 'theme_evoke'),
            'shorttext' => get_string('portfoliograding', 'theme_evoke'),
            'icon' => new pix_icon('a/setting', ''),
            'type' => \navigation_node::TYPE_SETTING,
            'key' => 'portfolios'
        ];

        $parentkey = null;
        if ($participantsitem) {
            $parentkey = $participantsitem->key;

            $menuitemoptions['parent'] = $participantsitem->parent;
        }

        $menuitem = new \flat_navigation_node($menuitemoptions, 0);

        $flatnav->add($menuitem, $parentkey);
    }

    if (!$cangrade && $cansubmit) {
        $actionurl = new moodle_url('/mod/evokeportfolio/index.php', ['id' => $COURSE->id]);

        $menuitemoptions = [
            'action' => $actionurl,
            'text' => get_string('portfolios', 'theme_evoke'),
            'shorttext' => get_string('portfolios', 'theme_evoke'),
            'icon' => new pix_icon('a/setting', ''),
            'type' => \navigation_node::TYPE_SETTING,
            'key' => 'portfolios'
        ];

        $parentkey = null;
        if ($participantsitem) {
            $parentkey = $participantsitem->key;

            $menuitemoptions['parent'] = $participantsitem->parent;
        }

        $menuitem = new \flat_navigation_node($menuitemoptions, 0);

        $flatnav->add($menuitem, $parentkey);
    }
}

/**
 * Add chat link in navigation
 *
 * @param flat_navigation $flatnav
 */
function theme_evoke_add_evokegame_course_menuitems(\flat_navigation $flatnav) {
    global $COURSE;

    if ($COURSE->id < 2) {
        return false;
    }

    $coursemenuitems = get_config('local_evokegame', 'coursemenuitems-' . $COURSE->id);

    if (!$coursemenuitems) {
        return false;
    }

    $participantsitem = $flatnav->find('participants', \navigation_node::TYPE_CONTAINER);

    $menuitems = theme_evoke_convert_text_to_menu_nodes($coursemenuitems, $participantsitem);

    if (!$menuitems) {
        return false;
    }

    $parentkey = null;
    if ($participantsitem) {
        $parentkey = $participantsitem->key;
    }

    foreach ($menuitems as $menuitem) {
        $menuitem->parent = $participantsitem->parent;

        $flatnav->add($menuitem, $parentkey);
    }
}

function theme_evoke_convert_text_to_menu_nodes($text) {
    $lines = explode("\n", $text);

    $menuitems = [];
    foreach ($lines as $linenumber => $line) {
        $line = trim($line);
        if (strlen($line) == 0) {
            continue;
        }
        // Parse item settings.
        $itemtext = null;
        $itemurl = null;
        $itemkey = null;
        $settings = explode('|', $line);
        foreach ($settings as $i => $setting) {
            $setting = trim($setting);
            if (!empty($setting)) {
                switch ($i) {
                    case 0: // Menu text.
                        $itemtext = ltrim($setting, '-');
                        break;
                    case 1: // URL.
                        try {
                            $itemurl = new moodle_url($setting);
                        } catch (moodle_exception $exception) {
                            // We're not actually worried about this, we don't want to mess up the display
                            // just for a wrongly entered URL.
                            $itemurl = null;
                        }
                        break;
                    case 2: // KEY.
                        $itemkey = trim($setting);
                        break;
                }
            }
        }

        $menuitemoptions = [
            'action' => $itemurl,
            'text' => $itemtext,
            'shorttext' => $itemtext,
            'icon' => new pix_icon('a/settings', $itemtext),
            'type' => \navigation_node::TYPE_SETTING,
            'key' => $itemkey
        ];

        $menuitem = new \flat_navigation_node($menuitemoptions, 0);

        $menuitems[] = $menuitem;
    }

    return $menuitems;
}

/**
 * Improve flat navigation menu
 *
 * @param flat_navigation $flatnav
 */
function theme_evoke_add_coursesections_to_navigation(\flat_navigation $flatnav) {
    global $PAGE, $USER, $PAGE;

    $participantsitem = $flatnav->find('participants', \navigation_node::TYPE_CONTAINER);

    if (!$participantsitem) {
        return;
    }

    if (!has_capability('moodle/course:update', $PAGE->context)) {
        return;
    }

    if ($PAGE->course->format != 'singleactivity') {
        $coursesectionsoptions = [
            'text' => get_string('coursesections', 'theme_evoke'),
            'shorttext' => get_string('coursesections', 'theme_evoke'),
            'icon' => new pix_icon('t/viewdetails', ''),
            'type' => \navigation_node::COURSE_CURRENT,
            'key' => 'course-sections',
            'parent' => $participantsitem->parent
        ];

        $coursesections = new \flat_navigation_node($coursesectionsoptions, 0);

        foreach ($flatnav as $item) {
            if ($item->type == \navigation_node::TYPE_SECTION) {
                $coursesections->add_node(new \navigation_node([
                    'text' => $item->text,
                    'shorttext' => $item->shorttext,
                    'icon' => $item->icon,
                    'type' => $item->type,
                    'key' => $item->key,
                    'parent' => $coursesections,
                    'action' => $item->action
                ]));
            }
        }

        $flatnav->add($coursesections, $participantsitem->key);
    }
}

/**
 * Check if a certificate plugin is installed.
 *
 * @return bool
 */
function theme_evoke_has_certificates_plugin() {
    $simplecertificate = \core_plugin_manager::instance()->get_plugin_info('mod_simplecertificate');

    $customcert = \core_plugin_manager::instance()->get_plugin_info('mod_customcert');

    if ($simplecertificate || $customcert) {
        return true;
    }

    return false;
}

/**
 * Serves the H5P Custom CSS.
 *
 * @param string $filename The filename.
 * @param theme_config $theme The theme config object.
 */
function theme_evoke_serve_hvp_css($filename, $theme) {
    global $CFG, $PAGE;

    require_once($CFG->dirroot.'/lib/configonlylib.php'); // For min_enable_zlib_compression().

    $PAGE->set_context(context_system::instance());
    $themename = $theme->name;

    $content = theme_evoke_get_setting('hvpcss');

    $md5content = md5($content);
    $md5stored = get_config('theme_evoke', 'hvpccssmd5');
    if ((empty($md5stored)) || ($md5stored != $md5content)) {
        // Content changed, so the last modified time needs to change.
        set_config('hvpccssmd5', $md5content, $themename);
        $lastmodified = time();
        set_config('hvpccsslm', $lastmodified, $themename);
    } else {
        $lastmodified = get_config($themename, 'hvpccsslm');
        if (empty($lastmodified)) {
            $lastmodified = time();
        }
    }

    // Sixty days only - the revision may get incremented quite often.
    $lifetime = 60 * 60 * 24 * 60;

    header('HTTP/1.1 200 OK');

    header('Etag: "'.$md5content.'"');
    header('Content-Disposition: inline; filename="'.$filename.'"');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s', $lastmodified).' GMT');
    header('Expires: '.gmdate('D, d M Y H:i:s', time() + $lifetime).' GMT');
    header('Pragma: ');
    header('Cache-Control: public, max-age='.$lifetime);
    header('Accept-Ranges: none');
    header('Content-Type: text/css; charset=utf-8');
    if (!min_enable_zlib_compression()) {
        header('Content-Length: '.strlen($content));
    }

    echo $content;

    die;
}

function theme_evoke_get_user_avatar_or_image($user = null) {
    global $USER, $OUTPUT, $PAGE;

    if (!$user) {
        $user = $USER;
    }

    if (class_exists(\local_evokegame\util\user::class)) {
        $userutil = new \local_evokegame\util\user();

        return $userutil->get_user_avatar_or_image($user);
    }

    $userpicture = new \user_picture($user);
    $userpicture->size = 1;

    return $userpicture->get_url($PAGE);
}