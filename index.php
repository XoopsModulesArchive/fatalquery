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
 *  FatalQuery Server Module                                        *
 *                                                                  *
 *    Copyright (c) 2003 by FatalException Crew                     *
 *    http://www.fatalexception.us                                  *
 ********************************************************************
 *    See madquery.php header for MadQuery Copyright Information    *
 ********************************************************************/

include 'header.php';
require_once 'madquery.php'; /* Must be valid for execution, and accessible to the web server */

global $xoopsDB,$xoopsModuleConfig,$xoopsTpl;
/***************************************/
/*         Page Configurations         */
/***************************************/
// Right Blocks on or Off  (1 = on, 0 = off)
$index = $xoopsModuleConfig['right_blocks'];

/*******************************************************/
/* Links placed at top for userquery and maps download */
/*******************************************************/
function fq_toplinks()
{
    global $xoopsDB, $xoopsModuleConfig, $xoopsTpl;

    if ('1' == $xoopsModuleConfig['user_query'] || '1' == $xoopsModuleConfig['map_dl_link']) {
        if (!isset($index)) {
            $index = '';
        }

        if (1 == $index) {
            $align = 'right';
        } else {
            $align = 'center';
        }

        if (('1' == $xoopsModuleConfig['user_query'] && '0' == $xoopsModuleConfig['map_dl_link']) || ('0' == $xoopsModuleConfig['user_query'] && '1' == $xoopsModuleConfig['map_dl_link'])) {
            $width = '100%';
        } else {
            $width = '';
        }

        $xoopsTpl->assign('user_query_id', $xoopsModuleConfig['user_query_id']);

        $xoopsTpl->assign('width', $width);

        $xoopsTpl->assign('align', $align);

        $xoopsTpl->assign('map_dl_link', $xoopsModuleConfig['map_dl_link']);

        $xoopsTpl->assign('user_query', $xoopsModuleConfig['user_query']);

        $xoopsTpl->assign('_fqmapdllink', _MD_FQ_MAPDLLINK);

        $xoopsTpl->assign('_fqsvraddress', _MD_FQ_SVRADDRESS);

        $xoopsTpl->assign('_fqsvrport', _MD_FQ_SVRPORT);

        $xoopsTpl->assign('_fqquery', _MD_FQ_QUERY);
    }
}

/***************************************/
/*         SERVER DISPLAY TYPE         */
/***************************************/
function main($sort = 'frag')
{
    global $xoopsModuleConfig, $xoopsTpl;

    $xoopsTpl->assign('default_view', $xoopsModuleConfig['default_view']);

    if (1 == $xoopsModuleConfig['default_view']) {
        default_view_full($sort);
    } else {
        default_view_short($sort);
    }
}

