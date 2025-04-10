<?php
require_once 'expenditure_model.php';

$expenseModel = new ExpenditureModel();

// Default filters
$category = $_GET['category'] ?? null;
$start_date = $_GET['start_date'] ?? null;
$end_date = $_GET['end_date'] ?? null;

$expenses = $expenseModel->getExpenditure($category, $start_date, $end_date);
$totalByCategory = $expenseModel->getTotalByCategory();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Expense Tracker</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Expense Tracker Web Application</h2>

        <h4>Add Expense by clicking the button below:</h4>
        <a href="log_expense.php" class="btn btn-success mb-3">Add New Expense</a>


        <h4>Filter Expenses by Category:</h4>
        
        <form method="GET" class="form-inline mb-3">
            <input type="text" class="form-control" name="category" placeholder="Category" value="<?= $category ?>">
            <input type="date" class="form-control ml-2" name="start_date" value="<?= $start_date ?>">
            <input type="date" class="form-control ml-2" name="end_date" value="<?= $end_date ?>">
            <button type="submit" class="btn btn-primary ml-2">Filter</button>
        </form>

        <h4>Expenditure by Category-Wise:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Total Amount Spent</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($totalByCategory as $row): ?>
                    <tr>
                        <td><?= $row['category'] ?></td>
                        <td><?= number_format($row['total_spent'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4>Expenditure List:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Amount Spent</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($expenses as $expense): ?>
                    <tr>
                        <td><?= date('d-m-Y', strtotime($expense['date'])); ?></td>
                        <td><?= $expense['category'] ?></td>
                        <td><?= number_format($expense['amount'], 2) ?></td>
                        <td><?= $expense['description'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
