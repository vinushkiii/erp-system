<?php
// Include database config
require_once '../includes/config.php';

// Connect to database
$db = getDB();

// Fetch all customers joined with their district names 
$customers = $db->query("
    SELECT customers.id, customers.title, customers.first_name, customers.last_name,
           customers.contact_number, districts.name AS district_name
    FROM customers
    JOIN districts ON districts.id = customers.district_id
    ORDER BY customers.id DESC
")->fetchAll();

// Include layout header
require_once '../includes/header.php';
?>

<!-- Page title -->
<h1 class="text-center">Customer List</h1>
<!-- Link to the add customer page -->
<a href="add_customer.php" class="btn btn-primary mb-3">+ Add New Customer</a>

<!-- Data table to display the customer list -->
<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Title</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Contact Number</th>
            <th>District</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php // Loop through each customer record fetched from the database ?>
        <?php foreach ($customers as $c): ?>
        <tr>
            <!-- Output customer data in table rows -->
            <td><?= $c['title'] ?></td>
            <td><?= $c['first_name'] ?></td>
            <td><?= $c['last_name'] ?></td>
            <td><?= $c['contact_number'] ?></td>
            <td><?= $c['district_name'] ?></td>
            <td>
                <!-- Action buttons with the specific customer ID passed via URL -->
                <a href="edit_customer.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="delete_customer.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this customer?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php // Include layout footer ?>
<?php require_once '../includes/footer.php'; ?>