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


defined('MOODLE_INTERNAL') || die();

/**
 * A custom renderer class that extends the plugin_renderer_base.
 *
 * @package mod_pairwork
 * @copyright 2015 Flash Gordon http://www.flashgordon.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_pairwork_renderer extends plugin_renderer_base {



		  /**
     * Returns the header for the module
     *
     * @param mod $instance
     * @param string $currenttab current tab that is shown.
     * @param int    $item id of the anything that needs to be displayed.
     * @param string $extrapagetitle String to append to the page title.
     * @return string
     */
    public function header($moduleinstance, $cm, $currenttab = '', $itemid = null, $extrapagetitle = null) {
        global $CFG;

        $activityname = format_string($moduleinstance->name, true, $moduleinstance->course);
        if (empty($extrapagetitle)) {
            $title = $this->page->course->shortname.": ".$activityname;
        } else {
            $title = $this->page->course->shortname.": ".$activityname.": ".$extrapagetitle;
        }

        // Build the buttons
        $context = context_module::instance($cm->id);

    /// Header setup
        $this->page->set_title($title);
        $this->page->set_heading($this->page->course->fullname);
        $output = $this->output->header();

        if (has_capability('mod/pairwork:manage', $context)) {
          if (!empty($currenttab)) {
                ob_start();
                include($CFG->dirroot.'/mod/pairwork/tabs.php');
                $output .= ob_get_contents();
                ob_end_clean();
            }
        } else {
            $output .= $this->output->heading($activityname);
        }

        return $output;
    }
	
	/**
     * Return HTML to display limited header
     */
      public function notabsheader(){
      	return $this->output->header();
      }
      
         /**
     * Returns the instructions for the view page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_view_instructions() {
    	$html =  $this->output->box_start();
    	$instructions = get_string('view_instructions','pairwork');
    	$html .=  html_writer::div($instructions,MOD_PAIRWORK_CLASS . '_instructions');
    	$html .=  $this->output->box_end();
    	return $html;
    }
    
    /**
     * Returns the buttons at the bottom of the view page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_view_buttons() {

    	$a_url =  new moodle_url('/mod/pairwork/activity.php',array('id'=>$this->page->cm->id,'partnertype'=>'a'));
    	$b_url =  new moodle_url('/mod/pairwork/activity.php',array('id'=>$this->page->cm->id,'partnertype'=>'b'));
    	$html = $this->output->single_button($a_url,get_string('partnera',MOD_PAIRWORK_LANG));
    	$html .= $this->output->single_button($b_url,get_string('partnerb',MOD_PAIRWORK_LANG));
    	return html_writer::div($html,MOD_PAIRWORK_CLASS . '_buttoncontainer');
    }

    /**
     * Returns the buttons at the bottom of the view page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_view_userreport_button() {
        $userreport_url =   new moodle_url('/mod/pairwork/userreport.php',
            array('id'=>$this->page->cm->id));
        $html = $this->output->single_button($userreport_url,
            get_string('userreport',MOD_PAIRWORK_LANG));
        return html_writer::div($html,MOD_PAIRWORK_CLASS . 'userreport_buttoncontainer');
    }



    /**
     * Returns the header for the activity page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_activity_header($moduleinstance,$displayopts) {
	    $html = $this->output->heading($moduleinstance->name, 2, 'main');
        $html .= $this->output->heading(get_string('student_x',MOD_PAIRWORK_LANG ,strtoupper($displayopts->partnertype)), 3, 'main');
        return $html;
    }
     /**
     * Returns the instructions for the activity page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_activity_instructions($moduleinstance,$displayopts) {
    	$html =  $this->output->box_start();
        //$instructions = get_string('defaultinstructions',MOD_PAIRWORK_LANG);
    	if($displayopts->partnertype=='a'){
    		$instructions =$moduleinstance->instructionsa;
    	}else{
    		$instructions =$moduleinstance->instructionsb;
    	}
    	$html .=  html_writer::div($instructions,MOD_PAIRWORK_CLASS . '_instructions');
    	$html .=  $this->output->box_end();
    	return $html;
    }
     /**
     * Returns the picture resource for the activity page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_activity_resource($moduleinstance,$displayopts) {
    	global $CFG;
    	//establish rol
    	if($displayopts->partnertype=='a'){
    		$myrole = 'a';
    		$partnerrole='b';
    	}else{
    		$myrole='b';
    		$partnerrole='a';
    	}
    	//get mypicture
    	$mypicture =  html_writer::img($CFG->wwwroot . '/mod/pairwork/resource/picture_' . $myrole . '.gif',
    		'my picture',array('class'=>MOD_PAIRWORK_CLASS . '_'  . 'resource'));
    	$mypicture = html_writer::div($mypicture, MOD_PAIRWORK_CLASS . '_resourcecontainer');
    	//get partnerpicture
    	$partnerpicture = html_writer::img($CFG->wwwroot . '/mod/pairwork//resource/picture_' . $partnerrole . '.gif',
    		'partner picture',array('class'=>MOD_PAIRWORK_CLASS . '_'  . 'resource'));
    	$partnerpicture = html_writer::div($partnerpicture, MOD_PAIRWORK_CLASS . '_resourcecontainer');
		
		//show mypicture , and maybe partner picture
		$html = $mypicture;
    	if($displayopts->seepartnerpic){
    		$html .= '<br/>' . $partnerpicture;
    	}
    	return $html;
    }
	 /**
     * Returns the buttons at the bottom of the activity page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_activity_buttons($moduleinstance,$displayopts) {
    	
    	//if showhide is false
    	if(!$moduleinstance->showhide){return '';}
    	
    	$partnerpic_visible = $displayopts->seepartnerpic;
    	$pageurl = $this->page->url;
    	$pageurl->params(array('seepartnerpic'=>!($partnerpic_visible),'partnertype'=>$displayopts->partnertype));
    	$actionlabel = get_string('see',MOD_PAIRWORK_LANG);
    	if($partnerpic_visible){$actionlabel = get_string('hide',MOD_PAIRWORK_LANG);}
    	$button = new single_button($pageurl,$actionlabel . get_string('partnerpic',MOD_PAIRWORK_LANG));
    	//$button->add_confirm_action('Do you really want to ' . $actionlabel .' your partners picture?');
    	$buttonhtml = $this->render($button);
    	return html_writer::div($buttonhtml,MOD_PAIRWORK_CLASS . '_'  . 'buttons');
    }


    /**
     * Returns the header for the activity page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_userreport_header($moduleinstance,$displayopts) {
        $html = $this->output->heading($moduleinstance->name, 2, 'main');
        $html .= $this->output->heading(get_string('userreport',MOD_PAIRWORK_LANG), 3, 'main');
        return $html;
    }

    public function fetch_userreport_buttons($moduleinstance,$displayopts)
    {
        $html = '';

        //back button
        $backurl = $this->page->url;
        $hasback = $displayopts->currentpage > 1;
        if ($hasback) {
            $backurl->params(array('currentpage' => $displayopts->currentpage - 1, 'sort' => $displayopts->sort));
            $html .= $this->output->single_button($backurl,get_string('back'));
        }
        //next button
        $nexturl = $this->page->url;
        $hasnext = $displayopts->usercount > ($displayopts->currentpage * $displayopts->perpage);
        if ($hasnext) {
            $nexturl->params(array('currentpage' => $displayopts->currentpage + 1, 'sort' => $displayopts->sort));
            $html .= $this->output->single_button($nexturl,get_string('next'));
        }
        return html_writer::div($html,MOD_PAIRWORK_CLASS . '_userreport_buttoncontainer');
    }

	public function fetch_user_list($moduleinstance, $userdata, $displayopts)
	{
		//set up display fields
		$fields = array('username','firstname','lastname','email');

		//set up our table and head attributes
		$tableattributes = array('class'=>'table table-striped usertable '. MOD_PAIRWORK_CLASS .'_table');
		$headrow_attributes = array('class'=>'success ' . MOD_PAIRWORK_CLASS . '_userreport_headrow');


		$htmltable = new html_table();
		$htmltable->attributes = $tableattributes;


		$htr = new html_table_row();
		$htr->attributes = $headrow_attributes;
		foreach($fields as $field){
            $cellurl = $this->page->url;
            $usesort = $field . ' ASC';
            if($displayopts->sort==$usesort){
                $usesort = $field . ' DESC';
            }
            $cellurl->params(array('sort'=>$usesort));
			$htr->cells[]=new html_table_cell(html_writer::link($cellurl,get_string($field)));
			//$htr->cells[]=new html_table_cell(get_string($field));
		}
		$htmltable->data[]=$htr;

		foreach($userdata as $row){
			$htr = new html_table_row();
			//set up descrption cell
			$cells = array();
			foreach($fields as $field){
				$cell = new html_table_cell($row->{$field});
				$cell->attributes= array('class'=>MOD_PAIRWORK_CLASS . '_userreport_cell_' . $field);
				$htr->cells[] = $cell;
			}

			$htmltable->data[]=$htr;
		}
		$html = html_writer::table($htmltable);
		return $html;

	}
    /**
     *
     */
    public function show_something($showtext) {
		$ret = $this->output->box_start();
		$ret .= $this->output->heading($showtext, 4, 'main');
		$ret .= $this->output->box_end();
        return $ret;
    }

	 /**
     *
     */
	public function show_intro($pairwork,$cm){
		$ret = "";
		if (trim(strip_tags($pairwork->intro))) {
			$ret .= $this->output->box_start('mod_introbox');
			$ret .= format_module_intro('pairwork', $pairwork, $cm->id);
			$ret .= $this->output->box_end();
		}
		return $ret;
	}
  
}

