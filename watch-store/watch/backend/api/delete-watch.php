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

// Get watch ID from URL parameter
$watch_id = isset($_GET['id']) ? $_GET['id'] : '';

// Make sure ID is not empty
if(!empty($watch_id) && is_numeric($watch_id)) {
    // Set watch ID
    $watch->id = $watch_id;

    try {
        // Delete the watch
        if($watch->delete()) {
            sendResponse(array("message" => "Watch was deleted successfully."));
        } else {
            sendError("Unable to delete watch", 503);
        }
    } catch(Exception $e) {
        sendError("Unable to delete watch: " . $e->getMessage(), 500);
    }
} else {
    sendError("Unable to delete watch. ID is missing or invalid.");
}
?>

