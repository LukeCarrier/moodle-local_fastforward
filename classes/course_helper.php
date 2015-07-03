<?php

/**
 * Fast forward.
 *
 * @author Luke Carrier <luke.carrier@floream.com>
 * @copyright 2015 Floream Limited
 */

namespace local_fastforward;

defined('MOODLE_INTERNAL') || die;

/**
 * Course module helper class.
 *
 * Provides utility methods to ease reuse.
 */
class course_helper {
    /**
     * Course module update SQL.
     *
     * @var string
     */
    const UPDATE_ALL_CM_SQL = <<<SQL
UPDATE {course_modules}
SET added = :added
WHERE course = :courseid
SQL;

    /**
     * Set the creation timestamp of a course.
     *
     * @param integer $courseid
     * @param integer $added
     *
     * @return void
     */
    public static function set_added($courseid, $added) {
        global $DB;

        $DB->update_record('course', (object) array(
            'id'          => $courseid,
            'timecreated' => $added,
        ));
    }

    /**
     * Set the creation timestamp of all modules within the specified course.
     *
     * @param integer $courseid
     * @param integer $added
     *
     * @return void
     */
    public static function set_all_modules_added($courseid, $added) {
        global $DB;

        $DB->execute(static::UPDATE_ALL_CM_SQL, array(
            'courseid' => $courseid,
            'added'    => $added,
        ));
    }

    /**
     * Set the creation timestamp of a course module.
     *
     * @param integer $cmid
     * @param integer $added
     *
     * @return void
     */
    public static function set_module_added($cmid, $added) {
        global $DB;

        $DB->update_record('course_modules', (object) array(
            'id'    => $cmid,
            'added' => $added,
        ));
    }
}
