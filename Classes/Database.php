<?php
include_once('../functions.php');
$conn = get_connection_handle();
$query = array();

$query[] = "CREATE TABLE IF NOT EXISTS students(
        id int auto_increment primary key, student_id varchar(90) not null,
        name varchar(200) not null, email varchar(400) not null, 
        phone varchar(20), password varchar(255), added_on varchar(50))";

$query[] = "CREATE TABLE IF NOT EXISTS tutors(
        id int auto_increment primary key, tutor_id varchar(90) not null,
        name varchar(200) not null, email varchar(400) not null, 
        phone varchar(20), password varchar(255), added_on varchar(50))";
        
$query[] = "CREATE TABLE IF NOT EXISTS comments(
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        item_id INT NOT NULL,comment VARCHAR(1500) NOT NULL,
        username VARCHAR(250) NOT NULL UNIQUE,
        added_on DATE NOT NULL, comment_time TIME NOT NULL)";

$query[] = "CREATE TABLE IF NOT EXISTS questions(
        id int auto_increment primary key, question text not null, 
        asked_by varchar(500) not null, tags varchar(400), 
        added_on varchar(100))";

$query[] = "CREATE TABLE IF NOT EXISTS notes(
        id int auto_increment primary key,title varchar(450), note text, 
        owner_id int, created_on varchar(25), status enum('public','private'), 
        link varchar(500))";

$query[] = "CREATE TABLE IF NOT EXISTS assignments(
        id int auto_increment primary key, question varchar(500) not null, 
        course varchar(200) not null, given_date varchar(50), 
        submit_date varchar(50), submit_time varchar(15), lecturer varchar(90),
        submission_method varchar(50), submission_format varchar(70),
        added_on varchar(40))";

$query[] = "CREATE TABLE IF NOT EXISTS hostels(
        id int auto_increment primary key,name varchar(250),description text not null, 
        contact varchar(20) not null, campus varchar(40), distance int, 
        facilities varchar(200), rate decimal(10, 2), added_on varchar(20))";

$query[] = "CREATE TABLE IF NOT EXISTS views(
        id INT NOT NULL AUTO_INCREMENT,
        item_id INT NOT NULL, item_title VARCHAR(650) NOT NULL,
        ip_address VARCHAR(1000),views INT NOT NULL, 
        added_on VARCHAR(50), PRIMARY KEY(id, item_id))";

$query[] = "CREATE TABLE IF NOT EXISTS chats(
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, sender_id int, 
        receiver_id int, message text, status enum('viewed','unviewed'),
        added_on VARCHAR(50),added_at varchar(20))";

$query[] = "CREATE TABLE IF NOT EXISTS answers(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, question varchar(500) not null,
    answer text not null, answered_by varchar(250),added_on varchar(40), 
    added_at varchar(40))";

$query[] = "CREATE TABLE IF NOT EXISTS votes(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, type_id int not null,
    vote int not null, type varchar(250), added_on varchar(40))";

$query[] = "CREATE TABLE IF NOT EXISTS lessons(
    id int not null auto_increment primary key,subject varchar(200),
    abbreviation varchar(5), lecturer varchar(200), venue varchar(145), 
    day varchar(25), start varchar(25), end varchar(25))";

$query[] = "CREATE TABLE IF NOT EXISTS events(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(500), organizer VARCHAR(200), contact varchar(25),
            location VARCHAR(750), description VARCHAR(1000),
            type VARCHAR(500), start_date VARCHAR(200), 
            end_date VARCHAR(50), time VARCHAR(20), added_on VARCHAR(50),
            added_at VARCHAR(20), event_misc VARCHAR(150))";

foreach($query as $qry){
    $result = $conn->query($qry);
    
}

if($conn->affected_rows > 0){
echo "<h1 class='text-green'>Created all tables</h1>";
}else{
    echo "<h1>Tables not created - $conn->error";
}
    