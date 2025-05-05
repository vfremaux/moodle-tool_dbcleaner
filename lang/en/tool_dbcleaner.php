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
 * Strings for component 'tool_dbcleaner', language 'en'.
 *
 * @package    tool_dbcleaner
 * @copyright  2011 Petr Skoda {@link http://skodak.org/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['privacy:metadata'] = 'The Database Cleaner plugin does not store any personal data.';

$string['addkey'] = 'Add one foreign key definition';
$string['cachedef_cleanmap'] = 'DB Cleaning mapping';
$string['cleandb'] = 'Cleanup bad data in database';
$string['cleanup'] = 'Clean out';
$string['cleanupplugins'] = 'Delete all removed plugins configuration';
$string['dbcleaner'] = 'Database cleaner tool';
$string['deletedplugins'] = 'Deleted plugins';
$string['deletedplugins_desc'] = 'Scans for deleted plugins and removes all configuration and other standard DB entries';
$string['evaluating'] = 'Found {$a->q} orphans in table {$a->t} -- Table Corruption : {$a->cr}%';
$string['fkeys'] = 'Delete corrupted orphan records';
$string['fkeys_desc'] = 'Scans the data model for referenced record known depenencies, and delete all orphan records with corrupted foreign key values';
$string['fromcomponentmanager'] = 'From the component manager';
$string['fromversionrecords'] = 'From version records in plugin configuration';
$string['goback'] = 'Cancel';
$string['nomissingplugins'] = 'No plugin is missing';
$string['path'] = 'Install path';
$string['plugincleaned'] = 'Plugin {$a} cleaned out.';
$string['pluginname'] = 'Database cleaner';
$string['pluginnamestr'] = 'Plugin';
$string['process'] = 'Processing';
$string['purging'] = 'Deleting orphan records from {$a}';
$string['purgingrecursive'] = 'Deleting {$a->q} recursive orphan records from {$a->src}';
$string['purgekey'] = 'Purge this key';
$string['purgelogs'] = 'Purge logs';
$string['purgelogs_desc'] = 'Purges the standard log until some horizon date and on selected origins';
$string['recheck'] = 'Check again';
$string['remotekeyfield'] = 'Remote Key Field';
$string['remotekeytable'] = 'Remote Key Table';
$string['scan'] = 'Examine the database';
$string['simulate'] = 'Simulate';
$string['sourcefield'] = 'Field';
$string['sourcetable'] = 'Table';

$string['cancelactive_desc'] = 'Only one log cleanup task can be active at the same time. If you want to change
the cleaning parameters, you first need to stop the current task, than reschedule a bew task with updated parameters.';
$string['cancelactive'] = 'Cancel the running task. Deleted records will not be restored.';
$string['origin'] = 'Origin';
$string['allorigins'] = 'All origins';
$string['web'] = 'Web';
$string['nonweb'] = 'All but web';
$string['cli'] = 'Cli';
$string['restore'] = 'Restore';
$string['ws'] = 'Webservices';
$string['until'] = 'Until';
$string['records'] = ' records';
$string['bunchsize'] = 'Bunch size';

