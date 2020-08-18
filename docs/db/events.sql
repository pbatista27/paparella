-- SET GLOBAL event_scheduler = ON;
DROP PROCEDURE IF EXISTS `mantenimiento_event`;
CREATE  EVENT `mantenimiento_event`
ON SCHEDULE EVERY 1 DAY STARTS '2000-01-01 23:59:00'
DO
    call mantenimiento();
call mantenimiento();
