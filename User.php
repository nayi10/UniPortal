<?php
include_once("functions.php");
/**
 * The User class is a generic class that contains all the properties and
 * methods to make it possible for users to interact with the application
 *
 * @author Alhassan Kamil
 */
class User {
    
    public function get_middlename() {
        return $this->middlename;
    }

    public function get_country() {
        return $this->country;
    }

    public function get_region() {
        return $this->region;
    }

    public function get_town() {
        return $this->town;
    }

    public function get_email() {
        return $this->email;
    }

    public function set_middlename($middlename) {
        $this->middlename = $middlename;
        return $this;
    }

    public function set_country($country) {
        $this->country = $country;
        return $this;
    }

    public function set_region($region) {
        $this->region = $region;
        return $this;
    }

    public function set_town($town) {
        $this->town = $town;
        return $this;
    }

    public function set_email($email) {
        $this->email = $email;
        return $this;
    }

        //Declaring member variables/properties
    private $firstname, $middlename, $lastname, $programme, $department,$courses;
    private $age, $username, $name, $country, $region, $town, $gender, $notes;
    private $password, $email, $phone, $owner_id;

    function __construct($user=null) {
        if(is_null($user)){
            $this->username = $user;
        }
        $conn = get_connection_handle();
        $query = $conn->query("select * from users where username = '$user'");
        if($query && $query->num_rows > 0){
        $res = $query->fetch_object();
        $this->firstname = $res->firstname;
        $this->lastname = $res->lastname;
        $this->middlename = $res->middlename;
        $this->name = $res->name;
        $this->username = $res->username;
        $this->email = $res->email;
        $this->password = $res->password;
        $this->phone = $res->phone;
        $this->department = $res->department;
        $this->programme = $res->programme;
        $this->certificate = $res->certificate;
        $this->owner_id = $res->id;
        $this->hostel = $res->hostel;
        }
    }

    /**
     * Gets the name of the current user. Includes the person's first name,
     * lastname, and middle name(if any)
     * @return string
     */
    public function get_fullname(){
        if($this->middlename){
            $name = $this->firstname.' '.$this->middlename.' '.$this->lastname;
        }  else {
            $name = $this->firstname. " ".$this->lastname;
        }

        return $name;
    }

    /**
     * Gets the first name of the current user
     * @return str
     */
    public function get_firstname(){
        return $this->firstname;
    }

    /**
     * Gets all notes of this user
     * @return object
     */
    function get_notes(){
        $conn = get_connection_handle();
        $owner = $this->username;
        $query = "select * from notes where owner = '$owner'";
        $stmt = $conn->query($query);
        if($stmt && $stmt->num_rows > 0){
            return $stmt;
        }
        return false;
    }

    function get_note_count(){
        $conn = get_connection_handle();
        $user = $this->username;
        $query = "select count(id) as total from notes where owner = '$user'";
        $stmt = $conn->query($query);
        if($stmt && $stmt->num_rows > 0){
            $count = $stmt->fetch_object();
            return $count->total;
        }
        return 0;
    }

    function get_note($title){
        $conn = get_connection_handle();
        if(is_okay($title)){
            $owner = $this->username;
            $query = "select * from notes where title = '$title' and "
                    . "owner = '$owner'";
            $stmt = $conn->query($query);
            if($stmt && $stmt->num_rows > 0){
                $row = $stmt->fetch_object();
                return $row;
            }
            return false;
        }
    }

    function get_noteby_link($link){
        $conn = get_connection_handle();
        if(is_okay($link)){
            $owner = $this->username;
            $query = "select * from notes where link_id = '$link' and "
                    . "owner = '$owner' and status = 'public'";
            $stmt = $conn->query($query);
            if($stmt && $stmt->num_rows > 0){
                $row = $stmt->fetch_object();
                return $row;
            }
            return false;
        }
    }

    public function get_notes_titles(){
        $conn = get_connection_handle();
        $user = $this->username;
        $query = $conn->query("select title from notes where owner = '$user' order by id desc");
        if($query && $query->num_rows > 0){
            return $query;
        }
        return false;
    }
    /**
     * Gets the last name of the current user
     * @return string
     */
    public function get_lastname(){
        return $this->lastname;
    }

    /**
     * Gets the age of the current user
     * @return integer
     */
    public function get_age() {
        return $this->age;
    }

    /**
     * Gets and returns the course of the current user
     * @return String
     */
    public function get_programme(){
        return $this->programme;
    }

    /**
     * Gets the current user's department
     * @return string
     */
    public function get_department(){
        return $this->department;
    }

    /**
     * Returns the current user's username
     * @return string
     */
    public function get_username(){
        return $this->username;
    }

    /**
     * Returns current user's age
     * @return int
     */
    public function get_gender(){
        return $this->gender;
    }

    /**
     * Sets the name of the current user using $fname as first name, $lname as
     * last name, and $mname as middle name.
     * @param string $fname
     * @param string $lname
     * @param string $mname
     */
    public function set_name($fname, $lname, $mname = ''){
        $this->name = $fname.' '.$mname.' '.$lname;
    }

    /**
     * Sets the age of current user with age $age
     * @param integer $age
     */
    public function set_age($age){
        $this->age = $age;
    }

    public function get_phone(){
        return $this->phone;
    }

