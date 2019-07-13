<?php
/**
 * Plugin Name: Remove jQuery Migrate
 * Plugin URI:  https://wordpress.org/plugins/remove-jquery-migrate/
 * Description: This plugin removes the jQuery Migrate script from the front end of your site.
 * Version:     1.0.1
 * Author:      Hendy Tarnando
 * Author URI:  https://www.thewebflash.com/
 * Text Domain: remove-jquery-migrate
 * License:     GPLv3
 */

/**
 * Copyright (C) 2017 Hendy Tarnando (https://www.thewebflash.com/contact/)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if ( ! function_exists( 'twf_remove_jquery_migrate' ) ) {
	
	/**
	 * Remove jQuery Migrate script from the jQuery bundle only in front end.
	 *
	 * @since 1.0
	 *
	 * @param WP_Scripts $scripts WP_Scripts object.
	 */
	function twf_remove_jquery_migrate( $scripts ) {
		if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
			$script = $scripts->registered['jquery'];
			
			if ( $script->deps ) { // Check whether the script has any dependencies
				$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
			}
		}
	}
	
	add_action( 'wp_default_scripts', 'twf_remove_jquery_migrate' );
}