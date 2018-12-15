<?php

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
    private $title, $note, $owner_id, $created_on, $status, $link;
    private $table = "notes";

    function __construct($title=null,$note=null,$owner_id=null,$create_on=null,$status=null,$link=NULL) {
        $this->title = $title;
        $this->note = $note;
        $this->created_on = $create_on;
        $this->owner_id = $owner_id;
        $this->status = $status;
        $this->link = $link;
    }

    public function save() {
        $con = new Connection();
        $conn = $con->connect();

        $stmt = $conn->prepare("insert into $this->table(title,note,owner_id,"
                . "created_on, status, link) values(?,?,?,?,?,?)");
        $stmt->bind_param("ssssis", $this->title,$this->note,$this->owner_id,
                $this->created_on,$this->status,$this->link);

        $stmt->execute();
        $rows = $conn->affected_rows;

        if($rows == 1){
            return $rows;
        }
        return FALSE;
    }

    public function update($id,$title=null,$note=null,$status=null){
        $con = new Connection();
        $conn = $con->connect();

        if(!is_null($title) && !is_null($note) && !is_null($status)){

            $stmt = $conn->prepare("UPDATE $this->table SET title = ?,note = ?,"
                    . "status = ? where id = ?");
            $stmt->bind_param("sssi", $title,$note,$status,$id);

        }elseif(is_null($title) && is_null($note) && !is_null($status)){

            $stmt = $conn->prepare("UPDATE $this->table SET status = ? where id = ?");
            $stmt->bind_param("si", $title,$note,$status,$id);

        }elseif(is_null($title) && !is_null($note) && !is_null($status)){

            $stmt = $conn->prepare("UPDATE $this->table SET note = ?, status = ? "
                    . "where id = ?");
            $stmt->bind_param("ssi", $note,$status,$id);

        }elseif(!is_null($title) && is_null($note) && !is_null($status)){

            $stmt = $conn->prepare("UPDATE $this->table SET title = ?, status = ?"
                    . " where id = ?");
            $stmt->bind_param("ssi", $title,$status,$id);

        }elseif(is_null($title) && !is_null($note) && is_null($status)){

            $stmt = $conn->prepare("UPDATE $this->table SET note = ? where id = ?");
            $stmt->bind_param("si", $note,$id);

        }elseif(!is_null($title) && !is_null($note) && !is_null($status)){

            $stmt = $conn->prepare("UPDATE $this->table SET title = ?, note = ?"
                    . " where id = ?");
            $stmt->bind_param("ssi", $title,$note,$id);

        }elseif(!is_null($title) && is_null($note) && is_null($status)){

            $stmt = $conn->prepare("UPDATE $this->table SET title = ? where id = ?");
            $stmt->bind_param("si", $title, $id);

        }else{

            return;
        }

        $stmt->execute();

        if($conn->affected_rows == 1){
            return $conn->affected_rows;
        }
        return FALSE;
    }

}
