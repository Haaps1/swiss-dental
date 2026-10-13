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

$result = $conn->query("
    SELECT *
    FROM blogs
    ORDER BY COALESCE(published_date, created_at) DESC
");

$totalBlogs = $result ? $result->num_rows : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard | Swiss Dental</title>

<style>
*{box-sizing:border-box;}

body{
    margin:0;
    background:#080808;
    color:#fff;
    font-family:Arial,sans-serif;
}

.header{
    padding:20px 30px;
    border-bottom:1px solid #292929;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.header h1{
    margin:0;
    font-size:24px;
}

.logout{
    color:#ffde00;
    text-decoration:none;
    font-size:14px;
}

.container{
    max-width:1100px;
    margin:40px auto;
    padding:0 20px;
}

.top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.top h2{margin:0;}

.add-btn{
    background:#ffde00;
    color:#000;
    padding:12px 18px;
    border-radius:8px;
    text-decoration:none;
    font-weight:700;
    font-size:14px;
}

.stats{
    background:#111;
    border:1px solid #292929;
    border-radius:12px;
    padding:25px;
    margin-bottom:30px;
}

.stats span{
    color:#999;
    font-size:14px;
}

.stats strong{
    display:block;
    font-size:30px;
    margin-top:8px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:#111;
    border:1px solid #292929;
    border-radius:12px;
    overflow:hidden;
}

th,td{
    padding:16px;
    text-align:left;
    border-bottom:1px solid #292929;
}

th{
    color:#ffde00;
    font-size:13px;
}

td{
    font-size:14px;
}

.status{
    color:#72e6a3;
}

.empty{
    padding:30px;
    text-align:center;
    color:#999;
}
</style>
</head>

<body>

<header class="header">
    <h1>Swiss Dental Admin</h1>
    <a href="logout.php" class="logout">Logout</a>
</header>

<div class="container">

    <div class="top">
        <h2>Blog Dashboard</h2>
        <a href="add-blog.php" class="add-btn">+ Add New Blog</a>
    </div>

    <div class="stats">
        <span>Total Blogs</span>
        <strong><?php echo $totalBlogs; ?></strong>
    </div>

    <?php if ($totalBlogs > 0): ?>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Published Date</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php while ($blog = $result->fetch_assoc()): ?>

            <tr>
                <td>
                    <?php echo htmlspecialchars($blog['title']); ?>
                </td>

                <td class="status">
                    <?php echo htmlspecialchars($blog['status']); ?>
                </td>

                <td>
                    <?php
                    echo date(
                        'M j, Y',
                        strtotime($blog['published_date'] ?: $blog['created_at'])
                    );
                    ?>
                </td>
                
                <td>
   <div style="display:flex;gap:12px;align-items:center;">

    <a
        href="edit-blog.php?id=<?php echo (int)$blog['id']; ?>"
        style="color:#ffde00;text-decoration:none;font-weight:600;"
    >
        Edit
    </a>

    <a
        href="delete-blog.php?id=<?php echo (int)$blog['id']; ?>"
        onclick="return confirm('Are you sure you want to delete this blog?');"
        style="color:#ff6b6b;text-decoration:none;font-weight:600;"
    >
        Delete
    </a>

</div>
</td>
            </tr>

        <?php endwhile; ?>

        </tbody>
    </table>

    <?php else: ?>

        <div class="empty">
            No blogs found.
        </div>

    <?php endif; ?>

</div>

</body>
</html>