<?php
    session_start();
    require('conn.php');
    $query = "SELECT * FROM `category` WHERE `status_id` = 1";
    $result = mysqli_query($conn, $query) OR die('Bad query');
    if(isset($_POST['submitbutton'])){
        $date = date("y/m/d");
        $username = $_SESSION['user_id'];        
        $title = htmlentities($_POST['title']);
        $text = $_POST['editor1'];
        $description = htmlentities($_POST['description']);
        $category = $_POST['category'];

        if(empty($_POST['title'])){
            $titleMsg = "<i style='color:red'>Cannot leave title blank</i>";
        } elseif(empty($_POST['description'])){
            $descMsg = "<i style='color:red'>Cannot leave description blank</i>";
        } elseif(empty($_POST['editor1'])){
            $textMsg = "<i style='color:red'>Cannot leave text blank</i>";
        } else{
            $query = "INSERT INTO `blog`(`title`, `text`, `author`, `category_id`,`description`, `publish_id`, `date`) 
            VALUES ('$title','$text','$username','$category','$description','1','$date')";
            $result = mysqli_query($conn, $query) OR die('Bad query');
            $msg = "<i style='color:green'> succesfully posted </i>";
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
        <title>Make a Blog!</title>
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
        <!-- <header class="masthead" style="background-image: url('assets/img/smash-bros-ultimate.png')"> -->
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
                            <h1>Create your Blog</h1>
                            <span class="subheading">Create your own blog! </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <!-- </header> -->
        <!-- Main Content-->
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                <script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
                    <form action = "make_blog.php" method = "post">
        <body>
            Title: <input type = 'text' name = 'title'> <?php if(isset($titleMsg)) { echo $titleMsg; }?><br> 
            Description: <input type = 'text' name = 'description'> <?php if(isset($descMsg)) { echo $descMsg; }?> <br>
            Text: <?php if(isset($textMsg)) { echo $textMsg; }?>
        <head>
            <meta charset="utf-8">
            <title>CKEditor</title>
        </head>
            </div>
        </div>
                        
        <body>
            <textarea name="editor1"></textarea>
            <script>
                CKEDITOR.replace( 'editor1' );
            </script>
            <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
        <label for = "category"> Category: </label>
            <select name = "category" id ="category" required>
                <option value = "">---</option>
                <?php while($row = mysqli_fetch_array($result)) {
                    echo "<option value =" .  $row['category_id'] . ">"; 
                    echo $row['category']; 
                    "</option>";
                } ?> 
            </select>
        
        <input type="submit" name="submitbutton">
        <?php if(isset($msg)){
            echo $msg;
        }?>
        </form>
    </body>        

</html>