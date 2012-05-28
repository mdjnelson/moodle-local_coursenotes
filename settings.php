<?php

/**
 * Create the menu options
 *
 * @package    local
 * @subpackage coursenotes
 * @copyright  Mark Nelson <mark@moodle.com.au>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$ADMIN->add('root', new admin_category('local_hub', get_string('pluginname', 'local_coursenotes')));

$ADMIN->add('local_hub', new admin_externalpage('coursenotes', get_string('menuoption', 'local_coursenotes'),
        $CFG->wwwroot."/local/coursenotes/notes.php",
        'local/coursenotes:add'));

?>
