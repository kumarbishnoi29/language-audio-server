<?php
require_once 'verify_auth.php';
require_once 'config.php';

// Collect categories and files
$categories = array_filter(glob(AUDIO_BASE_DIR . '*'), 'is_dir');
?>

<!DOCTYPE html>
<html>
<head>
  <title>Audio Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand">🎧 Audio Admin Panel</span>
    <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
  </div>
</nav>

<div class="container mt-4">
  <h3>Upload New MP3</h3>
  <form action="upload.php" method="POST" enctype="multipart/form-data" class="row g-3">
    <div class="col-md-4">
      <input type="text" name="category" class="form-control" placeholder="Category (e.g. numbers)" required>
    </div>
    <div class="col-md-5">
      <input type="file" name="audio" class="form-control" accept=".mp3,.wav,.ogg" required>
    </div>
    <div class="col-md-3">
      <button class="btn btn-success w-100" type="submit">Upload</button>
    </div>
  </form>

  <hr>

  <h3>Existing Categories</h3>
  <?php if (empty($categories)): ?>
    <p>No categories yet. Upload your first audio!</p>
  <?php endif; ?>

  <?php foreach ($categories as $catPath): 
        $category = basename($catPath);
        $files = array_filter(scandir($catPath), fn($f) => !is_dir("$catPath/$f"));
  ?>
    <div class="card mb-3">
      <div class="card-header bg-primary text-white">
        <strong><?= htmlspecialchars($category) ?></strong>
      </div>
      <div class="card-body">
        <?php if (empty($files)): ?>
          <p class="text-muted">No files yet.</p>
        <?php else: ?>
          <table class="table table-sm">
            <thead>
              <tr>
                <th>File</th>
                <th>Play</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($files as $file): 
                  $url = "categories/$category/$file";
              ?>
              <tr>
                <td><?= htmlspecialchars($file) ?></td>
                <td><audio controls src="<?= htmlspecialchars($url) ?>" style="width:200px;"></audio></td>
                <td>
                  <form method="POST" action="delete.php" style="display:inline;">
                    <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
                    <input type="hidden" name="file" value="<?= htmlspecialchars($file) ?>">
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this file?')">Delete</button>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>
</body>
</html>
