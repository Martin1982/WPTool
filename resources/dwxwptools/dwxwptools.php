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
    $creds = array();
    $creds['user_login'] = $_GET['username'];
    $creds['user_password'] = $_GET['password'];
    $creds['remember'] = true;
    $user = wp_signon( $creds, true);
    if ( is_wp_error($user) ) {
        $loginInfo = array(
            'authenticated' => false,
            'response' => $user->get_error_message()
        );
    } elseif (!in_array('administrator', $user->roles)) {
        $loginInfo = array(
            'authenticated' => false,
            'response' => 'Not an administrator'
        );
    } else {
        $loginInfo = array(
            'authenticated' => true,
            'response' => $user
        );
    }
    return $loginInfo;
}

/**
 * Request the available updates
 * @return array
 */
function wptool_getupdates()
{
    return wp_get_update_data();
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