    public function get_password(){
        return $this->password;
    }
    public function get_courses(){
        $conn = get_connection_handle();
        $query = $conn->query("select * from registered_courses 
        where username = '$this->username'");
        if($query && $query->num_rows > 0){
            return $query;
        }
        return false;
    }

    public function get_course_count(){
        $conn = get_connection_handle();
        $query = $conn->query("select count(id) as total from registered_courses 
        where username = '$this->username'");
        if($query && $query->num_rows > 0){
            $count = $query->fetch_object();
            return $count->total;
        }
        return 0;
    }
    public function get_answers(){
        $conn = get_connection_handle();
        $query = $conn->query("select * from answers where answered_by = '$this->username'");
        if($query && $query->num_rows > 0){
            return $query;
        }
        return false;
    }

    public function get_answer_count(){
        $conn = get_connection_handle();
        $query = $conn->query("select count(id) as total from answers 
        where answered_by = '$this->username'");
        if($query && $query->num_rows > 0){
            $count = $query->fetch_object();
            return $count->total;
        }
        return 0;
    }

    public function get_questions(){
        $conn = get_connection_handle();
        $query = $conn->query("select * from questions where asked_by = '$this->username'");
        if($query && $query->num_rows > 0){
            return $query;
        }
        return false;
    }

    public function get_question_upvotes(){
        $conn = get_connection_handle();
        $query = $conn->query("select sum(upvotes) as total from questions where 
        asked_by = '$this->username'");
        if($query && $query->num_rows > 0){
            $row = $query->fetch_object();
            return $row->total;
        }
        return 0;
    }

    function get_unviewed_chats(){
        $conn = get_connection_handle();
        $query = $conn->query("select distinct sender from chats where receiver = 
        '$this->username' and status = 'unviewed'");
        if($query && $query->num_rows > 0){
            return $query;
        }
        return 0;
    }

    function get_num_chats($user){
        $conn = get_connection_handle();
        $query = $conn->query("select count(id) as total from chats where receiver = 
        '$this->username' and sender = '$user' and status = 'unviewed'");
        if($query && $query->num_rows > 0){
            $row = $query->fetch_object();
            return $row->total;
        }
        return 0;
    }

    public function get_answer_upvotes(){
        $conn = get_connection_handle();
        $query = $conn->query("select sum(upvotes) as total from answers where 
        answered_by = '$this->username'");
        if($query && $query->num_rows > 0){
            $row = $query->fetch_object();
            return $row->total;
        }
        return 0;
    }

    public function get_question_downvotes(){
        $conn = get_connection_handle();
        $query = $conn->query("select sum(downvotes) as total from questions where 
        asked_by = '$this->username'");
        if($query && $query->num_rows > 0){
            $row = $query->fetch_object();
            return $row->total;
        }
        return 0;
    }

    public function get_answer_downvotes(){
        $conn = get_connection_handle();
        $query = $conn->query("select sum(downvotes) as total from answers where 
        answered_by = '$this->username'");
        if($query && $query->num_rows > 0){
            $row = $query->fetch_object();
            return $row->total;
        }
        return 0;
    }

    public function get_question_count(){
        $conn = get_connection_handle();
        $query = $conn->query("select count(id) as total from questions 
        where asked_by = '$this->username'");
        if($query && $query->num_rows > 0){
            $count = $query->fetch_object();
            return $count->total;
        }
        return 0;
    }

    public function get_question($id){
        $id = is_okay($id) ? $id: "";
        $conn = get_connection_handle();
        $query = $conn->query("select * from questions where id = $id");
        if($query && $query->num_rows > 0){
            return $query;
        }
        return false;
    }

    function get_assignments(){
        $conn = get_connection_handle();
        $department = $this->get_department();
        $query = $conn->query("select * from assignments where course in (
            select course_code from courses where department = '$department') 
            and submit_date >= CAST(CURRENT_DATE  AS DATETIME)");
        if($query && $query->num_rows > 0){
            return $query;
        }
        return false;
    }

    function get_assignment_count(){
        $conn = get_connection_handle();
        $department = $this->get_department();
        $query = $conn->query("select count(id) as total from assignments where course in (
            select course_code from courses where department = '$department') 
            and submit_date >= CAST(CURRENT_DATE  AS DATETIME)");
        if($query && $query->num_rows > 0){
            $count = $query->fetch_object();
            return $count->total;
        }
        return false;
    }
    
    function get_assignment($id){
        $conn = get_connection_handle();
        $id = is_okay($id) ? $id: "";
        $query = $conn->query("select * from assignments where id = $id");
        if($query && $query->num_rows > 0){
            $row = $query->fetch_object();
            return $row;
        }
        return 0;
    }
    
    function has_submitted($id){
        $conn = get_connection_handle();
        $id = is_okay($id) ? $id: "";
        $query = $conn->query("select * from submissions where assignment_id = $id");
        if($query && $query->num_rows > 0){
            return true;
        }
        return false;
    }

    function get_lectures(){
        $conn = get_connection_handle();
        $courses = $this->get_courses();
        $course_codes = array();
        while($row = $courses->fetch_object()){
            $course_codes[] = $row->course_code;
        }
        $codes = implode(",", explode("", $course_codes));
        $query = $conn->query("select * from assignments where course in ('$codes')");
        if($query && $query->num_rows > 0){
            return $query;
        }
        return false;
    }
}
