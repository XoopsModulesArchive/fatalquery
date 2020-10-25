<?php

/********************************************************************
 *  Gamer Server Module                                             *
 *                                                                  *
 *    Copyright (c) 2004 by FatalException Crew                     *
 *    http://www.fatalexception.us                                  *
 ********************************************************************
 *    See madquery.php header for MadQuery Copyright Information    *
 ********************************************************************
 *   If You Translate this Lang File Please put you Contanct Info   *
 *   in this file so that I could e-mail you to ask for further     *
 *   translations in the future, and for given credit where it is   *
 *   due.  Please e-mail any translations to                        *
 *   nobleclem@fatalexception.us                                    *
 ********************************************************************/

// Server Details Defines
define('_FQSVRDETAILS', 'Server Details');
define('_FQSVRADDRESS', 'Server Address');
define('_FQSVRPORT', 'Port');
define('_FQSVRMODDESC', 'Mod Type');
define('_FQSVRMODVER', 'Mod Version');
define('_FQPLYRSONLINE', 'Players Online');
define('_FQSVRTYPE', 'Server Type');
define('_FQSVROS', 'Server OS');
define('_FQSVRPASS', 'Password');
define('_FQSVRISSECURED', 'Is Secured');
define('_FQSVRPING', 'Ping');
define('_FQSVRRULES', 'Rules');
define('_FQSVRMAP', 'Map Name');
define('_FQSVRERROR', 'Could Not Connect to Specified Server');
define('_FQSVRDEDICATED', 'Dedicated');
define('_FQSVRLISTEN', 'Listen');
define('_FQSVRWINDOWS', 'Microsoft Windows');
define('_FQSVRLINUX', 'Linux');
define('_FQSVRUNKNOWN', 'Unknown OS');
define('_FQSVRNOPASS', 'No Password');
define('_FQSVRPASSPROTECTED', 'Password Protected');
define('_FQSVRPASSUNKNOWN', 'Uknown Password Status');
define('_FQSVRSECURED', 'Secured');
define('_FQSVRNOTSECURED', 'Not Secured');
define('_FQSVRUNKNOWNSECURED', 'Uknown Status');
define('_FQSVRJOIN', 'Join Server');
define('_FQSVRJOININFO', '<a href="http://www.csmapcentral.com/modules.php?name=Downloads&op=getit&lid=585" target="_blank">Half-Life Protocol Required</a>');
define('_FQSVRCURRMAP', 'Current Map');
// Player Details Defines
define('_FQPLYRSNONE', 'No Active Players Online');
define('_FQPLAYERS', 'Player');
define('_FQFRAGS', 'Frags');
define('_FQTIME', 'Time');
// Misc Defines
define('_FQMAPDLLINK', 'Click Here for Map Downloads');
define('_FQQUERY', 'Query');
define('_FQDOWNLOADS', 'Downloads');
define('_FQGOBACK', 'Click Here to Go Back');
define('_FQNODLAVAIL', 'Sorry but There is Currently No Download Available');
define('_FQCHECKBACKLATER', 'Please Check Back Later for a Download');
define('_FQMAPDIRERROR', 'Could not Open the Map Directory');
define('_FQPICDIRERROR', 'Could not Open the Picture Directory');
define('_FQNOMAPSINLISTING', 'There are currently no maps for download.');
define('_FQREMOVEFILES', 'Your install.php file still exists in the FatalQuery Directory Or you have not yet installed FatalQuery.<BR><BR>If you have installed FatalQuery Remove the install.php file and try to access the FatalQuery Module again.<BR><BR>If You are trying to Upgrade or Install FatalQuery <a href="modules.php?name=FatalQuery&file=install">Click Here</a>');
// Block Defines
define('_FQSVROFFLINE', 'Server Offline');
define('_FQADDRESS', 'Address');
define('_FQONLINE', 'Online');
define('_FQMOREINFO', 'Click For More Info');
define('_FQMAP', 'Map');
define('_FQMOD', 'Mod');
define('_FQBLOCKNOSERVERS', 'Servers Available for Block Display');

