<?php
/*
	Plugin Name: A Dashboard Notice
	Plugin URI: https://github.com/alleyinteractive/a-dashboard-notice
	Description: Display a notice in the WordPress Dashboard to all users.
	Version: 0.1.0
	Author: Alley Interactive
	Author URI: http://www.alleyinteractive.com/
*/
/*  This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

define( 'ADN_PATH', dirname( __FILE__ ) );
define( 'ADN_URL', trailingslashit( plugins_url( '', __FILE__ ) ) );

if ( is_admin() ) {
	require_once ADN_PATH . '/lib/class-adn-settings.php';
	require_once ADN_PATH . '/lib/notice.php';
}
