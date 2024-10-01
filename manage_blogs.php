<?php 
    SESSION_START();
    require('conn.php');
    $msg = "Select a post and press the edit button";
    $email = $_SESSION['email'];
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
        $edit_desc = htmlentities($_POST['desc']);
        $edit_title = htmlentities($_POST['title']);
        $status = $_POST['status'];
        $category = $_POST['category'];
        $query = "UPDATE `blog` 
        SET `title`='$edit_title',`text`='$edit',`description`='$edit_desc',`publish_id`='$status', `category_id`='$category' 
        WHERE `blog_id` = " . $_SESSION['edit'];
        $result = mysqli_query($conn, $query) OR die('Bad query finish');
    }
    $query = "SELECT `blog`.`blog_id`, `blog`.`title`, `blog`.`description`, `category`.`category`,`published_status`.`published_status`, `user`.`username`, `blog`.`views`, `blog`.`date`, `user`.`email` FROM `blog` INNER JOIN `category` ON `category`.`category_id`=`blog`.`category_id` 
    INNER JOIN `published_status` ON `published_status`.`publish_id`=`blog`.`publish_id` 
    INNER JOIN `user` ON `blog`.`author`=`user`.`user_id` 
    WHERE `user`.`email` = " . "'$email'";
    $result = mysqli_query($conn, $query) OR die('bad query');
    
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
                <a class="navbar-brand" href="index.html">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="index.php">Home</a></li>
                        <?php if(isset($_SESSION['username'])) { ?>
                            <?php if($_SESSION['level'] == 1){ ?>
                                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="admin/index.php">Admin</a></li>
                            <?php } ?>
                            <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="manage_blogs.php">Manage Blogs</a></li>
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
                            <h1>Editing Blogs</h1>
                            <span class="subheading">You can edit you blogs here!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <form action = "manage_blogs.php" method = "post">
        <div class="card-body">
        <table class = 'table' id="datatablesSimple">                                      
            <thead>
                <tr>
                    <th scope="col">ID</th>
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
                                <input type="submit" name="edit" value = "Edit Blogs"> <br>
                        <?php } ?>
                </form>
            </div>
        </div>  
        </form>
        </div>
    </body>
    <div class="sb-sidenav-footer">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
</html>