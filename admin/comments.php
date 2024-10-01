<?php 
session_start();
require('../conn.php');
if($_SESSION['level'] != 1){
    header('location: ../index.php');
} else {
    $msg = "Select a comment and choose one of the button below";
    if (isset($_POST['edit'])){
        if(isset($_POST['comments'])){
            $query = "SELECT `comment`, `Title` FROM `comments` WHERE `comments_id`=" . $_POST['comments'];
            $result = mysqli_query($conn, $query) OR die('cheeseballs');
            $row = mysqli_fetch_array($result);   
            $text = $row[0];
            $title = $row[1];
            $_SESSION['edit'] = $_POST['comments'];
        } else{
            $msg = "Please select both a comment and the edit button";
        }
    }
    //editing 
    elseif(isset($_POST['editFinish'])){
        $edit = $_POST['editor1'];
        $edit_title = $_POST['title'];
        $status = $_POST['status'];
        $query = "UPDATE `comments` SET `comment` = '$edit',`Title`='$edit_title', `status_id` = '$status' WHERE `comments_id`=" . $_SESSION['edit']; 
        $result = mysqli_query($conn, $query) OR die('cheeseballs');

    }
    $query = "SELECT `comments`.`comments_id`, `comments`.`Title`, `comments`.`comment`, `user`.`username`,`published_status`.`published_status`
    FROM `comments`
    INNER JOIN `user` ON `user`.`user_id`=`comments`.`username`
    INNER JOIN `published_status` ON `published_status`.`publish_id`=`comments`.`status_id`";
    $result = mysqli_query($conn, $query) OR die('Bad query comments');
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
                        <h1 class="mt-4">Comments</h1>
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
                            <form action = "comments.php" method = "post">  
                                <div class="card-body">
                                <table class = 'table' id="datatablesSimple">

                                    <thead>
                                        <tr>
                                            <th scope="col">Select</th>
                                            <th scope="col">ID</th>
                                            <th scope="col">Title</th>
                                            <th scope="col"> Comment</th>
                                            <th scope="col"> Username</th>
                                            <th scope="col"> Pulish Status</th>                               
                                        </tr>
                                    </thead>
                                        <?php   
                                            if(isset($msg)){
                                                echo $msg;
                                            }
                                            while($row = mysqli_fetch_array($result)){   
                                                echo "<tr><td>" . "<input type = radio name = comments value =" . $row['comments_id'] . "></td><td>" . $row['comments_id'] . "</td><td>" . $row['Title'] . "</td><td>" . $row['comment'] . "</td><td>" . $row['username'] . "</td><td>" . $row['published_status'] . "</td></tr>";
                                            }
                                        ?>
                                </tbody> 
                            </table> 
                            <input type="submit" name="edit" value = "Edit Comment">
                            <?php if(isset($_POST['edit']) && isset($_POST['comments'])) { ?>
                                <head>
                                <br> Title: 
                                    <input type = 'text' name = 'title' value = "<?php echo $title ?>">
                                    <meta charset="utf-8">
                                    <title>Editor</title>
                                    <script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
                                </head>
                                <br> Text
                                <?php if(isset($_POST['edit'])){ ?>
                                    <textarea name="editor1" id = editor1><?php echo $text ?></textarea>
                                <?php } ?>
                                    <script>
                                        CKEDITOR.replace( 'editor1' );
                                    </script>
                                <label for ="status">Status</label>
                                <select name = "status" id ="status" required>
                                    <option value = "">---</option>
                                    <option value = "1"> public </option>
                                    <option value = "2"> removed </option>
                                </select>
                                <br>
                                <input type="submit" name="editFinish" value = "Finished"> <br>
                                    <?php } ?>
                               
                            </form>  
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>