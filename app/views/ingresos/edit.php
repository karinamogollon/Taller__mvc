<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ingreso</title>
    <link rel="stylesheet" href="../../../css/styles.css"> <!-- Enlace correcto al CSS -->
</head>
<body>
    <h1>Editar Ingreso</h1>
    
    <?php if (isset($error)): ?>
        <div class="error">
            <?= $error ?>
        </div>
    <?php endif; ?>
    
    <form action="index.php?action=edit" method="POST">
        <input type="hidden" name="id" value="<?= $ingreso->id ?>">
        
        <!-- Código del Estudiante -->
        <label for="codigoEstudiante">Código del Estudiante:</label>
        <input type="text" id="codigoEstudiante" name="codigoEstudiante" value="<?= htmlspecialchars($ingreso->codigoEstudiante) ?>" required><br>

        <!-- Nombre del Estudiante -->
        <label for="nombreEstudiante">Nombre del Estudiante:</label>
        <input type="text" id="nombreEstudiante" name="nombreEstudiante" value="<?= htmlspecialchars($ingreso->nombreEstudiante) ?>" required><br>

        <!-- Programa (No editable) -->
        <label>Programa:</label>
        <p><?= htmlspecialchars($ingreso->programa_nombre) ?></p>

        <!-- Fecha de Ingreso (No editable) -->
        <label>Fecha de Ingreso:</label>
        <p><?= htmlspecialchars($ingreso->fechaIngreso) ?></p>

        <!-- Hora de Ingreso (No editable) -->
        <label>Hora de Ingreso:</label>
        <p><?= htmlspecialchars($ingreso->horaIngreso) ?></p>

        <!-- Sala (No editable) -->
        <label>Sala:</label>
        <p><?= htmlspecialchars($ingreso->sala_nombre) ?></p>

        <!-- Responsable (No editable) -->
        <label>Responsable:</label>
        <p><?= htmlspecialchars($ingreso->responsable_nombre) ?></p>

        <!-- Botón de Envío -->
        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
