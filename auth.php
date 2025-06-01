<?php
function checkPagePermission($conn, $page, $role_id) {
    $stmt = mysqli_prepare($conn, "SELECT can_view FROM page_permissions WHERE page = ? AND role_id = ?");
    mysqli_stmt_bind_param($stmt, "si", $page, $role_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $can_view);
    $result = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return ($result && $can_view == 1);
}
?>
