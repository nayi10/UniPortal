<?php
include_once 'functions.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Hostel
 *
 * @author kamil
 */
class Hostel {
    private $name, $description, $contact, $campus, $distance, $facilities, $rate, $date_added;
    private $table = "hostels";
    public function get_description() {
        return $this->description;
    }
    
    public function __construct($name=null) {
        if(!is_null($name)){
            $this->name = $name;
            $row = $this->get_hostel();
            $this->description = $row->description;
            $this->contact = $row->contact;
            $this->campus = $row->campus;
            $this->distance = $row->distance;
            $this->facilities = $row->facilities;
            $this->date_added = $row->added_on;
            $this->rate = $row->rate;
        }
    }

    public function get_contact() {
        return $this->contact;
    }

    public function get_campus() {
        return $this->campus;
    }

    public function get_distance() {
        return $this->distance;
    }

    public function get_facilities() {
        return $this->facilities;
    }

    public function get_rate() {
        return $this->rate;
    }

    public function set_description($description) {
        $this->description = $description;
        return $this;
    }

    public function set_contact($contact) {
        $this->contact = $contact;
        return $this;
    }

    public function set_date_added($date_added) {
        $this->date_added = $date_added;
        return $this;
    }

    public function set_campus($campus) {
        $this->campus = $campus;
        return $this;
    }

    public function set_distance($distance) {
        $this->distance = $distance;
        return $this;
    }

    public function set_facilities($facilities) {
        $this->facilities = $facilities;
        return $this;
    }

    public function set_rate($rate) {
        $this->rate = $rate;
        return $this;
    }

    function set_name($name){
        $this->name = $name;
    }
    function get_name(){
        return $this->name;
    }
    
    function get_date_added(){
        return $this->date_added;
    }

    function get_hostels(){
        $conn = get_connection_handle();
        $query = $conn->query("select * from hostels limit 25");
        if($query && $query->num_rows > 0){
            return $query;
        }
    }

    function get_random_hostels($range=5){
        $conn = get_connection_handle();
        $query = $conn->query("select name, description from hostels 
        order by id DESC limit $range");
        if($query && $query->num_rows > 0){
            return $query;
        }
    }

    function get_hostels_name_campus(){
        $conn = get_connection_handle();
        $query = $conn->query("select name, campus, added_on from hostels limit 30");
        if($query && $query->num_rows > 0){
            return $query;
        }
    }

    function get_hostel(){
        $conn = get_connection_handle();
        $name = $this->name;
        $query = $conn->query("select * from $this->table where name = '$name'");
        if($query && $query->num_rows > 0){
            $row = $query->fetch_object();
            return $row;
        }
        return 0;
    }

    function get_image(){
        $image = md5(strtolower($this->name));
        $y = new DateTime($this->date_added);
        $year = $y->format("Y");
        $full_path = "images/hostels/".$year."/".$image;
        if(file_exists($full_path.".jpg")){
            $img = $full_path.".jpg";
        }elseif(file_exists($full_path.".png")){
            $img = $full_path.".png";
        }elseif(file_exists($full_path.".gif")){
            $img = $full_path.".gif";
        }else{
            $img = "images/hostels/default.jpg";
        }
        return $img;
    }
    public function save() {
        $conn = get_connection_handle();
        $stmt = $conn->prepare("insert into hostels(name,description,"
                . "contact,campus,distance,facilities,rate,added_on) "
                . "values(?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssisis", $this->name,$this->description,
                $this->contact,$this->campus,$this->distance,$this->facilities,
                $this->rate, $this->date_added);
        $stmt->execute();
        $rows = $conn->affected_rows;
        if($rows == 1){
            return true;
        }
        return FALSE;
    }

}
