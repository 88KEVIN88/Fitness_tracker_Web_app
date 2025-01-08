<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Exercise</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Add a New Exercise</h1>
        <?php
        include '../config/db.php';

        // Recupera i tipi di esercizio dalla tabella tipo_esercizio
        $resultTypes = $conn->query("SELECT id_tipo, nome_tipo FROM tipo_esercizio");
        if (!$resultTypes) {
            die("Error fetching exercise types: " . $conn->error);
        }
        $types = $resultTypes->fetch_all(MYSQLI_ASSOC);

        // Recupera le descrizioni degli esercizi dalla tabella esercizi_descrizione
        $resultDescriptions = $conn->query("SELECT id_descrizione, nome_esercizio FROM esercizi_descrizione");
        if (!$resultDescriptions) {
            die("Error fetching exercise descriptions: " . $conn->error);
        }
        $descriptions = $resultDescriptions->fetch_all(MYSQLI_ASSOC);
        ?>
        <form method="POST" action="../handlers/addExerciseHandler.php" class="p-4 border rounded shadow-sm bg-light">
            <div class="mb-3">
                <label for="exercise_name" class="form-label">Exercise Name:</label>
                <input type="text" id="exercise_name" name="exercise_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="series" class="form-label">Default Series:</label>
                    <input type="number" id="series" name="series" class="form-control" required min="1">
                </div>
                <div class="col-md-6">
                    <label for="repetitions" class="form-label">Default Repetitions:</label>
                    <input type="number" id="repetitions" name="repetitions" class="form-control" required min="1">
                </div>
            </div>

            <div class="mb-3">
                <label for="type_id" class="form-label">Exercise Type:</label>
                <select id="type_id" name="type_id" class="form-select" required>
                    <?php foreach ($types as $type): ?>
                        <option value="<?= htmlspecialchars($type['id_tipo']) ?>">
                            <?= htmlspecialchars($type['nome_tipo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="description_id" class="form-label">Detailed Description:</label>
                <select id="description_id" name="description_id" class="form-select">
                    <option value="">-- Add New Description --</option>
                    <?php foreach ($descriptions as $description): ?>
                        <option value="<?= htmlspecialchars($description['id_descrizione']) ?>">
                            <?= htmlspecialchars($description['nome_esercizio']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="new_description" class="form-label">New Detailed Description (if not listed above):</label>
                <textarea id="new_description" name="new_description" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Add Exercise</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
