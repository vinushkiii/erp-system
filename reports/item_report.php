<?php
// Include database config
require_once '../includes/config.php';

// Connect to database
$db = getDB();

// Fetch all items with their category and sub-category names 
$items = $db->query("
    SELECT items.item_name,
           item_categories.name AS category_name,
           item_sub_categories.name AS sub_category_name,
           items.quantity
    FROM items
    JOIN item_categories ON item_categories.id = items.category_id
    JOIN item_sub_categories ON item_sub_categories.id = items.sub_category_id
    GROUP BY items.id
    ORDER BY items.item_name
")->fetchAll();

// Include layout header
require_once '../includes/header.php';
?>

<!-- Page title -->
<h1 class="text-center">Item Report</h1>

<!-- Data table to display the item report -->
<table class="table table-striped table-bordered mt-4">
    <thead class="table-dark">
        <tr>
            <th>Item Name</th><th>Item Category</th><th>Item Sub Category</th><th>Item Quantity</th>
        </tr>
    </thead>
    <tbody>
        <?php // Loop through each item record fetched from the database ?>
        <?php foreach ($items as $i): ?>
        <tr>
            <!-- Output item details in table rows -->
            <td><?= $i['item_name'] ?></td>
            <td><?= $i['category_name'] ?></td>
            <td><?= $i['sub_category_name'] ?></td>
            <td><?= $i['quantity'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php // Include layout footer ?>
<?php require_once '../includes/footer.php'; ?>