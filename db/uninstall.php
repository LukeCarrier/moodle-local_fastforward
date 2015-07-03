<?php

/**
 * Fast forward.
 *
 * @author Luke Carrier <luke.carrier@floream.com>
 * @copyright 2015 Floream Limited
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Uninstall the plugin.
 *
 * @return void
 */
function xmldb_local_fastforward_uninstall() {
    unset_config('enable', 'local_fastforward');
}
