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
  
    // SET PAGE TITLE
    CRM_Utils_System::setTitle(ts('Review CPD Full Report'));

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
		, civicrm_membership.membership_type_id
		FROM civicrm_contact 
		INNER JOIN civicrm_membership
		ON civicrm_contact.id = civicrm_membership.contact_id
		ORDER BY civicrm_contact.last_name";

    
    $dao = CRM_Core_DAO::executeQuery($sql);
    
    // SET UP CONTACT ARRAY
    $arr_members = array();
    $x = 0;
    while( $dao->fetch( ) ) {   
       	$arr_members[$x]["id"] = $dao->id;
       	$arr_members[$x]["last_name"] = $dao->last_name;
       	$arr_members[$x]["first_name"] = $dao->first_name;
       	$arr_members[$x]["external_identifier"] = $dao->external_identifier;
       	$arr_members[$x]["membership_type_id"] = $dao->membership_type_id;
       	$x++;	
    }
    
    for($x =0; $x < count($arr_members); $x++ ) {
    
    	// ENSURE THAT THE RECORD ISN'T BLANK AS SOME SEEM TO BE
		if(!is_null($arr_members[$x]["last_name"]) || !is_null($arr_members[$x]["first_name"])) {
		
			// ONLY REPORT MEMBER TYPES WE'RE INTERESTED IN
			if(in_array ( $arr_members[$x]["membership_type_id"] , $arr_membership_types )) {  
			  	
    			$report_table .= '<tr>';
    			$report_table .= '<td>' . $arr_members[$x]["last_name"] . '</td>';
    			$report_table .= '<td>' . $arr_members[$x]["first_name"] . '</td>';
    			$report_table .= '<td>' . $arr_members[$x]["external_identifier"] . '</td>';
    			$report_table .= '<td>' . 'member type' . '</td>';
    			$report_table .= '<td>' . 'member since' . '</td>';
    	
    			$sql = "SELECT civi_cpd_categories.id AS id
    			 , civi_cpd_categories.category AS category
    			 , SUM(civi_cpd_activities.credits) AS credits
    			 , civi_cpd_categories.minimum
    			 , civi_cpd_categories.maximum
    			 , civi_cpd_categories.description
    			 FROM civi_cpd_categories
    			 LEFT OUTER JOIN civi_cpd_activities
    			 ON civi_cpd_activities.category_id = civi_cpd_categories.id
    			 AND civi_cpd_activities.contact_id = " . $arr_members[$x]["id"] . "
    			 AND EXTRACT(YEAR FROM civi_cpd_activities.credit_date) = " . $_SESSION["report_year"] . "
    			 GROUP BY civi_cpd_categories.id";
    			 
    			$dao = CRM_Core_DAO::executeQuery($sql);
    		
    			$total_credits = 0;
    			$sub_cells = "";
    		
    			while( $dao->fetch( ) ) { 
    				$total_credits += abs($dao->credits); 
       				$sub_cells .= '<td>' . abs($dao->credits) . '</td>';	
    			}
    		
    			$report_table .= '<td>' . $total_credits . '</td>';
    		
    			$report_table .= $sub_cells;
    	
    			$report_table .= '</tr>';
    		}	
    	}
    	
    }
    
    
    
    			   
    			       
    // END TABLE
    $report_table .= '</table>';

    $this->assign( 'report_table', $report_table );
    
    parent::run();
  }
}
