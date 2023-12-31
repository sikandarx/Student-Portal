<?php
class application
{
    public $conn;
    public function __construct()
    {
        $host = "localhost";
        $db_name = "my_app";
        $username = "root";
        $password = "83110";
        $this->conn = new mysqli($host, $username, $password, $db_name);
        if ($this->conn->connect_error)
        {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    //-------------//
    //Student Functions
    //-------------//
    public function insert_student($name, $number,$batch,$email,$gender)
    {
        $sql = "INSERT INTO student (`name`, `roll_number`,`batch`, `email`,`gender`) VALUES ('$name', '$number','$batch','$email','$gender')";
        $result = mysqli_query($this->conn, $sql);
        if(!$result)
        {
            echo "<p class='p-2 mx-5 text-white bg-success text-center' >There is some issue with record creation</p>";
        }
        else
        {
            echo "<p class='p-2 mx-5 text-white text-center bg-success'>Data submitted</p>";
        }
    }
    public function get_data_student()
    {

        $result = $this->conn->query("SELECT * FROM `student`");
        return $result;
    }
    public function delete_student($id) {
        $sql = "DELETE FROM `student` WHERE student_id = $id";
        $this->conn->query($sql);
    }

    //----------------//
    //Course Functions
    //---------------//
    public function insert_course($course_title, $credit_hours,$course_teacher,$semester_number,$curriculum, $course_info)
    {
        $sql = "INSERT INTO course (`course_title`, `credit_hours`, `course_teacher`,`semester_number`,`curriculum`, `course_info`) VALUES ('$course_title', '$credit_hours','$course_teacher','$semester_number','$curriculum','$course_info')";
        $result = mysqli_query($this->conn, $sql);
        if(!$result)
        {
            echo "<p class='p-2 mx-5 text-white bg-danger text-center mx-5' >There is some issue with record creation</p>";
        }
        else
        {
            echo "<p class='p-2 mx-5 text-white bg-success text-center mx-5' >Data submitted</p>";
        }
    }
    public function get_data_course()
    {
        $result = $this->conn->query("SELECT * FROM `course`");
        return $result;
    }
    public function get_title_course($id)
    {
        $result = $this->conn->query("SELECT course_title FROM `course` WHERE course_id=".$id);
        return $result;
    }
    public function delete_course($id) {
        $sql = "DELETE FROM `course` WHERE course_id = $id";
        $this->conn->query($sql);
    }

    public function enroll_student($student_id, $course_id, $grade) {
        $sql = "INSERT INTO student_course (student_id, course_id, grade) VALUES ($student_id, $course_id, '$grade')";
        $enroll=$this->conn->query($sql);
        if(!$enroll)
        {
            echo "<p class='p-2 mx-5 text-white bg-danger text-center' >There is some issue with record creation</p>";
        }
        else
        {
            echo "<p class='p-2 mx-5 text-white bg-success text-center' >Enrollment Successfull</p>";
        }
    }
    public function delete_student_enroll($id) {
        $sql = "DELETE FROM `student_course` WHERE id = $id";
        $this->conn->query($sql);
    }
    public function get_student_enroll_data($course_id)
    {
        $sql="SELECT c.id as'Id',  b.name as 'Student Name', b.email as 'Student Email' , b.roll_number as 'Student Roll Number', c.grade as 'Grade' FROM `student_course` c JOIN student b on c.student_id = b.student_id JOIN course a on c.course_id = a.course_id WHERE a.course_id = ". $course_id;
        $result = $this->conn->query($sql);
        return $result;
    }
    public function get_student_id($username)
    {

        $result = $this->conn->query("SELECT student_id FROM `student` WHERE email='$username'");
        return $result;
    }
    public function get_data_student_grades($username){
        $result = $this->conn->query("SELECT sc.grade, c.* FROM `student` s JOIN `student_course` sc ON s.student_id = sc.student_id JOIN `course` c ON sc.course_id = c.course_id WHERE s.email = '$username'");
        return $result;
    }
    public function insert_teacher($name, $number,$email,$gender)
    {
        $sql = "INSERT INTO teacher (`name`, `number`, `email`,`gender`) VALUES ('$name', '$number','$email','$gender')";
        $result = mysqli_query($this->conn, $sql);
        if(!$result)
        {
            echo "<p class='p-2 mx-5 text-white bg-success text-center' >There is some issue with record creation</p>";
        }
        else
        {
            echo "<p class='p-2 mx-5 text-white text-center bg-success'>Data submitted</p>";
        }
    }
    public function get_data_teacher()
    {

        $result = $this->conn->query("SELECT * FROM `teacher`");
        return $result;
    }
    public function get_teacher_name($id)
    {
        $result = $this->conn->query("SELECT name FROM `teacher` WHERE teacher_id=".$id);
        return $result;
    }
    public function get_teacher_id($username)
    {
// Assuming $username contains the value you want to search for
        $sql = "SELECT teacher_id as 'ID' FROM `teacher` WHERE email=?";
        $stmt = mysqli_prepare($this->conn, $sql);

        if ($stmt) {
            // Bind the parameter to the prepared statement
            mysqli_stmt_bind_param($stmt, "s", $username);

            // Execute the prepared statement
            mysqli_stmt_execute($stmt);

            // Get the result
            $result = mysqli_stmt_get_result($stmt);

            // Check if the query was successful and if there are any rows returned
            if ($result && mysqli_num_rows($result) > 0) {
                // Do something with the result, e.g., fetch data from rows
                while ($row = mysqli_fetch_assoc($result)) {
                    return $row['ID'];
                }
            } else {
                // No results found
                echo "No records found.";
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Handle the error if the prepared statement fails
            echo "Error in the prepared statement: " . mysqli_error($this->conn);
        }
    }
    public function delete_teacher($id) {
        $sql = "DELETE FROM `teacher` WHERE teacher_id = $id";
        $this->conn->query($sql);
    }
    public function enroll_teacher($teacher_id, $course_id) {
        $sql = "INSERT INTO teacher_course (teacher_id, course_id) VALUES ($teacher_id, $course_id)";
        $enroll=$this->conn->query($sql);
        if(!$enroll)
        {
            echo "<p class='p-2 mx-5 text-white bg-danger text-center' >There is some issue with record creation</p>";
        }
        else
        {
            echo "<p class='p-2 mx-5 text-white bg-success text-center' >Enrollment Successfull</p>";
        }
    }
    public function get_teacher_enroll_data($teacher_id)
    {
        $sql="SELECT c.id as 'ID', a.course_id as 'Course ID' ,a.course_title as 'Course Title', a.credit_hours as 'Credit Hours' , a.semester_number as 'Semester Number', a.curriculum as 'Curriculum' FROM `teacher_course` c JOIN `teacher` b on c.teacher_id = b.teacher_id JOIN course a on c.course_id = a.course_id WHERE b.teacher_id = ". $teacher_id;
        $result = $this->conn->query($sql);
        return $result;
    }
    public function delete_teacher_enroll($id) {
        $sql = "DELETE FROM `teacher_course` WHERE id = $id";
        $this->conn->query($sql);
    }
    public function get_teacher_username_info($username)
    {
        $result = $this->conn->query("SELECT * FROM `teacher` WHERE email = '$username'");
        return $result;
    }
    public function teacher_grade($grade,$id) {
        $sql = "UPDATE `student_course` SET grade='$grade' WHERE id= '$id'";
        $enroll=$this->conn->query($sql);
        if(!$enroll)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    public function teacher_assignments($course_id,$title,$description,$date) {
        $currentDateTime = date("y-m-d h:i:s");
        $result=$this->conn->query("INSERT INTO assignments (course_id,title,description,deadline,upload_time) VALUES($course_id,'$title','$description','$date','$currentDateTime')");
        if(!$result)
        {
            echo "<p class='p-2 mx-5 text-white bg-danger text-center' >There is some issue with record creation</p>";
        }
        else
        {
            echo "<p class='p-2 mx-5 text-white bg-success text-center' >Saved Successfully</p>";
        }
    }
    public function get_teacher_assignments($username) {
        $result = $this->conn->query("SELECT a.* FROM `student` s JOIN `student_course` sc ON s.student_id = sc.student_id JOIN `assignments` a ON sc.course_id = a.course_id WHERE s.email = '$username' ORDER BY a.upload_time DESC");
        return $result;
    }
    public function get_teacher_assignments_id($id) {
        $result = $this->conn->query("SELECT * FROM `assignments` WHERE id = $id");
        return $result;
    }
    public function get_data_login($username,$password)
    {
        $result = $this->conn->query("SELECT * FROM `users` WHERE username = '$username' AND password = '$password'");
        return $result;
    }
    public function check_email_repeat($username)
    {
        $result = $this->conn->query("SELECT * FROM `users` WHERE username = '$username'");
        return $result;
    }
    public function check_email($username)
    {
        $result = $this->conn->query("SELECT * FROM `student` WHERE email = '$username'");
        return $result;
    }

    public function get_username_info($username)
    {
        $result = $this->conn->query("SELECT * FROM `student` WHERE email = '$username'");
        return $result;
    }

    public function get_data_student_course($username){
        $result = $this->conn->query("SELECT s.student_id, sc.course_id, c.* FROM `student` s JOIN `student_course` sc ON s.student_id = sc.student_id JOIN `course` c ON sc.course_id = c.course_id WHERE s.email = '$username'");
        return $result;
    }

    public function signup_users($username,$password,$type){
        $sql = "INSERT INTO users (`username`,`password`,`type`) VALUES ('$username','$password','$type')";
        $result = mysqli_query($this->conn, $sql);
        if(!$result)
        {
            echo "<p class='p-2 mx-5 text-white bg-danger text-center mx-5' >There is some issue with creating account!!</p>";
        }
        else
        {
            echo "<script>window.location.href = 'image.php';</script>";
            exit;
        }
    }
    public function admin_signup_users($username,$password,$type){
        $sql = "INSERT INTO users (`username`,`password`,`type`) VALUES ('$username','$password','$type')";
        $result = mysqli_query($this->conn, $sql);
        if(!$result)
        {
            echo "<p class='p-2 mx-5 text-white bg-danger text-center mx-5' >There is some issue with creating account!!</p>";
        }
        else
        {
            echo "<p class='p-2 mx-5 text-white bg-success text-center mx-5' >$type Account created.</p>";
        }
    }

    public function get_course_count($course_id){
        $result = $this->conn->query("SELECT COUNT(*) AS count FROM student_course WHERE course_id='$course_id'");
        return $result;
    }
    public function grade_percentage($grade)
    {
        if($grade=='A+')
        {
            return 4.0;
        }
        elseif($grade=='A')
        {
            return 4.0;
        }
        elseif($grade=='A-')
        {
            return 3.7;
        }
        elseif($grade=='B+')
        {
            return 3.4;
        }
        elseif($grade=='B')
        {
            return 3.0;
        }
        elseif($grade=='B-')
        {
            return 2.7;
        }
        elseif($grade=='C+')
        {
            return 2.4;
        }
        elseif($grade=='C')
        {
            return 2.0;
        }
        elseif($grade=='C-')
        {
            return 1.7;
        }
        elseif($grade=='D+')
        {
            return 1.4;
        }
        elseif($grade=='D')
        {
            return 1.0;
        }
        elseif($grade=='F')
        {
            return 0.0;
        }

    }
    public function gpa(array $arr)
    {
        $sum = 0;
        $count = count($arr);

        if ($count === 0) {
            return 0;
        }

        foreach ($arr as $num) {
            $sum += $num;
        }

        return $sum / $count;
    }
    public function announcement_notification($message)
    {
        $course_id=0;
        $currentDateTime = date("y-m-d h:i:s");
        $this->conn->query("INSERT INTO `notifications` (course_id, message, created_at,type) VALUES ($course_id, '$message', '$currentDateTime', 'all')");
    }
    public function student_notification($course_id, $message)
    {
        $currentDateTime = date("y-m-d h:i:s");
        $this->conn->query("INSERT INTO `notifications` (course_id, message, created_at,type) VALUES ($course_id, '$message', '$currentDateTime', '')");
    }
    public function admin_notification($type,$message)
    {
        $course_id=27;
        $currentDateTime = date("y-m-d h:i:s");
        $result=$this->conn->query("INSERT INTO `notifications` (course_id, message, created_at,type) VALUES ($course_id, '$message', '$currentDateTime', '$type')");
        if(!$result)
        {
            echo "<p class='p-2 mx-5 text-white bg-danger text-center mx-5' >There is some issue with sending Anouncement!!</p>";
        }
        else
        {
            echo "<p class='p-2 mx-5 text-white bg-success text-center mx-5' >Anouncement sent to $type.</p>";
        }

    }
    public function get_student_course_notification($student_id)
    {
        $result = $this->conn->query("SELECT n.* FROM `student` s JOIN `student_course` sc ON s.student_id = sc.student_id JOIN `notifications` n ON n.course_id = sc.course_id WHERE sc.student_id = $student_id ORDER BY n.created_at DESC");
        return $result;
    }

    public function get_student_notification()
    {
        $result = $this->conn->query("SELECT * FROM `notifications` WHERE type = 'student' ORDER BY created_at DESC");
        return $result;
    }

    public function get_teacher_notification()
    {
        $result=$this->conn->query("SELECT * FROM `notifications`  WHERE type = 'teacher' ORDER BY created_at DESC");
        return $result;
    }
    public function get_all_notification()
    {
        $result = $this->conn->query("SELECT * FROM `notifications` WHERE type = 'all' ORDER BY created_at DESC");
        return $result;
    }
}
?>