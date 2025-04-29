<!-- application/view/view3DAppData.php -->
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Drinks Data</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
  >
</head>
<body class="p-4">
  <h1 class="mb-4">All Drinks Records</h1>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Brand</th>
        <th>Model Path</th>
        <th>2nd Model Path</th>
        <th>Sound Path</th>
        <th>2nd Sound Path</th>
        <th>Animation</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($records as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['brand']) ?></td>
          <td><?= htmlspecialchars($row['modelPath']) ?></td>
          <td><?= htmlspecialchars($row['secondModelPath']) ?></td>
          <td><?= htmlspecialchars($row['soundPath']) ?></td>
          <td><?= htmlspecialchars($row['secondSoundPath']) ?></td>
          <td><?= htmlspecialchars($row['animation']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
