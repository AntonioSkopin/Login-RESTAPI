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
        public function __constructor($db) {
            $this->conn = $db;
        }

        // Function to read the users
        function read() {
            // select all query
            $query = "SELECT * FROM user";

            // Prepare the query statement
            $stmt = $this->conn->prepare($query);

            // Execute the query
            $stmt->execute();

            return $stmt;
        }
    }