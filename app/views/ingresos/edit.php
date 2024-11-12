<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar o Editar Ingreso</title>
    <link rel="stylesheet" href="css/estilos2.css"> 
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

        <!-- Fecha de Creación (No editable) -->
         <label>Fecha de Creación:</label>
         <p><?= htmlspecialchars($ingreso->fechaCreacion) ?></p>
         
         <!-- Fecha de Modificación (No editable) -->
          <label>Fecha de Modificación:</label>
          <p><?= htmlspecialchars($ingreso->fechaModificacion) ?></p>

        <!-- Botón de Envío -->
        <button type="submit">Guardar Cambios</button>
    </form>

    <h2>Consultar Ingresos</h2>
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

    <?php if (isset($ingresos)): ?>
        <h2>Ingresos Consultados</h2>
        <table>
            <thead>
                <tr>
                    <th>Código Estudiante</th>
                    <th>Nombre Estudiante</th>
                    <th>Programa</th>
                    <th>Fecha Ingreso</th>
                    <th>Hora Ingreso</th>
                    <th>Sala</th>
                    <th>Responsable</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ingresos as $ingreso): ?>
                    <tr>
                        <td><?= htmlspecialchars($ingreso->codigoEstudiante) ?></td>
                        <td><?= htmlspecialchars($ingreso->nombreEstudiante) ?></td>
                        <td><?= htmlspecialchars($ingreso->programa_nombre) ?></td>
                        <td><?= htmlspecialchars($ingreso->fechaIngreso) ?></td>
                        <td><?= htmlspecialchars($ingreso->horaIngreso) ?></td>
                        <td><?= htmlspecialchars($ingreso->sala_nombre) ?></td>
                        <td><?= htmlspecialchars($ingreso->responsable_nombre) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