/***************************************/
/*         FULL SERVER DISPLAY         */
/***************************************/
function default_view_full($sort = 'frag')
{
    global $xoopsDB, $xoopsModuleConfig, $xoopsTpl, $serverlist;

    fq_toplinks();

    $type = 0;

    $i = 0;

    $result = $xoopsDB->query('SELECT * from ' . $xoopsDB->prefix('fatalquery_svrs') . ' ORDER BY `svr_id`');

    while ($server_info = $xoopsDB->fetchArray($result)) {
        if ($server_info['svr_id'] != $xoopsModuleConfig['user_query_id'] && 1 == $server_info['svr_status']) {
            $Server_Address = $server_info['svr_address'];

            $Server_Port = $server_info['svr_port'];

            query_server($type, $server_info, $Server_Address, $Server_Port, $server_info['svr_id'], $sort, $i);

            $i++;
        }
    }

    $xoopsTpl->assign('serverlist', $serverlist);

    $xoopsTpl->assign('_fqgoback', _MD_FQ_GOBACK);

    $xoopsTpl->assign('_fqsvrdetails', _MD_FQ_SVRDETAILS);

    $xoopsTpl->assign('_fqsvraddress', _MD_FQ_SVRADDRESS);

    $xoopsTpl->assign('_fqsvrmoddesc', _MD_FQ_SVRMODDESC);

    $xoopsTpl->assign('_fqsvrmodver', _MD_FQ_SVRMODVER);

    $xoopsTpl->assign('_fqplyrsonline', _MD_FQ_PLYRSONLINE);

    $xoopsTpl->assign('_fqsvrtype', _MD_FQ_SVRTYPE);

    $xoopsTpl->assign('_fqsvros', _MD_FQ_SVROS);

    $xoopsTpl->assign('_fqsvrpass', _MD_FQ_SVRPASS);

    $xoopsTpl->assign('_fqsvrissecured', _MD_FQ_SVRISSECURED);

    $xoopsTpl->assign('_fqsvrping', _MD_FQ_SVRPING);

    $xoopsTpl->assign('_fqsvrrules', _MD_FQ_SVRRULES);

    $xoopsTpl->assign('_fqsvrmap', _MD_FQ_SVRMAP);

    $xoopsTpl->assign('_fqplayer', _MD_FQ_PLAYER);

    $xoopsTpl->assign('_fqfrags', _MD_FQ_FRAGS);

    $xoopsTpl->assign('_fqtime', _MD_FQ_TIME);

    $xoopsTpl->assign('_fqkpm', _MD_FQ_KPM);

    $xoopsTpl->assign('_fqplyrsnone', _MD_FQ_PLYRSNONE);

    $xoopsTpl->assign('_fqsvrjoin', _MD_FQ_SVRJOIN);

    $xoopsTpl->assign('_fqsvrjoininfo', _MD_FQ_SVRJOININFO);

    $custom = stripslashes($xoopsModuleConfig['custom_code']);

    $xoopsTpl->assign('custom_on', $xoopsModuleConfig['custom_on']);

    $xoopsTpl->assign('custom', $custom);
}

/***************************************/
/*          Short Server View          */
/***************************************/
function default_view_short()
{
    global $xoopsDB, $xoopsModuleConfig, $xoopsTpl;

    fq_toplinks();

    $xoopsTpl->assign('_fqadminsvrname', _MD_FQ_ADMINSVRNAME);

    $xoopsTpl->assign('_fqsrvadress', _MD_FQ_SVRADDRESS);

    $xoopsTpl->assign('_fqonline', _MD_FQ_ONLINE);

    $xoopsTpl->assign('_fqsvrcurrmap', _MD_FQ_SVRCURRMAP);

    $result = $xoopsDB->query('SELECT * from ' . $xoopsDB->prefix('fatalquery_svrs') . ' ORDER BY `svr_id`');

    $tdclass = 'even';

    $i = 0;

    while ($server_info = $xoopsDB->fetchArray($result)) {
        if ($server_info['svr_id'] != $xoopsModuleConfig['user_query_id'] && 1 == $server_info['svr_status']) {
            $myserver = query_class($server_info['svr_address'], $server_info['svr_port']);

            $myserver->getdetails();

            $svr_info[$i]['svr_id'] = $server_info['svr_id'];

            $svr_info[$i]['svr_uname'] = $server_info['svr_uname'];

            $svr_info[$i]['svr_address'] = $server_info['svr_address'];

            $svr_info[$i]['svr_port'] = $server_info['svr_port'];

            $svr_info[$i]['mActive'] = $myserver->mActive();

            $svr_info[$i]['mMax'] = $myserver->mMax();

            if ('0' == $myserver->mMap()) {
                $curr_mapname = '' . _MD_FQ_SVROFFLINE . '';
            } else {
                $curr_mapname = $myserver->mMap();
            }

            $svr_info[$i]['curr_mapname'] = $curr_mapname;

            $svr_info[$i]['tdclass'] = $tdclass;

            $i++;

            if ('even' == $tdclass) {
                $tdclass = 'odd';
            } else {
                $tdclass = 'even';
            }
        }
    }

    $xoopsTpl->assign('svr_info', $svr_info);

    $custom = stripslashes($xoopsModuleConfig['custom_code']);

    $xoopsTpl->assign('custom_on', $xoopsModuleConfig['custom_on']);

    $xoopsTpl->assign('custom', $custom);
}

/***************************************/
/*         MadQuery Class Call         */
/***************************************/
function query_class($address, $port)
{
    $classinfo = new madQuery($address, $port); /* your server's IP and port */

    return($classinfo);
}

