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
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(ts('CPD Administration'));

    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));

    parent::run();
  }
}
