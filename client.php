<?php
require 'db_connection.php'; // Make sure this file sets up your database connection

// Function to fetch client data
function fetchClientData($conn) {
    $query = "SELECT * FROM clients";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $clients = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $clients;
    } else {
        return ['error' => 'Failed to fetch client data: ' . mysqli_error($conn)];
    }
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $client_name = htmlspecialchars(trim($_POST['client_name']));
    $client_email = filter_var(trim($_POST['client_email']), FILTER_SANITIZE_EMAIL);
    $client_phone = htmlspecialchars(trim($_POST['client_phone']));
    $client_address = htmlspecialchars(trim($_POST['client_address']));

    if (!empty($client_name) && !empty($client_email) && !empty($client_phone) && !empty($client_address)) {
        // Prepare the SQL query
        $query = "INSERT INTO clients (cname, cemail, cphone, caddress) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'ssss', $client_name, $client_email, $client_phone, $client_address);
            if (mysqli_stmt_execute($stmt)) {
                $message = 'Client added successfully';
            } else {
                $message = 'Failed to add client: ' . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            $message = 'Failed to prepare the SQL query: ' . mysqli_error($conn);
        }
    } else {
        $message = 'Please fill in all fields';
    }
}

// Fetch existing client data
$clients = fetchClientData($conn);

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Client</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Billing System</h2>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="add-client.php">Add Client</a></li>
                    <li><a href="service.php">Add Service</a></li>
                    <li><a href="project.html">Add Project</a></li>
                    <li><a href="view-invoices.html">View Invoices</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Client Form Section -->
            <div class="form-section">
                <h2>Add Client</h2>
                <form id="client-form" method="POST">
                    <label for="client-name">Name:</label>
                    <input type="text" id="client-name" name="client_name" required placeholder="Client Name">

                    <label for="client-email">Email:</label>
                    <input type="email" id="client-email" name="client_email" placeholder="Client Email">

                    <label for="client-phone">Phone:</label>
                    <input type="text" id="client-phone" name="client_phone" placeholder="Client Phone">

                    <label for="client-address">Address:</label>
                    <textarea id="client-address" name="client_address" placeholder="Client Address"></textarea>

                    <button type="submit">Add Client</button>
                </form>

                <?php if (!empty($message)): ?>
                    <p><?php echo $message; ?></p>
                <?php endif; ?>
            </div>

            <!-- Client Data Retrieval Section -->
            <div class="data-section">
                <h2>Existing Clients</h2>
                <table id="client-table">
                    <thead>
                        <tr>
                            <th>Client ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($clients) && !isset($clients['error'])): ?>
                            <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td><?php echo $client['id']; ?></td>
                                    <td><?php echo $client['cname']; ?></td>
                                    <td><?php echo $client['cemail']; ?></td>
                                    <td><?php echo $client['cphone']; ?></td>
                                    <td><?php echo $client['caddress']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5"><?php echo $clients['error']; ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
