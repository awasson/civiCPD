<?php
/*
+--------------------------------------------------------------------+
| CiviCDP version alpha 1.0                                          |
+--------------------------------------------------------------------+
| File: EditReport.php                                               |
+--------------------------------------------------------------------+
| This file is a part of the CiviCPD extension.                      |
|                                                                    |
| This file will respond to requests, providing an editing window    |
| for editing continuing professional development Activities or an   |
| input screen if a new continuing education Activity is required    |
|                                                                    |
+--------------------------------------------------------------------+
*/
require_once 'CRM/Core/Page.php';

class CRM_Civicpd_Page_CPDEditIndividual extends CRM_Core_Page {
  function run() {
  
  	// ADD STYLESHEET
	CRM_Core_Resources::singleton()->addStyleFile('ca.lunahost.civicpd', 'civicpd.css');
	
	// Find the ID of the person viewing this page 
    $session = CRM_Core_Session::singleton();
	$admin_id = $session->get('userID');

	// Find the ID of the person we want to edit
	if(isset($_GET['cid'])) {
    	// id exists
    	$contact_id = $_GET['cid'];
    	$sql = "SELECT civicrm_contact.display_name FROM civicrm_contact WHERE civicrm_contact.id = " . $contact_id;
    	$dao = CRM_Core_DAO::executeQuery($sql);
    	while( $dao->fetch( ) ) {    
    		$display_name = $dao->display_name;
    	}
    	
	} else {
		// id doesn't exist, kick them back to the main report
		header('Location: /civicrm/civicpd/fullreport');
		exit;
	}
  
  	/**
     * PULL THE CPD NAME FOR THE PAGE TITLE
     */
    $sql = "SELECT * FROM civi_cpd_defaults";
    $dao = CRM_Core_DAO::executeQuery($sql);
  	$arr_defaults = array();
    $x = 0;
    while( $dao->fetch( ) ) {   
       	$arr_defaults[$dao->name] = $dao->value;
       	$x++;	
    }
    
    // SET VARIABLES FROM DEFAULTS ARRAY
    if(is_array ($arr_defaults)) {
    	
    	if(isset($arr_defaults['member_update_limit'])) {
    		$member_update_limit = $arr_defaults['member_update_limit'];
    	} else {
    		$member_update_limit = 0;
    	}
    	
    	if(isset($arr_defaults['long_name'])) {
    		$long_name = $arr_defaults['long_name'];
    	} else {
    		$long_name = 'Continuing Professional Development';
    	}
    	
    	if(isset($arr_defaults['short_name'])) {
    		$short_name = $arr_defaults['short_name'];
    	} else {
    		$short_name = 'CPD';
    	}
    	
    } else {
    	$member_update_limit = 0;
    	$long_name = 'Continuing Professional Development';
    	$short_name = 'CPD';
    }
   
   if($_SERVER['REQUEST_METHOD']=='GET') {
	
			if(isset($_GET['action'])) {
		
				$action = $_REQUEST['action'];
				
				// *** Set up some defaults ***	//
				$output = "";
				
				if(isset($_REQUEST['catid'])) {
					$category_id = $_REQUEST['catid'];
				}
				
				// Find the Year we are interested in
				// Default to this year
				if(!isset($_SESSION["report_year"])) {
					$_SESSION["report_year"] = date("Y");
				}
				$this->assign('report_year', $_SESSION["report_year"]); 
				
				$today = $_SESSION["report_year"] . date("-m-j");
				$this->assign('today', $today);
				// *** Set up some defaults *** //
		
				switch ($action) {
  				case 'new':

					// Insert new activity under this category for this contact for this time period.
   					CRM_Utils_System::setTitle(ts('Insert A New ' . $short_name . ' Activity for ' . $display_name));
   					
   					$sql = "SELECT * FROM civi_cpd_categories WHERE id = " . $category_id;
   					$dao = CRM_Core_DAO::executeQuery($sql);
   					
   					while( $dao->fetch( ) ) { 
   						$category = $dao->category;
   					}
   					
   					$output = '<form name="newactivity" method="post" action="/civicrm/civicpd/individual">
  								<input type="hidden" value="insert" name="action">
  								<input type="hidden" value="'.$contact_id.'" name="cid">
  								<input type="hidden" value="'. $category_id .'" name="category_id">
  									<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
    									<tbody>
      										<tr>
        										<td width="5%" valign="top" nowrap="nowrap">Date:</td>
       	 										<td width="60%"><input type="text" class="frm" id="credit_date" name="credit_date" value=' . $today . ' required="required"></td>
      										</tr>
      										<tr>
        										<td width="5%" valign="top" nowrap="nowrap">Activity:</td>
        										<td width="60%" nowrap="nowrap">
          											<table width="100%" cellspacing="0" cellpadding="0" border="0">
            											<tbody>
              												<tr>
                												<td width="64%"><input type="text" size="35" class="frm" name="activity" required="required"></td>
                												<td width="15%" valign="top">Credits:</td>
                												<td><input type="text" maxlength="4" size="4" class="frm" name="credits" required="required"></td>
              												</tr>
            											</tbody>
          											</table>
        										</td>
      										</tr>
      										<tr>
        										<td width="5%" valign="top" nowrap="nowrap">Details:</td>
        										<td width="60%"><textarea class="frm" rows="4" cols="42" name="details"></textarea></td>
      										</tr>
      										<tr>
        										<td width="5%" valign="top" nowrap="nowrap">Notes:</td>
        										<td width="60%"><textarea class="frm" rows="4" cols="42" name="notes"></textarea></td>
      										</tr>
      										<tr>
        										<td align="center"><input type="submit" value="Submit" class="form-submit-inline" name="Submit"></td>
        										<td></td>
      										</tr>
    									</tbody>
  									</table>
								</form>';
					
					$this->assign('sub_title', 'Use the form below to insert a new ' . $long_name . ' <em>' . $category . '</em> activity for ' . $display_name); 
					
					$this->assign('return_button', '<input type="button" name="return" id="return" value="Return to Reporting Page" class="form-submit-inline" onclick="top.location=\'/civicrm/civicpd/individual?cid=' . $contact_id . '&clear\';" />'); 
					
					$this->assign('output', $output);
					
   					break;
   					
   				case 'edit':
  				
					// Edit an existing activity under this category for this contact for this time period.
   					CRM_Utils_System::setTitle(ts('Edit ' . $short_name . ' Activity'));
   					
   					if(isset($_GET['activity_id'])) {
   						$activity_id = $_GET['activity_id'];
   					} else {
   						// No activity_id, nothing to do, so redirect to the admin individual report page
   						$querystring = "/civicrm/civicpd/individual?id=" . $contact_id;
    					header("Location: $querystring");
   					}
   					
   					$sql = "SELECT civi_cpd_categories.category, 
   							civi_cpd_activities.credit_date, 
   							civi_cpd_activities.credits, 
   							civi_cpd_activities.activity, 
   							civi_cpd_activities.details,
   							civi_cpd_activities.notes 
   							FROM civi_cpd_activities 
   							INNER JOIN civi_cpd_categories 
   							ON civi_cpd_categories.id = civi_cpd_activities.category_id 
   							WHERE civi_cpd_activities.id = " . $activity_id;
   							
   					$dao = CRM_Core_DAO::executeQuery($sql);
   					
   					while( $dao->fetch( ) ) { 
   						$category		= $dao->category;
   						$credit_date	= $dao->credit_date;
   						$credits		= $dao->credits;
   						$activity		= $dao->activity;
   						$details		= $dao->details;
   						$notes			= $dao->notes;
   					}

   					
   					while( $dao->fetch( ) ) { 
   						$category = $dao->category;
   					}
   					
   					$output = '<form name="editactivity" method="post" action="/civicrm/civicpd/individual">
  								<input type="hidden" value="update" name="action">
  								<input type="hidden" value="'.$contact_id.'" name="cid">
  								<input type="hidden" value="'. $activity_id .'" name="activity_id">
  									<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
    									<tbody>
      										<tr>
        										<td width="5%" valign="top" nowrap="nowrap">Date:</td>
       	 										<td width="60%"><input type="text" class="frm" id="credit_date" name="credit_date" value=' . $credit_date . ' required="required"></td>
      										</tr>
      										<tr>
        										<td width="5%" valign="top" nowrap="nowrap">Activity:</td>
        										<td width="60%" nowrap="nowrap">
          											<table width="100%" cellspacing="0" cellpadding="0" border="0">
            											<tbody>
              												<tr>
                												<td width="64%"><input type="text" size="35" class="frm" name="activity" value="' . $activity . '" required="required"></td>
                												<td width="15%" valign="top">Credits:</td>
                												<td><input type="text" maxlength="4" size="4" class="frm" name="credits" value="' . $credits . '" required="required"></td>
              												</tr>
            											</tbody>
          											</table>
        										</td>
      										</tr>
      										<tr>
        										<td width="5%" valign="top" nowrap="nowrap">Details:</td>
        										<td width="60%"><textarea class="frm" rows="4" cols="42" name="details">' . $details . '</textarea></td>
      										</tr>
      										<tr>
        										<td width="5%" valign="top" nowrap="nowrap">Notes:</td>
        										<td width="60%"><textarea class="frm" rows="4" cols="42" name="notes">' . $notes . '</textarea></td>
      										</tr>
      										<tr>
        										<td colspan="2">
        											<input type="submit" value="Submit" class="form-submit-inline" name="Submit">
        											<div style="display: inline-block; margin-bottom: -19px; margin-top: 20px;">
														<a title="Delete Activity" class="delete button" href="#">
                										<span><div class="icon delete-icon"></div>Delete Activity</span>
                										</a>
                									</div>
        										</td>
      										</tr>
    									</tbody>
  									</table>
								</form>';
					
					$this->assign('sub_title', 'Use the form below to update this ' . $long_name . ' <em>' . $category . '</em> activity'); 
					
					$this->assign('return_button', '<input type="button" name="return" id="return" value="Return to Reporting Page" class="form-submit-inline" onclick="top.location=\'/civicrm/civicpd/individual?cid=' . $contact_id . '&clear\';" />'); 
					
					$this->assign('delete_url', '/civicrm/civicpd/individual?cid='.$contact_id.'&action=delete&id=' . $activity_id);
					
					$this->assign('output', $output);
					
   					break;
   					
				case 'update':
					
					// Clear the cpd message
					$_SESSION['cpd_message'] = '';
				
   					// List out all of the entries in this category (for this contact for this time period) with an edit link beside each item
   					CRM_Utils_System::setTitle(ts('Update ' . $short_name . ' Activities for ' . $display_name));
										
   					$sql = "SELECT civi_cpd_categories.category
   								, civi_cpd_activities.id AS activity_id
   								, civi_cpd_activities.credit_date
   								, civi_cpd_activities.credits
   								, civi_cpd_activities.activity
   								, civi_cpd_activities.details
   								, civi_cpd_activities.notes 
   								FROM civi_cpd_categories 
   								INNER JOIN civi_cpd_activities 
   								ON civi_cpd_categories.id = civi_cpd_activities.category_id 
   								WHERE civi_cpd_activities.category_id = " . $category_id . " 
   								AND contact_id = " . $contact_id . " 
   								AND EXTRACT(YEAR FROM credit_date) = " . $_SESSION["report_year"] . " 
   								ORDER BY credit_date";   	
   								
   					$dao = CRM_Core_DAO::executeQuery($sql);
   					
   					$output = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  								<tr>
    								<th width="15%">Date</th>
    								<th width="5%">Credits</th>
    								<th width="20%">Activity</th>
    								<th width="25%">Details</th>
    								<th width="25%">Notes</th>
    								<th width="10%">Action</th>
  								</tr>';
   					
   					if ($dao->N <= 0) {
   					
   						//There's no activities here so we need to redirect the user to create some activities
   						
   						$_SESSION['cpd_message'] = "You don't appear to have any CPD activities recorded for this category in " . $_SESSION["report_year"] . ". Please use the form below to record your CPD activities.";
   						
   						$querystring = "/civicrm/civicpd/editindividual?cid=".$contact_id."&action=new&catid=" . $category_id;
    					header("Location: $querystring");
    					
    					exit;
    					
   					} else {
   					
   						//There's are activities here so put them in a table
   						while( $dao->fetch( ) ) { 
   							$activity_id = $dao->activity_id;
   							$category = $dao->category;
   							$output .= '<tr>
    									<td width="15%" valign="top">'. date("M d, Y", strtotime("$dao->credit_date")) .'</td>
    									<td width="5%" align="center" valign="top">'. abs($dao->credits) .'</td>
    									<td width="20%" valign="top">'. $dao->activity .'</td>
    									<td width="25%" valign="top">'. $dao->details .'</td>
    									<td width="25%" valign="top">'. $dao->notes .'</td>
    									<td width="10%" valign="top" style="text-align:center;">';
    						
    						$output .= 	'<a href="/civicrm/civicpd/editindividual?cid=' .$contact_id. '&action=edit&activity_id=' . $activity_id . '">edit</a>';
    								
    						$output .= 	'</td></tr>';
  									
  						}
  						
   					}
   					
   					$output .= '</table>';
   					
   					$this->assign('sub_title', 'Update ' . $long_name . ' <em>' . $category . '</em> activities for ' . $display_name); 
   					$this->assign('return_button', '<input type="button" name="return" id="return" value="Return to Reporting Page" class="form-submit-inline" onclick="top.location=\'/civicrm/civicpd/individual?cid=' . $contact_id . '&clear\';" />'); 
   					$this->assign('new_button', '<div style="display: inline-block; margin-bottom: -19px; margin-top: 20px;">
												<a title="New ' . $category . ' Activity" class="button" href="/civicrm/civicpd/editindividual?cid='.$contact_id.'&amp;action=new&amp;catid=' . $category_id . '">
                									<span><div class="icon dropdown-icon"></div>New ' . $category . ' Activity</span>
                								</a>
                							</div>');
   					
   					$this->assign('output', $output);
   					
   					break;
   					
				default:
   					break;
				}
			
			} else {
					// WE DON'T HAVE A REASON TO BE HERE AND SHOULD REDIRECT TO THE CATEGORIES PAGE
					$querystring = "/civicrm/civicpd/individual?cid=" . $contact_id;
    				header("Location: $querystring");
    				exit;
    		}
		
		} else {
			// WE DON'T HAVE A REASON TO BE HERE AND SHOULD REDIRECT TO THE CATEGORIES PAGE
    		$querystring = "/civicrm/civicpd/individual?cid=" . $contact_id;
    		header("Location: $querystring");
    		exit;
    	}
   	
   	if(isset($_SESSION['cpd_message'])) {
   		$this->assign('cpd_message', $_SESSION['cpd_message']);
   	}
   	
    parent::run();
  }
}
