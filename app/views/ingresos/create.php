<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Nuevo Ingreso</title>
    <link rel="stylesheet" href="css/estilos2.css"> 
</head>
<body>
    <h1>Registrar Nuevo Ingreso</h1>

    <!-- Mostrar error si existe -->
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="index.php?action=create" method="POST">
        <label for="codigoEstudiante">Código del Estudiante:</label>
        <input type="text" id="codigoEstudiante" name="codigoEstudiante" required><br>

        <label for="nombreEstudiante">Nombre del Estudiante:</label>
        <input type="text" id="nombreEstudiante" name="nombreEstudiante" required><br>

        <label for="idPrograma">Programa:</label>
        <select id="idPrograma" name="idPrograma" required>
            <?php foreach ($programas as $programa): ?>
                <option value="<?= $programa->id ?>"><?= $programa->nombre ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="fechaIngreso">Fecha de Ingreso:</label>
        <input type="date" id="fechaIngreso" name="fechaIngreso" required><br>

        <label for="horaIngreso">Hora de Ingreso:</label>
        <input type="time" id="horaIngreso" name="horaIngreso" required><br>

        <label for="horaSalida">Hora de Salida:</label>
        <input type="time" id="horaSalida" name="horaSalida" required><br>

        <label for="idSala">Sala:</label>
        <select id="idSala" name="idSala" required>
            <?php foreach ($salas as $sala): ?>
                <option value="<?= $sala->id ?>"><?= $sala->nombre ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="idResponsable">Responsable:</label>
        <select id="idResponsable" name="idResponsable" required>
            <?php foreach ($responsables as $responsable): ?>
                <option value="<?= $responsable->id ?>"><?= $responsable->nombre ?></option>
            <?php endforeach; ?>
        </select><br>

        <button type="submit">Guardar Ingreso</button>
    </form>

    <h2>Consultar Ingresos del Día Actual</h2>
    <form action="index.php?action=consultar" method="GET">
        <!-- Filtro por Rango de Fechas -->
        <label for="fechaInicio">Fecha Inicio:</label>
        <input type="date" id="fechaInicio" name="fechaInicio"><br>

        <label for="fechaFin">Fecha Fin:</label>
        <input type="date" id="fechaFin" name="fechaFin"><br>

        <!-- Filtro por Código de Estudiante -->
        <label for="codigoEstudianteFiltro">Código del Estudiante:</label>
        <input type="text" id="codigoEstudianteFiltro" name="codigoEstudianteFiltro"><br>

        <!-- Filtro por Programa -->
        <label for="idProgramaFiltro">Programa:</label>
        <select id="idProgramaFiltro" name="idProgramaFiltro">
            <option value="">Seleccione un programa</option>
            <?php foreach ($programas as $programa): ?>
                <option value="<?= $programa->id ?>"><?= $programa->nombre ?></option>
            <?php endforeach; ?>
        </select><br>

        <!-- Filtro por Responsable -->
        <label for="idResponsableFiltro">Responsable:</label>
        <select id="idResponsableFiltro" name="idResponsableFiltro">
            <option value="">Seleccione un responsable</option>
            <?php foreach ($responsables as $responsable): ?>
                <option value="<?= $responsable->id ?>"><?= $responsable->nombre ?></option>
            <?php endforeach; ?>
        </select><br>

        <button type="submit">Consultar Ingresos</button>
    </form>

</body>
</html>
