<?php
include_once 'functions.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Deals with answers posted by members
 *
 * @author Alhassan Kamil
 */
 class Answer {
    private $question, $answer, $id, $upvotes, $downvotes, $answered_by;
    private $table = "answers";

    function __construct($question=null, $answer=null) {
        if(!is_null($question)){
            $this->question = $question;
            $this->answer = $answer;
        }
    }
    public function get_question() {
        return $this->question;
    }

    public function get_answer() {
        return $this->answer;
    }

    public function get_answered_by() {
        return $this->answered_by;
    }

    public function set_question($question) {
        $this->question = $question;
        return $this;
    }

    public function set_answer($answer) {
        $this->answer = $answer;
        return $this;
    }

    public function set_answered_by($answered_by) {
        $this->answered_by = $answered_by;
        return $this;
    }

    function set_upvotes($upvotes){
        $this->upvotes = $upvotes;
    }
    
    function set_downvotes($downvotes){
        $this->downvotes = $downvotes;
    }
    
    function all_answers(){
        $conn = get_connection_handle();
        $query  = $conn->query("select * from answers where question = "
                . "$this->question");
        if($query->num_rows > 0){
            return $query;
        }
        return 0;
    }
    
    function set_id($id){
        $this->id = $id;
    }

    function get_id(){
        $conn = get_connection_handle();
        $res = $conn->query("select id from answers where answer = '$this->answer'");
        if($res->num_rows > 0){
            $row = $res->fetch_object();
            $this->id = $row->id;
            return $this->id;
        }else{
            return $this->id;
        }
    }

    function get_upvotes(){
        $conn = get_connection_handle();
        $qry = $conn->query("select sum(votes) as total from votes where type = 'answer'  
        and vote_type = 'upvote' and type_id = $this->id");
        echo $conn->error;
        if($qry->num_rows > 0){
            $row = $qry->fetch_object();
            return $row->total;
        }
        return '0';
    }
    
    function get_downvotes(){
        $conn = get_connection_handle();
        $qry = $conn->query("select sum(votes) as total from votes where type = 'answer'  
        and vote_type = 'downvote' and type_id = $this->id");
        if($qry->num_rows > 0){
            $row = $qry->fetch_object();
            return $row->total;
        }
        return '0';
    }
    public function update_votes($user,int $upvote = null, int $downvote = null){
        $conn = get_connection_handle();
        if(!is_null($upvote) || !empty($upvote)){
            $query = $conn->query("update answers set upvotes = upvotes + $upvote 
            where question = '$this->question' and answered_by = '$user'");
            if($conn->affected_rows == 1){
                echo $conn->affected_rows;
            }else{
                echo $conn->error;
            }
        }

        if(!is_null($downvote) || !empty($downvote)){
            $query = $conn->query("update answers set downvotes = downvotes - $downvote 
            where question = '$this->question' and answered_by = '$user'");
            if($conn->affected_rows == 1){
                echo $conn->affected_rows;
            }else{
                echo $conn->error;
            }
        }
    }

    function add_answer($username,$date){
        $conn = get_connection_handle();
        $qry = $conn->query("select id from answers where answered_by = '$username' 
        and question = '$this->question'");
        if($qry->num_rows == 0){
            $query = $conn->prepare("insert into answers(question, answer, answered_by, 
            added_on) values(?,?,?,?)");
            $query->bind_param("ssss", $this->question, $this->answer, $username, $date);
            $query->execute();
            if($conn->affected_rows == 1){
                return true;
            }else{
                return false;
            }
        }
    }

    public function insert_votes($user,int $upvote = null, int $downvote = null){
        $conn = get_connection_handle();
        $qry = $conn->query("select id from votes where type = 'answer' and username = '$user' 
        and type_id = $this->id");
        if($qry->num_rows == 0){
            if(!is_null($upvote) || !empty($upvote)){
                $query = $conn->query("insert into votes(type_id,username,votes,type,
                vote_type, added_on) values('$this->id','$user',$upvote,'answer',
                'upvote',CURRENT_DATE)");
                if($conn->affected_rows == 1){
                    echo $conn->affected_rows;
                }else{
                    echo $conn->error;
                }
            }

            if(!is_null($downvote) || !empty($downvote)){
                $query = $conn->query("insert into votes(type_id,username,votes,type,
                vote_type, added_on) values('$this->id','$user',$downvote,'answer',
                'downvote',CURRENT_DATE)");
                if($conn->affected_rows == 1){
                    echo $conn->affected_rows;
                }else{
                    echo $conn->error;
                }
            }
        }
    }
    
    function get_comments(){
        $conn = get_connection_handle();
        $id = $this->get_id();
        $res = $conn->query("select comment, username, added_on, added_at
        from comments where type_id = '$id'");
        if($res->num_rows > 0){
            return $res;
        }
        return false;
    }
}
