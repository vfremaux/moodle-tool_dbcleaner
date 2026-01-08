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

namespace tool_dbcleaner\task;

use stdClass;
use core\task\adhoc_task;

defined('MOODLE_INTERNAL') || die();

class purgelogs_task extends adhoc_task {

    public function execute() {
        global $DB, $CFG;

        // Raise the time limit for each discussion.
        \core_php_time_limit::raise(120);

        // Purge a bunch of logs
        $taskparams = $this->get_custom_data();

        $filterclause = '';
        $clauses = [];
        switch ($taskparams->origin) {
            case '*': {
                break;
            }
            case 'web': {
                $clauses[] = ' origin = "web" ';
                break;
            }
            case 'cli': {
                $clauses[] = ' origin = "cli" ';
                break;
            }
            case 'restore': {
                $clauses[] = ' origin = "restore" ';
                break;
            }
            case 'ws': {
                $clauses[] = ' origin = "ws" ';
                break;
            }
            case 'nonweb': {
                $clauses[] = ' origin <> "web" ';
                break;
            }
        }

        if (!empty($taskparams->until)) {
            $clauses[] = ' timecreated < ? ';
            $params[] = $taskparams->until;
        }

        $deleteparams = $params;

        $filterclause = implode(' AND ', $clauses);

        $sql = "
            SELECT
                id
            FROM
                {logstore_standard_log}
            WHERE
                {$filterclause}
            ORDER BY
                id
            LIMIT
                1
            OFFSET
                ".($taskparams->bunchsize ?? 100000);

        $lastid = $DB->get_field_sql($sql, $params);

        $idclause = '';
        if ($lastid) {
            $idclause = " AND id < ? ";
            $deleteparams[] = $lastid;
        }

        if ($CFG->debug >= DEBUG_NORMAL) {
            $pre = $this->get_check_counts();
        }

        $sql = "
            DELETE FROM
                {logstore_standard_log}
            WHERE
                {$filterclause}
                {$idclause}
        ";
        $DB->execute($sql, $deleteparams);

        if ($CFG->debug >= DEBUG_NORMAL) {
            $post = $this->get_check_counts();

            $output =  '|         |    pre |    post |    delta  |'."\n";
            $output .= "|     web |  {$pre->web} | {$post->web} | ".($post->web - $pre->web).' |'."\n";
            $output .= "|     cli |  {$pre->cli} | {$post->cli} | ".($post->cli - $pre->cli).' |'."\n";
            $output .= "| restore |    {$pre->restore} | {$post->restore} | ".($post->restore - $pre->restore).' |'."\n";
            $output .= "|      ws |    {$pre->ws} | {$post->ws} | ".($post->ws - $pre->ws).' |'."\n";

            if (defined('CLI_SCRIPT') && CLI_SCRIPT) {
                echo $output;
            } else {
                echo '<pre>'.$output.'</pre>';
            }
        }

        if (!$lastid) {
            // No more bouces we got them all.
            // This will stop the process.
            return true;
        }

        // Now bounce a new task.
        $task = new purgelogs_task();
        $task->set_userid($this->get_userid());
        $task->set_custom_data($taskparams); // Same parameters.
        $task->set_component('tool_dbcleaner');
        $task->set_next_run_time(time() + (2 * 60)); // Bounce every 2 minutes.
        \core\task\manager::queue_adhoc_task($task);
    }

    protected function get_check_counts() {
        global $DB;

        $checksql = "
            SELECT
                origin,
                COUNT(*) as cnt
            FROM
               {logstore_standard_log}
            GROUP BY
                origin
        ";
        $recs = $DB->get_records_sql($checksql);
        $counts = new StdClass;
        if ($recs) {
            foreach ($recs as $rec) {
                if (empty($rec->origin)) {
                    $rec->origin = 'undefined';
                }
                $counts->{$rec->origin} = $rec->cnt;
            }
        }
        if (empty($counts->cli)) {
            $counts->cli = 0;
        }
        if (empty($counts->ws)) {
            $counts->ws = 0;
        }
        if (empty($counts->restore)) {
            $counts->restore = 0;
        }

        return $counts;
    }
}