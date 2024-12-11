<?php

use PHPUnit\Framework\TestCase;

class AutenticacionTest extends TestCase
{
    protected $conn;
    
    protected function setUp(): void
    {
        // Crear un mock de conexión para la base de datos
        $this->conn = $this->createMock(mysqli::class);
    }
    
    // Prueba de autenticación exitosa
    public function testAutenticacionExitosa()
    {
        // Configurar mock para simular un resultado exitoso
        $resultMock = $this->createMock(mysqli_result::class);
        $resultMock->method('num_rows')->willReturn(1);
        
        $stmtMock = $this->createMock(mysqli_stmt::class);
        $stmtMock->method('get_result')->willReturn($resultMock);
        
        $this->conn->method('prepare')->willReturn($stmtMock);
        
        // Simular datos de usuario válidos
        $_POST['username'] = 'usuario_valido';
        $_POST['password'] = 'contraseña_correcta';

        // Iniciar un buffer de salida
        ob_start();
        require 'Horarios_uv_Zarzal/autenticacion.php';
        ob_end_clean();
        
        // Verificar que la sesión se estableció correctamente
        $this->assertEquals('usuario_valido', $_SESSION['username']);
    }
    
    // Prueba de autenticación fallida
    public function testAutenticacionFallida()
    {
        // Configurar mock para simular un resultado vacío
        $resultMock = $this->createMock(mysqli_result::class);
        $resultMock->method('num_rows')->willReturn(0);
        
        $stmtMock = $this->createMock(mysqli_stmt::class);
        $stmtMock->method('get_result')->willReturn($resultMock);
        
        $this->conn->method('prepare')->willReturn($stmtMock);
        
        // Simular datos de usuario incorrectos
        $_POST['username'] = 'usuario_incorrecto';
        $_POST['password'] = 'contraseña_incorrecta';

        // Iniciar un buffer de salida
        ob_start();
        require 'Horarios_uv_Zarzal/autenticacion.php';
        $output = ob_get_clean();

        // Verificar si se muestra el mensaje de error
        $this->assertStringContainsString('Invalid username or password', $output);
    }
    
    // Prueba de datos vacíos
    public function testDatosVacios()
    {
        $_POST['username'] = '';
        $_POST['password'] = '';
        
        // Iniciar un buffer de salida
        ob_start();
        require 'Horarios_uv_Zarzal/autenticacion.php';
        $output = ob_get_clean();

        // Verificar si no hubo redirección a inicio.php
        $this->assertStringNotContainsString('Location: inicio.php', $output);
    }

    // Prueba de inyección SQL
    public function testInyeccionSQL()
    {
        $_POST['username'] = "' OR '1'='1";
        $_POST['password'] = "' OR '1'='1";

        // Configurar mock para simular un resultado vacío
        $resultMock = $this->createMock(mysqli_result::class);
        $resultMock->method('num_rows')->willReturn(0);

        $stmtMock = $this->createMock(mysqli_stmt::class);
        $stmtMock->method('get_result')->willReturn($resultMock);

        $this->conn->method('prepare')->willReturn($stmtMock);

        // Iniciar un buffer de salida
        ob_start();
        require 'Horarios_uv_Zarzal/autenticacion.php';
        $output = ob_get_clean();

        // Verificar que la inyección no tenga éxito
        $this->assertStringContainsString('Invalid username or password', $output);
    }
}

?>
