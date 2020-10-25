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
/***************************************************
 * Copyright (C) 2002 madCoder                     *
 * http://www.utdallas.edu/~madcoder/              *
 * COMMENTS (NO support requests)may be sent to:   *
 *    madCoder@student.utdallas.edu                *
 ***************************************************
 * Use of this class assumes agreement to all      *
 * of the following terms of use:                  *
 ***************************************************
 * 1) This class is provided as-is, with no        *
 *    offering of technical support, or help       *
 *    in any way with setting up this class.       *
 * 2) madCoder will not, in any way, take          *
 *    responsibility for what you do with this     *
 *    script.                                      *
 * 3) This class may not be reproduced, or         *
 *    altered, without prior authoriazation from   *
 *    madCoder.                                    *
 * 4) ALL Copyright and credit notices MUST remain *
 *    intact, as released.                         *
 ***************************************************/

define('ERROR_NOERROR', 0);
define('ERROR_NOSERVER', -1);
define('ERROR_INSOCKET', -2);
//define("DEBUG",1);

function get_float32($fourchars)
{
    $bin = '';

    for ($loop = 0; $loop <= 3; $loop++) {
        $bin = str_pad(decbin(ord(mb_substr($fourchars, $loop, 1))), 8, '0', STR_PAD_LEFT) . $bin;
    }

    $exponent = bindec(mb_substr($bin, 1, 8));

    $exponent = ($exponent) ? $exponent - 127 : $exponent;

    if ($exponent) {
        $int = bindec('1' . mb_substr($bin, 9, $exponent));

        $dec = bindec(mb_substr($bin, 9 + $exponent));

        $time = "$int.$dec";

        return number_format($time / 60, 2);
    }

    return 0.0;
}

/******
 * getmicrotime()
 * as provided in the PHP manual
 ******/
function getmicrotime()
{
    [$usec, $sec] = explode(' ', microtime());

    return ((float)$usec + (float)$sec);
}

function dodebug($dbgstr = '')
{
    if (defined('DEBUG')) {
        echo '<!-- [DEBUG] ' . $dbgstr . " -->\n";
    }
}
/***********************************************
 * madQuery Class
 ***********************************************/
class madQuery
{
    public $_arr = [];

    public $_ip = '';

    public $_port = 0;

    public $_isconnected = 0;

    public $_players = [];

    public $_rules = [];

    public $_errorcode = ERROR_NOERROR;

    public $_seed = 'madQuery for server (%s:%d)';

    public $_sk; //socket

    //Constructor

    public function __construct($serverip, $serverport = 27015)
    {
        $this->_ip = $serverip;

        $this->_port = $serverport;

        $this->_seed = "\x0a\x3c\x21\x2d\x2d\x20\x20\x20\x20\x20\x20\x20\x53\x65\x72\x76\x65\x72\x20\x6d\x61\x64\x51\x75\x65\x72\x79\x20\x43"
                . "\x6c\x61\x73\x73\x20\x20\x20\x20\x20\x20\x20\x2d\x2d\x3e\x0a\x3c\x21\x2d\x2d\x20\x20\x20\x20\x43\x6f\x70\x79\x72\x69"
                . "\x67\x68\x74\x20\x28\x43\x29\x20\x32\x30\x30\x32\x20\x6d\x61\x64\x43\x6f\x64\x65\x72\x20\x20\x20\x20\x2d\x2d\x3e\x0a"
                . "\x3c\x21\x2d\x2d\x20\x20\x20\x6d\x61\x64\x63\x6f\x64\x65\x72\x40\x73\x74\x75\x64\x65\x6e\x74\x2e\x75\x74\x64\x61\x6c"
                . "\x6c\x61\x73\x2e\x65\x64\x75\x20\x20\x20\x2d\x2d\x3e\x0a\x3c\x21\x2d\x2d\x20\x68\x74\x74\x70\x3a\x2f\x2f\x77\x77\x77"
                . "\x2e\x75\x74\x64\x61\x6c\x6c\x61\x73\x2e\x65\x64\x75\x2f\x7e\x6d\x61\x64\x63\x6f\x64\x65\x72\x20\x2d\x2d\x3e\x0a\x0a";

        $this->_arr = array_pad($this->_arr, 21, 0);

        $this->_sk = fsockopen('udp://' . $this->_ip, $this->_port, $errno, $errstr, 3);

        stream_set_timeout($this->_sk, 2, 0);

        if ($tmp = $this->_sockstate()) {
            //echo $tmp;

            if (!$this->_sk) {
                echo 'ERROR #' . $errno . ': ' . $errstr;
            }

            //exit;
        }

        dodebug('[Initialized]');

        //	$this->_brand_seed();

        return !(!$this->_sk);
    }

    //Sets error code

