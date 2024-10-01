<?php
require('conn.php');
if(isset($_POST['submitbutton'])){
    if(!empty($_POST['username']) && !empty($_POST['pwd']) && !empty($_POST['email']) && !empty($_POST['dob'] && !empty($_POST['fname']) && !empty($_POST['lname']))) {
        $username = htmlentities($_POST['username']); 
        $password = $_POST['pwd'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $fname = htmlentities($_POST['lname']); 
        $lname = htmlentities($_POST['fname']);  
        $hash = password_hash($password, PASSWORD_DEFAULT); 
        $query = "SELECT * FROM `user` WHERE `email` = '" . $email . "'";
        $result = mysqli_query($conn,$query) or DIE('bad query');
        while($row = mysqli_fetch_array($result)) {
            $dbpassword = $row['password'];
            $dbemail = $row['email'];
            $dbusername = $row['username'];
        } 
        if (!ISSET($dbusername)) {    
            $query = "INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `dob`, `lname`, `fname`, `status_id`, `level`)  
            VALUES (NULL, '$username', '$hash', '$email', '$dob', '$fname','$lname' , 1, 2)";
            mysqli_query($conn,$query) or DIE("Bad Query");
            $msg = "<i style='color:green'> account made </i>";
        } else {
            $msg = "<i style='color:red'> Email Is Already in Use</i>";
            } 
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Everything About Smash Bros</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="CSS/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.php">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    cheese
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="index.php">Home</a></li>
                        <?php if(isset($_SESSION['username'])) { ?>
                            <?php if($_SESSION['level'] == 1){ ?>
                                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="admin/index.php">Admin</a></li>
                            <?php } ?>
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="make_blog.php">Create Post</a></li>
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="manage_blogs.php">Manage Blogs</a></li>
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="logout.php">Logout</a></li>

                        <?php } else { ?>
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="Login.php">Login</a></li>
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="Register.php">Register</a></li>
                        <?php } ?>
                        
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page Header-->
        <div class = "header">
        <style>    
        .header {
            padding: 60px;
            text-align: center;
            background: grey;
            color: white;
            font-size: 30px;
            }            
            </style>
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="site-heading">
                            <h1>Register</h1>
                            <span class="subheading">Create your account now!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- </header>  -->
        <!-- Main Content-->
        <br>
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                    <form action = "register.php" method = "post">
    <form action = "Register.php" method = "post">
        Username: <input type = 'text' name = 'username' required> <br>
        Password: <input type = 'password' name = 'pwd' required> <br>
        Email: <input type = 'email' name = 'email' required> <br> 
        First name: <input type = 'text' name = 'fname' required>  <br>
        Last Name: <input type = 'text' name = 'lname' required> <br>
        Date of Birth: <input type = 'date' name = 'dob' required> <br>
        <!-- Level <input type = '' name = 'level'> <br> -->
        <input type="submit" name="submitbutton"> <br>
        <?php
            if(isset($msg)){
                echo $msg;
            }
        ?>
    </form>
</html>