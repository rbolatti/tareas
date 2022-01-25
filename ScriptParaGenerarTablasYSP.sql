-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Servidor: db747997577.db.1and1.com
-- Tiempo de generación: 09-09-2018 a las 22:34:51
-- Versión del servidor: 5.5.60-0+deb7u1-log
-- Versión de PHP: 5.4.45-0+deb7u14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `db747997577`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`dbo747997577`@`%` PROCEDURE `GenerarTarea`()
BEGIN
DECLARE done BOOLEAN DEFAULT FALSE;
DECLARE id2 varchar(150);
DECLARE Asignador2 varchar(150);
DECLARE TituloTarea2 varchar(150);
DECLARE Descripcion2 varchar(150);
DECLARE Asignado2 varchar(150);
DECLARE FechaDeProximoEvento2 varchar(150);
DECLARE Frecuencia2 varchar(150);
-- SELECCIONA LAS TAREAS A CREARSE EL DIA SIGUIENTE (LAS TAREAS PROGRAMAS SE GENERAN UN DIA ANTES DE ESTIPULADO)

DECLARE c1 cursor for SELECT id,Asignador,TituloTarea,Descripcion,Asignado,FechaDeProximoEvento,Frecuencia FROM `tareasprogramadas` WHERE FechaDeProximoEvento=DATE_ADD(curdate() , INTERVAL 1 DAY) 
AND Finalizada='No';

DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = TRUE;
open c1;
c1_loop: LOOP
fetch c1 into id2,Asignador2,TituloTarea2,Descripcion2,Asignado2,FechaDeProximoEvento2,Frecuencia2;
        IF `done` THEN LEAVE c1_loop; END IF;
        INSERT INTO `tareascargadas` (Fecha, Asignador, TituloTarea, Descripcion, Asignado, FechaLimite, Vencida,Terminada) VALUES (NOW(), Asignador2, TituloTarea2,Descripcion2,Asignado2,FechaDeProximoEvento2,'0','0');
        IF Frecuencia2='Un solo evento' THEN
          UPDATE `tareasprogramadas` SET Finalizada='Si' WHERE id=id2;
        END IF;
        IF Frecuencia2='Diaria' THEN
          UPDATE `tareasprogramadas` SET FechaDeProximoEvento=(DATE_ADD(FechaDeProximoEvento2,INTERVAL 1 DAY)) WHERE id=id2;
        END IF;
        IF Frecuencia2='Semanal' THEN
          UPDATE `tareasprogramadas` SET FechaDeProximoEvento=(DATE_ADD(FechaDeProximoEvento2,INTERVAL 7 DAY)) WHERE id=id2;
        END IF;
        IF Frecuencia2='Mensual' THEN
          UPDATE `tareasprogramadas` SET FechaDeProximoEvento=(DATE_ADD(FechaDeProximoEvento2,INTERVAL 1 MONTH)) WHERE id=id2;
        END IF;

        IF Frecuencia2='Quincenal' THEN
          UPDATE `tareasprogramadas` SET FechaDeProximoEvento=(DATE_ADD(FechaDeProximoEvento2,INTERVAL 14 DAY)) WHERE id=id2;
        END IF;

        IF Frecuencia2='Anual' THEN
          UPDATE `tareasprogramadas` SET FechaDeProximoEvento=(DATE_ADD(FechaDeProximoEvento2,INTERVAL 1 YEAR)) WHERE id=id2;
        END IF;



END LOOP c1_loop;
CLOSE c1;
END$$

CREATE DEFINER=`dbo747997577`@`%` PROCEDURE `TareasVencidas`()
BEGIN
DECLARE done BOOLEAN DEFAULT FALSE;
DECLARE id2 varchar(150);
DECLARE Fecha2 varchar(150);
DECLARE Asignador2 varchar(150);
DECLARE TituloTarea2 varchar(150);
DECLARE Descripcion2 text;
DECLARE Asignado2 varchar(150);
DECLARE FechaLimite2 varchar(150);
DECLARE Vencida2 varchar(150);
DECLARE Terminada2 varchar(150);
DECLARE FechaDeTermino2 varchar(150);
DECLARE Adjunto2 varchar(150);

