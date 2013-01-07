** ABOUT **

civiCRM Continuing Professional Development Extension

The civiCPD extension is a platform agnostic plugin that provides a continuing professional 
development section to a civiCRM installation that is used for professional membership management.

Once installed the Administrator has the ability to add one or more CPD categories that will 
be associated with CPD acivities.

Contacts will be able to access the CPD section through their user 'My Contact Dashboard', 
where they can review, edit or add CPD activities and print out their CPD statement. 


** REQUIREMENTS **

Contacts will require a membership of some sort in order to be included in the CPD system. 

Note: In order for regular users to be able to access the CPD section, the permissions of 
the underlying CMS must allow them to access the civiCRM Contact Dashboard and civiCRM itself.

Note: Currently only tested on Drupal 7.18 with civiCRM 4.2.x

** KNOWN BUGS **

[FIXED] If a contact has two membership types and both types are applicable to CPD activities duplicate results will occur.

** [INSTALLATION] **

1) Upload the CPD module to a directory on your web server. In drupal for example, you can use: /sites/all/extensions

2) Update your extensions paths in civiCRM to recognize your extensions directory.

3) Under Manage Extensions, install the  civiCRM Continued Professional Development module.

* In this beta version I have experienced a PHP error/warning originating from the civicpd.civix.php file. 
It hasn't affected the module or performance so it is likely a bug that we will catch as the module matures.