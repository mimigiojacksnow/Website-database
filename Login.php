<?php
session_start();
require('conn.php');

if(isset($_POST["submitbutton"])){
    //authentication
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];
    $email = $_POST['email'];
    $query = "SELECT  * FROM `user` WHERE `email` = " . "'$email'";
    $result = mysqli_query($conn, $query) OR die('Bad query');
    $msg = "<i style='color:red'> bad creds</i>";
    while($row = mysqli_fetch_array($result)) {
        if($row['status_id'] == 1){
            $hash = $row["password"];
            if(password_verify($pwd, $hash)){
                $_SESSION['level'] = $row['level']; 
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['email'] = $row['email'];
                header("location: index.php");
            } 

        }elseif($row['status_id'] == 2){
            $msg = "<i style='color:red'> Error, this account has been disabled </i>";
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
                            <h1>Login</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- </header> -->
        <!-- Main Content-->
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                    <form action = "login.php" method = "post">
        <div class="card-body">
        <table class = 'table' id="datatablesSimple">        
        <body>
        <table borders = '1'>
            <form action = "login.php" method = "post">
                Username <input type = 'text' name = 'username'> <br>
                Password <input type = 'password' name = 'pwd'> <br> 
                Email <input type = 'text' name = 'email'> <br>
                <input type="submit" name="submitbutton"> <br>
            </form>
        </table>
        <?php
            if(isset($msg)){
                echo $msg;
            }
        ?>
    </body>
    </tbody> 
        </table>
        
</html>