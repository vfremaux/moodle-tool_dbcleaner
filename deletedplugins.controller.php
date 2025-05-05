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
 * Deleted components removal
 *
 * @package    tool_dbcleaner
 * @copyright  2016 Valery Fremaux (valery.fremaux@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class dbcleaner_deletedplugins_controller {

    protected $data;

    public function receive($cmd, $data = null) {

        $this->data = new StdClass;
        switch ($cmd) {
            case 'cleanup': {
                $this->data->plugin = optional_param('plugin', '', PARAM_TEXT);
            }
        }

    }

    public function process($cmd, $args = null) {
        global $DB;

        if ($cmd == 'cleanup') {

            $pluginlist = dbcleaner_component::get_missing_plugins_from_versions();

            $results = array();

            if (!empty($this->data->plugin)) {
                // Clean just one plugin.
                $parts = explode('_', $this->data->plugin);
                $ptype = array_shift($parts);
                $pname = implode('_', $parts);
                if (array_key_exists($ptype, $pluginlist) && array_key_exists($pname, $pluginlist[$ptype])) {
                    // Verify and confirm the plugin is in missing list.
                    dbcleaner_component::clean_plugin($ptype, $pname);
                    $results[] = get_string('plugincleaned', 'tool_dbcleaner', "{$ptype}_{$pname}");
                }
            } else {
                // Clean them all.
                if (!empty($pluginlist)) {
                    foreach ($pluginlist as $ptype => $plugins) {
                        foreach ($plugins as $pname => $foopath) {
                            dbcleaner_component::clean_plugin($ptype, $pname);
                            $results[] = get_string('plugincleaned', 'tool_dbcleaner', "{$ptype}_{$pname}");
                        }
                    }
                }
            }
        }
        return $results;
    }
}