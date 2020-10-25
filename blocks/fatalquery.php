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
 *  Fatalquery Module - Block                                       *
 *                                                                  *
 *    Copyright (c) 2003 by FatalException Crew                     *
 *    http://www.fatalexception.us                                  *
 * *******************************************************************
 *    See madquery.php header for MadQuery Copyright Information    *
 *******************************************************************
 * @param $options
 * @return array
 */

function b_fatalquery_servers_show($options)
{
    global $xoopsDB;

    require_once XOOPS_ROOT_PATH . '/modules/fatalquery/madquery.php'; /* Must be valid for execution, and accessible to the web server */

    $myresult = $xoopsDB->query('SELECT * from ' . $xoopsDB->prefix('fatalquery_svrs') . " where block_status='1'");

    $sqlcount = $xoopsDB->getRowsNum($myresult);

    $block = [];

    while ($info = $xoopsDB->fetchArray($myresult)) {
        $server_var = [];

        $server_var['address'] = gethostbyname($info['svr_address']);

        $server_var['port'] = $info['svr_port'];

        $server = new madQuery($server_var['address'], $server_var['port']);

        $server->getdetails();

        $server->getplayers();

        $server_var['desc'] = $server->mDescr();

        $server_var['active'] = $server->mActive();

        $server_var['max'] = $server->mMax();

        if ('0' == $server->mMap()) {
            $server_var['map'] = '';
        } else {
            $server_var['map'] = shorten($server->mMap());
        }

        if ('' == $server->mHostname()) {
            $server_var['hostname'] = _MB_FQ_SVROFFLINE;
        } else {
            $server_var['hostname'] = $info['svr_uname'];
        }

        $server_var['lang_address'] = _MB_FQ_ADDRESS;

        $server_var['lang_port'] = _MB_FQ_SVRPORT;

        $server_var['lang_mod'] = _MB_FQ_MOD;

        $server_var['lang_online'] = _MB_FQ_ONLINE;

        $server_var['lang_map'] = _MB_FQ_MAP;

        $server_var['lang_players'] = _MB_FQ_PLAYERS;

        $server_var['lang_noservers'] = _MB_FQ_BLOCKNOSERVERS;

        $server_var['lang_moreinfo'] = _MB_FQ_MOREINFO;

        if ('date' == $options[0]) {
            $server_var['date'] = formatTimestamp($myrow['date'], 's');
        } elseif ('hits' == $options[0]) {
            $server_var['hits'] = $myrow['hits'];
        }

        $block['serverlisting'][] = $server_var;

        $block['count'] = $sqlcount;
    }

    return $block;
}

function shorten($var, $len = 13)
{
    $var = trim($var);

    if (empty($var)) {
        return '';
    }

    if (mb_strlen($var) < $len) {
        return $var;
    }

    if (preg_match("/(.{1,$len})\s/", $var, $match)) {
        return $match[1] . '...';
    }

    return mb_substr($var, 0, $len) . '...';
}