// Admin Section Defines
// Admin - Main Page
define('_FQADMINMENUFQADMIN', 'Fatal Query Administration');
define('_FQADMINMENUMAPADMIN', 'Map Administration');
define('_FQADMINADDSVR', 'Add Server');
define('_FQADMINADDMAP', 'Add New Map');
define('_FQADMINDELETEMAP', 'Delete Existing Map');
define('_FQADMINEDITGAMESVRS', 'Edit Servers');
define('_FQADMINFQSETTINGS', 'Edit FatalQuery Settings');
define('_FQADMINMAPSTATUS', 'Change Map Status');
define('_FQADMINEDITCUSTOM', 'Edit Custom Code');
// Admin - Edit Server Info Page
define('_FQADMINEDITTITLE', 'FatalQuery Admin - Edit Game Server');
define('_FQADMINSVRADMIN', 'Server Administration');
define('_FQADMINSVRPORTINFO', 'Server Port');
define('_FQADMINSVRNAME', 'Server Name');
define('_FQADMINSTATUS', 'Status');
define('_FQADMINSVRADDRESS', 'Server Address');
define('_FQADMINPLYRSON', 'Players Online');
define('_FQADMINSVRTYPE', 'Server Type');
define('_FQADMINSVROS', 'Server OS');
define('_FQADMINSVRMOD', 'Mod Name');
define('_FQADMINSVRMODVER', 'Mod Version');
define('_FQADMINSVRMAPPIC', 'Map Pic');
define('_FQADMINSVRPING', 'Ping Time');
define('_FQADMINSVRPASS', 'Server Passworded');
define('_FQADMINSVRSECURED', 'Server Secured');
define('_FQADMINPLYRINFO', 'Player Info');
define('_FQADMINSVRRULES', 'Server Rules');
define('_FQADMINACTIVE', 'Shown');
define('_FQADMINNOTACTIVE', 'Not Shown');
// Admin - Add Game Server Page
define('_FQADMINADDTITLE', 'FatalQuery Administration - Add Server');
// Admin - Edit Game Servers Page
define('_FQADMINMODIFY', 'Modify');
define('_FQADMINDELETE', 'Delete');
define('_FQADMINCONFIRMSVRDELETE', 'Are your Sure that you wish to Delete the server');
define('_FQADMINCONFIRMSVRDELETETITLE', 'Confirm Game Server Deletion');
// Admin - Map Pages
define('_FQADMINMAPADMINTITLE', 'FatalQuery Map Administration');
define('_FQADMINADDMAPTITLE', 'FatalQuery Admin - Add New Map');
define('_FQADMINMAPEXSISTS', 'Sorry but that map already exists');
define('_FQADMINMAPADDED', 'has been added to the Database');
define('_FQADMINMAPH1', 'Heading 1');
define('_FQADMINMAPH2', 'Heading 2');
define('_FQADMINCHOOSEMAPDELETE', 'Choose a map to Delete');
define('_FQADMINCONFIRMDELETETITLE', 'Confim Map Deletion');
define('_FQADMINDELETECONFIRM', 'Are your Sure that you wish to Delete');
define('_FQADMINMAPDELETED', 'has been deleted from the Database');
// Admin - Misc

