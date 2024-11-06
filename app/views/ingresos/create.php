<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Ingreso</title>
</head>
<body>
    <h1>Registrar Ingreso a la Sala de Cómputo</h1>
    
    <?php if (isset($error)): ?>
        <div class="error">
            <?= $error ?>
        </div>
    <?php endif; ?>
    
    <form action="index.php?action=create" method="POST">
        
        <!-- Código del Estudiante -->
        <label for="codigoEstudiante">Código del Estudiante:</label>
        <input type="text" id="codigoEstudiante" name="codigoEstudiante" required><br>

        <!-- Nombre del Estudiante -->
        <label for="nombreEstudiante">Nombre del Estudiante:</label>
        <input type="text" id="nombreEstudiante" name="nombreEstudiante" required><br>

        <!-- Programa -->
        <label for="idPrograma">Programa:</label>
        <select id="idPrograma" name="idPrograma" required>
            <option value="">Seleccione un programa</option>
            <?php foreach ($programas as $programa): ?>
                <option value="<?= $programa->id ?>"><?= $programa->nombre ?></option>
            <?php endforeach; ?>
        </select><br>

        <!-- Fecha de Ingreso -->
        <label for="fechaIngreso">Fecha de Ingreso:</label>
        <input type="date" id="fechaIngreso" name="fechaIngreso" required><br>

        <!-- Hora de Ingreso -->
        <label for="horaIngreso">Hora de Ingreso:</label>
        <input type="time" id="horaIngreso" name="horaIngreso" required><br>

        <!-- Sala -->
        <label for="idSala">Sala:</label>
        <select id="idSala" name="idSala" required>
            <option value="">Seleccione una sala</option>
            <?php foreach ($salas as $sala): ?>
                <option value="<?= $sala->id ?>"><?= $sala->nombre ?></option>
            <?php endforeach; ?>
        </select><br>

        <!-- Responsable -->
        <label for="idResponsable">Responsable:</label>
        <select id="idResponsable" name="idResponsable" required>
            <option value="">Seleccione un responsable</option>
            <?php foreach ($responsables as $responsable): ?>
                <option value="<?= $responsable->id ?>"><?= $responsable->nombre ?></option>
            <?php endforeach; ?>
        </select><br>

        

        <!-- Botón de Envío -->
        <button type="submit">Registrar Ingreso</button>
    </form>
</body>
</html>
