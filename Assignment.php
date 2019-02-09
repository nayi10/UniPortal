<?php
include_once 'functions.php';
/**
 * Used to give assignments to students. It's the main platform through which
 * lecturer can provide assignments to his/her students
 *
 * @author Alhassan Kamil
 */
class Assignment {
    private $question, $course, $given_date, $submit_date, $submit_time;
    private $lecturer, $submission_method, $submission_format, $other;
    private $table = "assignments";
    
    public function __construct() {

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
    public function get_given_date() {
        return $this->given_date;
    }

    public function get_lecturer() {
        return $this->lecturer;
    }

    public function get_submission_method() {
        return $this->submission_method;
    }

    public function get_submission_format() {
        return $this->submission_format;
    }

    public function get_other() {
        return $this->other;
    }

    public function set_given_date($given_date) {
        $this->given_date = $given_date;
        return $this;
    }

    public function set_lecturer($lecturer) {
        $this->lecturer = $lecturer;
        return $this;
    }

    public function set_submission_method($submission_method) {
        $this->submission_method = $submission_method;
        return $this;
    }

    public function set_submission_format($submission_format) {
        $this->submission_format = $submission_format;
        return $this;
    }

    public function set_other($other) {
        $this->other = $other;
        return $this;
    }

        public function get_question(){
        return $this->question;
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

    public function set_questions($question){
        $this->question = $question;
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

    function insert(){
        $stmt = $this->db_connect->prepare("INSERT INTO assignments(question,"
            . "course,given_date,submit_date,lecturer) VALUES(?,?,?,?,?)");
        $stmt->bind_params('sssss',$this->question,$this->course,$this->given_date,
            $this->submit_date,$this->lecturer);
        $stmt->execute();
        if($stmt->affected_rows == 0){
            return $stmt->affected_rows;
        }
        return false;
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
