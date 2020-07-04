<?php

    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // Get database connection
    include_once '../config/database.php';

    // Instantiate user object
    include_once '../object/user.php';

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    // Get posted data
    $data = json_decode(file_get_contents("php://input"));

    // Make sure data is not empty
    if (
        !empty($data->username) &&
        !empty($data->email) &&
        !empty($data->password)
    ) {
        // Set user property values
        $user->username = $data->username;
        $user->email = $data->email;
        $user->password = $data->password;
        
        // Create the product
        if ($product->signup()) {
            // Set response code to 201 (Created)
            http_response_code(201);

            // Output it to the user
            echo json_encode(array("message" => "User account is created."));
        }
        // If unable to create the product, output it to the user
        else {
            // Set response code to 503 (Unavailable)
            http_response_code(503);

            // Output it to the user
            echo json_encode(array("message" => "Unable to create the account."));
        }
    }
    // Output to the user that the data is incomplete
    else {
        // Set response code to 400 (Bad request)
        http_response_code(400);

        // Output it to the user
        echo json_encode(array("message" => "Unable to create an account. Data is incomplete."));
    }