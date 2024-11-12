<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Ingresos</title>
    <link rel="stylesheet" href="css/estilos.css">
    </head>
<body>
    <h1>Listado de Ingresos del Día <?= date('d/m/Y') ?></h1>
    
    <a href="index.php?action=create">Registrar Nuevo Ingreso</a>

    <!-- Formulario de Filtro -->
    <h2>Filtrar Ingresos</h2>
    <form action="index.php?action=index" method="GET">
        <!-- Filtro por Rango de Fechas -->
        <label for="fechaInicio">Fecha Inicio:</label>
        <input type="date" id="fechaInicio" name="fechaInicio" required><br>

        <label for="fechaFin">Fecha Fin:</label>
        <input type="date" id="fechaFin" name="fechaFin" required><br>

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

        <button type="submit">Filtrar</button>
    </form>

    <!-- Mostrar los Ingresos -->
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Programa</th>
                <th>Fecha Ingreso</th>
                <th>Hora Ingreso</th>
                <th>Sala</th>
                <th>Responsable</th>
                <th>Fecha Creación</th>
                <th>Fecha Modificación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($ingresos)): ?>
                <?php foreach ($ingresos as $ingreso): ?>
                    <tr>
                        <td><?= htmlspecialchars($ingreso->codigoEstudiante) ?></td>
                        <td><?= htmlspecialchars($ingreso->nombreEstudiante) ?></td>
                        <td><?= htmlspecialchars($ingreso->programa_nombre) ?></td>
                        <td><?= htmlspecialchars($ingreso->fechaIngreso) ?></td>
                        <td><?= htmlspecialchars($ingreso->horaIngreso) ?></td>
                        <td><?= htmlspecialchars($ingreso->sala_nombre) ?></td>
                        <td><?= htmlspecialchars($ingreso->responsable_nombre) ?></td>
                        <td><?= htmlspecialchars($ingreso->fechaCreacion) ?></td>
                        <td><?= htmlspecialchars($ingreso->fechaModificacion) ?></td>
                        <td>
                            <a href="index.php?action=edit&id=<?= $ingreso->id ?>">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No hay ingresos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
