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

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $content = $_POST['content'] ?? '';
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');
    $focus_keyword = trim($_POST['focus_keyword'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $published_date = $_POST['published_date'] ?? '';
    $status = $_POST['status'] ?? 'draft';

    $featured_image = '';

    /* ---------- basic validation ---------- */

    if ($title === '' || $slug === '' || $content === '') {
        $error = 'Title, Slug and Content are required.';
    }

    /* ---------- image upload ---------- */

    if (
        empty($error) &&
        isset($_FILES['featured_image']) &&
        $_FILES['featured_image']['error'] !== UPLOAD_ERR_NO_FILE
    ) {

        if ($_FILES['featured_image']['error'] !== UPLOAD_ERR_OK) {
            $error = 'There was a problem uploading the image.';
        } else {

            $file = $_FILES['featured_image'];

            $maxSize = 5 * 1024 * 1024;

            if ($file['size'] > $maxSize) {
                $error = 'Image size must be 5 MB or less.';
            } else {

                $allowedTypes = [
                    'image/jpeg' => 'jpg',
                    'image/png'  => 'png',
                    'image/webp' => 'webp'
                ];

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);

                if (!isset($allowedTypes[$mimeType])) {

                    $error = 'Only JPG, PNG and WEBP images are allowed.';

                } else {

                    $uploadDir = dirname(__DIR__) . '/uploads/blog/';

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    $extension = $allowedTypes[$mimeType];

                    $fileName = bin2hex(random_bytes(16)) . '.' . $extension;

                    $destination = $uploadDir . $fileName;

                    if (move_uploaded_file($file['tmp_name'], $destination)) {

                        $featured_image = '/uploads/blog/' . $fileName;

                    } else {

                        $error = 'Could not save the uploaded image.';
                    }
                }
            }
        }
    }

    /* ---------- save blog ---------- */

    if (empty($error)) {

        $stmt = $conn->prepare("
            INSERT INTO blogs
            (
                title,
                slug,
                featured_image,
                content,
                meta_title,
                meta_description,
                focus_keyword,
                author,
                published_date,
                status
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssssssss",
            $title,
            $slug,
            $featured_image,
            $content,
            $meta_title,
            $meta_description,
            $focus_keyword,
            $author,
            $published_date,
            $status
        );

        if ($stmt->execute()) {

            header('Location: index.php');
            exit;

        } else {

            /* Delete uploaded image if database save fails */
            if ($featured_image !== '') {

                $uploadedFile = dirname(__DIR__) . $featured_image;

                if (file_exists($uploadedFile)) {
                    unlink($uploadedFile);
                }
            }

            $error = 'Could not save blog. The slug may already exist.';
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Blog | Swiss Dental</title>

<style>

*{
    box-sizing:border-box;
}

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

.header a{
    color:#ffde00;
    text-decoration:none;
    font-size:14px;
}

.container{
    max-width:900px;
    margin:40px auto;
    padding:0 20px;
}

.top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.top h2{
    margin:0;
}

.back{
    color:#ffde00;
    text-decoration:none;
    font-size:14px;
}

.form-box{
    background:#111;
    border:1px solid #292929;
    border-radius:14px;
    padding:30px;
}

.form-group{
    margin-bottom:22px;
}

label{
    display:block;
    margin-bottom:8px;
    font-size:14px;
    font-weight:600;
}

input,
textarea,
select{
    width:100%;
    padding:13px 14px;
    background:#080808;
    color:#fff;
    border:1px solid #333;
    border-radius:8px;
    font-size:14px;
    font-family:Arial,sans-serif;
}

input:focus,
textarea:focus,
select:focus{
    outline:none;
    border-color:#ffde00;
}

textarea{
    min-height:220px;
    resize:vertical;
}

.hint{
    color:#777;
    font-size:12px;
    margin-top:6px;
}

.row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.buttons{
    display:flex;
    gap:12px;
    margin-top:30px;
}

button{
    padding:13px 22px;
    border:0;
    border-radius:8px;
    background:#ffde00;
    color:#000;
    font-weight:700;
    cursor:pointer;
}

.cancel{
    padding:13px 22px;
    border:1px solid #444;
    border-radius:8px;
    color:#fff;
    text-decoration:none;
}

.error{
    margin-bottom:20px;
    padding:12px;
    border-radius:8px;
    background:#2a1111;
    color:#ff8d8d;
    font-size:14px;
}

@media(max-width:650px){

    .row{
        grid-template-columns:1fr;
    }

    .form-box{
        padding:20px;
    }

}

</style>

<link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet">

<style>
    #editor {
        min-height: 450px;
        font-size: 15px;
        line-height: 1.7;
    }

    .ql-editor {
        min-height: 450px;
        font-family: Arial, sans-serif;
    }

    .ql-toolbar.ql-snow {
        border-radius: 6px 6px 0 0;
    }

    .ql-container.ql-snow {
        border-radius: 0 0 6px 6px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const editor = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Write your blog content here...',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['blockquote'],
                ['link'],
                ['clean']
            ]
        }
    });

    const existingContent = document.querySelector('#content').value;

    if (existingContent) {
        editor.clipboard.dangerouslyPasteHTML(existingContent);
    }

    const form = document.querySelector('form');
    const contentField = document.querySelector('#content');

    form.addEventListener('submit', function () {
        contentField.value = editor.root.innerHTML;
    });

});
</script>

