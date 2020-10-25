<?php

/********************************************************************/
/*  FatalQuery Module 1.7.5                                           */
/*    -- admin main module                                          */
/*    Copyright (c) 2003 by nobleclem                               */
/*                          Fatalexception                          */
/*                          www.fatalexception.us                   */
/*                                                                  */
/*    For Support Information  Goto: www.fatalexception.us          */
/********************************************************************/

/****************************************************/
/*****       Admin Header Information Code      *****/
/****************************************************/
require dirname(__DIR__, 3) . '/include/cp_header.php';
require __DIR__ . '/adminmenu.php';

xoops_cp_header();

/****************************************************/
/*****        Add new map form and submit       *****/
/****************************************************/
function FatalQuery_Admin_Add()
{
    global $xoopsDB, $xoopsModuleConfig;

    $post_test = count($_POST);

    $PARAMS = $_POST;

    //submit code

    if ('0' != $post_test) {
        // Checks to see if the map already exists

        if ($xoopsDB->getRowsNum($xoopsDB->query('SELECT map_name from ' . $xoopsDB->prefix('fatalquery_maps') . " where map_name='$PARAMS[map_name]'")) > 0) {
            echo '<center>' . _AM_FQ_ADMINMAPEXSISTS . '<br>
				[ <a href="javascript:history.go(-1)">' . _AM_FQ_ADMINGOBACK . '</a> ]</center>';

            fqfooter();

            xoops_cp_footer();
        } elseif ('' != $PARAMS['map_name']) {
            $date = date('M-d-y');

            // Map Insertion Section

            $sql = 'INSERT INTO ' . $xoopsDB->prefix('fatalquery_maps') . "(map_name, in_rotation, date_added) VALUES('$PARAMS[map_name]', '$PARAMS[in_rotation]', '$date')";

            $xoopsDB->query($sql) or die('Unable to add data to ' . $xoopsDB->prefix('fatalquery_maps') . ' table: ' . $GLOBALS['xoopsDB']->error());

            // Map Insertion Complete output

            echo "<center>$PARAMS[map_name] " . _AM_FQ_ADMINMAPADDED . '<br><br>
				<a href="index.php?op=FatalQuery_Admin">' . _AM_FQ_ADMINMAINGOBACK . '</a>
     				 </center>';

            fqfooter();

            xoops_cp_footer();
        } else {
            echo '<center>' . _AM_FQ_ADMINMAPNONAME . '<br>
				[ <a href="javascript:history.go(-1)">' . _AM_FQ_ADMINGOBACK . '</a> ]</center>';

            fqfooter();

            xoops_cp_footer();
        }
    }

    // display add new map form

    if ('0' == $post_test) {
        echo '
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td align="center">
<table width="500" border="0" cellspacing="0">
        <tr> 
          <td colspan="4" align="center">
            <table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="100%" align="center"><u><b>' . _AM_FQ_ADMINADDMAPTITLE . '</b></u> </td>
              </tr>
              <tr> 
                <td align="center">&nbsp;</td>
              </tr>
              <tr> 
                <td align="center"> <form action="index.php?op=FatalQuery_Admin_Add&" method="post" name="add_new_map">
				<table width="400" border="0" cellpadding="0" cellspacing="0">
                      <tr align="center"> 
                        <td><strong>' . _AM_FQ_SVRMAP . '</strong></td>
                        <td><strong>' . _AM_FQ_ADMINMAPHEADING . '</strong></td>
                      </tr>
					  <tr> 
						<td rowspan="2" valign="top"><input name="map_name" type="text" value="" size="30"></td>
						<td>' . $xoopsModuleConfig['map_heading_1'] . ':</td>
						<td width="10"><input name="in_rotation" type="radio" value="1" checked></td>
					  </tr>
					  <tr> 
						<td>' . $xoopsModuleConfig['map_heading_2'] . ':</td>
						<td width="10"><input name="in_rotation" type="radio" value="0"></td>
					  </tr>
                    </table>
					  <p> 
                      <input type="submit" name="Submit" value="' . _AM_FQ_ADMINSUBMIT . '">
                      <input name="Reset" type="reset" value="' . _AM_FQ_ADMINRESET . '">
                    </p>
                  </form></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
		';

        fqfooter();

        xoops_cp_footer();
    }
}

/****************************************************/
/*****              Delete Map Code             ****
 * @param $submit
 * @param $map_name
 */
