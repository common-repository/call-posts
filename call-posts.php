<?php
/**
 * Call Posts WP Plugin
 *
 * Plugin Name: Call Posts
 * Description: Create posts grid layout with ease ( No coding knowledge required )
 * Version:     1.0
 * Author:      Call Posts Team
 * Author URI:	http://callposts.com/
 * Text Domain: call-posts
 * Domain Path: /languages
 * License:     GPLv2 or later
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

// Define magic constant to main filesystem path
if ( ! defined( 'cps_file' ) ) {
	define('cps_file', __FILE__);
}

// Initialization the Call Posts plugin.
require_once untrailingslashit( dirname( cps_file ) ) . '/cps-initialization.php';
