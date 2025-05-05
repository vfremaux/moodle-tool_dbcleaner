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
require_once($CFG->dirroot.'/admin/tool/dbcleaner/forms/purgelogs_form.php');
require_once($CFG->libdir.'/adminlib.php');

$url = new moodle_url('/admin/tool/dbcleaner/purgelogs.php');

$PAGE->set_url($url);

require_login();
admin_externalpage_setup('tooldbcleaner');

$params = ['component' => 'tool_dbcleaner', 'classname' => '\\tool_dbcleaner\\task\\purgelogs_task'];
$isrunning = $DB->record_exists('task_adhoc', $params);

$mform = new PurgeLogs_Form($url, ['isrunning' => $isrunning]);

if ($mform->is_cancelled()) {
    $returnurl = new moodle_url('/admin/tool/dbcleaner/index.php');
    redirect($returnurl);
}

if ($data = $mform->get_data()) {

    if (!empty($data->cancelactive)) {
        // Delete all records related to purge logs.
        $params = ['component' => 'tool_dbcleaner', 'classname' => '\\tool_dbcleaner\\task\\purgelogs_task'];
        $DB->delete_records('task_adhoc', $params);
    } else {

        // PLace a new adhoc task.
        $task = new \tool_dbcleaner\task\purgelogs_task();
        $task->set_userid($USER->id);
        unset($data->submitbutton);
        $task->set_custom_data($data);
        $task->set_component('tool_dbcleaner');
        $task->set_next_run_time(time() + (15 * (int) MINSECS));
        \core\task\manager::queue_adhoc_task($task);
    }
    $returnurl = new moodle_url('/admin/tool/dbcleaner/index.php');
    redirect($returnurl);
}

$PAGE->set_pagelayout('admin');

$renderer = $PAGE->get_renderer('tool_dbcleaner');

// Otherwise display the settings form.
echo $OUTPUT->header();

$mform->display();

echo $OUTPUT->footer();
