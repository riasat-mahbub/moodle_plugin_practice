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
 * @package   local_message
 * @copyright 2020, Riasat Mahbub <riasat.mahbub@brainstation-23.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/message/classes/form/edit_form.php');
global $DB;

$actionUrl = new moodle_url('/local/message/edit.php');

$PAGE->set_url($actionUrl);
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('edit_msg', 'local_message'));

$mform = new edit_form($actionUrl);

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
  //Handle form cancel operation, if cancel button is present on form

  redirect($CFG->wwwroot . '/local/message/manage.php', get_string('cancel_form', 'local_message'));
} else if ($fromform = $mform->get_data()) {
  //In this case you process validated data. $mform->get_data() returns data posted in form.
  $recordtoinsert = new stdClass();
  $recordtoinsert->messagetext = $fromform->messagetext;
  $recordtoinsert->messagetype = $fromform->messagetype;

  $DB->insert_record('local_message', $recordtoinsert);
  redirect($CFG->wwwroot . '/local/message/manage.php', get_string('create_form', 'local_message'). $fromform->messagetext);
}
echo $OUTPUT->header();

$mform->display();

echo $OUTPUT->footer();