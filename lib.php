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
require_once($CFG->dirroot.'/admin/tool/dbcleaner/compatlib.php');
require_once($CFG->dirroot.'/admin/tool/dbcleaner/classes/component.class.php');

/**
 * Language customization report upgrades
 *
 * @package    tool_dbcleaner
 * @author      Valery Fremaux <valery.fremaux@gmail.com>
 * @copyright   2016 Valery Fremaux (http://www.mylearningfactory.com)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Cleans out one foreign key.
 * @param object $key foreignkey definition
 * @param stringref &$str for reporting
 * @param bool $simulate
 */
function tool_dbcleaner_clean_key($key, &$str, $simulate = false) {
    global $DB, $OUTPUT;

    $dbman = $DB->get_manager();
    $originalkey = clone($key);

    $table = new xmldb_table($key->sourcetable);

    if (!$dbman->table_exists($table)) {
        return;
    }

    // Special transfer when the dest table is driven by a source field.

    if (strpos($key->sourcefield, '|') !== false) {

        // Composite key.

        /**
         * this is a very special case in which the constraint must be matched on a variable remote table
         */

        list($table, $sourcefield) = explode('|', $key->sourcefield);
        if (preg_match('/^\\((.*)\\)$/', $table, $matches)) {
            // If left field is marked with parenths, the remote ta ble is given by content
            // of this field in ssource table
            $key->remotekeytable = $matches[1];
            $key->sourcefield = $sourcefield;
        }

        if (!$simulate) {
            $checkedrecordset = $DB->get_recordset($key->sourcetable, ['itemtype' => 'mod']);
            $deleted = 0;
            foreach ($checkedrecordset as $record) {
                $remotetable = $record->{$key->remotekeytable};
                $remoteid = $record->{$key->sourcefield};
                if (!$DB->record_exists($remotetable, ['id' => $remoteid])) {
                    $DB->delete_records($key->sourcetable, ['id' => $record->id]);
                    $deleted++;
                }
            }
            $bad = false;
            return $bad;
        } else {
            $checkedrecordset = $DB->get_recordset($key->sourcetable, ['itemtype' => 'mod']);
            $badcount = 0;
            $allcount = 0;
            foreach ($checkedrecordset as $record) {
                $remotetable = $record->{$key->remotekeytable};
                $remoteid = $record->{$key->sourcefield};
                if (!$DB->record_exists($remotetable, ['id' => $remoteid])) {
                    $badcount++;
                }
                $allcount++;
            }
            $e = new StdClass;
            if ($allcount) {
                $e->q = $badcount;
                $e->cr = sprintf('%.3f', ($badcount / $allcount * 100));
                $e->t = $key->sourcetable;
                $e->k = json_encode($originalkey);
                $bad = $e->q;
            } else {
                $e->q = 0;
                $e->cr = '0';
                $e->t = $key->sourcetable;
                $e->k = json_encode($originalkey);
                $bad = false;
            }
            $link = '';
            if ($badcount) {
                $pixicon = $OUTPUT->pix_icon("t/delete", get_string('purgekey', 'tool_dbcleaner'));
                $cleanurl = new moodle_url('', ['singlekey' => $e->k, 'sesskey' => sesskey()]);
                $link = html_writer::link($cleanurl, $pixicon);
            }
            $str .= get_string('evaluating', 'tool_dbcleaner', $e).' '.$link."\n";
            return $bad;
        }
    }

    if (!$simulate) {

        if ($key->sourcetable != $key->remotekeytable) {

            $sql = "
                DELETE FROM
                    {{$key->sourcetable}}
                WHERE
                    {$key->sourcefield} NOT IN
                    (SELECT
                        {$key->remotekeyfield}
                     FROM
                        {{$key->remotekeytable}}) AND
                    {$key->sourcefield} != 0
            ";
            $str .= get_string('purging', 'tool_dbcleaner', $key->sourcetable)."\n";
            $DB->execute($sql);
            $bad = false;
        } else {
            $badrecssql = "
                SELECT
                    src.id
                FROM
                    {{$key->sourcetable}} src
                LEFT JOIN
                    {{$key->remotekeytable}} rem
                ON
                    src.{$key->sourcefield} = rem.{$key->remotekeyfield}
                WHERE
                    src.{$key->sourcefield} != 0 AND
                    rem.{$key->remotekeyfield} IS NULL
            ";
            $badrecs = $DB->get_records_sql($badrecssql);
            if (!empty($badrecs)) {
                $bad = true;
                $e = new Stdclass;
                $e->src = $key->sourcetable;
                $e->q = count($badrecs);
                $str .= get_string('purgingrecursive', 'tool_dbcleaner', $e)."\n";
                $DB->delete_records_list($key->sourcetable, 'id', array_keys($badrecs));
            } else {
                $bad = false;
            }
        }
    } else {
        $sql = "
            SELECT
                COUNT(*) as count
            FROM
                {{$key->sourcetable}} s
            WHERE
                {$key->sourcefield} NOT IN
                (SELECT 
                    d.{$key->remotekeyfield}
                 FROM
                    {{$key->remotekeytable}} d) AND
                s.{$key->sourcefield} != 0
        ";
        $e = new Stdclass();
        $rec = $DB->get_record_sql($sql);
        $e->k = json_encode($key);
        $e->q = $rec->count;
        $e->t = $key->sourcetable;
        $count = $DB->count_records($key->sourcetable);
        if ($count) {
            $e->cr = sprintf('%.3f', ($e->q / $count * 100));
            $bad = $e->q;
        } else {
            $e->cr = '0';
            $bad = false;
        }
        $link = '';
        if ($e->q) {
            $pixicon = $OUTPUT->pix_icon("t/delete", get_string('purgekey', 'tool_dbcleaner'));
            $cleanurl = new moodle_url('', ['singlekey' => $e->k, 'sesskey' => sesskey()]);
            $link = html_writer::link($cleanurl, $pixicon);
        }
        $str .= get_string('evaluating', 'tool_dbcleaner', $e).' '.$link."\n";
    }

    return $bad;
}

