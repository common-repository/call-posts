<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

// Remove all registered option when plugin is deleted
delete_option('cps_data');
delete_option('cps_predefined');
delete_option('cps_show_notice');
delete_option('cps_installed_date');