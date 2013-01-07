** ABOUT **
civiCRM Continuing Professional Development Extension

The civiCPD extension is a platform agnostic plugin that provides a continuing professional 
development section to a civiCRM installation that is used for professional membership management.

Once installed the Administrator has the ability to add one or more CPD categories that will 
be associated with CPD acivities.

Contacts will be able to access the CPD section through their user 'My Contact Dashboard', 
where they can review, edit or add CPD activities and print out their CPD statement. 


** REQUIREMENTS **
* Currently only tested on Drupal 7.18 with civiCRM 4.2.x

** [INSTALLATION] **
1) Upload the CPD module to a directory on your web server. In drupal for example, you might use: /sites/all/extensions

2) Update your extensions paths in civiCRM to recognize your extensions directory.

3) Under Manage Extensions, install the  civiCRM Continued Professional Development module.

4) You will need to visit the civiCPD menu in civiCRM and got to the civiCPD -> Administration page where you can
set the defaults for membership types subject to the CPD program as well as the period that members can actively
log and edit CPD activities.

5) Before members can log CPD activities, you will have to set up categories for them to report under civiCPD -> Categories.

6) A full year report can be found at civiCPD -> Report(Yearly)


* In this beta version upon installation, I have experienced a PHP error/warning originating from 
the civicpd.civix.php file. It hasn't affected the module or performance so it is likely a bug 
that we will catch as the module matures.

** NOTES **
civiCRM contacts will require a membership of some sort in order to be included in the CPD program. 

* In order for users to be able to access the CPD section, the permissions of the underlying CMS 
must allow them to access the civiCRM Contact Dashboard and civiCRM.

* From the yearly full report or the member's individual report pages, you can change the year 
by clicking on it (the year) and selecting a different year from the drop down control that will appear. 

* The contacts membership number will be displayed on each members reporting page, which they can print out 
and the membership number can be from the civicrm_contact table (external_identifier or user_unique_id) 
or the civicrm_membership id field as determined in the administration page.

* When civiCPD is uninstalled, the categories and activities database tables will remain in case the system is deleted by accident. 

** KNOWN BUGS **
[FIXED] If a contact has two membership types and both types are applicable to CPD activities duplicate results will occur.

