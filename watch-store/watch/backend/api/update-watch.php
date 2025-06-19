<?php
// Required headers
include_once '../config/database.php';
include_once '../config/watch.php';

// Set CORS headers
setCorsHeaders();

// Initialize database and watch object
$database = new Database();
$db = $database->getConnection();

if($db === null) {
    sendError("Database connection failed", 500);
}

$watch = new Watch($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Make sure data is not empty
if(
    !empty($data->id) &&
    !empty($data->name) &&
    !empty($data->price) &&
    !empty($data->image)
) {
    // Set watch property values
    $watch->id = $data->id;
    $watch->name = $data->name;
    $watch->brand = isset($data->brand) ? $data->brand : '';
    $watch->price = $data->price;
    $watch->image = $data->image;
    $watch->description = isset($data->description) ? $data->description : '';

    // Validate price
    if(!is_numeric($watch->price) || $watch->price <= 0) {
        sendError("Price must be a positive number");
    }

    try {
        // Update the watch
        if($watch->update()) {
            $response = array(
                "id" => $watch->id,
                "name" => $watch->name,
                "brand" => $watch->brand,
                "price" => floatval($watch->price),
                "image" => $watch->image,
                "description" => $watch->description,
                "message" => "Watch was updated successfully."
            );
            sendResponse($response);
        } else {
            sendError("Unable to update watch", 503);
        }
    } catch(Exception $e) {
        sendError("Unable to update watch: " . $e->getMessage(), 500);
    }
} else {
    sendError("Unable to update watch. Data is incomplete.");
}
?>

