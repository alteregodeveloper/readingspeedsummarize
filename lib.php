<?php

/**
 * @package   block_readingspeedsummarize
 * @copyright 2019, alterego developer {@link https://alteregodeveloper.github.io}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function get_readingtest($userid,$courseid) {
    global $DB;

    $query = 'SELECT mdl_reading_result.testid FROM mdl_reading_result JOIN mdl_readingspeed ON mdl_readingspeed.id = mdl_reading_result.testid WHERE mdl_reading_result.userid = ' . $userid . ' AND mdl_readingspeed.course = ' . $courseid . ' GROUP BY mdl_reading_result.testid ORDER BY mdl_reading_result.testid';
    $results = $DB->get_records_sql($query);
    $values = array();
    foreach($results as $result) {
        array_push($values,$result->testid);
    }
    return $values;
}

function get_resultspeed_avg($userid,$courseid) {
    global $DB;

    $query = 'SELECT mdl_reading_result.testid AS testid, ROUND(AVG(mdl_reading_result.result),2) AS average FROM mdl_reading_result JOIN mdl_readingspeed ON mdl_readingspeed.id = mdl_reading_result.testid WHERE mdl_reading_result.userid = ' . $userid . ' AND mdl_readingspeed.course = ' . $courseid . ' GROUP BY mdl_reading_result.testid ORDER BY mdl_reading_result.testid';  
    $results = $DB->get_records_sql($query);
    $values = array();
    foreach($results as $result) {
        array_push($values,$result->average);
    }
    return $values;
}