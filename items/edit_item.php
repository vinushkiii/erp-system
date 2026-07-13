<?php
require_once '../includes/config.php';
$db = getDB();

$id = $_GET['id'] ?? 0;
$errors = [];

$stmt = $db->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    die("Item not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_code = trim($_POST['item_code'] ?? '');
    $item_name = trim($_POST['item_name'] ?? '');
    $category_id = $_POST['category_id'] ?? '';
    $sub_category_id = $_POST['sub_category_id'] ?? '';
    $quantity = $_POST['quantity'] ?? '';
    $unit_price = $_POST['unit_price'] ?? '';

    if ($item_code === '') $errors[] = "Item code is required.";
    if ($item_name === '') $errors[] = "Item name is required.";
    if ($category_id === '') $errors[] = "Please select a category.";
    if ($sub_category_id === '') $errors[] = "Please select a sub-category.";
    if (!is_numeric($quantity) || $quantity < 0) $errors[] = "Quantity must be a positive number.";
    if (!is_numeric($unit_price) || $unit_price < 0) $errors[] = "Unit price must be a positive number.";

    if (empty($errors)) {
        $stmt = $db->prepare("UPDATE items SET item_code=?, item_name=?, category_id=?, sub_category_id=?, quantity=?, unit_price=? WHERE id=?");
        $stmt->execute([$item_code, $item_name, $category_id, $sub_category_id, $quantity, $unit_price, $id]);

        header("Location: index.php");
        exit;
    }
    $item = compact('item_code','item_name','category_id','sub_category_id','quantity','unit_price');
}

$categories = $db->query("SELECT id, name FROM item_categories ORDER BY name")->fetchAll();
$stmt = $db->prepare("SELECT id, name FROM item_sub_categories WHERE category_id = ? ORDER BY name");
$stmt->execute([$item['category_id']]);
$subcategories = $stmt->fetchAll();

require_once '../includes/header.php';
?>

<h1 class="text-center">Edit Item</h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $e): ?><li><?= $e ?></li><?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" class="row g-3 mx-auto mt-4" style="max-width: 500px;">
    <div class="col-12">
        <label class="form-label">Item Code</label>
        <input type="text" name="item_code" class="form-control" value="<?= htmlspecialchars($item['item_code']) ?>">
    </div>

    <div class="col-12">
        <label class="form-label">Item Name</label>
        <input type="text" name="item_name" class="form-control" value="<?= htmlspecialchars($item['item_name']) ?>">
    </div>

    <div class="col-12">
        <label class="form-label">Category</label>
        <select name="category_id" id="category_id" class="form-select">
            <option value="">-- Select Category --</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $item['category_id'] == $c['id'] ? 'selected' : '' ?>><?= $c['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Sub Category</label>
        <select name="sub_category_id" id="sub_category_id" class="form-select">
            <?php foreach ($subcategories as $s): ?>
                <option value="<?= $s['id'] ?>" <?= $item['sub_category_id'] == $s['id'] ? 'selected' : '' ?>><?= $s['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Quantity</label>
        <input type="number" name="quantity" class="form-control" value="<?= $item['quantity'] ?>">
    </div>

    <div class="col-12">
        <label class="form-label">Unit Price</label>
        <input type="number" step="0.01" name="unit_price" class="form-control" value="<?= $item['unit_price'] ?>">
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Update Item</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </div>
</form>

<script>
document.getElementById('category_id').addEventListener('change', function() {
    const categoryId = this.value;
    const subSelect = document.getElementById('sub_category_id');
    subSelect.innerHTML = '<option value="">Loading...</option>';
    if (!categoryId) return;
    fetch('ajax_subcategories.php?category_id=' + categoryId)
        .then(response => response.json())
        .then(data => {
            subSelect.innerHTML = '<option value="">-- Select Sub Category --</option>';
            data.forEach(sub => {
                subSelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
            });
        });
});
</script>

<?php require_once '../includes/footer.php'; ?>