/***************************************/
/*              Maps Code              */
/***************************************/
function maps()
{
    global $xoopsDB, $xoopsModuleConfig, $xoopsTpl;

    $i = 0;

    $k = 0;

    $tdclass = 'even';

    $result1 = $xoopsDB->query('SELECT * from ' . $xoopsDB->prefix('fatalquery_maps') . " where in_rotation = '1' ORDER BY map_name ");

    $result2 = $xoopsDB->query('SELECT * from ' . $xoopsDB->prefix('fatalquery_maps') . " where in_rotation = '0' ORDER BY map_name ");

    if ($xoopsDB->getRowsNum($result1) > 0) {
        $xoopsTpl->assign('map_heading_1', $xoopsModuleConfig['map_heading_1']);

        // runs through current maps lists

        while ($mapcycle = $xoopsDB->fetchArray($result1)) {
            // gets map picturename if exists sets to default pic name if one is not found

            // gets map download name if exists sets to no download avail if file doesnt exist

            $map_pic_name = mappic_name_check($mapcycle['map_name']);

            // $map_dl_name = map_dl_check($mapcycle['map_name']);

            $map_dl_name = 'downloadmap.php?file=' . $mapcycle['map_name'];

            // If the begining of a map listing row then start a new table

            // If statement moved to template

            // Print out Map picture name and downloadname

            $map_cycle[$k]['map_pic_name'] = $map_pic_name;

            $map_cycle[$k]['map_dl_name'] = $map_dl_name;

            $map_cycle[$k]['map_name'] = $mapcycle['map_name'];

            $map_cycle[$k]['map_dl_count'] = $mapcycle['map_dl_count'];

            $map_cycle[$k]['date_added'] = $mapcycle['date_added'];

            $map_cycle[$k]['i'] = $i;

            $map_cycle[$k]['j'] = 1;

            $map_cycle[$k]['k'] = $k;

            $map_cycle[$k]['tdclass'] = $tdclass;

            $i++;

            // If map in row has reach max value then end table and set counter to 0

            if ($i == $xoopsModuleConfig['maps_in_row']) {
                $i = 0;

                $map_cycle[$k]['j'] = 0;
            }

            if ('even' == $tdclass) {
                $tdclass = 'odd';
            } else {
                $tdclass = 'even';
            }

            $k++;
        }

        $xoopsTpl->assign('map_cycle', $map_cycle);

        $xoopsTpl->assign('maps_in_row', $xoopsModuleConfig['maps_in_row']);

        $xoopsTpl->assign('_fqdownloads', _MD_FQ_DOWNLOADS);

        // After Map Cycle output has finished if counter is not equal to 0 table is finished

        $i = 0;

        $k = 0;
    }//End of If Statement where as long as num_rows >0

    if ($xoopsDB->getRowsNum($result2) > 0) {
        $xoopsTpl->assign('map_heading_2', $xoopsModuleConfig['map_heading_2']);

        //runs through avail maps not in rotation

        while ($avail_maps = $xoopsDB->fetchArray($result2)) {
            // gets map picturename if exists sets to default pic name if one is not found

            // gets map download name if exists sets to no download avail if file doesnt exist

            $map_pic_name = mappic_name_check($avail_maps['map_name']);

            // $map_dl_name = map_dl_check($avail_maps['map_name']);

            $map_dl_name = 'downloadmap.php?file=' . $avail_maps['map_name'];

            // If the begining of a map listing row then start a new table

            // If statement moved to template

            // Print out Map picture name an downloadname

            $available_maps[$k]['map_pic_name'] = $map_pic_name;

            $available_maps[$k]['map_dl_name'] = $map_dl_name;

            $available_maps[$k]['map_name'] = $avail_maps['map_name'];

            $available_maps[$k]['map_dl_count'] = $avail_maps['map_dl_count'];

            $available_maps[$k]['date_added'] = $avail_maps['date_added'];

            $available_maps[$k]['i'] = $i;

            $available_maps[$k]['j'] = 1;

            $available_maps[$k]['k'] = $k;

            $available_maps[$k]['tdclass'] = $tdclass;

            $i++;

            // If map in row has reach max value then end table and set counter to 0

            if ($i == $xoopsModuleConfig['maps_in_row']) {
                $i = 0;

                $available_maps[$k]['j'] = 0;
            }

            if ('even' == $tdclass) {
                $tdclass = 'odd';
            } else {
                $tdclass = 'even';
            }

            $k++;
        }

        $xoopsTpl->assign('available_maps', $available_maps);

        // After Map Cycle output has finished if counter is not equal to 0 table is finished

        if (0 != $i) {
            $i = 0;

            $xoopsTpl->assign('map_t_finished', 1);
        }
    }//end of $xoopsDB->getRowsNum for $result2 >0

    if ((0 == $xoopsDB->getRowsNum($result1)) && (0 == $xoopsDB->getRowsNum($result2))) {
        $xoopsTpl->assign('_fqnomapsinlisting', _MD_FQ_NOMAPSINLISTING);
    }

    $xoopsTpl->assign('_fqnminlistchck', _MD_FQ_NOMAPSINLISTING);

    $xoopsTpl->assign('_fqgoback', _MD_FQ_GOBACK);
}

