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

defined('MOODLE_INTERNAL') || die();

/**
 * Language customization report upgrades
 *
 * @package    tool_dbcleaner
 */
require_once($CFG->libdir.'/formslib.php');

class PurgeLogs_Form extends moodleform {

    function definition() {
        $mform = $this->_form;

        if (empty($this->_customdata['isrunning'])) {
            $select = [
                '*' => get_string('allorigins', 'tool_dbcleaner'),
                'web' => get_string('web', 'tool_dbcleaner'),
                'nonweb' => get_string('nonweb', 'tool_dbcleaner'),
                'cli' => get_string('cli', 'tool_dbcleaner'),
                'restore' => get_string('restore', 'tool_dbcleaner'),
                'ws' => get_string('ws', 'tool_dbcleaner'),
            ];
            $mform->addElement('select', 'origin', get_string('origin', 'tool_dbcleaner'), $select);
            $mform->setDefault('origin', 'nonweb');
            $mform->setType('origin', PARAM_RAW);

            $sizeselect = [
                '10000' => '10k '.get_string('records', 'tool_dbcleaner'),
                '50000' => '50k '.get_string('records', 'tool_dbcleaner'),
                '100000' => '100k '.get_string('records', 'tool_dbcleaner'),
                '500000' => '500k '.get_string('records', 'tool_dbcleaner'),
                '1000000' => '1M '.get_string('records', 'tool_dbcleaner'),
            ];
            $mform->addElement('select', 'bunchsize', get_string('bunchsize', 'tool_dbcleaner'), $sizeselect);
            $mform->setDefault('bunchsize', 100000);
            $mform->setType('bunchsize', PARAM_INT);

            $mform->addElement('date_time_selector', 'until', get_string('until', 'tool_dbcleaner'));
        }

        if (!empty($this->_customdata['isrunning'])) {
            $mform->addElement('static', 'cancelactivedesc', '', get_string('cancelactive_desc', 'tool_dbcleaner'));

            $mform->addElement('checkbox', 'cancelactive', get_string('cancelactive', 'tool_dbcleaner'));
        }

        $this->add_action_buttons(true);

    }

}

