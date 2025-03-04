<?php
    require_once 'database.php';

    $db = new Database();
    session_start();
    // 0. Get data from line item
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["courseID"])) {
          $courseID = $_POST["courseID"];
        }
    } 
    $userID = $_SESSION['userId'];


    // 1. Remove user from Enrollments table
    $sql = "DELETE FROM Enrollments WHERE userID = ? AND courseID = ?";
    if ($db->delete($sql, "ss", $userID, $courseID)) { 

        // 2. Update course availability
        $sql = "UPDATE Courses SET availableSlots = availableSlots + 1 WHERE courseID = ?";
        $db->update($sql, "s", $courseID); 

        // 3. Check WaitingList for the course
        $sql = "SELECT userID FROM WaitingLists WHERE courseID = ? ORDER BY joinDate ASC LIMIT 1";
        $result = $db->select($sql, "s", $courseID);

        if ($result) {
            $nextUserID = $result[0]['userID'];

            // 4. Enroll the next user from the waiting list
            $sql = "INSERT INTO Enrollments (userID, courseID) VALUES (?, ?)";
            if ($db->insert($sql, "ss", $nextUserID, $courseID)) {
                // 5. Remove the user from the waiting list
                $sql = "DELETE FROM WaitingLists WHERE userID = ? AND courseID = ?";
                $db->delete($sql, "ss", $nextUserID, $courseID);

                // 5.5 Update course availability
                $sql = "UPDATE Courses SET availableSlots = availableSlots - 1 WHERE courseID = ?";
                $db->update($sql, "s", $courseID); 

                // 6.Notify the user (e.g., via email) that they have been enrolled from the waiting list.
                $sql2 = "SELECT email FROM users WHERE userID = ?";
                $result = $db->select($sql2, "s", $userID);
                if($result) {
                    $studen_email = $result[0]['email'];
                    $subject = "You've been added to a Class form your Waiting List";
                    $message = "This was send using PHP";
                    $headers = 'From: sender@example.com' . "\r\n" .
                                'Reply-To: sender@example.com' . "\r\n" .
                                'X-Mailer: PHP/' . phpversion();
                    mail($studen_email, $subject, $message, $headers);

                } else {
                    echo "Error sending an email to student in Waiting List";
                }
            } else {
                echo "Error enrolling user from waiting list.";
            }
        } else {
            echo "You have successfully canceled your enrollment.";
        }
    } else {
        echo "Error canceling enrollment.";
    }
    header("Location: myClasses.php");
?>
