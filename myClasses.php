<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <link rel="stylesheet" href= "https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>

    <title>CST499 Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Welcome to My Classes</h1>
        <?php
            // Database connection details
            require_once 'database.php';

            $db = new Database();

            $userID = $_SESSION['userId'];
            $sql = "SELECT courseID FROM Enrollments WHERE userID = ?";
            $result = $db->select($sql, "s", $userID);
            $courseIDs = array();
            if ($result) {
                $i = 0;
                foreach ($result as $row) {
                    $courseIDs[$i]= $row['courseID'];
                    
                    $i = $i + 1;
                }
            }
            // For EACH course 
            echo "<h3> Classes I am currently Enrolled in: </h3>";
            echo "<ul>";
            foreach($courseIDs as $courseID){
                $sql = "SELECT courseName, semester FROM Courses WHERE courseID = ?";
                $courseDetails = $db->select($sql, "s", $courseID); 
        
                if($courseDetails) {
                    $courseName = $courseDetails[0]['courseName'];
                    $semester = $courseDetails[0]['semester'];
                    echo "<form action='dropClass.php' method='post'><button type='submit' value=" . $courseID . 
                         " name='courseID' for='courseID'>CANCEL</button>  " . $courseName . " - " . $semester . "</form>";
                } else {
                    echo "<li>Course not found (ID: " . $courseID . ")</li>";
                }
            }
            echo "</ul>";

            //For waitingLists
            $sql = "SELECT courseID FROM waitingLists WHERE userID = ?";
            $result = $db->select($sql, "s", $userID);
            $courseIDs = array();
            if ($result) {
                $i = 0;
                foreach ($result as $row) {
                    $courseIDs[$i]= $row['courseID'];
                    
                    $i = $i + 1;
                }
            }
            echo "<h3> Classes I am currently on the Waiting List for: </h3>";
            echo "<ul>";
            foreach($courseIDs as $courseID){
                $sql = "SELECT courseName, semester FROM Courses WHERE courseID = ?";
                $courseDetails = $db->select($sql, "s", $courseID); 
        
                if($courseDetails) {
                    $courseName = $courseDetails[0]['courseName'];
                    $semester = $courseDetails[0]['semester'];
                    echo "<p>  " . $courseName . " - " . $semester . "</p>";
                } else {
                    echo "<li>Course not found (ID: " . $courseID . ")</li>";
                }
            }
            echo "</ul>";
        ?>
    </main>

</body>
</html>