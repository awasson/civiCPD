<?php
/*
+--------------------------------------------------------------------+
| CiviCDP version alpha 1.0                                          |
+--------------------------------------------------------------------+
| File: Categories.php                                               |
+--------------------------------------------------------------------+
| This file is a part of the CiviCPD extension.                      |
|                                                                    |
| This file will respond to requests, listing continuing             |
| professional development categories or processing requests to      |
| add, update or delete categories from the database.                |
|                                                                    |
+--------------------------------------------------------------------+
*/

require_once 'CRM/Core/Page.php';

class CRM_Civicpd_Page_Categories extends CRM_Core_Page {
  function run() {
  
  	// ADD STYLESHEET
	CRM_Core_Resources::singleton()->addStyleFile('ca.lunahost.civicpd', 'civicpd.css');
    
	/**
	 * Preprocess this page before we do anything 
	 * Check if we are just listing out categories or if there has been an update 
	 * or new category added to the database.
	 */
	 if(isset($_GET['action']) || isset($_POST['action'])){
	 	
	 	$action = $_REQUEST['action'];
	 		
	 	switch ($action) {
  			case 'insert':
				// Insert new category	TODO: Build in sanitation for input fields and put in some error trapping/correction
   				$category		= mysql_real_escape_string($_POST['category']);
   				$description	= mysql_real_escape_string($_POST['description']);
   				$minimum		= $_POST['minimum'];
   				$maximum		= $_POST['maximum'];
   				$sql = "INSERT INTO civi_cpd_categories(category, description, minimum, maximum) VALUES('".$category."','".$description."','".$minimum."','".$maximum."')";
   				CRM_Core_DAO::executeQuery($sql);
   				
   				break;
   				
			case 'update':
   				// Update Category where id = $catid 
   				if(isset($_POST['catid'])){
   					$catid			= $_POST['catid'];
   					$category		= mysql_real_escape_string($_POST['category']);
   					$description	= mysql_real_escape_string($_POST['description']);
   					$minimum		= $_POST['minimum'];
   					$maximum		= $_POST['maximum'];
   					$sql = "UPDATE civi_cpd_categories SET category = '".$category."', description = '".$description."', minimum = '".$minimum."', maximum = '".$maximum."' WHERE id =" . $catid;
   					CRM_Core_DAO::executeQuery($sql); 
   				}
   				
   				break;
   				
			case 'delete':
   				// Delete Category where id = $catid
   				if(isset($_GET['id'])){
   					$catid	= $_GET['id'];
   					$sql = "DELETE FROM civi_cpd_categories WHERE id =" . $catid;
   					CRM_Core_DAO::executeQuery($sql);
   				}
   				
   				break;
   				
			default:
   				break;
		}
 	}

    /**
     * After any processing, Query Categories table
     * Code to be refined later
     */
    $sql = "SELECT * FROM civi_cpd_categories";
    $dao = CRM_Core_DAO::executeQuery($sql);
  	
  	// Remove and replace with a simple pass of $dao to view. ie: $this->assign('categories', $dao);
  	
  	$categories = "";
  	
    while( $dao->fetch( ) ) {        
        $categories .= "<tr>"
        		. "<td nowrap=nowrap><strong>" . $dao->category . "</strong></td>" 
        		. "<td><em>" . $dao->description . "</em></td>"  
        		. "<td style='text-align: center;'>" . $dao->minimum . "</td>"  
        		. "<td style='text-align: center;'>" . $dao->maximum . "</td>"
        		. "<td style='text-align: center;'><a href='/civicrm/civicpd/EditCategories?id=".$dao->id."'>edit</a></td>"
        		. "</tr>";
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
    		$long_name = 'Continuing Professional Development';
    		$short_name = 'CPD';
    }

	// Set the page-title
    CRM_Utils_System::setTitle(ts('Review ' . $short_name . ' Categories'));
	
	$this->assign('categories', $categories);

    parent::run();
  }
}
