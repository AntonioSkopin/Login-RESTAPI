<?php
    // Required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // Get database connection
    include_once "../config/database.php";

    // Instantiate user object
    include_once "../object/user.php";

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    // Get username and password from url
    $user->username = isset($_GET["username"]) ? $_GET["username"] : die();
    $user->password = isset($_GET["password"]) ? $_GET["password"] : die();

    // Try to log the user in
    $stmt = $user->login();

    // Check if user exists
    if ($stmt->rowCount() > 0) {
        // Set response code to 200 (OK)
        http_response_code(200);

        // Get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Extract row
        extract($row);

        $user_arr = array(
            "status" => "Logged in",
            "message" => "Succesfully logged in!",
            "username" => $username
        );
    } else {
        $user_arr = array(
            "status" => "Invalid info.",
            "message" => "Please enter correct login data!"
        );
    }

    // Output message to user
    echo json_encode($user_arr);
