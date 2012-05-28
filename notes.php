<?php

/**
 * The page where the user enters notes for a given course
 *
 * @package    local
 * @subpackage coursenotes
 * @copyright  Mark Nelson <mark@moodle.com.au>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot.'/local/coursenotes/notes_forms.php');

$context = get_system_context();

require_login();
require_capability('local/coursenotes:add', $context);

if ($id = optional_param('id', '', PARAM_INT)) {
    if (!$course = $DB->get_record('course', array('id' => $id))) {
        print_error('invalidcourseid', 'error');
    }
}

if ($id) {
    $PAGE->set_url('/local/coursenotes/notes.php', array('id' => $id));
} else {
    $PAGE->set_url('/local/coursenotes/notes.php');
}
$PAGE->set_pagelayout('admin');
$PAGE->set_context($context);
$PAGE->set_title(get_string('addnotetitle', 'local_coursenotes'));

if (!$userscourses = enrol_get_my_courses()) {
    echo $OUTPUT->header();
    echo $OUTPUT->box(get_string('noavailablecourses', 'local_coursenotes'), 'generalbox', 'notice');
    echo $OUTPUT->footer();
    exit();
}

$arrcourses = array();
foreach($userscourses as $c) {
    $arrcourses[$c->id] = $c->shortname;
}

$search_form = new notes_course_search('', array('userscourses' => $arrcourses));
if ($data = $search_form->get_data()) {
    redirect($CFG->wwwroot.'/local/coursenotes/notes.php?id='.$data->course);
}

if ($id) {
    $notes_form = new notes_create_note($CFG->wwwroot.'/local/coursenotes/notes.php?id='.$id);
    if ($data = $notes_form->get_data()) {
        $time = time();
        if ($note = $DB->get_record('course_notes', array('userid' => $USER->id, 'courseid' => $id))) {
            $note->note = $data->note;
            $note->timemodified = $time;
            $DB->update_record('course_notes', $note);
        } else {
            $note = new stdClass();
            $note->userid = $USER->id;
            $note->courseid = $id;
            $note->note = $data->note;
            $note->timecreated = $time;
            $note->timemodified = $time;
            $DB->insert_record('course_notes', $note);
        }
        $notes_form->set_data($note);
    } else {
        if ($note = $DB->get_record('course_notes', array('userid' => $USER->id, 'courseid' => $id))) {
            $notes_form->set_data($note);
        }
    }
}

echo $OUTPUT->header();
$search_form->display();
if ($id) {
    $notes_form->display();
}
echo $OUTPUT->footer();

?>
