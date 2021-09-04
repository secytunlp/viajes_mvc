
##################################################### Solicitantes con estado dintinto a 3 #############################################
SELECT S.*, I.* FROM solicitud S INNER JOIN `cyt_solicitud_proyecto` SP ON S.cd_solicitud = SP.solicitud_oid INNER JOIN integrante I ON SP.proyecto_oid = I.cd_proyecto WHERE S.cd_periodo = 7 AND I.cd_estado <> 3 AND I.cd_docente = S.cd_docente ORDER BY `S`.`cd_solicitud` ASC

################################################### Evaluadores Cargados #######################################################
SELECT U.ds_name, U.ds_username, U.ds_email, F.ds_facultad
FROM cyt_user U INNER JOIN facultad F ON U.facultad_oid = F.cd_facultad
INNER JOIN cyt_user_usergroup UG ON U.oid = UG.user_oid AND usergroup_oid = 10
ORDER BY F.ds_facultad, UG.oid


################################################### Solicitudes con distinto lugar de trabajo #######################################################

SELECT CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(U.ds_unidad,'-',U.ds_sigla) AS Lugar_Trabajo_UNLP, CONCAT(UC.ds_unidad,'-',UC.ds_sigla) AS Lugar_Trabajo_Carrera, CONCAT(UB.ds_unidad,'-',UB.ds_sigla) AS Lugar_Trabajo_Beca, F.ds_facultad
FROM `solicitud` S INNER JOIN cyt_solicitud_estado E on S.cd_solicitud = E.solicitud_oid INNER JOIN docente D ON S.cd_docente = D.cd_docente
LEFT JOIN unidad U ON S.cd_unidad = U.cd_unidad LEFT JOIN unidad UC ON S.cd_unidadcarrera = UC.cd_unidad LEFT JOIN unidad UB ON S.cd_unidadbeca = UB.cd_unidad INNER JOIN facultad F ON S.cd_facultadplanilla = F.cd_facultad
WHERE (((S.cd_unidad != S.cd_unidadcarrera) AND S.cd_unidadcarrera!=0) OR ((S.cd_unidad != S.cd_unidadbeca) AND S.cd_unidadbeca !=0)) AND S.cd_periodo = 7 AND E.fechaHasta is null AND (E.estado_oid = 2 OR E.estado_oid = 3)
ORDER BY F.ds_facultad, D.ds_apellido, D.ds_nombre

######################### Pasar solicitudes desde viajes a incentivos ##################################3
SET FOREIGN_KEY_CHECKS=0;


DELETE FROM cyt_solicitud_estado WHERE EXISTS (
SELECT cd_solicitud
FROM solicitud
WHERE solicitud.cd_solicitud = cyt_solicitud_estado.solicitud_oid AND cd_periodo = 9
);

DELETE FROM presupuesto  WHERE EXISTS (
SELECT cd_solicitud
FROM solicitud
WHERE solicitud.cd_solicitud = presupuesto .cd_solicitud AND cd_periodo = 9
);


DELETE FROM cyt_solicitud_proyecto WHERE EXISTS (
SELECT cd_solicitud
FROM solicitud
WHERE solicitud.cd_solicitud = cyt_solicitud_proyecto.solicitud_oid AND cd_periodo = 9
);

DELETE FROM solicitud WHERE cd_periodo = 9;
SET FOREIGN_KEY_CHECKS=1;

### Insertas todas las solicitudes a incentivos desde viajes
SELECT * FROM solicitud WHERE cd_periodo = 9;

### Insertas todas las cyt_solicitud_estado a incentivos desde viajes
SELECT *
FROM `cyt_solicitud_estado`
WHERE EXISTS (

SELECT cd_solicitud
FROM solicitud
WHERE solicitud.cd_solicitud = cyt_solicitud_estado.solicitud_oid AND cd_periodo = 9
);

### Insertas todas los presupuesto  a incentivos desde viajes
SELECT *
FROM `presupuesto`
WHERE EXISTS (

SELECT cd_solicitud
FROM solicitud
WHERE solicitud.cd_solicitud = presupuesto .cd_solicitud AND cd_periodo = 9
);