// Admin - FQ Settings Page
define('_FQADMINFQSETTINGSTITLE', 'FatalQuery Settings');
define('_FQADMINPGTITLE', 'Page Title');
define('_FQADMINRTBLOCKS', 'Right Blocks');
define('_FQADMINDEFAULTVIEW', 'Default Page View');
define('_FQADMINDVSHORT', 'Short Listing');
define('_FQADMINDVFULL', 'Full Listing');
define('_FQADMINMAPSINROW', 'Maps In Row');
define('_FQADMINDEFAULTPIC', 'Default Pic name');
define('_FQADMINMAPHEADING', 'Map Heading');
define('_FQADMINHEADING1', 'Map Page Heading 1');
define('_FQADMINHEADING2', 'Map Page Heading 2');
define('_FQADMINMAPPICDIR', 'Map Picture Directory');
define('_FQADMINMAPDLDIR', 'Map Download Directory');
define('_FQADMINMAPDLEXT', 'Map Download Extenstion');
define('_FQADMINMAPPICEXT', 'Map Picture Extenstion');
define('_FQADMINCUSTOMCODE', 'Custom Code');
define('_FQADMINUSERQUERY', 'User Query Fields');
define('_FQADMINMAPDLLINK', 'Map Downloads Link');
define('_FQADMINBLOCKSTATUS', 'Active in Block');
define('_FQADMINJOINLINK', 'Join Link');
// Admin Cutom Code Page
define('_FQADMINEDITCUSTOMTITLE', 'Edit Custom Page Code for Module Page');
define('_FQADMINCUSTOMNOTE', 'USE html code for this section');

// Admin General Defines
define('_FQADMINTITLE', 'FatalQuery Administration');
define('_FQADMINON', 'On');
define('_FQADMINOFF', 'Off');
define('_FQADMINSUBMIT', 'Submit');
define('_FQADMINRESET', 'Reset');
define('_FQADMINYES', 'Yes');
define('_FQADMINNO', 'No');
define('_FQADMINMAINGOBACK', 'Click Here to Go Back to Main Admin Page');
define('_FQADMINGOBACK', 'Click Here to Go Back');
define('_FQADMINCOPYRIGHT', 'FatalQuery is developed and maintainted by nobleclem at <a href="http://www.fatalexception.us" target="_blank">www.fatalexception.us</a><BR>FatalQuery is Released under the <a href="http://www.gnu.org" target="_blank">GNU/GPL</a>');

// Installation / Upgrade Defines
define('_FQINSTALLTITLE', 'FatalQuery Installation / Upgrade Script<BR>FatalQuery Version 1.7.5');
define('_FQINSTALLCOMPLETE', 'Installation / Upgrade Complete<BR><BR>Delete the install.php file to complete the installation / upgrade of FatalQuery');
define('_FQINSTALLNOTSUP', 'Your Install / Upgrade Selection is not supported');
define('_FQINSTALLWELCOME', 'Welcome to the FatalQuery Installation and Upgrade Script.<BR>To Install or Upgrade Choose the desired settings below and click the "Install" Button');
define('_FQINSTALLINSTUPTYPE', 'Installation / Upgrade Type');
define('_FQINSTALLOP1', 'New FQ Install');
define('_FQINSTALLOP2', 'FQ v1.7.x Upgrade');
define('_FQINSTALLOP3', 'FQ v1.6 Upgrade');
define('_FQINSTALLOP4', 'FQ v1.5 Upgrade');
define('_FQINSTALLOP5', 'FQ v1.0 Upgrade');
define('_FQINSTALLDEFAULTPAGE', 'Default Page View Type');
define('_FQINSTALLFULL', 'Full Display');
define('_FQINSTALLSHORT', 'Short Display');
define('_FQINSTALLJOINLINK', 'Join Server Link');
define('_FQINSTALLON', 'On');
define('_FQINSTALLOFF', 'Off');
define('_FQINSTALLNOTES', '<u>Upgrade Edition Notes:</u><BR>FatalQuery 1.6 Upgrade: No known issues<BR>FatalQuery 1.5 Upgrade: Again no known major issues<BR>FatalQuery 1.0 Upgrade: All Data will be lost except for the map data.');
define('_FQINSTALLDEFINES', '<u>Installation Defines:</u><BR>Full Display - This is the normal full server detail display for all servers<BR>Short Display - This is a quick list of Server Name, Address, Players, and Current Mapname.');