/****************************************************/
function FatalQuery_Admin_Delete($submit, $map_name)
{
    global $xoopsDB;

    $i = 0;

    if (1 == $submit) {
        $delete = $xoopsDB->query('DELETE from ' . $xoopsDB->prefix('fatalquery_maps') . " where map_name='$map_name'");

        echo "<center>$map_name " . _AM_FQ_ADMINMAPDELETED . '<br><br>
		<a href="index.php?op=FatalQuery_Admin">' . _AM_FQ_ADMINMAINGOBACK . '</a>
        </center>';

        fqfooter();

        xoops_cp_footer();
    }

    // Map Delete Confirmations

    else {
        if (2 == $submit) {
            echo '
		<p align="center"><b><font face="Geneva, Arial, Helvetica, san-serif">' . _AM_FQ_ADMINCONFIRMDELETETITLE . '</font></b></p> 
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr> 
	    <td align="center">
      <p>' . _AM_FQ_ADMINDELETECONFIRM . " $map_name?</p>
      <p><form action=index.php?op=FatalQuery_Admin_Delete method=post><input type=hidden name=submit value=1><input type=hidden name=map_name value=$map_name><input type=submit value=" . _AM_FQ_ADMINYES . '></form></p>
      <br></td>
	  </tr>
	</table>
	';

            fqfooter();

            xoops_cp_footer();
        }

        // Main Delete Output

        else {
            echo '<table align="center" border="0" cellspacing="0" cellpadding="0"><tr><td>';

            echo '<center><b>' . _AM_FQ_ADMINCHOOSEMAPDELETE . '</b></center><br><br>';

            $result = $xoopsDB->query('SELECT map_name from ' . $xoopsDB->prefix('fatalquery_maps') . ' ORDER BY map_name ');

            while ($maplist = $xoopsDB->fetchArray($result)) {
                if (0 == $i) {
                    echo '
		<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
   ';
                }

                if (1 == $i) {
                    echo '<td width="15">&nbsp;</td>';
                }

                echo "
   <td width=\"50%\" align=\"left\"><a href=\"index.php?op=FatalQuery_Admin_Delete&submit=2&map_name=$maplist[map_name]\">$maplist[map_name]</a></td>
";

                $i++;

                if (2 == $i) {
                    echo '
   </tr>
   </table>
';

                    $i = 0;
                }
            }

            if (0 != $i) {
                echo '
<td width="50%" align="center"></td>
   </tr>
   </table>
';

                $i = 0;
            }

            echo '</td></tr></table>';

            echo '<center><br><br>[ 
		<a href="index.php?op=FatalQuery_Admin">' . _AM_FQ_ADMINMAINGOBACK . '</a> ]
      </center>';

            fqfooter();

            xoops_cp_footer();
        }
    }
}

/****************************************************/
/*****            Change Rotation Code          ****
 * @param $map_name
 */
/****************************************************/
function FatalQuery_Admin_Change($map_name)
{
    global $xoopsDB;

    $result = $xoopsDB->query('SELECT in_rotation from ' . $xoopsDB->prefix('fatalquery_maps') . " where map_name='$map_name'");

    $mapinfo = $xoopsDB->fetchArray($result);

    if (0 == $mapinfo['in_rotation']) {
        $change = $xoopsDB->queryF('Update ' . $xoopsDB->prefix('fatalquery_maps') . " set in_rotation='1' where map_name='$map_name'");
    } else {
        $change = $xoopsDB->queryF('Update ' . $xoopsDB->prefix('fatalquery_maps') . " set in_rotation='0' where map_name='$map_name'");
    }

    header('Location: index.php?op=FatalQuery_Admin_Status');
}

/****************************************************/
/*****            Change Servers  Code          ****
 * @param string $option
 * @param string $svrid
 */
