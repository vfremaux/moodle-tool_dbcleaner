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

class tool_dbcleaner_renderer extends plugin_renderer_base {

    public function keylist($keylist) {
        global $OUTPUT;

        $sourcetablestr = get_string('sourcetable', 'tool_dbcleaner');
        $sourcefieldstr = get_string('sourcefield', 'tool_dbcleaner');
        $remotekeytablestr = get_string('remotekeytable', 'tool_dbcleaner');
        $remotekeyfieldstr = get_string('remotekeyfield', 'tool_dbcleaner');

        $table = new html_table();
        $table->head = array($sourcetablestr, $sourcefieldstr, $remotekeytablestr, $remotekeyfieldstr, '');
        $table->align = array('left', 'left', 'left', 'left', 'left');
        $table->size = array('20%', '20%', '20%', '20%', '20%');

        $cmd = '';
        foreach($keylist as $key) {
            if (!empty($key->id)) {
                $deleteurl = new moodle_url('/admin/tool/dbcleaner/index.php', array('what' => 'delete', 'id' => $key->id));
                $cmd = '<a href="'.$deleteurl.'">'.$OUTPUT->pix_icon('t/delete', get_string('delete')).'</a>';
            }
            $table->data[] = array($key->sourcetable, $key->sourcefield, $key->remotekeytable, $key->remotekeyfield, $cmd);
        }

        return html_writer::table($table);
    }

    public function addkey_link() {
        $str = '<div class="tool-dbcleaner addlink">';
        $addkeyurl = new moodle_url('/admin/tool/dbcleaner/addkey.php', ['sesskey' => sesskey()]);
        $str .= '<a href="'.$addkeyurl.'">'.get_string('addkey', 'tool_dbcleaner').'</a>';
        $str .= '</div>';
        return $str;
    }

    public function missing_plugin_list(&$missingplugins) {

        $pluginstr = get_string('pluginnamestr', 'tool_dbcleaner');

        $template = new StdClass;

        if (empty($missingplugins)) {
            $template->noplugins = $this->output->notification(get_string('nomissingplugins', 'tool_dbcleaner'), 'success');
        } else {
            $table = new html_table();
            $table->head = array($pluginstr, '');
            $table->align = array('left', 'right');
            $table->size = array('60%', '40%');

            foreach ($missingplugins as $plugintype => $typelist) {

                foreach ($typelist as $pname => $path) {
                    $params = ['what' => 'cleanup', 'plugin' => $plugintype.'_'.$pname];
                    $cleanurl = new moodle_url('/admin/tool/dbcleaner/deletedplugins.php', $params);
                    $cleanpluginlink = html_writer::link($cleanurl, get_string('cleanup', 'tool_dbcleaner'));
                    $row = [$plugintype.'_'.$pname, $cleanpluginlink];
                    $table->data[] = $row;
                }
            }
            $template->plugintable = html_writer::table($table);
        }
        return $this->output->render_from_template('tool_dbcleaner/missingplugins', $template);
    }

}