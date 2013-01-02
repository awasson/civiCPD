<?php

require_once 'civicpd.civix.php';

/**
 * Implementation of hook_civicrm_config
 */
function civicpd_civicrm_config(&$config) {
  _civicpd_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function civicpd_civicrm_xmlMenu(&$files) {
  _civicpd_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_navigationMenu
 *
 * @param $params array(string)
 */
function civicpd_civicrm_navigationMenu( &$params ) {
  // get the maximum key of $params
  $maxKey = ( max( array_keys($params) ) );
  $params[$maxKey+1] = array (
    'attributes' => array (
    'label' => 'CiviCPD',
    'name' => 'CiviCPD',
    'url'        => null,
    'permission' => null,
    'operator'   => null,
    'separator'  => null,
    'parentID'   => null,
    'navID' => $maxKey+1,
    'active' => 1
	),
    	'child' =>  array (
    		'1' => array (
                'attributes' => array (
                    'label'      => 'Administration',
                    'name'       => 'Administration',
                    'url'        => 'civicrm/civicpd/admin',
                    'permission' => 'administer CiviCRM',
                    'operator'   => null,
                    'separator'  => 1,
                    'parentID'   => $maxKey+1,
                    'navID'      => 1,
                    'active'     => 1
                ),
			),
			'2' => array (
                'attributes' => array (
                    'label'      => 'Report (Annual)',
                    'name'       => 'Report',
                    'url'        => 'civicrm/civicpd/fullreport',
                    'permission' => 'administer CiviCRM',
                    'operator'   => null,
                    'separator'  => 1,
                    'parentID'   => $maxKey+1,
                    'navID'      => 1,
                    'active'     => 1
                ),
            ),
            '3' => array (
                'attributes' => array (
                    'label'      => 'Categories',
                    'name'       => 'Categories',
                    'url'        => 'civicrm/civicpd/categories',
                    'permission' => 'administer CiviCRM',
                    'operator'   => null,
                    'separator'  => 1,
                    'parentID'   => $maxKey+1,
                    'navID'      => 1,
                    'active'     => 1
                ),
            'child' => null
            ) 
        ) 
    );
}


// Adding a tab to the contact record
function civicpd_civicrm_tabs( &$tabs, $contactID ) {
    // let's add a new tab for CPD Activities
    $url = CRM_Utils_System::url( 'civicrm/civicpd/report', "reset=1&snippet=2");
    $tabs[] = array( 'id'    => 'CDP Activities',
                     'url'   => $url,
                     'title' => 'CDP Activities',
                     'weight' => 300 );
}

// Use hook_civicrm_pageRun to insert dynamic CPD information into 'My Contact Dashboard'
function civicpd_civicrm_pageRun( &$page ) {
    // Assign variables to the template using: $page->assign( 'varName', $varValue );
    // Get variables using: $page->getVar( 'varName' );

    if($page->getVar('_name')=='CRM_Contact_Page_View_UserDashBoard') {
    
    	
    
    	// Find the ID of the person viewing this page
    	$session = CRM_Core_Session::singleton();
    	$contact_id = $session->get('userID');
   
    	// Find the Year we are interested in and the date to print the report for
    	// Default to this year
    	$report_year = date("Y");

    	// Total credits for the year
    	$sql = "SELECT SUM(credits) as total_credits FROM civi_cpd_activities WHERE contact_id = ". $contact_id ." AND EXTRACT(YEAR FROM civi_cpd_activities.credit_date) = " . $report_year;

    	$dao = CRM_Core_DAO::executeQuery($sql);
    	while( $dao->fetch( ) ) {   
        	$total_credits = abs($dao->total_credits);	
    	}
    	
    	if(!isset($total_credits)) {
        	$total_credits = 0;
    	}
	
		$mcd_cpd_message = 'You currently have <strong>'. $total_credits .'</strong> CPD credits for this year. <a href="/civicrm/civicpd/report"><u>Click here</u></a> to update your CPD activities.';
	
    	$page->assign( 'mcd_cpd_message', $mcd_cpd_message );
    
    }
}


/**
 * Implementation of hook_civicrm_install
 */
function civicpd_civicrm_install() {
  return _civicpd_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function civicpd_civicrm_uninstall() {
  return _civicpd_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function civicpd_civicrm_enable() {
  return _civicpd_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function civicpd_civicrm_disable() {
  return _civicpd_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function civicpd_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _civicpd_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function civicpd_civicrm_managed(&$entities) {
  return _civicpd_civix_civicrm_managed($entities);
}
