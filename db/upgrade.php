<?php

/**
 * Handles upgrading the page
 *
 * @package    local
 * @subpackage coursenotes
 * @copyright  Mark Nelson <mark@moodle.com.au>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function xmldb_local_coursenotes_upgrade($oldversion) {
    global $CFG, $USER, $DB, $OUTPUT;

    require_once($CFG->libdir.'/db/upgradelib.php'); // Core Upgrade-related functions

    $result = true;

    $dbman = $DB->get_manager(); // loads ddl manager and xmldb classes

    if ($result && $oldversion < 2012052802) {

        $table = new xmldb_table('course_notes');
        $field = new xmldb_field('timecreated', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, null, null, null, 'note');
        $dbman->add_field($table, $field);
        $field = new xmldb_field('timemodified', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, null, null, null, 'timecreated');
        $dbman->add_field($table, $field);

         upgrade_plugin_savepoint($result, 2012052802, 'local', 'coursenotes');
    }

    return $result;
}

?>
