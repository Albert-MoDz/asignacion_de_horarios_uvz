<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

require_once "config/conexion.php";

// Handle form submission for adding or updating a docente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idDoc = $_POST['idDoc'] ?? null;
    $nombreDoc = $_POST['nombreDoc'];
    $idTipoDoc = $_POST['idTipoDoc'];
    $idMuni = $_POST['idMuni'];

    if ($idDoc) {
        // Update existing docente
        $sql = "UPDATE docente SET nombreDoc = ?, idTipoDoc = ?, idMuni = ? WHERE idDoc = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siii", $nombreDoc, $idTipoDoc, $idMuni, $idDoc);
    } else {
        // Insert new docente
        $sql = "INSERT INTO docente (nombreDoc, idTipoDoc, idMuni) VALUES ( ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("sii", $nombreDoc, $idTipoDoc, $idMuni);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Docente guardado exitosamente.'); window.location.href = 'docente.php';</script>";
    } else {
        echo "<script>alert('Error al guardar el docente: " . $stmt->error . "'); window.location.href = 'docente.php';</script>";
    }

    $stmt->close();
}

// Handle deletion of a docente
if (isset($_GET['delete'])) {
    $idDoc = $_GET['delete'];
    $sql = "DELETE FROM docente WHERE idDoc = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idDoc);

    if ($stmt->execute()) {
        echo "<script>alert('Docente eliminado exitosamente.'); window.location.href = 'docente.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el docente: " . $stmt->error . "'); window.location.href = 'docente.php';</script>";
    }

    $stmt->close();
}

// Retrieve list of docentes
$sql = "SELECT * FROM docente";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        
        .content {
            padding: 20px;
            text-align: center;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 20px auto;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #DC143C;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #DC143C;
            color: #fff;
        }
        .actions {
            text-align: center;
        }
        .actions a {
            margin: 0 5px;
            color: #007BFF;
            text-decoration: none;
        }
        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php include 'menu.php'; ?>
    <div class="content">
        <h1>Docente</h1>
        <div class="form-container">
            <form action="docente.php" method="post">
                <input type="hidden" name="idDoc" id="idDoc">
                <input type="text" name="nombreDoc" id="nombreDoc" placeholder="Nombre del Docente" required>
                <input type="number" name="idTipoDoc" id="idTipoDoc" placeholder="ID Tipo de Docente" required>
                <input type="number" name="idMuni" id="idMuni" placeholder="ID Municipio" required>
                <button type="submit">Guardar</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>ID Tipo Docente</th>
                    <th>ID Municipio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['idDoc']; ?></td>
                    <td><?php echo $row['nombreDoc']; ?></td>
                    +<td><?php echo $row['idTipoDoc']; ?></td>
                    <td><?php echo $row['idMuni']; ?></td>
                    <td class="actions">
                        <a href="javascript:void(0);" onclick="editDocente(<?php echo $row['idDoc']; ?>, '<?php echo $row['nombreDoc']; ?>', '<?php echo $row['idTipoDoc']; ?>', '<?php echo $row['idMuni']; ?>')">Editar</a>
                        <a href="docente.php?delete=<?php echo $row['idDoc']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este docente?')">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script>
        function editDocente(idDoc, cedulaDoc, nombreDoc, localDoc, idTipoDoc, idMuni) {
            document.getElementById('idDoc').value = idDoc;
            document.getElementById('nombreDoc').value = nombreDoc;
            document.getElementById('idTipoDoc').value = idTipoDoc;
            document.getElementById('idMuni').value = idMuni;
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
