<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lesson
 *
 * @author kamil
 */
class Lession {
    private $subject, $abbre, $lecturer, $venue, $day, $start, $end;
    private $table = "lessons";

    function __construct($s=NULL,$a=null,$l=null,$v=null,$d=null,$st=null,$end=null) {
        $this->subject = $s;
        $this->abbre = $a;
        $this->venue = $v;
        $this->lecturer = $l;
        $this->day = $d;
        $this->start = $st;
        $this->end = $end;
    }
      public function save() {
        $con = new Connection();
        $conn = $con->connect();

        $stmt = $conn->prepare("insert into $this->table(subject,abbreviation,"
                . "lecturer, venue, day, start, end) values(?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssss", $this->subject,$this->abbre,$this->lecturer,
                $this->venue, $this->day, $this->start,  $this->end);

        $stmt->execute();
        $rows = $conn->affected_rows;

        if($rows == 1){
            return $rows;
        }
        return FALSE;
    }

    public function update($id, $lect,$venue,$day,$start,$end){
        $con = new Connection();
        $conn = $con->connect();

        $stmt = $conn->prepare("update $this->table set lecturer = ?, venue = ?,"
                . " day = ?, start = ?, end = ? where id = ?");
        $stmt->bind_param("sssssi", $lect,$venue, $day, $start,  $end, $id);

        $stmt->execute();
        $rows = $conn->affected_rows;

        if($rows == 1){
            return $rows;
        }
        return FALSE;
    }

}
