<?php
// Include database config
require_once '../includes/config.php';

// Connect to database
$db = getDB();

// Array to hold validation errors
$errors = [];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs and strip extra spaces 
    $item_code = trim($_POST['item_code'] ?? '');
    $item_name = trim($_POST['item_name'] ?? '');
    $category_id = $_POST['category_id'] ?? '';
    $sub_category_id = $_POST['sub_category_id'] ?? '';
    $quantity = $_POST['quantity'] ?? '';
    $unit_price = $_POST['unit_price'] ?? '';

    // Validate inputs
    if ($item_code === '') $errors[] = "Item code is required.";
    if ($item_name === '') $errors[] = "Item name is required.";
    if ($category_id === '') $errors[] = "Please select a category.";
    if ($sub_category_id === '') $errors[] = "Please select a sub-category.";
    if (!is_numeric($quantity) || $quantity < 0) $errors[] = "Quantity must be a positive number.";
    if (!is_numeric($unit_price) || $unit_price < 0) $errors[] = "Unit price must be a positive number.";

    // If there are no errors, save to database
    if (empty($errors)) {
        // Prepare and execute insert query safely
        $stmt = $db->prepare("INSERT INTO items (item_code, item_name, category_id, sub_category_id, quantity, unit_price)
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$item_code, $item_name, $category_id, $sub_category_id, $quantity, $unit_price]);

        // Redirect to items list
        header("Location: index.php");
        exit; // Stop script execution
    }
}

// Fetch all categories for the dropdown menu
$categories = $db->query("SELECT id, name FROM item_categories ORDER BY name")->fetchAll();

// Include layout header
require_once '../includes/header.php';
?>

<!-- Page title -->
<h1 class="text-center">Add Item</h1>

<?php // Show error alert box if validation failed ?>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $e): ?><li><?= $e ?></li><?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Item creation form -->
<form method="POST" class="row g-3 mx-auto mt-4" style="max-width: 500px;">
    <!-- Item Code field -->
    <div class="col-12">
        <label class="form-label">Item Code</label>
        <input type="text" name="item_code" class="form-control">
    </div>

    <!-- Item Name field -->
    <div class="col-12">
        <label class="form-label">Item Name</label>
        <input type="text" name="item_name" class="form-control">
    </div>

    <!-- Category dropdown populated from database -->
    <div class="col-12">
        <label class="form-label">Category</label>
        <select name="category_id" id="category_id" class="form-select">
            <option value="">-- Select Category --</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Sub Category dropdown  -->
    <div class="col-12">
        <label class="form-label">Sub Category</label>
        <select name="sub_category_id" id="sub_category_id" class="form-select">
            <option value="">-- Select Category First --</option>
        </select>
    </div>

    <!-- Quantity field -->
    <div class="col-12">
        <label class="form-label">Quantity</label>
        <input type="number" name="quantity" class="form-control">
    </div>

    <!-- Unit Price field -->
    <div class="col-12">
        <label class="form-label">Unit Price</label>
        <input type="number" step="0.01" name="unit_price" class="form-control">
    </div>

    <!-- Action buttons -->
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Save Item</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </div>
</form>

<script>
// AJAX script to load subcategories dynamically when a category is selected
document.getElementById('category_id').addEventListener('change', function() {
    const categoryId = this.value;
    const subSelect = document.getElementById('sub_category_id');
    subSelect.innerHTML = '<option value="">Loading...</option>';
    if (!categoryId) {
        subSelect.innerHTML = '<option value="">-- Select Category First --</option>';
        return;
    }
    // Fetch subcategories matching the chosen category ID
    fetch('ajax_subcategories.php?category_id=' + categoryId)
        .then(response => response.json())
        .then(data => {
            subSelect.innerHTML = '<option value="">-- Select Sub Category --</option>';
            // Loop through data and build select options
            data.forEach(sub => {
                subSelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
            });
        });
});
</script>

<?php // Include layout footer ?>
<?php require_once '../includes/footer.php'; ?>