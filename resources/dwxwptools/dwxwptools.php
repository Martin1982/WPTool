<?php
/*
Plugin Name: Dreamworx WPTool
Plugin URI: https://github.com/Martin1982/WPTool
Description: The WPTool gatekeeper and communication layer.
Version: 0.1
Author: Martin de Keijzer
Author URI: http://www.dreamworxmedia.com
License: GPL2
*/

/*  Copyright 2012  Martin de Keijzer  (email : martin@dikketoeters.nl)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Main router for all wptool actions
 * @return bool
 */
function wptoolInit()
{
    if (!isset($_GET['wptoolaction'])) {
        return true;
    }

    $funcOut = call_user_func('wptool_' . $_GET['wptoolaction']);
    echo json_encode($funcOut);
    die();
}

/**
 * Initial handshake to check wptool presence
 * @return string
 */
function wptool_handshake()
{
    return 'wptool present';
}

/**
 * Request action for a login token
 * @return array
 */
function wptool_login()
{
    return array('token' => '1234567890');
}

/**
 * Request the available updates
 * @return array
 */
function wptool_getupdates()
{
    return array();
}

/**
 * Execute the given updates
 * @return array
 */
function wptool_runupdates()
{
    return array();
}

/**
 * Request the plugin version
 * @return string
 */
function wptool_version()
{
    return '0.1';
}

add_action('plugins_loaded', 'wptoolInit');