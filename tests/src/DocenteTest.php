<?php
use PHPUnit\Framework\TestCase;

class DocenteTest extends TestCase {
    protected $conn;

    protected function setUp(): void {
        // Aquí realizaríamos la configuración de la base de datos (por ejemplo, usar una base de datos en memoria o un mock).
        $this->conn = new mysqli('localhost', 'root', '', 'horarios'); // Configura tu conexión correctamente
    }

    // Test para crear un docente
    public function testCrearDocente() {
        // Datos de prueba
        $cedulaDoc = "123456789";
        $nombreDoc = "Juan Pérez";
        $localDoc = "Localidad 1";
        $idTipoDoc = 1;
        $idMuni = 1;

        // Crear docente
        $sql = "INSERT INTO docente (cedulaDoc, nombreDoc, localDoc, idTipoDoc, idMuni) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssi", $cedulaDoc, $nombreDoc, $localDoc, $idTipoDoc, $idMuni);

        $this->assertTrue($stmt->execute());
    }

    // Test para leer todos los docentes
    public function testLeerDocentes() {
        $sql = "SELECT * FROM docente";
        $result = $this->conn->query($sql);
        $this->assertGreaterThan(0, $result->num_rows);
    }

    // Test para actualizar un docente
    public function testActualizarDocente() {
        $idDoc = 1; // Suponiendo que el docente con id 1 ya existe
        $cedulaDoc = "987654321";
        $nombreDoc = "Carlos García";
        $localDoc = "Localidad 2";
        $idTipoDoc = 2;
        $idMuni = 2;

        $sql = "UPDATE docente SET cedulaDoc = ?, nombreDoc = ?, localDoc = ?, idTipoDoc = ?, idMuni = ? WHERE idDoc = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssii", $cedulaDoc, $nombreDoc, $localDoc, $idTipoDoc, $idMuni, $idDoc);

        $this->assertTrue($stmt->execute());
    }

    // Test para eliminar un docente
    public function testEliminarDocente() {
        $idDoc = 1; // Suponiendo que el docente con id 1 ya existe
        $sql = "DELETE FROM docente WHERE idDoc = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idDoc);

        $this->assertTrue($stmt->execute());
    }

    protected function tearDown(): void {
        // Limpiar los recursos, si es necesario
        $this->conn->close();
    }
}
?>