<?php

    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // Include database and object files
    include_once '../config/database.php';
    include_once '../object/user.php';

    // Instantiate database and user object
    $database = new Database();
    $db = $database->getConnection();

    // Initialize object
    $user = new User($db);

    // Query users
    $stmt = $user->read();
    $num = $stmt->rowCount();

    // Check if there are more than 0 users found
    if ($num > 0) {

        // Users array
        $users_arr = array();
        $users_arr["users"] = array();

        // Retrieve table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Extract row
            extract($row);

            $users_user = array(
                "id" => $id,
                "username" => $username,
                "email" => $email,
                "password" => $password
            );

            array_push($users_arr["users"], $users_user);
        }

        // Set response code to 200 (OK)
        http_response_code(200);

        // Show users in JSON format
        echo json_encode($users_user);
    } else {
        // Set response code to 404 (Not found)
        http_response_code(404);

        // Tell the user no users were found
        echo json_encode(array("message" => "No users were found."));
    }