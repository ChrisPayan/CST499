<?php
    require_once 'database.php';

    $db = new Database();
    session_start();

    // Retrieve form data   
    $userID = $_SESSION['userId'];
    $courseName = $_POST['courseName'];
    $semester = $_POST['semester'];
    $enrollmentDate = date(DATE_ATOM);


    $sql = "SELECT courseID FROM courses WHERE courseName = ? AND semester = ?";
    $results = $db->select($sql, "ss", $courseName, $semester);
    if($results){
        $courseID = $results[0]['courseID'];
        echo "we got courseID.".$results[0]['courseID']."";
    } else {
        echo "Error getting courseID.";
    }


     // Validate input 
    if (empty($courseName) || empty($semester)) {
        echo "Please fill in all required fields.";
    } else {

        $sql = "SELECT availableSlots FROM courses WHERE courseID = ?";
        $results = $db->select($sql, "s", $courseID);
        $available = $results[0]['availableSlots'];

        if($available > 0){
            $sql = "UPDATE Courses SET availableSlots = availableSlots - 1 WHERE courseID = ?";
            $db->update($sql, "s", $courseID);

            $sql2 = "INSERT INTO Enrollments (userID, courseID, enrollmentDate) VALUES (?, ?, ?)";

            if($db->insert($sql2, "sss", $userID, $courseID, $enrollmentDate )){  
                echo "Registration successful!";
                header("Location: index.php");
            } else {
                echo "Error Registration uncuessful!";
            }
        } else {
            echo "Course is full Throw back error";
            //add to waiting list
            $sql = "INSERT INTO waitingLists (userID, courseID, joinDate) VALUES (?, ?, ?)";
            $db->insert($sql,"sss", $userID, $courseID, $enrollmentDate);
            header("Location: myClasses.php");

        }

    }
    $conn->close();
?>