SET GLOBAL innodb_file_format=Barracuda; SET GLOBAL innodb_file_per_table=ON;
ALTER TABLE solicitud ENGINE=InnoDB ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=8;

ALTER TABLE `estado` ENGINE=InnoDB;

CREATE TABLE cyt_solicitud_estado ( oid bigint(20) NOT NULL auto_increment,
solicitud_oid int(11) default NULL, estado_oid int(11) default NULL, fechaDesde
datetime default NULL, fechaHasta datetime default NULL, motivo text default
NULL, user_oid int(11) NOT NULL, fechaUltModificacion timestamp NOT NULL default
CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, PRIMARY KEY  (oid), KEY
solicitud_oid (solicitud_oid), KEY estado_oid (estado_oid), KEY user_oid
(user_oid) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

ALTER TABLE cyt_solicitud_estado ADD FOREIGN KEY ( solicitud_oid ) REFERENCES solicitud (
cd_solicitud
);

ALTER TABLE cyt_solicitud_estado ADD FOREIGN KEY ( estado_oid ) REFERENCES estado (
cd_estado
);

ALTER TABLE cyt_solicitud_estado ADD FOREIGN KEY ( user_oid ) REFERENCES cyt_user (
oid
);

INSERT INTO cdt_function VALUES (NULL, 'Listar estados');
INSERT INTO cdt_function VALUES (NULL, 'Cambiar estado');

INSERT INTO cdt_action_function VALUES (NULL, 64, 'list_solicitudesEstado');
INSERT INTO cdt_action_function VALUES (NULL, 65, 'cambiarEstadoSolicitud_init');
INSERT INTO cdt_action_function VALUES (NULL, 65, 'cambiarEstadoSolicitud');

INSERT INTO cdt_function VALUES (NULL, 'Ver puntaje/diferencia');

INSERT INTO cdt_action_function VALUES (NULL, 66, 'view_puntaje');

CREATE TABLE cyt_solicitud_proyecto (
  oid bigint(20) NOT NULL auto_increment,
  solicitud_oid int(11) default NULL,
  proyecto_oid int(11) default NULL,
  dt_alta DATE NULL DEFAULT NULL,
  dt_baja DATE NULL DEFAULT NULL,
  PRIMARY KEY  (oid),
  KEY solicitud_oid (solicitud_oid),
  KEY proyecto_oid (proyecto_oid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

ALTER TABLE cyt_solicitud_proyecto ADD FOREIGN KEY ( solicitud_oid ) REFERENCES solicitud (
cd_solicitud
);

ALTER TABLE cyt_solicitud_proyecto ADD FOREIGN KEY ( proyecto_oid ) REFERENCES proyecto (
cd_proyecto
);

ALTER TABLE `evaluacion`
	ENGINE=InnoDB;

CREATE TABLE cyt_evaluacion_estado (
  oid bigint(20) NOT NULL auto_increment,
  evaluacion_oid int(11) default NULL,
  estado_oid int(11) default NULL,
  fechaDesde datetime default NULL,
  fechaHasta datetime default NULL,
  motivo text default NULL,
  user_oid int(11) NOT NULL,
  fechaUltModificacion timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (oid),
  KEY evaluacion_oid (evaluacion_oid),
  KEY estado_oid (estado_oid),
  KEY user_oid (user_oid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

ALTER TABLE cyt_evaluacion_estado ADD FOREIGN KEY ( evaluacion_oid ) REFERENCES evaluacion (
cd_evaluacion
);

ALTER TABLE cyt_evaluacion_estado ADD FOREIGN KEY ( estado_oid ) REFERENCES estado (
cd_estado
);

ALTER TABLE cyt_evaluacion_estado ADD FOREIGN KEY ( user_oid ) REFERENCES cyt_user (
oid
);

INSERT INTO cdt_action_function VALUES (NULL, 64, 'list_evaluacionEstado');
INSERT INTO cdt_action_function VALUES (NULL, 65, 'cambiarEstadoEvaluacion_init');
INSERT INTO cdt_action_function VALUES (NULL, 65, 'cambiarEstadoEvaluacion');

INSERT INTO cdt_function VALUES (NULL, 'Ver anteriores');

INSERT INTO cdt_action_function VALUES (NULL, 67, 'view_anteriores');

ALTER TABLE `motivo`
	ENGINE=InnoDB;

DELETE
FROM ambito
WHERE not exists (SELECT solicitud.cd_solicitud FROM solicitud WHERE solicitud.cd_solicitud =  ambito.cd_solicitud);

ALTER TABLE `ambito`
	ENGINE=InnoDB;

ALTER TABLE ambito ADD FOREIGN KEY ( cd_solicitud ) REFERENCES solicitud (
cd_solicitud
);

ALTER TABLE `evaluacion`
	ENGINE=InnoDB;

ALTER TABLE evaluacion ADD FOREIGN KEY ( cd_usuario ) REFERENCES cyt_user (
oid
);

ALTER TABLE evaluacion ADD FOREIGN KEY ( cd_solicitud ) REFERENCES solicitud (
cd_solicitud
);

ALTER TABLE `monto`
	ENGINE=InnoDB;

ALTER TABLE monto ADD FOREIGN KEY ( cd_solicitud ) REFERENCES solicitud (
cd_solicitud
);

ALTER TABLE `tipopresupuesto`
	ENGINE=InnoDB;

ALTER TABLE `presupuesto`
	ENGINE=InnoDB;

DELETE
FROM presupuesto
WHERE not exists (SELECT solicitud.cd_solicitud FROM solicitud WHERE solicitud.cd_solicitud =  presupuesto.cd_solicitud);

ALTER TABLE presupuesto ADD FOREIGN KEY ( cd_solicitud ) REFERENCES solicitud (
cd_solicitud
);

ALTER TABLE presupuesto ADD FOREIGN KEY ( cd_tipopresupuesto ) REFERENCES tipopresupuesto (
cd_tipopresupuesto
);

ALTER TABLE `tipoinvestigador`
	ENGINE=InnoDB;

ALTER TABLE `modeloplanilla`
	ENGINE=InnoDB;

ALTER TABLE modeloplanilla ADD FOREIGN KEY ( cd_motivo ) REFERENCES motivo (
cd_motivo
);

ALTER TABLE modeloplanilla ADD FOREIGN KEY ( cd_tipoinvestigador ) REFERENCES tipoinvestigador (
cd_tipoinvestigador
);

ALTER TABLE `planmaximo`
	ENGINE=InnoDB;

ALTER TABLE planmaximo ADD FOREIGN KEY ( cd_modeloplanilla ) REFERENCES modeloplanilla (
cd_modeloplanilla
);

ALTER TABLE `puntajeplan`
	ENGINE=InnoDB;

DELETE
FROM puntajeplan
WHERE not exists (SELECT modeloplanilla.cd_modeloplanilla FROM modeloplanilla WHERE modeloplanilla.cd_modeloplanilla =  puntajeplan.cd_modeloplanilla);

ALTER TABLE puntajeplan ADD FOREIGN KEY ( cd_modeloplanilla ) REFERENCES modeloplanilla (
cd_modeloplanilla
);

ALTER TABLE puntajeplan ADD FOREIGN KEY ( cd_evaluacion) REFERENCES evaluacion(
cd_evaluacion
);

ALTER TABLE `categoriamaximo`
	ENGINE=InnoDB;

ALTER TABLE categoriamaximo ADD FOREIGN KEY ( cd_modeloplanilla ) REFERENCES modeloplanilla (
cd_modeloplanilla
);

ALTER TABLE categoriamaximo ADD FOREIGN KEY ( cd_categoria) REFERENCES categoria(
cd_categoria
);

ALTER TABLE `puntajecategoria`
	ENGINE=InnoDB;

DELETE
FROM puntajecategoria
WHERE not exists (SELECT modeloplanilla.cd_modeloplanilla FROM modeloplanilla WHERE modeloplanilla.cd_modeloplanilla =  puntajecategoria.cd_modeloplanilla);

ALTER TABLE puntajecategoria ADD FOREIGN KEY ( cd_modeloplanilla ) REFERENCES modeloplanilla (
cd_modeloplanilla
);

ALTER TABLE puntajecategoria ADD FOREIGN KEY ( cd_evaluacion) REFERENCES evaluacion(
cd_evaluacion
);

SET FOREIGN_KEY_CHECKS = 0;
ALTER TABLE puntajecategoria ADD FOREIGN KEY ( cd_categoriamaximo) REFERENCES categoriamaximo(
cd_categoriamaximo
);
SET FOREIGN_KEY_CHECKS = 1;

ALTER TABLE `cargoplanilla`
	ENGINE=InnoDB;

ALTER TABLE `cargomaximo`
	ENGINE=InnoDB;

ALTER TABLE cargomaximo ADD FOREIGN KEY ( cd_modeloplanilla ) REFERENCES modeloplanilla (
cd_modeloplanilla
);

ALTER TABLE cargomaximo ADD FOREIGN KEY ( cd_cargoplanilla) REFERENCES cargoplanilla(
cd_cargoplanilla
);

ALTER TABLE `puntajecargo`
	ENGINE=InnoDB;

DELETE
FROM puntajecargo
WHERE not exists (SELECT modeloplanilla.cd_modeloplanilla FROM modeloplanilla WHERE modeloplanilla.cd_modeloplanilla =  puntajecargo.cd_modeloplanilla);

ALTER TABLE puntajecargo ADD FOREIGN KEY ( cd_modeloplanilla ) REFERENCES modeloplanilla (
cd_modeloplanilla
);

ALTER TABLE puntajecargo ADD FOREIGN KEY ( cd_evaluacion) REFERENCES evaluacion(
cd_evaluacion
);

SET FOREIGN_KEY_CHECKS = 0;
ALTER TABLE puntajecargo ADD FOREIGN KEY ( cd_cargomaximo) REFERENCES cargomaximo(
cd_cargomaximo
);
SET FOREIGN_KEY_CHECKS = 1;

ALTER TABLE `puntajegrupo`
	ENGINE=InnoDB;

ALTER TABLE `itemplanilla`
	ENGINE=InnoDB;

ALTER TABLE `itemmaximo`
	ENGINE=InnoDB;

ALTER TABLE itemmaximo ADD FOREIGN KEY ( cd_modeloplanilla ) REFERENCES modeloplanilla (
cd_modeloplanilla
);

ALTER TABLE itemmaximo ADD FOREIGN KEY ( cd_itemplanilla) REFERENCES itemplanilla(
cd_itemplanilla
);

ALTER TABLE itemmaximo ADD FOREIGN KEY ( cd_puntajegrupo) REFERENCES puntajegrupo(
cd_puntajegrupo
);

ALTER TABLE `eventoplanilla`
	ENGINE=InnoDB;

ALTER TABLE `eventomaximo`
	ENGINE=InnoDB;

ALTER TABLE eventomaximo ADD FOREIGN KEY ( cd_modeloplanilla ) REFERENCES modeloplanilla (
cd_modeloplanilla
);

ALTER TABLE eventomaximo ADD FOREIGN KEY ( cd_eventoplanilla) REFERENCES eventoplanilla(
cd_eventoplanilla
);

ALTER TABLE eventomaximo ADD FOREIGN KEY ( cd_puntajegrupo) REFERENCES puntajegrupo(
cd_puntajegrupo
);

ALTER TABLE `universidad`
	ENGINE=InnoDB;

ALTER TABLE `titulo`
	ENGINE=InnoDB;

ALTER TABLE titulo ADD FOREIGN KEY ( cd_universidad ) REFERENCES universidad (
cd_universidad
);

ALTER TABLE `beca`
	ENGINE=InnoDB;

ALTER TABLE beca ADD FOREIGN KEY ( cd_docente ) REFERENCES docente (
cd_docente
);

SET GLOBAL innodb_file_format=Barracuda;
SET GLOBAL innodb_file_per_table=ON;
ALTER TABLE solicitud ADD cd_titulogrado INT(11) NULL DEFAULT NULL;

ALTER TABLE solicitud ADD FOREIGN KEY ( cd_titulogrado ) REFERENCES titulo (
cd_titulo
);

ALTER TABLE `solicitud`
	CHANGE COLUMN `dt_fecha` `dt_fecha` DATETIME NULL DEFAULT NULL ;

ALTER TABLE `cyt_solicitud_proyecto`
	ADD UNIQUE INDEX `solicitud_oid_proyecto_oid` (`solicitud_oid`, `proyecto_oid`);

INSERT INTO cdt_function VALUES (NULL, 'Enviar solicitud');
INSERT INTO cdt_action_function VALUES (NULL, 68, 'send_solicitud');

INSERT INTO cdt_function VALUES (NULL, 'Admitir solicitud');
INSERT INTO cdt_action_function VALUES (NULL, 69, 'admit_solicitud');

INSERT INTO cdt_function VALUES (NULL, 'Rechazar solicitud');
INSERT INTO cdt_action_function VALUES (NULL, 70, 'deny_solicitud');
INSERT INTO cdt_action_function VALUES (NULL, 70, 'deny_solicitud_init');

######################################## 27/11/2014 ###################################################
CREATE TABLE IF NOT EXISTS cyt_solicitud_no_rendidas (
  oid bigint(20) NOT NULL AUTO_INCREMENT,
  nu_documento int(11) NOT NULL,
  nu_year varchar(5) NOT NULL,
  PRIMARY KEY (oid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE evaluacion
	ENGINE=InnoDB;

CREATE TABLE cyt_evaluacion_estado (
  oid bigint(20) NOT NULL auto_increment,
  evaluacion_oid int(11) default NULL,
  estado_oid int(11) default NULL,
  fechaDesde datetime default NULL,
  fechaHasta datetime default NULL,
  motivo text default NULL,
  user_oid int(11) NOT NULL,
  fechaUltModificacion timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (oid),
  KEY evaluacion_oid (evaluacion_oid),
  KEY estado_oid (estado_oid),
  KEY user_oid (user_oid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

ALTER TABLE cyt_evaluacion_estado ADD FOREIGN KEY ( evaluacion_oid ) REFERENCES evaluacion (
cd_evaluacion
);

ALTER TABLE cyt_evaluacion_estado ADD FOREIGN KEY ( estado_oid ) REFERENCES estado (
cd_estado
);

ALTER TABLE cyt_evaluacion_estado ADD FOREIGN KEY ( user_oid ) REFERENCES cyt_user (
oid
);

#################################### 03-02-2015 ########################################################
INSERT INTO modeloplanilla VALUES (21, 1, 3, 'A formados', 100, 6);
INSERT INTO modeloplanilla VALUES (22, 1, 4, 'A en formación', 100, 6);
INSERT INTO modeloplanilla VALUES (23, 2, 3, 'B formados', 100, 6);
INSERT INTO modeloplanilla VALUES (24, 2, 4, 'B en formación', 100, 6);
INSERT INTO modeloplanilla VALUES (25, 3, 3, 'C', 100, 6);

INSERT INTO planmaximo VALUES (23, null, 40);
INSERT INTO planmaximo VALUES (24, null, 40);
INSERT INTO planmaximo VALUES (25, null, 40);

INSERT INTO categoriamaximo VALUES (21, null, 6, 5);
INSERT INTO categoriamaximo VALUES (21, null, 7, 4);
INSERT INTO categoriamaximo VALUES (21, null, 8, 2);
INSERT INTO categoriamaximo VALUES (21, null, 1, 0);
INSERT INTO categoriamaximo VALUES (22, null, 9, 5);
INSERT INTO categoriamaximo VALUES (22, null, 10, 2.5);
INSERT INTO categoriamaximo VALUES (22, null, 1, 0);
INSERT INTO categoriamaximo VALUES (23, null, 6, 5);
INSERT INTO categoriamaximo VALUES (23, null, 7, 4);
INSERT INTO categoriamaximo VALUES (23, null, 8, 2);
INSERT INTO categoriamaximo VALUES (23, null, 1, 0);
INSERT INTO categoriamaximo VALUES (24, null, 9, 5);
INSERT INTO categoriamaximo VALUES (24, null, 10, 2.5);
INSERT INTO categoriamaximo VALUES (24, null, 1, 0);
INSERT INTO categoriamaximo VALUES (25, null, 6, 5);
INSERT INTO categoriamaximo VALUES (25, null, 7, 4);
INSERT INTO categoriamaximo VALUES (25, null, 8, 2);
INSERT INTO categoriamaximo VALUES (25, null, 1, 0);

INSERT INTO cargomaximo VALUES (21, null, 1, 15);
INSERT INTO cargomaximo VALUES (21, null, 2, 13);
INSERT INTO cargomaximo VALUES (21, null, 3, 13);
INSERT INTO cargomaximo VALUES (21, null, 4, 11);
INSERT INTO cargomaximo VALUES (21, null, 5, 11);
INSERT INTO cargomaximo VALUES (21, null, 6, 9);
INSERT INTO cargomaximo VALUES (21, null, 7, 9);
INSERT INTO cargomaximo VALUES (21, null, 8, 7);
INSERT INTO cargomaximo VALUES (21, null, 9, 6);
INSERT INTO cargomaximo VALUES (21, null, 10, 4);
INSERT INTO cargomaximo VALUES (22, null, 1, 15);
INSERT INTO cargomaximo VALUES (22, null, 2, 13);
INSERT INTO cargomaximo VALUES (22, null, 3, 13);
INSERT INTO cargomaximo VALUES (22, null, 4, 11);
INSERT INTO cargomaximo VALUES (22, null, 5, 11);
INSERT INTO cargomaximo VALUES (22, null, 6, 9);
INSERT INTO cargomaximo VALUES (22, null, 7, 9);
INSERT INTO cargomaximo VALUES (22, null, 8, 7);
INSERT INTO cargomaximo VALUES (22, null, 9, 6);
INSERT INTO cargomaximo VALUES (22, null, 10, 4);
INSERT INTO cargomaximo VALUES (23, null, 1, 8);
INSERT INTO cargomaximo VALUES (23, null, 2, 7);
INSERT INTO cargomaximo VALUES (23, null, 3, 7);
INSERT INTO cargomaximo VALUES (23, null, 4, 6);
INSERT INTO cargomaximo VALUES (23, null, 5, 6);
INSERT INTO cargomaximo VALUES (23, null, 6, 5);
INSERT INTO cargomaximo VALUES (23, null, 7, 5);
INSERT INTO cargomaximo VALUES (23, null, 8, 4);
INSERT INTO cargomaximo VALUES (23, null, 9, 4);
INSERT INTO cargomaximo VALUES (23, null, 10, 3);
INSERT INTO cargomaximo VALUES (24, null, 1, 8);
INSERT INTO cargomaximo VALUES (24, null, 2, 7);
INSERT INTO cargomaximo VALUES (24, null, 3, 7);
INSERT INTO cargomaximo VALUES (24, null, 4, 6);
INSERT INTO cargomaximo VALUES (24, null, 5, 6);
INSERT INTO cargomaximo VALUES (24, null, 6, 5);
INSERT INTO cargomaximo VALUES (24, null, 7, 5);
INSERT INTO cargomaximo VALUES (24, null, 8, 4);
INSERT INTO cargomaximo VALUES (24, null, 9, 4);
INSERT INTO cargomaximo VALUES (24, null, 10, 3);
INSERT INTO cargomaximo VALUES (25, null, 1, 5);
INSERT INTO cargomaximo VALUES (25, null, 2, 4);
INSERT INTO cargomaximo VALUES (25, null, 3, 4);
INSERT INTO cargomaximo VALUES (25, null, 4, 3);
INSERT INTO cargomaximo VALUES (25, null, 5, 3);
INSERT INTO cargomaximo VALUES (25, null, 6, 2);
INSERT INTO cargomaximo VALUES (25, null, 7, 2);
INSERT INTO cargomaximo VALUES (25, null, 8, 1);
INSERT INTO cargomaximo VALUES (25, null, 9, 1);
INSERT INTO cargomaximo VALUES (25, null, 10, 0);

INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (37, 'AFprod3', '12');

INSERT INTO itemmaximo VALUES (21, null, 1, 5, 1, 5);
INSERT INTO itemmaximo VALUES (21, null, 2, 3, 1, 3);
INSERT INTO itemmaximo VALUES (21, null, 3, 4, 1, 4);
INSERT INTO itemmaximo VALUES (21, null, 12, 3, 1, 3);
INSERT INTO itemmaximo VALUES (21, null, 13, 1, 1, 1);
INSERT INTO itemmaximo VALUES (21, null, 4, 2, 2, 2);
INSERT INTO itemmaximo VALUES (21, null, 6, 6, 37, 6);
INSERT INTO itemmaximo VALUES (21, null, 7, 4, 37, 4);
INSERT INTO itemmaximo VALUES (21, null, 8, 2, 37, 2);
INSERT INTO itemmaximo VALUES (21, null, 9, 2.5, 4, 2.5);
INSERT INTO itemmaximo VALUES (21, null, 14, 0.5, 5, 0.5);
INSERT INTO itemmaximo VALUES (21, null, 15, 1, 5, 1);

INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (38, 'AnFprod1', '20');
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (39, 'AnFprod2', '15');
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (40, 'AnFprod3', '10');


INSERT INTO itemmaximo VALUES (22, null, 1, 5, 38, 5);
INSERT INTO itemmaximo VALUES (22, null, 12, 3, 38, 3);
INSERT INTO itemmaximo VALUES (22, null, 2, 3, 38, 3);
INSERT INTO itemmaximo VALUES (22, null, 3, 4, 38, 4);
INSERT INTO itemmaximo VALUES (22, null, 13, 1, 38, 1);
INSERT INTO itemmaximo VALUES (22, null, 4, 3, 39, 3);
INSERT INTO itemmaximo VALUES (22, null, 6, 6, 40, 6);
INSERT INTO itemmaximo VALUES (22, null, 7, 4, 40, 4);
INSERT INTO itemmaximo VALUES (22, null, 8, 2, 40, 2);
INSERT INTO itemmaximo VALUES (22, null, 9, 2.5, 9, 2.5);
INSERT INTO itemmaximo VALUES (22, null, 14, 0.5, 10, 0.5);
INSERT INTO itemmaximo VALUES (22, null, 15, 1, 10, 1);

INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (41, 'BFprod2', '4');
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (42, 'BFprod3', '6');

INSERT INTO itemmaximo VALUES (23, null, 1, 2.5, 11, 2.5);
INSERT INTO itemmaximo VALUES (23, null, 12, 1.5, 11, 1.5);
INSERT INTO itemmaximo VALUES (23, null, 2, 1.5, 11, 1.5);
INSERT INTO itemmaximo VALUES (23, null, 3, 3, 11, 3);
INSERT INTO itemmaximo VALUES (23, null, 13, 1, 11, 1);
INSERT INTO itemmaximo VALUES (23, null, 4, 1, 41, 1);
INSERT INTO itemmaximo VALUES (23, null, 6, 3, 42, 3);
INSERT INTO itemmaximo VALUES (23, null, 7, 2, 42, 2);
INSERT INTO itemmaximo VALUES (23, null, 8, 1, 42, 1);
INSERT INTO itemmaximo VALUES (23, null, 9, 1.5, 14, 1.5);
INSERT INTO itemmaximo VALUES (23, null, 14, 0.25, 15, 0.25);
INSERT INTO itemmaximo VALUES (23, null, 15, 0.5, 15, 0.5);

INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (43, 'BnFprod1', '10');
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (44, 'BnFprod2', '5');
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (45, 'BnFprod3', '5');

INSERT INTO itemmaximo VALUES (24, null, 1, 2.5, 43, 2.5);
INSERT INTO itemmaximo VALUES (24, null, 12, 1.5, 43, 1.5);
INSERT INTO itemmaximo VALUES (24, null, 2, 1.5, 43, 1.5);
INSERT INTO itemmaximo VALUES (24, null, 3, 3, 43, 3);
INSERT INTO itemmaximo VALUES (24, null, 13, 1, 43, 1);
INSERT INTO itemmaximo VALUES (24, null, 4, 2, 44, 2);
INSERT INTO itemmaximo VALUES (24, null, 6, 3, 45, 3);
INSERT INTO itemmaximo VALUES (24, null, 7, 2, 45, 2);
INSERT INTO itemmaximo VALUES (24, null, 8, 1, 45, 1);
INSERT INTO itemmaximo VALUES (24, null, 9, 1, 19, 1);
INSERT INTO itemmaximo VALUES (24, null, 14, 0.25, 20, 0.25);
INSERT INTO itemmaximo VALUES (24, null, 15, 0.5, 20, 0.5);

INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (46, 'Cprod2', '3');
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (47, 'Cprod3', '5');

INSERT INTO itemmaximo VALUES (25, null, 1, 2.5, 21, 2.5);
INSERT INTO itemmaximo VALUES (25, null, 12, 1.5, 21, 1.5);
INSERT INTO itemmaximo VALUES (25, null, 2, 1.5, 21, 1.5);
INSERT INTO itemmaximo VALUES (25, null, 3, 3, 21, 3);
INSERT INTO itemmaximo VALUES (25, null, 13, 1, 21, 1);
INSERT INTO itemmaximo VALUES (25, null, 4, 1, 46, 1);
INSERT INTO itemmaximo VALUES (25, null, 6, 3, 47, 3);
INSERT INTO itemmaximo VALUES (25, null, 7, 2, 47, 2);
INSERT INTO itemmaximo VALUES (25, null, 8, 1, 47, 1);
INSERT INTO itemmaximo VALUES (25, null, 9, 1.5, 24, 1.5);
INSERT INTO itemmaximo VALUES (25, null, 14, 0.25, 25, 0.25);
INSERT INTO itemmaximo VALUES (25, null, 15, 0.5, 25, 0.5);

INSERT INTO eventomaximo VALUES (21, null, 8, 10, 26, 0);
INSERT INTO eventomaximo VALUES (21, null, 14, 3, 26, 0);
INSERT INTO eventomaximo VALUES (21, null, 9, 5, 26, 5);
INSERT INTO eventomaximo VALUES (21, null, 12, 6, 26, 6);
INSERT INTO eventomaximo VALUES (21, null, 13, 1, 26, 1);

INSERT INTO eventomaximo VALUES (22, null, 8, 12, 27, 0);
INSERT INTO eventomaximo VALUES (22, null, 14, 4, 27, 0);
INSERT INTO eventomaximo VALUES (22, null, 9, 7, 27, 7);
INSERT INTO eventomaximo VALUES (22, null, 12, 6, 27, 6);
INSERT INTO eventomaximo VALUES (22, null, 13, 1, 27, 1);

INSERT INTO eventomaximo VALUES (23, null, 11, 8, 28, 0);
INSERT INTO eventomaximo VALUES (23, null, 6, 3, 28, 0);
INSERT INTO eventomaximo VALUES (23, null, 10, 3, 28, 3);
INSERT INTO eventomaximo VALUES (23, null, 12, 5, 28, 5);
INSERT INTO eventomaximo VALUES (23, null, 13, 1, 28, 1);

INSERT INTO eventomaximo VALUES (24, null, 11, 10, 29, 0);
INSERT INTO eventomaximo VALUES (24, null, 6, 5, 29, 0);
INSERT INTO eventomaximo VALUES (24, null, 10, 3, 29, 3);
INSERT INTO eventomaximo VALUES (24, null, 12, 6, 29, 6);
INSERT INTO eventomaximo VALUES (24, null, 13, 1, 29, 1);

INSERT INTO eventomaximo VALUES (25, null, 1, 15, 30, 0);
INSERT INTO eventomaximo VALUES (25, null, 7, 3, 30, 3);
INSERT INTO eventomaximo VALUES (25, null, 12, 6, 30, 6);
INSERT INTO eventomaximo VALUES (25, null, 13, 1, 30, 1);

SET FOREIGN_KEY_CHECKS = 0;
ALTER TABLE `solicitud`
	ADD UNIQUE INDEX `periodo_docente_unique` (`cd_periodo`, `cd_docente`);
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO `unidadaprobadaviajes` (`cd_unidad`, `cd_periodo`) VALUES
(1874, 6),
(1899, 6),
(5380, 6),
(5381, 6),
(5383, 6),
(5415, 6),
(5416, 6),
(5419, 6),
(5420, 6),
(5421, 6),
(5422, 6),
(5423, 6),
(5424, 6),
(5425, 6),
(5426, 6),
(5738, 6),
(5739, 6),
(6292, 6),
(6302, 6),
(6303, 6),
(6325, 6),
(6995, 6),
(7790, 6),
(7835, 6),
(8017, 6),
(8378, 6),
(10311, 6),
(11097, 6),
(11992, 6),
(12366, 6),
(12706, 6),
(12928, 6),
(12992, 6),
(13029, 6),
(13074, 6),
(13078, 6),
(13086, 6),
(13160, 6),
(13170, 6),
(13209, 6),
(13865, 6),
(13942, 6),
(14050, 6),
(14102, 6),
(14122, 6),
(14330, 6),
(14536, 6),
(20009, 6),
(20010, 6),
(20012, 6),
(20013, 6),
(20260, 6),
(20408, 6),
(20461, 6),
(21075, 6),
(21076, 6),
(21594, 6),
(22104, 6),
(22126, 6),
(22246, 6),
(22262, 6),
(22347, 6),
(22514, 6),
(22515, 6),
(22516, 6),
(22518, 6),
(22519, 6),
(110129, 6),
(110130, 6),
(110332, 6),
(110334, 6),
(110505, 6),
(110524, 6),
(110603, 6),
(110620, 6),
(110621, 6),
(110633, 6),
(110634, 6),
(110635, 6),
(110636, 6),
(111012, 6),
(111027, 6),
(111108, 6),
(111120, 6),
(111122, 6),
(111123, 6),
(111124, 6),
(111126, 6),
(111128, 6),
(111130, 6),
(111233, 6),
(111234, 6),
(111236, 6),
(111237, 6),
(111324, 6),
(111414, 6),
(111415, 6),
(111611, 6),
(111712, 6),
(111720, 6),
(111827, 6),
(111839, 6),
(111849, 6),
(111850, 6),
(111851, 6),
(111852, 6),
(111853, 6),
(111862, 6),
(900003, 6),
(900007, 6),
(900008, 6),
(110525, 6),
(110526, 6),
(110131, 6),
(111131, 6),
(111238, 6);

############################################ 08/06/2015 #####################################################
CREATE TABLE cambioviajes (
  cd_cambio int(11) NOT NULL AUTO_INCREMENT,
  cd_solicitud int(11) NOT NULL,

  dt_fecha timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  ds_archivo varchar(255) DEFAULT NULL,

  ds_observacion text,

  PRIMARY KEY (cd_cambio),
  KEY cd_solicitud (cd_solicitud)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

ALTER TABLE cambioviajes ADD FOREIGN KEY ( cd_solicitud ) REFERENCES solicitud (
cd_solicitud
);


CREATE TABLE ambitocambioviajes (
  cd_ambito int(11) NOT NULL AUTO_INCREMENT,
  cd_cambio int(11) NOT NULL,
  dt_desde date DEFAULT NULL,
  dt_hasta date DEFAULT NULL,
  ds_institucion varchar(255) DEFAULT NULL,
  ds_ciudad varchar(255) DEFAULT NULL,
  ds_pais varchar(255) DEFAULT NULL,
  PRIMARY KEY (cd_ambito),
  KEY cd_cambio (cd_cambio)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


CREATE TABLE presupuestocambioviajes (
  cd_presupuesto int(11) NOT NULL AUTO_INCREMENT,
  cd_tipopresupuesto int(11) NOT NULL,
  cd_cambio int(11) NOT NULL,
  ds_presupuesto varchar(255) NOT NULL,
  nu_monto double(10,2) NOT NULL,
  dt_fecha date NOT NULL,
  PRIMARY KEY (cd_presupuesto),
  KEY cd_tipopresupuesto (cd_tipopresupuesto,cd_cambio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


CREATE TABLE cyt_cambio_estado (
  oid bigint(20) NOT NULL auto_increment,
  cambio_oid int(11) default NULL,
  estado_oid int(11) default NULL,
  fechaDesde datetime default NULL,
  fechaHasta datetime default NULL,
  motivo text default NULL,
  user_oid int(11) NOT NULL,
  fechaUltModificacion timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (oid),
  KEY cambio_oid (cambio_oid),
  KEY estado_oid (estado_oid),
  KEY user_oid (user_oid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

ALTER TABLE cyt_cambio_estado ADD FOREIGN KEY ( cambio_oid ) REFERENCES cambioviajes (
cd_cambio
);

ALTER TABLE cyt_cambio_estado ADD FOREIGN KEY ( estado_oid ) REFERENCES estado (
cd_estado
);

ALTER TABLE cyt_cambio_estado ADD FOREIGN KEY ( user_oid ) REFERENCES cyt_user (
oid
);

ALTER TABLE ambitocambioviajes ADD FOREIGN KEY ( cd_cambio ) REFERENCES cambioviajes (
cd_cambio
);

ALTER TABLE presupuestocambioviajes ADD FOREIGN KEY ( cd_cambio ) REFERENCES cambioviajes (
cd_cambio
);

############################################ 03/02/2016 #####################################################
ALTER TABLE `solicitud`
	ADD COLUMN `ds_disciplina` VARCHAR(255) NULL DEFAULT NULL AFTER `cd_titulogrado`;

INSERT INTO `unidadaprobadaviajes` (`cd_unidad`, `cd_periodo`) VALUES
(1874, 7),
(1899, 7),
(5380, 7),
(5381, 7),
(5383, 7),
(5415, 7),
(5416, 7),
(5419, 7),
(5420, 7),
(5421, 7),
(5422, 7),
(5423, 7),
(5424, 7),
(5425, 7),
(5426, 7),
(5738, 7),
(5739, 7),
(6292, 7),
(6302, 7),
(6303, 7),
(6325, 7),
(6995, 7),
(7790, 7),
(7835, 7),
(8017, 7),
(8378, 7),
(10311, 7),
(11097, 7),
(11992, 7),
(12366, 7),
(12706, 7),
(12928, 7),
(12992, 7),
(13029, 7),
(13074, 7),
(13078, 7),
(13086, 7),
(13160, 7),
(13170, 7),
(13177, 7),
(13209, 7),
(13865, 7),
(13942, 7),
(14050, 7),
(14102, 7),
(14122, 7),
(14330, 7),
(14536, 7),
(20009, 7),
(20010, 7),
(20012, 7),
(20013, 7),
(20260, 7),
(20408, 7),
(20461, 7),
(21075, 7),
(21076, 7),
(21594, 7),
(22104, 7),
(22126, 7),
(22246, 7),
(22262, 7),
(22347, 7),
(22514, 7),
(22515, 7),
(22516, 7),
(22518, 7),
(22519, 7),
(110129, 7),
(110130, 7),
(110131, 7),
(110332, 7),
(110334, 7),
(110505, 7),
(110524, 7),
(110525, 7),
(110526, 7),
(110603, 7),
(110620, 7),
(110621, 7),
(110633, 7),
(110634, 7),
(110635, 7),
(110636, 7),
(111012, 7),
(111027, 7),
(111108, 7),
(111120, 7),
(111122, 7),
(111123, 7),
(111124, 7),
(111126, 7),
(111128, 7),
(111130, 7),
(111131, 7),
(111228, 7),
(111233, 7),
(111234, 7),
(111236, 7),
(111237, 7),
(111238, 7),
(111324, 7),
(111414, 7),
(111415, 7),
(111611, 7),
(111712, 7),
(111720, 7),
(111827, 7),
(111839, 7),
(111849, 7),
(111850, 7),
(111851, 7),
(111852, 7),
(111853, 7),
(111862, 7),
(900003, 7),
(900007, 7),
(900008, 7),
(900009, 7),
(900010, 7),
(900011, 7),
(900012, 7),
(900013, 7),
(900014, 7),
(900015, 7),
(900016, 7),
(900017, 7),
(900018, 7),
(900019, 7),
(900020, 7),
(900021, 7),
(900022, 7),
(900023, 7),
(900024, 7),
(900025, 7),
(900026, 7),
(900027, 7),
(900028, 7),
(900029, 7),
(900030, 7),
(900031, 7),
(900032, 7),
(900033, 7),
(900034, 7),
(111863, 7),
(900035, 7),
(900036, 7),
(900037, 7),
(900038, 7),
(900039, 7),
(5384, 7),
(5372, 7);

############################################################04/03/2016########################################################3
CREATE TABLE cyt_rendicionviajes (
  oid int(11) NOT NULL AUTO_INCREMENT,
  solicitud_oid int(11) NOT NULL,

  fecha timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  rendicion varchar(255) DEFAULT NULL,
  informe varchar(255) DEFAULT NULL,
  constancia varchar(255) DEFAULT NULL,
  observaciones text,

  PRIMARY KEY (oid),
  KEY cd_solicitud (solicitud_oid)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

ALTER TABLE cyt_rendicionviajes ADD FOREIGN KEY ( solicitud_oid ) REFERENCES solicitud (
cd_solicitud
);

CREATE TABLE cyt_rendicionviajes_estado (
  oid bigint(20) NOT NULL auto_increment,
  rendicion_oid int(11) default NULL,
  estado_oid int(11) default NULL,
  fechaDesde datetime default NULL,
  fechaHasta datetime default NULL,
  motivo text default NULL,
  user_oid int(11) NOT NULL,
  fechaUltModificacion timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (oid),
  KEY rendicion_oid (rendicion_oid),
  KEY estado_oid (estado_oid),
  KEY user_oid (user_oid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

ALTER TABLE cyt_rendicionviajes_estado ADD FOREIGN KEY ( rendicion_oid ) REFERENCES cyt_rendicionviajes (
oid
);

ALTER TABLE cyt_rendicionviajes_estado ADD FOREIGN KEY ( estado_oid ) REFERENCES estado (
cd_estado
);

ALTER TABLE cyt_rendicionviajes_estado ADD FOREIGN KEY ( user_oid ) REFERENCES cyt_user (
oid
);

############################################################14/04/2016########################################################
INSERT INTO modeloplanilla VALUES (26, 1, 3, 'A formados', 100, 7);
INSERT INTO modeloplanilla VALUES (27, 1, 4, 'A en formaci�n', 100, 7);
INSERT INTO modeloplanilla VALUES (28, 2, 3, 'B formados', 100, 7);
INSERT INTO modeloplanilla VALUES (29, 2, 4, 'B en formaci�n', 100, 7);
INSERT INTO modeloplanilla VALUES (30, 3, 3, 'C', 100, 7);

INSERT INTO planmaximo VALUES (28, null, 40);
INSERT INTO planmaximo VALUES (29, null, 40);
INSERT INTO planmaximo VALUES (30, null, 40);

INSERT INTO categoriamaximo VALUES (26, null, 6, 5);
INSERT INTO categoriamaximo VALUES (26, null, 7, 4);
INSERT INTO categoriamaximo VALUES (26, null, 8, 2);
INSERT INTO categoriamaximo VALUES (26, null, 1, 0);
INSERT INTO categoriamaximo VALUES (27, null, 9, 5);
INSERT INTO categoriamaximo VALUES (27, null, 10, 2.5);
INSERT INTO categoriamaximo VALUES (27, null, 1, 0);
INSERT INTO categoriamaximo VALUES (28, null, 6, 5);
INSERT INTO categoriamaximo VALUES (28, null, 7, 4);
INSERT INTO categoriamaximo VALUES (28, null, 8, 2);
INSERT INTO categoriamaximo VALUES (28, null, 1, 0);
INSERT INTO categoriamaximo VALUES (29, null, 9, 5);
INSERT INTO categoriamaximo VALUES (29, null, 10, 2.5);
INSERT INTO categoriamaximo VALUES (29, null, 1, 0);
INSERT INTO categoriamaximo VALUES (30, null, 6, 5);
INSERT INTO categoriamaximo VALUES (30, null, 7, 4);
INSERT INTO categoriamaximo VALUES (30, null, 8, 2);
INSERT INTO categoriamaximo VALUES (30, null, 1, 0);

INSERT INTO cargomaximo VALUES (26, null, 1, 15);
INSERT INTO cargomaximo VALUES (26, null, 2, 13);
INSERT INTO cargomaximo VALUES (26, null, 3, 13);
INSERT INTO cargomaximo VALUES (26, null, 4, 11);
INSERT INTO cargomaximo VALUES (26, null, 5, 11);
INSERT INTO cargomaximo VALUES (26, null, 6, 9);
INSERT INTO cargomaximo VALUES (26, null, 7, 9);
INSERT INTO cargomaximo VALUES (26, null, 8, 7);
INSERT INTO cargomaximo VALUES (26, null, 9, 6);
INSERT INTO cargomaximo VALUES (26, null, 10, 4);
INSERT INTO cargomaximo VALUES (27, null, 1, 15);
INSERT INTO cargomaximo VALUES (27, null, 2, 13);
INSERT INTO cargomaximo VALUES (27, null, 3, 13);
INSERT INTO cargomaximo VALUES (27, null, 4, 11);
INSERT INTO cargomaximo VALUES (27, null, 5, 11);
INSERT INTO cargomaximo VALUES (27, null, 6, 9);
INSERT INTO cargomaximo VALUES (27, null, 7, 9);
INSERT INTO cargomaximo VALUES (27, null, 8, 7);
INSERT INTO cargomaximo VALUES (27, null, 9, 6);
INSERT INTO cargomaximo VALUES (27, null, 10, 4);
INSERT INTO cargomaximo VALUES (28, null, 1, 8);
INSERT INTO cargomaximo VALUES (28, null, 2, 7);
INSERT INTO cargomaximo VALUES (28, null, 3, 7);
INSERT INTO cargomaximo VALUES (28, null, 4, 6);
INSERT INTO cargomaximo VALUES (28, null, 5, 6);
INSERT INTO cargomaximo VALUES (28, null, 6, 5);
INSERT INTO cargomaximo VALUES (28, null, 7, 5);
INSERT INTO cargomaximo VALUES (28, null, 8, 4);
INSERT INTO cargomaximo VALUES (28, null, 9, 4);
INSERT INTO cargomaximo VALUES (28, null, 10, 3);
INSERT INTO cargomaximo VALUES (29, null, 1, 8);
INSERT INTO cargomaximo VALUES (29, null, 2, 7);
INSERT INTO cargomaximo VALUES (29, null, 3, 7);
INSERT INTO cargomaximo VALUES (29, null, 4, 6);
INSERT INTO cargomaximo VALUES (29, null, 5, 6);
INSERT INTO cargomaximo VALUES (29, null, 6, 5);
INSERT INTO cargomaximo VALUES (29, null, 7, 5);
INSERT INTO cargomaximo VALUES (29, null, 8, 4);
INSERT INTO cargomaximo VALUES (29, null, 9, 4);
INSERT INTO cargomaximo VALUES (29, null, 10, 3);
INSERT INTO cargomaximo VALUES (30, null, 1, 5);
INSERT INTO cargomaximo VALUES (30, null, 2, 4);
INSERT INTO cargomaximo VALUES (30, null, 3, 4);
INSERT INTO cargomaximo VALUES (30, null, 4, 3);
INSERT INTO cargomaximo VALUES (30, null, 5, 3);
INSERT INTO cargomaximo VALUES (30, null, 6, 2);
INSERT INTO cargomaximo VALUES (30, null, 7, 2);
INSERT INTO cargomaximo VALUES (30, null, 8, 1);
INSERT INTO cargomaximo VALUES (30, null, 9, 1);
INSERT INTO cargomaximo VALUES (30, null, 10, 0);

INSERT INTO `itemplanilla` (`cd_itemplanilla`, `ds_itemplanilla`, `nu_orden`) VALUES
(17, 'Dir/Cod Tesinas de Grado/Dir/Cod Becas Vocaciones Cient�ficas CIN-UNLP y de Entrenamiento CIC(Finalizadas/Aprobadas)(se excluyen si es la misma persona)', 12);

INSERT INTO itemmaximo VALUES (26, null, 1, 5, 1, 5);
INSERT INTO itemmaximo VALUES (26, null, 2, 3, 1, 3);
INSERT INTO itemmaximo VALUES (26, null, 3, 4, 1, 4);
INSERT INTO itemmaximo VALUES (26, null, 12, 3, 1, 3);
INSERT INTO itemmaximo VALUES (26, null, 13, 1, 1, 1);
INSERT INTO itemmaximo VALUES (26, null, 4, 2, 2, 2);
INSERT INTO itemmaximo VALUES (26, null, 6, 6, 37, 6);
INSERT INTO itemmaximo VALUES (26, null, 7, 4, 37, 4);
INSERT INTO itemmaximo VALUES (26, null, 8, 2, 37, 2);
INSERT INTO itemmaximo VALUES (26, null, 9, 2.5, 4, 2.5);
INSERT INTO itemmaximo VALUES (26, null, 17, 0.5, 5, 0.5);
INSERT INTO itemmaximo VALUES (26, null, 15, 1, 5, 1);

INSERT INTO itemmaximo VALUES (27, null, 1, 5, 38, 5);
INSERT INTO itemmaximo VALUES (27, null, 12, 3, 38, 3);
INSERT INTO itemmaximo VALUES (27, null, 2, 3, 38, 3);
INSERT INTO itemmaximo VALUES (27, null, 3, 4, 38, 4);
INSERT INTO itemmaximo VALUES (27, null, 13, 1, 38, 1);
INSERT INTO itemmaximo VALUES (27, null, 4, 3, 39, 3);
INSERT INTO itemmaximo VALUES (27, null, 6, 6, 40, 6);
INSERT INTO itemmaximo VALUES (27, null, 7, 4, 40, 4);
INSERT INTO itemmaximo VALUES (27, null, 8, 2, 40, 2);
INSERT INTO itemmaximo VALUES (27, null, 9, 2.5, 9, 2.5);
INSERT INTO itemmaximo VALUES (27, null, 17, 0.5, 10, 0.5);
INSERT INTO itemmaximo VALUES (27, null, 15, 1, 10, 1);

INSERT INTO itemmaximo VALUES (28, null, 1, 2.5, 11, 2.5);
INSERT INTO itemmaximo VALUES (28, null, 12, 1.5, 11, 1.5);
INSERT INTO itemmaximo VALUES (28, null, 2, 1.5, 11, 1.5);
INSERT INTO itemmaximo VALUES (28, null, 3, 3, 11, 3);
INSERT INTO itemmaximo VALUES (28, null, 13, 1, 11, 1);
INSERT INTO itemmaximo VALUES (28, null, 4, 1, 41, 1);
INSERT INTO itemmaximo VALUES (28, null, 6, 3, 42, 3);
INSERT INTO itemmaximo VALUES (28, null, 7, 2, 42, 2);
INSERT INTO itemmaximo VALUES (28, null, 8, 1, 42, 1);
INSERT INTO itemmaximo VALUES (28, null, 9, 1.5, 14, 1.5);
INSERT INTO itemmaximo VALUES (28, null, 17, 0.25, 15, 0.25);
INSERT INTO itemmaximo VALUES (28, null, 15, 0.5, 15, 0.5);

INSERT INTO itemmaximo VALUES (29, null, 1, 2.5, 43, 2.5);
INSERT INTO itemmaximo VALUES (29, null, 12, 1.5, 43, 1.5);
INSERT INTO itemmaximo VALUES (29, null, 2, 1.5, 43, 1.5);
INSERT INTO itemmaximo VALUES (29, null, 3, 3, 43, 3);
INSERT INTO itemmaximo VALUES (29, null, 13, 1, 43, 1);
INSERT INTO itemmaximo VALUES (29, null, 4, 2, 44, 2);
INSERT INTO itemmaximo VALUES (29, null, 6, 3, 45, 3);
INSERT INTO itemmaximo VALUES (29, null, 7, 2, 45, 2);
INSERT INTO itemmaximo VALUES (29, null, 8, 1, 45, 1);
INSERT INTO itemmaximo VALUES (29, null, 9, 1, 19, 1);
INSERT INTO itemmaximo VALUES (29, null, 17, 0.25, 20, 0.25);
INSERT INTO itemmaximo VALUES (29, null, 15, 0.5, 20, 0.5);

INSERT INTO itemmaximo VALUES (30, null, 1, 2.5, 21, 2.5);
INSERT INTO itemmaximo VALUES (30, null, 12, 1.5, 21, 1.5);
INSERT INTO itemmaximo VALUES (30, null, 2, 1.5, 21, 1.5);
INSERT INTO itemmaximo VALUES (30, null, 3, 3, 21, 3);
INSERT INTO itemmaximo VALUES (30, null, 13, 1, 21, 1);
INSERT INTO itemmaximo VALUES (30, null, 4, 1, 46, 1);
INSERT INTO itemmaximo VALUES (30, null, 6, 3, 47, 3);
INSERT INTO itemmaximo VALUES (30, null, 7, 2, 47, 2);
INSERT INTO itemmaximo VALUES (30, null, 8, 1, 47, 1);
INSERT INTO itemmaximo VALUES (30, null, 9, 1.5, 24, 1.5);
INSERT INTO itemmaximo VALUES (30, null, 17, 0.25, 25, 0.25);
INSERT INTO itemmaximo VALUES (30, null, 15, 0.5, 25, 0.5);

INSERT INTO eventomaximo VALUES (26, null, 8, 10, 26, 0);
INSERT INTO eventomaximo VALUES (26, null, 14, 3, 26, 0);
INSERT INTO eventomaximo VALUES (26, null, 9, 5, 26, 5);
INSERT INTO eventomaximo VALUES (26, null, 12, 6, 26, 6);
INSERT INTO eventomaximo VALUES (26, null, 13, 1, 26, 1);

INSERT INTO eventomaximo VALUES (27, null, 8, 12, 27, 0);
INSERT INTO eventomaximo VALUES (27, null, 14, 4, 27, 0);
INSERT INTO eventomaximo VALUES (27, null, 9, 7, 27, 7);
INSERT INTO eventomaximo VALUES (27, null, 12, 6, 27, 6);
INSERT INTO eventomaximo VALUES (27, null, 13, 1, 27, 1);

INSERT INTO eventomaximo VALUES (28, null, 11, 8, 28, 0);
INSERT INTO eventomaximo VALUES (28, null, 6, 3, 28, 0);
INSERT INTO eventomaximo VALUES (28, null, 10, 3, 28, 3);
INSERT INTO eventomaximo VALUES (28, null, 12, 5, 28, 5);
INSERT INTO eventomaximo VALUES (28, null, 13, 1, 28, 1);

INSERT INTO eventomaximo VALUES (29, null, 11, 10, 29, 0);
INSERT INTO eventomaximo VALUES (29, null, 6, 5, 29, 0);
INSERT INTO eventomaximo VALUES (29, null, 10, 3, 29, 3);
INSERT INTO eventomaximo VALUES (29, null, 12, 6, 29, 6);
INSERT INTO eventomaximo VALUES (29, null, 13, 1, 29, 1);

INSERT INTO eventomaximo VALUES (30, null, 1, 15, 30, 0);
INSERT INTO eventomaximo VALUES (30, null, 7, 3, 30, 3);
INSERT INTO eventomaximo VALUES (30, null, 12, 6, 30, 6);
INSERT INTO eventomaximo VALUES (30, null, 13, 1, 30, 1);

#########################################################03/06/2016####################################################################

INSERT INTO cdt_function VALUES (NULL, 'Listar rendiciones');


INSERT INTO cdt_action_function VALUES (NULL, , 'list_rendiciones');



INSERT INTO cdt_action_function VALUES (NULL, 64, 'list_rendicionesEstado');
INSERT INTO cdt_action_function VALUES (NULL, 65, 'cambiarEstadoRendicion_init');
INSERT INTO cdt_action_function VALUES (NULL, 65, 'cambiarEstadoRendicion');

#########################################################12/12/2016####################################################################

ALTER TABLE `cyt_solicitud_proyecto`
	ADD COLUMN `bl_seleccionado` BINARY(1) NULL DEFAULT '0' AFTER `dt_baja`;



ALTER TABLE `solicitud`
	ADD COLUMN `dt_fechatrabajohasta` DATE NULL DEFAULT NULL AFTER `dt_fechatrabajo`,
	ADD COLUMN `ds_modalidadtrabajo` TEXT NULL DEFAULT NULL AFTER ds_invitaciongrupo,
	ADD COLUMN `ds_relevanciatrabajo` TEXT NULL AFTER `ds_resumentrabajo`,
	ADD COLUMN `ds_relevanciaB` TEXT NULL AFTER ds_aportesB,
	ADD COLUMN `ds_relevanciaA` TEXT NULL AFTER `ds_relevanciaB`,
	ADD COLUMN `ds_relacionProyectoC` TEXT NULL AFTER `ds_planC`;


#########################################################22/02/2017####################################################################

INSERT INTO modeloplanilla VALUES (31, 1, 3, 'A formados', 100, 8);
INSERT INTO modeloplanilla VALUES (32, 1, 4, 'A en formaci�n', 100, 8);
INSERT INTO modeloplanilla VALUES (33, 2, 3, 'B formados', 100, 8);
INSERT INTO modeloplanilla VALUES (34, 2, 4, 'B en formaci�n', 100, 8);
INSERT INTO modeloplanilla VALUES (35, 3, 3, 'C', 100, 8);

INSERT INTO planmaximo VALUES (33, null, 40);
INSERT INTO planmaximo VALUES (34, null, 40);
INSERT INTO planmaximo VALUES (35, null, 40);

INSERT INTO categoriamaximo VALUES (31, null, 6, 5);
INSERT INTO categoriamaximo VALUES (31, null, 7, 4);
INSERT INTO categoriamaximo VALUES (31, null, 8, 2);
INSERT INTO categoriamaximo VALUES (31, null, 1, 0);
INSERT INTO categoriamaximo VALUES (32, null, 9, 5);
INSERT INTO categoriamaximo VALUES (32, null, 10, 2.5);
INSERT INTO categoriamaximo VALUES (32, null, 1, 0);
INSERT INTO categoriamaximo VALUES (33, null, 6, 5);
INSERT INTO categoriamaximo VALUES (33, null, 7, 4);
INSERT INTO categoriamaximo VALUES (33, null, 8, 2);
INSERT INTO categoriamaximo VALUES (33, null, 1, 0);
INSERT INTO categoriamaximo VALUES (34, null, 9, 5);
INSERT INTO categoriamaximo VALUES (34, null, 10, 2.5);
INSERT INTO categoriamaximo VALUES (34, null, 1, 0);
INSERT INTO categoriamaximo VALUES (35, null, 6, 5);
INSERT INTO categoriamaximo VALUES (35, null, 7, 4);
INSERT INTO categoriamaximo VALUES (35, null, 8, 2);
INSERT INTO categoriamaximo VALUES (35, null, 1, 0);

INSERT INTO cargomaximo VALUES (31, null, 1, 15);
INSERT INTO cargomaximo VALUES (31, null, 2, 13);
INSERT INTO cargomaximo VALUES (31, null, 3, 13);
INSERT INTO cargomaximo VALUES (31, null, 4, 11);
INSERT INTO cargomaximo VALUES (31, null, 5, 11);
INSERT INTO cargomaximo VALUES (31, null, 6, 9);
INSERT INTO cargomaximo VALUES (31, null, 7, 9);
INSERT INTO cargomaximo VALUES (31, null, 8, 7);
INSERT INTO cargomaximo VALUES (31, null, 9, 6);
INSERT INTO cargomaximo VALUES (31, null, 10, 4);
INSERT INTO cargomaximo VALUES (32, null, 1, 15);
INSERT INTO cargomaximo VALUES (32, null, 2, 13);
INSERT INTO cargomaximo VALUES (32, null, 3, 13);
INSERT INTO cargomaximo VALUES (32, null, 4, 11);
INSERT INTO cargomaximo VALUES (32, null, 5, 11);
INSERT INTO cargomaximo VALUES (32, null, 6, 9);
INSERT INTO cargomaximo VALUES (32, null, 7, 9);
INSERT INTO cargomaximo VALUES (32, null, 8, 7);
INSERT INTO cargomaximo VALUES (32, null, 9, 6);
INSERT INTO cargomaximo VALUES (32, null, 10, 4);
INSERT INTO cargomaximo VALUES (33, null, 1, 8);
INSERT INTO cargomaximo VALUES (33, null, 2, 7);
INSERT INTO cargomaximo VALUES (33, null, 3, 7);
INSERT INTO cargomaximo VALUES (33, null, 4, 6);
INSERT INTO cargomaximo VALUES (33, null, 5, 6);
INSERT INTO cargomaximo VALUES (33, null, 6, 5);
INSERT INTO cargomaximo VALUES (33, null, 7, 5);
INSERT INTO cargomaximo VALUES (33, null, 8, 4);
INSERT INTO cargomaximo VALUES (33, null, 9, 4);
INSERT INTO cargomaximo VALUES (33, null, 10, 3);
INSERT INTO cargomaximo VALUES (34, null, 1, 8);
INSERT INTO cargomaximo VALUES (34, null, 2, 7);
INSERT INTO cargomaximo VALUES (34, null, 3, 7);
INSERT INTO cargomaximo VALUES (34, null, 4, 6);
INSERT INTO cargomaximo VALUES (34, null, 5, 6);
INSERT INTO cargomaximo VALUES (34, null, 6, 5);
INSERT INTO cargomaximo VALUES (34, null, 7, 5);
INSERT INTO cargomaximo VALUES (34, null, 8, 4);
INSERT INTO cargomaximo VALUES (34, null, 9, 4);
INSERT INTO cargomaximo VALUES (34, null, 10, 3);
INSERT INTO cargomaximo VALUES (35, null, 1, 5);
INSERT INTO cargomaximo VALUES (35, null, 2, 4);
INSERT INTO cargomaximo VALUES (35, null, 3, 4);
INSERT INTO cargomaximo VALUES (35, null, 4, 3);
INSERT INTO cargomaximo VALUES (35, null, 5, 3);
INSERT INTO cargomaximo VALUES (35, null, 6, 2);
INSERT INTO cargomaximo VALUES (35, null, 7, 2);
INSERT INTO cargomaximo VALUES (35, null, 8, 1);
INSERT INTO cargomaximo VALUES (35, null, 9, 1);
INSERT INTO cargomaximo VALUES (35, null, 10, 0);

ALTER TABLE `itemplanilla` CHANGE `ds_itemplanilla` `ds_itemplanilla` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL

INSERT INTO `itemplanilla` (`cd_itemplanilla`, `ds_itemplanilla`, `nu_orden`) VALUES (18, 'Con t�tulo de propiedad intelectual: -Patentes', '7');
INSERT INTO `itemplanilla` (`cd_itemplanilla`, `ds_itemplanilla`, `nu_orden`) VALUES (19, 'Con t�tulo de propiedad intelectual: -Modelo de utilidad -Derecho de obtentor (Variedades vegetales) -Derecho de autor de producciones tecnol�gicas -Modelo industrial -Dise�o industrial, Marca de servicios o producto', '8');
INSERT INTO `itemplanilla` (`cd_itemplanilla`, `ds_itemplanilla`, `nu_orden`) VALUES (20, 'Dir/Cod Tesis de Posgrado aprobadas (Maestr�as/Doctorados)', '10');
INSERT INTO `itemplanilla` (`cd_itemplanilla`, `ds_itemplanilla`, `nu_orden`) VALUES (21, 'Congresos: Res�menes publicados en actas con Referatos', '6');

INSERT INTO itemmaximo VALUES (31, null, 1, 5, 1, 5);
INSERT INTO itemmaximo VALUES (31, null, 2, 3, 1, 3);
INSERT INTO itemmaximo VALUES (31, null, 3, 4, 1, 4);
INSERT INTO itemmaximo VALUES (31, null, 12, 3, 1, 3);
INSERT INTO itemmaximo VALUES (31, null, 13, 1, 1, 1);
INSERT INTO itemmaximo VALUES (31, null, 4, 2, 2, 2);
INSERT INTO itemmaximo VALUES (31, null, 18, 6, 37, 6);
INSERT INTO itemmaximo VALUES (31, null, 19, 4, 37, 4);
INSERT INTO itemmaximo VALUES (31, null, 8, 2, 37, 2);
INSERT INTO itemmaximo VALUES (31, null, 20, 2.5, 4, 2.5);
INSERT INTO itemmaximo VALUES (31, null, 17, 0.5, 5, 0.5);
INSERT INTO itemmaximo VALUES (31, null, 15, 1, 5, 1);



INSERT INTO itemmaximo VALUES (32, null, 1, 5, 38, 5);
INSERT INTO itemmaximo VALUES (32, null, 12, 3, 38, 3);
INSERT INTO itemmaximo VALUES (32, null, 2, 3, 38, 3);
INSERT INTO itemmaximo VALUES (32, null, 3, 4, 38, 4);
INSERT INTO itemmaximo VALUES (32, null, 13, 1, 38, 1);
INSERT INTO itemmaximo VALUES (32, null, 4, 3, 39, 3);
INSERT INTO itemmaximo VALUES (32, null, 21, 0.2, 39, 0.2);
INSERT INTO itemmaximo VALUES (32, null, 18, 6, 40, 6);
INSERT INTO itemmaximo VALUES (32, null, 19, 4, 40, 4);
INSERT INTO itemmaximo VALUES (32, null, 8, 2, 40, 2);
INSERT INTO itemmaximo VALUES (32, null, 20, 2.5, 9, 2.5);
INSERT INTO itemmaximo VALUES (32, null, 17, 0.5, 10, 0.5);
INSERT INTO itemmaximo VALUES (32, null, 15, 1, 10, 1);

INSERT INTO itemmaximo VALUES (33, null, 1, 2.5, 11, 2.5);
INSERT INTO itemmaximo VALUES (33, null, 12, 1.5, 11, 1.5);
INSERT INTO itemmaximo VALUES (33, null, 2, 1.5, 11, 1.5);
INSERT INTO itemmaximo VALUES (33, null, 3, 3, 11, 3);
INSERT INTO itemmaximo VALUES (33, null, 13, 1, 11, 1);
INSERT INTO itemmaximo VALUES (33, null, 4, 1, 41, 1);
INSERT INTO itemmaximo VALUES (33, null, 18, 3, 42, 3);
INSERT INTO itemmaximo VALUES (33, null, 19, 2, 42, 2);
INSERT INTO itemmaximo VALUES (33, null, 8, 1, 42, 1);
INSERT INTO itemmaximo VALUES (33, null, 20, 1.5, 14, 1.5);
INSERT INTO itemmaximo VALUES (33, null, 17, 0.25, 15, 0.25);
INSERT INTO itemmaximo VALUES (33, null, 15, 0.5, 15, 0.5);

INSERT INTO itemmaximo VALUES (34, null, 1, 2.5, 43, 2.5);
INSERT INTO itemmaximo VALUES (34, null, 12, 1.5, 43, 1.5);
INSERT INTO itemmaximo VALUES (34, null, 2, 1.5, 43, 1.5);
INSERT INTO itemmaximo VALUES (34, null, 3, 3, 43, 3);
INSERT INTO itemmaximo VALUES (34, null, 13, 1, 43, 1);
INSERT INTO itemmaximo VALUES (34, null, 4, 2, 44, 2);
INSERT INTO itemmaximo VALUES (34, null, 21, 0.1, 44, 0.1);
INSERT INTO itemmaximo VALUES (34, null, 18, 3, 45, 3);
INSERT INTO itemmaximo VALUES (34, null, 19, 2, 45, 2);
INSERT INTO itemmaximo VALUES (34, null, 8, 1, 45, 1);
INSERT INTO itemmaximo VALUES (34, null, 20, 1, 19, 1);
INSERT INTO itemmaximo VALUES (34, null, 17, 0.25, 20, 0.25);
INSERT INTO itemmaximo VALUES (34, null, 15, 0.5, 20, 0.5);

INSERT INTO itemmaximo VALUES (35, null, 1, 2.5, 21, 2.5);
INSERT INTO itemmaximo VALUES (35, null, 12, 1.5, 21, 1.5);
INSERT INTO itemmaximo VALUES (35, null, 2, 1.5, 21, 1.5);
INSERT INTO itemmaximo VALUES (35, null, 3, 3, 21, 3);
INSERT INTO itemmaximo VALUES (35, null, 13, 1, 21, 1);
INSERT INTO itemmaximo VALUES (35, null, 4, 1, 46, 1);
INSERT INTO itemmaximo VALUES (35, null, 18, 3, 47, 3);
INSERT INTO itemmaximo VALUES (35, null, 19, 2, 47, 2);
INSERT INTO itemmaximo VALUES (35, null, 8, 1, 47, 1);
INSERT INTO itemmaximo VALUES (35, null, 20, 1.5, 24, 1.5);
INSERT INTO itemmaximo VALUES (35, null, 17, 0.25, 25, 0.25);
INSERT INTO itemmaximo VALUES (35, null, 15, 0.5, 25, 0.5);

INSERT INTO `eventoplanilla` (`cd_eventoplanilla`, `ds_eventoplanilla`, `nu_orden`) VALUES (15, 'Justificaci�n y relaci�n con el proyecto de investigaci�n', '1');

INSERT INTO `eventoplanilla` (`cd_eventoplanilla`, `ds_eventoplanilla`, `nu_orden`) VALUES (16, 'Relevancia institucional: (-La importancia del evento con relaci�n al tema del solicitante, -Su contribuci�n al
proyecto que integra, -La relevancia de su participaci�n para transferir y fortalecer l�neas de investigaci�n de la Unidad
Acad�mica, -El establecimiento o afianzamiento de v�nculos con otros equipos o investigadores particulares, -Los
potenciales canales de difusi�n que pueden surgir a partir del evento)', '1');

INSERT INTO `eventoplanilla` (`cd_eventoplanilla`, `ds_eventoplanilla`, `nu_orden`) VALUES (17, 'Justificaci�n y Relaci�n del plan de trabajo del investigador invitado con el proyecto de investigaci�n acreditado del grupo receptor', '1');

INSERT INTO `eventoplanilla` (`cd_eventoplanilla`, `ds_eventoplanilla`, `nu_orden`) VALUES (18, 'Aportes del desarrollo del plan de trabajo al grupo de investigaci�n, Unidad de Investigaci�n y/o Unidad Acad�mica', '1');


INSERT INTO eventomaximo VALUES (31, null, 15, 8, 26, 0);
INSERT INTO eventomaximo VALUES (31, null, 16, 2, 26, 0);
INSERT INTO eventomaximo VALUES (31, null, 14, 3, 26, 0);
INSERT INTO eventomaximo VALUES (31, null, 12, 10, 26, 10);
INSERT INTO eventomaximo VALUES (31, null, 13, 2, 26, 2);

INSERT INTO eventomaximo VALUES (32, null, 15, 11, 27, 0);
INSERT INTO eventomaximo VALUES (32, null, 16, 3, 27, 0);
INSERT INTO eventomaximo VALUES (32, null, 14, 4, 27, 0);
INSERT INTO eventomaximo VALUES (32, null, 12, 10, 27, 10);
INSERT INTO eventomaximo VALUES (32, null, 13, 2, 27, 2);

INSERT INTO eventomaximo VALUES (33, null, 11, 8, 28, 0);
INSERT INTO eventomaximo VALUES (33, null, 6, 2, 28, 0);
INSERT INTO eventomaximo VALUES (33, null, 10, 1, 28, 1);
INSERT INTO eventomaximo VALUES (33, null, 12, 7, 28, 7);
INSERT INTO eventomaximo VALUES (33, null, 13, 2, 28, 2);

INSERT INTO eventomaximo VALUES (34, null, 11, 9, 29, 0);
INSERT INTO eventomaximo VALUES (34, null, 6, 3, 29, 0);
INSERT INTO eventomaximo VALUES (34, null, 10, 1, 29, 1);
INSERT INTO eventomaximo VALUES (34, null, 12, 10, 29, 10);
INSERT INTO eventomaximo VALUES (34, null, 13, 2, 29, 2);

INSERT INTO eventomaximo VALUES (35, null, 17, 13, 30, 0);
INSERT INTO eventomaximo VALUES (35, null, 18, 2, 30, 0);
INSERT INTO eventomaximo VALUES (35, null, 7, 2, 30, 2);
INSERT INTO eventomaximo VALUES (35, null, 12, 6, 30, 6);
INSERT INTO eventomaximo VALUES (35, null, 13, 2, 30, 2);


ALTER TABLE `puntajeplan`
	ADD COLUMN `ds_justificacion` TEXT NULL AFTER `nu_puntaje`;

ALTER TABLE `puntajeevento`
	ADD COLUMN `ds_justificacion` TEXT NULL AFTER `nu_puntaje`;

CREATE TABLE IF NOT EXISTS `estadoevaluacion` (
  `cd_estado` int(11) NOT NULL AUTO_INCREMENT,
  `ds_estado` varchar(30) NOT NULL,
  PRIMARY KEY (`cd_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

--
-- Volcar la base de datos para la tabla `estado`
--

INSERT INTO `estadoevaluacion` (`cd_estado`, `ds_estado`) VALUES
(1, 'Creada'),
(2, 'Recibida'),
(3, 'Aceptada'),
(4, 'Rechazada'),

(6, 'En evaluaci�n'),

(8, 'Evaluada');

INSERT INTO `unidadaprobadaviajes` (`cd_unidad`, `cd_periodo`) VALUES
(1874, 8),
(1899, 8),
(5380, 8),
(5381, 8),
(5383, 8),
(5415, 8),
(5416, 8),
(5419, 8),
(5420, 8),
(5421, 8),
(5422, 8),
(5423, 8),
(5424, 8),
(5425, 8),
(5426, 8),
(5738, 8),
(5739, 8),
(6292, 8),
(6302, 8),
(6303, 8),
(6325, 8),
(6995, 8),
(7790, 8),
(7835, 8),
(8017, 8),
(8378, 8),
(10311, 8),
(11097, 8),
(11992, 8),
(12366, 8),
(12706, 8),
(12928, 8),
(12992, 8),
(13029, 8),
(13074, 8),
(13078, 8),
(13086, 8),
(13160, 8),
(13170, 8),
(13177, 8),
(13209, 8),
(13865, 8),
(13942, 8),
(14050, 8),
(14102, 8),
(14122, 8),
(14330, 8),
(14536, 8),
(20009, 8),
(20010, 8),
(20012, 8),
(20013, 8),
(20260, 8),
(20408, 8),
(20461, 8),
(21075, 8),
(21076, 8),
(21594, 8),
(22104, 8),
(22126, 8),
(22246, 8),
(22262, 8),
(22347, 8),
(22514, 8),
(22515, 8),
(22516, 8),
(22518, 8),
(22519, 8),
(110129, 8),
(110130, 8),
(110131, 8),
(110332, 8),
(110334, 8),
(110505, 8),
(110524, 8),
(110525, 8),
(110526, 8),
(110603, 8),
(110620, 8),
(110621, 8),
(110633, 8),
(110634, 8),
(110635, 8),
(110636, 8),
(111012, 8),
(111027, 8),
(111108, 8),
(111120, 8),
(111122, 8),
(111123, 8),
(111124, 8),
(111126, 8),
(111128, 8),
(111130, 8),
(111131, 8),
(111228, 8),
(111233, 8),
(111234, 8),
(111236, 8),
(111237, 8),
(111238, 8),
(111324, 8),
(111414, 8),
(111415, 8),
(111611, 8),
(111712, 8),
(111720, 8),
(111827, 8),
(111839, 8),
(111849, 8),
(111850, 8),
(111851, 8),
(111852, 8),
(111853, 8),
(111862, 8),
(900003, 8),
(900007, 8),
(900008, 8),
(900009, 8),
(900010, 8),
(900011, 8),
(900012, 8),
(900013, 8),
(900014, 8),
(900015, 8),
(900016, 8),
(900017, 8),
(900018, 8),
(900019, 8),
(900020, 8),
(900021, 8),
(900022, 8),
(900023, 8),
(900024, 8),
(900025, 8),
(900026, 8),
(900027, 8),
(900028, 8),
(900029, 8),
(900030, 8),
(900031, 8),
(900032, 8),
(900033, 8),
(900034, 8),
(111863, 8),
(900035, 8),
(900036, 8),
(900037, 8),
(900038, 8),
(900039, 8),
(5384, 8),
(5372, 8),
(110335, 8),
(20216, 8),
(900040, 8),
(900041, 8),
(900042, 8),
(900043, 8),
(900044, 8),
(900045, 8);

#########################################################06/02/2018####################################################################

ALTER TABLE `beca`
	ADD COLUMN `ds_resumen` TEXT NULL DEFAULT NULL;


ALTER TABLE `solicitud`

	ADD COLUMN `ds_justificacionB` TEXT NULL DEFAULT NULL;

#######################################################16/02/2018########################################################################3
INSERT INTO `unidadaprobadaviajes` (`cd_unidad`, `cd_periodo`) VALUES
(1874, 9),
(1899, 9),
(5380, 9),
(5381, 9),
(5383, 9),
(5415, 9),
(5416, 9),
(5419, 9),
(5420, 9),
(5421, 9),
(5422, 9),
(5423, 9),
(5424, 9),
(5425, 9),
(5426, 9),
(5738, 9),
(5739, 9),
(6292, 9),
(6302, 9),
(6303, 9),
(6325, 9),
(6995, 9),
(7790, 9),
(7835, 9),
(8017, 9),
(8378, 9),
(10311, 9),
(11097, 9),
(11992, 9),
(12366, 9),
(12706, 9),
(12928, 9),
(12992, 9),
(13029, 9),
(13074, 9),
(13078, 9),
(13086, 9),
(13160, 9),
(13170, 9),
(13177, 9),
(13209, 9),
(13865, 9),
(13942, 9),
(14050, 9),
(14102, 9),
(14122, 9),
(14330, 9),
(14536, 9),
(20009, 9),
(20010, 9),
(20012, 9),
(20013, 9),
(20260, 9),
(20408, 9),
(20461, 9),
(21075, 9),
(21076, 9),
(21594, 9),
(22104, 9),
(22126, 9),
(22246, 9),
(22262, 9),
(22347, 9),
(22514, 9),
(22515, 9),
(22516, 9),
(22518, 9),
(22519, 9),
(110129, 9),
(110130, 9),
(110131, 9),
(110332, 9),
(110334, 9),
(110505, 9),
(110524, 9),
(110525, 9),
(110526, 9),
(110603, 9),
(110620, 9),
(110621, 9),
(110633, 9),
(110634, 9),
(110635, 9),
(110636, 9),
(111012, 9),
(111027, 9),
(111108, 9),
(111120, 9),
(111122, 9),
(111123, 9),
(111124, 9),
(111126, 9),
(111128, 9),
(111130, 9),
(111131, 9),
(111228, 9),
(111233, 9),
(111234, 9),
(111236, 9),
(111237, 9),
(111238, 9),
(111324, 9),
(111414, 9),
(111415, 9),
(111611, 9),
(111712, 9),
(111720, 9),
(111827, 9),
(111839, 9),
(111849, 9),
(111850, 9),
(111851, 9),
(111852, 9),
(111853, 9),
(111862, 9),
(900003, 9),
(900007, 9),
(900008, 9),
(900009, 9),
(900010, 9),
(900011, 9),
(900012, 9),
(900013, 9),
(900014, 9),
(900015, 9),
(900016, 9),
(900017, 9),
(900018, 9),
(900019, 9),
(900020, 9),
(900021, 9),
(900022, 9),
(900023, 9),
(900024, 9),
(900025, 9),
(900026, 9),
(900027, 9),
(900028, 9),
(900029, 9),
(900030, 9),
(900031, 9),
(900032, 9),
(900033, 9),
(900034, 9),
(111863, 9),
(900035, 9),
(900036, 9),
(900037, 9),
(900038, 9),
(900039, 9),
(5384, 9),
(5372, 9),
(110335, 9),
(20216, 9),
(900040, 9),
(900041, 9),
(900042, 9),
(900043, 9),
(900044, 9),
(900045, 9),
(900046, 9),
(900047, 9),
(900048, 9),
(900049, 9),
(900050, 9),
(900051, 9)
(9145, 9),
(110716, 9),
(110717, 9),
(900052, 9),
(900053, 9);

#######################################################03/04/2018########################################################################

INSERT INTO modeloplanilla VALUES (36, 1, 3, 'A formados', 100, 9);
INSERT INTO modeloplanilla VALUES (37, 1, 4, 'A en formaci�n', 100, 9);
INSERT INTO modeloplanilla VALUES (38, 2, 3, 'B formados', 100, 9);
INSERT INTO modeloplanilla VALUES (39, 2, 4, 'B en formaci�n', 100, 9);
INSERT INTO modeloplanilla VALUES (40, 3, 3, 'C', 100, 9);



INSERT INTO planmaximo VALUES (38, null, 20);
INSERT INTO planmaximo VALUES (39, null, 20);
INSERT INTO planmaximo VALUES (40, null, 20);

INSERT INTO categoriamaximo VALUES (36, null, 6, 5);
INSERT INTO categoriamaximo VALUES (36, null, 7, 4);
INSERT INTO categoriamaximo VALUES (36, null, 8, 2);
INSERT INTO categoriamaximo VALUES (36, null, 1, 0);
INSERT INTO categoriamaximo VALUES (36, null, 9, 1.5);
INSERT INTO categoriamaximo VALUES (36, null, 10, 1);
INSERT INTO categoriamaximo VALUES (37, null, 9, 5);
INSERT INTO categoriamaximo VALUES (37, null, 10, 2.5);
INSERT INTO categoriamaximo VALUES (37, null, 1, 0);
INSERT INTO categoriamaximo VALUES (38, null, 6, 5);
INSERT INTO categoriamaximo VALUES (38, null, 7, 4);
INSERT INTO categoriamaximo VALUES (38, null, 8, 2);
INSERT INTO categoriamaximo VALUES (38, null, 1, 0);
INSERT INTO categoriamaximo VALUES (38, null, 9, 1.5);
INSERT INTO categoriamaximo VALUES (38, null, 10, 1);
INSERT INTO categoriamaximo VALUES (39, null, 9, 5);
INSERT INTO categoriamaximo VALUES (39, null, 10, 2.5);
INSERT INTO categoriamaximo VALUES (39, null, 1, 0);
INSERT INTO categoriamaximo VALUES (40, null, 6, 5);
INSERT INTO categoriamaximo VALUES (40, null, 7, 4);
INSERT INTO categoriamaximo VALUES (40, null, 8, 2);
INSERT INTO categoriamaximo VALUES (40, null, 1, 0);
INSERT INTO categoriamaximo VALUES (40, null, 9, 1.5);
INSERT INTO categoriamaximo VALUES (40, null, 10, 1);

INSERT INTO cargomaximo VALUES (36, null, 1, 15);
INSERT INTO cargomaximo VALUES (36, null, 2, 13);
INSERT INTO cargomaximo VALUES (36, null, 3, 13);
INSERT INTO cargomaximo VALUES (36, null, 4, 11);
INSERT INTO cargomaximo VALUES (36, null, 5, 11);
INSERT INTO cargomaximo VALUES (36, null, 6, 9);
INSERT INTO cargomaximo VALUES (36, null, 7, 9);
INSERT INTO cargomaximo VALUES (36, null, 8, 7);
INSERT INTO cargomaximo VALUES (36, null, 9, 6);
INSERT INTO cargomaximo VALUES (36, null, 10, 4);
INSERT INTO cargomaximo VALUES (37, null, 1, 15);
INSERT INTO cargomaximo VALUES (37, null, 2, 13);
INSERT INTO cargomaximo VALUES (37, null, 3, 13);
INSERT INTO cargomaximo VALUES (37, null, 4, 11);
INSERT INTO cargomaximo VALUES (37, null, 5, 11);
INSERT INTO cargomaximo VALUES (37, null, 6, 9);
INSERT INTO cargomaximo VALUES (37, null, 7, 9);
INSERT INTO cargomaximo VALUES (37, null, 8, 7);
INSERT INTO cargomaximo VALUES (37, null, 9, 6);
INSERT INTO cargomaximo VALUES (37, null, 10, 4);
INSERT INTO cargomaximo VALUES (38, null, 1, 8);
INSERT INTO cargomaximo VALUES (38, null, 2, 7);
INSERT INTO cargomaximo VALUES (38, null, 3, 7);
INSERT INTO cargomaximo VALUES (38, null, 4, 6);
INSERT INTO cargomaximo VALUES (38, null, 5, 6);
INSERT INTO cargomaximo VALUES (38, null, 6, 5);
INSERT INTO cargomaximo VALUES (38, null, 7, 5);
INSERT INTO cargomaximo VALUES (38, null, 8, 4);
INSERT INTO cargomaximo VALUES (38, null, 9, 4);
INSERT INTO cargomaximo VALUES (38, null, 10, 3);
INSERT INTO cargomaximo VALUES (39, null, 1, 8);
INSERT INTO cargomaximo VALUES (39, null, 2, 7);
INSERT INTO cargomaximo VALUES (39, null, 3, 7);
INSERT INTO cargomaximo VALUES (39, null, 4, 6);
INSERT INTO cargomaximo VALUES (39, null, 5, 6);
INSERT INTO cargomaximo VALUES (39, null, 6, 5);
INSERT INTO cargomaximo VALUES (39, null, 7, 5);
INSERT INTO cargomaximo VALUES (39, null, 8, 4);
INSERT INTO cargomaximo VALUES (39, null, 9, 4);
INSERT INTO cargomaximo VALUES (39, null, 10, 3);
INSERT INTO cargomaximo VALUES (40, null, 1, 5);
INSERT INTO cargomaximo VALUES (40, null, 2, 4);
INSERT INTO cargomaximo VALUES (40, null, 3, 4);
INSERT INTO cargomaximo VALUES (40, null, 4, 3);
INSERT INTO cargomaximo VALUES (40, null, 5, 3);
INSERT INTO cargomaximo VALUES (40, null, 6, 2);
INSERT INTO cargomaximo VALUES (40, null, 7, 2);
INSERT INTO cargomaximo VALUES (40, null, 8, 1);
INSERT INTO cargomaximo VALUES (40, null, 9, 1);
INSERT INTO cargomaximo VALUES (40, null, 10, 0);

INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (75, 'AFprod1_Padre', '45');

INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`, cd_grupopadre) VALUES (56, 'AFprod1', '35',75);
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (57, 'AFprod2', '10');
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (58, 'AFprod3', '15');

INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (59, 'AFform1', '6');
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (60, 'AFform2', '4');

INSERT INTO itemmaximo VALUES (36, null, 1, 5, 56, 5);
INSERT INTO itemmaximo VALUES (36, null, 2, 3, 56, 3);
INSERT INTO itemmaximo VALUES (36, null, 3, 4, 56, 4);
INSERT INTO itemmaximo VALUES (36, null, 12, 3, 56, 3);
INSERT INTO itemmaximo VALUES (36, null, 13, 1, 56, 1);
INSERT INTO itemmaximo VALUES (36, null, 4, 2, 57, 2);
INSERT INTO itemmaximo VALUES (36, null, 18, 6, 58, 6);
INSERT INTO itemmaximo VALUES (36, null, 19, 4, 58, 4);
INSERT INTO itemmaximo VALUES (36, null, 8, 2, 58, 2);
INSERT INTO itemmaximo VALUES (36, null, 20, 2.5, 59, 2.5);
INSERT INTO itemmaximo VALUES (36, null, 17, 0.5, 60, 0.5);
INSERT INTO itemmaximo VALUES (36, null, 15, 1, 60, 1);

INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (76, 'AnFprod1_Padre', '45');

INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`, cd_grupopadre) VALUES (61, 'AnFprod1', '35', 76);

INSERT INTO itemmaximo VALUES (37, null, 1, 5, 61, 5);
INSERT INTO itemmaximo VALUES (37, null, 12, 3, 61, 3);
INSERT INTO itemmaximo VALUES (37, null, 2, 3, 61, 3);
INSERT INTO itemmaximo VALUES (37, null, 3, 4, 61, 4);
INSERT INTO itemmaximo VALUES (37, null, 13, 1, 61, 1);
INSERT INTO itemmaximo VALUES (37, null, 4, 3, 39, 3);
INSERT INTO itemmaximo VALUES (37, null, 21, 0.2, 39, 0.2);
INSERT INTO itemmaximo VALUES (37, null, 18, 6, 40, 6);
INSERT INTO itemmaximo VALUES (37, null, 19, 4, 40, 4);
INSERT INTO itemmaximo VALUES (37, null, 8, 2, 40, 2);
INSERT INTO itemmaximo VALUES (37, null, 20, 2.5, 9, 2.5);
INSERT INTO itemmaximo VALUES (37, null, 17, 0.5, 10, 0.5);
INSERT INTO itemmaximo VALUES (37, null, 15, 1, 10, 1);

INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (77, 'BFprod1_Padre', '37');

INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`, cd_grupopadre) VALUES (62, 'BFprod1', '30', 77);
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (63, 'BFprod2', '8');
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (64, 'BFprod3', '10');
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (65, 'BFform1', '6');
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (66, 'BFform2', '4');

INSERT INTO itemmaximo VALUES (38, null, 1, 2.5, 62, 2.5);
INSERT INTO itemmaximo VALUES (38, null, 12, 1.5, 62, 1.5);
INSERT INTO itemmaximo VALUES (38, null, 2, 1.5, 62, 1.5);
INSERT INTO itemmaximo VALUES (38, null, 3, 3, 62, 3);
INSERT INTO itemmaximo VALUES (38, null, 13, 1, 62, 1);
INSERT INTO itemmaximo VALUES (38, null, 4, 1, 63, 1);
INSERT INTO itemmaximo VALUES (38, null, 18, 3, 64, 3);
INSERT INTO itemmaximo VALUES (38, null, 19, 2, 64, 2);
INSERT INTO itemmaximo VALUES (38, null, 8, 1, 64, 1);
INSERT INTO itemmaximo VALUES (38, null, 20, 1.5, 65, 1.5);
INSERT INTO itemmaximo VALUES (38, null, 17, 0.25, 66, 0.25);
INSERT INTO itemmaximo VALUES (38, null, 15, 0.5, 66, 0.5);

INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (78, 'BnFprod1_Padre', '40');

INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`, cd_grupopadre) VALUES (67, 'BnFprod1', '35',78);
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (68, 'BnFprod2', '15');
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (69, 'BnFprod3', '10');

INSERT INTO itemmaximo VALUES (39, null, 1, 2.5, 67, 2.5);
INSERT INTO itemmaximo VALUES (39, null, 12, 1.5, 67, 1.5);
INSERT INTO itemmaximo VALUES (39, null, 2, 1.5, 67, 1.5);
INSERT INTO itemmaximo VALUES (39, null, 3, 3, 67, 3);
INSERT INTO itemmaximo VALUES (39, null, 13, 1, 67, 1);
INSERT INTO itemmaximo VALUES (39, null, 4, 2, 68, 2);
INSERT INTO itemmaximo VALUES (39, null, 21, 0.1, 68, 0.1);
INSERT INTO itemmaximo VALUES (39, null, 18, 3, 69, 3);
INSERT INTO itemmaximo VALUES (39, null, 19, 2, 69, 2);
INSERT INTO itemmaximo VALUES (39, null, 8, 1, 69, 1);
INSERT INTO itemmaximo VALUES (39, null, 20, 1, 19, 1);
INSERT INTO itemmaximo VALUES (39, null, 17, 0.25, 20, 0.25);
INSERT INTO itemmaximo VALUES (39, null, 15, 0.5, 20, 0.5);

INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (79, 'Cprod1_Padre', '35');

INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`, cd_grupopadre) VALUES (70, 'Cprod1', '30',79);
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (71, 'Cprod2', '8');
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (72, 'Cprod3', '10');
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (73, 'Cform1', '6');
INSERT INTO `puntajegrupo` (`cd_puntajegrupo`, `ds_puntajegrupo`, `nu_max`) VALUES (74, 'Cform2', '4');


INSERT INTO itemmaximo VALUES (40, null, 1, 2.5, 70, 2.5);
INSERT INTO itemmaximo VALUES (40, null, 12, 1.5, 70, 1.5);
INSERT INTO itemmaximo VALUES (40, null, 2, 1.5, 70, 1.5);
INSERT INTO itemmaximo VALUES (40, null, 3, 3, 70, 3);
INSERT INTO itemmaximo VALUES (40, null, 13, 1, 70, 1);
INSERT INTO itemmaximo VALUES (40, null, 4, 1, 71, 1);
INSERT INTO itemmaximo VALUES (40, null, 18, 3, 72, 3);
INSERT INTO itemmaximo VALUES (40, null, 19, 2, 72, 2);
INSERT INTO itemmaximo VALUES (40, null, 8, 1, 72, 1);
INSERT INTO itemmaximo VALUES (40, null, 20, 1.5, 73, 1.5);
INSERT INTO itemmaximo VALUES (40, null, 17, 0.25, 74, 0.25);
INSERT INTO itemmaximo VALUES (40, null, 15, 0.5, 74, 0.5);

INSERT INTO eventomaximo VALUES (36, null, 15, 8, 26, 0);
INSERT INTO eventomaximo VALUES (36, null, 16, 2, 26, 0);
INSERT INTO eventomaximo VALUES (36, null, 14, 3, 26, 0);
INSERT INTO eventomaximo VALUES (36, null, 12, 10, 26, 10);
INSERT INTO eventomaximo VALUES (36, null, 13, 2, 26, 2);

INSERT INTO eventomaximo VALUES (37, null, 15, 11, 27, 0);
INSERT INTO eventomaximo VALUES (37, null, 16, 3, 27, 0);
INSERT INTO eventomaximo VALUES (37, null, 14, 4, 27, 0);
INSERT INTO eventomaximo VALUES (37, null, 12, 10, 27, 10);
INSERT INTO eventomaximo VALUES (37, null, 13, 2, 27, 2);

INSERT INTO eventomaximo VALUES (38, null, 15, 6, 28, 0);
INSERT INTO eventomaximo VALUES (38, null, 16, 2, 28, 0);
INSERT INTO eventomaximo VALUES (38, null, 6, 2, 28, 0);
INSERT INTO eventomaximo VALUES (38, null, 10, 1, 28, 1);
INSERT INTO eventomaximo VALUES (38, null, 12, 7, 28, 7);
INSERT INTO eventomaximo VALUES (38, null, 13, 2, 28, 2);

INSERT INTO eventomaximo VALUES (39, null, 15, 7, 29, 0);
INSERT INTO eventomaximo VALUES (39, null, 16, 2, 29, 0);
INSERT INTO eventomaximo VALUES (39, null, 6, 3, 29, 0);
INSERT INTO eventomaximo VALUES (39, null, 10, 1, 29, 1);
INSERT INTO eventomaximo VALUES (39, null, 12, 10, 29, 10);
INSERT INTO eventomaximo VALUES (39, null, 13, 2, 29, 2);

INSERT INTO eventomaximo VALUES (40, null, 17, 13, 30, 0);
INSERT INTO eventomaximo VALUES (40, null, 18, 2, 30, 0);
INSERT INTO eventomaximo VALUES (40, null, 7, 2, 30, 2);
INSERT INTO eventomaximo VALUES (40, null, 12, 6, 30, 6);
INSERT INTO eventomaximo VALUES (40, null, 13, 2, 30, 2);

#######################################################05/02/2019########################################################################3

ALTER TABLE `solicitud`
	ADD COLUMN `ds_googleScholar` VARCHAR(255) NULL AFTER `ds_justificacionB`;

UPDATE `motivo` SET `ds_motivo`='A) Reuniones Científicas:' WHERE  `cd_motivo`=1;


INSERT INTO `unidadaprobadaviajes` (`cd_unidad`, `cd_periodo`) VALUES
(1874, 10),
(1899, 10),
(5380, 10),
(5381, 10),
(5383, 10),
(5415, 10),
(5416, 10),
(5419, 10),
(5420, 10),
(5421, 10),
(5422, 10),
(5423, 10),
(5424, 10),
(5425, 10),
(5426, 10),
(5738, 10),
(5739, 10),
(6292, 10),
(6302, 10),
(6303, 10),
(6325, 10),
(6995, 10),
(7790, 10),
(7835, 10),
(8017, 10),
(8378, 10),
(10311, 10),
(11097, 10),
(11992, 10),
(12366, 10),
(12706, 10),
(12928, 10),
(12992, 10),
(13029, 10),
(13074, 10),
(13078, 10),
(13086, 10),
(13160, 10),
(13170, 10),
(13177, 10),
(13209, 10),
(13865, 10),
(13942, 10),
(14050, 10),
(14102, 10),
(14122, 10),
(14330, 10),
(14536, 10),
(20009, 10),
(20010, 10),
(20012, 10),
(20013, 10),
(20260, 10),
(20408, 10),
(20461, 10),
(21075, 10),
(21076, 10),
(21594, 10),
(22104, 10),
(22126, 10),
(22246, 10),
(22262, 10),
(22347, 10),
(22514, 10),
(22515, 10),
(22516, 10),
(22518, 10),
(22519, 10),
(110129, 10),
(110130, 10),
(110131, 10),
(110332, 10),
(110334, 10),
(110505, 10),
(110524, 10),
(110525, 10),
(110526, 10),
(110603, 10),
(110620, 10),
(110621, 10),
(110633, 10),
(110634, 10),
(110635, 10),
(110636, 10),
(111012, 10),
(111027, 10),
(111108, 10),
(111120, 10),
(111122, 10),
(111123, 10),
(111124, 10),
(111126, 10),
(111128, 10),
(111130, 10),
(111131, 10),
(111228, 10),
(111233, 10),
(111234, 10),
(111236, 10),
(111237, 10),
(111238, 10),
(111324, 10),
(111414, 10),
(111415, 10),
(111611, 10),
(111712, 10),
(111720, 10),
(111827, 10),
(111839, 10),
(111849, 10),
(111850, 10),
(111851, 10),
(111852, 10),
(111853, 10),
(111862, 10),
(900003, 10),
(900007, 10),
(900008, 10),
(900009, 10),
(900010, 10),
(900011, 10),
(900012, 10),
(900013, 10),
(900014, 10),
(900015, 10),
(900016, 10),
(900017, 10),
(900018, 10),
(900019, 10),
(900020, 10),
(900021, 10),
(900022, 10),
(900023, 10),
(900024, 10),
(900025, 10),
(900026, 10),
(900027, 10),
(900028, 10),
(900029, 10),
(900030, 10),
(900031, 10),
(900032, 10),
(900033, 10),
(900034, 10),
(111863, 10),
(900035, 10),
(900036, 10),
(900037, 10),
(900038, 10),
(900039, 10),
(5384, 10),
(5372, 10),
(110335, 10),
(20216, 10),
(900040, 10),
(900041, 10),
(900042, 10),
(900043, 10),
(900044, 10),
(900045, 10),
(900046, 10),
(900047, 10),
(900048, 10),
(900049, 10),
(900050, 10),
(900051, 10),
(9145, 10),
(110716, 10),
(110717, 10),
(900052, 10),
(900053, 10),
(111132, 10),
(111133, 10),
(110544, 10),
(111240, 10),
(111134, 10),
(111864, 10);

#######################################################02/05/2019########################################################################

INSERT INTO modeloplanilla VALUES (41, 1, 3, 'A formados', 100, 10);
INSERT INTO modeloplanilla VALUES (42, 1, 4, 'A en formación', 100, 10);
INSERT INTO modeloplanilla VALUES (43, 2, 3, 'B formados', 100, 10);
INSERT INTO modeloplanilla VALUES (44, 2, 4, 'B en formación', 100, 10);
INSERT INTO modeloplanilla VALUES (45, 3, 3, 'C', 100, 10);



INSERT INTO planmaximo VALUES (43, null, 20);
INSERT INTO planmaximo VALUES (44, null, 20);
INSERT INTO planmaximo VALUES (45, null, 20);

INSERT INTO categoriamaximo VALUES (41, null, 6, 5);
INSERT INTO categoriamaximo VALUES (41, null, 7, 4);
INSERT INTO categoriamaximo VALUES (41, null, 8, 2);
INSERT INTO categoriamaximo VALUES (41, null, 1, 0);
INSERT INTO categoriamaximo VALUES (41, null, 9, 1.5);
INSERT INTO categoriamaximo VALUES (41, null, 10, 1);
INSERT INTO categoriamaximo VALUES (42, null, 9, 5);
INSERT INTO categoriamaximo VALUES (42, null, 10, 2.5);
INSERT INTO categoriamaximo VALUES (42, null, 1, 0);
INSERT INTO categoriamaximo VALUES (43, null, 6, 5);
INSERT INTO categoriamaximo VALUES (43, null, 7, 4);
INSERT INTO categoriamaximo VALUES (43, null, 8, 2);
INSERT INTO categoriamaximo VALUES (43, null, 1, 0);
INSERT INTO categoriamaximo VALUES (43, null, 9, 1.5);
INSERT INTO categoriamaximo VALUES (43, null, 10, 1);
INSERT INTO categoriamaximo VALUES (44, null, 9, 5);
INSERT INTO categoriamaximo VALUES (44, null, 10, 2.5);
INSERT INTO categoriamaximo VALUES (44, null, 1, 0);
INSERT INTO categoriamaximo VALUES (45, null, 6, 5);
INSERT INTO categoriamaximo VALUES (45, null, 7, 4);
INSERT INTO categoriamaximo VALUES (45, null, 8, 2);
INSERT INTO categoriamaximo VALUES (45, null, 1, 0);
INSERT INTO categoriamaximo VALUES (45, null, 9, 1.5);
INSERT INTO categoriamaximo VALUES (45, null, 10, 1);

INSERT INTO cargomaximo VALUES (41, null, 1, 15);
INSERT INTO cargomaximo VALUES (41, null, 2, 13);
INSERT INTO cargomaximo VALUES (41, null, 3, 13);
INSERT INTO cargomaximo VALUES (41, null, 4, 11);
INSERT INTO cargomaximo VALUES (41, null, 5, 11);
INSERT INTO cargomaximo VALUES (41, null, 6, 9);
INSERT INTO cargomaximo VALUES (41, null, 7, 9);
INSERT INTO cargomaximo VALUES (41, null, 8, 7);
INSERT INTO cargomaximo VALUES (41, null, 9, 6);
INSERT INTO cargomaximo VALUES (41, null, 10, 4);
INSERT INTO cargomaximo VALUES (42, null, 1, 15);
INSERT INTO cargomaximo VALUES (42, null, 2, 13);
INSERT INTO cargomaximo VALUES (42, null, 3, 13);
INSERT INTO cargomaximo VALUES (42, null, 4, 11);
INSERT INTO cargomaximo VALUES (42, null, 5, 11);
INSERT INTO cargomaximo VALUES (42, null, 6, 9);
INSERT INTO cargomaximo VALUES (42, null, 7, 9);
INSERT INTO cargomaximo VALUES (42, null, 8, 7);
INSERT INTO cargomaximo VALUES (42, null, 9, 6);
INSERT INTO cargomaximo VALUES (42, null, 10, 4);
INSERT INTO cargomaximo VALUES (43, null, 1, 8);
INSERT INTO cargomaximo VALUES (43, null, 2, 7);
INSERT INTO cargomaximo VALUES (43, null, 3, 7);
INSERT INTO cargomaximo VALUES (43, null, 4, 6);
INSERT INTO cargomaximo VALUES (43, null, 5, 6);
INSERT INTO cargomaximo VALUES (43, null, 6, 5);
INSERT INTO cargomaximo VALUES (43, null, 7, 5);
INSERT INTO cargomaximo VALUES (43, null, 8, 4);
INSERT INTO cargomaximo VALUES (43, null, 9, 4);
INSERT INTO cargomaximo VALUES (43, null, 10, 3);
INSERT INTO cargomaximo VALUES (44, null, 1, 8);
INSERT INTO cargomaximo VALUES (44, null, 2, 7);
INSERT INTO cargomaximo VALUES (44, null, 3, 7);
INSERT INTO cargomaximo VALUES (44, null, 4, 6);
INSERT INTO cargomaximo VALUES (44, null, 5, 6);
INSERT INTO cargomaximo VALUES (44, null, 6, 5);
INSERT INTO cargomaximo VALUES (44, null, 7, 5);
INSERT INTO cargomaximo VALUES (44, null, 8, 4);
INSERT INTO cargomaximo VALUES (44, null, 9, 4);
INSERT INTO cargomaximo VALUES (44, null, 10, 3);
INSERT INTO cargomaximo VALUES (45, null, 1, 5);
INSERT INTO cargomaximo VALUES (45, null, 2, 4);
INSERT INTO cargomaximo VALUES (45, null, 3, 4);
INSERT INTO cargomaximo VALUES (45, null, 4, 3);
INSERT INTO cargomaximo VALUES (45, null, 5, 3);
INSERT INTO cargomaximo VALUES (45, null, 6, 2);
INSERT INTO cargomaximo VALUES (45, null, 7, 2);
INSERT INTO cargomaximo VALUES (45, null, 8, 1);
INSERT INTO cargomaximo VALUES (45, null, 9, 1);
INSERT INTO cargomaximo VALUES (45, null, 10, 0);


INSERT INTO itemmaximo VALUES (41, null, 1, 5, 56, 5);
INSERT INTO itemmaximo VALUES (41, null, 2, 3, 56, 3);
INSERT INTO itemmaximo VALUES (41, null, 3, 4, 56, 4);
INSERT INTO itemmaximo VALUES (41, null, 12, 3, 56, 3);
INSERT INTO itemmaximo VALUES (41, null, 13, 1, 56, 1);
INSERT INTO itemmaximo VALUES (41, null, 4, 2, 57, 2);
INSERT INTO itemmaximo VALUES (41, null, 18, 6, 58, 6);
INSERT INTO itemmaximo VALUES (41, null, 19, 4, 58, 4);
INSERT INTO itemmaximo VALUES (41, null, 8, 2, 58, 2);
INSERT INTO itemmaximo VALUES (41, null, 20, 2.5, 59, 2.5);
INSERT INTO itemmaximo VALUES (41, null, 17, 0.5, 60, 0.5);
INSERT INTO itemmaximo VALUES (41, null, 15, 1, 60, 1);


INSERT INTO itemmaximo VALUES (42, null, 1, 5, 61, 5);
INSERT INTO itemmaximo VALUES (42, null, 12, 3, 61, 3);
INSERT INTO itemmaximo VALUES (42, null, 2, 3, 61, 3);
INSERT INTO itemmaximo VALUES (42, null, 3, 4, 61, 4);
INSERT INTO itemmaximo VALUES (42, null, 13, 1, 61, 1);
INSERT INTO itemmaximo VALUES (42, null, 4, 3, 39, 3);
INSERT INTO itemmaximo VALUES (42, null, 21, 0.2, 39, 0.2);
INSERT INTO itemmaximo VALUES (42, null, 18, 6, 40, 6);
INSERT INTO itemmaximo VALUES (42, null, 19, 4, 40, 4);
INSERT INTO itemmaximo VALUES (42, null, 8, 2, 40, 2);
INSERT INTO itemmaximo VALUES (42, null, 20, 2.5, 9, 2.5);
INSERT INTO itemmaximo VALUES (42, null, 17, 0.5, 10, 0.5);
INSERT INTO itemmaximo VALUES (42, null, 15, 1, 10, 1);


INSERT INTO itemmaximo VALUES (43, null, 1, 2.5, 62, 2.5);
INSERT INTO itemmaximo VALUES (43, null, 12, 1.5, 62, 1.5);
INSERT INTO itemmaximo VALUES (43, null, 2, 1.5, 62, 1.5);
INSERT INTO itemmaximo VALUES (43, null, 3, 3, 62, 3);
INSERT INTO itemmaximo VALUES (43, null, 13, 1, 62, 1);
INSERT INTO itemmaximo VALUES (43, null, 4, 1, 63, 1);
INSERT INTO itemmaximo VALUES (43, null, 18, 3, 64, 3);
INSERT INTO itemmaximo VALUES (43, null, 19, 2, 64, 2);
INSERT INTO itemmaximo VALUES (43, null, 8, 1, 64, 1);
INSERT INTO itemmaximo VALUES (43, null, 20, 1.5, 65, 1.5);
INSERT INTO itemmaximo VALUES (43, null, 17, 0.25, 66, 0.25);
INSERT INTO itemmaximo VALUES (43, null, 15, 0.5, 66, 0.5);


INSERT INTO itemmaximo VALUES (44, null, 1, 2.5, 67, 2.5);
INSERT INTO itemmaximo VALUES (44, null, 12, 1.5, 67, 1.5);
INSERT INTO itemmaximo VALUES (44, null, 2, 1.5, 67, 1.5);
INSERT INTO itemmaximo VALUES (44, null, 3, 3, 67, 3);
INSERT INTO itemmaximo VALUES (44, null, 13, 1, 67, 1);
INSERT INTO itemmaximo VALUES (44, null, 4, 2, 68, 2);
INSERT INTO itemmaximo VALUES (44, null, 21, 0.1, 68, 0.1);
INSERT INTO itemmaximo VALUES (44, null, 18, 3, 69, 3);
INSERT INTO itemmaximo VALUES (44, null, 19, 2, 69, 2);
INSERT INTO itemmaximo VALUES (44, null, 8, 1, 69, 1);
INSERT INTO itemmaximo VALUES (44, null, 20, 1, 19, 1);
INSERT INTO itemmaximo VALUES (44, null, 17, 0.25, 20, 0.25);
INSERT INTO itemmaximo VALUES (44, null, 15, 0.5, 20, 0.5);


INSERT INTO itemmaximo VALUES (45, null, 1, 2.5, 70, 2.5);
INSERT INTO itemmaximo VALUES (45, null, 12, 1.5, 70, 1.5);
INSERT INTO itemmaximo VALUES (45, null, 2, 1.5, 70, 1.5);
INSERT INTO itemmaximo VALUES (45, null, 3, 3, 70, 3);
INSERT INTO itemmaximo VALUES (45, null, 13, 1, 70, 1);
INSERT INTO itemmaximo VALUES (45, null, 4, 1, 71, 1);
INSERT INTO itemmaximo VALUES (45, null, 18, 3, 72, 3);
INSERT INTO itemmaximo VALUES (45, null, 19, 2, 72, 2);
INSERT INTO itemmaximo VALUES (45, null, 8, 1, 72, 1);
INSERT INTO itemmaximo VALUES (45, null, 20, 1.5, 73, 1.5);
INSERT INTO itemmaximo VALUES (45, null, 17, 0.25, 74, 0.25);
INSERT INTO itemmaximo VALUES (45, null, 15, 0.5, 74, 0.5);

INSERT INTO eventomaximo VALUES (41, null, 15, 8, 26, 0);
INSERT INTO eventomaximo VALUES (41, null, 16, 2, 26, 0);
INSERT INTO eventomaximo VALUES (41, null, 14, 3, 26, 0);
INSERT INTO eventomaximo VALUES (41, null, 12, 10, 26, 10);
INSERT INTO eventomaximo VALUES (41, null, 13, 2, 26, 2);

INSERT INTO eventomaximo VALUES (42, null, 15, 11, 27, 0);
INSERT INTO eventomaximo VALUES (42, null, 16, 3, 27, 0);
INSERT INTO eventomaximo VALUES (42, null, 14, 4, 27, 0);
INSERT INTO eventomaximo VALUES (42, null, 12, 10, 27, 10);
INSERT INTO eventomaximo VALUES (42, null, 13, 2, 27, 2);

INSERT INTO eventomaximo VALUES (43, null, 15, 6, 28, 0);
INSERT INTO eventomaximo VALUES (43, null, 16, 2, 28, 0);
INSERT INTO eventomaximo VALUES (43, null, 6, 2, 28, 0);
INSERT INTO eventomaximo VALUES (43, null, 10, 1, 28, 1);
INSERT INTO eventomaximo VALUES (43, null, 12, 7, 28, 7);
INSERT INTO eventomaximo VALUES (43, null, 13, 2, 28, 2);

INSERT INTO eventomaximo VALUES (44, null, 15, 7, 29, 0);
INSERT INTO eventomaximo VALUES (44, null, 16, 2, 29, 0);
INSERT INTO eventomaximo VALUES (44, null, 6, 3, 29, 0);
INSERT INTO eventomaximo VALUES (44, null, 10, 1, 29, 1);
INSERT INTO eventomaximo VALUES (44, null, 12, 10, 29, 10);
INSERT INTO eventomaximo VALUES (44, null, 13, 2, 29, 2);

INSERT INTO eventomaximo VALUES (45, null, 17, 13, 30, 0);
INSERT INTO eventomaximo VALUES (45, null, 18, 2, 30, 0);
INSERT INTO eventomaximo VALUES (45, null, 7, 2, 30, 2);
INSERT INTO eventomaximo VALUES (45, null, 12, 6, 30, 6);
INSERT INTO eventomaximo VALUES (45, null, 13, 2, 30, 2);

#######################################################05/02/2020########################################################################

UPDATE `estado` SET `ds_estado`='Otorgada-Rendida' WHERE  `cd_estado`=9;
UPDATE `estado` SET `ds_estado`='Otorgada-Renunciada' WHERE  `cd_estado`=10;

INSERT INTO `estado` (`ds_estado`) VALUES ('Otorgada-Devuelta');

INSERT INTO `unidadaprobadaviajes` (`cd_unidad`, `cd_periodo`) VALUES
(1874, 11),
(1899, 11),
(5380, 11),
(5381, 11),
(5383, 11),
(5415, 11),
(5416, 11),
(5419, 11),
(5420, 11),
(5421, 11),
(5422, 11),
(5423, 11),
(5424, 11),
(5425, 11),
(5426, 11),
(5738, 11),
(5739, 11),
(6292, 11),
(6302, 11),
(6303, 11),
(6325, 11),
(6995, 11),
(7790, 11),
(7835, 11),
(8017, 11),
(8378, 11),
(10311, 11),
(11097, 11),
(11992, 11),
(12366, 11),
(12706, 11),
(12928, 11),
(12992, 11),
(13029, 11),
(13074, 11),
(13078, 11),
(13086, 11),
(13160, 11),
(13170, 11),
(13177, 11),
(13209, 11),
(13865, 11),
(13942, 11),
(14050, 11),
(14102, 11),
(14122, 11),
(14330, 11),
(14536, 11),
(20009, 11),
(20010, 11),
(20012, 11),
(20013, 11),
(20260, 11),
(20408, 11),
(20461, 11),
(21075, 11),
(21076, 11),
(21594, 11),
(22104, 11),
(22126, 11),
(22246, 11),
(22262, 11),
(22347, 11),
(22514, 11),
(22515, 11),
(22516, 11),
(22518, 11),
(22519, 11),
(110129, 11),
(110130, 11),
(110131, 11),
(110332, 11),
(110334, 11),
(110505, 11),
(110524, 11),
(110525, 11),
(110526, 11),
(110603, 11),
(110620, 11),
(110621, 11),
(110633, 11),
(110634, 11),
(110635, 11),
(110636, 11),
(111012, 11),
(111027, 11),
(111108, 11),
(111120, 11),
(111122, 11),
(111123, 11),
(111124, 11),
(111126, 11),
(111128, 11),
(111130, 11),
(111131, 11),
(111228, 11),
(111233, 11),
(111234, 11),
(111236, 11),
(111237, 11),
(111238, 11),
(111324, 11),
(111414, 11),
(111415, 11),
(111611, 11),
(111712, 11),
(111720, 11),
(111827, 11),
(111839, 11),
(111849, 11),
(111850, 11),
(111851, 11),
(111852, 11),
(111853, 11),
(111862, 11),
(900003, 11),
(900007, 11),
(900008, 11),
(900009, 11),
(900010, 11),
(900011, 11),
(900012, 11),
(900013, 11),
(900014, 11),
(900015, 11),
(900016, 11),
(900017, 11),
(900018, 11),
(900019, 11),
(900020, 11),
(900021, 11),
(900022, 11),
(900023, 11),
(900024, 11),
(900025, 11),
(900026, 11),
(900027, 11),
(900028, 11),
(900029, 11),
(900030, 11),
(900031, 11),
(900032, 11),
(900033, 11),
(900034, 11),
(111863, 11),
(900035, 11),
(900036, 11),
(900037, 11),
(900038, 11),
(900039, 11),
(5384, 11),
(5372, 11),
(110335, 11),
(20216, 11),
(900040, 11),
(900041, 11),
(900042, 11),
(900043, 11),
(900044, 11),
(900045, 11),
(900046, 11),
(900047, 11),
(900048, 11),
(900049, 11),
(900050, 11),
(900051, 11),
(9145, 11),
(110716, 11),
(110717, 11),
(900052, 11),
(900053, 11),
(111132, 11),
(111133, 11),
(110544, 11),
(111240, 11),
(111134, 11),
(111864, 11),
(900054, 11),
(900055, 11),
(900056, 11),
(900057, 11),
(900058, 11),
(900059, 11),
(900060, 11),
(900061, 11),
(900062, 11),
(5378, 11),
(5382, 11),
(900066, 11);

#######################################################17/06/2020########################################################################

INSERT INTO modeloplanilla VALUES (46, 1, 3, 'A formados', 100, 11);
INSERT INTO modeloplanilla VALUES (47, 1, 4, 'A en formación', 100, 11);
INSERT INTO modeloplanilla VALUES (48, 2, 3, 'B formados', 100, 11);
INSERT INTO modeloplanilla VALUES (49, 2, 4, 'B en formación', 100, 11);
INSERT INTO modeloplanilla VALUES (50, 3, 3, 'C', 100, 11);



INSERT INTO planmaximo VALUES (48, null, 20);
INSERT INTO planmaximo VALUES (49, null, 20);
INSERT INTO planmaximo VALUES (50, null, 20);

INSERT INTO categoriamaximo VALUES (46, null, 6, 5);
INSERT INTO categoriamaximo VALUES (46, null, 7, 4);
INSERT INTO categoriamaximo VALUES (46, null, 8, 2);
INSERT INTO categoriamaximo VALUES (46, null, 1, 0);
INSERT INTO categoriamaximo VALUES (46, null, 9, 1.5);
INSERT INTO categoriamaximo VALUES (46, null, 10, 1);
INSERT INTO categoriamaximo VALUES (47, null, 9, 5);
INSERT INTO categoriamaximo VALUES (47, null, 10, 2.5);
INSERT INTO categoriamaximo VALUES (47, null, 1, 0);
INSERT INTO categoriamaximo VALUES (48, null, 6, 5);
INSERT INTO categoriamaximo VALUES (48, null, 7, 4);
INSERT INTO categoriamaximo VALUES (48, null, 8, 2);
INSERT INTO categoriamaximo VALUES (48, null, 1, 0);
INSERT INTO categoriamaximo VALUES (48, null, 9, 1.5);
INSERT INTO categoriamaximo VALUES (48, null, 10, 1);
INSERT INTO categoriamaximo VALUES (49, null, 9, 5);
INSERT INTO categoriamaximo VALUES (49, null, 10, 2.5);
INSERT INTO categoriamaximo VALUES (49, null, 1, 0);
INSERT INTO categoriamaximo VALUES (50, null, 6, 5);
INSERT INTO categoriamaximo VALUES (50, null, 7, 4);
INSERT INTO categoriamaximo VALUES (50, null, 8, 2);
INSERT INTO categoriamaximo VALUES (50, null, 1, 0);
INSERT INTO categoriamaximo VALUES (50, null, 9, 1.5);
INSERT INTO categoriamaximo VALUES (50, null, 10, 1);

INSERT INTO cargomaximo VALUES (46, null, 1, 15);
INSERT INTO cargomaximo VALUES (46, null, 2, 13);
INSERT INTO cargomaximo VALUES (46, null, 3, 13);
INSERT INTO cargomaximo VALUES (46, null, 4, 11);
INSERT INTO cargomaximo VALUES (46, null, 5, 11);
INSERT INTO cargomaximo VALUES (46, null, 6, 9);
INSERT INTO cargomaximo VALUES (46, null, 7, 9);
INSERT INTO cargomaximo VALUES (46, null, 8, 7);
INSERT INTO cargomaximo VALUES (46, null, 9, 6);
INSERT INTO cargomaximo VALUES (46, null, 10, 4);
INSERT INTO cargomaximo VALUES (47, null, 1, 15);
INSERT INTO cargomaximo VALUES (47, null, 2, 13);
INSERT INTO cargomaximo VALUES (47, null, 3, 13);
INSERT INTO cargomaximo VALUES (47, null, 4, 11);
INSERT INTO cargomaximo VALUES (47, null, 5, 11);
INSERT INTO cargomaximo VALUES (47, null, 6, 9);
INSERT INTO cargomaximo VALUES (47, null, 7, 9);
INSERT INTO cargomaximo VALUES (47, null, 8, 7);
INSERT INTO cargomaximo VALUES (47, null, 9, 6);
INSERT INTO cargomaximo VALUES (47, null, 10, 4);
INSERT INTO cargomaximo VALUES (48, null, 1, 8);
INSERT INTO cargomaximo VALUES (48, null, 2, 7);
INSERT INTO cargomaximo VALUES (48, null, 3, 7);
INSERT INTO cargomaximo VALUES (48, null, 4, 6);
INSERT INTO cargomaximo VALUES (48, null, 5, 6);
INSERT INTO cargomaximo VALUES (48, null, 6, 5);
INSERT INTO cargomaximo VALUES (48, null, 7, 5);
INSERT INTO cargomaximo VALUES (48, null, 8, 4);
INSERT INTO cargomaximo VALUES (48, null, 9, 4);
INSERT INTO cargomaximo VALUES (48, null, 10, 3);
INSERT INTO cargomaximo VALUES (49, null, 1, 8);
INSERT INTO cargomaximo VALUES (49, null, 2, 7);
INSERT INTO cargomaximo VALUES (49, null, 3, 7);
INSERT INTO cargomaximo VALUES (49, null, 4, 6);
INSERT INTO cargomaximo VALUES (49, null, 5, 6);
INSERT INTO cargomaximo VALUES (49, null, 6, 5);
INSERT INTO cargomaximo VALUES (49, null, 7, 5);
INSERT INTO cargomaximo VALUES (49, null, 8, 4);
INSERT INTO cargomaximo VALUES (49, null, 9, 4);
INSERT INTO cargomaximo VALUES (49, null, 10, 3);
INSERT INTO cargomaximo VALUES (50, null, 1, 5);
INSERT INTO cargomaximo VALUES (50, null, 2, 4);
INSERT INTO cargomaximo VALUES (50, null, 3, 4);
INSERT INTO cargomaximo VALUES (50, null, 4, 3);
INSERT INTO cargomaximo VALUES (50, null, 5, 3);
INSERT INTO cargomaximo VALUES (50, null, 6, 2);
INSERT INTO cargomaximo VALUES (50, null, 7, 2);
INSERT INTO cargomaximo VALUES (50, null, 8, 1);
INSERT INTO cargomaximo VALUES (50, null, 9, 1);
INSERT INTO cargomaximo VALUES (50, null, 10, 0);


INSERT INTO itemmaximo VALUES (46, null, 1, 5, 56, 5);
INSERT INTO itemmaximo VALUES (46, null, 2, 3, 56, 3);
INSERT INTO itemmaximo VALUES (46, null, 3, 4, 56, 4);
INSERT INTO itemmaximo VALUES (46, null, 12, 3, 56, 3);
INSERT INTO itemmaximo VALUES (46, null, 13, 1, 56, 1);
INSERT INTO itemmaximo VALUES (46, null, 4, 2, 57, 2);
INSERT INTO itemmaximo VALUES (46, null, 18, 6, 58, 6);
INSERT INTO itemmaximo VALUES (46, null, 19, 4, 58, 4);
INSERT INTO itemmaximo VALUES (46, null, 8, 2, 58, 2);
INSERT INTO itemmaximo VALUES (46, null, 20, 2.5, 59, 2.5);
INSERT INTO itemmaximo VALUES (46, null, 17, 0.5, 60, 0.5);
INSERT INTO itemmaximo VALUES (46, null, 15, 1, 60, 1);


INSERT INTO itemmaximo VALUES (47, null, 1, 5, 61, 5);
INSERT INTO itemmaximo VALUES (47, null, 12, 3, 61, 3);
INSERT INTO itemmaximo VALUES (47, null, 2, 3, 61, 3);
INSERT INTO itemmaximo VALUES (47, null, 3, 4, 61, 4);
INSERT INTO itemmaximo VALUES (47, null, 13, 1, 61, 1);
INSERT INTO itemmaximo VALUES (47, null, 4, 3, 39, 3);
INSERT INTO itemmaximo VALUES (47, null, 21, 0.2, 39, 0.2);
INSERT INTO itemmaximo VALUES (47, null, 18, 6, 40, 6);
INSERT INTO itemmaximo VALUES (47, null, 19, 4, 40, 4);
INSERT INTO itemmaximo VALUES (47, null, 8, 2, 40, 2);
INSERT INTO itemmaximo VALUES (47, null, 20, 2.5, 9, 2.5);
INSERT INTO itemmaximo VALUES (47, null, 17, 0.5, 10, 0.5);
INSERT INTO itemmaximo VALUES (47, null, 15, 1, 10, 1);


INSERT INTO itemmaximo VALUES (48, null, 1, 2.5, 62, 2.5);
INSERT INTO itemmaximo VALUES (48, null, 12, 1.5, 62, 1.5);
INSERT INTO itemmaximo VALUES (48, null, 2, 1.5, 62, 1.5);
INSERT INTO itemmaximo VALUES (48, null, 3, 3, 62, 3);
INSERT INTO itemmaximo VALUES (48, null, 13, 1, 62, 1);
INSERT INTO itemmaximo VALUES (48, null, 4, 1, 63, 1);
INSERT INTO itemmaximo VALUES (48, null, 18, 3, 64, 3);
INSERT INTO itemmaximo VALUES (48, null, 19, 2, 64, 2);
INSERT INTO itemmaximo VALUES (48, null, 8, 1, 64, 1);
INSERT INTO itemmaximo VALUES (48, null, 20, 1.5, 65, 1.5);
INSERT INTO itemmaximo VALUES (48, null, 17, 0.25, 66, 0.25);
INSERT INTO itemmaximo VALUES (48, null, 15, 0.5, 66, 0.5);


INSERT INTO itemmaximo VALUES (49, null, 1, 2.5, 67, 2.5);
INSERT INTO itemmaximo VALUES (49, null, 12, 1.5, 67, 1.5);
INSERT INTO itemmaximo VALUES (49, null, 2, 1.5, 67, 1.5);
INSERT INTO itemmaximo VALUES (49, null, 3, 3, 67, 3);
INSERT INTO itemmaximo VALUES (49, null, 13, 1, 67, 1);
INSERT INTO itemmaximo VALUES (49, null, 4, 2, 68, 2);
INSERT INTO itemmaximo VALUES (49, null, 21, 0.1, 68, 0.1);
INSERT INTO itemmaximo VALUES (49, null, 18, 3, 69, 3);
INSERT INTO itemmaximo VALUES (49, null, 19, 2, 69, 2);
INSERT INTO itemmaximo VALUES (49, null, 8, 1, 69, 1);
INSERT INTO itemmaximo VALUES (49, null, 20, 1, 19, 1);
INSERT INTO itemmaximo VALUES (49, null, 17, 0.25, 20, 0.25);
INSERT INTO itemmaximo VALUES (49, null, 15, 0.5, 20, 0.5);


INSERT INTO itemmaximo VALUES (50, null, 1, 2.5, 70, 2.5);
INSERT INTO itemmaximo VALUES (50, null, 12, 1.5, 70, 1.5);
INSERT INTO itemmaximo VALUES (50, null, 2, 1.5, 70, 1.5);
INSERT INTO itemmaximo VALUES (50, null, 3, 3, 70, 3);
INSERT INTO itemmaximo VALUES (50, null, 13, 1, 70, 1);
INSERT INTO itemmaximo VALUES (50, null, 4, 1, 71, 1);
INSERT INTO itemmaximo VALUES (50, null, 18, 3, 72, 3);
INSERT INTO itemmaximo VALUES (50, null, 19, 2, 72, 2);
INSERT INTO itemmaximo VALUES (50, null, 8, 1, 72, 1);
INSERT INTO itemmaximo VALUES (50, null, 20, 1.5, 73, 1.5);
INSERT INTO itemmaximo VALUES (50, null, 17, 0.25, 74, 0.25);
INSERT INTO itemmaximo VALUES (50, null, 15, 0.5, 74, 0.5);

INSERT INTO eventomaximo VALUES (46, null, 15, 8, 26, 0);
INSERT INTO eventomaximo VALUES (46, null, 16, 2, 26, 0);
INSERT INTO eventomaximo VALUES (46, null, 14, 3, 26, 0);
INSERT INTO eventomaximo VALUES (46, null, 12, 10, 26, 10);
INSERT INTO eventomaximo VALUES (46, null, 13, 2, 26, 2);

INSERT INTO eventomaximo VALUES (47, null, 15, 11, 27, 0);
INSERT INTO eventomaximo VALUES (47, null, 16, 3, 27, 0);
INSERT INTO eventomaximo VALUES (47, null, 14, 4, 27, 0);
INSERT INTO eventomaximo VALUES (47, null, 12, 10, 27, 10);
INSERT INTO eventomaximo VALUES (47, null, 13, 2, 27, 2);

INSERT INTO eventomaximo VALUES (48, null, 15, 6, 28, 0);
INSERT INTO eventomaximo VALUES (48, null, 16, 2, 28, 0);
INSERT INTO eventomaximo VALUES (48, null, 6, 2, 28, 0);
INSERT INTO eventomaximo VALUES (48, null, 10, 1, 28, 1);
INSERT INTO eventomaximo VALUES (48, null, 12, 7, 28, 7);
INSERT INTO eventomaximo VALUES (48, null, 13, 2, 28, 2);

INSERT INTO eventomaximo VALUES (49, null, 15, 7, 29, 0);
INSERT INTO eventomaximo VALUES (49, null, 16, 2, 29, 0);
INSERT INTO eventomaximo VALUES (49, null, 6, 3, 29, 0);
INSERT INTO eventomaximo VALUES (49, null, 10, 1, 29, 1);
INSERT INTO eventomaximo VALUES (49, null, 12, 10, 29, 10);
INSERT INTO eventomaximo VALUES (49, null, 13, 2, 29, 2);

INSERT INTO eventomaximo VALUES (50, null, 17, 13, 30, 0);
INSERT INTO eventomaximo VALUES (50, null, 18, 2, 30, 0);
INSERT INTO eventomaximo VALUES (50, null, 7, 2, 30, 2);
INSERT INTO eventomaximo VALUES (50, null, 12, 6, 30, 6);
INSERT INTO eventomaximo VALUES (50, null, 13, 2, 30, 2);

############################################ 28/09/2021 #####################################################
CREATE TABLE cyt_rendicionviajes (
  oid int(11) NOT NULL AUTO_INCREMENT,
  solicitud_oid int(11) NOT NULL,

  dt_fecha timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  ds_informe varchar(255) DEFAULT NULL,
  ds_rendicion varchar(255) DEFAULT NULL,
  ds_certificado varchar(255) DEFAULT NULL,

  ds_observacion text,

  PRIMARY KEY (oid),
  KEY solicitud_oid (solicitud_oid)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

ALTER TABLE `cyt_rendicionviajes`
    ADD UNIQUE INDEX `solicitud_oid_unique` (`solicitud_oid`);





CREATE TABLE cyt_rendicionviajes_estado (
  oid bigint(20) NOT NULL auto_increment,
  rendicion_oid int(11) default NULL,
  estado_oid int(11) default NULL,
  fechaDesde datetime default NULL,
  fechaHasta datetime default NULL,
  motivo text default NULL,
  user_oid int(11) NOT NULL,
  fechaUltModificacion timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (oid),
  KEY rendicion_oid (rendicion_oid),
  KEY estado_oid (estado_oid),
  KEY user_oid (user_oid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

ALTER TABLE cyt_rendicionviajes_estado ADD FOREIGN KEY ( rendicion_oid ) REFERENCES cyt_rendicionviajes (
oid
);

ALTER TABLE cyt_rendicionviajes_estado ADD FOREIGN KEY ( estado_oid ) REFERENCES estado (
cd_estado
);

ALTER TABLE cyt_rendicionviajes_estado ADD FOREIGN KEY ( user_oid ) REFERENCES cyt_user (
oid
);