/***************************************/
/*           No DL Avail Code          */
/***************************************/
function no_dl_avail()
{
    redirect_header('index.php?op=maps', 3, _MD_FQ_NODLAVAILYET);

    /*
    global $xoopsTpl;
    $xoopsTpl->assign('_fqnodlavail', _MD_FQ_NODLAVAIL);
    $xoopsTpl->assign('_fqcheckbacklater', _MD_FQ_CHECKBACKLATER);
    $xoopsTpl->assign('fqgoback', _MD_FQ_GOBACK);
    */
}

/***************************************/
/*              Map DL Code            */
/***************************************/
function map_dl($map)
{
    global $xoopsDB, $xoopsModuleConfig;

    $mapdlname = '' . $map . '' . $xoopsModuleConfig['map_dl_ext'] . '';

    $xoopsDB->query('UPDATE ' . $xoopsDB->prefix('fatalquery_maps') . " set map_dl_count=map_dl_count+1 where map_name='$map'");

    header("Location: $xoopsModuleConfig[map_dl_dir]/$mapdlname");
}

/***************************************/
/*              Mappic Name            */
/***************************************/
function mappic_name_check($map)
{
    global $xoopsModuleConfig;

    $map = '' . $map . '' . $xoopsModuleConfig['mappic_ext'] . '';

    // mapname setting, if file doesnt exist then sets to a default picutre.

    $dh = opendir($xoopsModuleConfig['map_pic_dir']) || die('' . _MD_FQ_PICDIRERROR . '');

    while ($file = readdir($dh)) {
        if ($file == $map) {
            $map_pic_name = '' . $xoopsModuleConfig['map_pic_dir'] . '' . $map . '';

            break;
        }

        $map_pic_name = '' . $xoopsModuleConfig['map_pic_dir'] . '' . $xoopsModuleConfig['default_pic_name'] . '' . $xoopsModuleConfig['mappic_ext'] . '';
    }

    return $map_pic_name;
}

/***************************************/
/*              Map DL Name            */
/***************************************/
function map_dl_check($map)
{
    global $xoopsModuleConfig, $xoopsDB;

    $mapdlname = '' . $map . '' . $xoopsModuleConfig['map_dl_ext'] . '';

    // checks to see if file exists

    $dh = opendir($xoopsModuleConfig['map_dl_dir']) || die('' . _MD_FQ_MAPDIRERROR . '');

    while ($file = readdir($dh)) {
        if ($file == $mapdlname) {
            $map_dl_name = "index.php?op=map_dl&map=$map";

            break;
        }

        $map_dl_name = 'index.php?op=No_DL_Avail';
    }

    return $map_dl_name;
}

