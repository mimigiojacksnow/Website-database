<?php 
    session_start();
    require('../conn.php');
    if($_SESSION['level'] != 1){
        header('location: ../index.php');
    } else {
    $msg = "Select a user and press either button to remove, activate, or edit a blog";
    if(isset($_POST['edit'])){
        if(isset($_POST['blogs'])){
            $query = "SELECT `blog`.`blog_id`, `blog`.`title`,`blog`.`text`, `blog`.`category_id`, `blog`.`description`,`blog`.`publish_id`,`blog`.`date`,`user`.`username`
            FROM `blog`
            INNER JOIN `user` ON `user`.`user_id`=`blog`.`author` 
            WHERE `blog_id` =" . $_POST['blogs'];
            $result = mysqli_query($conn, $query) OR die('Bad query edit');
            $row = mysqli_fetch_array($result);   
            $text = $row[2];
            $title = $row[1];
            $desc = $row[4];
            $_SESSION['edit'] = $_POST['blogs'];
        } else {
            $msg = "You must pick a category and click on the edit button";  
        }
    } elseif(isset($_POST['editFinish'])){
        $edit = $_POST['editor1'];
        $edit_desc = $_POST['desc'];
        $edit_title = $_POST['title'];
        $status = $_POST['status'];
        $category = $_POST['category'];
        $query = "UPDATE `blog` SET `title`='$edit_title',`text`='$edit',`description`='$edit_desc',`publish_id`='$status', `category_id`='$category' WHERE `blog_id` = " . $_SESSION['edit'];
        $result = mysqli_query($conn, $query) OR die('Bad query finish');
    } elseif(isset($_POST['add'])){
        header('location: ../make_blog.php');
    }
    $query = "SELECT `blog`.`blog_id`, `blog`.`title`, `blog`.`description`, `category`.`category`,`published_status`.`published_status`, `user`.`username`, `blog`.`views`, `blog`.`date` 
    FROM `blog` 
    INNER JOIN `category` ON `category`.`category_id`=`blog`.`category_id` 
    INNER JOIN `published_status` ON `published_status`.`publish_id`=`blog`.`publish_id`
    INNER JOIN `user` ON `blog`.`author`=`user`.`user_id`";
    $result = mysqli_query($conn, $query) OR die('Bad query edit');
}
?> 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Users</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Start Bootstrap</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">

                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <li><a class="dropdown-item" href="../logout.php" style = "color:white">Logout</a></li>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <li class="nav-item"><a class="nav-link" href="blogs.php">Blogs</a></li>
                            <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="comments.php">Comments</a></li>
                            <li class="nav-item"><a class="nav-link" href= "categories.php">Categories</a></li>
                            <li class="nav-item"><a class="nav-link" href= '../index.php'>Index</a></li>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $_SESSION['username']?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Blogs</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Blogs</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="blogs.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Users</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="users.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Comments</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="comments.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Categories</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="categories.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Blogs
                            </div>
                            <form action = "blogs.php" method = "post">
                            <div class="card-body">
                            <table class = 'table' id="datatablesSimple">                                      
                                    <thead>
                                        <tr>
                                            <th scope="col">Select</th>
                                            <th scope="col">ID</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Publish</th>
                                            <th scope="col">Views</th>
                                            <th scope="col">Publish Date</th>  
                                        </tr>
                                    </thead>
                                        <?php   
                                            if(isset($msg)){
                                                echo $msg;
                                            }
                                            while($row = mysqli_fetch_array($result)){   
                                                    echo "<tr>
                                                    <td>" . "<input type = radio name = blogs value =" . $row['blog_id'] . "></td>
                                                    <td>" . $row['blog_id'] . "</td>
                                                    <td>" . $row['username'] . "</td>
                                                    <td>" . $row['title'] . "</td>
                                                    <td>" . $row['description'] . "</td>
                                                    <td>" . $row['category'] . "</td>
                                                    <td>" . $row['published_status'] . "</td>
                                                    <td>" . $row['views'] . "</td>
                                                    <td>" . $row['date'] . "</td></tr>";
                                            }
                                        ?>
                                    </tbody> 
                                </table>   
                            <?php if(isset($_POST['edit']) && isset($_POST['blogs'])){  
                                    $query = "SELECT * FROM `category`";
                                    $result = mysqli_query($conn, $query) OR die('Bad query');
                                ?>
                                
                        <head>
                        Title: 
                            <input type = 'text' name = 'title' value = "<?php echo $title ?>">
                            <meta charset="utf-8">
                            <title>Editor</title>
                            <script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
                            </head>
                            Description
                            <input type = 'text' name = 'desc' value = "<?php echo $desc?>">
                            <br> Text
                            <textarea name="editor1" id = editor1> <?php echo $text ?></textarea>
                                <script>
                                    CKEDITOR.replace( 'editor1' );
                                </script>
                        <label for ="status">Status</label>
                            <select name = "status" id ="status" required>
                                <option value = "">---</option>
                                <option value = "1"> public </option>
                                <option value = "2"> removed </option>
                            </select>
                            <label for = "category"> Category: </label>
                            <select name = "category" id ="category" required>
                                <option value = "">---</option>
                                <?php while($row = mysqli_fetch_array($result)) {
                                    echo "<option value =" .  $row['category_id'] . ">"; 
                                    echo $row['category']; 
                                    "</option>";
                                } ?> 
                            </select>
                            <input type="submit" name="editFinish" value = "Edit"> <br>     
                        <?php } ?>
                            <?php if(isset($_POST['edit']) && isset($_POST['blogs'])){ ?>
                            <?php } else { ?>
                                <input type="submit" name="edit" value = "Edit Blogs">
                                <input type="submit" name = "add" value = "Add a Blog">
                        <?php } ?>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <!-- <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>

    </body>

</html>