<?php
// Include database config
require_once '../includes/config.php';

// Connect to database
$db = getDB();

// Array to hold validation errors
$errors = [];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs and strip extra spaces (default to empty string)
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

    // If there are no errors, save to database
    if (empty($errors)) {
        // Use prepared statements to prevent SQL injection
        $stmt = $db->prepare("INSERT INTO customers (title, first_name, last_name, contact_number, district_id)
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $first_name, $last_name, $contact_number, $district_id]);

        // Redirect to customers list
        header("Location: index.php");
        exit; // Stop script execution
    }
}

// Fetch all districts for the dropdown menu
$districts = $db->query("SELECT id, name FROM districts ORDER BY name")->fetchAll();

// Include layout header
require_once '../includes/header.php';
?>

<!-- Page title -->
<h1 class="text-center">Add Customer</h1>

<?php // Show error alert box if validation failed ?>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $e): ?><li><?= $e ?></li><?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Customer creation form -->
<form method="POST" class="row g-3 mx-auto mt-5" style="max-width: 500px;">
    <!-- Title dropdown -->
    <div class="col-12">
        <label class="form-label">Title</label>
        <select name="title" class="form-select">
            <option value="">-- Select --</option>
            <option value="Mr">Mr</option>
            <option value="Mrs">Mrs</option>
            <option value="Miss">Miss</option>
            <option value="Dr">Dr</option>
        </select>
    </div>

    <!-- First Name field -->
    <div class="col-12">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control">
    </div>

    <!-- Last Name field -->
    <div class="col-12">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control">
    </div>

    <!-- Contact Number field -->
    <div class="col-12">
        <label class="form-label">Contact Number</label>
        <input type="text" name="contact_number" class="form-control" placeholder="0771234567">
    </div>

    <!-- District dropdown (loaded from database) -->
    <div class="col-12">
        <label class="form-label">District</label>
        <select name="district_id" class="form-select">
            <option value="">-- Select --</option>
            <?php // Loop through database results to create dropdown options ?>
            <?php foreach ($districts as $d): ?>
                <option value="<?= $d['id'] ?>"><?= $d['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Action buttons -->
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Save Customer</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </div>
</form>

<?php // Include layout footer ?>
<?php require_once '../includes/footer.php'; ?>
