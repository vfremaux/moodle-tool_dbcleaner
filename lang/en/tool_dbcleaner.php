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

$string['cachedef_cleanmap'] = 'DB Cleaning mapping';
$string['pluginname'] = 'Database cleaner';
$string['dbcleaner'] = 'Database cleaner tool';
$string['pluginnamestr'] = 'Plugin';
$string['path'] = 'Install path';
$string['sourcetable'] = 'Table';
$string['sourcefield'] = 'Field';
$string['remotekeytable'] = 'Remote Key Table';
$string['remotekeyfield'] = 'Remote Key Field';
$string['simulate'] = 'Simulate';
$string['scan'] = 'Examine the database';
$string['cleandb'] = 'Cleanup bad data in database';
$string['goback'] = 'Cancel';
$string['purging'] = 'Deleting orphan records from {$a}';
$string['purgingrecursive'] = 'Deleting {$a->q} recursive orphan records from {$a->src}';
$string['evaluating'] = 'Found {$a->q} orphans in table {$a->t} -- Table Corruption : {$a->cr}%';
$string['addkey'] = 'Add one foreign key definition';
$string['recheck'] = 'Check again';
$string['cleanup'] = 'Clean out';
$string['deletedplugins'] = 'Deleted plugins';
$string['nomissingplugins'] = 'No plugin is missing';
$string['cleanupplugins'] = 'Delete all removed plugins configuration';
$string['deletedplugins_desc'] = 'Scans for deleted plugins and removes all configuration and other standard DB entries';
$string['fkeys'] = 'Delete corrupted orphan records';
$string['fkeys_desc'] = 'Scans the data model for referenced record known depenencies, and delete all orphan records with corrupted foreign key values';
$string['fromcomponentmanager'] = 'From the component manager';
$string['fromversionrecords'] = 'From version records in plugin configuration';
