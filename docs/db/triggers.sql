DROP TRIGGER IF EXISTS `localidad_before_insert`;
DELIMITER $$
CREATE TRIGGER `localidad_before_insert` BEFORE INSERT ON `localidad` FOR EACH ROW BEGIN
	DECLARE provincia varchar(255);
	SET provincia = (select nombre from provincia where id = NEW.id);
	SET NEW .keyword = concat( NEW.nombre, ' ', provincia);
  END
$$
DELIMITER ;

DROP TRIGGER IF EXISTS `localidad_before_update`;
DELIMITER $$
CREATE TRIGGER `localidad_before_update` BEFORE UPDATE ON `localidad` FOR EACH ROW BEGIN
	DECLARE provincia varchar(255);

	SET provincia = (select nombre from provincia where id = NEW.id);
	SET NEW .keyword = concat( NEW.nombre, ' ', provincia);
  END
$$
DELIMITER ;

DROP TRIGGER IF EXISTS `perfil_before_insert`;
DELIMITER $$
CREATE TRIGGER `perfil_before_insert` BEFORE INSERT ON `perfil` FOR EACH ROW BEGIN
	SET NEW.id = null;
  END
$$
DELIMITER ;

DROP TRIGGER IF EXISTS `perfil_before_insert`;
DELIMITER $$
CREATE TRIGGER `perfil_before_insert` BEFORE INSERT ON `perfil` FOR EACH ROW BEGIN
	SET NEW.id = NULL;
  END
$$
DELIMITER ;

DROP TRIGGER IF EXISTS `perfil_before_update`;
DELIMITER $$
CREATE TRIGGER `perfil_before_update` BEFORE UPDATE ON `perfil` FOR EACH ROW BEGIN
	SET NEW.id = OLD.id;
  END
$$
DELIMITER ;

DROP TRIGGER IF EXISTS `usuario_before_insert`;
DELIMITER $$
CREATE TRIGGER `usuario_before_insert` BEFORE INSERT ON `usuario` FOR EACH ROW BEGIN
	DECLARE flagLoop        INT;
	DECLARE hashAuthKey     VARCHAR(255);

	-- SET users.auth_key
	SET flagLoop = 1;
	WHILE flagLoop = 1 DO
		SET hashAuthKey   = (SELECT SUBTOKEN_UUID(40));
		SET flagLoop      = (SELECT COUNT(id) FROM usuario WHERE  auth_key = hashAuthKey);
	END WHILE;
	SET NEW.auth_key = hashAuthKey;

	-- SET users.token
	SET flagLoop = 1;
	WHILE flagLoop = 1 DO
		SET hashAuthKey   = (SELECT SUBTOKEN_UUID(40));
		SET flagLoop      = (SELECT COUNT(id) FROM usuario WHERE  token = hashAuthKey);
	END WHILE;
	SET NEW.token = hashAuthKey;

	SET NEW.id    = null;
	SET NEW.fecha_registro  = NOW();
	SET NEW.fecha_edicion  = NULL;
END $$
DELIMITER ;

DROP TRIGGER IF EXISTS `usuario_before_update`;
DELIMITER $$
CREATE TRIGGER `usuario_before_update` BEFORE UPDATE ON `usuario` FOR EACH ROW BEGIN
	DECLARE flagLoop        INT;
	DECLARE hashAuthKey     VARCHAR(255);

	-- update token
	IF(NEW.token is null or new.token = '')
	THEN
		SET flagLoop = 1;
		WHILE flagLoop = 1 DO
			SET hashAuthKey   = (SELECT SUBTOKEN_UUID(40));
			SET flagLoop      = (SELECT COUNT(id) FROM usuario WHERE  token = hashAuthKey);
		END WHILE;
		SET NEW.token = hashAuthKey;
	END IF;

	-- nunca cambiar estos
	SET NEW.auth_key        = OLD.auth_key;
	SET NEW.id              = OLD.id;
	SET NEW.fecha_registro  = OLD.fecha_registro;
	SET NEW.fecha_edicion   = now();
	SET NEW.id_perfil       = OLD.id_perfil;
END $$
DELIMITER ;

DROP TRIGGER IF EXISTS `usuario_after_insert`;
DELIMITER $$
CREATE TRIGGER `usuario_after_insert` AFTER INSERT ON `usuario` FOR EACH ROW BEGIN
	IF(NEW.id_perfil = 4) THEN
		INSERT INTO usuario_contacto (`id`) values (NEW.id);
	END IF;
END $$
DELIMITER ;

