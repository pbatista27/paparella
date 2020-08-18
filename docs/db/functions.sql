DELIMITER $$
DROP FUNCTION IF EXISTS `SUBTOKEN_UUID`$$
CREATE FUNCTION `SUBTOKEN_UUID` (`maxChar` INT(3)) RETURNS VARCHAR(255) BEGIN
    return UPPER(SUBSTRING( TOKEN_UUID() , 1, maxChar)) ;
END$$
DROP FUNCTION IF EXISTS `TOKEN_UUID`$$

CREATE FUNCTION `TOKEN_UUID` () RETURNS VARCHAR(255) BEGIN
    return UPPER(SUBSTRING( ( concat((SELECT SHA(UUID())) , (SELECT SHA(UUID())) , (SELECT SHA(UUID())) , (SELECT SHA(UUID())) , (SELECT SHA(UUID())),  (SELECT SHA(UUID())), (SELECT SHA(UUID())) ) )  , 1, 255)) ;
END$$
DELIMITER ;


DELIMITER $$
DROP FUNCTION IF EXISTS `COUNT_CURSADAS_POR_INICIAR`$$
CREATE FUNCTION COUNT_CURSADAS_POR_INICIAR(idSucursal int) RETURNS INT
BEGIN
    RETURN (SELECT  COUNT(cur.id) FROM cursada as cur
    INNER JOIN curso_sucursal AS cs ON (cs.id = cur.id_curso_sucursal AND cs.id_sucursal = idSucursal)
    WHERE cur.status = 0 AND cur.fecha_inicio > NOW());
END$$
DELIMITER ;


DELIMITER $$
DROP FUNCTION IF EXISTS `COUNT_CURSADAS_ACTIVAS`$$
CREATE FUNCTION COUNT_CURSADAS_ACTIVAS(idSucursal int) RETURNS INT
BEGIN
    RETURN (SELECT  COUNT(cur.id) FROM cursada as cur
    INNER JOIN curso_sucursal AS cs ON (cs.id = cur.id_curso_sucursal AND cs.id_sucursal = idSucursal)
    WHERE cur.status = 1 AND cur.fecha_fin < NOW());
END$$
DELIMITER ;


DELIMITER $$
DROP FUNCTION IF EXISTS `COUNT_CURSADAS_FINALIZADAS`$$
CREATE FUNCTION COUNT_CURSADAS_FINALIZADAS(idSucursal int) RETURNS INT
BEGIN
    RETURN (SELECT  COUNT(cur.id) FROM cursada as cur
    INNER JOIN curso_sucursal AS cs ON (cs.id = cur.id_curso_sucursal AND cs.id_sucursal = idSucursal)
    WHERE cur.status = 2 AND cur.fecha_fin < NOW());
END$$
DELIMITER ;


DELIMITER $$
DROP FUNCTION IF EXISTS `COUNT_CURSADAS_CANCELADAS`$$
CREATE FUNCTION COUNT_CURSADAS_CANCELADAS(idSucursal int) RETURNS INT
BEGIN
    RETURN (SELECT  COUNT(cur.id) FROM cursada as cur
    INNER JOIN curso_sucursal AS cs ON (cs.id = cur.id_curso_sucursal AND cs.id_sucursal = idSucursal)
    WHERE cur.status = 3 );
END$$
DELIMITER ;


DELIMITER $$
DROP FUNCTION IF EXISTS `COUNT_USER_ACTIVE_SUCURSAL`$$
CREATE FUNCTION COUNT_USER_ACTIVE_SUCURSAL(idSucursal int , idPerfil int) RETURNS INT
BEGIN
    return (SELECT count(id) from usuario where id in( select u.id from usuario as u inner join usuario_sucursal as us on (us.id_usuario = u.id) where u.id_perfil = idPerfil and u.activo = 1 and us.id_sucursal = idSucursal ));
END$$
DELIMITER ;

DELIMITER $$
DROP FUNCTION IF EXISTS `COUNT_USER_INACTIVE_SUCURSAL`$$
CREATE FUNCTION COUNT_USER_INACTIVE_SUCURSAL(idSucursal int , idPerfil int) RETURNS INT
BEGIN
    return (SELECT count(id) from usuario where id in( select u.id from usuario as u inner join usuario_sucursal as us on (us.id_usuario = u.id) where u.id_perfil = idPerfil and u.activo = 0 and us.id_sucursal = idSucursal ));
