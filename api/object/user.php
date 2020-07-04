<?php

    class User {
        // Database connection and table name
        private $conn;
        private $table_name = "user";

        // Object properties
        public $id;
        public $username;
        public $email;
        public $password;

        // Constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // Function to read the users
        function read() {
            // select all query
            $query = "SELECT * FROM " . $this->table_name;

            // Prepare the query statement
            $stmt = $this->conn->prepare($query);

            // Execute the query
            $stmt->execute();

            return $stmt;
        }

        // Function to sign the user up
        public function signup() {
            // Query to insert the record
            $query = "INSERT INTO " .$this->table_name. " 
            SET username=:username, email=:email, password=:password";
            
            // Prepare the query
            $stmt = $this->conn->prepare($query);

            // Sanitize
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));

            // Bind values
            $stmt->bindParam("username", $this->username);
            $stmt->bindParam("email", $this->email);
            $stmt->bindParam("password", $this->password);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            return false;
        }
    }