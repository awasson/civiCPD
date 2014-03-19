<?php
/*
+--------------------------------------------------------------------+
| CiviCDP version alpha 1.0                                          |
+--------------------------------------------------------------------+
| File: CDPAdmin.php                                                 |
+--------------------------------------------------------------------+
| This file is a part of the CiviCPD extension.                      |
|                                                                    |
| This file is the Administrators admin control panel and provides   |
| a snapshot of the organization's CPD activities and credits        |
| based on the year in question.                                     |
|                                                                    |
+--------------------------------------------------------------------+
*/

require_once 'CRM/Core/Page.php';

class CRM_Civicpd_Page_CPDAdmin extends CRM_Core_Page {
  function run() {
  
  	// HANDLE ANY PRE-PROCESSING FIRST
  	if( isset( $_POST['action'] ) &&  $_POST['action'] == "update" ) {
  	
  		/**
  		 * SET WHICH MEMBER TYPES 
  		 * ARE APPLICABLE TO THE CPD SYSTEM
  		 */
  		// REMOVE EXISTING civi_cpd_membership_type VALUES
  		$sql = 'DELETE FROM civi_cpd_membership_type';
  		$dao = CRM_Core_DAO::executeQuery($sql);
  	
  		if( isset( $_POST['memberships'] ) ) {
  			
  			// INSERT NEW VALUES
  			$arr_posted_membership_types = $_POST['memberships'];  			
  			$sql = "INSERT INTO civi_cpd_membership_type (membership_id) VALUES ";
			foreach ($arr_posted_membership_types as $item) {
  				$sql .= "(".$item."),";
			}
			$sql = rtrim($sql,",");//remove the extra comma
			$dao = CRM_Core_DAO::executeQuery($sql);
  			
  		}
  		
  		// CLEAR civi_cpd_defaults
  		$sql = 'DELETE FROM civi_cpd_defaults';
  		$dao = CRM_Core_DAO::executeQuery($sql);
  		
  		// CREATE SQL FOR civi_cpd_defaults
  		$sql = "INSERT INTO civi_cpd_defaults (name, value) VALUES "; 
  		
  		/**
  		 * SET THE LIMIT ON MEMBER'S EDITING THEIR ACTIVITES 
  		 * 0 = UNLIMITED
  		 * 1 = CURRENT YEAR
  		 * 2 = PAST 2 YEARS
  		 * 3 = PAST 3 YEARS
  		 * 5 = PAST 5 YEARS
  		 */
  		 
  		 if( isset( $_POST['member_update_limit'] ) ) {
  		 	$sql .= "('member_update_limit', '".$_POST['member_update_limit']."'),"; 
  		 }
  		 
  		 /**
  		 * SET THE SOURCE FOR THE  
  		 * ORGANIZATIONS MEMBERSHIP NUMBERS
  		 */
  		 
  		 if( isset( $_POST['organization_member_number'] ) ) {
  		 	$sql .= "('organization_member_number', '".$_POST['organization_member_number']."'),"; 
  		 }
  		 
  		 /**
  		 * SET THE NAME AND ABBREVIATED NAME THAT THE ORGANIZATION USES 
  		 * FOR THE CONTINUING PROFESSIONAL DEVELOPMENT SYSTEM
  		 */
  		 
  		 if( isset( $_POST['long_name'] ) ) {
  		 	if($_POST['long_name']>"") {
  		 		$sql .= "('long_name', '".$_POST['long_name']."'),";
  		 	}
  		 }
  		 
  		 if( isset( $_POST['short_name'] ) ) {
  		 	if($_POST['short_name']>"") {
  		 		$sql .= "('short_name', '".$_POST['short_name']."'),";
  		 	}
  		 }
  		
  		 $sql = rtrim($sql,",");//remove the extra comma
  		 $dao = CRM_Core_DAO::executeQuery($sql);
  		 
  	}
    
    /**
  	* GET APPLICABLE MEMBER TYPES  
  	* FROM THE civi_cpd_membership_type TABLE
  	* PUT RESULTS IN AN ARRAY
  	*/
  	$sql = 'SELECT membership_id FROM civi_cpd_membership_type';
  	$dao = CRM_Core_DAO::executeQuery($sql);
  	$arr_membership_types = array();
    $x = 0;
    while( $dao->fetch( ) ) {   
       	$arr_membership_types[$x] = $dao->membership_id;
       	$x++;	
    }
    
    /**
  	* GET MEMBERSHIP TYPES FROM THE DATABASE  
  	* COMPARE WITH TYPES SET IN civi_cpd_membership_type
  	* OUTPUT CHECKBOXES WITH THE APPROPRIATE CHECKED VALUES
  	*/
    $sql = "SELECT id, name FROM civicrm_membership_type ORDER BY weight ASC";
    $dao = CRM_Core_DAO::executeQuery($sql);
	$membership_checkboxes = "";
	$checked = '';
    while( $dao->fetch( ) ) { 
    	if(in_array ( $dao->id , $arr_membership_types )) {
    		$checked = 'checked';
    	}
    	$membership_checkboxes .= '<label><input type="checkbox" name="memberships[]" value="' . $dao->id . '" id="memberships_' . $dao->id . '" ' . $checked . ' /> ' . $dao->name . '</label><br/>';
    	$checked = '';
    }
    
    /**
     * PULL THE DEFAULTS FROM THE DATABASE 
     * AND SET THE FORM FIELDS 
     * ACCORDING TO THEIR VALUES
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
    	
    	if(isset($arr_defaults['organization_member_number'])) {
    		$organization_member_number_field = $arr_defaults['organization_member_number'];
    	} else {
    		$organization_member_number_field = 'civicrm_contact.external_identifier';
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
    		$organization_member_number_field = 'civicrm_contact.external_identifier';
    		$long_name = 'Continuing Professional Development';
    		$short_name = 'CPD';
    }
    
    $arr_member_edit_limit = array('1','2','3','4','5','0');
    $member_edit_limit = "";
    $member_edit_limit_text = "";
    $checked = '';

    for($x = 0; $x < count($arr_member_edit_limit); $x++) {
    	
    	if($arr_member_edit_limit[$x] == 0) {
    		$member_edit_limit_text = 'Any year';
    	} 
    	elseif($arr_member_edit_limit[$x] == 1) {
    		$member_edit_limit_text = 'Current year';
    	} else { 
    		$member_edit_limit_text = 'Past '.$arr_member_edit_limit[$x].' years';
    	}
    	
    	if($arr_member_edit_limit[$x] == $member_update_limit){
    		$checked = 'checked="checked"';
     	}
    	
    	$member_edit_limit .= '<label> <input type="radio" name="member_update_limit" value="' . $arr_member_edit_limit[$x] . '" id="member_update_limit_'.$x.'" ' . $checked . ' /> ' . $member_edit_limit_text . ' </label><br />';
    	$checked = '';
    }
    
    
    
    // Add unique member id number
    $arr_member_id_field = array('civicrm_contact.external_identifier','civicrm_contact.user_unique_id','civicrm_membership.id');
    $selected = '';
    $organization_member_number = '<select name="organization_member_number" id="organization_member_number">';
    
    for($x = 0; $x < count($arr_member_id_field); $x++) {
    	if($arr_member_id_field[$x] == $organization_member_number_field) {
    		$selected = 'selected="selected"';
    	}	
    	$organization_member_number .= '<option value="' . $arr_member_id_field[$x] . '" ' . $selected . '>' . $arr_member_id_field[$x] . '</option>';
    	$selected = '';
    }
    
  	$organization_member_number .= '</select>';
  	
  	CRM_Utils_System::setTitle(ts($short_name . ' Administration'));
  	$this->assign('membership_checkboxes', $membership_checkboxes);
    $this->assign('member_edit_limit', $member_edit_limit);
  	$this->assign('organization_member_number', $organization_member_number);
    $this->assign('long_name', $long_name);
    $this->assign('short_name', $short_name);

    parent::run();
  }
}
