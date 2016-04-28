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
 * pairwork module admin settings and defaults
 *
 * @package    mod
 * @subpackage pairwork
 * @copyright  2015 Flash Gordon http://www.flashgordon.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
require_once($CFG->dirroot.'/mod/pairwork/lib.php');

if ($ADMIN->fulltree) {

		$settings->add(new admin_setting_configcheckbox(MOD_PAIRWORK_FRANKY . '/enablereset',
  get_string('enablereset', MOD_PAIRWORK_LANG), 
  get_string('enablereset_desc',MOD_PAIRWORK_LANG),'0'));
  
  	$settings->add(new admin_setting_configcheckbox(MOD_PAIRWORK_FRANKY . '/enablereports',
  get_string('enablereports', MOD_PAIRWORK_LANG), 
  get_string('enablereports_desc',MOD_PAIRWORK_LANG),'0'));

	  $settings->add(new admin_setting_configtext('mod_pairwork/someadminsetting',
        get_string('someadminsetting', 'pairwork'), get_string('someadminsetting_details', MOD_PAIRWORK_LANG), 'default text', PARAM_TEXT));

}
