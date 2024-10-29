<?php
/*
Plugin Name: AJAX Referer Fix
Plugin URI: http://sparepencil.com/code/ajax-referer-fix/
Description: Fixes a problem that causes "You don't have permission to do that" errors. It replaces the pluggable <code>check_ajax_referer()</code> with a safe alternative.
Version: 0.1
Author: Bas van Doren
Author URI: http://sparepencil.com/
*/
/*
Copyright 2007 Bas van Doren

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// Preserve pluggability to prevent possible conflicts
// (who knows what other plugins plug this...)
if (!function_exists('check_ajax_referer')) :
function check_ajax_referer() {
	// Explode cookie data like WordPress normally does
	$cookie = explode('; ', urldecode(empty($_POST['cookie']) ? $_GET['cookie'] : $_POST['cookie'])); // AJAX scripts must pass cookie=document.cookie
	foreach ( $cookie as $tasty ) {
		if ( false !== strpos($tasty, USER_COOKIE) )
			$user = substr(strstr($tasty, '='), 1);
		if ( false !== strpos($tasty, PASS_COOKIE) )
			$pass = substr(strstr($tasty, '='), 1);
	}
	
	// This variable is set when cookie data was sent in an encrypted fashion
	// For more information:
	// * http://forum.hardened-php.net/viewtopic.php?pid=616
	// * http://www.hardened-php.net/suhosin/
	if(isset($_SERVER['RAW_HTTP_COOKIE']))
	{
		// Explode the raw (HTTP) cookie data using the WP method
		$crypt_cookie = explode('; ', $_SERVER['RAW_HTTP_COOKIE']);
		foreach ( $crypt_cookie as $tasty ) { 
			if ( false !== strpos($tasty, USER_COOKIE) ) 
				$crypt_user = substr(strstr($tasty, '='), 1); 
			if ( false !== strpos($tasty, PASS_COOKIE) ) 
				$crypt_pass = substr(strstr($tasty, '='), 1); 
		} 
		// Set $user and $pass to the decrypted values if the cookies match
		if($crypt_user == $user && $crypt_pass == $pass) 
		{ 
			$user = $_COOKIE[USER_COOKIE]; 
			$pass = $_COOKIE[PASS_COOKIE]; 
		}
	} 
	
	if ( !wp_login( $user, $pass, true ) )
		die('-1');
	do_action('check_ajax_referer');
}
endif;
