<?php
include_once 'Classes/Connection.php';
include_once 'functions.php';

/**
 * Used to manage questions in the system
 *
 * @author Alhassan Kamil
 */
class Question {
    private $id, $question, $description, $asked_by, $tags = array(),$tag, $date_;
    private $upvotes, $downvotes;

    function __construct($q=null){
        $this->question = $q;
        if($this->select()){
            $qry = $this->select();
            $row = $qry->fetch_object();
            $this->id = $row->id;
            $this->description = $row->description;
            $this->asked_by = $row->asked_by;
            $this->tags[] = $row->tags;
            $this->date_ = $row->added_on;
            $this->upvotes = $row->upvotes;
            $this->downvotes = $row->downvotes;
        }else{
            $this->select();
        }
    }

    function set_question($q){
        $this->question = $q;
    }

    function set_asker($asker){
        $this->asked_by = $asker;
    }

    function set_tags(...$tags){
      foreach($tags as $val=>$tag)
        $this->tags[$val] = $tag;
    }

    function set_date($d){
        $this->date_ = $d;
    }

    function set_id($id){
        $this->id = $id;
    }

    /**
     * Returns the id number of the current question
     * @return integer The id of this question
     */
    function get_id(){
        $conn = get_connection_handle();
        $res = $conn->query("select id from questions where question = "
                . "'$this->question'");
        if($res && $res->num_rows > 0){
            $row = $res->fetch_object();
            $this->id = $row->id;
            return $row->id;
        }
    }

    function get_question(){
        $conn = get_connection_handle();
        $id = $this->get_id();
        $res = $conn->query("select question from questions where id = $id");
        if($res && $res->num_rows > 0){
            $row = $res->fetch_object();
            $this->question = $row->question;
            return $row->question;
        }
        return false;
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
                . " where id = '$id'");

        if($res && $res->num_rows > 0){
            $rows = fetch_item($res);
            return $tags = explode(",", $rows->tags);
        }

