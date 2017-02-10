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
 * @category   tool
 * @copyright  2010 David Mudrak <david.mudrak@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->libdir.'/formslib.php');

class ForeignKey_Form extends moodleform {


    function definition() {
        $mform = $this->_form;

        $mform->addElement('text', 'sourcetable', get_string('sourcetable', 'tool_dbcleaner'), '', array('size' => 32));
        $mform->setType('sourcetable', PARAM_TEXT);

        $mform->addElement('text', 'sourcefield', get_string('sourcefield', 'tool_dbcleaner'), '', array('size' => 32));
        $mform->setType('sourcefield', PARAM_TEXT);

        $mform->addElement('text', 'remotekeytable', get_string('remotekeytable', 'tool_dbcleaner'), '', array('size' => 32));
        $mform->setType('remotekeytable', PARAM_TEXT);

        $mform->addElement('text', 'remotekeyfield', get_string('remotekeyfield', 'tool_dbcleaner'), '', array('size' => 32));
        $mform->setType('remotekeyfield', PARAM_TEXT);

        $this->add_action_buttons(true);

    }

}

