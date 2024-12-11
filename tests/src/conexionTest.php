<?php 

include "../config/conexion.php";

use PHPUnit\Framework\TestCase;

class ConexionTest extends TestCase  { 

    public function testConnection() {
        // Arrange
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "horarios";

        // true or false
        $expected = true; 

        // Act
        $conn = new mysqli($servername, $username, $password, $dbname); // Create connection
        $result = $conn->connect_error ? false : true;

        // Assert
        $this->assertEquals($expected, $result);

        if ($result) {
            $conn->close();
        }
        
    }
}



/*

vendor/bin/phpunit conexionTest.php
PHP Warning:  include(/../config/conexion.php): Failed to open stream: No such file or directory in /opt/lampp/htdocs/Horarios_uv_Zarzal/test/src/conexionTest.php on line 3
PHP Warning:  include(): Failed opening '/../config/conexion.php' for inclusion (include_path='.:') in /opt/lampp/htdocs/Horarios_uv_Zarzal/test/src/conexionTest.php on line 3
PHPUnit 9.6.21 by Sebastian Bergmann and contributors.

E                                                                   1 / 1 (100%)

Time: 00:00.022, Memory: 4.00 MB

There was 1 error:

1) ConexionTest::testConnection
mysqli_sql_exception: No such file or directory

/opt/lampp/htdocs/Horarios_uv_Zarzal/test/src/conexionTest.php:21

ERRORS!
Tests: 1, Assertions: 0, Errors: 1.

como los soluciono ese errror


*/

