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
            // Check if username or email already exists
            if ($this->doesAlreadyExist()) {
                return false;
            }

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

        // Function to check whether the username or email already exists
        public function doesAlreadyExist() {
            // Query to check the database
            $query = "SELECT username, email FROM " .$this->table_name. " 
            WHERE username='".$this->username."' OR email='".$this->email."'";

            // Prepare the query
            $stmt = $this->conn->prepare($query);

            // Execute the query
            $stmt->execute();

            // Check if there is a row with the same email or username
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        // Function to log an existing user in
        public function login() {
            // Query to compare username and password
            $query = "SELECT username, password FROM " .$this->table_name. " 
            WHERE username=:username AND password=:password";

            // Prepare the query
            $stmt = $this->conn->prepare($query);

            // Sanitize
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->password = htmlspecialchars(strip_tags($this->password));

            // Bind values
            $stmt->bindParam("username", $this->username);
            $stmt->bindParam("password", $this->password);

            // Execute query and return the statement
            $stmt->execute();
            return $stmt;
        }
    }