/***************************************/
/*           User Query Code           */
/***************************************/
function userquery($svrid = -1, $sort = 'frag')
{
    global $xoopsDB, $xoopsModuleConfig, $xoopsTpl, $serverlist;

    if (-1 == $svrid) {
        $svrid = $xoopsModuleConfig['user_query_id'];
    }

    fq_toplinks();

    $type = 1;

    $result = $xoopsDB->query('SELECT * from ' . $xoopsDB->prefix('fatalquery_svrs') . " where svr_id='" . $svrid . "'");

    $server_info = $xoopsDB->fetchArray($result);

    if ($svrid == $xoopsModuleConfig['user_query_id']) {
        if (isset($_POST['user_address'])) {
            $Server_Address = $_POST['user_address'];
        } elseif (isset($_GET['user_address'])) {
            $Server_Address = $_GET['user_address'];
        } else {
            $Server_Address = $server_info['svr_address'];
        }

        if (isset($_POST['user_port'])) {
            $Server_Port = $_POST['user_port'];
        } elseif (isset($_GET['user_port'])) {
            $Server_Port = $_GET['user_port'];
        } else {
            $Server_Port = $server_info['svr_port'];
        }
    } else {
        $Server_Address = $server_info['svr_address'];

        $Server_Port = $server_info['svr_port'];
    }

    $i = 0;

    query_server($type, $server_info, $Server_Address, $Server_Port, $svrid, $sort, $i);

    $xoopsTpl->assign('serverlist', $serverlist);

    $xoopsTpl->assign('_fqgoback', _MD_FQ_GOBACK);

    $xoopsTpl->assign('_fqsvrdetails', _MD_FQ_SVRDETAILS);

    $xoopsTpl->assign('_fqsvraddress', _MD_FQ_SVRADDRESS);

    $xoopsTpl->assign('_fqsvrmoddesc', _MD_FQ_SVRMODDESC);

    $xoopsTpl->assign('_fqsvrmodver', _MD_FQ_SVRMODVER);

    $xoopsTpl->assign('_fqplyrsonline', _MD_FQ_PLYRSONLINE);

    $xoopsTpl->assign('_fqsvrtype', _MD_FQ_SVRTYPE);

    $xoopsTpl->assign('_fqsvros', _MD_FQ_SVROS);

    $xoopsTpl->assign('_fqsvrpass', _MD_FQ_SVRPASS);

    $xoopsTpl->assign('_fqsvrissecured', _MD_FQ_SVRISSECURED);

    $xoopsTpl->assign('_fqsvrping', _MD_FQ_SVRPING);

    $xoopsTpl->assign('_fqsvrrules', _MD_FQ_SVRRULES);

    $xoopsTpl->assign('_fqsvrmap', _MD_FQ_SVRMAP);

    $xoopsTpl->assign('_fqplayer', _MD_FQ_PLAYER);

    $xoopsTpl->assign('_fqfrags', _MD_FQ_FRAGS);

    $xoopsTpl->assign('_fqtime', _MD_FQ_TIME);

    $xoopsTpl->assign('_fqkpm', _MD_FQ_KPM);

    $xoopsTpl->assign('_fqplyrsnone', _MD_FQ_PLYRSNONE);

    $xoopsTpl->assign('_fqsvrjoin', _MD_FQ_SVRJOIN);

    $xoopsTpl->assign('_fqsvrjoininfo', _MD_FQ_SVRJOININFO);

    $custom = stripslashes($xoopsModuleConfig['custom_code']);

    $xoopsTpl->assign('custom_on', $xoopsModuleConfig['custom_on']);

    $xoopsTpl->assign('custom', $custom);
}