</head>

<body>

<header class="header">

    <h1>Swiss Dental Admin</h1>

    <a href="logout.php">Logout</a>

</header>


<div class="container">

    <div class="top">

        <h2>Add New Blog</h2>

        <a href="index.php" class="back">
            ← Back to Dashboard
        </a>

    </div>


    <div class="form-box">

        <?php if ($error): ?>

            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>


        <form method="POST" enctype="multipart/form-data">


            <div class="form-group">

                <label for="title">
                    Blog Title *
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label for="slug">
                    Slug *
                </label>

                <input
                    type="text"
                    id="slug"
                    name="slug"
                    value="<?php echo htmlspecialchars($_POST['slug'] ?? ''); ?>"
                    placeholder="example-dental-blog"
                    required
                >

                <div class="hint">
                    Use lowercase words separated by hyphens.
                </div>

            </div>


            <div class="form-group">

                <label for="featured_image">
                    Featured Image
                </label>

                <input
                    type="file"
                    id="featured_image"
                    name="featured_image"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                >

                <div class="hint">
                    JPG, PNG or WEBP. Maximum 5 MB.
                </div>

            </div>


            <div class="form-group">

                <label for="content">
                    Blog Content *
                </label>

            <div id="editor"></div>

                <textarea
                    id="content"
                    name="content"
                    style="display:none;"
                ><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>

            </div>


            <div class="row">


                <div class="form-group">

                    <label for="meta_title">
                        Meta Title
                    </label>

                    <input
                        type="text"
                        id="meta_title"
                        name="meta_title"
                        value="<?php echo htmlspecialchars($_POST['meta_title'] ?? ''); ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="focus_keyword">
                        Focus Keyword
                    </label>

                    <input
                        type="text"
                        id="focus_keyword"
                        name="focus_keyword"
                        value="<?php echo htmlspecialchars($_POST['focus_keyword'] ?? ''); ?>"
                    >

                </div>


            </div>


            <div class="form-group">

                <label for="meta_description">
                    Meta Description
                </label>

                <textarea
                    id="meta_description"
                    name="meta_description"
                    style="min-height:100px;"
                ><?php echo htmlspecialchars($_POST['meta_description'] ?? ''); ?></textarea>

            </div>


            <div class="row">


                <div class="form-group">

                    <label for="author">
                        Author
                    </label>

                    <input
                        type="text"
                        id="author"
                        name="author"
                        value="<?php echo htmlspecialchars($_POST['author'] ?? 'Swiss Dental'); ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="published_date">
                        Published Date
                    </label>

                    <input
                        type="datetime-local"
                        id="published_date"
                        name="published_date"
                        value="<?php echo htmlspecialchars($_POST['published_date'] ?? date('Y-m-d\TH:i')); ?>"
                    >

                </div>


            </div>


            <div class="form-group">

                <label for="status">
                    Status
                </label>

                <select id="status" name="status">

                    <option value="draft"
                        <?php echo (($_POST['status'] ?? '') === 'draft') ? 'selected' : ''; ?>>
                        Draft
                    </option>

                    <option value="published"
                        <?php echo (($_POST['status'] ?? '') === 'published') ? 'selected' : ''; ?>>
                        Published
                    </option>

                </select>

            </div>


            <div class="buttons">

                <button type="submit">
                    Save Blog
                </button>

                <a href="index.php" class="cancel">
                    Cancel
                </a>

            </div>


        </form>

    </div>

</div>

</body>

</html>