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
 * JavaScript library for the pairwork module.
 *
 * @package    mod
 * @subpackage pairwork
 * @copyright  2015 Flash Gordon http://www.flashgordon.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

M.mod_pairwork = M.mod_pairwork || {};

M.mod_pairwork.helper = {
	gY: null,


	 /**
     * @param Y the YUI object
     * @param opts an array of options
     */
    init: function(Y,opts) {
    	
    	M.mod_pairwork.helper.gY = Y;
    	console.log(opts['someinstancesetting']);
    
    }
};
