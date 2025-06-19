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

try {
    // Get watches
    $stmt = $watch->read();
    $num = $stmt->rowCount();

    if($num > 0) {
        $watches_arr = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $watch_item = array(
                "id" => $id,
                "name" => $name,
                "brand" => $brand,
                "price" => floatval($price),
                "image" => $image,
                "description" => $description,
                "created_at" => $created_at,
                "updated_at" => $updated_at
            );

            array_push($watches_arr, $watch_item);
        }

        sendResponse($watches_arr);
    } else {
        sendResponse(array());
    }
} catch(Exception $e) {
    sendError("Unable to read watches: " . $e->getMessage(), 500);
}
?>