### Insertas todas las cyt_solicitud_proyecto a incentivos desde viajes
SELECT *
FROM `cyt_solicitud_proyecto`
WHERE EXISTS (

SELECT cd_solicitud
FROM solicitud
WHERE solicitud.cd_solicitud = cyt_solicitud_proyecto.solicitud_oid AND cd_periodo = 9
);


################################################### Filtrar por cargo docente #######################################################

SELECT CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, C.ds_cargo as Cargo, T.ds_tipoinvestigador as Tipo, E.ds_estado as Estado, S.nu_puntaje as Puntaje
FROM `solicitud` S INNER JOIN cyt_solicitud_estado SE on S.cd_solicitud = SE.solicitud_oid 
INNER JOIN estado E ON SE.estado_oid = E.cd_estado
INNER JOIN docente D ON S.cd_docente = D.cd_docente
LEFT JOIN cargo C ON S.cd_cargo = C.cd_cargo 
LEFT JOIN motivo M ON S.cd_motivo = M.cd_motivo 
LEFT JOIN tipoinvestigador T ON S.cd_tipoinvestigador = T.cd_tipoinvestigador
WHERE S.cd_periodo = 6 AND SE.fechaHasta is null AND SE.estado_oid != 1 AND SE.estado_oid != 4 AND S.cd_motivo = 1
ORDER BY D.ds_apellido, D.ds_nombre

###################################### Docentes 1, 2 y 3 de La Plata para el banco de evaluadores ########################################
SELECT D.cd_docente,CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador,CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil) as Cuil,
C.ds_categoria,F.ds_facultad,D.nu_documento,D.cd_categoria,D.cd_facultad 
FROM docente D LEFT JOIN categoria C ON D.cd_categoria = C.cd_categoria
LEFT JOIN facultad F ON D.cd_facultad = F.cd_facultad
WHERE (D.cd_universidad = 11 OR D.cd_universidad = 0 OR D.cd_universidad is null) AND D.cd_categoria IN (6,7,8)
ORDER BY D.ds_apellido, D.ds_nombre

########################################## Vacio los perfiles evaluadores #####################################################3
DELETE FROM `cyt_user_usergroup` WHERE `usergroup_oid` = 10


###################################### Insertar usuarios evaluadores que no están ########################################
INSERT INTO cyt_user (ds_username, ds_name, ds_email, ds_password, facultad_oid)
SELECT DISTINCT CONCAT(D.nu_precuil,'-',LPAD(D.nu_documento,8,'0'),'-',D.nu_postcuil) as Cuil,CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador,
D.ds_mail, '202cb962ac59075b964b07152d234b70', D.cd_facultad 
FROM `banco_evaluadores` ES INNER JOIN docente D ON ES.nu_documento = D.nu_documento
WHERE (D.cd_universidad = 11 OR D.cd_universidad = 0 OR D.cd_universidad is null) AND (D.ds_mail is not null OR D.ds_mail != '') AND NOT EXISTS (SELECT cyt_user.oid FROM `cyt_user` WHERE cyt_user.ds_username LIKE CONCAT('%',D.nu_documento,'%'));

############## Insertar perfiles evaluadores (a los que no tienen los de directores y solicitantes también se les agregan) ########################################
INSERT INTO cyt_user_usergroup (user_oid, usergroup_oid)
SELECT DISTINCT U.oid,'10'
FROM `banco_evaluadores` ES 
INNER JOIN docente D ON ES.nu_documento = D.nu_documento
INNER JOIN cyt_user U ON U.ds_username = CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil) OR U.ds_username = CONCAT(D.nu_precuil,'-0',D.nu_documento,'-',D.nu_postcuil)
WHERE NOT EXISTS (SELECT UG.oid FROM `cyt_user_usergroup` UG WHERE UG.user_oid = U.oid AND usergroup_oid = 10);

INSERT INTO cyt_user_usergroup (user_oid, usergroup_oid)
SELECT DISTINCT U.oid,'3'
FROM `banco_evaluadores` ES 
INNER JOIN docente D ON ES.nu_documento = D.nu_documento
INNER JOIN cyt_user U ON U.ds_username = CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil) OR U.ds_username = CONCAT(D.nu_precuil,'-0',D.nu_documento,'-',D.nu_postcuil)
WHERE NOT EXISTS (SELECT UG.oid FROM `cyt_user_usergroup` UG WHERE UG.user_oid = U.oid AND usergroup_oid = 3);

