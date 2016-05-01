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
 * Prints the all users page of pairwork
 *
 *
 * @package    mod_pairwork
 * @copyright  2015 Flash Gordon http://www.flashgordon.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');


$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // pairwork instance ID - it should be named as the first character of the module
$sortorder = optional_param('sortorder', 'userid', PARAM_TEXT); // the sort order of the list
$pagecount = optional_param('pagecount', 50, PARAM_INT); // the number of records to show



if ($id) {
    $cm         = get_coursemodule_from_id('pairwork', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $moduleinstance  = $DB->get_record('pairwork', array('id' => $cm->instance), '*', MUST_EXIST);
} elseif ($n) {
    $moduleinstance  = $DB->get_record('pairwork', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $moduleinstance->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('pairwork', $moduleinstance->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

$PAGE->set_url('/mod/pairwork/userreport.php', array('id' => $cm->id));
require_login($course, true, $cm);
$modulecontext = context_module::instance($cm->id);

//Diverge logging logic at Moodle 2.7
if($CFG->version<2014051200){
	add_to_log($course->id, 'pairwork', 'view', "userreport.php?id={$cm->id}", $moduleinstance->name, $cm->id);
}else{
	// Trigger module viewed event.
	$event = \mod_pairwork\event\course_module_viewed::create(array(
	   'objectid' => $moduleinstance->id,
	   'context' => $modulecontext
	));
	$event->add_record_snapshot('course_modules', $cm);
	$event->add_record_snapshot('course', $course);
	$event->add_record_snapshot('pairwork', $moduleinstance);
	$event->trigger();
}

/// Set up the page header
$PAGE->set_title(format_string($moduleinstance->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($modulecontext);
$PAGE->set_pagelayout('course');

	//Get an admin settings 
	$config = get_config(MOD_PAIRWORK_FRANKY);
  	$someadminsetting = $config->someadminsetting;

	//Get an instance setting
	$someinstancesetting = $moduleinstance->someinstancesetting;

$userdata = new stdClass();

//This puts all our display logic into the renderer.php
$renderer = $PAGE->get_renderer('mod_pairwork');


//if we are not a teacher we see no tabs and no report
if(!has_capability('mod/pairwork:preview',$modulecontext)){
	echo $renderer->notabsheader();
	echo get_string('nopermission');
	echo $renderer->footer();

}

$mode = 'userreport';
echo $renderer->header($moduleinstance, $cm, $mode, null, get_string('userreport', MOD_PAIRWORK_LANG));
$displayopts = new stdClass();
echo $renderer->fetch_userreport_header($moduleinstance,$displayopts);
echo $renderer->fetch_user_list($moduleinstance,$userdata, $displayopts);

// Finish the page
echo $renderer->footer();
