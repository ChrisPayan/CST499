<?php
    
    // Database connection details
    $servername = "xxxx";
    $username = "xxxx";
    $password = "xxxx";
    $dbname = "xxxx"; 

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection

    if ($conn->connect_error) {
        echo'Connection Failed';
        die("Connection failed: " . $conn->connect_error);
    }

    // Function to hash the password securely
    function hashPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }
    // Function to check if a userID already exists.
    function userIDExists($conn, $userID) {
        $stmt = $conn->prepare("SELECT userID FROM Users WHERE userID = ?");
        $stmt->bind_param("s", $userID);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    // Retrieve form data   
    $userID = $_POST['userID'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $additonalInfo = $_POST['additionalInfo'];

     // Validate input (add more validation as needed)
     if (empty($userID) || empty($password) || empty($name) || empty($email)) {
        echo "Please fill in all required fields.";
    } else {

        if (userIDExists($conn, $userID)) {
             echo "userID already exists. Please choose a different userID.";
        } else {
            // Hash the password
            $hashedPassword = hashPassword($password);

            // Prepare and execute the SQL query for the Users table.
            $stmt = $conn->prepare("INSERT INTO Users (userID, password, name, phone, email) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $userID, $hashedPassword, $name, $phone, $email);

            if ($stmt->execute()) {
                $stmt->close();
                //Prepare and execute the SQL query for the profiles table.
                $stmt2 = $conn->prepare("INSERT INTO Profiles (userID, address, additionalInfo) VALUES (?, ?, ?)");
                $stmt2->bind_param("sss", $userID, $address, $additionalInfo);

                if ($stmt2->execute()){
                    echo "New user registered successfully!";
                    $stmt2->close();
                    header("Location: login.php");
                    $conn->close();
                    exit();
                } else {
                    echo "Error: " . $stmt2->error;
                    $stmt2->close();
                    //If a profile fails to be created, delete the user.
                    $stmt3 = $conn->prepare("DELETE FROM Users WHERE userID = ?");
                    $stmt3->bind_param("s", $userID);
                    $stmt3->execute();
                    $stmt3->close();
                }

            } else {
                echo "Error: " . $stmt->error;
                $stmt->close();
            }
        }
    }
    $conn->close();
?>