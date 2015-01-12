CiviCPD: Continuing Professional Development
============================================

JUNE 5, 2014: ADDED SERVER/CLIENT VALIDATION TO PREVENT USERS FROM INSERTING/UPDATING RECORDS THAT HAVE BEEN CLOSED OFF

JUNE 1, 2014: ADDED ADMIN PAGES FOR ADMIN USERS TO EDIT AND ADJUST ANY CPD ENTRY IN THE SYSTEM

JANUARY 20, 2013: CALL FOR TESTING. PLEASE DOWNLOAD AND TEST! (This extension is ready for testing but is still in development and currrently lacks the feature to export reports)

TODO
====
1) Export the full report as CSV or Excel. Have a technique that uses an Excel Class. Seeking permission to enable in this extension.

2) Would like to add the ability for CiviCRM Events to be related to the Continuing Professional Development extension so that events can be set to be CPD applicable. When a member registers for a CPD applicable event a record is automatically logged related to their CPD account. Maybe also add the ability for the system to send an email after a CPD event has passed prompting them to add notes to the record.

BACKGROUND
==========
The civiCPD extension is a platform agnostic plugin that provides a continuing professional development section to a CiviCRM installation that is used for professional membership management.

Once installed the Administrator has the ability to add one or more continuing professional development categories that contacts within a specified membership type can use to log yearly activities with their credit amounts per activity.

Contacts will be able to access the CPD section through their user 'My Contact Dashboard', where they can review, edit or add CPD activities and print out their CPD statement. 


REQUIREMENTS
============
Tested and compatible with CiviCRM Versions from CiviCRM 4.2.x and up. Currently in use with the latest stable versions of Drupal (7.34) and CiviCRM (4.5.5)

INSTALLATION
============
1) Download this extension using the "download zip" button. Expand the zipped archive and rename to "ca.lunahost.civicpd" 

2) Upload the CPD module to a directory on your web server. In drupal for example, you might use: /sites/all/extensions

3) Update your extensions paths and directory paths in CiviCRM to recognize your extensions directory.

4) Under Manage Extensions, install the  CiviCRM Continued Professional Development module.

5) You will need to visit the CiviCPD menu in CiviCRM and got to the CiviCPD -> Administration page where you can
set the defaults for membership types subject to the CPD program as well as the period that members can actively
log and edit CPD activities.

6) Before members can log CPD activities, you will have to set up categories for them to report under CiviCPD -> Categories.

7) A full year report can be found at CiviCPD -> Report(Yearly)

8) This extension assumes that the members who will be entering their professional development activities will have access to their contact dashboard but not CiviCRM and requires that you adjust your CMS permissions accordingly. 

9) Administrative users who have access to CiviCRM will be able to view the full report per year and if necessary can click the name of a member to adjust their record for that period.


NOTES
=====
* civiCRM contacts will require a membership of some sort in order to be included in the CPD program. 

* In order for users to be able to access the CPD section, the permissions of the underlying CMS must allow them to access the civiCRM Contact Dashboard.

* From the yearly full report or the member's individual report pages, you can change the year by clicking on it (the year) and selecting a different year from the drop down control that will appear. 

* The contacts membership number will be displayed on each members reporting page, which they can print out and the membership number can be from the civicrm_contact table (external_identifier or user_unique_id) or the civicrm_membership id field as determined in the administration page.

* When CiviCPD is uninstalled, the categories and activities database tables will remain in case the system is deleted by accident. 

KNOWN BUGS
==========
[FIXED] If a contact has two membership types and both types are applicable to CPD activities duplicate results will occur.