class mod_pairwork_report_renderer extends plugin_renderer_base {


	public function render_reportmenu($moduleinstance,$cm) {
		
		$basic = new single_button(
			new moodle_url(MOD_PAIRWORK_URL . '/reports.php',array('report'=>'basic','id'=>$cm->id,'n'=>$moduleinstance->id)), 
			get_string('basicreport',MOD_PAIRWORK_LANG), 'get');

		$ret = html_writer::div($this->render($basic) .'<br />'  ,MOD_PAIRWORK_CLASS  . '_listbuttons');

		return $ret;
	}

	public function render_delete_allattempts($cm){
		$deleteallbutton = new single_button(
				new moodle_url(MOD_PAIRWORK_URL . '/manageattempts.php',array('id'=>$cm->id,'action'=>'confirmdeleteall')), 
				get_string('deleteallattempts',MOD_PAIRWORK_LANG), 'get');
		$ret =  html_writer::div( $this->render($deleteallbutton) ,MOD_PAIRWORK_CLASS  . '_actionbuttons');
		return $ret;
	}

	public function render_reporttitle_html($course,$username) {
		$ret = $this->output->heading(format_string($course->fullname),2);
		$ret .= $this->output->heading(get_string('reporttitle',MOD_PAIRWORK_LANG,$username),3);
		return $ret;
	}

