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

function wptools_init()
{
    if (!isset($_GET['wptoolsaction'])) {
        return true;
    }

    $funcOut = call_user_func('wptools' . $_GET['wptoolsaction']);
    echo json_encode($funcOut);
}

function wptools_getupdates()
{
    return array();
}

function wptools_version()
{
    return '0.1';
}

add_action('plugins_loaded', 'wptools_init');