<?php
include_once("functions.php");
/**
 * The User class is a generic class that contains all the properties and
 * methods to make it possible for users to interact with the application
 *
 * @author Alhassan Kamil
 */
class User {
    //Declaring member variables/properties
    public $firstname, $middlename, $lastname, $programme, $department,$courses;
    public $age, $username, $name, $country, $region, $town, $gender, $notes;
    public $password, $email, $phone, $owner_id;

    function __construct($user=null,$pass=null) {
        $this->username = $user;
        $this->password = $pass;
    }

    /**
     * Gets the name of the current user. Includes the person's first name,
     * lastname, and middle name(if any)
     * @return string
     */
    public function get_name(){
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
     * @param integer $owner_id
     * @return object
     */
    function get_notes($owner_id){
        $conn = get_connection_handle;
        if(is_okay($owner_id)){
            $owner_id = clean_data($owner_id);
            $query = "select * from notes where owner_id = $owner_id";
            $stmt = $conn->query($query);

            return $stmt;
        }
    }

    function get_note($owner_id, $note_id){
        $conn = get_connection_handle;
        if(is_okay($owner_id) && is_okay($note_id)){
            $owner_id = clean_data($owner_id);
            $note_id = clean_data($note_id);

            $query = "select * from $this->table where id = $note_id and "
                    . "owner_id = $owner_id";
            $stmt = $conn->query($query);

            return $stmt;
        }
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

    public function get_courses(){
        return $courses = [$this->courses];
    }

}
