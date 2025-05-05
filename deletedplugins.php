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
 * Data integrity and Cleaner tool
 *
 * @package    tool_dbcleaner
 * @copyright  2016 Valery Fremaux (valery.fremaux@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require('../../../config.php');
require_once($CFG->dirroot.'/admin/tool/dbcleaner/lib.php');
require_once($CFG->libdir.'/adminlib.php');

define('IGNORE_COMPONENT_CACHE', true);

$action = optional_param('what', false, PARAM_TEXT);
$url = new moodle_url('/admin/tool/dbcleaner/deletedplugins.php');

$PAGE->set_url($url);

$systemcontext = context_system::instance();
$PAGE->set_context($systemcontext);

require_login();
require_capability('moodle/site:config', $systemcontext);
admin_externalpage_setup('tooldbcleaner');

require_once($CFG->dirroot.'/admin/tool/dbcleaner/lib.php');
require_once($CFG->dirroot.'/admin/tool/dbcleaner/deletedplugins.controller.php');

if (!empty($action)) {
    $controller = new dbcleaner_deletedplugins_controller();
    $controller->receive($action);
    $results = $controller->process($action);
}

$PAGE->set_pagelayout('admin');

$pluginlist = dbcleaner_component::get_missing_plugins_from_versions();

$renderer = $PAGE->get_renderer('tool_dbcleaner');

// Otherwise display the settings form.
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('deletedplugins', 'tool_dbcleaner'));

if (!empty($results)) {
    echo $OUTPUT->notification('<pre>'.implode("\n", $results).'</pre>', 'success');
}

echo $OUTPUT->heading(get_string('fromversionrecords', 'tool_dbcleaner'), 3);

echo $renderer->missing_plugin_list($pluginlist);

echo '<div class="tool-dbcleaner-form-buttons">';
echo $OUTPUT->single_button(new moodle_url('/admin/tool/dbcleaner/deletedplugins.php', array('what' => 'cleanup', 'sesskey' => sesskey())), get_string('cleanupplugins', 'tool_dbcleaner'));

echo $OUTPUT->single_button(new moodle_url('/admin/tool/dbcleaner/index.php'), get_string('goback', 'tool_dbcleaner'));
echo '</div>';

echo $OUTPUT->footer();
