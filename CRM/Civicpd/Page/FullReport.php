<?php
/*
+--------------------------------------------------------------------+
| CiviCDP version alpha 1.0                                          |
+--------------------------------------------------------------------+
| File: FullReport.php                                               |
+--------------------------------------------------------------------+
| This file is a part of the CiviCPD extension.                      |
|                                                                    |
| This file lists a full report of all member's                      |
| annual credits under the categories in the database.               |
|                                                                    |
| NOTE: This page uses brute force and multiple trips to the         |
|       database to return this report. It must be re-factored       |
|       before it will be ready for distribution.                    |
|                                                                    |
+--------------------------------------------------------------------+
*/
require_once 'CRM/Core/Page.php';

class CRM_Civicpd_Page_FullReport extends CRM_Core_Page {
  function run() {
  
  	// ADD STYLESHEET
	CRM_Core_Resources::singleton()->addStyleFile('ca.lunahost.civicpd', 'civicpd.css');
  
  	/**
     * PULL THE CPD DEFAULTS AS DEFINED IN THE ADMIN PAGE
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
    		$organization_member_number_field = 'civicrm_contact.external_identifier';
    		$long_name = 'Continuing Professional Development';
    		$short_name = 'CPD';
    }
  
  	/**
  	* GET APPLICABLE MEMBER TYPES FOR THE REPORT 
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
  	* ADD $_SESSION["report_year"]
  	*/
  	$current_year = date("Y");
	if(!isset($_SESSION["report_year"])) {
		$_SESSION["report_year"] = $current_year;
	}
	
	/**
  	* BUILD DROP-DOWN ELEMENT  
  	* FOR CHANGING $_SESSION["report_year"]
  	*/
	$select_years = "";
	for($i=$current_year; $i>=($current_year-15); $i--) {
		$selected = "";
		if($i == $_SESSION["report_year"]) { $selected = "selected"; }
		$select_years .= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
	} 
	$this->assign('select_years', $select_years);

    /**
  	* GRAB CATEGORIES  
  	* AND PUT IN $arr_categories
  	*/
    $sql = "SELECT id, category FROM civi_cpd_categories ORDER BY id ASC";
    $dao = CRM_Core_DAO::executeQuery($sql);
    $arr_categories = array();
    $x = 0;
    while( $dao->fetch( ) ) {   
       	$arr_categories[$x]["category"] = $dao->category;
       	$x++;	
    }
    
    // SET UP TABLE HEADER FOR FULL REPORT
    $report_table = '<table class="report-table" border="0" cellspacing="0" cellpadding="0">
    					<tr>
    						<th nowrap>Last Name</th>
    						<th nowrap>First Name</th>
    						<th nowrap>Member Number</th>
    						<th nowrap>Membership Type</th>
    						<th nowrap>Member Since</th>
    						<th nowrap>Total Credits</th>';
    
    // PRINT CATEGORIES IN TABLE HEADER					
    for($x =0; $x < count($arr_categories); $x++ ) {
    	$report_table .= '<th nowrap>' . $arr_categories[$x]["category"] . '</th>';
    }
    
    // END TABLE HEADER
    $report_table .= '</tr>';


    /**
  	* LOOP THROUGH THE CONTACT TABLE AND CREATE AN ARRAY
  	* RUN A SECOND QUERY ON EACH ONE THAT 
  	* IS APPLICABLE TO POPULATE THE REPORT
  	*/
    $sql = "SELECT civicrm_contact.id
		, civicrm_contact.last_name
		, civicrm_contact.first_name
		, civicrm_contact.external_identifier
		, civicrm_contact.user_unique_id
		, civicrm_membership.membership_type_id
		, civicrm_membership.id AS membership_id
		, civicrm_membership.join_date AS member_since
		, civicrm_membership_type.name AS member_type
		FROM civicrm_contact 
		INNER JOIN civicrm_membership
		ON civicrm_contact.id = civicrm_membership.contact_id
		INNER JOIN civicrm_membership_type
		ON civicrm_membership.membership_type_id = civicrm_membership_type.id
		WHERE civicrm_contact.first_name IS NOT NULL 
		AND civicrm_contact.last_name IS NOT NULL
		ORDER BY civicrm_contact.last_name";

    
    $dao = CRM_Core_DAO::executeQuery($sql);
    
    // FLAG FOR LAST CONTACT ID
	$last_contact_id = "";
    
    // SET UP CONTACT ARRAY
    $arr_members = array();
    
    // CREATE TEMP TABLE OF ACTIVITIES FOR THIS YEAR ONLY
    $tempsql = "SELECT * FROM civi_cpd_activities WHERE civi_cpd_activities.credit_date >= '" . $_SESSION["report_year"] . "-01-01' AND civi_cpd_activities.credit_date  < '" . ($_SESSION["report_year"] + 1) . "-01-01'";
    $tempQuery = 'CREATE TEMPORARY TABLE civi_cpd_activities_temp1 AS ' . $tempsql;
    CRM_Core_DAO::executeQuery($tempQuery);

    while( $dao->fetch( ) ) {   

       	// ENSURE THAT THE RECORD ISN'T BLANK
		if(!is_null($dao->last_name) || !is_null($dao->first_name)) {

       		// REPORT MEMBER TYPES WE'RE INTERESTED IN && NO DUPLICATES
			if(in_array ( $dao->membership_type_id , $arr_membership_types ) && $dao->id != $last_contact_id) {
				
				$last_contact_id = $dao->id;	
				
				$report_table .= '<tr>';
    			$report_table .= '<td><a href="/civicrm/civicpd/individual?clear&amp;cid='.$dao->id.'" title="Edit/Update this record">' . $dao->last_name . '</a></td>';
    			$report_table .= '<td><a href="/civicrm/civicpd/individual?clear&amp;cid='.$dao->id.'" title="Edit/Update this record">' . $dao->first_name . '</a></td>';
    			
    			if($organization_member_number_field == 'civicrm_contact.user_unique_id'){
    				$report_table .= '<td>' . $dao->user_unique_id . '</td>';
    			}
    			elseif($organization_member_number_field == 'civicrm_membership.id') {
    				$report_table .= '<td>' . $dao->membership_id . '</td>';
    			} else {
    				$report_table .= '<td>' . $dao->external_identifier . '</td>';
    			}
    			
    			$report_table .= '<td>' . $dao->member_type . '</td>';
    			$report_table .= '<td>' . $dao->member_since . '</td>';
    			

    			$sql = "SELECT civi_cpd_categories.id AS id
    			 , civi_cpd_categories.category AS category
    			 , SUM(civi_cpd_activities_temp1.credits) AS credits
    			 , civi_cpd_categories.minimum
    			 , civi_cpd_categories.maximum
    			 , civi_cpd_categories.description
    			 FROM civi_cpd_categories
    			 LEFT OUTER JOIN civi_cpd_activities_temp1
    			 ON civi_cpd_activities_temp1.category_id = civi_cpd_categories.id
    			 AND civi_cpd_activities_temp1.contact_id = " . $dao->id . "
    			 GROUP BY civi_cpd_categories.id";
    			 
    			 $subdao = CRM_Core_DAO::executeQuery($sql);
    		
    			$total_credits = 0;
    			$sub_cells = "";
    			
    			while( $subdao->fetch( ) ) { 
    				$total_credits += abs($subdao->credits); 
    				$sub_cells .= '<td>' . abs($subdao->credits) . '</td>';       				
    			}
    		
    			$report_table .= '<td>' . $total_credits . '</td>';
    		
    			$report_table .= $sub_cells;
    	
    			$report_table .= '</tr>';

			}
       	
       	}
       	
       	
    }
			       
    // END TABLE
    $report_table .= '</table>';
	
	// SET PAGE TITLE
    CRM_Utils_System::setTitle(ts('Review ' . $short_name . ' Full Report'));
    
    $this->assign( 'report_table', $report_table );
    
    parent::run();
  }
}
