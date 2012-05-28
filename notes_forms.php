<?php

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/datalib.php');

/**
 * The forms that are used by this plugin
 *
 * @package    local
 * @subpackage coursenotes
 * @copyright  Mark Nelson <mark@moodle.com.au>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class notes_course_search extends moodleform {

    function definition() {
        $mform =& $this->_form;

        $arrgroup = array();
        $arrgroup[] = $mform->createElement('select', 'course', get_string('course'), $this->_customdata['userscourses']);
        $arrgroup[] = $mform->createElement('submit', 'submit', get_string('search', 'local_coursenotes'));
        $mform->addElement('group', 'coursegroup', get_string('course'), $arrgroup, array(' '), false);

        if ($id = optional_param('id', '', PARAM_INT)) {
            $mform->setDefault('course', $id);
        }

        $mform->setType('course', PARAM_INT);
    }
}

class notes_create_note extends moodleform {

    function definition() {
        $mform =& $this->_form;

        $mform->addElement('textarea', 'note', get_string('note', 'local_coursenotes'));
        $mform->setType('note', PARAM_TEXT);
        $mform->addRule('note', get_string('required'), 'required');

        $mform->addElement('submit', 'save', get_string('save', 'local_coursenotes'));
    }

    function validation($data, $files) {
        $errors = parent::validation($data, $files);

        if (empty($data['note'])) {
            $errors['note'] = get_string('noteisrequired', 'local_coursenotes');
        }

        return $errors;
    }
}

?>
