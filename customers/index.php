<?php
require_once '../includes/config.php';
$db = getDB();

$customers = $db->query("
    SELECT customers.id, customers.title, customers.first_name, customers.last_name,
           customers.contact_number, districts.name AS district_name
    FROM customers
    JOIN districts ON districts.id = customers.district_id
    ORDER BY customers.id DESC
")->fetchAll();

require_once '../includes/header.php';
?>

<h1 class="text-center">Customer List</h1>
<a href="add_customer.php" class="btn btn-primary mb-3">+ Add New Customer</a>

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
        <?php foreach ($customers as $c): ?>
        <tr>
            <td><?= $c['title'] ?></td>
            <td><?= $c['first_name'] ?></td>
            <td><?= $c['last_name'] ?></td>
            <td><?= $c['contact_number'] ?></td>
            <td><?= $c['district_name'] ?></td>
            <td>
                <a href="edit_customer.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="delete_customer.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this customer?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>