DECLARE c1 cursor for SELECT id,Fecha,Asignador,TituloTarea,Descripcion,Asignado,FechaLimite,Vencida,Terminada,FechaDeTermino,Adjunto FROM `tareascargadas` WHERE FechaLimite < curdate() AND Vencida='0' and Terminada='0';
DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = TRUE;
open c1;
c1_loop: LOOP
fetch c1 into id2,Fecha2,Asignador2,TituloTarea2,Descripcion2,Asignado2,FechaLimite2,Vencida2,Terminada2,FechaDeTermino2,Adjunto2 ;
        IF `done` THEN LEAVE c1_loop; END IF;
       
          UPDATE `tareascargadas` SET Vencida='1' WHERE id=id2;
        
END LOOP c1_loop;
CLOSE c1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE IF NOT EXISTS `equipos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Responsable` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `Usuario`, `Responsable`) VALUES
(8, 'JOHANA DE LA PAZ MORENO RIVERA', 'GLORIA ANGELICA MARTINEZ ORTIZ'),
(9, 'GLORIA ANGELICA MARTINEZ ORTIZ', 'EDUARDO ESPINO MARMOLEJO'),
(10, 'EDUARDO ESPINO MARMOLEJO', 'SERGIO ALEJANDRO PAZ HOLGUIN'),
(11, 'ARIANA PATRICIA RUIZ HERNANDEZ', 'GLORIA ANGELICA MARTINEZ ORTIZ'),
(12, 'SERGIO ALEJANDRO PAZ HOLGUIN', 'EDUARDO ESPINO MARMOLEJO'),
(13, 'EMMA ELIZABETH URIAS MICHEL', 'EDUARDO ESPINO MARMOLEJO'),
(14, 'RUTH MELISSA ESTRADA RODRIGUEZ', 'EMMA ELIZABETH URIAS MICHEL'),
(15, 'RUTH MELISSA ESTRADA RODRIGUEZ', 'EDUARDO ESPINO MARMOLEJO'),
(16, 'JOHANA DE LA PAZ MORENO RIVERA', 'EDUARDO ESPINO MARMOLEJO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareascargadas`
--

CREATE TABLE IF NOT EXISTS `tareascargadas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` datetime DEFAULT NULL,
  `Asignador` varchar(150) DEFAULT NULL,
  `TituloTarea` text,
  `Descripcion` text,
  `Asignado` varchar(150) DEFAULT NULL,
  `FechaLimite` text,
  `Vencida` int(10) DEFAULT NULL,
  `Terminada` int(2) DEFAULT NULL,
  `FechaDeTermino` datetime DEFAULT NULL,
  `Adjunto` varchar(350) DEFAULT NULL,
  `ComentarioDeCierre` text NOT NULL,
  `EvidenciaDeCierreAdjunto` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=127 ;

--
-- Volcado de datos para la tabla `tareascargadas`
--

INSERT INTO `tareascargadas` (`id`, `Fecha`, `Asignador`, `TituloTarea`, `Descripcion`, `Asignado`, `FechaLimite`, `Vencida`, `Terminada`, `FechaDeTermino`, `Adjunto`, `ComentarioDeCierre`, `EvidenciaDeCierreAdjunto`) VALUES
(22, '2018-08-16 12:39:59', 'pazs', 'contactos de emergencia', 'Cargar contactos de emergencia en kiosko', 'pazs', '2018-08-16', 0, 1, '2018-08-16 19:26:53', '', '', ''),
(23, '2018-08-16 12:40:46', 'pazs', 'cambios de turno', 'Generar reporte de cambios de turno e imprimirlo y pasarselo a melissa.', 'pazs', '2018-08-16', 0, 1, '2018-08-16 17:04:28', '', '', ''),
(25, '2018-08-16 13:14:24', 'pazs', 'Entrenamiento', 'Entrenar a melissa y emma para editar el clasificado, preguntar a lalo sobre el template.', 'pazs', '2018-08-16', 0, 1, '2018-08-20 21:07:34', '', '', ''),
(35, '2018-08-16 20:03:20', 'pazs', 'Incapacidades', 'Realizar modificaciones en el correo de notificaciÃ³n de incapacidad cuando el empleado sea un indirecto y la incapacidad se capturada en lunes, solo agregar a Edgar y Vale en la lista de distribucion para este caso.', 'pazs', '2018-08-17', 0, 1, '2018-08-21 19:28:55', '', '', ''),
(37, '2018-08-17 12:19:24', 'pazs', 'MRO', 'Solicitar 1 paquete de bolsas para MRO', 'pazs', '2018-08-23', 0, 1, '2018-08-30 12:35:56', '', '', ''),
(38, '2018-08-17 19:31:13', 'pazs', 'MRO', 'Solicitar guantes a SM y pegatinas en papeleria.', 'pazs', '2018-08-21', 0, 1, '2018-08-30 16:43:10', '', '', ''),
(39, '2018-08-17 20:01:13', 'pazs', 'contactos de emergencia', 'Enviar a Lalo reporte como lo pidio Bhawani para que corpo cargue los contactos de manera masiva en EC.', 'pazs', '2018-08-20', 0, 1, '2018-08-20 14:03:03', '', '', ''),
(40, '2018-08-20 14:02:47', 'pazs', 'Contactos', 'Recordar a Lalo este lunes sobre la acciÃ³n a tomar para capturar el telÃ©fono de contacto de la gente.', 'pazs', 'NA', 0, 1, '2018-08-20 14:03:20', NULL, '', ''),
(42, '2018-08-20 14:06:10', 'pazs', 'Auditoria cambio de turno', 'Auditar 10 expedientes y generar reporte con empleado fecha de movimiento y en un pivote los supervisores involucrados.', 'pazs', '2018-08-20', 0, 1, '2018-08-21 12:31:43', '', '', ''),
(43, '2018-08-20 19:02:53', 'pazs', 'Auditoria de presencia', 'Buscar los expedientes faltantes 453344, 831034, 7003520, 7010242', 'pazs', '2018-08-31', 1, 1, '2018-09-03 11:58:28', '', '', ''),
(45, '2018-08-21 12:31:37', 'pazs', 'Vacaciones', 'Hacer saldo', 'pazs', '2018-08-21', 0, 1, '2018-08-21 14:49:02', '', '', ''),
(46, '2018-08-21 15:33:43', 'pazs', 'HR Central CDMX', 'Enviar a Jose luis el proyecto de HR Central', 'pazs', '2018-08-22', 0, 1, '2018-08-28 11:53:43', '', '', ''),
(47, '2018-08-21 18:51:14', 'pazs', 'Ingresos', 'NT y CURP a Oyuki', 'pazs', '2018-08-21', 0, 1, '2018-08-21 19:07:07', '', '', ''),
(48, '2018-08-21 20:03:45', 'pazs', 'Desarrollo IqorQoins', 'Implementar restriccion a vales de gasolina limitar a 4 por mes por empleado.', 'pazs', '2018-08-24', 0, 1, '2018-08-28 09:06:40', '', '', ''),
(49, '2018-08-22 13:44:17', 'pazs', 'SF', 'Ir con Martin para entrenarlo con cambios de turno', 'pazs', '2018-08-22', 0, 1, '2018-08-23 15:06:23', '', '', ''),
(50, '2018-08-23 12:57:25', 'pazs', 'Notificaciones cambio de turno', 'Correo en individual a los supervisores para cambio de turno.', 'pazs', '2018-08-23', 0, 1, '2018-08-24 20:18:04', '', '', ''),
(51, '2018-08-23 12:58:21', 'pazs', 'Veraneada', 'Notificar a supervisores deposito de casetas.', 'pazs', '2018-08-23', 0, 1, '2018-08-23 17:26:07', '', '', ''),
(52, '2018-08-24 20:19:44', 'pazs', 'Limpia tu closet', 'Capturar en presentacion lo investigado en Albergues', 'pazs', '2018-08-24', 1, 1, '2018-09-03 11:58:33', '', '', ''),
(53, '2018-08-25 12:12:47', 'pazs', 'CDMX Marcajes', 'Escanear a Edgar el pago de 1&1', 'pazs', '2018-08-27', 0, 1, '2018-08-28 11:53:38', '', '', ''),
(59, '2018-08-27 08:09:09', 'pazs', 'HR Central ', 'Revisar cÃ³digo de mÃ³dulo de incidentes/accidentes', 'pazs', '2018-08-27', 0, 1, '2018-08-28 11:53:30', '', '', ''),
(60, '2018-08-27 18:08:13', 'pazs', 'Facilicites report', 'Reporte a facilities de accidentes x correo en automatico.', 'pazs', '2018-09-10', 0, 0, NULL, '', '', ''),
(61, '2018-08-28 01:24:52', 'pazs', 'Badges', 'Cambiar badge ids.', 'pazs', 'Diaria', 0, 1, '2018-08-29 10:35:03', NULL, '', ''),
(62, '2018-08-28 08:54:17', 'pazs', 'cambios de turno', 'Correo recordando a los que faltan de enregar cambios de turno.', 'pazs', '2018-08-28', 0, 1, '2018-08-29 12:51:06', '', '', ''),
(63, '2018-08-28 09:17:28', 'pazs', 'Reporte de vacaciones', 'Reporte con vacaciones de 420 421 422 de color.', 'pazs', '2018-08-29', 0, 1, '2018-08-29 10:35:08', '', '', ''),
(64, '2018-08-28 10:02:57', 'pazs', 'Hosting', 'Verificar que se realice deposito a Eduardo de 1&1 por parte de Reynosa', 'pazs', '2018-09-07', 1, 1, '2018-09-08 23:23:41', '', '', ''),
(65, '2018-08-29 00:38:24', 'pazs', 'Badges', 'Cambiar badge ids.', 'pazs', 'Diaria', 0, 1, '2018-08-30 12:35:39', NULL, '', ''),
(66, '2018-08-29 16:53:40', 'pazs', 'INE', 'Crear mÃ³dulo en HR Central que permita cargar las INEs en el folder \\chh1wprdwebap02Web SitesITHRCentralInformationAnteproyectoADatos', 'pazs', '2018-08-30', 1, 1, '2018-09-03 18:16:07', '', '', ''),
(67, '2018-08-30 12:39:44', 'pazs', 'Junta Lalo', 'Recrdar a Lalo sobre la asigacion de que constancias laborales se entregaran en bodega y que contrataciorealizaar el actalizacvio deconstancias y referencias.', 'pazs', '2018-08-31', 1, 1, '2018-09-03 11:58:14', '', '', ''),
(68, '2018-08-30 16:46:22', 'pazs', 'IqorQoins', 'Enviar a Lalo todos los puntos de IqorQoins 2da fase. preguntar a Emma.', 'pazs', '2018-09-04', 1, 0, NULL, '', '', ''),
(69, '2018-08-30 17:02:23', 'pazs', 'Vacaciones', 'Correo a los supervisores indicando que la entrega de vacaciones y pcg en fÃ­sico solo se aceptan hasta las 5pm del lunes.', 'pazs', '2018-08-31', 1, 1, '2018-09-03 11:58:01', '', '', ''),
(70, '2018-08-30 17:18:48', 'pazs', 'Permuta', 'Entregar a gloria hoja de permuta', 'pazs', '2018-08-31', 1, 1, '2018-09-03 11:58:04', '', '', ''),
(71, '2018-08-31 08:21:27', 'pazs', 'Badges', 'Cambiar badge ids.', 'pazs', 'Diaria', 0, 1, '2018-09-01 14:32:53', NULL, '', ''),
(72, '2018-09-01 13:42:11', 'pazs', 'Badges', 'Cambiar badge ids.', 'pazs', 'Diaria', 1, 1, '2018-09-02 23:01:03', NULL, '', ''),
(75, '2018-09-02 23:05:30', 'pazs', 'Badges', 'Cambiar badge IDs', 'pazs', '2018-09-04', 0, 1, '2018-09-04 23:17:59', NULL, '', ''),
(76, '2018-09-03 08:16:45', 'pazs', 'Correo a reynosa', 'Enviar correo a reynosa con el conteo de personal DL en CUU.', 'pazs', '2018-09-04', 0, 1, '2018-09-03 21:54:41', NULL, '', ''),
(77, '2018-09-03 08:52:23', 'pazs', 'Desarrollo HRCentral', 'Actualizar las ppts de los beneficios y activar botÃ³n.', 'pazs', '2018-09-03', 1, 1, '2018-09-09 19:23:26', '', '', ''),
(78, '2018-09-03 11:13:21', 'pazs', 'Desarrollo HRCentral', 'Reporte a Yolibeth para metricos, debe jalar la informaciÃ³n de los reportes de ausentismo y de las incapacidades este reporte se ejecutarÃ¡ mediante un boton despues de actualizar los reportes de laborales.', 'pazs', '2018-09-04', 1, 1, '2018-09-09 12:07:13', '1535994801.JPG', 'El botÃ³n se implementa en representantes en el modulo de laborales.', ''),
(79, '2018-09-03 23:13:53', 'pazs', 'Badges', 'Cambiar badge IDs', 'pazs', '2018-09-05', 0, 1, '2018-09-04 23:17:38', NULL, 'Listo', ''),
(80, '2018-09-03 23:13:53', 'pazs', 'Correo a reynosa', 'Enviar correo a reynosa con el conteo de personal DL en CUU.', 'pazs', '2018-09-05', 0, 1, '2018-09-04 23:43:24', NULL, 'YA QUEDO.', '1536126204.js'),
(83, '2018-09-05 09:16:44', 'pazs', 'Badges', 'Cambiar badge IDs', 'pazs', '2018-09-06', 0, 1, '2018-09-06 10:24:34', NULL, '', ''),
(84, '2018-09-05 09:16:44', 'pazs', 'Correo a reynosa', 'Enviar correo a reynosa con el conteo de personal DL en CUU.', 'pazs', '2018-09-06', 0, 1, '2018-09-05 09:18:35', NULL, 'Se elimina tarea', '1536160715.xlsx'),
(85, '2018-09-05 09:55:46', 'pazs', 'SF', 'Enviar correo indicando que deben reseleccionar el turno para corregir las working hours.', 'pazs', '2018-09-05', 0, 1, '2018-09-05 11:15:50', '', '', ''),
(86, '2018-09-05 15:36:41', 'pazs', 'LimpiaTuCloset', 'Correo a Oscar Armendariz indicando que carguen la ropa un dia antes y la divisiÃ³n.', 'pazs', '2018-09-06', 0, 1, '2018-09-06 08:32:39', '', '', ''),
(87, '2018-09-05 17:45:38', 'pazs', 'Junta', 'Poner junta a monica, lalo, emma para entrenamiento en SF por movimientos incorrectos.', 'pazs', '2018-09-06', 1, 0, NULL, '', '', ''),
(88, '2018-09-05 18:12:00', 'pazs', 'sap', 'Esta bien que use domestic parther en SAP para alguien que no esta casado', 'pazs', '2018-09-06', 0, 1, '2018-09-05 22:31:07', '', '', ''),
(91, '2018-09-05 23:41:40', 'pazs', '111', '1111', 'pazs', '2018-09-05', 0, 1, '2018-09-05 23:41:53', '', '2222', ''),
(92, '2018-09-05 23:43:44', 'pazs', '222', '2222', 'pazs', '2018-09-05', 0, 1, '2018-09-05 23:44:28', '', '33333', ''),
(93, '2018-09-05 23:46:37', 'pazs', '5555', '5555', 'pazs', '2018-09-05', 0, 1, '2018-09-05 23:46:47', '', '5555', ''),
(95, '2018-09-05 23:49:57', 'pazs', 'test2', 'test2', 'ESPINOED', '2018-09-05', 0, 1, '2018-09-05 23:50:43', '', 'yaquedo', ''),
(96, '2018-09-05 23:52:25', 'ESPINOED', 'zzzz', 'zzz', 'ESPINOED', '2018-09-07', 0, 1, '2018-09-05 23:52:38', '', 'zzz2', ''),
(97, '2018-09-05 23:52:58', 'ESPINOED', 'x1', 'x11', 'ESPINOED', '2018-09-12', 0, 1, '2018-09-05 23:53:05', '', '', ''),
(99, '2018-09-05 23:54:34', 'ESPINOED', 'q1', 'q11', 'pazs', '2018-09-05', 0, 1, '2018-09-05 23:55:16', '', 'q1x', ''),
(100, '2018-09-06 00:04:16', 'pazs', 'ggg', 'gggg', 'ESPINOED', '2018-09-06', 0, 1, '2018-09-06 00:05:30', '', 'gggg', ''),
(101, '2018-09-06 00:04:33', 'pazs', 'hhhh', 'hhh', 'pazs', '2018-09-06', 0, 1, '2018-09-06 00:05:55', '', 'hhhhhhhhhh', ''),
(102, '2018-09-06 08:32:15', 'pazs', 'Badges', 'Cambiar badge IDs', 'pazs', '2018-09-07', 1, 1, '2018-09-08 10:19:34', NULL, '', ''),
(103, '2018-09-06 08:32:15', 'pazs', 'Correo a reynosa', 'Enviar correo a reynosa con el conteo de personal DL en CUU.', 'pazs', '2018-09-07', 0, 1, '2018-09-06 10:24:26', NULL, '', ''),
(104, '2018-09-06 11:15:51', 'pazs', 'kronos', 'Revisar este viernes que 7005547 MARTIN ESPINO SAENZ que en kronos ya este en segundo turno y le confirmas a Meny rivero.', 'pazs', '2018-09-06', 1, 1, '2018-09-07 18:24:00', '', '', ''),
(105, '2018-09-06 16:39:23', 'pazs', 'Desarrollo HRCentral', 'Subir nuevo manual de requisiones a HR Central y la pptx', 'pazs', '2018-09-07', 1, 1, '2018-09-09 12:19:02', '', 'Se carga en HR Central nueva versiÃ³n', ''),
(106, '2018-09-07 00:05:59', 'pazs', 'Badges', 'Cambiar badge IDs', 'pazs', '2018-09-08', 0, 1, '2018-09-07 18:10:28', NULL, '', ''),
(107, '2018-09-07 00:05:59', 'pazs', 'Correo a reynosa', 'Enviar correo a reynosa con el conteo de personal DL en CUU.', 'pazs', '2018-09-08', 0, 1, '2018-09-07 18:10:25', NULL, '', ''),
(108, '2018-09-07 13:51:09', 'pazs', '', 'SUSANA BERENICE HERNANDEZ ARAGON carta para el lunes 12pm', 'pazs', '2018-09-07', 1, 0, NULL, '', '', ''),
(109, '2018-09-07 15:44:12', 'pazs', 'gafete', '8009061 TARIN ACOSTA, GABRIE. comenta que su gafete no checa kronos ni torniquetes en la noche. avisar a Jesus decanini y daniela moreno.', 'pazs', '2018-09-07', 1, 0, NULL, '', '', ''),
(110, '2018-09-07 18:24:47', 'pazs', '', '7011703 y 8013258 se renovo con fecha del 10 pero hoy vence su contrato', 'pazs', '2018-09-10', 0, 1, '2018-09-08 10:00:05', '', 'No se dieron de baja.', ''),
(111, '2018-09-07 23:14:19', 'pazs', 'Badges', 'Cambiar badge IDs', 'pazs', '2018-09-09', 0, 1, '2018-09-08 10:18:47', NULL, '', ''),
(122, '2018-09-08 23:24:08', 'pazs', 'asx', 'asxasx', 'ESPINOED', '2018-08-10', 0, 1, '2018-09-08 23:24:20', '', '', ''),
(125, '2018-09-09 09:01:08', 'pazs', 'SR', 'Acceso para la nueva de laborales a la ruta I:DirecTVHRLABORALES levantar caso este 10 de sept. 8am', 'pazs', '2018-09-10', 0, 0, NULL, NULL, '', ''),
(126, '2018-09-09 09:01:08', 'pazs', '', 'Pasar a nominas por la copia de la correcciÃ³n de Jesus villa 168451 OLGA ALICIA BANDA PONCE', 'pazs', '2018-09-10', 0, 0, NULL, NULL, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareascargadaseliminadas`
--

CREATE TABLE IF NOT EXISTS `tareascargadaseliminadas` (
  `id` int(11) NOT NULL,
  `Fecha` datetime DEFAULT NULL,
  `Asignador` varchar(150) DEFAULT NULL,
  `TituloTarea` text,
  `Descripcion` text,
  `Asignado` varchar(150) DEFAULT NULL,
  `FechaLimite` text,
  `Vencida` int(10) DEFAULT NULL,
  `Terminada` int(2) DEFAULT NULL,
  `FechaDeTermino` text,
  `ComentarioDeCierre` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tareascargadaseliminadas`
--

INSERT INTO `tareascargadaseliminadas` (`id`, `Fecha`, `Asignador`, `TituloTarea`, `Descripcion`, `Asignado`, `FechaLimite`, `Vencida`, `Terminada`, `FechaDeTermino`, `ComentarioDeCierre`) VALUES
(112, '2018-09-07 23:14:19', 'pazs', 'Correo a reynosa', 'Enviar correo a reynosa con el conteo de personal DL en CUU.', 'pazs', '2018-09-09', NULL, 1, '2018-09-08 10:18:44', ''),
(115, '2018-09-08 18:30:02', 'pazs', 'ttttttttttttt', 'tttttttttttttt', 'pazs', '2018-09-14', NULL, 0, 'NULL', ''),
(116, '2018-09-08 18:52:59', 'pazs', 'vvv', 'vvvvv', 'pazs', '2018-09-09', NULL, 0, 'NULL', ''),
(119, '2018-09-08 19:07:07', 'pazs', 'kk3', 'k3', 'pazs', '2018-09-09', NULL, 0, 'NULL', ''),
(118, '2018-09-08 19:07:07', 'pazs', 'kk2', 'k2', 'pazs', '2018-09-09', NULL, 0, 'NULL', ''),
(117, '2018-09-08 18:59:41', 'pazs', 'iiiiiiiiiiii', 'iiiiii', 'pazs', '2018-09-09', NULL, 0, 'NULL', ''),
(120, '2018-09-08 19:07:07', 'pazs', 'kk4', 'k4', 'ESPINOED', '2018-09-09', NULL, 0, 'NULL', ''),
(121, '2018-09-08 19:25:02', 'pazs', 'sasac', 'ascascffff', 'pazs', '2018-09-08', NULL, 0, 'NULL', ''),
(123, '2018-09-09 09:01:08', 'pazs', 'Badges', 'Cambiar badge IDs', 'pazs', '2018-09-10', NULL, 0, 'NULL', ''),
(124, '2018-09-09 09:01:08', 'pazs', 'Correo a reynosa', 'Enviar correo a reynosa con el conteo de personal DL en CUU.', 'pazs', '2018-09-10', NULL, 0, 'NULL', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareasprogramadas`
--

CREATE TABLE IF NOT EXISTS `tareasprogramadas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FechaDeCreacion` datetime DEFAULT NULL,
  `Asignador` varchar(100) DEFAULT NULL,
  `TituloTarea` varchar(100) DEFAULT NULL,
  `Descripcion` varchar(1000) DEFAULT NULL,
  `Asignado` varchar(100) DEFAULT NULL,
  `FechaDeProximoEvento` date DEFAULT NULL,
  `Frecuencia` varchar(50) DEFAULT NULL,
  `Finalizada` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Volcado de datos para la tabla `tareasprogramadas`
--

INSERT INTO `tareasprogramadas` (`id`, `FechaDeCreacion`, `Asignador`, `TituloTarea`, `Descripcion`, `Asignado`, `FechaDeProximoEvento`, `Frecuencia`, `Finalizada`) VALUES
(12, '2018-08-16 18:34:44', 'pazs', 'Contactos', 'Recordar a Lalo este lunes sobre la acciÃ³n a tomar para capturar el telÃ©fono de contacto de la gente.', 'pazs', '2018-08-20', 'Un solo evento', 'Si'),
(13, '2018-08-16 23:55:45', 'pazs', 'Contactos de emergencia', 'Agregar los numeros de contacto de emergencia faltantes en Kiosko', 'pazs', '2018-08-20', 'Un solo evento', 'Si'),
(25, '2018-09-02 23:05:15', 'pazs', 'Badges', 'Cambiar badge IDs', 'pazs', '2018-09-11', 'Diaria', 'No'),
(26, '2018-09-03 08:15:02', 'pazs', 'Correo a reynosa', 'Enviar correo a reynosa con el conteo de personal DL en CUU.', 'pazs', '2018-09-11', 'Diaria', 'No'),
(27, '2018-09-05 18:24:02', 'pazs', 'SR', 'Acceso para la nueva de laborales a la ruta I:DirecTVHRLABORALES levantar caso este 10 de sept. 8am', 'pazs', '2018-09-10', 'Un solo evento', 'Si'),
(28, '2018-09-06 11:34:45', 'pazs', '1and1', 'Revisar en 1and1 que se genere una factura negativa por $14.5 lleme el 06 de sept no.caso 817459318 Juan diego ', 'pazs', '2018-09-18', 'Un solo evento', 'No'),
(29, '2018-09-07 21:19:19', 'pazs', '', 'Pasar a nominas por la copia de la correcciÃ³n de Jesus villa 168451 OLGA ALICIA BANDA PONCE', 'pazs', '2018-09-10', 'Un solo evento', 'Si'),
(31, '2018-09-08 18:48:49', 'pazs', 'vvv', 'vvvvv', 'pazs', '2018-09-09', 'Un solo evento', 'Si'),
(32, '2018-09-08 18:53:53', 'pazs', 'iiiiiiiiiiii', 'iiiiii', 'pazs', '2018-09-09', 'Un solo evento', 'Si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `User` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `FullName` varchar(130) NOT NULL,
  `Role` int(11) NOT NULL,
  `Email` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `User`, `Password`, `FullName`, `Role`, `Email`) VALUES
(17, 'johana.moreno1', 'johana.moreno11260', 'JOHANA DE LA PAZ MORENO RIVERA', 2, 'johana.moreno1@iqor.com'),
(18, 'martinezg', 'martinezg1260', 'GLORIA ANGELICA MARTINEZ ORTIZ', 2, 'GLORIA.MARTINEZ@IQOR.COM'),
(19, 'ESPINOED', 'espinoed1260', 'EDUARDO ESPINO MARMOLEJO', 1, 'sergio.pazholguin@iqor.com'),
(20, 'ariana.ruiz', 'ariana.ruiz1260', 'ARIANA PATRICIA RUIZ HERNANDEZ', 2, 'ariana.ruiz@iqor.com'),
(21, 'pazs', 'pazs1260', 'SERGIO ALEJANDRO PAZ HOLGUIN', 1, 'SERGIO.PAZHOLGUIN@IQOR.COM'),
(22, 'uriase', 'uriase1260', 'EMMA ELIZABETH URIAS MICHEL', 2, 'EMMA.URIAS@IQOR.COM'),
(23, 'melissa.estrada', 'melissa.estrada1260', 'RUTH MELISSA ESTRADA RODRIGUEZ', 2, 'melissa.estrada@iqor.com');

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`dbo747997577`@`%` EVENT `JobGenerarTareaSP` ON SCHEDULE EVERY 1 DAY STARTS '2018-08-26 15:08:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL GenerarTarea()$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
