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
    }