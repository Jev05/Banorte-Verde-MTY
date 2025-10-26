-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-10-2025 a las 07:56:39
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `banorte`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conveniosservicios`
--

CREATE TABLE `conveniosservicios` (
  `id` int(11) NOT NULL,
  `institucion` varchar(100) NOT NULL,
  `nombre_corto` varchar(50) NOT NULL,
  `num_convenio` varchar(50) NOT NULL,
  `tipo_servicio` enum('Electricidad','Agua','Gas','Telecom','Transporte','Seguros','Viajes','Alimentos','Impuestos','TV-Cable','Transferencia') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `conveniosservicios`
--

INSERT INTO `conveniosservicios` (`id`, `institucion`, `nombre_corto`, `num_convenio`, `tipo_servicio`) VALUES
(1, 'Comisión Federal de Electricidad', 'CFE', '08870000100', 'Electricidad'),
(2, 'Agua y Drenaje\r\n', 'AYDM', '10000000001', 'Agua'),
(3, 'Gas ', 'GAS-NATURGY', '8000000025', 'Gas'),
(4, 'Teléfono', 'TELEFONO', '77712345', 'Telecom'),
(5, 'Seguros', 'GRUPO SEGUROS ', '0190000000', 'Seguros'),
(6, 'Viajes y turismos ', 'VIAJE ', '08870000101', 'Viajes'),
(7, 'Movilidad y Transporte', 'MOVILIDAD', '5000000001', 'Transporte'),
(8, 'TV', 'TV', '1010101010', 'Telecom'),
(9, 'Alimentos ', 'Alimentos ', '9000000005', 'Alimentos'),
(10, 'Impuestos ', 'Impuestos Mexico ', '8000000050', 'Impuestos'),
(23, 'Transferencia/deposito', 'Transferencia', '00225123', 'Transferencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ganancias`
--

