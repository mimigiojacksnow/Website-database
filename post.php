<?php 
    session_start();
    require('conn.php');
    if(isset($_POST['comment'])){
        $username = $_SESSION['user_id'];
        $comment = $_POST['editor1'];
        $title = htmlentities($_POST['title']);
        $blog_id = $_SESSION['id'];
        $query = "INSERT INTO `comments`(`username`, `comment`, `Title`, `status_id`, `blog_id`) VALUES ('$username','$comment','$title',1,'$blog_id')";
        $result = mysqli_query($conn, $query) OR die('submit bad update'); 
    }
    if(isset($_GET['title']));{
        $queryData=htmlentities($_GET['title']);
    }
    $query ="SELECT * FROM `blog` WHERE `title` = '$queryData'";
    $result = mysqli_query($conn, $query) OR die('view bad query'); 
    while($row = mysqli_fetch_array($result)){
        $x = $row['views'];
        $x = 1 + $x;
        $_SESSION['id'] = $row['blog_id'];
        $query ="UPDATE `blog` SET `views` = $x WHERE `title`='$queryData'";  
    } 
    // blogs
    $result = mysqli_query($conn, $query) OR die('index bad update'); 
    $query = "SELECT `blog`.`blog_id`, `blog`.`title`, `blog`.`description`, `blog`.`text`, `blog`.`views`, `category`.`category`,`user`.`username`, `blog`.`date`     
    FROM `blog` 
    INNER JOIN `category` ON `category`.`category_id`=`blog`.`category_id` 
    INNER JOIN `published_status` ON `published_status`.`publish_id`=`blog`.`publish_id`
    INNER JOIN `user` ON `blog`.`author`=`user`.`user_id` 
    WHERE `blog`.`title` = '$queryData'";
    $result = mysqli_query($conn, $query) OR die('blog bad update'); 
    // Comments
    $query_c = "SELECT `user`.`username`, `comments`.`comment`, `comments`.`Title`,`comments`.`status_id` 
    FROM `comments` 
    INNER JOIN `user` ON `user`.`user_id`=`comments`.`username` 
    WHERE `comments`.`status_id` = 1 AND `blog_id` =" . $_SESSION['id'];
    $result_c = mysqli_query($conn, $query_c) OR die('bad query'); 

    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Clean Blog - Start Bootstrap Theme</title>
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
        <header class="masthead">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="post-heading">
                        <?php $row = mysqli_fetch_array($result); ?>
                            <h1><?php echo $row['title']; ?></h1>
                            <h2 class="subheading"><?php echo $row['description']; ?></h2>
                            Posted by
                            <a href="#!"><?php echo $row['username']; ?></a>
                            on <?php echo $row['date'];?> <br>
                            Category: <?php  echo $row['category']; ?>
                            <span class="meta">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Post Content-->
        <article class="mb-4">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <?php echo $row['text']; ?>
                            <!-- <a href="http://spaceipsum.com/">Space Ipsum</a> -->
                            <!-- &middot; Images by -->
                            <!-- <a href="https://www.flickr.com/photos/nasacommons/">NASA on The Commons</a> -->
                        
                    </div>
                </div>
            </div>
        </article>
        <!-- Footer-->
        <footer class="border-top">
            <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">

                    <!-- <div class="col-md-10 col-lg-8 col-xl-7"> -->
                        <?php if(isset($_SESSION['username'])) {?>
                        <ul class="list-inline text-center">
                            <script src="js/scripts.js"></script>
                            <form action = "post.php?title=<?php echo $queryData; ?>" method = "post">  
                            Leave a comment!    
                            <head>
                                <br> Title: 
                                    <input type = 'text' name = 'title'>
                                    <meta charset="utf-8">
                                    <title>Editor</title>
                                    <script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
                                </head>
                                <br> Text
                                <textarea name="editor1" id = editor1></textarea>
                                    <script>
                                        CKEDITOR.replace( 'editor1' );
                                    </script>
                                <input type="submit" name="comment" value = "Submit"> <br>
                            </form>  
                        </body>
                        <thead>
                        <div class="card mb-4">
                            <form action = "comments.php" method = "post">  
                                <?php } ?>
                                <!-- <div class="card-body"> -->
                                <h2 style = "text-align:center"> Comments </h2>

                                <table class = 'table' id="datatablesSimple">
                                <tr>
                                    <th scope="col">Username</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Comments</th>                             
                                </tr>
                            </thead>
                                <?php 
                                while($row = mysqli_fetch_array($result_c)){
                                    echo '<tr><td>';
                                    echo $row['username'] . "</td><td>";
                                    echo $row['Title'] . "</td><td>";
                                    echo $row['comment']; 
                                    echo "</td></tr>";
                                }
                                ?>
                            </table>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        
</html>
