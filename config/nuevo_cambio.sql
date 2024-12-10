CREATE TABLE `programa` (
  `codProg` int(11) NOT NULL COMMENT 'Código del Programa Académico',
  `nombreProg` varchar(30) DEFAULT NULL COMMENT 'Nombre del Programa Académico',
  `descriProg` varchar(100) DEFAULT NULL COMMENT 'Descripción del Programa Académico',
  `SNIES` varchar(30) DEFAULT NULL,
  `jornada` varchar(30) DEFAULT NULL COMMENT 'Tipo de Jornada del Programa Académico',
  `idDocApoyo` int(11) DEFAULT NULL COMMENT 'Número de Identificación del Docente de Apoyo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CRETA TABLE 'salon' (
    'idSalon' int(11) PRIMARY KEY AUTO_INCREMENT COMMENT 'ID del salón',
    'codSalon' int(11) DEFAULT NULL COMMENT 'Código del salón',
    'capacidadSalon' int(11) DEFAULT NULL COMMENT 'Capacidad del salón',
    'tipoSalon' varchar(30) DEFAULT NULL COMMENT 'Tipo del salón'
    'sedeSalon' varchar(30) DEFAULT NULL COMMENT 'Sede del salón'

);