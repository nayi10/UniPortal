<?php
include_once 'Classes/Connection.php';
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
    private $name, $description, $contact, $campus, $distance, $facilities, $rate;
    private $table = "hostels";

    public function __construct($n,$desc,$contact,$campus,$distance,$facilities,$r) {
        $this->name = $n;
        $this->description = $desc;
        $this->contact = $contact;
        $this->campus = $campus;
        $this->distance = $distance;
        $this->facilities = $facilities;
        $this->rate = $r;
    }

    function get_hostels(){
        $con = new Connection();
        $conn = $con->connect();

        $query = "select * from $this->table";

        $stmt = $conn->query($query);

        return $stmt;
    }

    function get_hostel($id){
        $con = new Connection();
        $conn = $con->connect();

        $query = "select * from $this->table where id = $id";

        $stmt = $conn->query($query);

        return $stmt;
    }

    public function save() {
        $con = new Connection();
        $conn = $con->connect();

        $stmt = $conn->prepare("insert into $this->table(name,description,"
                . "contact,campus,distance,facilities,rate) "
                . "values(?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssisi", $this->name,$this->description,
                $this->contact,$this->campus,$this->distance,$this->facilities,
                $this->rate);

        $stmt->execute();
        $rows = $conn->affected_rows;

        if($rows == 1){
            return $rows;
        }
        return FALSE;
    }

}
