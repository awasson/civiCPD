<?php
/*
+--------------------------------------------------------------------+
| CiviCDP version alpha 1.0                                          |
+--------------------------------------------------------------------+
| File: Edit.php                                                     |
+--------------------------------------------------------------------+
| This file is a part of the CiviCPD extension.                      |
|                                                                    |
| This file will respond to requests, providing an editing window    |
| for editing continuing professional development categories or an   |
| input screen if a new continuing education category is required    |
|                                                                    |
+--------------------------------------------------------------------+
*/

require_once 'CRM/Core/Page.php';

class CRM_Civicpd_Page_Edit extends CRM_Core_Page {
  function run() {
  
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

    
	if($_SERVER['REQUEST_METHOD']=='GET') {
	
		if(isset($_GET['id'])){
		
			//THIS IS AN EDITING PAGE
    		CRM_Utils_System::setTitle(ts('Edit ' . $short_name . ' Categories'));
		
			$catid	= $_GET['id'];
			$sql	= "SELECT * FROM civi_cpd_categories WHERE id = $catid";
			$dao	= CRM_Core_DAO::executeQuery($sql);
			$dao->fetch( );
	
			$this->assign('id', $catid);
			$this->assign('action', 'update');
			$this->assign('category', $dao->category);
			$this->assign('description', $dao->description);
			$this->assign('minimum', $dao->minimum);
			$this->assign('maximum', $dao->maximum);
			
			
			$this->assign('delete_url', '/civicrm/civicpd/categories?action=delete&id='.$catid);
			$this->assign('submit_button', '<input type="submit" name="submit" id="submit" value="Update" class="form-submit-inline" />');
			$this->assign('cancel_button', '<input type="button" name="cancel" id="cancel" value="Cancel" onclick="history.back(1);" />');
			$this->assign('delete_button', '<div style="display: inline-block; margin-bottom: -19px; margin-top: 20px;">
												<a title="Delete Category" class="delete button" href="#">
                									<span><div class="icon delete-icon"></div>Delete Category</span>
                								</a>
                							</div>');
	
		} 
		
		elseif(isset($_GET['action'])){
			$action = $_GET['action'];
			
			if($action == 'new'){
				//THIS IS A NEW CATEGORY ENTRY
    			CRM_Utils_System::setTitle(ts('Add ' . $short_name . ' Category'));
				
				$this->assign('action', 'insert');
				$this->assign('submit_button', '<input type="submit" name="submit" id="submit" value="Save" class="form-submit-inline" />');
				$this->assign('cancel_button', '<input type="button" name="cancel" id="cancel" value="Cancel" onclick="history.back(1);" />');
				$this->assign('delete_button', '');	
			}
			
		}
		
		else {
			//WE DON'T HAVE A REASON TO BE HERE AND SHOULD REDIRECT TO THE CATEGORIES PAGE
    		header('Location: /civicrm/civicpd/categories');
    		exit;
    	}
		
		
	
	}

    parent::run();
  }
}