    public function seterror($code)
    {
        dodebug('[Setting Error Code (' . $code . ")]<BR>\n");

        $this->_errorcode = $code;
    }

    //Obtains ping value to server

    public function _ping()
    {
        dodebug('[Getting Ping]');

        if ($tmp = $this->_sockstate()) {
            //echo $tmp;

            dodebug('[Error in Socket]');

            $this->seterror(ERROR_INSOCKET);

            return -1; //Error in socket
        }

        $tmp = '';

        $start = getmicrotime() * 1000;

        $this->_send('ÿÿÿÿping' . chr(0));

        while (mb_strlen($tmp) < 4 && (getmicrotime() * 1000 - $start) < 1000) {
            $tmp = $this->_getmore();
        }

        if (mb_strlen($tmp) >= 4 && 'j' == mb_substr($tmp, 4, 1)) {
            $end = getmicrotime() * 1000;

            if ($end < $start) {
                echo $end . '\n' . $start;
            }

            return ($end - $start); //($end-$start)>=0 ? ($end-$start) : -1; //Will be numeric ping
        }

        //echo "Server didn't respond!";

        //exit;

        $this->seterror(ERROR_NOSERVER);

        dodebug('[ERROR: No pong from server]');

        return -1; //Server isn't responding...
        return 0;
    }

    //Populates details array

    public function getdetails()
    {
        dodebug('[Getting Details]');

        if ($tmp = $this->_sockstate()) {
            //echo $tmp;

            $this->seterror(ERROR_INSOCKET);

            return -1;
        }

        $this->_send('ÿÿÿÿdetails' . chr(0));

        $buffer = $this->_getmore();

        /*echo $buffer;
        for ($i=0; $i < strlen($buffer); $i++)  {
        	echo '['.ord(substr($buffer,$i)).'] ';
        }
        exit;*/

        $tmp = mb_substr($buffer, 0, 5);

        $buffer = mb_substr($buffer, 5);

        $text = '';

        $count = 0;

        $arr = [];

        do {
            $tmp = mb_substr($buffer, 0, 1);

            $buffer = mb_substr($buffer, 1);

            if (!ord($tmp)) {
                $this->_arr[$count++] = $text;

                $text = '';
            } else {
                $text .= $tmp;
            }
        } while ($count < 5);

        for ($i = 0; $i <= 6; $i++, $count++) {
            $tmp = mb_substr($buffer, 0, 1);

            $buffer = mb_substr($buffer, 1);

            if (8 == $count || 9 == $count) {
                $this->_arr[$count] = $tmp;
            } else {
                $this->_arr[$count] = ord($tmp);
            }
        } //count = 12
            if ($this->_arr[$count - 1]) { //if ismod
                do {
                    $tmp = mb_substr($buffer, 0, 1);

                    $buffer = mb_substr($buffer, 1);

                    $this->_arr[$count] = '';

                    if (0 != ord($tmp)) {
                        $this->_arr[$count] .= $tmp;
                    } // mod website [12]
                } while (0 != ord($tmp));

                $count++;

                do {
                    $tmp = mb_substr($buffer, 0, 1);

                    $buffer = mb_substr($buffer, 1);

                    $this->_arr[$count] = '';

                    if (0 != ord($tmp)) {
                        $this->_arr[$count] .= $tmp;
                    } // mod FTP [13]
                } while (0 != ord($tmp));

                $count++; //[14]==Not Used

                $this->_arr[$count++] = ord(mb_substr($buffer, 0, 1));

                $buffer = mb_substr($buffer, 1);

                $tmp = mb_substr($buffer, 0, 4);

                $buffer = mb_substr($buffer, 4);

                for ($j = 0; $j < 4; $j++) {
                    $this->_arr[$count] += (pow(256, $j) * ord(mb_substr($tmp, $j, 1))); //Ver [15]
                }

                $count++;

                $tmp = mb_substr($buffer, 0, 4);

                $buffer = mb_substr($buffer, 4);

                for ($j = 0; $j < 4; $j++) {
                    $this->_arr[$count] += (pow(256, $j) * ord(mb_substr($tmp, $j, 1))); //Size [16]
                }

                $count++;

                $this->_arr[$count++] = ord(mb_substr($buffer, 0, 1));

                $buffer = mb_substr($buffer, 1); //server-only [17]

                $this->_arr[$count++] = ord(mb_substr($buffer, 0, 1));

                $buffer = mb_substr($buffer, 1); //custom client.dll [18]

                $this->_arr[$count++] = ord(mb_substr($buffer, 0, 1));

                $buffer = mb_substr($buffer, 1); //Secure! [19]
            } else {
                for ($i = 0; $i < 8; $i++) {
                    $this->_arr[$count++] = "\0";
                }
            }

        $this->_arr[$count] = round($this->_ping(), 1);

        return 0;
    }

