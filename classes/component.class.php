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

namespace tool_dbcleaner;

/**
 * Output renderer
 *
 * @package    tool_dbcleaner
 * @author      Valery Fremaux <valery.fremaux@gmail.com>
 * @copyright   2016 Valery Fremaux (http://www.mylearningfactory.com)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use stdClass;

/**
 * Component extension
 *
 * @package    tool_dbcleaner
 * @copyright   2016 Valery Fremaux (http://www.mylearningfactory.com)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class component extends \core_component {

    /**
     * Updates the db checker cache with integrity checks as : 
     * [0] => checked table
     * [1] => foreign key to check on checked table
     * [2] => foreign key source table
     * [3] => foreign key field in source table
     * [5] => where restriction in source table to match the foreign key
     */
    public static function get_update_cache() {
        global $DB, $CFG;

        $forummoduleid = $DB->get_field('modules', 'id', array('name' => 'forum'));
        $assignmoduleid = $DB->get_field('modules', 'id',array('name' => 'assign'));
        $surveymoduleid = $DB->get_field('modules', 'id', array('name' => 'survey'));
        $choicemoduleid = $DB->get_field('modules', 'id', array('name' => 'choice'));
        $resourcemoduleid = $DB->get_field('modules', 'id', array('name' => 'resource'));
        $labelmoduleid = $DB->get_field('modules', 'id', array('name' => 'label'));
        $wikimoduleid = $DB->get_field('modules', 'id', array('name' => 'wiki'));
        $quizmoduleid = $DB->get_field('modules', 'id', array('name' => 'quiz'));
        $glossarymoduleid = $DB->get_field('modules', 'id', array('name' => 'glossary'));
        $bookmoduleid = $DB->get_field('modules', 'id', array('name' => 'book'));
        $datamoduleid = $DB->get_field('modules', 'id', array('name' => 'data'));
        $feedbackmoduleid = $DB->get_field('modules', 'id', array('name' => 'feedback'));
        $chatmoduleid = $DB->get_field('modules', 'id', array('name' => 'chat'));
        $foldermoduleid = $DB->get_field('modules', 'id', array('name' => 'folder'));

        $coredefs = array(
            array('course_modules', 'course', 'course', 'id', ''),
            array('course_modules', 'module', 'modules', 'id', ''),
            array('course_modules_completion', 'coursemoduleid', 'course_modules', 'id', ''),
            array('course_modules_completion', 'userid', 'user', 'id', ''),
            array('course_completions', 'course', 'course', 'id', ''),
            array('course_completion_aggr_meth', 'course', 'course', 'id', ''),
            array('course_completion_criteria', 'course', 'course', 'id', ''),
            array('course_completion_criteria', 'module', 'modules', 'id', ''),
            array('course_completion_crit_compl', 'course', 'course', 'id', ''),
            array('course_completion_crit_compl', 'userid', 'user', 'id', ''),
            array('course_completion_crit_compl', 'criteriaid', 'course_completion_criteria', 'id', ''),
            array('course_format_option', 'courseid', 'course', 'id', ''),
            array('course_sections', 'course', 'course', 'id', ''),
            array('block_instances', 'parentcontextid', 'context', 'id', ''),
            array('block_positions', 'blockinstanceid', 'block_instances', 'id', ''),
            array('enrol', 'courseid', 'course', 'id', ''),
            array('user_enrolments', 'enrolid', 'enrol', 'id', ''),
            array('role_capabilities', 'roleid', 'role', 'id', ''),
            array('role_capabilities', 'contextid', 'context', 'id', ''),
            array('role_capabilities', 'capability', 'capabilities', 'name', ''),
            array('role_assignments', 'roleid', 'role', 'id', ''),
            array('role_assignments', 'contextid', 'context', 'id', ''),
            array('mnet_host2service', 'hostid', 'mnet_host', 'id', ''),
            array('mnet_host2service', 'serviceid', 'mnet_service', 'id', ''),
            array('mnet_service2rpc', 'serviceid', 'mnet_service', 'id', ''),
            array('mnet_service2rpc', 'rpcid', 'mnet_rpc', 'id', ''),
            array('mnetservice_enrol_courses', 'hostid', 'mnet_host', 'id', ''),
            array('forum', 'course', 'course', 'id', ''),
            array('forum', 'id', 'course_modules', 'instance', ' module = '.$forummoduleid.' '),
            array('assign', 'course', 'course', 'id', ''),
            array('assign', 'id', 'course_modules', 'instance', ' module = '.$assignmoduleid.' '),
            array('survey', 'course', 'course', 'id', ''),
            array('survey', 'id', 'course_modules', 'instance', ' module = '.$surveymoduleid.' '),
            array('choice', 'course', 'course', 'id', ''),
            array('choice', 'id', 'course_modules', 'instance', ' module = '.$choicemoduleid.' '),
            array('resource', 'course', 'course', 'id', ''),
            array('resource', 'id', 'course_modules', 'instance', ' module = '.$resourcemoduleid.' '),
            array('label', 'course', 'course', 'id', ''),
            array('label', 'id', 'course_modules', 'instance', ' module = '.$labelmoduleid.' '),
            array('wiki', 'course', 'course', 'id', ''),
            array('wiki', 'id', 'course_modules', 'instance', ' module = '.$wikimoduleid.' '),
            array('quiz', 'course', 'course', 'id', ''),
            array('quiz', 'id', 'course_modules', 'instance', ' module = '.$quizmoduleid.' '),
            array('glossary', 'course', 'course', 'id', ''),
            array('glossary', 'id', 'course_modules', 'instance', ' module = '.$glossarymoduleid.' '),
            array('book', 'course', 'course', 'id', ''),
            array('book', 'id', 'course_modules', 'instance', ' module = '.$bookmoduleid.' '),
            array('data', 'course', 'course', 'id', ''),
            array('data', 'id', 'course_modules', 'instance', ' module = '.$datamoduleid.' '),
            array('feedack', 'course', 'course', 'id', ''),
            array('feedback', 'id', 'course_modules', 'instance', ' module = '.$feedbackmoduleid.' '),
            array('chat', 'course', 'course', 'id', ''),
            array('grade_grade', 'userid', 'user', 'id', ''),
            array('grade_grade', 'itemid', 'grade_items', 'id', ''),
            array('grade_items', 'categoryid', 'grade_categories', 'id', ''),
            array('grade_items', 'courseid', 'course', 'id', ''),
            array('grade_items', '(itemmodule)|iteminstance', '$itemmodule', 'id', ''),
            array('grade_outcomes', 'courseid', 'course', 'id', ''),
            array('chat', 'course', 'course', 'id', ''),
            array('chat', 'id', 'course_modules', 'instance', ' module = '.$chatmoduleid.' '),
            array('folder', 'course', 'course', 'id', ''),
            array('folder', 'id', 'course_modules', 'instance', ' module = '.$foldermoduleid.' '),
            // Moodle V4.
            array('question_versions', 'questionid', 'question', 'id', ''),
            array('question_bank_entries', 'questioncategoryid', 'question_categories', 'id', ''),
            array('question_versions', 'questionbankentryid', 'question_bank_entries', 'id', ''),
            array('question_bank_entries', 'id', 'question_versions', 'questionbankentryid', ''),
            array('question_categories', 'parent', 'question_categories', 'id', ''),
            array('question_answers', 'question', 'question', 'id', ''),
            array('question_attempts', 'questionid', 'question', 'id', ''),
            array('question_attempts', 'questionusageid', 'question_usages', 'id', ''),
            array('question_attempt_steps', 'questionattemptid', 'question_attempts', 'id', ''),
            array('question_attempt_steps_data', 'attemptstepid', 'question_attempt_steps', 'id', ''),
            array('question_calculated', 'question', 'question', 'id', ''),
            array('question_calculated_options', 'question', 'question', 'id', ''),
            array('question_datasets', 'question', 'question', 'id', ''),
            array('question_datasets', 'datasetdefinition', 'question_dataset_definitions', 'id', ''),
            array('question_datasets_items', 'definition', 'question_dataset_definitions', 'id', ''),

            array('qtype_multichoice_options', 'questionid', 'question', 'id', ''),
            array('qtype_match_options', 'questionid', 'question', 'id', ''),
            array('qtype_essay_options', 'questionid', 'question', 'id', ''),
            array('qtype_shortanswer_options', 'questionid', 'question', 'id', ''),
            array('qtype_randomamatch_options', 'questionid', 'question', 'id', ''),
         );

        $cleanmaptable = array();
        foreach ($coredefs as $def) {
            $obj = new StdClass();
            $obj->sourcetable = $def[0];
            $obj->sourcefield = $def[1];
            $obj->remotekeytable = $def[2];
            $obj->remotekeyfield = $def[3];
            $obj->remotesqlselect = $def[4];
            $obj->origin = 'core';
            $cleanmaptable[] = $obj;
        }

        $ltcmoduleid = $DB->get_field('modules', 'id', array('name' => 'learningtimecheck'));
        $mplayermoduleid = $DB->get_field('modules', 'id', array('name' => 'mplayer'));
        $schedulermoduleid = $DB->get_field('modules', 'id', array('name' => 'scheduler'));
        $magtestmoduleid = $DB->get_field('modules', 'id', array('name' => 'magtest'));
        $thirdpartydefs = array(
            array('learningtimecheck', 'course', 'course', 'id', ''),
            array('learningtimecheck', 'id', 'course_modules', 'instance', ' module = '.$ltcmoduleid.' '),
            array('mplayer', 'course', 'course', 'id', ''),
            array('mplayer', 'id', 'course_modules', 'instance', ' module = '.$mplayermoduleid.' '),
            array('scheduler', 'course', 'course', 'id', ''),
            array('scheduler', 'id', 'course_modules', 'instance', ' module = '.$schedulermoduleid.' '),
            array('magtest', 'course', 'course', 'id', ''),
            array('magtest', 'id', 'course_modules', 'instance', ' module = '.$magtestmoduleid.' '),
        );

        foreach ($thirdpartydefs as $def) {
            $obj = new StdClass();
            $obj->sourcetable = $def[0];
            $obj->sourcefield = $def[1];
            $obj->remotekeytable = $def[2];
            $obj->remotekeyfield = $def[3];
            $obj->remotesqlselect = $def[4];
            $obj->origin = 'core';
            $cleanmaptable[] = $obj;
        }

        // Scan all components and get the dbcleaner records
        $allcomponents = self::fetch_plugintypes();
        $alltypes = $allcomponents[0];
        foreach ($alltypes as $type => $path) {
            $plugins = self::fetch_plugins($type, $path);
            foreach ($plugins as $pluginname => $fulldir) {
                if (!file_exists($fulldir.'/lib.php')) continue;
                require_once($fulldir.'/lib.php');
                $dbcleanerfunc = $pluginname.'_dbcleaner_add_keys';
                if ($type != 'mod') {
                    $dbcleanerfunc = $type.'_'.$dbcleanerfunc;
                }
                if (function_exists($dbcleanerfunc)) {
                    $defs = $dbcleanerfunc();
                    foreach($defs as $def) {
                        $obj = new StdClass();
                        $obj->sourcetable = $def[0];
                        $obj->sourcefield = $def[1];
                        $obj->remotekeytable = $def[2];
                        $obj->remotekeyfield = $def[3];
                        $obj->remotesqlselect = $def[4];
                        $obj->origin = $type;
                        $cleanmaptable[] = $obj;
                    }
                }
            }
        }

        $extradefs = $DB->get_records('tool_dbcleaner');
        foreach($extradefs as $def) {
            $cleanmaptable[] = $def;
        }

        return $cleanmaptable;
    }

    public static function get_missing_plugins_from_versions() {
        global $DB;

        $missingplugins = array();
        $plugintypes = \core_component::get_plugin_types();

        $versions = $DB->get_records('config_plugins', ['name' => 'version']);
        if ($versions) {
            foreach ($versions as $v) {
                $parts = explode('_', $v->plugin);
                $plugintype = array_shift($parts);
                $pluginname = implode('_', $parts);
                if (array_key_exists($plugintype, $plugintypes)) {
                    $path = \core_component::get_component_directory($v->plugin);
                    if (empty($path) || !is_dir($path)) {
                        $missingplugins[$plugintype][$pluginname] = $path;
                    }
                }
            }
        }

        return $missingplugins;
    }

    /**
     * Cleans all known location with this plugin reference, using core
     * automated uninstal function.
     *
     */
    public static function clean_plugin($ptype, $pname) {
        global $DB;

        uninstall_plugin($ptype, $pname);
    }
}