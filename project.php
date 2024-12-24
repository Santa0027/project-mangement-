<?php
require "db_connection.php";

function fetchServiceData($conn) {
    $query = "SELECT * FROM services";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $project = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $project;
    } else {
        return ['error' => 'Failed to fetch service data: ' . mysqli_error($conn)];
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Add a new project
    $name = $_POST["project_name"];
    $description = $_POST["project_description"];
    $client = $_POST["project_client"];
    $budget = $_POST["project_budget"];

    $stmt = $conn->prepare("INSERT INTO projects (name, description, client, budget) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssd", $name, $description, $client, $budget);

    if ($stmt->execute()) {
        $message = "Project added successfully!";
    } else {
        $message = "Failed to add project.";
    }

    $stmt->close();
} else {
    // Fetch all projects
    $result = $conn->query("SELECT * FROM projects");

    if ($result->num_rows > 0) {
        $projects = $result->fetch_all(MYSQLI_ASSOC);
        $message = $projects;
    } else {
        $message = "No projects found.";
    }
}

$conn->close();

$projects = fetchServiceData($conn);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
    <link rel="stylesheet" href="style.css">
    <script src="project.js" defer></script>
</head>
<body>
    <div class="container">
              <!-- Sidebar -->
              <aside class="sidebar">
            <h2>Billing System</h2>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="client.php">Add Client</a></li>
                    <li><a href="service.php">Add Service</a></li>
                    <li><a href="project.html">Add Project</a></li>
                    <li><a href="view-invoices.html">View Invoices</a></li>
                </ul>
            </nav>
        </aside>
    
    <!-- Main Content -->
    <main class="main-content">
        <!-- Project Form Section -->
        <div class="form-section">
            <h2>Add Project</h2>
            <form id="project-form" action="project.php" method="POST">
                <label for="project-name">Project Name:</label>
                <input type="text" id="project-name" name="project_name" required placeholder="Project Name">

                <label for="project-description">Description:</label>
                <textarea id="project-description" name="project_description" required placeholder="Project Description"></textarea>

                <label for="project-client">Client:</label>
                <input type="text" id="project-client" name="project_client" required placeholder="Client Name">

                <label for="project-budget">Budget:</label>
                <input type="number" id="project-budget" name="project_budget" required placeholder="Project Budget">

                <button type="submit">Add Project</button>
            </form>

            <p></p>
        </div>

        <!-- Project Data Retrieval Section -->
        <div class="data-section">
            <h2>Existing Projects</h2>
            <table id="project-table">
                <thead>
                    <tr>
                        <th>Project ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Client</th>
                        <th>Budget</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic data will load here -->
                    <?php if (!empty($project) && !isset($projects['error'])): ?>
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
