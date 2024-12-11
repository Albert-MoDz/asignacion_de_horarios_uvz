<?php

use PHPUnit\Framework\TestCase;

class AsignaturaTest extends TestCase
{
    protected $conn;
    
    protected function setUp(): void
    {
        // Crear un mock de la conexión a la base de datos
        $this->conn = $this->createMock(mysqli::class);
    }

    // Test para verificar si la asignatura se inserta correctamente
    public function testInsertAsignatura()
    {
        // Datos de prueba
        $_POST['codAsig'] = 'ASIG001';
        $_POST['nombreAsig'] = 'Matemáticas';
        $_POST['codInclu'] = 123;

        // Mock de la consulta de inserción
        $sql = "INSERT INTO asignatura (codAsig, nombreAsig, codInclu) VALUES ('ASIG001', 'Matemáticas', 123)";
        $this->conn->method('query')->willReturn(true);

        // Iniciar un buffer de salida
        ob_start();
        require 'Horarios_uv_Zarzal/asignatura.php'; // Requiere el archivo PHP
        ob_end_clean();

        // Verificar que la asignatura fue insertada
        $this->assertStringContainsString('Asignatura actualizada exitosamente.', ob_get_contents());
    }

    // Test para la actualización de asignatura
    public function testUpdateAsignatura()
    {
        // Simular valores de POST para actualizar una asignatura
        $_POST['idAsig'] = 1;
        $_POST['codAsig'] = 'ASIG002';
        $_POST['nombreAsig'] = 'Historia';
        $_POST['codInclu'] = 124;

        // Configurar mock para la actualización
        $stmtMock = $this->createMock(mysqli_stmt::class);
        $stmtMock->method('execute')->willReturn(true);

        $this->conn->method('prepare')->willReturn($stmtMock);

        // Iniciar un buffer de salida
        ob_start();
        require 'Horarios_uv_Zarzal/asignatura.php'; // Requiere el archivo PHP
        ob_end_clean();

        // Verificar que la asignatura fue actualizada
        $this->assertStringContainsString('Asignatura actualizada exitosamente.', ob_get_contents());
    }

    // Test para eliminar una asignatura
    public function testDeleteAsignatura()
    {
        $_GET['delete'] = 1;

        // Simular eliminación
        $stmtMock = $this->createMock(mysqli_stmt::class);
        $stmtMock->method('execute')->willReturn(true);
        
        $this->conn->method('prepare')->willReturn($stmtMock);

        // Iniciar un buffer de salida
        ob_start();
        require 'Horarios_uv_Zarzal/asignatura.php'; // Requiere el archivo PHP
        ob_end_clean();

        // Verificar que la asignatura fue eliminada
        $this->assertStringContainsString('Asignatura eliminada exitosamente.', ob_get_contents());
    }

    // Test para la búsqueda de asignaturas
    public function testSearchAsignaturas()
    {
        $_GET['search'] = 'Matemáticas';

        // Simulamos que la búsqueda devuelve resultados
        $searchQuery = "WHERE codAsig LIKE '%Matemáticas%' OR nombreAsig LIKE '%Matemáticas%' OR codInclu LIKE '%Matemáticas%'";
        $this->conn->method('query')->willReturn($searchQuery);

        // Iniciar un buffer de salida
        ob_start();
        require 'Horarios_uv_Zarzal/asignatura.php'; // Requiere el archivo PHP
        ob_end_clean();

        // Verificar que los resultados son los esperados
        $this->assertStringContainsString('Matemáticas', ob_get_contents());
    }

    // Test para la paginación de asignaturas
    public function testPaginationAsignaturas()
    {
        $_GET['page'] = 2;

        // Configurar paginación mock
        $totalPages = 5;
        $this->conn->method('query')->willReturn($totalPages);

        // Iniciar un buffer de salida
        ob_start();
        require 'Horarios_uv_Zarzal/asignatura.php'; // Requiere el archivo PHP
        ob_end_clean();

        // Verificar que los controles de paginación están presentes
        $this->assertStringContainsString('Siguiente', ob_get_contents());
    }
}
?>
