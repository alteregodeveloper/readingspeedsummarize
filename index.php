<?php

/**
 * @package   block_readingspeedsummarize
 * @copyright 2019, alterego developer {@link https://alteregodeveloper.github.io}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once('lib.php');

$courseid = required_param('id', PARAM_INT);

$url = new moodle_url('/blocks/readingspeedsummarize/index.php', array('id'=>$courseid));
$PAGE->set_url($url);
$PAGE->set_pagelayout('admin');

if (!$course = $DB->get_record('course', array('id'=>$courseid))) {
    print_error('invalidcourse');
}

require_login($course);

$context = context_course::instance($course->id);
$pluginname = get_string('readingspeedsummarize', 'block_readingspeedsummarize');

$PAGE->set_title($course->shortname .': '. $pluginname);
$PAGE->set_heading($course->fullname);
$PAGE->set_pagetype('course-view-' . $course->format);
$PAGE->add_body_class('path-user');
$PAGE->set_other_editing_capability('moodle/course:manageactivities');
echo $OUTPUT->header();
echo '<h2><img src="' . $CFG->wwwroot . '/blocks/readingspeedsummarize/pix/icon.png" /> ' . $pluginname . '</h2>';

$activities = get_readingtest($USER->id,$courseid);
$results = get_resultspeed_avg($USER->id,$courseid);

$chart = new \core\chart_line();
$chart->set_smooth(true);
$serie = new \core\chart_series('Results', $results);
$chart->add_series($serie);
$chart->set_labels($activities);
echo $OUTPUT->render($chart);

echo $OUTPUT->footer();