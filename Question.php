<?php
include_once 'Classes/Connection.php';
include_once 'functions.php';

/**
 * Used to manage questions in the system
 *
 * @author Alhassan Kamil
 */
class Question {
    private $question, $asked_by, $tags, $date_;
    private $table = "questions";

    function __construct($q=null,$askby=null,$tags=null,$date_=null){
        $this->question = $q;
        $this->asked_by = $askby;
        $this->tags = $tags;
        $this->date_ = $date_;
    }

    function set_question($q){
        $this->question = $q;
    }

    function set_asker($asker){
        $this->asked_by = $asker;
    }

    function set_tags($tags){
        $this->tags = $tags;
    }

    function set_date($d){
        $this->date_ = $d;
    }

    /**
     * Returns the id number of the current question
     * @return integer The id of this question
     */
    function get_id(){
        $conn = get_connection_handle();
        $res = $conn->query("select id from $this->table where question = "
                . "$this->question");

        if($res->num_rows > 0){
            $id = fetch_item($res);
            $this->id = $id;
            return $this->id;
        }
    }

    function get_question(){
        $conn = get_connection_handle();
        $id = $this->get_id();
        $res = $conn->query("select question from $this->table where id = $id");

        if($res->num_rows > 0){
            $question = fetch_item($res);
            $this->question = $question;
            return $this->question;
        }
    }

    /**
     * Gets the tags of the current question. This returns the tags as a string
     * array
     * @return array All tags of this question
     */
    function get_tags(){
        $conn = get_connection_handle();
        $id = $this->get_id();

        $res = $conn->query("select tags from questions"
                . " where id = $id");

        if($res->num_rows > 0){
            $tags = fetch_item($res);
            return $tags;
        }

        return 0;

    }

    /**
     * Returns the date the current question was asked
     * @return string The date this question was assked
     */
    function get_date(){
        $conn = get_connection_handle();
        $id = $this->get_id();

        $res = $conn->query("select date from questions where id = $id");

        if($res->num_rows > 0){
            $date_ = fetch_item($res);
            return $date_;
        }
    }
    /**
     * Gets the comments of the current question
     * @return mixed An associative array of a comment and its other details
     */
    function get_comments(){
        $conn = get_connection_handle();
        $id = $this->get_id();

        $res = $conn->query("select comment, user, commented_on from comments"
                . " where question_id = $id");

        if($res->num_rows > 0){
            $comment = array();//initialise an associative array comment

            while ($rows = $res->fetch_object()){
                //assign values to $comment array
                $comment['comment'] = $rows->comment;
                $comment['user'] = $rows->user;
                $comment['commented_on'] = $rows->commented_on;
            }
            return $comment;
        }
        return 0;
    }

    /**
     * Returns the number of page visits of the current question
     * @return integer
     */
    function get_views(){
        $conn = get_connection_handle();
        $id = $this->get_id();

        $res = $conn->query("select sum(view) from views"
                . " where type = questions and type_id = $id");

        if($res->num_rows > 0){
            $count = fetch_item($res);
            return $count;
        }
        return 0;
    }

    /**
     *
     * @return integer The total votes for the current question
     */
    function get_votes(){
        $conn = get_connection_handle();
        $id = $this->get_id();

        $res = $conn->query("select sum(vote) from votes"
                . " where type = questions and type_id = $id");

        if($res->num_rows > 0){
            $count = fetch_item($res);
            return $count;
        }
        return 0;
    }

    /**
     * Saves a question details into the database. Note that this depends on the
     *  constructor to store a question. Thus, the class must be fully initialized
     * with non-null values before save() is called. Failure to initialize the
     * constructor will insert null values in some/all fields.
     * @return mixed Returns the number of rows affected by query fi successful,
     * False otherwise
     */
    function save(){
        $con = new Connection();
        $conn = $con->connect();

        $stmt = $conn->prepare("insert into questions(question,asked_by,tags,"
                . "date) values(?,?,?,?)");

        $stmt->bind_param("ssss", $this->question,$this->asked_by,$this->tags,
        $this->date_);

        $stmt->execute();

        if($conn->affected_rows == 1){
            return $conn->affected_rows;
        }

        return FALSE;
    }

    /**
     * Updates this question with a new question @param $question.
     * @param string $question The new question to update to.
     * @param string $tags The new tags you want to assign to the question
     * @return mixed If both @param $question and @param $tags are null, exits
     * the method. If at least one @param is not null, updates and returns the
     * number of rows affected. Returns FALSE if update is not successful.
     */
    function update($question=null,$tags=null){
        $conn = get_connection_handle();
        $id = $this->get_id();

        if(!is_null($question) && !is_null($tags)){
            $stmt = $conn->prepare("update questions set question = ?, tags = ? "
                    . "where id = ?");

            $stmt->bind_param("ssi",$question, $tags,$id);

        }elseif(!is_null($question) && is_null($tags)){

            $stmt = $conn->prepare("update questions set question = ? where id = ?");
            $stmt->bind_param("si", $question, $id);

        }elseif(is_null($question) && !is_null($tags)){

            $stmt = $conn->prepare("update questions set tags = ? where id = ?");
            $stmt->bind_param("si", $tags, $id);

        }else{
            return;
        }

        $stmt->execute();
        if($conn->affected_rows == 1){
            return $conn->affected_rows;
        }

        return FALSE;
    }

    function get_answers(){
        $conn = get_connection_handle();

        $query  = $conn->query("select * from answers where question = $this->question");

        if($query->num_rows > 0){
            return $query;
        }

        return 0;

    }
}