CREATE TABLE `ganancias` (
  `id_g` int(11) NOT NULL,
  `ganancia` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ganancias`
--

INSERT INTO `ganancias` (`id_g`, `ganancia`) VALUES
(151, 105.75),
(154, 6.75),
(156, 0.75);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referencia`
--

CREATE TABLE `referencia` (
  `id` int(11) NOT NULL,
  `referenciaVal` varchar(30) NOT NULL,
  `convenio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `referencia`
--

INSERT INTO `referencia` (`id`, `referenciaVal`, `convenio_id`) VALUES
(42, '00012345678', 1),
(53, '012345678901', 2),
(54, '50011223344', 3),
(55, '900000000001', 4),
(56, '000000000005', 5),
(57, '123456789012', 6),
(58, '00000001234', 7),
(59, '1030053402', 8),
(60, '45623453456', 9),
(61, '999565653345', 10),
(62, '123456789', 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE `transacciones` (
  `id` int(11) NOT NULL,
  `emisor` int(11) NOT NULL,
  `remitente` int(11) NOT NULL,
  `tipo_movimiento` tinyint(1) NOT NULL,
  `fecha` date NOT NULL,
  `motivo` varchar(100) NOT NULL,
  `monto` double NOT NULL,
  `referencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transacciones`
--

INSERT INTO `transacciones` (`id`, `emisor`, `remitente`, `tipo_movimiento`, `fecha`, `motivo`, `monto`, `referencia`) VALUES
(1, 180, 219, 0, '2025-10-06', 'Pago mensual luz', 215.99, 42),
(2, 151, 152, 0, '2025-10-02', 'Pesos', 0.75, 54),
(4, 151, 152, 1, '2025-10-02', 'Pago alimentos', 51, 56),
(9, 151, 152, 0, '2025-10-23', 'prueba', 100, 62),
(11, 151, 151, 0, '2025-10-23', 'prueba', 100, 62),
(13, 151, 219, 0, '2025-10-25', 'CFE', 100, 62),
(14, 151, 219, 0, '2025-10-25', 'CFE', 500, 62),
(15, 151, 182, 0, '2025-10-25', 'Agua', 780, 62),
(16, 154, 151, 0, '2025-10-09', 'Por guapo', 500, 62),
(17, 154, 219, 0, '2025-10-25', 'CFE', 265, 62),
(18, 154, 151, 0, '2025-10-09', 'Por guapo', 500, 62),
(19, 154, 228, 0, '2025-10-25', 'Telmex', 100, 62),
(20, 154, 234, 0, '2025-10-25', 'Predial', 1562.65, 62),
(21, 151, 152, 0, '2025-10-03', 'nomas', 1000, 62),
(22, 151, 234, 0, '2025-10-25', 'Predial', 1756, 62),
(23, 151, 228, 0, '2025-10-25', 'Telmex', 500, 62),
(24, 151, 182, 0, '2025-10-25', 'Agua', 203, 62),
(25, 151, 219, 0, '2025-10-25', 'CFE', 200, 62),
(26, 151, 152, 0, '2025-10-03', 'Pago colegiatura', 1000, 62),
(27, 151, 219, 0, '2025-10-26', 'CFE', 517, 62),
(28, 151, 152, 0, '2025-10-24', 'Pago mensualidad', 150, 62),
(29, 151, 182, 0, '2025-10-26', 'Agua', 150, 62),
(30, 151, 152, 0, '2025-10-22', 'Frutas', 195, 62),
(31, 151, 219, 0, '2025-10-26', 'CFE', 480, 62),
(32, 151, 182, 0, '2025-10-26', 'Agua', 0, 62);

--
-- Disparadores `transacciones`
--
DELIMITER $$
CREATE TRIGGER `trg_actualizar_saldos` AFTER INSERT ON `transacciones` FOR EACH ROW BEGIN
    -- Si es egreso (tipo_movimiento = 0)
    IF NEW.tipo_movimiento = 0 THEN
        -- Restar al emisor
        UPDATE usuarios
        SET saldo = saldo - NEW.monto
        WHERE id = NEW.emisor;

        -- Sumar al remitente
        UPDATE usuarios
        SET saldo = saldo + NEW.monto
        WHERE id = NEW.remitente;
    
    -- Si es ingreso (tipo_movimiento = 1)
    ELSEIF NEW.tipo_movimiento = 1 THEN
        -- Sumar al emisor
        UPDATE usuarios
        SET saldo = saldo + NEW.monto
        WHERE id = NEW.emisor;

        -- Restar al remitente
        UPDATE usuarios
        SET saldo = saldo - NEW.monto
        WHERE id = NEW.remitente;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `Email` varchar(255) NOT NULL,
  `domicilio` varchar(255) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `nip` varchar(255) NOT NULL,
  `saldo` decimal(10,2) DEFAULT 0.00,
  `puntos` float DEFAULT 0,
  `nocuenta` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `fecha_nacimiento`, `Email`, `domicilio`, `usuario`, `nip`, `saldo`, `puntos`, `nocuenta`, `password`) VALUES
(151, 'Javier Castillo Peña', '1993-05-21', 'javi.castillo@email.com', 'Avenida del Sol 1122', 'javi.castillo', '7890', 1275.00, 5, '4523698574586214', '123456789'),
(152, 'Camila Ortiz Bravo', '2002-08-14', 'cami.ortiz@email.com', 'Calle Luna Nueva 3344', 'cami.ortiz', '1235', 3345.25, 0, '123456789101112', ''),
(153, 'Matias Serrano Gallardo', '1986-11-02', 'Matias Serrano Gallardo@email.com', 'epigmenio preciado 555', 'Matias Serrano Gallardo', '5679', 18000.00, 0, '', ''),
(154, 'Isabella Mora Luna', '1998-02-18', 'isa.mora@email.com', 'Paseo de los Cometas 7788', 'isa.mora', '9013', 772.60, 9, '565896587458', '1111'),
(155, 'Nicolas Juarez Nuñez', '1979-06-30', 'nico.juarez@email.com', 'Ronda Galaxia 9900', 'nico.juarez', '3457', 32000.60, 0, '', ''),
(156, 'Valeria Guzman Tapia', '1995-09-07', 'vale.guzman@email.com', 'Plaza Universo 1011', 'vale.guzman', '7891', 6800.00, 2.25, '', ''),
(157, 'Samuel Delgado Araya', '2004-04-12', 'samu.delgado@email.com', 'Alameda Cosmos 1213', 'samu.delgado', '2345', 1200.90, 0, '', ''),
(158, 'Daniela Paz Donoso', '1982-12-05', 'dani.paz@email.com', 'Gran Vía Láctea 1415', 'dani.paz', '6789', 29500.40, 0, '', ''),
(159, 'Benjamin Rios Solis', '1991-07-19', 'benja.rios@email.com', 'Cuesta del Big Bang 1617', 'benja.rios', '1234', 11000.75, 0, '', ''),
(160, 'Antonia Leon Valencia', '1997-10-03', 'anto.leon@email.com', 'Camino Nebulosa 1819', 'anto.leon', '5678', 5900.20, 0, '', ''),
(161, 'Joaquin Bustos Paredes', '2000-01-25', 'joaquin.b@email.com', 'Avenida Constelación 2021', 'joaquin.b', '9012', 3100.00, 0, '', ''),
(162, 'Luciana Lara Salazar', '1984-03-11', 'luci.lara@email.com', 'Calle Supernova 2223', 'luci.lara', '3456', 22000.50, 0, '', ''),
(163, 'Felipe Marin Vargas', '1996-08-08', 'felipe.marin@email.com', 'Boulevard Agujero Negro 2425', 'felipe.marin', '7890', 7300.80, 0, '', ''),
(164, 'Emilia Pereira Molina', '2003-05-16', 'emi.pereira@email.com', 'Paseo de los Planetas 2627', 'emi.pereira', '2345', 2500.40, 0, '', ''),
(165, 'Dante Cardenas Rios', '1980-10-29', 'dante.c@email.com', 'Ronda de los Asteroides 2829', 'dante.c', '6789', 45000.00, 0, '', ''),
(166, 'Victoria Vidal Navarro', '1992-04-01', 'vicky.vidal@email.com', 'Plaza de los Satélites 3031', 'vicky.vidal', '1234', 9500.60, 0, '', ''),
(167, 'Martin Parra Vega', '1999-11-22', 'martin.parra@email.com', 'Alameda de los Meteoritos 3233', 'martin.parra', '5678', 4800.15, 0, '', ''),
(168, 'Agustina Cortes Cordero', '1987-06-15', 'agus.cortes@email.com', 'Gran Vía del Espacio 3435', 'agus.cortes', '9012', 19800.90, 0, '', ''),
(169, 'Facundo Abanto Campos', '2001-09-09', 'facu.abanto@email.com', 'Cuesta del Tiempo 3637', 'facu.abanto', '3456', 3600.70, 0, '', ''),
(170, 'Renata Aguilar Silva', '1983-01-07', 'renata.a@email.com', 'Camino de la Gravedad 3839', 'renata.a', '7890', 26000.25, 0, '', ''),
(171, 'Bautista Alvarez Miranda', '1994-07-14', 'bauti.alvarez@email.com', 'Avenida de la Luz 4041', 'bauti.alvarez', '2345', 8200.00, 0, '', ''),
(172, 'Catalina Benitez Figueroa', '1990-03-02', 'cata.benitez@email.com', 'Calle de la Oscuridad 4243', 'cata.benitez', '6789', 14500.50, 0, '', ''),
(173, 'Lorenzo Blanco Acosta', '1981-08-20', 'lorenzo.b@email.com', 'Boulevard del Átomo 4445', 'lorenzo.b', '1234', 38000.80, 0, '', ''),
(174, 'Regina Cano Peña', '2005-02-11', 'regi.cano@email.com', 'Paseo de la Molécula 4647', 'regi.cano', '5678', 750.30, 0, '', ''),
(175, 'Francisco Chavez Bravo', '1996-12-08', 'fran.chavez@email.com', 'Ronda de la Célula 4849', 'fran.chavez', '9012', 6100.00, 0, '', ''),
(176, 'Alma Delgado Ponce', '1988-05-25', 'alma.delgado@email.com', 'Plaza del Neutrón 5051', 'alma.delgado', '3456', 17000.60, 0, '', ''),
(177, 'Bruno Duran Cabrera', '1993-10-18', 'bruno.duran@email.com', 'Alameda del Protón 5253', 'bruno.duran', '7890', 9000.90, 0, '', ''),
(178, 'Elena Espinoza Gallardo', '2002-06-03', 'elena.e@email.com', 'Gran Vía del Electrón 5455', 'elena.e', '2345', 2900.10, 0, '', ''),
(179, 'Gael Fernandez Luna', '1985-04-01', 'gael.f@email.com', 'Cuesta del Quark 5657', 'gael.f', '6789', 24000.40, 0, '', ''),
(180, 'Abril Galvan Nuñez', '1997-11-15', 'abril.galvan@email.com', 'Camino del Bosón 5859', 'abril.galvan', '1234', 5200.70, 0, '', ''),
(181, 'Ciro Gimenez Tapia', '1991-01-28', 'ciro.gimenez@email.com', 'Avenida del Fotón 6061', 'ciro.gimenez', '5678', 13000.00, 0, '', ''),
(182, 'agua y drenaje ', '2000-08-11', 'agua y drenaje @email.com', 'agua y drenaje ', 'agua y drenaje ', '9012', 4933.20, 0, '', ''),
(183, 'Jacobo Leon Donoso', '1986-09-22', 'jacobo.leon@email.com', 'Boulevard del Leptón 6465', 'jacobo.leon', '3456', 20500.50, 0, '', ''),
(184, 'Lola Lozano Solis', '1995-04-07', 'lola.lozano@email.com', 'Paseo del Muón 6667', 'lola.lozano', '7890', 6500.80, 0, '', ''),
(185, 'Malena Maldonado Valencia', '2004-02-14', 'male.m@email.com', 'Ronda del Tau 6869', 'male.m', '2345', 1500.30, 0, '', ''),
(186, 'Manuel Medina Bustos', '1989-07-03', 'manu.medina@email.com', 'Plaza del Neutrino 7071', 'manu.medina', '6789', 16000.00, 0, '', ''),
(187, 'Olivia Montoya Lara', '1998-12-27', 'oli.montoya@email.com', 'Alameda del Hadron 7273', 'oli.montoya', '1234', 5000.60, 0, '', ''),
(188, 'Pedro Nieto Marin', '1980-05-10', 'pedro.nieto@email.com', 'Gran Vía del Barión 7475', 'pedro.nieto', '5678', 35000.90, 0, '', ''),
(189, 'Sara Pascual Pereira', '2001-10-01', 'sara.pascual@email.com', 'Cuesta del Mesón 7677', 'sara.pascual', '9012', 3300.15, 0, '', ''),
(190, 'Simon Quintana Cardenas', '1987-03-20', 'simon.q@email.com', 'Camino del Pion 7879', 'simon.q', '3456', 18500.40, 0, '', ''),
(191, 'Uma Roldan Vidal', '1994-06-13', 'uma.roldan@email.com', 'Avenida del Kaon 8081', 'uma.roldan', '7890', 7900.70, 0, '', ''),
(192, 'Vito Saez Parra', '1992-09-04', 'vito.saez@email.com', 'Calle del Eta 8283', 'vito.saez', '2345', 10500.20, 0, '', ''),
(193, 'Alexia Santos Cortes', '1984-11-19', 'alexia.s@email.com', 'Boulevard del Omega 8485', 'alexia.s', '6789', 23000.00, 0, '', ''),
(194, 'Bastian Guerrero Abanto', '2003-03-28', 'bastian.g@email.com', 'Paseo del Sigma 8687', 'bastian.g', '1234', 2100.55, 0, '', ''),
(195, 'Cayetana Salazar Aguilar', '1999-01-02', 'caye.salazar@email.com', 'Ronda del Delta 8889', 'caye.salazar', '5678', 4500.80, 0, '', ''),
(196, 'Dionisio Castillo Alvarez', '1982-08-18', 'dioni.c@email.com', 'Plaza del Lambda 9091', 'dioni.c', '9012', 28000.30, 0, '', ''),
(197, 'Elsa Paredes Benitez', '1993-02-09', 'elsa.paredes@email.com', 'Alameda del Xi 9293', 'elsa.paredes', '3456', 9200.60, 0, '', ''),
(198, 'Fabrizio Vargas Blanco', '2000-07-23', 'fabri.vargas@email.com', 'Gran Vía del Núcleo 9495', 'fabri.vargas', '7890', 3900.00, 0, '', ''),
(199, 'Gala Molina Cano', '1986-04-06', 'gala.molina@email.com', 'Cuesta del Isótopo 9697', 'gala.molina', '2345', 20000.70, 0, '', ''),
(200, 'Hernan Cordero Chavez', '1995-11-11', 'hernan.c@email.com', 'Camino del Ión 9899', 'hernan.c', '6789', 6700.10, 0, '', ''),
(201, 'India Campos Delgado', '1990-06-29', 'india.campos@email.com', 'Avenida del Catión 1110', 'india.campos', '1234', 15000.40, 0, '', ''),
(202, 'Jano Silva Duran', '2004-09-17', 'jano.silva@email.com', 'Calle del Anión 1312', 'jano.silva', '5678', 1800.95, 0, '', ''),
(203, 'Kira Miranda Espinoza', '1983-12-12', 'kira.miranda@email.com', 'Boulevard del Plasma 1514', 'kira.miranda', '9012', 26500.00, 0, '', ''),
(204, 'Lian Figueroa Fernandez', '1997-02-24', 'lian.f@email.com', 'Paseo del Gas 1716', 'lian.f', '3456', 5800.30, 0, '', ''),
(205, 'Mora Acosta Galvan', '1991-05-03', 'mora.acosta@email.com', 'Ronda del Líquido 1918', 'mora.acosta', '7890', 11500.60, 0, '', ''),
(206, 'Nael Peña Gimenez', '1985-10-15', 'nael.peña@email.com', 'Plaza del Sólido 2120', 'nael.peña', '2345', 21500.90, 0, '', ''),
(208, 'Rocco Ponce Leon', '1998-08-27', 'rocco.ponce@email.com', 'Gran Vía del Metal 2524', 'rocco.ponce', '1234', 4900.50, 0, '', ''),
(209, 'Sasha Cabrera Lozano', '1988-06-05', 'sasha.cabrera@email.com', 'Cuesta del Polímero 2726', 'sasha.cabrera', '5678', 17500.80, 0, '', ''),
(210, 'Teo Gallardo Maldonado', '1994-03-19', 'teo.gallardo@email.com', 'Camino del Compuesto 2928', 'teo.gallardo', '9012', 8400.10, 0, '', ''),
(211, 'Uriel Luna Medina', '2001-04-23', 'uriel.luna@email.com', 'Avenida de la Mezcla 3130', 'uriel.luna', '3456', 4100.40, 0, '', ''),
(212, 'Zyan Nuñez Montoya', '1981-11-08', 'zyan.nuñez@email.com', 'Calle de la Solución 3332', 'zyan.nuñez', '7890', 33000.70, 0, '', ''),
(213, 'Ambar Tapia Nieto', '1999-07-07', 'ambar.tapia@email.com', 'Boulevard del Solvente 3534', 'ambar.tapia', '2345', 4300.90, 0, '', ''),
(214, 'Camilo Araya Pascual', '1992-09-13', 'camilo.araya@email.com', 'Paseo del Soluto 3736', 'camilo.araya', '6789', 10000.00, 0, '', ''),
(215, 'Ginebra Donoso Quintana', '1987-01-26', 'gin.donoso@email.com', 'Ronda de la Aleación 3938', 'gin.donoso', '1234', 19000.20, 0, '', ''),
(216, 'Izan Solis Roldan', '2005-05-04', 'izan.solis@email.com', 'Plaza del Coloide 4140', 'izan.solis', '5678', 950.80, 0, '', ''),
(217, 'Liam Valencia Saez', '1989-10-11', 'liam.valencia@email.com', 'Alameda de la Suspensión 4342', 'liam.valencia', '9012', 16500.50, 0, '', ''),
(218, 'Noah Bustos Garcia', '1996-06-06', 'noah.bustos@email.com', 'Gran Vía de la Emulsión 4544', 'noah.bustos', '3456', 7000.30, 0, '', ''),
(219, 'servicio de electricidad ', '1984-08-16', 'servicio de electricidad @email.com', 'servicio de electricidad ', 'servicio de electricidad ', '7890', 24562.60, 0, '', ''),
(220, 'Thiago Marin Martinez', '2002-11-30', 'thiago.m@email.com', 'Camino del Gel 4948', 'thiago.m', '2345', 2950.10, 0, '', ''),
(221, 'Valentina Pereira Hernandez', '1993-04-09', 'vale.pereira@email.com', 'Avenida de la Espuma 5150', 'vale.pereira', '6789', 8800.40, 0, '', ''),
(222, 'Benjamin Cardenas Lopez', '1981-02-19', 'benja.cardenas@email.com', 'Calle del Fuego 5352', 'benja.cardenas', '1234', 31000.90, 0, '', ''),
(228, 'servicio telefono', '0000-00-00', 'serviciotel@gmail.com', '', 'telefono', '', 600.00, 0, '', ''),
(229, 'servicio internet', '0000-00-00', '', '', '', '', 0.00, 0, '', ''),
(234, 'servicio predial', '0000-00-00', '', '', 'servicio predial', '', 3318.65, 0, '', '');

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `trg_after_update_puntos` BEFORE UPDATE ON `usuarios` FOR EACH ROW BEGIN
    DECLARE diferencia DECIMAL(10,2);
    DECLARE puntos_banorte DECIMAL(10,2);
    DECLARE existe INT;

    -- Solo actuar si los puntos aumentan
    IF NEW.puntos > OLD.puntos THEN
        SET diferencia = NEW.puntos - OLD.puntos;
        SET puntos_banorte = diferencia * 0.25;

        -- Solo el 75 % queda en el usuario
        SET NEW.puntos = OLD.puntos + (diferencia * 0.75);

        -- Verificar si existe un registro de ese usuario en Banorte
        SELECT COUNT(*) INTO existe
        FROM ganancias
        WHERE id_g = OLD.id;

        -- Si no existe, crearlo
        IF existe = 0 THEN
            INSERT INTO ganancias (id_g, ganancia)
            VALUES (OLD.id, puntos_banorte);
        ELSE
            -- Si ya existe, solo actualizar su ganancia
            UPDATE ganancias
            SET ganancia = ganancia + puntos_banorte
            WHERE id_g = OLD.id;
        END IF;
    END IF;
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `conveniosservicios`
--
ALTER TABLE `conveniosservicios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `institucion` (`institucion`);

--
-- Indices de la tabla `ganancias`
--
ALTER TABLE `ganancias`
  ADD PRIMARY KEY (`id_g`);

--
-- Indices de la tabla `referencia`
--
ALTER TABLE `referencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `convenio_id` (`convenio_id`);

--
-- Indices de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emisor` (`emisor`),
  ADD KEY `referencia` (`referencia`),
  ADD KEY `remitente` (`remitente`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `conveniosservicios`
--
ALTER TABLE `conveniosservicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `ganancias`
--
ALTER TABLE `ganancias`
  MODIFY `id_g` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT de la tabla `referencia`
--
ALTER TABLE `referencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `referencia`
--
ALTER TABLE `referencia`
  ADD CONSTRAINT `convenio_id` FOREIGN KEY (`convenio_id`) REFERENCES `conveniosservicios` (`id`);

--
-- Filtros para la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD CONSTRAINT `emisor` FOREIGN KEY (`emisor`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `referencia` FOREIGN KEY (`referencia`) REFERENCES `referencia` (`id`),
  ADD CONSTRAINT `remitente` FOREIGN KEY (`remitente`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