/***************************************/
/*         Server Query Code           */
/***************************************/
function query_server($type, $server_info, $Server_Address, $Server_Port, $svrid = -1, $sort = 'frag', $i = 0)
{
    global $xoopsDB, $xoopsModuleConfig, $xoopsTpl, $serverlist;

    if (-1 == $svrid) {
        $svrid = $xoopsModuleConfig['user_query_id'];
    }

    if (0 == $type) {	 // Full Listing Option
        $serverlist[$i]['link'] = '';

        $serverlist[$i]['gobacklink'] = '';
    } else {//User Query Option
        $serverlist[$i]['link'] = "op=userquery&svrid=$svrid&user_address=$Server_Address&user_port=$Server_Port&";

        $serverlist[$i]['gobacklink'] = '<br>[ <a href="index.php"><b>' . _MD_FQ_GOBACK . '</b></a> ]';
    }

    $serverlist[$i]['type'] = $type;

    $serverlist[$i]['svrid'] = $svrid;

    $myserver = query_class($Server_Address, $Server_Port);

    $myserver->getdetails();

    $myserver->getplayers();

    // Server Name Heading

    if ('1' == $server_info['svr_name']) {
        if ('' == $myserver->mHostname()) {
            $svr_hostname = '' . _MD_FQ_SVRERROR . '';
        } else {
            $svr_hostname = $myserver->mHostname();
        }

        $serverlist[$i]['svr_hostname'] = $svr_hostname;
    }

    // Server Information Output

    if ('1' == $server_info['svr_address_on']) {
        $serverlist[$i]['Server_Address'] = $Server_Address;

        $serverlist[$i]['Server_Port'] = $Server_Port;
    }

    if ('1' == $server_info['svr_mod_desc']) {
        $serverlist[$i]['mDesc'] = $myserver->mDescr();
    }

    if ('1' == $server_info['svr_mod_version']) {
        $serverlist[$i]['mModVer'] = $myserver->mModVer();
    }

    if ('1' == $server_info['players_online']) {
        $serverlist[$i]['mActive'] = $myserver->mActive();

        $serverlist[$i]['mMax'] = $myserver->mMax();
    }

    if ('1' == $server_info['svr_type']) {
        if ('d' == $myserver->mSvrType()) {
            $Server_Type = '' . _MD_FQ_SVRDEDICATED . '';
        } else {
            $Server_Type = '' . _MD_FQ_SVRLISTEN . '';
        }

        $serverlist[$i]['Server_Type'] = $Server_Type;
    }

    if ('1' == $server_info['svr_os']) {
        if ('w' == $myserver->mSvrOS()) {
            $Server_OS = '' . _MD_FQ_SVRWINDOWS . '';
        } else {
            if ('l' == $myserver->mSvrOS()) {
                $Server_OS = '' . _MD_FQ_SVRLINUX . '';
            } else {
                $Server_OS = '' . _MD_FQ_SVRUNKNOWN . '';
            }
        }

        $serverlist[$i]['Server_OS'] = $Server_OS;
    }

    if ('1' == $server_info['svr_password']) {
        if ('0' == $myserver->mPass()) {
            $Server_Password = '' . _MD_FQ_SVRNOPASS . '';
        } else {
            if ('1' == $myserver->mPass()) {
                $Server_Password = '' . _MD_FQ_SVRPASSPROTECTED . '';
            } else {
                $Server_Password = '' . _MD_FQ_SVRPASSUNKNOWN . '';
            }
        }

        $serverlist[$i]['Server_Password'] = $Server_Password;
    }

    if ('1' == $server_info['svr_security']) {
        if ('0' == $myserver->mIsSecure()) {
            $Server_Secure = '' . _MD_FQ_SVRNOTSECURED . '';
        } else {
            if ('1' == $myserver->mIsSecure()) {
                $Server_Secure = '' . _MD_FQ_SVRSECURED . '';
            } else {
                $Server_Secure = '' . _MD_FQ_SVRUNKNOWNSECURED . '';
            }
        }

        $serverlist[$i]['Server_Secure'] = $Server_Secure;
    }

    if ('1' == $server_info['svr_ping']) {
        $serverlist[$i]['mPing'] = $myserver->mPing();
    }

    if ('1' == $server_info['svr_rules']) {
        $myserver->getrules();

        $rules = $myserver->mRules();

        $k = 0;

        foreach ($rules as $cvar => $value) {
            $serverlist[$i]['svr_rules'][$k]['cvar'] = $cvar;

            $serverlist[$i]['svr_rules'][$k]['value'] = $value;

            $k++;
        }
    }

    if ('0' == $myserver->mMap()) {
        $curr_mapname = '';
    } else {
        $curr_mapname = $myserver->mMap();
    }

    //$map_dl_name = map_dl_check($myserver->mMap());

    $map_dl_name = 'downloadmap.php?file=' . $curr_mapname;

    if ('1' == $server_info['svr_curr_mapname']) {
        $serverlist[$i]['map_dl_name'] = $map_dl_name;

        $serverlist[$i]['curr_mapname'] = $curr_mapname;
    }

    if ('1' == $server_info['svr_curr_mappic']) {
        $map_pic_name = mappic_name_check($myserver->mMap());

        $serverlist[$i]['map_dl_name'] = $map_dl_name;

        $serverlist[$i]['map_pic_name'] = $map_pic_name;
    }

    // Player Data Output Headings

    // $serverlist[$i]['player_sort_link']=$link;

    if ('1' == $server_info['svr_player_info'] && 0 != $myserver->mActive()) {
        // Sorting of the Player Array

        $tmp = $myserver->mPlayerData();

        if (isset($_GET['sort'])) {
            $sorted = 0;

            for ($k = 0; $k < count($tmp) - 1 && !$sorted; $k++) {
                $sorted = 1;

                for ($j = 0; $j < count($tmp) - 1; $j++) {
                    if (('frag' == $_GET['sort'] && $tmp[$j]['Frags'] < $tmp[$j + 1]['Frags']) ||
                        ('name' == $_GET['sort'] && strcasecmp($tmp[$j]['Name'], $tmp[$j + 1]['Name']) > 0) || ('time' == $_GET['sort'] && $tmp[$j]['Time'] < $tmp[$j + 1]['Time']) || ('kpm' == $_GET['sort'] && ($tmp[$j]['Frags'] / $tmp[$j]['Time'])
                        < ($tmp[$j + 1]['Frags'] / $tmp[$j + 1]['Time']))) {
                        //$tmp[$j]['totaltime']=date("H:i:s",mktime(0,(int)$tmp[$j]['Time'],(int)(60*($tmp[$j]['Time']-(int)$tmp[$j]['Time']))));

                        $temp = $tmp[$j];

                        $tmp[$j] = $tmp[$j + 1];

                        $tmp[$j + 1] = $temp;

                        $sorted = 0;
                    }
                }
            }
        }

        // Player Output Information

        $j = 0;

        foreach ($tmp as $plyr) {
            if ('' != $plyr['Name']) {//KPM code removed because its flawed... takes total players online time and divides by map kills
                //$Player_Info .="<td align=\"right\">".round($plyr["Frags"]/$plyr["Time"],1)."</td></tr>";

                $tmp[$j]['totaltime'] = date('H:i:s', mktime(0, (int)$tmp[$j]['Time'], (int)(60 * ($tmp[$j]['Time'] - (int)$tmp[$j]['Time']))));

                $tmp[$j]['kpm'] = round($tmp[$j]['Frags'] / $tmp[$j]['Time'], 1);

                $j++;
            }
        }

        $serverlist[$i]['playerlist'] = $tmp;
    }

    if ('1' == $server_info['svr_join']) {
        $serverlist[$i]['svr_join'] = $server_info['svr_join'];
    }
}

