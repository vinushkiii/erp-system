<?php
// Include database config
require_once '../includes/config.php';

// Connect to database
$db = getDB();

// Get customer ID from URL parameters 
$id = $_GET['id'] ?? 0;

// Array to hold validation errors
$errors = [];

// Fetch current customer details from the database
$stmt = $db->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$id]);
$customer = $stmt->fetch();

// Stop execution if customer doesn't exist
if (!$customer) {
    die("Customer not found.");
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs and strip extra spaces 
    $title = $_POST['title'] ?? '';
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $contact_number = trim($_POST['contact_number'] ?? '');
    $district_id = $_POST['district_id'] ?? '';

    // Validate inputs
    if (!in_array($title, ['Mr','Mrs','Miss','Dr'])) $errors[] = "Please select a valid title.";
    if ($first_name === '') $errors[] = "First name is required.";
    if ($last_name === '') $errors[] = "Last name is required.";
    if (!preg_match('/^[0-9]{10}$/', $contact_number)) $errors[] = "Contact number must be exactly 10 digits.";
    if ($district_id === '') $errors[] = "Please select a district.";

    // If there are no errors, update the database
    if (empty($errors)) {
        // Prepare and execute update query safely
        $stmt = $db->prepare("UPDATE customers SET title=?, first_name=?, last_name=?, contact_number=?, district_id=? WHERE id=?");
        $stmt->execute([$title, $first_name, $last_name, $contact_number, $district_id, $id]);

        // Redirect to customers list
        header("Location: index.php");
        exit; // Stop script execution
    }
    // If validation failed, overwrite customer data with form values to keep user inputs in fields
    $customer = compact('title','first_name','last_name','contact_number','district_id');
}

// Fetch all districts for the dropdown menu
$districts = $db->query("SELECT id, name FROM districts ORDER BY name")->fetchAll();

// Include layout header
require_once '../includes/header.php';
?>

<!-- Page title -->
<h1 class="text-center">Edit Customer</h1>

<?php // Show error alert box if validation failed ?>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $e): ?><li><?= $e ?></li><?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Customer edit form -->
<form method="POST" class="row g-3 mx-auto mt-4" style="max-width: 500px;">
    <!-- Title dropdown (auto-selects current title) -->
    <div class="col-12">
        <label class="form-label">Title</label>
        <select name="title" class="form-select">
            <option value="">-- Select --</option>
            <?php foreach (['Mr','Mrs','Miss','Dr'] as $t): ?>
                <option value="<?= $t ?>" <?= $customer['title'] === $t ? 'selected' : '' ?>><?= $t ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- First Name field with pre-filled value -->
    <div class="col-12">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($customer['first_name']) ?>">
    </div>

    <!-- Last Name field with pre-filled value -->
    <div class="col-12">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($customer['last_name']) ?>">
    </div>

    <!-- Contact Number field with pre-filled value -->
    <div class="col-12">
        <label class="form-label">Contact Number</label>
        <input type="text" name="contact_number" class="form-control" value="<?= htmlspecialchars($customer['contact_number']) ?>">
    </div>

    <!-- District dropdown  -->
    <div class="col-12">
        <label class="form-label">District</label>
        <select name="district_id" class="form-select">
            <option value="">-- Select --</option>
            <?php foreach ($districts as $d): ?>
                <option value="<?= $d['id'] ?>" <?= $customer['district_id'] == $d['id'] ? 'selected' : '' ?>><?= $d['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Action buttons -->
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Update Customer</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </div>
</form>

<?php // Include layout footer ?>
<?php require_once '../includes/footer.php'; ?>