<?php
/**
 * Handle Backup plugin upgrades
 *
 * @package automattic/jetpack-backup-plugin
 */

// After changing this file, consider increasing the version number ("VXXX") in all the files using this namespace, in
// order to ensure that the specific version of this file always get loaded. Otherwise, Jetpack autoloader might decide
// to load an older/newer version of the class (if, for example, both the standalone and bundled versions of the plugin
// are installed, or in some other cases).
namespace Automattic\Jetpack\Backup\V0005;

use function get_option;
use function update_option;

/**
 * The Upgrades class.
 */
class Jetpack_Backup_Upgrades {

	/**
	 * Run all methods only once and store an option to make sure it never runs again
	 */
	public static function upgrade() {

		$upgrades = get_class_methods( __CLASS__ );

		foreach ( $upgrades as $upgrade ) {
			$option_name = '_upgrade_' . $upgrade;
			if ( 'upgrade' === $upgrade || get_option( $option_name ) ) {
				continue;
			}

			update_option( $option_name, 1 );

			call_user_func( array( __CLASS__, $upgrade ) );

		}
	}

	/**
	 * The plugin is not checking if it was disabled and reactivating it when we reconnect, therefore we need to clear this information from DB so other plugins know we are still using the connection
	 *
	 * @deprecated since 1.7.0 No longer required after removing soft disconnect functionality.
	 */
	public static function clear_disabled_plugin() {}
}
