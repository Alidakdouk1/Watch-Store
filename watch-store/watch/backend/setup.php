<?php
// Database setup script
include_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

if($db === null) {
    die("Database connection failed");
}

try {
    // Create watches table
    $create_watches_table = "CREATE TABLE IF NOT EXISTS watches (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        brand VARCHAR(100),
        price DECIMAL(10,2) NOT NULL,
        image VARCHAR(500) NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    $db->exec($create_watches_table);
    echo "Watches table created successfully.\n";

    // Create orders table
    $create_orders_table = "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        customer_name VARCHAR(255) NOT NULL,
        customer_email VARCHAR(255) NOT NULL,
        customer_address TEXT NOT NULL,
        customer_phone VARCHAR(50) NOT NULL,
        watch_id INT,
        watch_name VARCHAR(255) NOT NULL,
        watch_price DECIMAL(10,2) NOT NULL,
        order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        status ENUM('pending', 'processing', 'shipped', 'delivered') DEFAULT 'pending',
        FOREIGN KEY (watch_id) REFERENCES watches(id) ON DELETE SET NULL
    )";

    $db->exec($create_orders_table);
    echo "Orders table created successfully.\n";

    // Insert sample data
    $sample_watches = [
        [
            'name' => 'Rolex Submariner',
            'brand' => 'Rolex',
            'price' => 8500.00,
            'image' => 'assets/images/rolex-submariner.jpg',
            'description' => 'Luxury diving watch with automatic movement'
        ],
        [
            'name' => 'Omega Speedmaster',
            'brand' => 'Omega',
            'price' => 5200.00,
            'image' => 'assets/images/omega-speedmaster.jpg',
            'description' => 'Professional chronograph watch'
        ],
        [
            'name' => 'TAG Heuer Formula 1',
            'brand' => 'TAG Heuer',
            'price' => 1200.00,
            'image' => 'assets/images/tag-heuer-formula1.jpg',
            'description' => 'Sports watch with precision timing'
        ],
        [
            'name' => 'Seiko Prospex',
            'brand' => 'Seiko',
            'price' => 350.00,
            'image' => 'assets/images/seiko-prospex.jpg',
            'description' => 'Reliable diving watch for professionals'
        ]
    ];

    $insert_query = "INSERT INTO watches (name, brand, price, image, description) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($insert_query);

    foreach($sample_watches as $watch) {
        $stmt->execute([
            $watch['name'],
            $watch['brand'],
            $watch['price'],
            $watch['image'],
            $watch['description']
        ]);
    }

    echo "Sample data inserted successfully.\n";
    echo "Database setup completed!\n";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>

