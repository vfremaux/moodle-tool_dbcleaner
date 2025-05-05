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

$action = optional_param('what', false, PARAM_TEXT);
$url = new moodle_url('/admin/tool/dbcleaner/fkeys.php');

$PAGE->set_url($url);

require_login();
admin_externalpage_setup('tooldbcleaner');

require_once($CFG->dirroot.'/admin/tool/dbcleaner/lib.php');
require_once($CFG->dirroot.'/admin/tool/dbcleaner/fkeys.controller.php');

if (!empty($action)) {
    $controller = new dbcleaner_fkeys_controller();
    $id = optional_param('id', null, PARAM_INT);
    $controller->process($action, array($id));
}

$PAGE->set_pagelayout('admin');

$keylist = dbcleaner_component::get_update_cache();

$renderer = $PAGE->get_renderer('tool_dbcleaner');

// Otherwise display the settings form.
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('dbcleaner', 'tool_dbcleaner'));

echo $renderer->addkey_link();

echo $renderer->keylist($keylist);

echo $renderer->addkey_link();

echo '<center>';
echo $OUTPUT->single_button(new moodle_url('/admin/tool/dbcleaner/process.php', ['confirm' => 0, 'sesskey' => sesskey()]), get_string('scan', 'tool_dbcleaner'));
echo '</center>';

echo $OUTPUT->footer();
