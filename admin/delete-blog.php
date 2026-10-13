<?php
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

if (empty($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once '../config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare("SELECT featured_image FROM blogs WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$blog = $result->fetch_assoc();

$stmt->close();

if (!$blog) {
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

/* Delete uploaded image */
if (!empty($blog['featured_image'])) {

    $imagePath = dirname(__DIR__) . $blog['featured_image'];

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}

header('Location: index.php');
exit;
?>