/****************************************************/
function FatalQuery_Admin_Servers($option = '0', $svrid = '')
{
    global $xoopsDB, $xoopsModuleConfig;

    $post_test = count($_POST);

    $PARAMS = $_POST;

    if ('1' != $option && '2' != $option && '3' != $option && '4' != $option) {
        $currentoption = '2';

        $breadcrumb = _AM_FQ_ADMINEDITGAMESVRS;

        adminmenu($currentoption, $breadcrumb);

        echo '<center><b>' . _AM_FQ_ADMINSVRADMIN . '</b></center><br>
<table align="center" border="0" cellspacing="0" cellpadding="0">
              <tr> 
			  	<td align="left"><strong>' . _AM_FQ_ADMINSVRNAME . '&nbsp;</strong>&nbsp;&nbsp;</td>
                <td align="left"><strong>' . _AM_FQ_SVRADDRESS . '&nbsp;</strong>&nbsp;&nbsp;</td>
				<td align="left"><strong>' . _AM_FQ_ADMINSTATUS . '&nbsp;</strong>&nbsp;&nbsp;</td>
                <td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
              </tr>
			  <tr><td colspan=5 bgcolor=black></td></tr>
';

        $result = $xoopsDB->query('SELECT svr_uname, svr_id, svr_address, svr_port from ' . $xoopsDB->prefix('fatalquery_svrs') . " WHERE svr_address='user_query'");

        $svrlist = $xoopsDB->fetchArray($result);

        $status = '' . _AM_FQ_ADMINNOTACTIVE . '';

        $delete = '';

        echo "
   <tr align=\"center\"> 
   <td align=\"left\" nowroap>$svrlist[svr_uname]&nbsp;&nbsp;&nbsp;</td>
   <td align=\"left\" nowrap>$svrlist[svr_address]:$svrlist[svr_port]&nbsp;&nbsp;&nbsp;</td>
   <td align=\"left\" nowrap>$status&nbsp;&nbsp;&nbsp;</td>
   <td align=\"center\" nowrap><a href=\"index.php?op=FatalQuery_Admin_Servers&option=1&svrid=$svrlist[svr_id]\">" . _AM_FQ_ADMINMODIFY . "</a>&nbsp;&nbsp;&nbsp;</td>
   <td align=\"center\" nowrap>$delete&nbsp;&nbsp;&nbsp;</td>   
   </tr>
";

        $result = $xoopsDB->query('SELECT svr_uname, svr_id, svr_address, svr_port, svr_status from ' . $xoopsDB->prefix('fatalquery_svrs') . ' ORDER BY svr_id ');

        while ($svrlist = $xoopsDB->fetchArray($result)) {
            if ('user_query' != $svrlist['svr_address']) {
                if (1 == $svrlist['svr_status']) {
                    $status = '' . _AM_FQ_ADMINACTIVE . '';
                } else {
                    $status = '' . _AM_FQ_ADMINNOTACTIVE . '';
                }

                if ($svrlist['svr_id'] != $xoopsModuleConfig['user_query_id']) {
                    $delete = "<a href=\"index.php?op=FatalQuery_Admin_Servers&option=2&svrid=$svrlist[svr_id]\">" . _AM_FQ_ADMINDELETE . '</a>';
                } else {
                    $delete = '';
                }

                echo "
   <tr align=\"center\"> 
   <td align=\"left\" nowroap>$svrlist[svr_uname]&nbsp;&nbsp;&nbsp;</td>
   <td align=\"left\" nowrap>$svrlist[svr_address]:$svrlist[svr_port]&nbsp;&nbsp;&nbsp;</td>
   <td align=\"left\" nowrap>$status&nbsp;&nbsp;&nbsp;</td>
   <td align=\"center\" nowrap><a href=\"index.php?op=FatalQuery_Admin_Servers&option=1&svrid=$svrlist[svr_id]\">" . _AM_FQ_ADMINMODIFY . "</a>&nbsp;&nbsp;&nbsp;</td>
   <td align=\"center\" nowrap>$delete&nbsp;&nbsp;&nbsp;</td>   
   </tr>
";
            }
        }

        echo '<tr><td colspan="2">
</td></tr>
</table><br><br>
<center>[ <a href="index.php?op=FatalQuery_Admin">' . _AM_FQ_ADMINMAINGOBACK . '</a> ]</center>
';
    }

    if ('0' == $post_test && '1' == $option) {
        $currentoption = '2';

        $breadcrumb = _AM_FQ_ADMINEDITGAMESVRS;

        adminmenu($currentoption, $breadcrumb);

        $result = $xoopsDB->query('SELECT * from ' . $xoopsDB->prefix('fatalquery_svrs') . " where svr_id='$svrid'");

        $svrinfo = $xoopsDB->fetchArray($result);

        if ('1' == $svrinfo['svr_status']) {
            $status_checked_on = 'checked';

            $status_checked_off = 'unchecked';
        } else {
            $status_checked_on = 'unchecked';

            $status_checked_off = 'checked';
        }

        if ('1' == $svrinfo['svr_name']) {
            $sn_checked_on = 'checked';

            $sn_checked_off = 'unchecked';
        } else {
            $sn_checked_on = 'unchecked';

            $sn_checked_off = 'checked';
        }

        if ('1' == $svrinfo['svr_address_on']) {
            $sa_checked_on = 'checked';

            $sa_checked_off = 'unchecked';
        } else {
            $sa_checked_on = 'unchecked';

            $sa_checked_off = 'checked';
        }

        if ('1' == $svrinfo['svr_mod_desc']) {
            $md_checked_on = 'checked';

            $md_checked_off = 'unchecked';
        } else {
            $md_checked_on = 'unchecked';

            $md_checked_off = 'checked';
        }

        if ('1' == $svrinfo['svr_mod_version']) {
            $mv_checked_on = 'checked';

            $mv_checked_off = 'unchecked';
        } else {
            $mv_checked_on = 'unchecked';

            $mv_checked_off = 'checked';
        }

        if ('1' == $svrinfo['players_online']) {
            $po_checked_on = 'checked';

            $po_checked_off = 'unchecked';
        } else {
            $po_checked_on = 'unchecked';

            $po_checked_off = 'checked';
        }

        if ('1' == $svrinfo['svr_type']) {
            $st_checked_on = 'checked';

            $st_checked_off = 'unchecked';
        } else {
            $st_checked_on = 'unchecked';

            $st_checked_off = 'checked';
        }

        if ('1' == $svrinfo['svr_os']) {
            $so_checked_on = 'checked';

            $so_checked_off = 'unchecked';
        } else {
            $so_checked_on = 'unchecked';

            $so_checked_off = 'checked';
        }

        if ('1' == $svrinfo['svr_password']) {
            $sp_checked_on = 'checked';

            $sp_checked_off = 'unchecked';
        } else {
            $sp_checked_on = 'unchecked';

            $sp_checked_off = 'checked';
        }

        if ('1' == $svrinfo['svr_security']) {
            $ss_checked_on = 'checked';

            $ss_checked_off = 'unchecked';
        } else {
            $ss_checked_on = 'unchecked';

            $ss_checked_off = 'checked';
        }

        if ('1' == $svrinfo['svr_ping']) {
            $ping_checked_on = 'checked';

            $ping_checked_off = 'unchecked';
        } else {
            $ping_checked_on = 'unchecked';

            $ping_checked_off = 'checked';
        }

        if ('1' == $svrinfo['svr_player_info']) {
            $pi_checked_on = 'checked';

            $pi_checked_off = 'unchecked';
        } else {
            $pi_checked_on = 'unchecked';

            $pi_checked_off = 'checked';
        }

        if ('1' == $svrinfo['svr_rules']) {
            $sr_checked_on = 'checked';

            $sr_checked_off = 'unchecked';
        } else {
            $sr_checked_on = 'unchecked';

            $sr_checked_off = 'checked';
        }

        if ('1' == $svrinfo['svr_curr_mapname']) {
            $cm_checked_on = 'checked';

            $cm_checked_off = 'unchecked';
        } else {
            $cm_checked_on = 'unchecked';

            $cm_checked_off = 'checked';
        }

        if ('1' == $svrinfo['svr_curr_mappic']) {
            $pic_checked_on = 'checked';

            $pic_checked_off = 'unchecked';
        } else {
            $pic_checked_on = 'unchecked';

            $pic_checked_off = 'checked';
        }

        if ('1' == $svrinfo['block_status']) {
            $block_checked_on = 'checked';

            $block_checked_off = 'unchecked';
        } else {
            $block_checked_on = 'unchecked';

            $block_checked_off = 'checked';
        }

        if ('1' == $svrinfo['svr_join']) {
            $join_checked_on = 'checked';

            $join_checked_off = 'unchecked';
        } else {
            $join_checked_on = 'unchecked';

            $join_checked_off = 'checked';
        }

        echo '
<table align="center" width="500" border="0" cellspacing="0">
        <tr> 
          <td colspan="4" align="center">
            <table width="100%" border="0" cellspacing="0">
              <tr> 
                <td width="100%" align="center"><u><b>' . _AM_FQ_ADMINEDITTITLE . "</b></u></td>
              </tr>
              <tr> 
                <td align=\"center\">&nbsp;</td>
              </tr>
              <tr> 
                <td align=\"center\">
				<form action=\"index.php?op=FatalQuery_Admin_Servers&option=1&svrid=$svrinfo[svr_id]\" method=\"post\">
					<table width=\"100%\" border=\"0\">
                      <tr align=\"center\"> 
					    <td><strong>" . _AM_FQ_ADMINSVRNAME . '</strong></td>';

        if ($svrinfo['svr_id'] != $xoopsModuleConfig['user_query_id']) {
            echo '<td><strong>' . _AM_FQ_ADMINSVRADDRESS . '</strong></td>
                        <td><strong>' . _AM_FQ_ADMINSVRPORTINFO . '</strong></td>';
        }

        echo "</tr>
                      <tr align=\"center\"> 
					    <td> <input name=\"svr_uname\" type=\"text\" value=\"$svrinfo[svr_uname]\" size=\"20\"</td>";

        if ($svrinfo['svr_id'] != $xoopsModuleConfig['user_query_id']) {
            echo "<td> <input name=\"svr_address\" type=\"text\" value=\"$svrinfo[svr_address]\" size=\"25\"></td>
                        <td> <input name=\"svr_port\" type=\"text\" value=\"$svrinfo[svr_port]\" size=\"10\"></td>";
        } else {
            echo "<input name=\"svr_address\" type=\"hidden\" value=\"$svrinfo[svr_address]\"><input name=\"svr_port\" type=\"hidden\" value=\"$svrinfo[svr_port]\">";
        }

        echo '</tr>
                    </table>
                    <table width="450" border="0" cellspacing="0" cellpadding="0">
					';

        if ($svrinfo['svr_id'] != $xoopsModuleConfig['user_query_id']) {
            echo '
					  <tr>
					  <td colspan="2"><b>' . _AM_FQ_ADMINSTATUS . "</b>:&nbsp;
					  <label><input name=\"svr_status\" type=\"radio\" value=\"1\" $status_checked_on></label><label> " . _AM_FQ_ADMINACTIVE . " 
                      <input name=\"svr_status\" type=\"radio\" value=\"0\" $status_checked_off>" . _AM_FQ_ADMINNOTACTIVE . '</label>
					  </td>
					  </tr>
					  ';
        } else {
            echo "<input name=\"svr_status\" type=\"hidden\" value=\"$svrinfo[svr_status]\">";
        }

        echo '
                      <tr> 
                        <td><b>' . _AM_FQ_ADMINSVRNAME . "</b> 
                          <label> </label> <label></label></td>
                        <td><label> 
                          <input name=\"svr_name\" type=\"radio\" value=\"1\" $sn_checked_on>
                          </label> <label> " . _AM_FQ_ADMINON . " 
                          <input name=\"svr_name\" type=\"radio\" value=\"0\" $sn_checked_off>
                          " . _AM_FQ_ADMINOFF . '</label></td>
                        <td><b>' . _AM_FQ_ADMINPLYRSON . "</b> </td>
                        <td><label> 
                          <input name=\"players_online\" type=\"radio\" value=\"1\" $po_checked_on>
                          </label> <label> " . _AM_FQ_ADMINON . " 
                          <input name=\"players_online\" type=\"radio\" value=\"0\" $po_checked_off>
                          " . _AM_FQ_ADMINOFF . '</label></td>
                      </tr>
                      <tr> 
                        <td><b>' . _AM_FQ_ADMINSVRADDRESS . "</b></td>
                        <td><label> 
                          <input name=\"svr_addy\" type=\"radio\" value=\"1\" $sa_checked_on>
                          </label> <label> " . _AM_FQ_ADMINON . " 
                          <input name=\"svr_addy\" type=\"radio\" value=\"0\" $sa_checked_off>
                          " . _AM_FQ_ADMINOFF . '</label></td>
                        <td><b>' . _AM_FQ_ADMINSVRTYPE . "</b></td>
                        <td><label> 
                          <input name=\"svr_type\" type=\"radio\" value=\"1\" $st_checked_on>
                          </label> <label> " . _AM_FQ_ADMINON . " 
                          <input name=\"svr_type\" type=\"radio\" value=\"0\" $st_checked_off>
                          " . _AM_FQ_ADMINOFF . '</label></td>
                      </tr>
                      <tr> 
                        <td><b>' . _AM_FQ_ADMINSVRPING . "</b></td>
                        <td><label>
                          <input name=\"svr_ping\" type=\"radio\" value=\"1\" $ping_checked_on>
                          </label> <label> " . _AM_FQ_ADMINON . " 
                          <input name=\"svr_ping\" type=\"radio\" value=\"0\" $ping_checked_off>
                          " . _AM_FQ_ADMINOFF . '</label></td>
                        <td><b>' . _AM_FQ_ADMINSVROS . "</b></td>
                        <td><label> 
                          <input name=\"svr_os\" type=\"radio\" value=\"1\" $so_checked_on>
                          </label> <label> " . _AM_FQ_ADMINON . " 
                          <input name=\"svr_os\" type=\"radio\" value=\"0\" $so_checked_off>
                          " . _AM_FQ_ADMINOFF . '</label></td>
                      </tr>
                      <tr> 
                        <td><b>' . _AM_FQ_ADMINSVRMOD . "</b></td>
                        <td><label> 
                          <input name=\"svr_mod_desc\" type=\"radio\" value=\"1\" $md_checked_on>
                          </label> <label> " . _AM_FQ_ADMINON . " 
                          <input name=\"svr_mod_desc\" type=\"radio\" value=\"0\" $md_checked_off>
                          " . _AM_FQ_ADMINOFF . '</label></td>
                        <td><b>' . _AM_FQ_ADMINSVRPASS . "</b></td>
                        <td><label> 
                          <input name=\"svr_password\" type=\"radio\" value=\"1\" $sp_checked_on>
                          </label> <label> " . _AM_FQ_ADMINON . " 
                          <input name=\"svr_password\" type=\"radio\" value=\"0\" $sp_checked_off>
                          " . _AM_FQ_ADMINOFF . '</label></td>
                      </tr>
                      <tr> 
                        <td><b>' . _AM_FQ_ADMINSVRMODVER . "</b></td>
                        <td><label> 
                          <input name=\"svr_mod_version\" type=\"radio\" value=\"1\" $mv_checked_on>
                          </label> <label> " . _AM_FQ_ADMINON . " 
                          <input name=\"svr_mod_version\" type=\"radio\" value=\"0\" $mv_checked_off>
                          " . _AM_FQ_ADMINOFF . '</label></td>
                        <td><b>' . _AM_FQ_ADMINSVRSECURED . "</b></td>
                        <td><label> 
                          <input name=\"svr_security\" type=\"radio\" value=\"1\" $ss_checked_on>
                          </label> <label> " . _AM_FQ_ADMINON . " 
                          <input name=\"svr_security\" type=\"radio\" value=\"0\" $ss_checked_off>
                          " . _AM_FQ_ADMINOFF . '</label></td>
                      </tr>
                      <tr> 
                        <td><b>' . _AM_FQ_ADMINSVRMAPPIC . "</b></td>
                        <td><label>
                          <input name=\"svr_curr_mappic\" type=\"radio\" value=\"1\" $pic_checked_on>
                          </label> <label> " . _AM_FQ_ADMINON . " 
                          <input name=\"svr_curr_mappic\" type=\"radio\" value=\"0\" $pic_checked_off>
                          " . _AM_FQ_ADMINOFF . '</label></td>
                        <td><b>' . _AM_FQ_ADMINPLYRINFO . "</b></td>
                        <td><label> 
                          <input name=\"svr_player_info\" type=\"radio\" value=\"1\" $pi_checked_on>
                          </label> <label> " . _AM_FQ_ADMINON . " 
                          <input name=\"svr_player_info\" type=\"radio\" value=\"0\" $pi_checked_off>
                          " . _AM_FQ_ADMINOFF . '</label></td>
                      </tr>
                      <tr>
                        <td><b>' . _AM_FQ_ADMINSVRRULES . "</b></td>
                        <td><label> 
                          <input name=\"svr_rules\" type=\"radio\" value=\"1\" $sr_checked_on>
                          </label> <label> " . _AM_FQ_ADMINON . " 
                          <input name=\"svr_rules\" type=\"radio\" value=\"0\" $sr_checked_off>
                          " . _AM_FQ_ADMINOFF . '</label></td> 
                        <td><b>' . _AM_FQ_SVRMAP . "</b></td>
                        <td><label> 
                          <input name=\"svr_curr_mapname\" type=\"radio\" value=\"1\" $cm_checked_on>
                          </label> <label> " . _AM_FQ_ADMINON . " 
                          <input name=\"svr_curr_mapname\" type=\"radio\" value=\"0\" $cm_checked_off>
                          " . _AM_FQ_ADMINOFF . '</label></td> 
                      </tr>
					  ';

        if ($svrinfo['svr_id'] != $xoopsModuleConfig['user_query_id']) {
            echo '
                        <td><b>' . _AM_FQ_ADMINBLOCKSTATUS . "</b></td>
                        <td><label> 
                          <input name=\"block_status\" type=\"radio\" value=\"1\" $block_checked_on>
                          </label> <label> " . _AM_FQ_ADMINON . " 
                          <input name=\"block_status\" type=\"radio\" value=\"0\" $block_checked_off>
                          " . _AM_FQ_ADMINOFF . ' </label></td>
						  ';
        } else {
            echo "<input name=\"block_status\" type=\"hidden\" value=\"$svrinfo[block_status]\">";
        }

        echo '
                        <td><b>' . _AM_FQ_ADMINJOINLINK . "</b></td>
                        <td><label> 
                          <input name=\"svr_join\" type=\"radio\" value=\"1\" $join_checked_on>
                          </label> <label> " . _AM_FQ_ADMINON . " 
                          <input name=\"svr_join\" type=\"radio\" value=\"0\" $join_checked_off>
                          " . _AM_FQ_ADMINOFF . ' </label></td> 
                      </tr>					  
                    </table>
                    <p> 
                      <input type="submit" name="Submit" value="' . _AM_FQ_ADMINSUBMIT . '">
                      <input name="Reset" type="reset" value="' . _AM_FQ_ADMINRESET . '">
                    </p>
                  </form></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
';
    }

    if ('0' != $post_test && '1' == $option) {
        $xoopsDB->query('Update ' . $xoopsDB->prefix('fatalquery_svrs') . " set 
svr_uname='$PARAMS[svr_uname]', 
svr_address='$PARAMS[svr_address]', svr_port='$PARAMS[svr_port]', svr_status='$PARAMS[svr_status]', 
svr_name ='$PARAMS[svr_name]', svr_mod_desc='$PARAMS[svr_mod_desc]',
svr_mod_version='$PARAMS[svr_mod_version]', players_online='$PARAMS[players_online]', 
svr_address_on='$PARAMS[svr_addy]', svr_password='$PARAMS[svr_password]', 
svr_os='$PARAMS[svr_os]', svr_type='$PARAMS[svr_type]', 
svr_ping='$PARAMS[svr_ping]', svr_security='$PARAMS[svr_security]', 
svr_player_info='$PARAMS[svr_player_info]', block_status='$PARAMS[block_status]',
svr_curr_mappic='$PARAMS[svr_curr_mappic]', svr_curr_mapname='$PARAMS[svr_curr_mapname]', 
svr_rules='$PARAMS[svr_rules]', svr_join='$PARAMS[svr_join]' 
where svr_id='$svrid'");

        header('Location: index.php?op=FatalQuery_Admin_Servers');
    }

    if ('3' == $option) {
        $currentoption = '1';

        $breadcrumb = _AM_FQ_ADMINADDSVR;

        adminmenu($currentoption, $breadcrumb);

        echo '
<table align="center" width="500" border="0" cellspacing="0">
        <tr>
          <td colspan="4" align="center">
            <table width="100%" border="0" cellspacing="0">
              <tr> 
                <td width="100%" align="center"><u><b>' . _AM_FQ_ADMINADDTITLE . '</b></u></td>
              </tr>
              <tr> 
                <td align="center">&nbsp;</td>
              </tr>
              <tr> 
                <td align="center"> <form action="index.php?op=FatalQuery_Admin_Servers&option=3" method="post" name="edit_server" id="edit_server">
<table width="100%" border="0">
                      <tr align="center"> 
					  	<td><strong>' . _AM_FQ_ADMINSVRNAME . '</strong></td>
                        <td><strong>' . _AM_FQ_ADMINSVRADDRESS . '</strong></td>
                        <td><strong>' . _AM_FQ_ADMINSVRPORTINFO . '</strong></td>
                      </tr>
                      <tr align="center"> 
					  	<td> <input name="svr_uname" type="text" id="svr_uname" value="" size="20"></td>
                        <td> <input name="svr_address" type="text" id="svr_address" value="" size="25"></td>
                        <td> <input name="svr_port" type="text" id="svr_port" value="27015" size="10"></td>
                      </tr>
                    </table>
                    <p> 
                      <input type="submit" name="Submit" value="' . _AM_FQ_ADMINSUBMIT . '">
                      <input name="Reset" type="reset" value="' . _AM_FQ_ADMINRESET . '">
                    </p>
                  </form></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
';
    }

    if ('3' == $option && '0' != $post_test) {
        if ('' != $PARAMS['svr_uname'] && '' != $PARAMS['svr_address'] && '' != $PARAMS['svr_port']) {
            $xoopsDB->query('INSERT INTO ' . $xoopsDB->prefix('fatalquery_svrs') . " (svr_uname, svr_address, svr_port) VALUES('$PARAMS[svr_uname]','$PARAMS[svr_address]','$PARAMS[svr_port]')");
        }

        header('Location: index.php?op=FatalQuery_Admin_Servers');
    }

    if ('2' == $option) {
        $currentoption = '2';

        $breadcrumb = _AM_FQ_ADMINDELETEGAMESVRS;

        adminmenu($currentoption, $breadcrumb);

        $result = $xoopsDB->query('SELECT svr_uname, svr_address, svr_port FROM ' . $xoopsDB->prefix('fatalquery_svrs') . " WHERE svr_id='$svrid'");

        $server_info = $xoopsDB->fetchArray($result);

        echo '
		<p align="center"><b><font face="Geneva, Arial, Helvetica, san-serif">' . _AM_FQ_ADMINCONFIRMSVRDELETETITLE . '</font></b></p> 
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
	    <td align="center">
      <p>' . _AM_FQ_ADMINCONFIRMSVRDELETE . ':<br><br>
	  <b>' . _AM_FQ_ADMINSVRNAME . ":</b> $server_info[svr_uname]<br>
	  <b>" . _AM_FQ_ADMINSVRADDRESS . ":</b> $server_info[svr_address]:$server_info[svr_port]</p>
      <p><form action=index.php?op=FatalQuery_Admin_Servers method=post><input type=hidden name=option value=4><input type=hidden name=svrid value=$svrid><input type=submit value=" . _AM_FQ_ADMINYES . '></form></p>
      <br></td>
	  </tr>
	</table>
';
    }

    if ('4' == $option) {
        $sql = 'DELETE from ' . $xoopsDB->prefix('fatalquery_svrs') . " where svr_id='$svrid'";

        $xoopsDB->query($sql) or die('error ' . $GLOBALS['xoopsDB']->error());

        header('Location: index.php?op=FatalQuery_Admin_Servers');
    }

    fqfooter();

    xoops_cp_footer();
}

/****************************************************/
/*****          Change Map Status Page          *****/
/****************************************************/
function FatalQuery_Admin_Status()
{
    global $xoopsDB, $xoopsModuleConfig;

    echo '<center><b>' . _AM_FQ_ADMINMAPADMINTITLE . '</b></center><br>
<table align="center" border="0" cellspacing="0" cellpadding="0">
<tr><td colspan="2"></td></tr>
<tr><td></td></tr>
              <tr> 
                <td align="left"><u><strong>' . _AM_FQ_SVRMAP . '</strong>&nbsp;&nbsp;</u></td>
                <td align="center"><u><strong>' . _AM_FQ_ADMINMAPHEADING . '</strong></u></td>
              </tr>
';

    $result = $xoopsDB->query('SELECT map_name, in_rotation from ' . $xoopsDB->prefix('fatalquery_maps') . ' ORDER BY map_name ');

    while ($maplist = $xoopsDB->fetchArray($result)) {
        if (1 == $maplist['in_rotation']) {
            $mapactivestate = $xoopsModuleConfig['map_heading_1'];
        } else {
            $mapactivestate = $xoopsModuleConfig['map_heading_2'];
        }

        echo "
   <tr align=\"center\"> 
   <td align=\"left\">$maplist[map_name]</td>
   <td align=\"center\"><a href=\"index.php?op=FatalQuery_Admin_Change&map_name=$maplist[map_name]\">$mapactivestate</a></td>
   </tr>
";
    }

    echo '<tr><td colspan="2">
</td></tr>
</table><br><br>
<center>[ <a href="index.php?op=FatalQuery_Admin">' . _AM_FQ_ADMINMAINGOBACK . '</a> ]</center>
';

    fqfooter();

    xoops_cp_footer();
}

function fqfooter()
{
    echo '<center>' . _AM_FQ_ADMINCOPYRIGHT . '</center>';
}
/****************************************************/
/*****              End Of Functions            *****/
/****************************************************/
if (!isset($op)) {
    $op = '';
}
switch ($op) {
    default:
        $currentoption = '0';
        $breadcrumb = _AM_FQ_ADMININDEX;
        adminmenu($currentoption, $breadcrumb);
        adminindexmenu('', '', '', '3');
        xoops_cp_footer();
        break;
    case 'FatalQuery_Admin_Servers':
        if (!isset($svrid)) {
            $svrid = '';
        }
        if (!isset($option)) {
            $option = '';
        }
        FatalQuery_Admin_Servers($option, $svrid);
        break;
    case 'FatalQuery_Admin_Add':
        $currentoption = '3';
        $breadcrumb = _AM_FQ_ADMINADDMAP;
        adminmenu($currentoption, $breadcrumb);
        FatalQuery_Admin_Add();
        break;
    case 'FatalQuery_Admin_Status':
        $currentoption = '4';
        $breadcrumb = _AM_FQ_ADMINMAPSTATUS;
        adminmenu($currentoption, $breadcrumb);
        FatalQuery_Admin_Status();
        break;
    case 'FatalQuery_Admin_Change':
        $currentoption = '4';
        $breadcrumb = _AM_FQ_ADMINCHANGEMAPSTATUS;
        adminmenu($currentoption, $breadcrumb);
        FatalQuery_Admin_Change($map_name);
        break;
    case 'FatalQuery_Admin_Delete':
        $currentoption = '5';
        $breadcrumb = _AM_FQ_ADMINDELETEMAP;
        adminmenu($currentoption, $breadcrumb);
        if (!isset($submit)) {
            $submit = '';
        }
        if (!isset($map_name)) {
            $map_name = '';
        }
        FatalQuery_Admin_Delete($submit, $map_name);
        break;
}
