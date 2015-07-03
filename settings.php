<?php

/**
 * Fast forward.
 *
 * @author Luke Carrier <luke.carrier@floream.com>
 * @copyright 2015 Floream Limited
 */

defined('MOODLE_INTERNAL') || die;

$component = 'local_fastforward';

if ($branch = $ADMIN->locate('optionalsubsystems')) {
    $branch->add(new admin_setting_configcheckbox(
        "{$component}/enable",
        new lang_string('enable',     $component),
        new lang_string('enabledesc', $component),
        false
    ));
}