INSERT INTO cyt_user_usergroup (user_oid, usergroup_oid)
SELECT DISTINCT U.oid,'15'
FROM `banco_evaluadores` ES 
INNER JOIN docente D ON ES.nu_documento = D.nu_documento
INNER JOIN cyt_user U ON U.ds_username = CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil) OR U.ds_username = CONCAT(D.nu_precuil,'-0',D.nu_documento,'-',D.nu_postcuil)
WHERE NOT EXISTS (SELECT UG.oid FROM `cyt_user_usergroup` UG WHERE UG.user_oid = U.oid AND usergroup_oid = 15);

################################Lugares de trabajo aprobados no cargados en la evaluacion ################################################33
SELECT S.cd_solicitud,E.cd_evaluacion
FROM `solicitud` S 
INNER JOIN evaluacion E ON S.cd_solicitud = E.cd_solicitud
INNER JOIN cyt_evaluacion_estado EE ON E.cd_evaluacion = EE.evaluacion_oid 
WHERE EE.estado_oid IN (6,8) AND EE.fechaHasta IS NULL AND S.cd_periodo = 8 AND EXISTS (SELECT UA.cd_unidad FROM `unidadaprobadaviajes` 
UA WHERE UA.cd_unidad=S.cd_unidad)  AND NOT EXISTS (SELECT PE.cd_puntajeevento FROM `puntajeevento` PE WHERE `cd_eventomaximo` 
IN (137,142,147,152,157) AND E.cd_evaluacion = PE.cd_evaluacion)
AND EXISTS (SELECT PC.cd_puntajecargo FROM `puntajecargo` PC WHERE E.cd_evaluacion = PC.cd_evaluacion)
 ORDER BY `E`.`cd_evaluacion` ASC
 
 SELECT S.cd_solicitud,E.cd_evaluacion
FROM `solicitud` S 
INNER JOIN evaluacion E ON S.cd_solicitud = E.cd_solicitud
INNER JOIN cyt_evaluacion_estado EE ON E.cd_evaluacion = EE.evaluacion_oid 
WHERE EE.estado_oid IN (6,8) AND EE.fechaHasta IS NULL AND S.cd_periodo = 8 AND EXISTS (SELECT UA.cd_unidad FROM `unidadaprobadaviajes` 
UA WHERE UA.cd_unidad=S.cd_unidadbeca)  AND NOT EXISTS (SELECT PE.cd_puntajeevento FROM `puntajeevento` PE WHERE `cd_eventomaximo` 
IN (137,142,147,152,157) AND E.cd_evaluacion = PE.cd_evaluacion)
AND EXISTS (SELECT PC.cd_puntajecargo FROM `puntajecargo` PC WHERE E.cd_evaluacion = PC.cd_evaluacion)
 ORDER BY `E`.`cd_evaluacion` ASC

 SELECT S.cd_solicitud,E.cd_evaluacion
FROM `solicitud` S 
INNER JOIN evaluacion E ON S.cd_solicitud = E.cd_solicitud
INNER JOIN cyt_evaluacion_estado EE ON E.cd_evaluacion = EE.evaluacion_oid 
WHERE EE.estado_oid IN (6,8) AND EE.fechaHasta IS NULL AND S.cd_periodo = 8 AND EXISTS (SELECT UA.cd_unidad FROM `unidadaprobadaviajes` 
UA WHERE UA.cd_unidad=S.cd_unidadcarrera)  AND NOT EXISTS (SELECT PE.cd_puntajeevento FROM `puntajeevento` PE WHERE `cd_eventomaximo` 
IN (137,142,147,152,157) AND E.cd_evaluacion = PE.cd_evaluacion)
AND EXISTS (SELECT PC.cd_puntajecargo FROM `puntajecargo` PC WHERE E.cd_evaluacion = PC.cd_evaluacion)
 ORDER BY `E`.`cd_evaluacion` ASC
 
