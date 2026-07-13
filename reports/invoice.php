<?php
require_once '../includes/config.php';
$db = getDB();

$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';
$invoices = [];

if ($date_from && $date_to) {
    $stmt = $db->prepare("
        SELECT invoices.invoice_number, invoices.invoice_date,
               CONCAT(customers.first_name, ' ', customers.last_name) AS customer_name,
               districts.name AS district_name,
               COUNT(invoice_items.id) AS item_count,
               invoices.total_amount
        FROM invoices
        JOIN customers ON customers.id = invoices.customer_id
        JOIN districts ON districts.id = customers.district_id
        LEFT JOIN invoice_items ON invoice_items.invoice_id = invoices.id
        WHERE invoices.invoice_date BETWEEN ? AND ?
        GROUP BY invoices.id
        ORDER BY invoices.invoice_date DESC
    ");
    $stmt->execute([$date_from, $date_to]);
    $invoices = $stmt->fetchAll();
}

require_once '../includes/header.php';
?>

<h1 class="text-center">Invoice Report</h1>

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

<?php if ($date_from && $date_to): ?>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Invoice Number</th><th>Date</th><th>Customer</th>
                <th>District</th><th>Item Count</th><th>Invoice Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoices as $inv): ?>
            <tr>
                <td><?= $inv['invoice_number'] ?></td>
                <td><?= $inv['invoice_date'] ?></td>
                <td><?= $inv['customer_name'] ?></td>
                <td><?= $inv['district_name'] ?></td>
                <td><?= $inv['item_count'] ?></td>
                <td><?= number_format($inv['total_amount'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-center text-muted">Select a date range and click Search.</p>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>