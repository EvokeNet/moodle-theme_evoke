<?php

namespace theme_evoke\util;

use navigation_node;
use moodle_url;

/**
 * Secondary top red navbar utility class.
 *
 * @package     theme_evoke
 * @copyright   2022 World Bank Group <https://worldbank.org>
 * @author      Willian Mano <willianmanoaraujo@gmail.com>
 */
class secondarynavigation {
    public static function get_general_nav_items() {
        global $PAGE, $USER;

        $secondary = $PAGE->secondarynav;

        if (!has_capability('moodle/course:update', $PAGE->context)) {
            if ($keys = $secondary->get_children_key_list()) {
                foreach ($keys as $key) {
                    $child = $secondary->get($key);
                    $child->remove();
                }
            }

            if ($PAGE->course->id < 2) {
                return $secondary;
            }

            if (isguestuser($USER) || !is_enrolled($PAGE->context, $USER)) {
                return $secondary;
            }

            $secondary->add(
                get_string('hq', 'theme_evoke'),
                new moodle_url('/course/view.php', ['id' => $PAGE->course->id]),
                navigation_node::TYPE_CUSTOM
            );

            if (self::course_has_block_map($PAGE->course->id)) {
                $secondary->add(
                    get_string('map', 'theme_evoke'),
                    new moodle_url('/blocks/evokehq/missions.php', ['id' => $PAGE->course->id]),
                    navigation_node::TYPE_CUSTOM
                );
            }

            if ($coursemenuitems = get_config('local_evokesettings', 'coursemenuitems-' . $PAGE->course->id)) {
                $menuitems = self::convert_text_to_menu_nodes($coursemenuitems);

                foreach ($menuitems as $menuitem) {
                    $secondary->add(
                        $menuitem['text'],
                        $menuitem['url'],
                        navigation_node::TYPE_CUSTOM
                    );
                }
            }

            if (self::course_has_game_enabled($PAGE->course->id)) {
                $secondary->add(
                    get_string('myprogress', 'theme_evoke'),
                    new moodle_url('/local/evokegame/profile.php', ['id' => $PAGE->course->id]),
                    navigation_node::TYPE_CUSTOM
                );
            }

            if (self::course_has_marketplace_enabled($PAGE->course->id)) {
                $secondary->add(
                    get_string('marketplace', 'theme_evoke'),
                    new moodle_url('/local/marketplace/index.php', ['id' => $PAGE->course->id]),
                    navigation_node::TYPE_CUSTOM
                );
            }
        }

        return $secondary;
    }

    protected static function convert_text_to_menu_nodes($text) {
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
                            } catch (\moodle_exception $exception) {
                                // We're not actually worried about this, we don't want to mess up the display
                                // just for a wrongly entered URL.
                                $itemurl = null;
                            }
                            break;
                    }
                }
            }

            $menuitems[] = [
                'text' => $itemtext,
                'url' => $itemurl
            ];
        }

        return $menuitems;
    }

    /**
     * Verify if block is present in the course
     *
     * @param int $courseid
     *
     * @return bool
     *
     * @throws \dml_exception
     */
    public static function course_has_block_map($courseid): bool {
        global $DB;

        if (!class_exists(\block_mission_map\output\blockintohq::class)) {
            return false;
        }

        $sql = 'SELECT b.*
                FROM {block_instances} b
                INNER JOIN {context} c ON c.id = b.parentcontextid
                WHERE b.blockname = :blockname AND c.contextlevel = :contextlevel AND instanceid = :courseid';

        $record = $DB->get_record_sql(
            $sql,
            [
                'blockname' => 'mission_map',
                'contextlevel' => 50,
                'courseid' => $courseid
            ]
        );

        if ($record) {
            return true;
        }

        return false;
    }

    /**
     * Verify if game is enabled in the course
     *
     * @param int $courseid
     *
     * @return bool
     *
     * @throws \dml_exception
     */
    public static function course_has_game_enabled($courseid): bool  {
        if (!class_exists(\local_evokegame\output\renderer::class)) {
            return false;
        }

        $isgameenabledincourse = get_config('local_evokegame', 'isgameenabledincourse-' . $courseid);

        if ($isgameenabledincourse == 1) {
            return true;
        }

        return false;
    }

    /**
     * Verify if game is enabled in the course
     *
     * @param int $courseid
     *
     * @return bool
     *
     * @throws \dml_exception
     */
    public static function course_has_marketplace_enabled($courseid): bool {
        if (!class_exists(\local_marketplace\output\renderer::class)) {
            return false;
        }

        if (!self::course_has_game_enabled($courseid)) {
            return false;
        }

        return true;
    }
}