############################################Actualizar usuarios duplicados ##########################################################3
UPDATE `evaluacion` SET cd_usuario = 1152 WHERE `cd_usuario` = 5679;
UPDATE `evaluacionjovenes` SET cd_usuario = 1152 WHERE `cd_usuario` = 5679;
UPDATE `evaluacionproyecto` SET cd_usuario = 1152 WHERE `cd_usuario` = 5679;
UPDATE `evaluadorespecialidad` SET cd_usuario = 1152 WHERE `cd_usuario` = 5679;


UPDATE `cyt_evaluacion_estado` SET `user_oid` = 1152 WHERE `user_oid` = 5679;
UPDATE `cyt_evaluacionjovenes_estado` SET `user_oid` = 1152 WHERE `user_oid` = 5679;
UPDATE `cyt_solicitud_estado` SET `user_oid` = 1152 WHERE `user_oid` = 5679;
UPDATE `cyt_solicitudjovenes_estado` SET `user_oid` = 1152 WHERE `user_oid` = 5679;
UPDATE `cyt_integrante_estado` SET `user_oid` = 1152 WHERE `user_oid` = 5679;
UPDATE `cyt_unidad` SET `user_oid` = 1152 WHERE `user_oid` = 5679;
UPDATE `cyt_unidad_integrante` SET `user_oid` = 1152 WHERE `user_oid` = 5679;
UPDATE `cyt_unidad_tipo_estado` SET `user_oid` = 1152 WHERE `user_oid` = 5679;

DELETE FROM `cyt_user_usergroup` WHERE `user_oid` =5679;
DELETE FROM `cyt_user` WHERE `oid` =5679;




##############################Evaluadores que no aceptaron la evaluación#######################################3
SELECT CONCAT(D.ds_apellido,', ', D.ds_nombre) as Solicitante, F.ds_facultad, UE.ds_name AS Evaluador , UE.ds_email, EE.fechaDesde AS Fecha_Envio 
FROM `solicitud` S INNER JOIN docente D ON S.cd_docente = D.cd_docente
INNER JOIN evaluacion E ON S.cd_solicitud = E.cd_solicitud
INNER JOIN facultad F ON S.cd_facultadPlanilla = F.cd_facultad
INNER JOIN cyt_user UE ON E.cd_usuario = UE.oid
INNER JOIN cyt_evaluacion_estado EE ON E.cd_evaluacion = EE.evaluacion_oid
INNER JOIN cyt_solicitud_estado SE ON S.cd_solicitud = SE.solicitud_oid
WHERE S.`cd_periodo` = 9 AND EE.fechaHasta is NULL AND EE.estado_oid = 2 AND SE.fechaHasta is NULL AND F.cd_cat = 3
ORDER BY  UE.ds_name, F.ds_facultad, D.ds_apellido, D.ds_nombre

##############################Evaluadores que enviaron la evaluacion#######################################3
SELECT DISTINCT UE.ds_name AS Evaluador , UE.ds_email
FROM `solicitud` S INNER JOIN docente D ON S.cd_docente = D.cd_docente
INNER JOIN evaluacion E ON S.cd_solicitud = E.cd_solicitud

INNER JOIN cyt_user UE ON E.cd_usuario = UE.oid
INNER JOIN cyt_evaluacion_estado EE ON E.cd_evaluacion = EE.evaluacion_oid
INNER JOIN cyt_solicitud_estado SE ON S.cd_solicitud = SE.solicitud_oid
WHERE S.`cd_periodo` = 10 AND EE.fechaHasta is NULL AND EE.estado_oid = 8 
ORDER BY  UE.ds_name


##############################Solicitudes con estado "En evaluacion" con 2 o más evaluaciones en estado "Evaluada"#######################################3
SELECT S.cd_solicitud, count(S.cd_solicitud) AS Evaluaciones 
FROM `solicitud` S 
INNER JOIN evaluacion E ON S.cd_solicitud = E.cd_solicitud

