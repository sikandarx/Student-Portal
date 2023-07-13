
<!DOCTYPE html>
<html>
<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <?php
    require 'application.php';
    if($_POST)
    {

        if($_POST['email'] != "" && $_POST['number'] != "" && $_POST['batch'] != ""&& $_POST['email'] != ""&& $_POST['gender'] != "")
            {
                $connection = new application();
                $connection->insert_student($_POST['name'], $_POST['number'], $_POST['batch'],$_POST['email'], $_POST['gender'], $_POST['about_yourself']);
            }
        else{
            echo "<p class='p-2 text-white bg-danger text-center' >Incomplete credentials</p>";
        }

    }
    ?>
</head>
<body>
<h1 class="p-4 text-center text-white bg-primary">Enter Student Info</h1>
<div class="container mt-5">
    <form name ="bio" method="POST" action="student_info.php">
        <div class="form-group">
            <label for="name">Name<span class="text-danger"> *</span></label>
            <input type="text" class="form-control" id="name"  name="name" placeholder="Enter your name" required>
        </div>
        <div class="form-group">
            <label for="roll_number">Roll number<span class="text-danger"> *</span></label>
            <input type="text" class="form-control" id="roll_number" name="number" placeholder="Enter your Roll number" required>
        </div>
        <div class="form-group">
            <label for="batch">Batch<span class="text-danger"> *</span></label>
            <select class="form-control" id="batch" name="batch">
                <option value="">(Select your Batch)</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
            </select>
        </div>
        <div class="form-group">
            <label for="email">Email address<span class="text-danger"> *</span></label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="gender">Gender<span class="text-danger"> *</span></label>
            <select class="form-control" id="gender" name="gender">
                <option value="">(Select your Gender)</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="about-yourself">About yourself</label>
            <textarea class="form-control" id="about_yourself" name="about_yourself" rows="4" placeholder="Tell us about yourself"></textarea>
        </div>
        <button type="submit" class="btn btn-primary" >Submit</button>
    </form>
    <a href="student_info_table.php" target="_blank">
        <button class="btn btn-secondary my-3">Student Data Table</button>
    </a>
</div>
</body>
</html>