	public function render_empty_section_html($sectiontitle) {
		global $CFG;
		return $this->output->heading(get_string('nodataavailable',MOD_PAIRWORK_LANG),3);
	}
	
	public function render_exportbuttons_html($cm,$formdata,$showreport){
		//convert formdata to array
		$formdata = (array) $formdata;
		$formdata['id']=$cm->id;
		$formdata['report']=$showreport;
		/*
		$formdata['format']='pdf';
		$pdf = new single_button(
			new moodle_url(MOD_PAIRWORK_URL . '/reports.php',$formdata),
			get_string('exportpdf',MOD_PAIRWORK_LANG), 'get');
		*/
		$formdata['format']='csv';
		$excel = new single_button(
			new moodle_url(MOD_PAIRWORK_URL . '/reports.php',$formdata), 
			get_string('exportexcel',MOD_PAIRWORK_LANG), 'get');

		return html_writer::div( $this->render($excel),MOD_PAIRWORK_CLASS  . '_actionbuttons');
	}
	

	
	public function render_section_csv($sectiontitle, $report, $head, $rows, $fields) {

        // Use the sectiontitle as the file name. Clean it and change any non-filename characters to '_'.
        $name = clean_param($sectiontitle, PARAM_FILE);
        $name = preg_replace("/[^A-Z0-9]+/i", "_", trim($name));
		$quote = '"';
		$delim= ",";//"\t";
		$newline = "\r\n";

		header("Content-Disposition: attachment; filename=$name.csv");
		header("Content-Type: text/comma-separated-values");

		//echo header
		$heading="";	
		foreach($head as $headfield){
			$heading .= $quote . $headfield . $quote . $delim ;
		}
		echo $heading. $newline;
		
		//echo data rows
        foreach ($rows as $row) {
			$datarow = "";
			foreach($fields as $field){
				$datarow .= $quote . $row->{$field} . $quote . $delim ;
			}
			 echo $datarow . $newline;
		}
        exit();
	}

