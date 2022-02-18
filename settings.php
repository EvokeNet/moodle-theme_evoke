<?php
// This file is part of Ranking block for Moodle - http://moodle.org/
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
 * Theme Evoke block settings file
 *
 * @package    theme_evoke
 * @copyright  2017 Willian Mano http://conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

// This is used for performance, we don't need to know about these settings on every page in Moodle, only when
// we are looking at the admin settings pages.
if ($ADMIN->fulltree) {

    // Boost provides a nice setting page which splits settings onto separate tabs. We want to use it here.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingevoke', get_string('configtitle', 'theme_evoke'));

    /*
    * ----------------------
    * General settings tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_evoke_general', get_string('generalsettings', 'theme_evoke'));

    // Logo file setting.
    $name = 'theme_evoke/logo';
    $title = get_string('logo', 'theme_evoke');
    $description = get_string('logodesc', 'theme_evoke');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Favicon setting.
    $name = 'theme_evoke/favicon';
    $title = get_string('favicon', 'theme_evoke');
    $description = get_string('favicondesc', 'theme_evoke');
    $opts = array('accepted_types' => array('.ico'), 'maxfiles' => 1);
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset.
    $name = 'theme_evoke/preset';
    $title = get_string('preset', 'theme_evoke');
    $description = get_string('preset_desc', 'theme_evoke');
    $default = 'default.scss';

    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_evoke', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    // These are the built in presets.
    $choices['default.scss'] = 'default.scss';
    $choices['plain.scss'] = 'plain.scss';

    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset files setting.
    $name = 'theme_evoke/presetfiles';
    $title = get_string('presetfiles', 'theme_evoke');
    $description = get_string('presetfiles_desc', 'theme_evoke');

    $setting = new admin_setting_configstoredfile($name, $title, $description, 'preset', 0,
        array('maxfiles' => 20, 'accepted_types' => array('.scss')));
    $page->add($setting);

    // Login page background image.
    $name = 'theme_evoke/loginbgimg';
    $title = get_string('loginbgimg', 'theme_evoke');
    $description = get_string('loginbgimg_desc', 'theme_evoke');
    $opts = array('accepted_types' => array('.png', '.jpg', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbgimg', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $brand-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_evoke/brandcolor';
    $title = get_string('brandcolor', 'theme_evoke');
    $description = get_string('brandcolor_desc', 'theme_evoke');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $navbar-header-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_evoke/navbarheadercolor';
    $title = get_string('navbarheadercolor', 'theme_evoke');
    $description = get_string('navbarheadercolor_desc', 'theme_evoke');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $navbar-bg.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_evoke/navbarbg';
    $title = get_string('navbarbg', 'theme_evoke');
    $description = get_string('navbarbg_desc', 'theme_evoke');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $navbar-bg-hover.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_evoke/navbarbghover';
    $title = get_string('navbarbghover', 'theme_evoke');
    $description = get_string('navbarbghover_desc', 'theme_evoke');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Course format option.
    $name = 'theme_evoke/coursepresentation';
    $title = get_string('coursepresentation', 'theme_evoke');
    $description = get_string('coursepresentationdesc', 'theme_evoke');
    $options = [];
    $options[1] = get_string('coursedefault', 'theme_evoke');
    $options[2] = get_string('coursecover', 'theme_evoke');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_evoke/courselistview';
    $title = get_string('courselistview', 'theme_evoke');
    $description = get_string('courselistviewdesc', 'theme_evoke');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $page->add($setting);

    // Must add the page after definiting all the settings!
    $settings->add($page);

    /*
    * ----------------------
    * Advanced settings tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_evoke_advanced', get_string('advancedsettings', 'theme_evoke'));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_scsscode('theme_evoke/scsspre',
        get_string('rawscsspre', 'theme_evoke'), get_string('rawscsspre_desc', 'theme_evoke'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_scsscode('theme_evoke/scss', get_string('rawscss', 'theme_evoke'),
        get_string('rawscss_desc', 'theme_evoke'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Google analytics block.
    $name = 'theme_evoke/googleanalytics';
    $title = get_string('googleanalytics', 'theme_evoke');
    $description = get_string('googleanalyticsdesc', 'theme_evoke');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);

    /*
    * -----------------------
    * Frontpage settings tab
    * -----------------------
    */
    $page = new admin_settingpage('theme_evoke_frontpage', get_string('frontpagesettings', 'theme_evoke'));

    // Disable bottom footer.
    $name = 'theme_evoke/disablefrontpageloginbox';
    $title = get_string('disablefrontpageloginbox', 'theme_evoke');
    $description = get_string('disablefrontpageloginboxdesc', 'theme_evoke');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $page->add($setting);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Disable teachers from cards.
    $name = 'theme_evoke/disableteacherspic';
    $title = get_string('disableteacherspic', 'theme_evoke');
    $description = get_string('disableteacherspicdesc', 'theme_evoke');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $page->add($setting);

    // Headerimg file setting.
    $name = 'theme_evoke/headerimg';
    $title = get_string('headerimg', 'theme_evoke');
    $description = get_string('headerimgdesc', 'theme_evoke');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'headerimg', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Homepage alert.
    $name = 'theme_evoke/alertmsg';
    $title = get_string('alert', 'theme_evoke');
    $description = get_string('alert_desc', 'theme_evoke');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Bannerheading.
    $name = 'theme_evoke/bannerheading';
    $title = get_string('bannerheading', 'theme_evoke');
    $description = get_string('bannerheadingdesc', 'theme_evoke');
    $default = 'Perfect Learning System';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Bannercontent.
    $name = 'theme_evoke/bannercontent';
    $title = get_string('bannercontent', 'theme_evoke');
    $description = get_string('bannercontentdesc', 'theme_evoke');
    $default = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_evoke/displaymarketingbox';
    $title = get_string('displaymarketingbox', 'theme_evoke');
    $description = get_string('displaymarketingboxdesc', 'theme_evoke');
    $default = 1;
    $choices = array(0 => 'No', 1 => 'Yes');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    // Marketing1icon.
    $name = 'theme_evoke/marketing1icon';
    $title = get_string('marketing1icon', 'theme_evoke');
    $description = get_string('marketing1icondesc', 'theme_evoke');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing1icon', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing1heading.
    $name = 'theme_evoke/marketing1heading';
    $title = get_string('marketing1heading', 'theme_evoke');
    $description = get_string('marketing1headingdesc', 'theme_evoke');
    $default = 'We host';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing1subheading.
    $name = 'theme_evoke/marketing1subheading';
    $title = get_string('marketing1subheading', 'theme_evoke');
    $description = get_string('marketing1subheadingdesc', 'theme_evoke');
    $default = 'your MOODLE';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing1content.
    $name = 'theme_evoke/marketing1content';
    $title = get_string('marketing1content', 'theme_evoke');
    $description = get_string('marketing1contentdesc', 'theme_evoke');
    $default = 'Moodle hosting in a powerful cloud infrastructure';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing1url.
    $name = 'theme_evoke/marketing1url';
    $title = get_string('marketing1url', 'theme_evoke');
    $description = get_string('marketing1urldesc', 'theme_evoke');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing2icon.
    $name = 'theme_evoke/marketing2icon';
    $title = get_string('marketing2icon', 'theme_evoke');
    $description = get_string('marketing2icondesc', 'theme_evoke');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing2icon', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing2heading.
    $name = 'theme_evoke/marketing2heading';
    $title = get_string('marketing2heading', 'theme_evoke');
    $description = get_string('marketing2headingdesc', 'theme_evoke');
    $default = 'Consulting';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing2subheading.
    $name = 'theme_evoke/marketing2subheading';
    $title = get_string('marketing2subheading', 'theme_evoke');
    $description = get_string('marketing2subheadingdesc', 'theme_evoke');
    $default = 'for your company';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing2content.
    $name = 'theme_evoke/marketing2content';
    $title = get_string('marketing2content', 'theme_evoke');
    $description = get_string('marketing2contentdesc', 'theme_evoke');
    $default = 'Moodle consulting and training for you';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing2url.
    $name = 'theme_evoke/marketing2url';
    $title = get_string('marketing2url', 'theme_evoke');
    $description = get_string('marketing2urldesc', 'theme_evoke');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing3icon.
    $name = 'theme_evoke/marketing3icon';
    $title = get_string('marketing3icon', 'theme_evoke');
    $description = get_string('marketing3icondesc', 'theme_evoke');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing3icon', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing3heading.
    $name = 'theme_evoke/marketing3heading';
    $title = get_string('marketing3heading', 'theme_evoke');
    $description = get_string('marketing3headingdesc', 'theme_evoke');
    $default = 'Development';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing3subheading.
    $name = 'theme_evoke/marketing3subheading';
    $title = get_string('marketing3subheading', 'theme_evoke');
    $description = get_string('marketing3subheadingdesc', 'theme_evoke');
    $default = 'themes and plugins';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing3content.
    $name = 'theme_evoke/marketing3content';
    $title = get_string('marketing3content', 'theme_evoke');
    $description = get_string('marketing3contentdesc', 'theme_evoke');
    $default = 'We develop themes and plugins as your desires';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing3url.
    $name = 'theme_evoke/marketing3url';
    $title = get_string('marketing3url', 'theme_evoke');
    $description = get_string('marketing3urldesc', 'theme_evoke');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing4icon.
    $name = 'theme_evoke/marketing4icon';
    $title = get_string('marketing4icon', 'theme_evoke');
    $description = get_string('marketing4icondesc', 'theme_evoke');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing4icon', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing4heading.
    $name = 'theme_evoke/marketing4heading';
    $title = get_string('marketing4heading', 'theme_evoke');
    $description = get_string('marketing4headingdesc', 'theme_evoke');
    $default = 'Support';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing4subheading.
    $name = 'theme_evoke/marketing4subheading';
    $title = get_string('marketing4subheading', 'theme_evoke');
    $description = get_string('marketing4subheadingdesc', 'theme_evoke');
    $default = 'we give you answers';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing4content.
    $name = 'theme_evoke/marketing4content';
    $title = get_string('marketing4content', 'theme_evoke');
    $description = get_string('marketing4contentdesc', 'theme_evoke');
    $default = 'MOODLE specialized support';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing4url.
    $name = 'theme_evoke/marketing4url';
    $title = get_string('marketing4url', 'theme_evoke');
    $description = get_string('marketing4urldesc', 'theme_evoke');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Enable or disable Slideshow settings.
    $name = 'theme_evoke/sliderenabled';
    $title = get_string('sliderenabled', 'theme_evoke');
    $description = get_string('sliderenableddesc', 'theme_evoke');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $page->add($setting);

    // Enable slideshow on frontpage guest page.
    $name = 'theme_evoke/sliderfrontpage';
    $title = get_string('sliderfrontpage', 'theme_evoke');
    $description = get_string('sliderfrontpagedesc', 'theme_evoke');
    $default = 0;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $page->add($setting);

    $name = 'theme_evoke/slidercount';
    $title = get_string('slidercount', 'theme_evoke');
    $description = get_string('slidercountdesc', 'theme_evoke');
    $default = 1;
    $options = array();
    for ($i = 0; $i < 13; $i++) {
        $options[$i] = $i;
    }
    $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // If we don't have an slide yet, default to the preset.
    $slidercount = get_config('theme_evoke', 'slidercount');

    if (!$slidercount) {
        $slidercount = 1;
    }

    for ($sliderindex = 1; $sliderindex <= $slidercount; $sliderindex++) {
        $fileid = 'sliderimage' . $sliderindex;
        $name = 'theme_evoke/sliderimage' . $sliderindex;
        $title = get_string('sliderimage', 'theme_evoke');
        $description = get_string('sliderimagedesc', 'theme_evoke');
        $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_evoke/slidertitle' . $sliderindex;
        $title = get_string('slidertitle', 'theme_evoke');
        $description = get_string('slidertitledesc', 'theme_evoke');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
        $page->add($setting);

        $name = 'theme_evoke/slidercap' . $sliderindex;
        $title = get_string('slidercaption', 'theme_evoke');
        $description = get_string('slidercaptiondesc', 'theme_evoke');
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $page->add($setting);
    }

    // Enable or disable Slideshow settings.
    $name = 'theme_evoke/numbersfrontpage';
    $title = get_string('numbersfrontpage', 'theme_evoke');
    $description = get_string('numbersfrontpagedesc', 'theme_evoke');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $page->add($setting);

    // Enable sponsors on frontpage guest page.
    $name = 'theme_evoke/sponsorsfrontpage';
    $title = get_string('sponsorsfrontpage', 'theme_evoke');
    $description = get_string('sponsorsfrontpagedesc', 'theme_evoke');
    $default = 0;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $page->add($setting);

    $name = 'theme_evoke/sponsorstitle';
    $title = get_string('sponsorstitle', 'theme_evoke');
    $description = get_string('sponsorstitledesc', 'theme_evoke');
    $default = get_string('sponsorstitledefault', 'theme_evoke');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_evoke/sponsorssubtitle';
    $title = get_string('sponsorssubtitle', 'theme_evoke');
    $description = get_string('sponsorssubtitledesc', 'theme_evoke');
    $default = get_string('sponsorssubtitledefault', 'theme_evoke');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_evoke/sponsorscount';
    $title = get_string('sponsorscount', 'theme_evoke');
    $description = get_string('sponsorscountdesc', 'theme_evoke');
    $default = 1;
    $options = array();
    for ($i = 0; $i < 5; $i++) {
        $options[$i] = $i;
    }
    $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // If we don't have an slide yet, default to the preset.
    $sponsorscount = get_config('theme_evoke', 'sponsorscount');

    if (!$sponsorscount) {
        $sponsorscount = 1;
    }

    for ($sponsorsindex = 1; $sponsorsindex <= $sponsorscount; $sponsorsindex++) {
        $fileid = 'sponsorsimage' . $sponsorsindex;
        $name = 'theme_evoke/sponsorsimage' . $sponsorsindex;
        $title = get_string('sponsorsimage', 'theme_evoke');
        $description = get_string('sponsorsimagedesc', 'theme_evoke');
        $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_evoke/sponsorsurl' . $sponsorsindex;
        $title = get_string('sponsorsurl', 'theme_evoke');
        $description = get_string('sponsorsurldesc', 'theme_evoke');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
        $page->add($setting);
    }

    // Enable clients on frontpage guest page.
    $name = 'theme_evoke/clientsfrontpage';
    $title = get_string('clientsfrontpage', 'theme_evoke');
    $description = get_string('clientsfrontpagedesc', 'theme_evoke');
    $default = 0;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $page->add($setting);

    $name = 'theme_evoke/clientstitle';
    $title = get_string('clientstitle', 'theme_evoke');
    $description = get_string('clientstitledesc', 'theme_evoke');
    $default = get_string('clientstitledefault', 'theme_evoke');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_evoke/clientssubtitle';
    $title = get_string('clientssubtitle', 'theme_evoke');
    $description = get_string('clientssubtitledesc', 'theme_evoke');
    $default = get_string('clientssubtitledefault', 'theme_evoke');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $name = 'theme_evoke/clientscount';
    $title = get_string('clientscount', 'theme_evoke');
    $description = get_string('clientscountdesc', 'theme_evoke');
    $default = 1;
    $options = array();
    for ($i = 0; $i < 5; $i++) {
        $options[$i] = $i;
    }
    $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // If we don't have an slide yet, default to the preset.
    $clientscount = get_config('theme_evoke', 'clientscount');

    if (!$clientscount) {
        $clientscount = 1;
    }

    for ($clientsindex = 1; $clientsindex <= $clientscount; $clientsindex++) {
        $fileid = 'clientsimage' . $clientsindex;
        $name = 'theme_evoke/clientsimage' . $clientsindex;
        $title = get_string('clientsimage', 'theme_evoke');
        $description = get_string('clientsimagedesc', 'theme_evoke');
        $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_evoke/clientsurl' . $clientsindex;
        $title = get_string('clientsurl', 'theme_evoke');
        $description = get_string('clientsurldesc', 'theme_evoke');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
        $page->add($setting);
    }

    $settings->add($page);

    // Forum page.
    $settingpage = new admin_settingpage('theme_evoke_forum', get_string('forumsettings', 'theme_evoke'));

    $settingpage->add(new admin_setting_heading('theme_evoke_forumheading', null,
            format_text(get_string('forumsettingsdesc', 'theme_evoke'), FORMAT_MARKDOWN)));

    // Enable custom template.
    $name = 'theme_evoke/forumcustomtemplate';
    $title = get_string('forumcustomtemplate', 'theme_evoke');
    $description = get_string('forumcustomtemplatedesc', 'theme_evoke');
    $default = 0;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settingpage->add($setting);

    // Header setting.
    $name = 'theme_evoke/forumhtmlemailheader';
    $title = get_string('forumhtmlemailheader', 'theme_evoke');
    $description = get_string('forumhtmlemailheaderdesc', 'theme_evoke');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $settingpage->add($setting);

    // Footer setting.
    $name = 'theme_evoke/forumhtmlemailfooter';
    $title = get_string('forumhtmlemailfooter', 'theme_evoke');
    $description = get_string('forumhtmlemailfooterdesc', 'theme_evoke');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $settingpage->add($setting);

    $settings->add($settingpage);

    // Evoke page.
    $settingpage = new admin_settingpage('theme_evoke_evoke', get_string('evokesettings', 'theme_evoke'));

    // H5P custom CSS.
    $setting = new admin_setting_configtextarea('theme_evoke/hvpcss', get_string('hvpcss', 'theme_evoke'), get_string('hvpcss_desc', 'theme_evoke'), '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settingpage->add($setting);

    $settings->add($settingpage);
}
