<?php
include_once 'functions.php';

/**
 * Description of Lesson
 *
 * @author kamil
 */
class Lessons
{
    private $id, $subject, $course_code, $lecturer, $venue, $day, $start, $end;

    function __construct($lesson = null)
    {
        if (!is_null($lesson)) {
            $this->subject = $lesson;
        }
    }

    public function get_all_lessons($subject = null, $date = null)
    {
        $conn = get_connection_handle();
        $day = date("l");
        if (!is_null($subject) && !is_null($date)) {
            $query = $conn->query("select * from lessons where subject = '$lesson' and day = '$date'");
        } elseif (!is_null($subject) && is_null($date)) {
            $query = $conn->query("select * from lessons where subject = '$lesson'");
        } elseif (is_null($subject) && !is_null($date)) {
            $query = $conn->query("select * from lessons where day = '$date'");
        } else {
            $query = $conn->query("select * from lessons 
            where day = '$day' and CURRENT_TIME BETWEEN start and end");
        }
        if ($query && $query->num_rows > 0) {
            return $query;
        }
    }

    public function get_todays_lessons($limit){
        if(is_null($limit)){
            $limit = 7;
        }
        $conn = get_connection_handle();
        $day = date("l");
        $query = $conn->query("select * from lessons where day = '$day' limit $limit");
        if ($query && $query->num_rows > 0) {
            return $query;
        }
    }

    public function get_num_lessons(){
        $conn = get_connection_handle();
        $date = new DateTime();
        $day = $date->format("l");
        $time = $date->format("H:i:s");
        $query = $conn->query("select count(*) as rows from lessons 
        where day = '$day' and end > CAST($time AS TIME)");
        $row = $query->fetch_object();
        return $row->rows;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_subject()
    {
        return $this->subject;
    }

    public function get_course_code()
    {
        return $this->course_code;
    }

    public function get_lecturer()
    {
        return $this->lecturer;
    }

    public function get_venue()
    {
        return $this->venue;
    }

    public function get_day()
    {
        return $this->day;
    }

    public function get_start()
    {
        return $this->start;
    }

    public function get_end()
    {
        return $this->end;
    }

    public function set_id($id)
    {
        $this->id = $id;
        return $this;
    }

    public function set_subject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function set_course_code($course_code)
    {
        $this->course_code = $course_code;
        return $this;
    }

    public function set_lecturer($lecturer)
    {
        $this->lecturer = $lecturer;
        return $this;
    }

    public function set_venue($venue)
    {
        $this->venue = $venue;
        return $this;
    }

    public function set_day($day)
    {
        $this->day = $day;
        return $this;
    }

    public function set_start($start)
    {
        $this->start = $start;
        return $this;
    }

    public function set_end($end)
    {
        $this->end = $end;
        return $this;
    }

    public function save()
    {
        $conn = get_connection_handle();
        $stmt = $conn->prepare("insert into lessons(subject,course_code,"
            . "lecturer, venue, day, start, end) values(?,?,?,?,?,?,?)");
        $stmt->bind_param(
            "sssssss",
            $this->subject,
            $this->course_code,
            $this->lecturer,
            $this->venue,
            $this->day,
            $this->start,
            $this->end
        );
        $stmt->execute();
        if ($conn->affected_rows == 1) {
            return $conn->affected_rows;
        }
        return false;
    }

    /**
     * Updates this lesson with new values
     * @return mixed Returns rows affected(1) if update successful, False otherwise
     */
    public function update()
    {
        $conn = get_connection_handle();
        if ($this->subject) {
            $stmt = $conn->prepare("update lessons set subject = ?, course_code = ?, lecturer = ?, "
                . "venue = ?, day = ?, start = ?, end = ? where id = ?");
            $stmt->bind_param(
                "ssssssi",
                $this->subject,
                $this->course_code,
                $this->lecturer,
                $this->venue,
                $this->day,
                $this->start,
                $this->end,
                $this->id
            );
            $stmt->execute();
            $rows = $conn->affected_rows;
            if ($rows == 1) {
                return $rows;
            }
            return false;
        }
    }
}