        return false;

    }

    function get_description(){
      $conn = get_connection_handle();
      $id = $this->get_id();

      $res = $conn->query("select description from questions"
              . " where id = '$id'");
      if($res && $res->num_rows > 0){
          $desc = fetch_item($res);
          return $desc->description;
      }
      return false;
    }
    /**
     * Returns the date the current question was asked
     * @return string The date this question was assked
     */
    function get_date(){
        $conn = get_connection_handle();
        $id = $this->get_id();
        $res = $conn->query("select date from questions where id = '$id'");

        if($res && $res->num_rows > 0){
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
                . " where question_id = '$id'");

        if($res && $res->num_rows > 0){
            $comment = array();//initialise an associative array comment

            while ($rows = $res->fetch_object()){
                //assign values to $comment array
                $comment['comment'] = $rows->comment;
                $comment['user'] = $rows->user;
                $comment['commented_on'] = $rows->commented_on;
            }
            return $comment;
        }
        return false;
    }

    /**
     * Returns the number of page visits of the current question
     * @return integer
     */
    function get_views(){
        $conn = get_connection_handle();
        $id = $this->get_id();

        $res = $conn->query("select sum(view) from views"
                . " where type = questions and type_id = '$id'");

        if($res && $res->num_rows > 0){
            $count = fetch_item($res);
            return $count;
        }
        return 0;
    }

    /**
     *
     * @return integer The total votes for the current question
     */
    function get_upvotes(){
        $conn = get_connection_handle();
        $id = $this->get_id();
        $res = $conn->query("select sum(votes) as total from votes where 
        type = 'question' and type_id = '$id' and vote_type = 'upvote'");
        if($res && $res->num_rows > 0){
            $count = $res->fetch_object();
            return $count->total;
        }
        return 0;
    }

    function get_downvotes(){
        $conn = get_connection_handle();
        $id = $this->get_id();
        $res = $conn->query("select sum(votes) as total from votes where 
        type = 'question' and type_id = '$id' and vote_type = 'downvote'");
        if($res && $res->num_rows > 0){
            $count = $res->fetch_object();
            return $count->total;
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
        $conn = get_connection_handle();

        $stmt = $conn->prepare("insert into questions(question, description, 
        asked_by, tags, upvotes, downvotes, added_on) values(?,?,?,?,?,?,?)");

        $stmt->bind_param("ssssiis", $this->question,$this->description,
        $this->asked_by,$this->tags,$this->upvotes,$this->downvotes,
        $this->date_);

        $stmt->execute();

        if($conn->affected_rows == 1){
            return $conn->affected_rows;
        }

        return FALSE;
    }

    public function insert_votes($user,int $upvote = null, int $downvote = null){
        $conn = get_connection_handle();
        $qry = $conn->query("select id from votes where type = 'question' 
        and username = '$user' and type_id = $this->id");
        if($qry->num_rows == 0){
            if(!is_null($upvote) || !empty($upvote)){
                $query = $conn->query("insert into votes(type_id,username,votes,type,
                vote_type, added_on) values($this->id,'$user',$upvote,'question',
                'upvote',CURRENT_DATE)");
                if($conn->affected_rows == 1){
                    echo $conn->affected_rows;
                }else{
                    echo $conn->error;
                }
            }

            if(!is_null($downvote) || !empty($downvote)){
                $query = $conn->query("insert into votes(type_id,username,votes,type,
                vote_type, added_on) values($this->id,'$user',$downvote,'question',
                'downvote',CURRENT_DATE)");
                if($conn->affected_rows == 1){
                    echo $conn->affected_rows;
                }else{
                    echo $conn->error;
                }
            }
        }
    }
    
    /**
     * Updates this question with a new question @param $question.
     * @param string $question The new question to update to.
     * @param string $tags The new tags you want to assign to the question
     * @return mixed If both @param $question and @param $tags are null, exits
     * the method. If at least one @param is not null, updates and returns the
     * number of rows affected. Returns FALSE if update is not successful.
     */
    function update($question=null, $tags=null, $desc=null){
        $conn = get_connection_handle();
        $id = $this->get_id();
        $first = is_first($question, $desc, $tags);
        $second = is_second($question,$desc,$tags);
        $third = is_third($question, $desc, $tags);
        if($first && $second && $third){
            $stmt = $conn->prepare("update questions set question = ?, description = ?, 
            tags = ? where id = ?");
            $stmt->bind_param("ssi",$question, $desc, $tags,$id);

        }elseif($first && $second){
            $stmt = $conn->prepare("update questions set question = ?, description = ? 
            where id = ?");
            $stmt->bind_param("ssi",$question, $desc, $id);

        }elseif($second && $third){
            $stmt = $conn->prepare("update questions set description = ?, tags = ? 
            where id = ?");
            $stmt->bind_param("ssi", $desc, $tags,$id);

        }elseif($first && $third){
            $stmt = $conn->prepare("update questions set question = ?, tags = ? 
            where id = ?");
            $stmt->bind_param("ssi",$question,$tags,$id);

        }elseif($first){
            $stmt = $conn->prepare("update questions set question = ? where id = ?");
            $stmt->bind_param("si", $question, $id);
        }elseif($second){
            $stmt = $conn->prepare("update questions set description = ? where id = ?");
            $stmt->bind_param("si", $desc, $id);
        }elseif($third){
            $stmt = $conn->prepare("update questions set tags = ? where id = ?");
            $stmt->bind_param("si", $tags, $id);
        }

        $stmt->execute();
        if($conn->affected_rows == 1){
            return $conn->affected_rows;
        }
        return FALSE;
    }

    function select($date_=null,$tag=null){
        $conn = get_connection_handle();
        $q = $this->question;
        if(are_not_null($q,$tag, $date_)){
            $query = $conn->query("select * from questions 
            where question = '$q' and tags LIKE '%$tag%' and 
            added_on = '$date_' order by added_on LIMIT 25");
        }elseif(is_first($q, $tag,$date_)){
            $query = $conn->query("select * from questions where 
            question = '$q' order by added_on LIMIT 25");
        }elseif(is_second($q, $tag,$date_)){
            $query = $conn->query("select * from questions where 
            tags like '%$tag%' order by added_on LIMIT 25");
        }elseif(is_third($q, $tag,$date_)){
            $query = $conn->query("select * from questions where 
            added_on = '$date_' order by added_on LIMIT 25");
        }else{
            $query = $conn->query("select * from questions order by added_on LIMIT 25");
        }
        if($query && $query->num_rows > 0){
            return $query;
        }
        return false;
    }

    function get_all($limit=null){
        $conn = get_connection_handle();
        if(!is_null($limit)){
            $query = $conn->query("select * from questions order by added_on DESC LIMIT $limit");
        }else{
            $query = $conn->query("select * from questions order by added_on DESC LIMIT 25");
        }
        
        if($query && $query->num_rows > 0){
            return $query;
        }
        return false;
    }
    function get_questions($limit=null){
        $conn = get_connection_handle();
        if(!is_null($limit)){
            $query = $conn->query("select question from questions order by added_on DESC LIMIT $limit");
        }else{
            $query = $conn->query("select question from questions order by added_on DESC LIMIT 25");
        }
        
        if($query && $query->num_rows > 0){
            return $query;
        }
        return false;
    }

    function get_answers(){
        $conn = get_connection_handle();

        $query  = $conn->query("select * from answers where
        question = '$this->question'");
        if($query && $query->num_rows > 0){
            return $query;
        }
        return false;
    }

    function get_num_answers(){
        $conn = get_connection_handle();
        $query  = $conn->query("select count(id) as num from answers where
        question = '$this->question'");
        if($query && $query->num_rows > 0){
            $count = $query->fetch_object();
            return $count->num;
        }

        return 0;

    }
}
