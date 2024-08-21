<?php
// Include your database connection code (e.g., db.php)
include '../includes/functions.php';

// Initialize an array to store materials
$materials = [];

// Query to select materials from your database table
$query = "SELECT * FROM Materials"; // Adjust the table name if needed

// Execute the query
$result = mysqli_query($connection, $query);

if ($result) {
    // Fetch materials and add them to the array
    while ($row = mysqli_fetch_assoc($result)) {
        $materials[] = [
            'id' => $row['material_id'],
            'name' => $row['material_name'],
        ];
    }

    // Close the database connection
    mysqli_close($connection);

    // Prepare the JSON response
    $response = [
        'success' => true,
        'materials' => $materials,
    ];
} else {
    // Handle database query error
    $response = [
        'success' => false,
        'error' => 'Failed to fetch materials.',
    ];
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the JSON response
echo json_encode($response);
?>
