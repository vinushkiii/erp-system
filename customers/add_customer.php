<?php
require_once '../includes/config.php';
$db = getDB();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $contact_number = trim($_POST['contact_number'] ?? '');
    $district_id = $_POST['district_id'] ?? '';

    if (!in_array($title, ['Mr','Mrs','Miss','Dr'])) $errors[] = "Please select a valid title.";
    if ($first_name === '') $errors[] = "First name is required.";
    if ($last_name === '') $errors[] = "Last name is required.";
    if (!preg_match('/^[0-9]{10}$/', $contact_number)) $errors[] = "Contact number must be exactly 10 digits.";
    if ($district_id === '') $errors[] = "Please select a district.";

    if (empty($errors)) {
        $stmt = $db->prepare("INSERT INTO customers (title, first_name, last_name, contact_number, district_id)
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $first_name, $last_name, $contact_number, $district_id]);

        header("Location: index.php");
        exit;
    }
}

$districts = $db->query("SELECT id, name FROM districts ORDER BY name")->fetchAll();

require_once '../includes/header.php';
?>

<h1 class="text-center">Add Customer</h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $e): ?><li><?= $e ?></li><?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" class="row g-3 mx-auto mt-5" style="max-width: 500px;">
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

    <div class="col-12">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control">
    </div>

    <div class="col-12">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control">
    </div>

    <div class="col-12">
        <label class="form-label">Contact Number</label>
        <input type="text" name="contact_number" class="form-control" placeholder="0771234567">
    </div>

    <div class="col-12">
        <label class="form-label">District</label>
        <select name="district_id" class="form-select">
            <option value="">-- Select --</option>
            <?php foreach ($districts as $d): ?>
                <option value="<?= $d['id'] ?>"><?= $d['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Save Customer</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </div>
</form>

<?php require_once '../includes/footer.php'; ?>