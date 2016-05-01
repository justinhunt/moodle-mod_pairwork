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

M.mod_pairwork.ouch = {
	gY: null,
	init: function(Y,opts) {
		console.log('initing ouch');
    	this.gY = Y;
    	this.gY.one('.mod_pairwork_resource').on('click',function(){
    		console.log('ouching');
    		window.alert("Don't touch this cat!!");
    		}
    	);    	 
    }
}

M.mod_pairwork.togglebutton = {
	gY: null,
	init: function(Y,opts) {
		console.log('initing toggling button');
    	this.gY = Y;
    	this.gY.one('.mod_pairwork_togglebutton').on('click',function(){
    		console.log('toggling');
    		var ppic = M.mod_pairwork.togglebutton.gY.one('.mod_pairwork_partnerpiccontainer');
    		ppic.toggleView();
    		ppic.removeClass('hide');
    		}
    	);    	 
    }
}

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
