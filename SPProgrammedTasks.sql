DELIMITER ;;
DROP PROCEDURE IF EXISTS `GenerarTarea`;;
CREATE PROCEDURE `GenerarTarea`()
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
END ;;

call GenerarTarea();