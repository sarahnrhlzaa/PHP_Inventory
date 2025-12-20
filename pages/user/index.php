<?php 
require_once '../../includes/header.php'; 

if($_SESSION['role'] !== 'ADMIN') {
    echo "<script>alert('Access Denied');window.location='../dashboard.php';</script>";
    exit;
}
$users = callAPI('GET', '/users');
?>
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h3>Management User (Admin Area)</h3>
        <a href="add.php" class="btn btn-primary">+ Add Staff</a>
    </div>
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr></thead>
        <tbody>
            <?php if(isset($users['data'])): foreach($users['data'] as $u): ?>
            <tr>
                <td style="color: #333;"><?= $u['id'] ?></td>

                <td style="font-weight: bold;"><?= $u['name'] ?></td>
                <td><?= $u['email'] ?></td>
                <td>
                    <?php if($u['role'] === 'ADMIN'): ?>
                        <span class="badge-role bg-danger">ADMIN</span>
                    <?php else: ?>
                        <span class="badge-role bg-primary">PETUGAS</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>
<?php require_once '../../includes/footer.php'; ?>