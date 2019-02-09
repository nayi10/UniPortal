<?php
include_once('../functions.php');
$conn = get_connection_handle();
$query = array();

$query[] = "CREATE TABLE IF NOT EXISTS users(
        id int auto_increment primary key, user_id varchar(90) not null,
        firstname varchar(200) not null, middlename varchar(200), lastname varchar(200) not null, 
        name varchar(200) not null, username varchar(150), email varchar(400) not null, 
        phone varchar(20), password varchar(255), age int, gender enum('mala','female'), 
        programme char(150), department char(150), certificate char(150), hostel char(100),
        nationality varchar(200), region char(150), town char(200), 
        type enum('student','tutor'), added_on DATETIME)";

$query[] = "CREATE TABLE IF NOT EXISTS comments(
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, type varchar(50),
        type_id INT NOT NULL, comment VARCHAR(1500) NOT NULL,
        username VARCHAR(250),
        added_on DATETIME NOT NULL, added_at TIME NOT NULL)";

$query[] = "CREATE TABLE IF NOT EXISTS questions(
        id int auto_increment primary key, question varchar(250),
        description varchar(1000), asked_by varchar(500) not null,
        tags varchar(400), added_on DATETIME)";

$query[] = "CREATE TABLE IF NOT EXISTS notes(
        id int auto_increment primary key,title varchar(450), note text,
        owner varchar(110), added_on DATETIME, status enum('public','private'),
        link varchar(500))";

$query[] = "CREATE TABLE IF NOT EXISTS assignments(
        id int auto_increment primary key, question varchar(500) not null,
        course varchar(200) not null, given_date varchar(50),
        submit_date varchar(50), submit_time varchar(15), lecturer varchar(90),
        submission_method varchar(50), submission_format varchar(70),
        added_on DATETIME)";

$query[] = "CREATE TABLE IF NOT EXISTS hostels(
        id int auto_increment primary key, name varchar(250), description text,
        contact varchar(20) not null, campus char(40), distance int default 0,
        facilities varchar(200), rate decimal(10, 2) default 0, added_on DATETIME)";

$query[] = "CREATE TABLE IF NOT EXISTS views(
        id INT NOT NULL AUTO_INCREMENT,
        item_id INT NOT NULL, item_title VARCHAR(650) NOT NULL,
        ip_address VARCHAR(1000),views INT default 0,
        added_on DATETIME, PRIMARY KEY(id, item_id))";

$query[] = "CREATE TABLE IF NOT EXISTS chats(
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, sender varchar(200),
        receiver varchar(200), message text, status enum('viewed','unviewed'),
        added_on DATETIME,added_at varchar(20))";

$query[] = "CREATE TABLE IF NOT EXISTS answers(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, question varchar(500) not null,
    answer text not null, answered_by varchar(250),added_on DATETIME)";

$query[] = "CREATE TABLE IF NOT EXISTS votes(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, type_id int not null, 
    username varchar(200), votes int default 0, type enum('answer','question'), 
    vote_type enum('upvote','downvote'), added_on DATETIME)";

$query[] = "CREATE TABLE IF NOT EXISTS lessons(
    id int not null auto_increment primary key, subject varchar(200),
    course_code varchar(5), lecturer varchar(200), venue varchar(145),
    day varchar(25), start time, end time)";

$query[] = "CREATE TABLE IF NOT EXISTS submissions(
        id int not null auto_increment primary key, assignment_id varchar(200),
        lecturer varchar(200), username varchar(145),
        date_submitted DATETIME, is_submitted enum('true','false')
        )";
$query[] = "CREATE TABLE IF NOT EXISTS events(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(500), organizer VARCHAR(200), contact varchar(125),
            location VARCHAR(750), description VARCHAR(1000),
            type VARCHAR(500), start_date VARCHAR(150),
            end_date VARCHAR(150), time VARCHAR(20), added_on DATETIME,
            misc VARCHAR(150))";

$query[] = "CREATE TABLE IF NOT EXISTS courses(
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, course_code char(15),
        title CHAR(150), lecturer VARCHAR(200), department char(150),
        description VARCHAR(1000), status enum('core', 'elective'), 
        academic_year char(10), level CHAR(5), 
        term varchar(200), added_on DATETIME)";
        
$query[] = "CREATE TABLE IF NOT EXISTS admins(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(500), firstname VARCHAR(150), middlename varchar(120),
            lastname varchar(150), password VARCHAR(300), email VARCHAR(490),
            phone varchar(50), added_on DATETIME)";

$query[] = "CREATE TABLE IF NOT EXISTS registered_courses(
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        course_code CHAR(15), title VARCHAR(200), lecturer varchar(25),
        username varchar(200), description VARCHAR(1000), department CHAR(150), 
        status enum('core', 'elective'), academic_year char(10), 
        level enum('100','200','300','400','500','600','700','800'),
        term varchar(200),added_on DATETIME)";

foreach($query as $qry){
    $result = $conn->query($qry);

}

if($conn->affected_rows > 0){
echo "<h1 class='text-green'>Created all tables</h1>";
}else{
    echo "<h1>Tables not created - $conn->error";
}