INNER JOIN cyt_evaluacion_estado EE ON E.cd_evaluacion = EE.evaluacion_oid
INNER JOIN cyt_solicitud_estado SE ON S.cd_solicitud = SE.solicitud_oid
WHERE S.`cd_periodo` = 10 AND EE.fechaHasta is NULL AND EE.estado_oid = 8 AND SE.fechaHasta is NULL AND SE.estado_oid = 6 AND SE.fechaHasta is NULL
GROUP BY S.cd_solicitud
HAVING (count(S.cd_solicitud)>1)

##############################Solicitudes de EXACTAS con estado "En evaluacion" con 1 o más evaluaciones en estado "Recibida"#####################################
SELECT CONCAT(D.ds_apellido,', ', D.ds_nombre) as Solicitante, F.ds_facultad, UE.ds_name AS Evaluador , FE.ds_facultad, CASE E.bl_interno WHEN 1 THEN 'Interno' ELSE 'Externo' END AS Tipo, EE.fechaDesde
FROM `solicitud` S INNER JOIN docente D ON S.cd_docente = D.cd_docente
INNER JOIN evaluacion E ON S.cd_solicitud = E.cd_solicitud
INNER JOIN facultad F ON S.cd_facultadPlanilla = F.cd_facultad
INNER JOIN cyt_user UE ON E.cd_usuario = UE.oid
INNER JOIN cyt_evaluacion_estado EE ON E.cd_evaluacion = EE.evaluacion_oid
INNER JOIN facultad FE ON UE.facultad_oid = FE.cd_facultad
WHERE F.cd_cat=1 AND EE.fechaHasta is NULL AND EE.estado_oid = 2 AND EXISTS  (
SELECT S1.cd_solicitud
FROM `solicitud` S1
INNER JOIN evaluacion E1 ON S1.cd_solicitud = E1.cd_solicitud

INNER JOIN cyt_evaluacion_estado EE1 ON E1.cd_evaluacion = EE1.evaluacion_oid
INNER JOIN cyt_solicitud_estado SE1 ON S1.cd_solicitud = SE1.solicitud_oid
WHERE S1.cd_solicitud = S.cd_solicitud AND S1.`cd_periodo` = 10 AND EE1.fechaHasta is NULL AND EE1.estado_oid = 2 AND SE1.fechaHasta is NULL AND SE1.estado_oid = 6 AND SE1.fechaHasta is NULL
GROUP BY S1.cd_solicitud
HAVING (count(S1.cd_solicitud)>0))
ORDER BY  FE.ds_facultad, UE.ds_name , D.ds_apellido, D.ds_nombre

##############################Evaluaciones de EXACTAS con estado "En evaluacion"#######################################3
SELECT CONCAT(D.ds_apellido,', ', D.ds_nombre) as Solicitante, F.ds_facultad, UE.ds_name AS Evaluador, UE.ds_email AS Mail , FE.ds_facultad, CASE E.bl_interno WHEN 1 THEN 'Interno' ELSE 'Externo' END AS Tipo, EE.fechaDesde, E.nu_puntaje
FROM `solicitud` S INNER JOIN docente D ON S.cd_docente = D.cd_docente
INNER JOIN evaluacion E ON S.cd_solicitud = E.cd_solicitud
INNER JOIN facultad F ON S.cd_facultadPlanilla = F.cd_facultad
INNER JOIN cyt_user UE ON E.cd_usuario = UE.oid
INNER JOIN cyt_evaluacion_estado EE ON E.cd_evaluacion = EE.evaluacion_oid
INNER JOIN facultad FE ON UE.facultad_oid = FE.cd_facultad
WHERE F.cd_cat=1 AND EE.fechaHasta is NULL AND EE.estado_oid = 6 AND S.cd_periodo=10
ORDER BY  FE.ds_facultad, UE.ds_name , D.ds_apellido, D.ds_nombre

##############################Evaluaciones con distinto tilde en unidad aprobada OJO!!! hay que cambiar los ID de eventomaximo#######################################3
SELECT evaluacion.cd_solicitud, count(puntajeevento.`nu_puntaje`) 
FROM `puntajeevento` INNER JOIN evaluacion ON puntajeevento.cd_evaluacion = evaluacion.cd_evaluacion
WHERE `cd_eventomaximo` IN (189,194,200,206,211)  
group by evaluacion.cd_solicitud  
HAVING (count(puntajeevento.`nu_puntaje`)<2)