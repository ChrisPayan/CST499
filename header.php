<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href= "https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="jumbotron">
        <div class="container text-center">
            <h1>Student Portal</h1>

        </div>
    </div>
<nav>
    <div class="container-fluid">
        <ul class="nav nav-tabs">
            <?php?>

            <?php
                    ini_set('session.use_only_cookies','1');
                    session_start();

                        if(isset($_SESSION['userId']))
                        {
                            echo '<li role="presentation"><a href="index.php">Home</a><li>';
                            echo '<li role="presentation"><a href="myClasses.php">My Classes</a><li>';
                            echo '<li role="presentation"><a href="enrollment.php">Enrollment</a></li>';
                            echo '<li role="presentation"><a href="logout.php">Logout</a></li>';

                        } else {

                            echo '<li role="presentation"><a href="index.php">Home</a><li>';
                            echo '<li role="presentation"><a href="login.php">Login</a></li>';
                            echo '<li role="presentation"><a href="registration.php">Registration</a></li>';

                        }
                    
            ?>
        </ul>
</div>
</nav>
</body>
</html>