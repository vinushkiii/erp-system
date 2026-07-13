<?php
// Include database config
require_once '../includes/config.php';

// Connect to database
$db = getDB();

// Get search dates from URL parameters 
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';

// Array to hold report data
$rows = [];

// Only run query if both search dates are provided
if ($date_from && $date_to) {
    // Prepare query to fetch detailed invoice information within date range
    $stmt = $db->prepare("
        SELECT invoices.invoice_number, invoices.invoice_date,
               CONCAT(customers.first_name, ' ', customers.last_name) AS customer_name,
               items.item_name, items.item_code,
               item_categories.name AS category_name,
               invoice_items.unit_price
        FROM invoice_items
        JOIN invoices ON invoices.id = invoice_items.invoice_id
        JOIN customers ON customers.id = invoices.customer_id
        JOIN items ON items.id = invoice_items.item_id
        JOIN item_categories ON item_categories.id = items.category_id
        WHERE invoices.invoice_date BETWEEN ? AND ?
        ORDER BY invoices.invoice_date DESC
    ");
    // Execute query with filtered dates
    $stmt->execute([$date_from, $date_to]);
    // Fetch all matching records
    $rows = $stmt->fetchAll();
}

// Include layout header
require_once '../includes/header.php';
?>

<!-- Page title -->
<h1 class="text-center">Invoice Item Report</h1>

<!-- Date range search form using GET method -->
<form method="GET" class="row g-3 align-items-end mx-auto mt-4 mb-4" style="max-width: 600px;">
    <div class="col-auto">
        <label class="form-label">From</label>
        <input type="date" name="date_from" class="form-control" value="<?= htmlspecialchars($date_from) ?>">
    </div>
    <div class="col-auto">
        <label class="form-label">To</label>
        <input type="date" name="date_to" class="form-control" value="<?= htmlspecialchars($date_to) ?>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>

<?php // If a search was performed, display the results table ?>
<?php if ($date_from && $date_to): ?>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Invoice Number</th><th>Invoiced Date</th><th>Customer Name</th>
                <th>Item Name (Code)</th><th>Item Category</th><th>Item Unit Price</th>
            </tr>
        </thead>
        <tbody>
            <?php // Loop through each report record ?>
            <?php foreach ($rows as $r): ?>
            <tr>
                <!-- Output data rows with formatted pricing -->
                <td><?= $r['invoice_number'] ?></td>
                <td><?= $r['invoice_date'] ?></td>
                <td><?= $r['customer_name'] ?></td>
                <td><?= $r['item_name'] ?> (<?= $r['item_code'] ?>)</td>
                <td><?= $r['category_name'] ?></td>
                <td><?= number_format($r['unit_price'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <!-- Prompt user to select dates if no search has run yet -->
    <p class="text-center text-muted">Select a date range and click Search.</p>
<?php endif; ?>

<?php // Include layout footer ?>
<?php require_once '../includes/footer.php'; ?>