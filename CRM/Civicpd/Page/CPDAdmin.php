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
    // Set the page-title 
    CRM_Utils_System::setTitle(ts('CPD Administration'));
    
    // Get Membership types for the form
    $sql = "SELECT id, name FROM civicrm_membership_type ORDER BY weight ASC";
    $dao = CRM_Core_DAO::executeQuery($sql);
    
	$membership_checkboxes = "";
	
    while( $dao->fetch( ) ) { 
    	$membership_checkboxes .= '<label><input type="checkbox" name="memberships" value="' . $dao->id . '" id="memberships_' . $dao->id . '" /> ' . $dao->name . '</label><br/>';
    }
    
    // Member editing CPD Activities Limit
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
