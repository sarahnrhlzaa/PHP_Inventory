<?php
require_once 'includes/api_helper.php';
$equipments = callAPI('GET', '/equipments');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Public Catalog</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="navbar" style="justify-content: space-between;">
        <h3>Laboratorium Catalog</h3>
        <a href="login.php" class="btn btn-primary">Login Admin</a>
    </div>
    <div class="main-content" style="max-width: 1000px; margin: auto;">
        <div class="card">
            <h2>Equipment Availability</h2>
            <table>
                <thead>
                    <tr><th>Name</th><th>Category</th><th>Available Stock</th><th>Location</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <?php if($equipments && isset($equipments['data'])): ?>
                    <?php foreach($equipments['data'] as $row): ?>
                    <tr>
                        <td><?= $row['equipmentName'] ?></td>
                        <td><?= $row['categoryId'] ?></td>
                        <td>
                            <?= $row['availableQuantity'] > 0 ? 
                                "<span style='color:green;font-weight:bold'>".$row['availableQuantity']."</span>" : 
                                "<span style='color:red'>No Stock</span>" 
                            ?>
                        </td>
                        <td><?= $row['location'] ?></td>
                        <td><?= $row['conditionStatus'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>