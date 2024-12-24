<?php
require 'db_connection.php'; // Make sure this file sets up your database connection

// Function to fetch service data
function fetchServiceData($conn) {
    $query = "SELECT * FROM services";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $services = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $services;
    } else {
        return ['error' => 'Failed to fetch service data: ' . mysqli_error($conn)];
    }
}



if($_SERVER['REQUEST_METHOD']==='POST'){
    $service = $_POST['service_name'];
    $description = $_POST['service_description'];
    $price = $_POST['service_price'];


    if(!empty($service) && !empty($description) && !empty($price)){
        $query="INSERT INTO services (name , description , rate) VALUES(?,?,?)";
        // $stmt = mysql_prepare($conn,$query);
        $stmt = mysqli_prepare($conn, $query);
    }

    if($stmt){
        mysqli_stmt_bind_param($stmt,'ssi', $service,$description,$price);
        if(mysqli_stmt_execute($stmt)){
            $message = "service added successfully";
        }
        else{
            $message = "failed to add service"  . mysql_stmt_error($stmt);
        }
    }
    else{
        $message = "please fill all the feild";
    }
    
}

$services = fetchServiceData($conn);

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Billing System</h2>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="client.php">Add Client</a></li>
                    <li><a href="service.php">Add Service</a></li>
                    <li><a href="project.php">Add Project</a></li>
                    <li><a href="view-invoices.html">View Invoices</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Service Form Section -->
            <div class="form-section">
                <h2>Add Service</h2>
                <form id="service-form" method="POST">
                    <label for="service-name">Name:</label>
                    <input type="text" id="service-name" name="service_name" required placeholder="Service Name">

                    <label for="service-description">Description:</label>
                    <textarea id="service-description" name="service_description" placeholder="Service Description"></textarea>

                    <label for="service-price">Price:</label>
                    <input type="number" id="service-price" name="service_price" step="0.01" placeholder="Service Price" required>

                    <button type="submit">Add Service</button>
                </form>
                <?php if (!empty($message)): ?>
                    <p><?php echo $message; ?></p>
                <?php endif; ?>
            </div>

            <!-- Service Data Retrieval Section -->
            <div class="data-section">
                <h2>Existing Services</h2>
                <table id="service-table">
                    <thead>
                        <tr>
                            <th>Service ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($services) && !isset($services['error'])): ?>
                            <?php foreach ($services as $service): ?>
                                <tr>
                                    <td><?php echo $service['id']; ?></td>
                                    <td><?php echo $service['name']; ?></td>
                                    <td><?php echo $service['description']; ?></td>
                                    <td><?php echo $service['rate']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">no data found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
