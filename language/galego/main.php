<?php

//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://www.xoops.org>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

/********************************************************************
 *  Fatalquery Module                                               *
 *                                                                  *
 *    Copyright (c) 2005 by FatalException Crew                     *
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
define('_MD_FQ_SVRDETAILS', 'Server Details');
define('_MD_FQ_SVRADDRESS', 'Server IP');
define('_MD_FQ_SVRPORT', 'Port');
define('_MD_FQ_SVRMODDESC', 'Mod Type');
define('_MD_FQ_SVRMODVER', 'Mod Version');
define('_MD_FQ_PLYRSONLINE', 'Players Online');
define('_MD_FQ_SVRTYPE', 'Server Type');
define('_MD_FQ_SVROS', 'Server OS');
define('_MD_FQ_SVRPASS', 'Password');
define('_MD_FQ_SVRISSECURED', 'Is Secured');
define('_MD_FQ_SVRPING', 'Ping');
define('_MD_FQ_SVRRULES', 'Rules');
define('_MD_FQ_SVRMAP', 'Map Name');
define('_MD_FQ_SVRERROR', 'Could Not Connect to Specified Server');
define('_MD_FQ_SVRDEDICATED', 'Dedicated');
define('_MD_FQ_SVRLISTEN', 'Listen');
define('_MD_FQ_SVRWINDOWS', 'Microsoft Windows');
define('_MD_FQ_SVRLINUX', 'Linux');
define('_MD_FQ_SVRUNKNOWN', 'Unknown OS');
define('_MD_FQ_SVRNOPASS', 'No Password');
define('_MD_FQ_SVRPASSPROTECTED', 'Password Protected');
define('_MD_FQ_SVRPASSUNKNOWN', 'Uknown Password Status');
define('_MD_FQ_SVRSECURED', 'Secured');
define('_MD_FQ_SVRNOTSECURED', 'Not Secured');
define('_MD_FQ_SVRUNKNOWNSECURED', 'Uknown Status');
define('_MD_FQ_SVRJOIN', 'Join Server');
define('_MD_FQ_SVRJOININFO', '<a href="http://www.csmapcentral.com/modules.php?name=Downloads&op=getit&lid=585" target="_blank">Half-Life Protocol Required</a>');
define('_MD_FQ_SVRCURRMAP', 'Current Map');
define('_MD_FQ_ONLINE', 'Online');

// Player Details Defines
define('_MD_FQ_PLYRSNONE', 'No Active Players Online');
define('_MD_FQ_PLAYER', 'Player');
define('_MD_FQ_FRAGS', 'Frags');
define('_MD_FQ_TIME', 'Time');
define('_MD_FQ_KPM', 'KpM');

// Misc Defines
define('_MD_FQ_MAPDLLINK', 'Click Here for Map Downloads');
define('_MD_FQ_QUERY', 'Query');
define('_MD_FQ_DOWNLOADS', 'Downloads');
define('_MD_FQ_GOBACK', 'Click Here to Go Back');
define('_MD_FQ_NODLAVAIL', 'Sorry but There is Currently No Download Available');
define('_MD_FQ_CHECKBACKLATER', 'Please Check Back Later for a Download');
define('_MD_FQ_MAPDIRERROR', 'Could not Open the Map Directory');
define('_MD_FQ_PICDIRERROR', 'Could not Open the Picture Directory');
define('_MD_FQ_NOMAPSINLISTING', 'There are currently no maps for download.');
define('_MD_FQ_REMOVEFILES', 'Your install.php file still exists in the FatalQuery Directory Or you have not yet installed FatalQuery.<BR><BR>If you have installed FatalQuery Remove the install.php file and try to access the FatalQuery Module again.<BR><BR>If You are trying to Upgrade or Install FatalQuery <a href="modules.php?name=FatalQuery&file=install">Click Here</a>');
define('_MD_FQ_ADMINSVRNAME', 'Server Name');
define('_MD_FQ_NODLAVAILYET', 'Sorry but There is Currently No Download Available<br>Please Check Back Later for a Download');

// Installation / Upgrade Defines
define('_MD_FQ_INSTALLTITLE', 'FatalQuery Installation / Upgrade Script<BR>FatalQuery Version 1.7.5');
define('_MD_FQ_INSTALLCOMPLETE', 'Installation / Upgrade Complete<BR><BR>Delete the install.php file to complete the installation / upgrade of FatalQuery');
define('_MD_FQ_INSTALLNOTSUP', 'Your Install / Upgrade Selection is not supported');
define('_MD_FQ_INSTALLWELCOME', 'Welcome to the FatalQuery Installation and Upgrade Script.<BR>To Install or Upgrade Choose the desired settings below and click the "Install" Button');
define('_MD_FQ_INSTALLINSTUPTYPE', 'Installation / Upgrade Type');
define('_MD_FQ_INSTALLOP1', 'New FQ Install');
define('_MD_FQ_INSTALLOP2', 'FQ v1.7.x Upgrade');
define('_MD_FQ_INSTALLOP3', 'FQ v1.6 Upgrade');
define('_MD_FQ_INSTALLOP4', 'FQ v1.5 Upgrade');
define('_MD_FQ_INSTALLOP5', 'FQ v1.0 Upgrade');
define('_MD_FQ_INSTALLDEFAULTPAGE', 'Default Page View Type');
define('_MD_FQ_INSTALLFULL', 'Full Display');
define('_MD_FQ_INSTALLSHORT', 'Short Display');
define('_MD_FQ_INSTALLJOINLINK', 'Join Server Link');
define('_MD_FQ_INSTALLON', 'On');
define('_MD_FQ_INSTALLOFF', 'Off');
define('_MD_FQ_INSTALLNOTES', '<u>Upgrade Edition Notes:</u><BR>FatalQuery 1.6 Upgrade: No known issues<BR>FatalQuery 1.5 Upgrade: Again no known major issues<BR>FatalQuery 1.0 Upgrade: All Data will be lost except for the map data.');
define('_MD_FQ_INSTALLDEFINES', '<u>Installation Defines:</u><BR>Full Display - This is the normal full server detail display for all servers<BR>Short Display - This is a quick list of Server Name, Address, Players, and Current Mapname.');
