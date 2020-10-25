<?php

function adminmenu($currentoption, $breadcrumb)
{
    global $xoopsModule, $xoopsConfig;

    $tblColors = [];

    $tblColors[0] = $tblColors[1] = $tblColors[2] = $tblColors[3] = $tblColors[4] = $tblColors[5] = '#DDE';

    $tblColors[$currentoption] = 'white';

    echo "<table width=100% class='outer'><tr><td align=right>
          <font size=2>" . _AM_FQ_MODULEADMIN . ' : ' . $xoopsModule->name() . ' : ' . $breadcrumb . '</font></td></tr></table><br>';

    echo '<div id="navcontainer"><ul style="padding: 3px 0; margin-left: 0; font: bold 12px Verdana, sans-serif; ">';

    echo '<li style="list-style: none; margin: 0; display: inline; ">
    <a href="index.php" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[0] . ';
     text-decoration: none; ">' . _AM_FQ_ADMININDEX . '</a></li>';

    echo '<li style="list-style: none; margin: 0; display: inline; ">
    <a href="index.php?op=FatalQuery_Admin_Servers&option=3" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[1] . ';
     text-decoration: none; ">' . _AM_FQ_ADMINADDSVR . '</a></li>';

    echo '<li style="list-style: none; margin: 0; display: inline; ">
    <a href="index.php?op=FatalQuery_Admin_Servers" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[2] . ';
     text-decoration: none; ">' . _AM_FQ_ADMINEDITGAMESVRS . '</a></li>';

    echo '<li style="list-style: none; margin: 0; display: inline; ">
    <a href="index.php?op=FatalQuery_Admin_Add" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[3] . ';
     text-decoration: none; ">' . _AM_FQ_ADMINADDMAP . '</a></li>';

    echo '<li style="list-style: none; margin: 0; display: inline; ">
    <a href="index.php?op=FatalQuery_Admin_Status" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[4] . ';
     text-decoration: none; ">' . _AM_FQ_ADMINMAPSTATUS . '</a></li>';

    echo '<li style="list-style: none; margin: 0; display: inline; ">
    <a href="index.php?op=FatalQuery_Admin_Delete" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[5] . ';
     text-decoration: none; ">' . _AM_FQ_ADMINDELETEMAP . '</a></li></div></ul><br>';
}

/*
* Whats this class/function for?
*
* To render a nice ordered menu for your modules.
* You can change the amount of cells per menu table, i.e. 2.3.4.5.6 etc and will render the cell class per cell
*
* The menu item can either be defined before you call adminmenu or you could change the menu array to you own taste.
*
*/

/**
 * adminmenu()
 *
 * @param string $header optional : You can gice the menu a nice header
 * @param string $extra  optional : You can gice the menu a nice footer
 * @param string $menu   required : This is an array of links. U can
 * @param int    $scount required : This will difine the amount of cells long the menu will have.
 *                       NB: using a value of 3 at the moment will break the menu where the cell colours will be off display.
 * @return void
 */

/*
* Notice: There is a slight problem with dealing with 3 cell menu.
* For some reason 3 doesn't convert well when divided by 2 ;-) You will always get 1.5 lol
* Will fix this issue but should be good enough to use now
*/

function adminindexmenu($header = '', $extra = '', $menu = '', $scount = 5)
{
    global $xoopsConfig, $xoopsModule;

    if (empty($menu)) {
        /*
        * You can change this part to suit your own module. Defining this here will save you form having to do this each time.
        */

        $menu = [
            _AM_FQ_GENERALSET => '' . XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $xoopsModule->getVar('mid') . '',
_AM_FQ_ADMINADDSVR => 'index.php?op=FatalQuery_Admin_Servers&option=3',
_AM_FQ_ADMINEDITGAMESVRS => 'index.php?op=FatalQuery_Admin_Servers',
_AM_FQ_ADMINADDMAP => 'index.php?op=FatalQuery_Admin_Add',
_AM_FQ_ADMINMAPSTATUS => 'index.php?op=FatalQuery_Admin_Status',
_AM_FQ_ADMINDELETEMAP => 'index.php?op=FatalQuery_Admin_Delete',
            ];
    }

    /*
    * the amount of cells per menu row
    */

    $count = 0;

    /*
    * Set up the first class
    */

    $class = 'even';

    /*
    * Sets up the width of each menu cell
    */

    $width = 100 / $scount;

    /*
    * Menu table begin
    */

    echo '<h3>' . $header . '</h3>';

    echo "<table width = '100%' cellpadding= '2' cellspacing= '1' class='outer'><tr>";

    /*
    * Check to see if $menu is and array
    */

    if (is_array($menu)) {
        foreach ($menu as $menutitle => $menulink) {
            $count++;

            echo "<td class='$class' align='center' valign='middle' width= $width%>";

            echo "<a href='" . $menulink . "'>" . $menutitle . '</a></td>';

            /*
            * Break menu cells to start a new row if $count > $scount
            */

            if ($count >= $scount) {
                /*
                * If $class is the same for the end and start cells, invert $class
                */

                $class = ((0 == ($count % 2)) && 'even' == $class) ? 'even' : 'odd';

                echo '</tr>';

                $count = 0;
            } else {
                $class = ('even' == $class) ? 'odd' : 'even';
            }
        }

        /*
        * checks to see if there are enough cell to fill menu row, if not add empty cells
        */

        if ($count >= 1) {
            $counter = 0;

            while ($counter < $scount - $count) {
                echo '<td class="' . $class . '">&nbsp;</td>';

                $class = ('even' == $class) ? 'odd' : 'even';

                $counter++;
            }
        }

        echo '</table>';
    }

    if ($extra) {
        echo "<br><div>$extra</div>";
    }
}
