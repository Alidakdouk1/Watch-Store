<?php
// Required headers
include_once '../config/database.php';

// Set CORS headers
setCorsHeaders();

// Initialize database
$database = new Database();
$db = $database->getConnection();

if($db === null) {
    sendError("Database connection failed", 500);
}

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->email) &&
    !empty($data->address) &&
    !empty($data->phone) &&
    !empty($data->watch)
) {
    try {
        // Create orders table if it doesn't exist
        $create_table_query = "CREATE TABLE IF NOT EXISTS orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            customer_name VARCHAR(255) NOT NULL,
            customer_email VARCHAR(255) NOT NULL,
            customer_address TEXT NOT NULL,
            customer_phone VARCHAR(50) NOT NULL,
            watch_id INT,
            watch_name VARCHAR(255) NOT NULL,
            watch_price DECIMAL(10,2) NOT NULL,
            order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            status ENUM('pending', 'processing', 'shipped', 'delivered') DEFAULT 'pending'
        )";
        
        $db->exec($create_table_query);

        // Insert order
        $query = "INSERT INTO orders 
                  SET customer_name=:name, customer_email=:email, customer_address=:address, 
                      customer_phone=:phone, watch_id=:watch_id, watch_name=:watch_name, 
                      watch_price=:watch_price";

        $stmt = $db->prepare($query);

        // Sanitize
        $name = htmlspecialchars(strip_tags($data->name));
        $email = htmlspecialchars(strip_tags($data->email));
        $address = htmlspecialchars(strip_tags($data->address));
        $phone = htmlspecialchars(strip_tags($data->phone));
        $watch_id = isset($data->watch->id) ? $data->watch->id : null;
        $watch_name = htmlspecialchars(strip_tags($data->watch->name));
        $watch_price = $data->watch->price;

        // Validate email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            sendError("Invalid email address");
        }

        // Bind values
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":watch_id", $watch_id);
        $stmt->bindParam(":watch_name", $watch_name);
        $stmt->bindParam(":watch_price", $watch_price);

        if($stmt->execute()) {
            $order_id = $db->lastInsertId();
            
            $response = array(
                "success" => true,
                "order_id" => $order_id,
                "message" => "Order placed successfully! We will contact you soon.",
                "customer_name" => $name,
                "watch_name" => $watch_name,
                "total_price" => floatval($watch_price)
            );
            
            sendResponse($response, 201);
        } else {
            sendError("Unable to place order", 503);
        }
    } catch(Exception $e) {
        sendError("Unable to place order: " . $e->getMessage(), 500);
    }
} else {
    sendError("Unable to place order. Required data is missing.");
}
?>

