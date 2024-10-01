<?php 
    session_start();
    // Blogs
    require('conn.php');
    $query = "SELECT `blog`.`blog_id`, `blog`.`title`, `blog`.`description`, `category`.`category`,`published_status`.`published_status`, `user`.`username`, `blog`.`date`, `blog`.`views` 
    FROM `blog` 
    INNER JOIN `category` ON `category`.`category_id`=`blog`.`category_id` 
    INNER JOIN `published_status` ON `published_status`.`publish_id`=`blog`.`publish_id`
    INNER JOIN `user` ON `blog`.`author`=`user`.`user_id` 
    WHERE `blog`.`publish_id` = 1"; 
    $result = mysqli_query($conn, $query) OR die('cheeseballs'); 
    // Category
    $query_c = "SELECT * FROM `category` WHERE `status_id` = 1";
    $result_c = mysqli_query($conn, $query_c) OR die('Bad query');
    if(isset($_POST['filter'])){
        $category = $_POST['category'];
        $query = "SELECT `blog`.`blog_id`, `blog`.`title`, `blog`.`description`, `category`.`category`,`published_status`.`published_status`, `user`.`username`, `blog`.`date`, `blog`.`views`  
        FROM `blog` 
        INNER JOIN `category` ON `category`.`category_id`=`blog`.`category_id` 
        INNER JOIN `published_status` ON `published_status`.`publish_id`=`blog`.`publish_id`
        INNER JOIN `user` ON `blog`.`author`=`user`.`user_id` 
        WHERE `blog`.`publish_id` = 1 AND `blog`.`category_id` = $category"; 
        $result = mysqli_query($conn, $query) OR die('cheeseballs'); 
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
                    Nav
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
        <header class="masthead" style="background-image: url('assets/img/smash-bros-ultimate.png')">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="site-heading">
                            <h1>Super Smash Bros Ultimate</h1>
                            <span class="subheading">Everything you Need to Survive the World of Smash Bros</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main Content-->
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                    <form action = "index.php" method = "post">
                    <label for = "category"> Category: </label>
                    <select name = "category" id ="category" required>
                        <option value = "">---</option>
                        <?php 
                        while($row = mysqli_fetch_array($result_c)) {
                            echo "<option value =" .  $row['category_id'] . ">"; 
                            echo $row['category']; 
                            "</option>";
                        } 
                        ?> 
                    </select>
                    <input type="submit" name="filter" value = "Filter">
                        <?php  echo "<table id ='datatablesSimple'>";   
                        while($row = mysqli_fetch_array($result)){     ?>
                            <tr>
                                <td>
                    <!-- Post preview-->  
                    <div class="post-preview">
                    <h2 class="post-title"><a href="post.php?title=<?php echo $row['title'] ?>"></h2>
                        <h3 class="post-subtitle"><?php echo $row['description'] ?></h3>
                        </a>
                        <p class="post-meta">
                            Description: <?php echo $row['description']; ?> <br>
                            Posted by <?php echo $row['username'] ?>
                            on <?php echo $row['date']?> <br>
                            Category: <?php echo $row['category']?> <br>
                            views <?php echo $row['views']?>
                        </p>
                                </td>
                            </tr>
                        </div>
                        <?php } echo "</table>"; ?>
                    
                    <!-- Divider-->
                    <hr class="my-4" />
                    <!-- Pager-->
                    <div class="d-flex justify-content-end mb-4"><a class="btn btn-primary text-uppercase" href="#!">Older Posts →</a></div>
                </div>
            </div>
        </div>
        <!-- Footer-->
        <footer class="border-top">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <ul class="list-inline text-center">
                            <li class="list-inline-item">
                                <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="small text-center text-muted fst-italic">Copyright &copy; Your Website 2022</div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="admin/js/scripts.js"></script>

    </body>
</html>
