<?php
error_reporting(E_ALL);
ini_set('display_errors', 0); // Turn off direct error output for AJAX

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Unknown error'];

try {
    // Database connection variables
    $host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "shopusers_db";

    // Establish connection
    $conn = new mysqli($host, $db_user, $db_password, $db_name);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Collect data from the form
        $name = $_POST['addProductName'] ?? '';
        $description = $_POST['addDescription'] ?? '';
        $price = $_POST['addProductPrice'] ?? 0;
        $category = $_POST['role'] ?? '';
        $seller_id = $_POST['seller_id'] ?? null;
        $stock_quantity = $_POST['stock_quantity'] ?? 0;
        $status = 'active';
        $created_at = date('Y-m-d H:i:s');

        // Handle image upload
        $image_url = '';
        if (isset($_FILES['productImages']) && $_FILES['productImages']['error'][0] == 0) {
            // $target_dir = "uploads/";
            $baseDir = $_SERVER['Document_ROOT'];
            $uploadDir = $baseDir . '/uploads';
            if (!is_dir($target_dir)) {
                // mkdir($target_dir, 0777, true);
                mkdir($uploadDir, 0777, true);
            }
            $file_name = basename($_FILES["productImages"]["name"][0]);
            $uniqueFileName = uniqid() . "_" . $file_name;
            $targetFile = $uploadDir . $uniqueFileName;
            if (move_uploaded_file($_FILES["productImages"]["tmp_name"][0], $targetFile)) {
                $image_url = '/LEESELLS/img/uploads/' . $uniqueFileName;
            }
            // $target_file = $target_dir . uniqid() . "_" . $file_name;
            // if (move_uploaded_file($_FILES["productImages"]["tmp_name"][0], $target_file)) {
            //     $image_url = $target_file;
            // }
        }

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO products (seller_id, name, description, price, stock_quantity, image_url, status, created_at, category) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("issdissss", $seller_id, $name, $description, $price, $stock_quantity, $image_url, $status, $created_at, $category);

        if ($stmt->execute()) {
            // Get the inserted product id
            $product_id = $stmt->insert_id;

            // Return the inserted product data (optional)
            $response = [
                'success' => true,
                'message' => 'Product added successfully!',
                'product' => [
                    'product_id' => $product_id,
                    'seller_id' => $seller_id,
                    'name' => $name,
                    'description' => $description,
                    'price' => $price,
                    'stock_quantity' => $stock_quantity,
                    'image_url' => $image_url,
                    'status' => $status,
                    'created_at' => $created_at,
                    'category' => $category
                ]
            ];
        } else {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    } else {
        throw new Exception("Invalid request method");
    }

    $conn->close();
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;
