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
 * Language customization report upgrades
 *
 * @package    tool_dbcleaner
 * @category   tool
 * @copyright  2010 David Mudrak <david.mudrak@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require('../../../config.php');
require_once($CFG->dirroot.'/admin/tool/dbcleaner/forms/foreignkey_form.php');
require_once($CFG->dirroot.'/admin/tool/dbcleaner/lib.php');

$confirm = optional_param('confirm', 0, PARAM_BOOL);
$systemcontext = context_system::instance();

require_login();
require_sesskey();

$url = new moodle_url('/admin/tool/dbcleaner/addkey.php');
$PAGE->set_url($url);
$PAGE->set_context($systemcontext);

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('cleandb', 'tool_dbcleaner'));

// Get all keys.
$cache = cache::make('tool_dbcleaner', 'cleanmap');
$cleanmaptable = $cache->get('cleanmapdata');
if (empty($cleanmaptable)) {
    dbcleaner_component::get_update_cache();
}

if ($confirm) {
    if ($cleanmaptable) {
        echo $OUTPUT->heading(get_string('process', 'tool_dbcleaner'), 3);
        echo '<pre>';
        foreach ($cleanmaptable as $key) {
            $str = '';
            tool_dbcleaner_clean_key($key, $str);
            echo $str;
        }
        echo '</pre>';
    }
} else {
    if ($cleanmaptable) {
        echo $OUTPUT->heading(get_string('simulate', 'tool_dbcleaner'), 3);
        $badkeycount = 0;
        $allkeycount = 0;
        echo '<pre>';
        $badkey = 0;
        foreach ($cleanmaptable as $key) {
            $str = '';
            $badkey = tool_dbcleaner_clean_key($key, $str, true);
            $allkeycount++;
            if ($badkey) {
                $badkeycount++;
                echo '<span class="error">'.$str.'</span>';
            } else {
                echo $str;
            }
        }
        echo '</pre>';

        if ($allkeycount) {
            echo "Corruption : ".(sprintf('%.2f', $badkeycount/$allkeycount*100));
        }
    }
}

if (!$confirm) {
    echo '<center>';
    echo $OUTPUT->single_button(new moodle_url('/admin/tool/dbcleaner/process.php', array('confirm' => 1, 'sesskey' => sesskey())), get_string('confirm', 'tool_dbcleaner'));
    echo '</center>';
} else {
    echo '<center>';
    echo $OUTPUT->single_button(new moodle_url('/admin/tool/dbcleaner/process.php', array('confirm' => 0, 'sesskey' => sesskey())), get_string('recheck', 'tool_dbcleaner'));
    echo '</center>';
}

echo '<center>';
echo $OUTPUT->single_button(new moodle_url('/admin/tool/dbcleaner/index.php'), get_string('goback', 'tool_dbcleaner'));
echo '</center>';

echo $OUTPUT->footer();