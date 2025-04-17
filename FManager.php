<?php
$dir = isset($_GET['dir']) ? $_GET['dir'] : '.';
$dir = realpath($dir);

if (!$dir || !is_dir($dir)) {
    die('Direktori tidak ditemukan.');
}

if (isset($_GET['delete'])) {
    $fileToDelete = $dir . '/' . basename($_GET['delete']);
    
    function deleteFolder($folder) {
        foreach (scandir($folder) as $item) {
            if ($item == '.' || $item == '..') continue;
            $path = $folder . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                deleteFolder($path);
            } else {
                unlink($path);
            }
        }
        return rmdir($folder);
    }

    if (is_file($fileToDelete)) {
        unlink($fileToDelete);
    } elseif (is_dir($fileToDelete)) {
        deleteFolder($fileToDelete);
    }

    header("Location: FManager.php?dir=" . urlencode($dir));
    exit;
}

if (isset($_POST['create_folder'])) {
    $folderName = trim($_POST['folder_name']);
    if (!preg_match('/^[a-zA-Z0-9_\- ]+$/', $folderName)) {
        die("Nama folder tidak valid.");
    }
    $newFolderPath = $dir . '/' . $folderName;
    if (!file_exists($newFolderPath)) {
        mkdir($newFolderPath);
    }
    header("Location: FManager.php?dir=" . urlencode($dir));
    exit;
}

if (isset($_POST['upload_file'])) {
    $targetFile = $dir . '/' . basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $targetFile);
    header("Location: FManager.php?dir=" . urlencode($dir));
    exit;
}

if (isset($_POST['edit_file'])) {
    file_put_contents($_POST['file_path'], $_POST['file_content']);
    header("Location: FManager.php?dir=" . urlencode(dirname($_POST['file_path'])));
    exit;
}

if (isset($_GET['extract']) && is_file($_GET['extract']) && strtolower(pathinfo($_GET['extract'], PATHINFO_EXTENSION)) === 'zip') {
    $zipFile = $_GET['extract'];
    $extractDir = $dir; 
    $zip = new ZipArchive;
    if ($zip->open($zipFile) === TRUE) {
        $zip->extractTo($extractDir); 
        $zip->close();
        header("Location: FManager.php?dir=" . urlencode($dir));
        exit;
    } else {
        die("Gagal mengekstrak file ZIP.");
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>🗂 File Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f6f9;
            color: #333;
            padding: 40px;
        }
        h2 {
            color: #1e88e5;
        }
        a {
            color: #1e88e5;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .nav {
            margin-bottom: 20px;
        }
        .actions, .upload, .edit-section {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        input[type="text"], input[type="file"], textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 100%;
            margin-top: 5px;
            margin-bottom: 10px;
        }
        button {
            background: #1e88e5;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }
        button:hover {
            background: #1565c0;
        }
        table {
            width: 100%;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background: #e3f2fd;
        }
        tr:nth-child(even) {
            background: #fafafa;
        }
        .file-icon {
            margin-right: 8px;
        }
        .edit-section textarea {
            width: 100%;
            font-family: monospace;
        }
    </style>
</head>
<body>

    <h2>🗂 File Manager - <?= htmlspecialchars($dir) ?></h2>

    <div class="nav">
        <?php if ($dir !== realpath('.')): ?>
            <a href="?dir=<?= urlencode(dirname($dir)) ?>">⬅ Kembali ke atas</a>
        <?php endif; ?>
    </div>

    <div class="actions">
        <form method="post">
            <label>📁 Buat Folder Baru:</label>
            <input type="text" name="folder_name" placeholder="Nama folder..." required>
            <button type="submit" name="create_folder">+ Buat</button>
        </form>
    </div>

    <div class="upload">
        <form method="post" enctype="multipart/form-data">
            <label>📤 Upload File:</label>
            <input type="file" name="file" required>
            <button type="submit" name="upload_file">Upload</button>
        </form>
    </div>

    <table>
        <tr><th>Nama</th><th>Tipe</th><th>Aksi</th></tr>
        <?php foreach (scandir($dir) as $file): ?>
            <?php if ($file === '.' || $file === '..') continue; ?>
            <?php $filePath = $dir . '/' . $file; ?>
            <tr>
                <td>
                    <?php if (is_dir($filePath)): ?>
                        📁 <a href="?dir=<?= urlencode($filePath) ?>"><?= htmlspecialchars($file) ?></a>
                    <?php else: ?>
                        📄 <?= htmlspecialchars($file) ?>
                    <?php endif; ?>
                </td>
                <td><?= is_dir($filePath) ? 'Folder' : 'File' ?></td>
                <td>
                    <a href="javascript:void(0);" onclick="confirmDelete('<?= urlencode($file) ?>')">🗑 Hapus</a>
                    <?php if (is_file($filePath)): ?>
                        | <a href="?edit=<?= urlencode($filePath) ?>">✏️ Edit</a>
                        <?php if (strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) === 'zip'): ?>
                            | <a href="javascript:void(0);" onclick="confirmExtract('<?= urlencode($filePath) ?>')">📦 Extract</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if (isset($_GET['edit']) && is_file($_GET['edit'])): ?>
        <?php $editFile = $_GET['edit']; ?>
        <div class="edit-section">
            <h3>✏️ Edit File: <?= htmlspecialchars(basename($editFile)) ?></h3>
            <form method="post">
                <textarea name="file_content" rows="15"><?= htmlspecialchars(file_get_contents($editFile)) ?></textarea><br>
                <input type="hidden" name="file_path" value="<?= htmlspecialchars($editFile) ?>">
                <button type="submit" name="edit_file">💾 Simpan</button>
            </form>
        </div>
    <?php endif; ?>

    <script>
        function confirmDelete(file) {
            Swal.fire({
                title: 'Yakin ingin menghapus file ini?',
                text: 'File yang dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "?dir=<?= urlencode($dir) ?>&delete=" + file;
                }
            });
        }

        function confirmExtract(file) {
            Swal.fire({
                title: 'Yakin ingin mengekstrak file ZIP ini?',
                text: 'File akan diekstrak ke folder baru.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ekstrak!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "?dir=<?= urlencode($dir) ?>&extract=" + file;
                }
            });
        }
    </script>
</body>
</html>
