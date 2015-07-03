<?php

/**
 * Fast forward.
 *
 * @author Luke Carrier <luke.carrier@floream.com>
 * @copyright 2015 Floream Limited
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Event observers.
 *
 * @var mixed[]
 */
$observers = array(
    /*
     * Course module created.
     */
    array(
        'eventname' => '\core\event\course_module_created',
        'callback'  => '\local_fastforward\observer::course_module_created',
    ),

    /*
     * Course restored.
     */
    array(
        'eventname' => '\core\event\course_restored',
        'callback'  => '\local_fastforward\observer::course_restored',
    ),
);
