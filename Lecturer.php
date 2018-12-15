<?php
include_once('User.php');
/**
 * The Lecturer class provides methods and propertties to access and display
 * Lecturer information. It inherits most of its members from the User class
 *
 * @author Alhassan Kamil
 */
class Lecturer extends User{
    public $title, $position, $qualifications, $highest_cert, $name;

    /**
     * Constructor for Lecturer class
     * @param string $title
     * @return string
     */
    public function __construct($title, $fname, $lname, $mname = '') {
        $this->title = $title;
        $this->firstname = $fname;
        $this->lastname = $lname;
        $this->middlename = $mname;
    }

    public function get_name() {
        $old = parent::get_name();
        $new_name = $this->title.' '.$old;
        return $new_name;
    }

    public function get_title(){
        return $this->title;
    }

    public function get_position(){
        return $this->position;
    }

    public function get_qualifications(){
        return $this->qualifications;
    }

    public function get_highest_certificate(){
        return $this->highest_cert;
    }

    public function set_position($position){
        $this->position = $position;
    }

    public function set_title($title){
        $this->title = $title;
    }

    public function set_qualifications($qualifications){
        $this->qualifications = $qualifications;

    }

    public function register(){
        $conn = new Connection();
        $db_conn = $conn->connect();
        if($db_conn){

        }
    }
}
