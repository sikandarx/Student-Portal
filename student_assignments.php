<?php
require 'session.php';
$session = new session();
$session->student();
$username=$_SESSION['username'];
if(isset($_POST['logout']))
{
    session_destroy();
    header("Location: login.php");
}

require "application.php";
$db=new application();
$assignments=$db->get_teacher_assignments($username);

$si=$db->get_student_id($username);
$student_id = $si->fetch_row()[0];
$notification=$db->get_student_course_notification($student_id);
$notification_all=$db->get_all_notification();
$notification_student=$db->get_student_notification();

$folderPath = 'uploads/';
$fileName = $username.'.jpg';
$file=$folderPath.$fileName;
if(file_exists($file))
{
    $name= $username;
}
else{
    $name="man";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assignments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .nav-item{
            margin: auto 0!important;
        }
        .nav-link{
            padding: 8px 0!important;
            margin-right: 20px!important;
            margin-left: 20px!important;
        }
        .active{
            background-color: #5840ba!important;
            padding: 16px 20px!important;
            border-radius: 0!important;
            margin: 0!important;
        }
        .navbar{
            padding: 0;
        }
        .bg-primary{
            background-color: #5840ba!important;
        }
        .img{
            max-width: 20px;
        }
        .info>*{
            background-color: #d8d8d8;
            padding: 20px;
            margin: 10px 0;
        }
        .d-flex{
            gap: 50px;
        }
        .d-flex>*{
            max-width: 1000px;
        }
        .navbar-nav{
            margin-left: 40px;
        }
        .mini-container{
            margin: 50px 0;
        }
        .cont{

            width: 70%;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin: 20px auto;
        }
        .cont:hover{
            cursor: pointer;
            background-color: #5840ba;
            color: white;
        }
        .no_assignments{
            width: 70%;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin: 20px auto;
        }
        .font-weight-heavy{
            font-weight: 600;
        }
        .custom-dropdown-btn {
            border: none;
            background: none;
            padding: 0;
            margin: 10px 110px;
        }

        .custom-dropdown-btn:focus {
            outline: none;
            box-shadow: none;
        }

        .custom-dropdown-icon {
            display: block;
            width: 32px; /* Set the width and height of your custom icon */
            height: 32px; /* Adjust as needed */
            /* Add any custom icon styles here */
            transition: transform 0.3s ease-in-out; /* Transition for the rotation animation */
        }

        .rotate-right {
            transform: rotate(20deg);
        }

        .rotate-left {
            transform: rotate(-20deg);
        }
        .dropdown-menu.dropdown-menu-right{
            margin-right: 20px!important;
            border-radius: 20px;
            width: 650px;
            max-height: 700px!important;
            padding: 20px;
            overflow-y: auto;
        }
        .notification{
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
            background-color: white;
            max-width: 600px;
            padding: 10px;
            margin: 15px 25px!important;
            border-radius: 10px;
        }
        .notification:hover{
            color: white!important;
            background-color: #5840ba!important;
        }
        .notification_all{
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
            color: white;
            background-color: #ff6969;
            max-width: 600px;
            padding: 10px;
            margin: 15px 25px!important;
            border-radius: 10px;
        }
        .notification_all:hover{
            color: white!important;
            background-color: #5840ba!important;
        }
        @media screen and (max-width:980px) {
            .mtop{
                margin-top: 150px !important;
            }
            .img{
                max-width: 0px!important;
            }
            .info>*{
                width: 800px !important;
            }
            h1{
                font-size: 85px !important;
            }
            h2{
                font-size: 50px !important;
            }
            h4{
                font-size: 40px !important;
            }
            .navbar-nav{
                margin: 0!important;
            }
            .nav-link{
                margin-left: 0!important;
                padding: 16px 20px!important;
                font-size: 40px!important;
            }
            .navbar-toggler-icon {
                font-size: 3.5rem;
            }
            .navbar-toggler{
                margin: 25px;
            }
            .nav-item{
                margin: 20px 0!important;
            }
            .navbar-collapse {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                width: 50%;
                background-color: #343a40; /* Adjust the background color as needed */
                padding: 1rem;
                z-index: 1000;
                transition-duration: 0s;
                animation: slideIn 0.3s forwards;
                transform: translateX(-100%);
            }
            @keyframes slideIn {
                from {
                    transform: translateX(-100%);
                }
                to {
                    transform: translateX(0);
                }
            }

        }
    </style>
</head>
<body>


<nav class="navbar nav-pills navbar-expand-lg bg-dark navbar-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Links -->
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="student_home.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="student_registered_courses.php">Registered Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="student_grades.php">Grades</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="student_assignments.php">Assignments</a>
            </li>
        </ul>
    </div>
    <div class="dropdown">
        <button class="custom-dropdown-btn" type="button" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="custom-dropdown-icon" src="notification_icon.png" alt="Notification Icon">
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
            <h5 class="mb-4 font-weight-heavy">Notifications:</h5>
            <?php
            if($notification->num_rows > 0 || $notification_all->num_rows > 0)
            {
                if ($notification_all->num_rows > 0)
                {
                    foreach ($notification_all as $row):
                        if($row['type']=="all"){
                            ?>
                            <div class="notification_all"><?= $row['message']?>
                                <div><?= $row['created_at']?></div></div>
                        <?php } endforeach;
                }
                if ($notification_student->num_rows > 0)
                {
                    foreach ($notification_student as $row):
                        if($row['type']=="student"){
                            ?>
                            <div class="notification_all"><?= $row['message']?>
                                <div><?= $row['created_at']?></div></div>
                        <?php } endforeach;
                }
                if ($notification->num_rows > 0)
                {
                    foreach ($notification as $row):
                        if($row['type']==""){
                            ?>
                            <div class="notification"><?= $row['message']?>
                                <div><?= $row['created_at']?></div></div>
                        <?php } endforeach;
                }
            }
            else
            {
                echo "<h6 class='text-center m-5'>No notifications to show.</h6>";
            } ?>
        </div>
    </div>
    <div class="btn-group mr-5" style="position: absolute; right: 0;">
        <button class="btn-lg"
                style="width: 50px;
                    height: 50px;
                    border-radius: 50%;
                    background-image: url(uploads/<?= $name?>.jpg);
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-position:center;"
                type="button"
                class="dropdown-toggle"
                data-bs-toggle="dropdown">
        </button>
        <div class="dropdown-menu p-3" style="left: -100px;">
            <div class="dropdown-item">
                <button onclick="window.location.href='student_profile.php';" class="btn"><img src="profile_icon.png" alt="profile icon" class="img mr-1">Profile</button>
            </div>
            <div class="dropdown-item">
                <button onclick="window.location.href='student_settings.php';" class="btn settings"><img src="settings_icon.png" alt="settings icon" class="img mr-1">Settings</button>
            </div>
            <form method="POST" action="student_home.php" class="dropdown-item">
                <input type="hidden" name="logout">
                <button type="submit" class="btn" >
                    <img src="logout_icon1.png" alt="Power Sign" class="img">
                    Log Out</button>
            </form>
        </div>
    </div>
</nav>


<h1 class="p-4 text-center text-white bg-primary">Assignments</h1>

<div class="mini-container">
    <?php
    if ($assignments->num_rows > 0)
    {
    foreach($assignments as $row):
    ?>
    <div class="cont">
        <h2>    <?php
            $course_name=$db->get_title_course($row['course_id']);
            $course = $course_name->fetch_row()[0];
            echo $course;
            ?></h2>
        <h3 class="font-weight-light"><?=$row['title']?></h3>
        <div class="text-right">
            <p><span class="font-weight-heavy">Deadline: </span><?=$row['deadline']?></p>
        </div>
    </div>
    <?php endforeach;}
    else{
        echo "<h5 class='no_assignments text-center'>You have no Assignments.</h5>";
    }?>
</div>
<script>
    $(document).ready(function () {
        var icon = $('.custom-dropdown-icon');

        $('#notificationDropdown').on('click', function () {
            if (!icon.hasClass('rotate-right') && !icon.hasClass('rotate-left')) {
                icon.addClass('rotate-right');

                setTimeout(function () {
                    icon.removeClass('rotate-right');
                    icon.addClass('rotate-left');

                    setTimeout(function () {
                        icon.removeClass('rotate-left');
                    }, 300); // Delay for the left rotation animation (0.3s)
                }, 300); // Delay before starting the left rotation animation (0.3s)
            }
        });
    });
</script>
</body>
</html>