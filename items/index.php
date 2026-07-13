<?php
require_once '../includes/config.php';
$db = getDB();

$items = $db->query("
    SELECT items.id, items.item_code, items.item_name, items.quantity, items.unit_price,
           item_categories.name AS category_name,
           item_sub_categories.name AS sub_category_name
    FROM items
    JOIN item_categories ON item_categories.id = items.category_id
    JOIN item_sub_categories ON item_sub_categories.id = items.sub_category_id
    ORDER BY items.id DESC
")->fetchAll();

require_once '../includes/header.php';
?>

<h1 class="text-center">Item List</h1>
<a href="add_item.php" class="btn btn-primary mb-3">+ Add New Item</a>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Item Code</th><th>Item Name</th><th>Category</th>
            <th>Sub Category</th><th>Quantity</th><th>Unit Price</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $i): ?>
        <tr>
            <td><?= $i['item_code'] ?></td>
            <td><?= $i['item_name'] ?></td>
            <td><?= $i['category_name'] ?></td>
            <td><?= $i['sub_category_name'] ?></td>
            <td><?= $i['quantity'] ?></td>
            <td><?= $i['unit_price'] ?></td>
            <td>
                <a href="edit_item.php?id=<?= $i['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="delete_item.php?id=<?= $i['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>