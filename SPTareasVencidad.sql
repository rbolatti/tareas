DELIMITER ;;
DROP PROCEDURE IF EXISTS `TareasVencidas`;;
CREATE PROCEDURE `TareasVencidas`()
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
END ;;

call TareasVencidas();