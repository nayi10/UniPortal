<?php
include_once 'User.php';
include_once 'Classes/Connection.php';
/**
 * The Student class provides methods and properties to access and display
 * Student information. It inherits most of its members from the User class
 *
 * @author Alhassan Kamil
 */

 
class Student extends User{
    private $hostel, $student_id, $course_degree, $prog_shortcut;
    private $year_of_completion;

    public function get_id() {
        return $this->student_id;
    }

    public function get_completion(){
        return $this->year_of_completion;
    }

    public function get_course_degree(){
        return $this->course_degree;
    }

    public function set_course_degree($course_deg){
        $this->course_degree = $course_deg;
    }

    public function set_id($id){
        $this->student_id = $id;
    }

    public function set_hostel($hostel){
        $this->hostel = $hostel;
    }

    public function set_completion($yr){
        $this->year_of_completion = $yr;
    }

    public function set_programme_shortcut($shortcut){
        $this->prog_shortcut = $shortcut;
    }

    public function update_details($id, $col, $details){
        $this->student_id = $id;

        $conn = get_connection_handle();
        if(isset($id) && $col !== "" && isset($details) && $details !== ""){
            /* @var $query connection handle */
            $query = $conn->query("update students set "
                    . "$col = $details where student_id = $id");

            if($conn->affected_rows > 0){
                return $rows;
            }  else {
                echo 'Errors: '.$conn->error;
                return $conn->error;
            }
        }
        return \FALSE;
    }

    public function login($student_id, $pass){
        $conn = get_connection_handle();

        $this->student_id = $student_id;
        $this->password = $pass;
        $errors = array();

        if(!is_okay($student_id)){
            $errors[] = 'Stduent ID is required';
        } else{
            $sdt_id = strip_tags(trim(htmlspecialchars($student_id)));
        }

        if(!is_okay($pass)){
            $errors[] = 'Password is required';
        }else{
            $password = $pass;
        }

        if(!$errors){
            $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
            $stmt->bind_param('s', $sdt_id);

            $stmt->execute();

            $result = $stmt->get_result();

            $row = $result->num_rows;

            if($row == 1){

                $r = $result->fetch_assoc();

                if(password_verify($password, $r['password'])){

                    if(!session_id())
                        session_start();

                    $_SESSION["student_id"] = $sdt_id;

                    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

                    $_SESSION['email'] = $r['email'];

                    $_SESSION['id'] = $r['id'];

                    ini_set('session.save_path', "/users/$student_id/sessions");
                    echo "<script>history.go(-2);</script>";

                }else{
                    if(!session_id())
                        session_start();
                    $errors[] = "Invalid Student ID and/or password";
                    $_SESSION['errors'] = $errors;
                }

            } else{
                if(!session_id())
                    session_start();
                $errors[] = "Invalid Student ID and/or password";
                $_SESSION['errors'] = $errors;
            }

        } else{
            if(!session_id())
                session_start();
            $_SESSION["errors"] = $errors;
        }
    }
}