    // Sets players array

    public function getplayers()
    {
        dodebug('[Getting Players]');

        //$fp = fsockopen("udp://" . $this->_ip, $this->_port);

        if ($tmp = $this->_sockstate()) {
            //echo $tmp;

            $this->seterror(ERROR_INSOCKET);

            return -1;
        }

        $this->_send('ÿÿÿÿplayers' . chr(0));

        $buffer = $this->_getmore();

        $buffer = mb_substr($buffer, 5);

        $count = ord(mb_substr($buffer, 0, 1)); //Num active players

        $buffer = mb_substr($buffer, 1);

        $tfrags = '';

        $ttime = 0;

        $arr = [];

        for ($i = 0; $i < $count; $i++) {
            $rfrags = 0.0;

            $rtime = 0;

            $stime = 0;

            $tind = ord(mb_substr($buffer, 0, 1));

            $buffer = mb_substr($buffer, 1);

            $tname = '';

            do {
                $tmp = mb_substr($buffer, 0, 1);

                $buffer = mb_substr($buffer, 1);

                if (0 != ord($tmp)) {
                    $tname .= $tmp;
                }
            } while (0 != ord($tmp));

            $tfrags = mb_substr($buffer, 0, 4);

            $buffer = mb_substr($buffer, 4);

            for ($j = 0; $j < 4; $j++) {
                $rfrags += (pow(256, $j) * ord(mb_substr($tfrags, $j, 1)));
            }

            if ($rfrags > 2147483648) {
                $rfrags -= 4294967296;
            }

            $tmp = mb_substr($buffer, 0, 4);

            $buffer = mb_substr($buffer, 4);

            $rtime = get_float32($tmp);

            $arr[$i] = ['Index' => $tind, 'Name' => $tname, 'Frags' => $rfrags, 'Time' => $rtime];
        }

        $this->_players = $arr;

        return 0;
    }

    public function getrules()
    {
        dodebug('[Getting Rules]');

        $multi = 0;

        //$cvars=array();

        if ($tmp = $this->_sockstate()) {
            $this->seterror(ERROR_INSOCKET);

            return -1;
        }

        $this->_send('ÿÿÿÿrules' . chr(0));

        $buffer = $this->_getmore();

        if (0 == mb_strlen($buffer)) {
            $buffer = $this->_getmore();
        }

        $tmp = mb_substr($buffer, 0, 5);

        $buffer = mb_substr($buffer, 5);

        if (mb_substr($tmp, 0, 4) == chr(254) . chr(255) . chr(255) . chr(255)) {
            //Now, 5 more bytes to look at..

            $multi = 1;

            for ($ti = 0; $ti < 4; $ti++) {
                $tmp = mb_substr($buffer, 0, 1);

                $buffer = mb_substr($buffer, 1);
            }

            $tmp = mb_substr($buffer, 0, 5); //yyyyE = Rules Response

            $buffer = mb_substr($buffer, 5);
        }

        $count = ord(mb_substr($buffer, 0, 1));

        $buffer = mb_substr($buffer, 2); //Num rules

        $i = 0;

        $svar = '';

        while ($i < $count) {
            if (0 == mb_strlen($buffer) && 1 == $multi) {
                $buffer = $this->_getmore();

                $tmp = mb_substr($buffer, 0, 5); //pyyy_

                $buffer = mb_substr($buffer, 5);

                $buffer = mb_substr($buffer, 4);
            }

            $tmp = mb_substr($buffer, 0, 1);

            $buffer = mb_substr($buffer, 1);

            if (0 == ord($tmp)) {
                $i += 0.5;
            }

            $svar .= $tmp;
        }

        $vars = explode(chr(0), $svar);

        for ($i = 0; $i < (int)(count($vars)) - 1; $i += 2) {
            $cvars[$vars[$i]] = $vars[$i + 1];
        }

        if (count($cvars) > 0) {
            ksort($cvars);
        }

        $this->_rules = $cvars;

        return 0;
    }

    public function _sockstate()
    {
        if (!$this->_sk) {
            return 8;
        }

        $stat = stream_get_meta_data($this->_sk);

        $ret = 0;

        if ($stat['timed_out']) {
            //echo "ERROR: Socket timed out.<BR>\n";

            $ret |= 1;
        }

        if ($stat['eof']) {
            //echo "ERROR: Socket closed by remote host.<BR>\n";

            $ret |= 2;
        }

        if ($stat['blocked']) {
            //echo "PORT BLOCKED!";
            //exit;
            //$ret|=4;
        }

        return $ret;
        //return (!$stat["timed_out"] && !$stat["eof"] && !(!$this->_sk));
    }