	public function render_section_html($sectiontitle, $report, $head, $rows, $fields) {
		global $CFG;
		if(empty($rows)){
			return $this->render_empty_section_html($sectiontitle);
		}
		
		//set up our table and head attributes
		$tableattributes = array('class'=>'generaltable '. MOD_PAIRWORK_CLASS .'_table');
		$headrow_attributes = array('class'=>MOD_PAIRWORK_CLASS . '_headrow');
		
		$htmltable = new html_table();
		$htmltable->attributes = $tableattributes;
		
		
		$htr = new html_table_row();
		$htr->attributes = $headrow_attributes;
		foreach($head as $headcell){
			$htr->cells[]=new html_table_cell($headcell);
		}
		$htmltable->data[]=$htr;
		
		foreach($rows as $row){
			$htr = new html_table_row();
			//set up descrption cell
			$cells = array();
			foreach($fields as $field){
				$cell = new html_table_cell($row->{$field});
				$cell->attributes= array('class'=>MOD_PAIRWORK_CLASS . '_cell_' . $report . '_' . $field);
				$htr->cells[] = $cell;
			}

			$htmltable->data[]=$htr;
		}
		$html = $this->output->heading($sectiontitle, 4);
		$html .= html_writer::table($htmltable);
		return $html;
		
	}
	
	  /**
       * Returns HTML to display a single paging bar to provide access to other pages  (usually in a search)
       * @param int $totalcount The total number of entries available to be paged through
       * @param stdclass $paging an object containting sort/perpage/pageno fields. Created in reports.php and grading.php
       * @param string|moodle_url $baseurl url of the current page, the $pagevar parameter is added
       * @return string the HTML to output.
       */
    function show_paging_bar($totalcount,$paging,$baseurl){
		$pagevar="pageno";
		//add paging params to url (NOT pageno)
		$baseurl->params(array('perpage'=>$paging->perpage,'sort'=>$paging->sort));
    	return $this->output->paging_bar($totalcount,$paging->pageno,$paging->perpage,$baseurl,$pagevar);
    }
	
	function show_reports_footer($moduleinstance,$cm,$formdata,$showreport){
		// print's a popup link to your custom page
		$link = new moodle_url(MOD_PAIRWORK_URL . '/reports.php',array('report'=>'menu','id'=>$cm->id,'n'=>$moduleinstance->id));
		$ret =  html_writer::link($link, get_string('returntoreports',MOD_PAIRWORK_LANG));
		$ret .= $this->render_exportbuttons_html($cm,$formdata,$showreport);
		return $ret;
	}

}

