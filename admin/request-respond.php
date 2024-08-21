<?php include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Respond'])) {
    // Initialize arrays to store materials, quantities, and prices
    $materials = $_POST['material'];
    $quantities = $_POST['quantity'];
    $prices = []; // An array to store the prices

    // Initialize an empty array to store material details
    $materialDetails = [];

    // Loop through the arrays and process each material and quantity
    for ($i = 0; $i < count($materials); $i++) {
        $materialId = $materials[$i];
        $quantity = $quantities[$i];

        // Query the database to get the name and price of the material by its ID
        $query = "SELECT material_name, price FROM Materials WHERE material_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'i', $materialId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $materialName = $row['material_name'];
            $price = $row['price'];

            // Calculate the total cost for this material
            $totalCost = $quantity * $price;

            // Store the material details in the materialDetails array
            $materialDetails[] = [
                'name' => $materialName,
                'quantity' => $quantity,
                'price' => $price,
                'totalCost' => $totalCost,
            ];
        }
    }

    // Create a string to combine all materials and quantities
    $materialString = "";
    foreach ($materialDetails as $detail) {
        $materialString .= "{$detail['name']} (Quantity: {$detail['quantity']}), ";
    }

    // Remove the trailing comma and space
    $materialString = rtrim($materialString, ', ');

    // Create another string for each item, its (price * quantity), and the total
    $itemString = "";
    $totalCost = 0;
    foreach ($materialDetails as $detail) {
        $itemTotal = $detail['totalCost'];
        $itemString .= "{$detail['name']} ({$detail['price']} * {$detail['quantity']} = $itemTotal), ";
        $totalCost += $itemTotal;
    }

    // Remove the trailing comma and space
    $itemString = rtrim($itemString, ', ');

    // Append the total cost to the itemString
    $itemString .= " (Total Cost: $totalCost)";

    // Update the database with the analysis and market analysis
    $requestId = $_GET['request_id'];

    // SQL statement to update the database
    $query = "UPDATE `job_requests` SET `analysis` = ?, `market_analysis` = ? WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'ssi', $materialString, $itemString, $requestId);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $_SESSION['success'] = "Successful";
    } else {
        $_SESSION['error'] = "Failed to update the request.";
    }
}

// Rest of your code...

// Your code to fetch the request details (similar to your previous script)
$query = "SELECT * FROM job_requests JOIN users USING(user_id) WHERE id = '$_GET[request_id]' ";
$result = mysqli_query($connection, $query);

$request = mysqli_fetch_assoc($result);
$count = 1;
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Response</h4>
            <p class="card-description">Respond to Request</p>

            <form action="" method="post">
              <div class="form-group">
                <label for="">Username</label>
                <input type="text" class="form-control" value="<?=$request['username']?>" disabled>
              </div>
              <div class="form-group">
                <label for="">Description</label>
                <textarea type="text" class="form-control" disabled><?=trim($request['description'])?></textarea>
              </div>

              <div id="materials-container">
                <!-- Material fields and quantities will be added here -->
              </div>

              <button class="btn-primary btn" id="add-material">Add Material</button>
              <button class="btn-primary btn" name="Respond" type="submit">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    // Track selected materials to prevent duplicates
    const selectedMaterials = new Set();

    // Function to fetch materials from the server
    function fetchMaterials() {
      $.ajax({
        url: 'get-materials.php', // Replace with the actual URL to fetch materials
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            const availableMaterials = response.materials;

            // Create Material dropdown
            const materialDropdown = document.createElement('select');
            materialDropdown.className = 'form-control';
            materialDropdown.name = 'material[]'; // Use an array to submit multiple materials
            materialDropdown.required = true;

            // Create Quantity input
            const quantityInput = document.createElement('input');
            quantityInput.type = 'number';
            quantityInput.className = 'form-control';
            quantityInput.name = 'quantity[]'; // Use an array to submit multiple quantities
            quantityInput.placeholder = 'Quantity';
            quantityInput.required = true;

            // Add available materials as options
            availableMaterials.forEach((material) => {
              if (!selectedMaterials.has(material.name)) {
                const option = new Option(material.name, material.id);
                materialDropdown.append(option);
              }
            });

            // Add the Material and Quantity fields to the container
            const materialsContainer = document.getElementById('materials-container');
            materialsContainer.appendChild(materialDropdown);
            materialsContainer.appendChild(quantityInput);

            // Track selected material to prevent duplicates
            materialDropdown.onchange = function() {
              selectedMaterials.add(materialDropdown.value);
            };
          } else {
            console.error('Failed to fetch materials:', response.error);
          }
        },
        error: function(xhr, status, error) {
          console.error('AJAX error:', error);
        }
      });
    }

    // Initial fetch of materials when the page loads
    fetchMaterials();

    // Add Material button click event
    $('#add-material').on('click', function(e) {
      e.preventDefault();
      fetchMaterials(); // Fetch materials each time the button is clicked
    });
  });
</script>
