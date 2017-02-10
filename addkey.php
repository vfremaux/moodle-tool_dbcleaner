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

$id = optional_param('id', 0, PARAM_INT);
$systemcontext = context_system::instance();

require_login();
require_sesskey();

$url = new moodle_url('/admin/tool/dbcleaner/addkey.php');
$PAGE->set_url($url);
$PAGE->set_context($systemcontext);

$mform = new ForeignKey_Form();

if ($data = $mform->get_data()) {

    $DB->delete_record('tool_dbcleaner', array('sourcetable' => $data->sourcetable, 'sourcefield' => $data->sourcefield, 'remotekeytable' => $data->remotekeytable, 'remotekeyfield' => $data->remotekeyfield));

    $data->origin = 'custom';
    $DB->insert_record('tool_dbcleaner', $data);

    redirect(new moodle_url('/admin/tool/dbcleaner/index.php'));
}

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('addkey', 'tool_dbcleaner'));

$mform->display();

echo $OUTPUT->footer();