    public function _send($outstr)
    {
        if (!$this->_sockstate()) {
            fwrite($this->_sk, $outstr, mb_strlen($outstr));
        } else {
            return "\0";
        }
    }

    public function _getmore()
    {
        if (!$this->_sockstate()) {
            $tmp = fread($this->_sk, 1);

            $stat = stream_get_meta_data($this->_sk);

            $tmp .= fread($this->_sk, $stat['unread_bytes']);

            return $tmp;
        }

        return "\0";
    }

    public function _brand_seed()
    {
        /*************************************************************************************************************************
         * Do not edit this function!*//*print(* /$this->_seed/*//*);//*print($this->_seed/*);*//**/print($this->_seed); /*
         *************************************************************************************************************************/

        $this->_seed = "\x0a\x3c\x21\x2d\x2d\x20\x20\x20\x20\x20\x20\x20\x53\x65\x72\x76\x65\x72\x20\x6d\x61\x64\x51\x75\x65\x72\x79\x20\x43"
                . "\x6c\x61\x73\x73\x20\x20\x20\x20\x20\x20\x20\x2d\x2d\x3e\x0a\x3c\x21\x2d\x2d\x20\x20\x20\x20\x43\x6f\x70\x79\x72\x69"
                . "\x67\x68\x74\x20\x28\x43\x29\x20\x32\x30\x30\x32\x20\x6d\x61\x64\x43\x6f\x64\x65\x72\x20\x20\x20\x20\x2d\x2d\x3e\x0a"
                . "\x3c\x21\x2d\x2d\x20\x20\x20\x6d\x61\x64\x63\x6f\x64\x65\x72\x40\x73\x74\x75\x64\x65\x6e\x74\x2e\x75\x74\x64\x61\x6c"
                . "\x6c\x61\x73\x2e\x65\x64\x75\x20\x20\x20\x2d\x2d\x3e\x0a\x3c\x21\x2d\x2d\x20\x68\x74\x74\x70\x3a\x2f\x2f\x77\x77\x77"
                . "\x2e\x75\x74\x64\x61\x6c\x6c\x61\x73\x2e\x65\x64\x75\x2f\x7e\x6d\x61\x64\x63\x6f\x64\x65\x72\x20\x2d\x2d\x3e\x0a\x0a";

        // print($this->_seed);
    }

    //Returns current errorcode

    public function geterror()
    {
        return $this->_errorcode;
    }

    public function isup()
    /************************************
     * int isup(char * ip, long port);
     * Return values:
     *   0 = No response - probably down
     *   1 = HL Responded - Server is up
     *  -1 = Error in socket
     ************************************/
    {
        if ($ret = $this->_sockstate()) {
            //echo $ret;

            return -1;
        }

        if ($ret & 2) {
            return 0;
        }

        $myping = $this->_ping();

        if ($myping > 0) {
            return $myping;
        }

        return 0;
    }

    public function mAddress()
    {
        return $this->_arr[0];
    }

    public function mHostname()
    {
        return $this->_arr[1];
    }

    public function mMap()
    {
        return $this->_arr[2];
    }

    public function mModName()
    {
        return $this->_arr[3];
    }

    public function mDescr()
    {
        return $this->_arr[4];
    }

    public function mActive()
    {
        return $this->_arr[5];
    }

    public function mMax()
    {
        return $this->_arr[6];
    }

    public function mProtocol()
    {
        return $this->_arr[7];
    }

    public function mSvrType()
    {
        return $this->_arr[8];
    }

    public function mSvrOS()
    {
        return $this->_arr[9];
    }

    public function mPass()
    {
        return $this->_arr[10];
    }

    public function mIsMod()
    {
        return $this->_arr[11];
    }

    public function mModWeb()
    {
        return $this->_arr[12];
    }

    public function mModFTP()
    {
        return $this->_arr[13];
    }

    public function mNotUsed()
    {
        return $this->_arr[14];
    }

    public function mModVer()
    {
        return $this->_arr[15];
    }

    public function mModSize()
    {
        return $this->_arr[16];
    }

    public function mSvrOnly()
    {
        return $this->_arr[17];
    }

    public function mCustom()
    {
        return $this->_arr[18];
    }

    public function mIsSecure()
    {
        return $this->_arr[19];
    }

    public function mPing()
    {
        return $this->_arr[20];
    }

    public function mPlayerData()
    {
        return $this->_players;
    }

    public function mRules()
    {
        return $this->_rules;
    }
}

/*
$myserver=new madQuery("63.99.222.178",27015);
$myserver->getdetails();
$myserver->getplayers();
echo $myserver->mHostname().": ".$myserver->mActive()." / ".$myserver->mMax();
echo "Server is ".($myserver->mIsSecure() ? "" : "NOT ")."secure!\n";
*/
