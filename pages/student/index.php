<?php 
require_once '../../includes/header.php'; 
// Ambil data dari API GET /students
$students = callAPI('GET', '/students');
?>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
        <h3>Student List</h3>
        <a href="add.php" class="btn btn-primary">+ Add Student</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>NIM</th>
                <th>Full Name</th>
                <th>Study Program</th>
                <th>Phone Number</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($students['data']) && count($students['data']) > 0): ?>
                <?php foreach($students['data'] as $s): ?>
                <tr>
                    <td><?= $s['id'] ?></td>
                    <td><?= $s['nim'] ?></td>
                    <td><?= $s['name'] ?></td>
                    <td><?= $s['studyProgram'] ?></td>
                    <td><?= $s['phone'] ?? '-' ?></td>
                    <td>
                        <a href="edit.php?id=<?= $s['id'] ?>" class="btn btn-info btn-sm">Edit</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;">No student data available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once '../../includes/footer.php'; ?>