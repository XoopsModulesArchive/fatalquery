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

require __DIR__ . '/header.php';
global $xoopsDB, $xoopsModuleConfig;
$map_dl_location = $xoopsModuleConfig['map_dl_location'];
// $filename = getenv("QUERY_STRING");
if (isset($_GET['file'])) {
    $mapdlname = $_GET['file'] . $xoopsModuleConfig['map_dl_ext'] . '';
} else {
    $mapdlname = '';
}

if ('' == $mapdlname) {
    redirect_header('index.php?op=maps', 3, _MD_FQ_NODLAVAILYET);
}

if (eregi('.*://.*', $map_dl_location)) {
    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('fatalquery_maps') . " set map_dl_count=map_dl_count+1 where map_name='" . $_GET['file'] . "'");

    header("Location: $map_dl_location/$mapdlname");
} else {
    if (!eregi('^/.*', $map_dl_location) && !eregi("\.\./.*", $map_dl_location)) {
        $map_dl_location = './' . $map_dl_location;
    }

    if (is_file($map_dl_location . '/' . $mapdlname)) {
        $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('fatalquery_maps') . " set map_dl_count=map_dl_count+1 where map_name='" . $_GET['file'] . "'");

        $fp = @fopen($map_dl_location . '/' . $mapdlname, 'rb');

        //	}

        //if(isset($fp)) {

        $content_len = filesize($map_dl_location . '/' . $mapdlname);

        $content_file = fread($fp, $content_len);

        fclose($fp);

        @ob_end_clean();

        @ini_set('zlib.output_compression', 'Off');

        header('Pragma: public');

        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

        header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
        header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
        header('Content-Transfer-Encoding: none');

        header('Content-Type: application/octetstream; name="' . $mapdlname . '"'); //This should work for IE & Opera
        header('Content-Type: application/octet-stream; name="' . $mapdlname . '"'); //This should work for the rest
        header('Content-Disposition: inline; filename="' . $mapdlname . '"');

        header("Content-length: $content_len");

        echo $content_file;

        exit();
    }

    redirect_header('index.php?op=maps', 3, _MD_FQ_NODLAVAILYET . $mapdlname);
}
