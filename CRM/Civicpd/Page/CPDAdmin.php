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
    

    // Assign the Memberships, Name and Short Names for the Form
    $this->assign('membership_checkboxes', $membership_checkboxes);
    $this->assign('long_name', 'Continuing Professional Development');
    $this->assign('short_name', 'CPD');

    parent::run();
  }
}
