<?php require_once '../../includes/header.php'; 

// Handle search
$searchQuery = $_GET['search'] ?? '';
if($searchQuery) {
    $data = callAPI('GET', '/equipments/search', ['q' => $searchQuery]);
} else {
    $data = callAPI('GET', '/equipments');
}
?>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h3>Equipment List</h3>
        <a href="add.php" class="btn btn-primary">+ Add Equipment</a>
    </div>
    
    <!-- SEARCH FORM -->
    <form method="GET" style="margin-bottom:20px;">
        <div style="display:flex; gap:10px; align-items:center;">
            <input type="text" name="search" placeholder="🔍 Search equipment name..." 
                   value="<?= htmlspecialchars($searchQuery) ?>"
                   style="flex:1; padding:10px; border:1px solid #ddd; border-radius:5px; font-size:14px;">
            <button type="submit" class="btn btn-info">
                <i class="fas fa-search"></i> Search
            </button>
            <?php if($searchQuery): ?>
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Clear
                </a>
            <?php endif; ?>
        </div>
    </form>
    
    <?php if($searchQuery): ?>
        <div style="padding:10px; background:#e3f2fd; border-left:4px solid #2196f3; margin-bottom:15px; border-radius:4px;">
            <strong>Search results for:</strong> "<?= htmlspecialchars($searchQuery) ?>" 
            (<?= isset($data['data']) ? count($data['data']) : 0 ?> found)
        </div>
    <?php endif; ?>
    
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Stock Available</th>
                    <th>Total Stock</th>
                    <th>Status</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($data['data']) && count($data['data']) > 0): 
                    foreach($data['data'] as $row): ?>
                <tr>
                    <td style="font-family:monospace; color:#666;"><?= $row['id'] ?></td>
                    <td style="font-weight:600; color:#333;">
                        <?= htmlspecialchars($row['equipmentName']) ?>
                    </td>
                    <td>
                        <span style="background:#f0f0f0; padding:4px 8px; border-radius:4px; font-size:0.85rem;">
                            <?= $row['categoryId'] ?>
                        </span>
                    </td>
                    <td style="text-align:center; font-weight:600;">
                        <?php 
                        $avail = $row['availableQuantity'];
                        if($avail == 0) {
                            echo "<span style='color:var(--danger-color);'>$avail</span>";
                        } elseif($avail < 3) {
                            echo "<span style='color:var(--warning-color);'>$avail</span>";
                        } else {
                            echo "<span style='color:var(--success-color);'>$avail</span>";
                        }
                        ?>
                    </td>
                    <td style="text-align:center;"><?= $row['totalQuantity'] ?></td>
                    <td>
                        <?php 
                        $status = $row['conditionStatus'];
                        if($status == 'BAIK') {
                            echo "<span class='badge-status bg-success'>BAIK</span>";
                        } elseif($status == 'RUSAK_RINGAN') {
                            echo "<span class='badge-status bg-warning'>RUSAK RINGAN</span>";
                        } elseif($status == 'RUSAK_BERAT') {
                            echo "<span class='badge-status bg-danger'>RUSAK BERAT</span>";
                        } else {
                            echo "<span class='badge-status' style='background:#ff9800;'>DALAM PERBAIKAN</span>";
                        }
                        ?>
                    </td>
                    <td style="color:#666;">
                        <i class="fas fa-map-marker-alt" style="color:#999;"></i> 
                        <?= htmlspecialchars($row['location']) ?>
                    </td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="8" style="text-align:center; padding:30px; color:#999;">
                        <?php if($searchQuery): ?>
                            No equipment found matching "<?= htmlspecialchars($searchQuery) ?>"
                        <?php else: ?>
                            No equipment data available.
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>