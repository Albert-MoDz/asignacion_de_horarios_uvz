<?php
use PHPUnit\Framework\TestCase;
define('DB_SERVER', 'localhost'); // Cambia por tu servidor de base de datos
define('DB_USERNAME', 'root');    // Cambia por tu usuario
define('DB_PASSWORD', '');        // Cambia por tu contraseña
define('DB_DATABASE', 'horarios'); // Cambia por tu base de datos

require_once 'Horarios_uv_Zarzal/config/conexion.php';

class AsignaturaTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Configurar la conexión de prueba a la base de datos
        $this->conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if ($this->conn->connect_error) {
            $this->fail('Conexión fallida: ' . $this->conn->connect_error);
        }
    }

    protected function tearDown(): void
    {
        // Cerrar la conexión después de cada prueba
        $this->conn->close();
    }

    public function testInsertAsignatura()
    {
        // Datos de prueba
        $codAsig = 'CS101';
        $nombreAsig = 'Programación Básica';
        $codProg = '123';
        $periodoAcade = '2024-1';
        $codInclu = '456';

        // Insertar nueva asignatura
        $sql = "INSERT INTO asignatura (codAsig, nombreAsig, codProg, periodoAcade, codInclu) 
                VALUES ('$codAsig', '$nombreAsig', '$codProg', '$periodoAcade', '$codInclu')";
        $resultado = mysqli_query($this->conn, $sql);

        $this->assertTrue($resultado, 'La asignatura debería insertarse correctamente');
    }

    public function testUpdateAsignatura()
    {
        // Actualizar asignatura con ID conocido
        $idAsig = 1;
        $codAsig = 'CS102';
        $nombreAsig = 'Estructuras de Datos';
        $codProg = '124';
        $periodoAcade = '2024-2';
        $codInclu = '457';

        $sql = "UPDATE asignatura SET codAsig = ?, nombreAsig = ?, codProg = ?, periodoAcade = ?, codInclu = ? 
                WHERE idAsig = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssissi", $codAsig, $nombreAsig, $codProg, $periodoAcade, $codInclu, $idAsig);
        $stmt->execute();
        
        $this->assertEquals(1, $stmt->affected_rows, 'La asignatura debería actualizarse correctamente');
    }

    public function testDeleteAsignatura()
    {
        // Eliminar asignatura con ID conocido
        $idAsig = 1;

        $sql = "DELETE FROM asignatura WHERE idAsig = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idAsig);
        $stmt->execute();
        
        $this->assertEquals(1, $stmt->affected_rows, 'La asignatura debería eliminarse correctamente');
    }

    public function testSearchAsignatura()
    {
        $search = 'CS101'; // Supón que esta asignatura existe en la base de datos
        $sql = "SELECT * FROM asignatura WHERE codAsig LIKE '%$search%' OR nombreAsig LIKE '%$search%'";
        $resultado = $this->conn->query($sql);

        $this->assertGreaterThan(0, $resultado->num_rows, 'Debería haber resultados de búsqueda');
    }
}
?>
