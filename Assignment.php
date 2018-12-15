<?php
include_once 'functions.php';
/**
 * Used to give assignments to students. It's the main platform through which
 * lecturer can provide assignments to his/her students
 *
 * @author Alhassan Kamil
 */
class Assignment {
    private $questions, $course, $given_date, $submit_date, $submit_time;
    private $lecturer, $submission_method, $submission_format, $other;
    private $db_connect;
    private $id;
    private $table = "assignments";
    
    public function __construct($db) {
        $this->db_connect = $db;
    }

    function get_assignments(){
        $query = "select id, question, course, submit_date,lecturer from $this->table"
                . " order by submit_date";
        $stmt = $this->db_connect->query($query);

        return $stmt;
    }

    function get_assignment($id){
        if(is_okay($id)){
            $id = clean_data($id);
            $query = "select * from $this->table where id = $id";

            $stmt = $this->db_connect->query($query);

            return $stmt;
        }

    }

    public function get_questions(){
        return $this->questions;
    }

    public function get_course(){
        return $this->course;
    }

    public function get_submit_date(){
        return $this->submit_date;
    }

    public function get_sumit_time(){
        return $this->submit_time;
    }

    public function set_questions($questions){
        $this->questions = [$questions];
    }
    function set_course($course){
        $this->course = $course;
    }

    function set_submit_date($date_){
        $this->submit_date = $date_;
    }

    function set_submit_time($time_){
        $this->submit_time = $time_;
    }

    function create($questions,$course,$given_date,$submit_date,$lecturer){
        if(is_array_okay($questions,$course,$given_date,$submit_date,$lecturer)){
            $stmt = $this->db_connect->prepare("INSERT INTO assignments(questions,"
                    . "course,given_date,submit_date,lecturer) VALUES("
                    . "?,?,?,?,?)");
            $stmt->bind_params('sssss',$questions,$course,$given_date,
                    $submit_date,$lecturer);
            $stmt->execute();

            $rows = show_affected_rows($stmt);
            return $rows;
        }
    }

    function finish_create($time=NULL,$method=NULL, $format=NULL, $other=NULL){
        $stmt = $this->db_connect->prepare("UPDATE assignments SET submit_time = ?,"
                    . "submission_method = ?,submission_format = ?, other = ?)");
        $stmt->bind_params('ssss',$time,$method,$format,$other);
        $stmt->execute();
        $rows = show_affected_rows($stmt);

        if($rows > 0){
            return $rows;
        }

        return FALSE;
    }
}
$con = new Connection();
$conn = $con->connect();
$ass = new Assignment($conn);
$stmt = $ass->get_assignments();
$rows = $stmt->num_rows;
?>
<div>
    <h1>Assignments to do</h1>
    <ul>
        <?php
        while ($row = $stmt->fetch_object()){
        echo "<li>$row->question</li>"
                . "<li>$row->course</li>"
                . "<li>".ucwords($row->lecturer)."</li><hr>";
        }
        ?>

    </ul>
</div>
