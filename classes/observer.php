<?php

/**
 * Fast forward.
 *
 * @author Luke Carrier <luke.carrier@floream.com>
 * @copyright 2015 Floream Limited
 */

namespace local_fastforward;

use backup;
use core\event\course_module_created;
use core\event\course_restored;

defined('MOODLE_INTERNAL') || die;

/**
 * Event observer.
 *
 * Contains utility methods called by Moodle's event manager in response to the
 * triggering of their corresponding events.
 */
class observer {
    /**
     * Moodle component.
     *
     * @var string
     */
    const MOODLE_COMPONENT = 'local_fastforward';

    /**
     * Is the observer enabled?
     *
     * @var boolean
     */
    protected static $isenabled;

    /**
     * Course module created.
     *
     * Verifies that we're being triggered as part of an activity duplication
     * and corrects the timestamp of the activity accordingly.
     *
     * @return void
     */
    public static function course_module_created(course_module_created $event) {
        if (!static::is_enabled()) {
            return;
        }

        $backtrace = debug_backtrace();
        foreach ($backtrace as $trace) {
            if ($trace['function'] === 'mod_duplicate_activity') {
                course_helper::set_module_added($event->objectid,
                                                $event->timecreated);
            }
        }
    }

    /**
     * Course restored.
     *
     * Enumerates activities within the restored course and corrects their
     * timestamps.
     *
     * @return void
     */
    public static function course_restored(course_restored $event) {
        if (!static::is_enabled()) {
            return;
        }

        course_helper::set_added($event->objectid, $event->timecreated);

        /* This will affect all modules, not just those that were restored. Can
         * we be a bit less heavy handed? */
        switch ($event->other['target']) {
            case backup::TARGET_NEW_COURSE:
                course_helper::set_all_modules_added($event->objectid,
                                                     $event->timecreated);
                break;
        }
    }

    /**
     * Is the observer enabled?
     *
     * @return boolean
     */
    protected static function is_enabled() {
        if (static::$isenabled === null) {
            static::$isenabled = get_config(static::MOODLE_COMPONENT, 'enable');
        }

        return static::$isenabled;
    }
}
