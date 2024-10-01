<?php 
    session_start();
    require('../conn.php');
    if($_SESSION['level'] != 1){
        header('location: ../index.php');
    } else {
    $user_msg = "Select a user and press the edit button";
    //adding people
    if(ISSET($_POST['finish'])){
        $edit_username = $_POST['username'];
        $edit_email = $_POST['email'];
        $edit_level = $_POST['level'];
        $edit_status = $_POST['status'];
        $edit_fname = $_POST['fname'];
        $edit_lname = $_POST['lname'];
        // $edit_dob = $_POST['dob'];
        $query = "UPDATE `user` 
        SET `username`='$edit_username',`email`='$edit_email',`level`='$edit_level',`status_id`='$edit_status',`fname`='$edit_fname',`lname`='$edit_lname' WHERE `user_id` =" . $_SESSION['edit'];
        $result = mysqli_query($conn, $query) OR die('Bad query');
    } elseif(isset($_POST['edit']) && isset($_POST['users'])) { 
        $query = "SELECT `user_id`, `username`, `password`, `email`, `level`, `status_id`, `fname`, `lname`, `dob` FROM `user`  WHERE `user_id` =" . $_POST['users'];
        $result = mysqli_query($conn, $query) OR die('Bad query');
        $row = mysqli_fetch_array($result);   
        $username = $row[1];
        // $password = [2];
        $email = $row[3];
        $fname = $row[6];
        $lname = $row[7];
        $dob = $row[8];
        $_SESSION['edit'] = $_POST['users']; 
    } elseif(isset($_POST['edit']) && !isset($_POST['users'])) {
        $user_msg = "You must pick a user and press the edit button";
    }
    $query = "SELECT `user`.`user_id`, `user`.`username`, `user`.`password`, `user`.`level`, `user`.`email`,`level`.`level`, `user`.`fname`, `user`.`lname`,`user`.`dob`,`status`.`status` 
    FROM `level` INNER JOIN `user` ON `level`.`level_id` = `user`.`level` 
    INNER JOIN `status` ON `status`.`status_id`=`user`.`status_id`";
    $result = mysqli_query($conn, $query) OR die('Bad query user'); 
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
                        <h1 class="mt-4">Users</h1>
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
                                Users
                            </div>
                            <form action = "users.php" method = "post">
                            <div class="card-body">
                            <table class = 'table' id="datatablesSimple">       
                                    <thead>
                                        <tr>
                                            <th scope="col">Select</th>
                                            <th scope="col">ID</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Level</th>
                                            <th scope="col">Fname</th>
                                            <th scope="col">Lname</th>
                                            <th scope="col">DOB</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                        <?php 
                                            if(isset($user_msg)){
                                                echo $user_msg;
                                            }
                                            while($row = mysqli_fetch_array($result)){    
                                                
                                                echo "<tr><td>" . "<input type = radio name = users value =" . $row['user_id'] . 
                                                "></td>" . "<td>" . $row['user_id'] . 
                                                "</td><td>" . $row['username'] .  
                                                "</td><td>" . $row['email'] . 
                                                "</td><td>" . $row['level'] . 
                                                "</td><td>" . $row['fname'] . 
                                                "</td><td>" . $row['lname'] . 
                                                "</td><td>" . $row['dob'] . 
                                                "</td><td>" . $row['status']. "<td></tr>";
                                            }
                                        ?> 
                                    </tbody> 
                                </table>
                                <?php if(isset($_POST['edit']) && isset($_POST['users'])){  ?>
                                    <head>
                                        Username: 
                                        <input type = 'text' name = 'username' value = <?php echo $username ?>>
                                        <meta charset="utf-8">
                                        <title>Edit User</title>
                                        </head>
                                        <br> Email:
                                        <input type = 'text' name = 'email' value = <?php echo $email; ?>>
                                        <br> First Name
                                        <input type = 'text' name = 'fname' value = <?php echo $fname ?>>
                                        <br> Last Name
                                        <input type = 'text' name = 'lname' value = <?php echo $lname ?>>

                                        <br> <label for ="status">Status</label>
                                            <select name = "status" id ="status" required>
                                                <option value = "">---</option>
                                                <option value = "1"> public </option>
                                                <option value = "2"> removed </option>
                                            </select>
                                        <br> <label for ="status">Level</label>
                                            <select name = "level" id ="level" required>
                                                <option value = "">---</option>
                                                <option value = "2"> User </option>
                                                <option value = "1"> Admin </option>
                                            </select>
                                            <?php
                                            while($row = mysqli_fetch_array($result)){ echo $row;?>
                                                <option value = <?php $row['user_id'] ?>> <?php echo $row['username'] ?></option>
                                            <?php } ?>
                                    <?php } ?>  
                                    <?php if(isset($_POST['edit']) && isset($_POST['users'])){ ?>
                                        <br> <input type="submit" name="finish" value = "finish"> <br>     
                                        <?php } else { ?>
                                            <input type="submit" name="edit" value = "edit">
                                        <?php } ?> 
                                    </form>   
                            </div>
                        </div>                  
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>