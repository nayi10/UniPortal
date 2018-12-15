<?php
include_once 'functions.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Answers
 *
 * @author Alhassan Kamil
 */
class Answers {
    private $question;
    private $table = "answers";

    function __construct($q=null) {
        $this->question = $q;
    }

    function all_answers($question){
        $this->question = $question;
        $conn = get_connection_handle();
        $query  = $conn->query("select * from answers where question = "
                . "$this->question");

        if($query->num_rows > 0){
            return $query;
        }

        return 0;

    }
}
