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
  	
  		// REMOVE EXISTING civi_cpd_membership_type VALUES
  		$sql = 'DELETE FROM civi_cpd_membership_type';
  		$dao = CRM_Core_DAO::executeQuery($sql);
  	
  		if( isset( $_POST['memberships'] ) ) {
  			
  			// INSERT NEW VALUES
  			$arr_posted_membership_types = $_POST['memberships'];  			
  			$sql = "INSERT INTO civi_cpd_membership_type (membership_id) VALUES ";
			foreach ($arr_posted_membership_types as $item) {
  				$sql .= "(".$item[0]."),";
			}
			$sql = rtrim($sql,",");//remove the extra comma
			$dao = CRM_Core_DAO::executeQuery($sql);
  			
  			
  		}  
  	
  	}
  
  
    // SET THE PAGE TITLE
    CRM_Utils_System::setTitle(ts('CPD Administration'));
    
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
    
    // TIME LIMIT FOR EDITING CPD ACTIVITIES
    $member_edit_limit = '<label>
    <input type="radio" name="member_update_limit" value="1" id="member_update_limit_0" />
    Current year</label>
  <br />
  <label>
    <input type="radio" name="member_update_limit" value="2" id="member_update_limit_1" />
    Past 2 years</label>
  <br />
  <label>
    <input type="radio" name="member_update_limit" value="3" id="member_update_limit_2" />
    Past 3 years</label>
  <br />
  <label>
    <input type="radio" name="member_update_limit" value="5" id="member_update_limit_3" />
    Past 5 years</label>
  <br />
  <label>
    <input type="radio" name="member_update_limit" value="0" id="member_update_limit_4" checked="checked" />
    Any year</label>';
    
    $this->assign('member_edit_limit', $member_edit_limit);
    
    // Add unique member id number
    
    $organization_member_number = '<select name="organization_member_number" id="organization_member_number">
    <option value="civicrm_contact.external_identifier" selected="selected">civicrm_contact.external_identifier</option>
    <option value="civicrm_contact.user_unique_id">civicrm_contact.user_unique_id</option>
    <option value="civicrm_membership.id">civicrm_membership.id</option>
  </select>';
  
  $this->assign('organization_member_number', $organization_member_number);


    // Assign the Memberships, Name and Short Names for the Form
    $this->assign('membership_checkboxes', $membership_checkboxes);
    $this->assign('long_name', 'Continuing Professional Development');
    $this->assign('short_name', 'CPD');

    parent::run();
  }
}
