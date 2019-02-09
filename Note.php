<?php
include_once("functions.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Note
 *
 * @author kamil
 */
class Note {
    private $title, $note, $owner, $added_on, $status, $link;
    private $table = "notes";
    
    public function __construct($title) {
        $this->title = $title;
    }
    public function get_title() {
        return $this->title;
    }
    public function get_note() {
        return $this->note;
    }

    public function get_owner_id() {
        return $this->owner;
    }

    public function get_added_on() {
        return $this->added_on;
    }

    public function get_status() {
        return $this->status;
    }

    public function get_link() {
        return $this->link;
    }

    public function set_title($title) {
        $this->title = $title;
        return $this;
    }

    public function set_note($note) {
        $this->note = $note;
        return $this;
    }

    public function set_owner_id($owner) {
        $this->owner = $owner;
        return $this;
    }

    public function set_added_on($added_on) {
        $this->added_on = $added_on;
        return $this;
    }

    public function set_status($status) {
        $this->status = $status;
        return $this;
    }

    public function set_link($link) {
        $this->link = $link;
        return $this;
    }

    public function save() {
        $conn = get_connection_handle();
        $stmt = $conn->prepare("insert into $this->table(title,note,owner,"
                . "added_on, status, link_id) values(?,?,?,?,?,?)");
        $stmt->bind_param("ssssis", $this->title,$this->note,$this->owner,
                $this->added_on,$this->status,$this->link);
        $stmt->execute();
        $rows = $conn->affected_rows;
        if($rows == 1){
            return true;
        }
        return FALSE;
    }

    public function update($user){
        $conn = get_connection_handle();
        $d = new DateTime();
        $date = $d->format("Y-m-d h:i:sa");
        $stmt = $conn->prepare("UPDATE $this->table SET title = ?,note = ?,"
                . "status = ?, added_on = ?, link_id = ?, owner = ? where id = ?");
        $stmt->bind_param("sssssi", $this->title,$this->note,$this->status,$this->added_on,
        $this->link, $this->owner, $id);
        $stmt->execute();
        if($conn->affected_rows == 1){
            return $conn->affected_rows;
        }
        return FALSE;
    }

}
