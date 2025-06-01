<div class="enquiryadmin-card">
    <div class="enquiryadmin-card-head">
        <span class="enquiryadmin-card-name"><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></span>
        <span class="enquiryadmin-card-type"><?= htmlspecialchars($row['enquiry_type']) ?></span>
    </div>
    <div class="enquiryadmin-card-meta">
        <span><?= htmlspecialchars($row['email']) ?></span>
        <span><?= htmlspecialchars($row['submitted_at']) ?></span>
    </div>
    <div class="enquiryadmin-card-msg"><?= htmlspecialchars(mb_strimwidth($row['message'], 0, 80, '...')) ?></div>
    <form method="post" class="enquiryadmin-status-form">
        <input type="hidden" name="enquiry_id" value="<?= $row['id'] ?>">
        <select name="status"
                class="enquiryadmin-status-pill enquiryadmin-status-<?= strtolower(str_replace(' ', '', $row['status'])) ?>"
                onchange="this.form.submit()">
            <option value="Pending"     <?= $row['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
            <option value="In Progress" <?= $row['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
            <option value="Resolved"    <?= $row['status'] === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
        </select>
        <input type="hidden" name="update_status" value="1">
    </form>
</div>
