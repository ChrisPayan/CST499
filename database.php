<?php
class Database {
    private $servername = "xxxx";
    private $username = "xxxx";
    private $password = "xxxx";
    private $dbname = "sxxxx"; 
    private $conn;
    // Constructor
    function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    //Insert method
    function insert($sql, $types, ...$params) {
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $stmt->error;
            $stmt->close();
            return false; 
        }
        $stmt->close();
    }
    //Select method
    function select($sql, $types = "", ...$params) {
        $stmt = $this->conn->prepare($sql);
        if (!empty($types)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;
    }
    //Update method
    function update($sql, $types, ...$params) {
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $stmt->error;
            $stmt->close();
            return false; 
        }
        $stmt->close();
    }
    // Delete method
    function delete($sql, $types, ...$params) {
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $stmt->error;
            $stmt->close();
            return false; 
        }
        $stmt->close();
    }
}
?>