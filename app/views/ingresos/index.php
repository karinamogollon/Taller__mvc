<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Ingresos</title>
    <link rel="stylesheet" href="../../../css/styles.css"> <!-- Enlace correcto al CSS -->
</head>
<body>
    <h1>Listado de Ingresos del Día <?= date('d/m/Y') ?></h1>
    
    <a href="index.php?action=create">Registrar Nuevo Ingreso</a>
    
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
                        <td>
                            <a href="index.php?action=edit&id=<?= $ingreso->id ?>">Editar</a>
                            <!-- Opcional: Enlace para registrar salida -->
                            <!-- <form action="index.php?action=registrarSalida" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $ingreso->id ?>">
                                <button type="submit">Registrar Salida</button>
                            </form> -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No hay ingresos registrados para hoy.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
