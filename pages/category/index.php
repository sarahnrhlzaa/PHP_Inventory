<?php 
require_once '../../includes/header.php'; 
// Ambil data dari API GET /categories
$categories = callAPI('GET', '/categories');
?>

<div class="card">
    <div style="display:flex; justify-content:space-between; margin-bottom: 20px;">
        <h3>Categories</h3>
        <a href="add.php" class="btn btn-primary">+ Add Category</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($categories['data']) && count($categories['data']) > 0): ?>
                <?php foreach($categories['data'] as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td style="font-weight:bold;"><?= $c['categoryName'] ?></td>
                    <td><?= $c['description'] ?? '-' ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align:center;">No categories available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once '../../includes/footer.php'; ?>