END$$
DELIMITER ;

DELIMITER $$
DROP FUNCTION IF EXISTS `COUNT_NUEVO_ESTUDIANTE_SUCURSAL`$$
CREATE FUNCTION COUNT_NUEVO_ESTUDIANTE_SUCURSAL(idSucursal int) RETURNS INT
BEGIN
    return (SELECT count(id) from usuario
        where id in( select u.id from usuario as u inner join usuario_sucursal as us on (us.id_usuario = u.id) where u.id_perfil = 4 and us.id_sucursal = idSucursal )
        and usuario.fecha_registro =  (SELECT DATE_FORMAT(now(), "%Y-%m-%d")));
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS `MANTENIMIENTO`$$
CREATE PROCEDURE `MANTENIMIENTO`() BEGIN
    DECLARE diaActual DATE DEFAULT (SELECT DATE_FORMAT( NOW(), "%Y-%m-%d") );

    START TRANSACTION;
    SET FOREIGN_KEY_CHECKS = 0;
    SET @TRIGGER_CHECKS    = TRUE;

    update config  set en_mantenimiento = true where id = 1;
    DELETE FROM sucursal_estadistica WHERE fecha >= diaActual;

    BEGIN
        DECLARE idSucursal INT(11);
        DECLARE flagEndLoop INTEGER DEFAULT 0;
        DECLARE cursor_sucursal CURSOR FOR SELECT id FROM sucursal order by id asc;
        DECLARE CONTINUE HANDLER FOR NOT FOUND SET flagEndLoop=1;

        OPEN cursor_sucursal;
        myLoop: LOOP

            FETCH cursor_sucursal INTO idSucursal;
            IF (flagEndLoop = 1) THEN
                LEAVE myLoop;
            END IF;

            INSERT INTO sucursal_estadistica set
                `id_sucursal`                   = idSucursal,
                --
                `nro_admin_totales`              = COUNT_USER_ACTIVE_SUCURSAL(idSucursal, 2) +  COUNT_USER_INACTIVE_SUCURSAL(idSucursal, 2),
                `nro_admin_activos`              = COUNT_USER_ACTIVE_SUCURSAL(idSucursal, 2),
                `nro_admin_inactivos`            = COUNT_USER_INACTIVE_SUCURSAL(idSucursal, 2),
                --
                `nro_docentes_totales`           = COUNT_USER_ACTIVE_SUCURSAL(idSucursal, 3) +  COUNT_USER_INACTIVE_SUCURSAL(idSucursal, 3),
                `nro_docentes_inactivos`         = COUNT_USER_INACTIVE_SUCURSAL(idSucursal, 3),
                `nro_docentes_activos`           = COUNT_USER_ACTIVE_SUCURSAL(idSucursal, 3),
                --
                `nro_estudiantes_totales`        = COUNT_USER_ACTIVE_SUCURSAL(idSucursal, 4) +  COUNT_USER_INACTIVE_SUCURSAL(idSucursal, 4),
                `nro_estudiantes_inactivos`      = COUNT_USER_INACTIVE_SUCURSAL(idSucursal, 4),
                `nro_estudiantes_activos`        = COUNT_USER_ACTIVE_SUCURSAL(idSucursal, 4),
                `nro_estudiantes_nuevo_ingreso`  = COUNT_NUEVO_ESTUDIANTE_SUCURSAL(idSucursal),
                `nro_estudiantes_preinscripcion` = 0, -- por hacer
                `nro_estudiantes_sincurso`       = 0, -- por hacer

                `nro_cursadas_sininiciar`       = COUNT_CURSADAS_POR_INICIAR(idSucursal),
                `nro_cursadas_activas`          = COUNT_CURSADAS_ACTIVAS(idSucursal),
                `nro_cursadas_finalizada`       = COUNT_CURSADAS_FINALIZADAS(idSucursal),

                `fecha`                         = diaActual;
        END LOOP myLoop;
        CLOSE cursor_sucursal;
    END;
    update config  set en_mantenimiento = false where id = 1;

    SET FOREIGN_KEY_CHECKS=1;
    SET @TRIGGER_CHECKS = FALSE;
    COMMIT;

END$$
DELIMITER ;