/***************************************/
/*            Case Statement           */
/***************************************/
if (!isset($op)) {
    $op = '';
}
if (!isset($sort)) {
    $sort = 'frag';
}
switch ($op) {
    default:
        $GLOBALS['xoopsOption']['template_main'] = 'fatalquery_index.html';
        require XOOPS_ROOT_PATH . '/header.php';
        $xoopsTpl->assign('page_title', $xoopsModuleConfig['page_title']);
        main($sort);
    break;
    case 'maps':
        $GLOBALS['xoopsOption']['template_main'] = 'fatalquery_maps.html';
        require XOOPS_ROOT_PATH . '/header.php';
        $xoopsTpl->assign('page_title', $xoopsModuleConfig['page_title']);
        maps();
    break;
    case 'No_DL_Avail':
        require XOOPS_ROOT_PATH . '/header.php';
        no_dl_avail();
    break;
    case 'map_dl':
        require XOOPS_ROOT_PATH . '/header.php';
        map_dl($map);
    break;
    case 'userquery':
        $GLOBALS['xoopsOption']['template_main'] = 'fatalquery_userquery.html';
        require XOOPS_ROOT_PATH . '/header.php';
        $xoopsTpl->assign('page_title', $xoopsModuleConfig['page_title']);
        userquery($svrid, $sort);
    break;
}
include 'footer.php';
