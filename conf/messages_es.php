<?php

/**
 * se definen los mensajes del sistema en español.
 *
 * @author modelBuilder
 *
 */


include_once('messages_labels_es.php');

/* SOLICITUDES */

define('CYT_MSG_SOLICITUD_TITLE_LIST', 'Solicitudes', true);
define('CYT_MSG_SOLICITUD_TITLE_ADD', 'Crear ' . CYT_LBL_SOLICITUD, true);
define('CYT_MSG_SOLICITUD_TITLE_UPDATE', 'Modificar ' . CYT_LBL_SOLICITUD , true);
define('CYT_MSG_SOLICITUD_TITLE_VIEW', 'Visualizar ' . CYT_LBL_SOLICITUD , true);
define('CYT_MSG_SOLICITUD_TITLE_DELETE', 'Borrar ' . CYT_LBL_SOLICITUD , true);
define('CYT_MSG_SOLICITUD_TITLE_EVALUAR', 'Evaluar ' . CYT_LBL_SOLICITUD, true);

define('CYT_MSG_SOLICITUD_CALLE_REQUIRED', CYT_LBL_SOLICITUD_CALLE . ' es requerido', true);
define('CYT_MSG_SOLICITUD_CALLE_NRO_REQUIRED', CYT_LBL_SOLICITUD_CALLE_NRO . ' es requerido', true);
define('CYT_MSG_SOLICITUD_CP_REQUIRED', CYT_LBL_SOLICITUD_CP . ' es requerido', true);
define('CYT_MSG_SOLICITUD_MAIL_REQUIRED', CYT_LBL_SOLICITUD_MAIL . ' es requerido', true);
define('CYT_MSG_SOLICITUD_TITULO_REQUIRED', CYT_LBL_SOLICITUD_TITULO . ' es requerido', true);
define('CYT_MSG_SOLICITUD_LUGAR_TRABAJO_REQUIRED', CYT_LBL_SOLICITUD_LUGAR_TRABAJO . ' es requerido', true);
define('CYT_MSG_SOLICITUD_CARGO_REQUIRED', CYT_LBL_SOLICITUD_CARGO . ' es requerido', true);
define('CYT_MSG_SOLICITUD_DEDICACION_REQUIRED', CYT_LBL_SOLICITUD_DEDICACION . ' es requerido', true);
define('CYT_MSG_SOLICITUD_FACULTAD_REQUIRED', CYT_LBL_SOLICITUD_FACULTAD . ' es requerido', true);
define('CYT_MSG_SOLICITUD_MONTO_REQUIRED', CYT_LBL_SOLICITUD_MONTO . ' es requerido', true);
define('CYT_MSG_SOLICITUD_MOTIVO_REQUIRED', CYT_LBL_SOLICITUD_MOTIVO . ' es requerido', true);
define('CYT_MSG_SOLICITUD_TIPO_EVENTO_REQUIRED', CYT_LBL_SOLICITUD_A_TIPO_EVENTO . ' es requerido', true);
define('CYT_MSG_SOLICITUD_TITULO_EVENTO_REQUIRED', 'Título es requerido', true);
define('CYT_MSG_SOLICITUD_AUTOR_REQUIRED', CYT_LBL_SOLICITUD_A_AUTOR_CONFERENCIA . ' es requerido', true);
define('CYT_MSG_SOLICITUD_CONGRESO_REQUIRED', CYT_LBL_SOLICITUD_A_CONGRESO_CONGRESO . ' es requerido', true);
define('CYT_MSG_SOLICITUD_CARACTER_REQUIRED', CYT_LBL_SOLICITUD_A_CARACTER . ' es requerido', true);
define('CYT_MSG_SOLICITUD_LUGAR_REQUIRED', CYT_LBL_SOLICITUD_A_LUGAR . ' es requerido', true);
define('CYT_MSG_SOLICITUD_A_FECHA_REQUIRED', CYT_LBL_SOLICITUD_A_FECHA . ' es requerido', true);
define('CYT_MSG_SOLICITUD_PROFESOR_REQUIRED', CYT_LBL_SOLICITUD_C_PROFESOR. ' es requerido', true);
define('CYT_MSG_SOLICITUD_PROFESOR_LUGAR_REQUIRED', CYT_LBL_SOLICITUD_C_PROFESOR. ' es requerido', true);

define('CYT_MSG_SOLICITUD_RESUMEN_PALABRAS_REQUIRED', 'El texto del resumen en la pestaña motivo debe tener al menos', true);
define('CYT_MSG_SOLICITUD_RESUMEN_PALABRAS', 'Palabras', true);


define('CYT_MSG_SOLICITUD_TAB_DOMICILIO', "Domicilio", true);
define('CYT_MSG_SOLICITUD_DOMICILIO_TITULO', "Domicilio de notificación (Dentro del Radio Urbano de La Plata, Art. 20 Ord. 101)", true);
define('CYT_MSG_SOLICITUD_TAB_UNIVERSIDAD', "Universidad", true);
define('CYT_MSG_SOLICITUD_TAB_BECARIO', "Becario", true);
define('CYT_MSG_SOLICITUD_TAB_CARRERAINV', "Carrera Inv.", true);
define('CYT_MSG_SOLICITUD_TAB_PROYECTOS', "Proyectos", true);
define('CYT_MSG_SOLICITUD_PROYECTOS_TITULO', "Seleccione el proyecto de investigación en el marco del cual realizará la actividad", true);
define('CYT_MSG_SOLICITUD_TAB_TIPO_INVESTIGADOR', "Tipo Inv.", true);
define('CYT_MSG_SOLICITUD_TIPO_INVESTIGADOR_TITULO', "En el caso de contar con un solo cargo docente debe seleccionar la facultad por donde posee dicho cargo, si posee cargos en facultades distintas debe seleccionar la facultad por donde usted tiene un cargo docente y realiza su tarea de investigación", true);
define('CYT_MSG_SOLICITUD_TAB_AMBITOS', "Lugar", true);
define('CYT_MSG_SOLICITUD_AMBITOS_TITULO', "Para los subsidios tipo A ó B ingrese el lugar donde realizará la actividad, si el subsidio es tipo C ingrese el lugar de procedencia del investigador invitado", true);
define('CYT_MSG_SOLICITUD_TAB_MONTOS', "Montos", true);
define('CYT_MSG_SOLICITUD_MONTOS_TITULO', "MONTO SOLICITADO A OTROS ORGANISMOS", true);
define('CYT_MSG_SOLICITUD_TAB_MOTIVO', "Motivo", true);
define('CYT_MSG_SOLICITUD_TAB_PRESUPUESTOS', "Presupuesto", true);
define('CYT_MSG_SOLICITUD_PRESUPUESTOS_TITULO', "SERVICIOS NO PERSONALES", true);

define('CYT_MSG_SOLICITUD_SIN_YEAR_PROYECTO', 'Debe contar al menos con un año de antigüedad en proyectos en ejecución o ser becario UNLP.', true);
define('CYT_MSG_SOLICITUD_SIN_PROYECTO_ACTUAL', 'Debe contar al menos con un proyecto en ejecución o ser becario UNLP.', true);
define('CYT_MSG_SOLICITUD_SIN_PROYECTO_ELEGIDO', 'Debe seleccionar un solo proyecto de la pestaña', true);
define('CYT_MSG_SOLICITUD_ANTERIORES_OTORGADAS', 'No podrá completar su solicitud por haber obtenido el subsidio en la convocatoria anterior según lo establecido en el punto 18 del Anexo I de las pautas del llamo  (Resolución N° 11/19) donde se establece que: “No se podrán presentar aquellos postulantes que hayan sido beneficiados con el subsidio en la convocatoria anterior (los que han renunciado se consideran como subsidios otorgados).No puede completar la Solicitud por haber obtenido el subsidio en el período anterior', true);
define('CYT_MSG_SOLICITUD_CREADA', 'Sólo se puede crear una solicitud por período', true);
define('CYT_MSG_SOLICITUD_LUGAR_TRABAJO_BECA_NO_UNLP', 'Si tiene dedicación simple el lugar de trabajo de la beca debe ser en la U.N.L.P..', true);
define('CYT_MSG_SOLICITUD_LUGAR_TRABAJO_CARRERA_NO_UNLP', 'Si tiene dedicación simple el lugar de trabajo de la carrera de investigador debe ser en la U.N.L.P..', true);
define('CYT_MSG_SOLICITUD_CONFERENCISTA_NO_FORMADO', 'Los investigadores en formación no pueden solicitar subsidios como conferencistas', true);
define('CYT_MSG_SOLICITUD_MONTO_MAXIMO', 'El monto máximo es de', true);
define('CYT_MSG_SOLICITUD_MONTO_DECLARAR', 'El total de la pestaña presupuesto debe ser igual al monto declarado en la pestaña ', true);
define('CYT_MSG_SOLICITUD_TAB_CAMPOS_REQUERIDOS', "Complete todos los campos de la pestaña", true);
define('CYT_MSG_SOLICITUD_TIPO_C_FORMADOS', 'Solo pueden solicitar subsidios Tipo C los Investigadores Formados.', true);



/* AMBITOS*/
define('CYT_MSG_AMBITO_INSTITUCION_REQUIRED', CYT_LBL_AMBITO_INSTITUCION . ' es requerido', true);
define('CYT_MSG_AMBITO_CIUDAD_REQUIRED', CYT_LBL_AMBITO_CIUDAD . ' es requerido', true);
define('CYT_MSG_AMBITO_PAIS_REQUIRED', CYT_LBL_AMBITO_PAIS . ' es requerido', true);
define('CYT_MSG_AMBITO_DESDE_REQUIRED', CYT_LBL_AMBITO_DESDE . ' es requerido', true);
define('CYT_MSG_AMBITO_HASTA_REQUIRED', CYT_LBL_AMBITO_HASTA . ' es requerido', true);
define('CYT_MSG_AMBITOS_REQUIRED', 'Debe ingresar al menos un ámbito', true);

define('CYT_MSG_AMBITO_ASIGNAR', 'Asignar Ambito', true);
define('CYT_MSG_AMBITOS', "Indique los ámbitos", true);

define('CYT_MSG_AMBITO_DESDE_MAYOR', CYT_LBL_AMBITO_DESDE . ' es mayor que '.CYT_LBL_AMBITO_HASTA, true);
define('CYT_MSG_AMBITO_DESDE_FUERA_RANGO', CYT_LBL_AMBITO_DESDE . ' fuera de rango', true);
define('CYT_MSG_AMBITO_HASTA_FUERA_RANGO', CYT_LBL_AMBITO_HASTA . ' fuera de rango', true);

define('CYT_MSG_AMBITO_REQUIRED', 'Debe ingresar al menos un ambito', true);
define('CYT_MSG_AMBITO_REQUIRED1', 'Debe ingresar un solo lugar', true);

define('CYT_MSG_AMBITO_FUERA_RANGO', 'El período del congreso no está contenido en su totalidad en el período del lugar cargado', true);
/* MONTOS*/
define('CYT_MSG_MONTO_INSTITUCION_REQUIRED', CYT_LBL_MONTO_INSTITUCION . ' es requerido', true);
define('CYT_MSG_MONTO_CARACTER_REQUIRED', CYT_LBL_MONTO_CARACTER . ' es requerido', true);
define('CYT_MSG_MONTO_IMPORTE_REQUIRED', CYT_LBL_MONTO_IMPORTE . ' es requerido', true);
define('CYT_MSG_MONTOS_REQUIRED', 'Debe ingresar al menos un monto', true);

define('CYT_MSG_MONTO_ASIGNAR', 'Asignar Monto', true);
define('CYT_MSG_MONTOS', "Indique los montos", true);

/* PRESUPUESTOS*/
define('CYT_MSG_PRESUPUESTO_FECHA_REQUIRED', CYT_LBL_PRESUPUESTO_DATE . ' es requerido', true);
define('CYT_MSG_PRESUPUESTO_CONCEPTO_REQUIRED', CYT_LBL_PRESUPUESTO_CONCEPTO . ' es requerido', true);
define('CYT_MSG_PRESUPUESTO_IMPORTE_REQUIRED', CYT_LBL_PRESUPUESTO_IMPORTE . ' es requerido', true);
define('CYT_MSG_PRESUPUESTO_DIAS_REQUIRED', CYT_LBL_PRESUPUESTO_DIAS . ' es requerido', true);
define('CYT_MSG_PRESUPUESTO_LUGAR_REQUIRED', CYT_LBL_PRESUPUESTO_LUGAR . ' es requerido', true);
define('CYT_MSG_PRESUPUESTO_PASAJES_REQUIRED', CYT_LBL_PRESUPUESTO_PASAJES . ' es requerido', true);
define('CYT_MSG_PRESUPUESTO_DESTINO_REQUIRED', CYT_LBL_PRESUPUESTO_DESTINO . ' es requerido', true);
define('CYT_MSG_PRESUPUESTO_DESCRIPCION_REQUIRED', CYT_LBL_PRESUPUESTO_DESCRIPCION . ' es requerido', true);
define('CYT_MSG_PRESUPUESTOS_REQUIRED', 'Debe ingresar al menos un monto', true);

define('CYT_MSG_PRESUPUESTO_ASIGNAR', 'Asignar Presupuesto', true);
define('CYT_MSG_PRESUPUESTOS', "Indique los servicios", true);

define('CYT_MSG_PRESUPUESTO_FECHA_FUERA_RANGO', CYT_LBL_PRESUPUESTO_DATE . ' fuera de rango', true);

//PDF

define('CYT_MSG_SOLICITUD_PDF_HEADER_TITLE', 'SOLICITUD DE SUBSIDIOS', true);
define('CYT_MSG_SOLICITUD_PDF_HEADER_TITLE_2', 'Viajes/Estadías/Inscripción a Congresos', true);

define('CYT_MSG_SOLICITUD_PDF_MES_1', 'Junio', true);
define('CYT_MSG_SOLICITUD_PDF_MES_2', 'Julio', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_DOMICILIO', 'Domicilio de notificación (Dentro del Radio Urbano de La Plata, Art. 20 Ord. 101)', true);
define('CYT_MSG_SOLICITUD_PROYECTOS_ACTUALES', 'PROYECTO/S ACREDITADO/S EN EL/LOS QUE PARTICIPA ACTUALMENTE SELECCIONADO/S', true);
define('CYT_MSG_SOLICITUD_PROYECTO_SELECCIONADO', 'PROYECTO DE INVESTIGACION SELECCIONADO EN EL MARCO DEL CUAL SE REALIZARA LA ACTIVIDAD', true);
define('CYT_MSG_SOLICITUD_PROYECTOS_OTROS', 'OTROS PROYECTOS EN LOS QUE PARTICIPA', true);
define('CYT_MSG_SOLICITUD_AMBITOS', 'AMBITOS ACADEMICOS EN QUE REALIZARA LA ACTIVIDAD', true);
define('CYT_MSG_SOLICITUD_AMBITOS_A', 'INSTITUCION/LUGAR DONDE REALIZARA LA ACTIVIDAD', true);
define('CYT_MSG_SOLICITUD_AMBITOS_B', 'AMBITOS ACADEMICOS EN QUE REALIZARA LA ACTIVIDAD', true);
define('CYT_MSG_SOLICITUD_AMBITOS_C', 'INSTITUCION/LUGAR DE PROCEDENCIA DEL INVESTIGADOR INVITADO', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_OBJETIVO', 'OBJETIVOS DEL VIAJE - JUSTIFICACION Y RELACION DE LAS TAREAS A REALIZAR CON EL PROYECTO DE INVESTIGACION - RELEVANCIA INSTITUCIONAL.', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_OBJETIVO_2017', 'OBJETIVOS DEL VIAJE - JUSTIFICACION Y RELACION CON EL PROYECTO DE INVESTIGACION', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_RELEVANCIA', 'RELEVANCIA INSTITUCIONAL: (-La importancia del evento con relación al tema del solicitante, -Su contribución al proyecto que integra, -La relevancia de su participación para transferir y fortalecer líneas de investigación de la Unidad Académica, -El establecimiento o afianzamiento de vínculos con otros equipos o investigadores particulares, -Los potenciales canales de difusión que pueden surgir a partir del evento)', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_OBJETIVO_2', 'Si el motivo de la solicitud es A)Reuniones Científicas deberá aclarar si realiza otra actividad además de presentar su trabajo (por ej. coordinador/a, comentarista de ponencias, panelista, presentador/a de libros o alguna otra actividad)', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_OBJETIVO_3', 'OBJETIVO DEL VIAJE Y RELACION DE LAS TAREAS A REALIZAR CON EL PROYECTO DE INVESTIGACION', true);
define('CYT_MSG_SOLICITUD_PDF_MONTO', 'MONTO SOLICITADO A LA UNLP (en pesos)', true);
define('CYT_MSG_SOLICITUD_PDF_MONTO_OTRO_ORGANISMO', 'MONTO SOLICITADO A OTROS ORGANISMOS', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_OTRA_ACTIVIDAD', 'Deberá aclarar si realiza otra actividad además de la actividad motivo de esta solicitada (por ej. coordinador/a, comentarista de ponencias, panelista, presentador/a de libros o alguna otra actividad)', true);
define('CYT_MSG_SOLICITUD_PDF_MOTIVO_A_TIPO', 'Tipo', true);
define('CYT_MSG_SOLICITUD_PDF_TITULO_TRABAJO', 'Título del Trabajo', true);
define('CYT_MSG_SOLICITUD_PDF_TITULO_CONFERENCIA', 'Título de la Conferencia', true);
define('CYT_MSG_SOLICITUD_PDF_AUTOR_TRABAJO', 'Autores del Trabajo', true);
define('CYT_MSG_SOLICITUD_PDF_AUTOR_CONFERENCIA', 'Autor', true);
define('CYT_MSG_SOLICITUD_PDF_NOMBRE_TRABAJO', 'Nombre del Congreso', true);
define('CYT_MSG_SOLICITUD_PDF_NOMBRE_CONFERENCIA', 'Congreso donde se dictará la conferencia', true);
define('CYT_MSG_SOLICITUD_PDF_CARACTER', 'Carácter', true);
define('CYT_MSG_SOLICITUD_PDF_LUGAR', 'Lugar', true);
define('CYT_MSG_SOLICITUD_PDF_FECHA', 'Fecha Inicio', true);
define('CYT_MSG_SOLICITUD_PDF_FECHA_HASTA', 'Fecha Fin', true);
define('CYT_MSG_SOLICITUD_PDF_RESUMEN_CONFERENCIA', ' de la Conferencia', true);
define('CYT_MSG_SOLICITUD_PDF_RESUMEN_TRABAJO', ' del Trabajo', true);
define('CYT_MSG_SOLICITUD_PDF_RELEVANCIA_EVENTO', 'Relevancia del evento', true);
define('CYT_MSG_SOLICITUD_PDF_RESUMEN', 'Resumen', true);
define('CYT_MSG_SOLICITUD_PDF_MODALIDAD_EVENTO', 'Modalidad de la presentación', true);
define('CYT_MSG_SOLICITUD_PDF_MOTIVO_C_PROFESOR', 'Profesor Visitante', true);
define('CYT_MSG_SOLICITUD_PDF_MOTIVO_C_LUGAR', 'Lugar de Origen del Prof. Visitante', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_PRODUCCION', 'Producción Científica, artística o desarrollo tecnológico en los últimos 5 años.', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_LIBROS_AUTORIAS', 'LIBROS (AUTORIAS)', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_AUTOR', 'Autor - Título - Editor - Edición(Nacional/Internacional) - ISBN - Lugar de Publicación - Año', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_LIBROS_COMPILACIONES', 'LIBROS (COMPILACIONES)', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_COMPILADOR', 'Compilador - Título - Editor - Edición(Nacional/Internacional) - ISBN - Lugar de Publicación - Año', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_CAPITULOS', 'CAPITULOS DE LIBROS', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_CAPITULOS_AUTORES', 'Autores - Capítulo/s - Título del Libro - Editor - Edición(Nacional/Internacional) - ISBN - Lugar de Publicación - Año', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_REFERATO_1', 'con o sin referato', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_REFERATO_2', 'solo con referato', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_REFERATO_3', '- Con Referato', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_ARTICULOS', 'ARTICULOS EN REVISTAS', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_ARTICULOS_AUTORES_1', 'Autor/es - Título - Revista - ISSN - Volumen - Nro. - Páginas - Año ', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_ARTICULOS_AUTORES_2', ' - Nacional o Internacional', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_CONGRESOS', 'CONGRESOS (TRABAJOS COMPLETOS PUBLICADOS EN ACTAS CON REFERATO)', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_CONGRESOS_AUTORES', 'Autor/es - Título trabajo - Congreso - Lugar - Volumen - Nro. - Páginas - Año - Fecha - Carácter(Nacional/Internacional)', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_PATENTES', 'PATENTES', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_PATENTES_AUTORES', 'Autor/es - Título - Código de Patente - Año', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_INTELECTUAL', 'REGISTROS DE PROPIEDAD INTELECTUAL', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_INTELECTUAL_TIPO', 'Tipo - Título - Titular/es - Registro Nro. - País - Autor/es', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_TECNICO', 'INFORMES TECNICOS', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_TECNICO_AUTORES', 'Autor/es - Título - Año - Institución', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_RRHH', 'Formación de Recursos Humanos realizada durante toda su carrera como docente-investigador.', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_DIR_TESIS', 'DIR./CODIR. TESIS DE POSGRADO APROBADAS', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_DIR_TESIS_DATOS', 'Año - Apellido y Nombre - Tema - Universidad - Calificación - (Dir./Codir.) - (Doctorado/Maestría)', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_DIR_BECAS', 'DIR./CODIR. BECAS DE POSGRADO / DIR./CODIR. TESIS DE POSGRADO EN REALIZACION', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_DIR_BECAS_DATOS', 'Año - Apellido y Nombre - Tema - Universidad - (Dir./Codir.) - Si es Tesis (Doctorado/Maestría) - Si es Beca (Tipo de Beca)', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_DIR_TESINAS', 'DIR./CODIR. TESINAS DE GRADO / DIR./CODIR. BECAS DE ENTRENAMIENTO', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_DIR_TESINAS_DATOS', 'Año - Apellido y Nombre - Tema - Universidad - (Dir./Codir.) - (Tesina de Grado/Beca de Entrenamiento)', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO', 'PLAN DE TRABAJO DE INVESTIGACIÓN (para los tipo B)', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_1', '1. Objetivo general de la estadía', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_2', '2. Objetivos específicos de la estadía', true);

define('CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_3', '3. Detalle de las actividades de invest. a realizar en el período relacionado con el proy. de invest. en el que participa.', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_3_2017', '3. Plan de trabajo de investigación a realizar en el período.', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_4', '4.- Cronograma', true);

define('CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_5', '5.- Aportes al grupo de investigación', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_5_2018', '5.- Justificación de la realización de la estadía y relación con el proyecto de investigación en el que participa', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_5_2017', '5.- Relevancia institucional: (Detalle de las actividades de investigación a realizar relacionadas con el proyecto de investigación en el que participa, la afinidad y los aportes del grupo receptor a la línea de investigación del solicitante, la transferencia que realizará el solicitante a su equipo de investigación, a la unidad de investigación y a la unidad académica', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_6_2018', '6. Relevancia institucional: (-La afinidad y los aportes del grupo receptor a la línea de investigación del solicitante, -La correspondencia del plan de trabajo a realizar con la línea de investigación del solicitante así como su factibilidad, -Los aportes del desarrollo del plan de trabajo a la línea de investigación del solicitante, -La transferencia que realizará el solicitante a su equipo de investigación, Unidad de Investigación y/o Unidad Académica a partir de la realización de su estadía)', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_6', '6. Relevancia del lugar donde realiza la estadía. Justifique la elección del lugar', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_7', '7. Relevancia del lugar donde realiza la estadía. Justifique la elección del lugar', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO', 'PLAN DE TRABAJO DE INVESTIGACIÓN (para los tipo C)', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO_1', '1. Objetivo general de la estadía', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO_2', '2. Plan de actividades de invest. a realizar en el período, en relación con el proy. de investigación del grupo receptor.', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO_2_2017', '2. Plan de trabajo de investigación a realizar en el período.', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO_3', '3. Aportes del desarrollo del plan de trabajo al grupo de investigación, Unidad de Investigación y/o Unidad Académica.', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO_3_2017', '3. Relación del plan de trabajo del investigador invitado con el proyecto de investigación acreditado del grupo receptor.', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO_4', '4. Otras actividades (ejemplo: dictado de cursos, seminarios, participación en eventos científicos, etc.)', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO_4_2017', '4. Aportes del desarrollo del plan de trabajo al grupo de investigación, Unidad de Investigación y/o Unidad Académica.', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO_5_2017', '5. Otras actividades', true);
define('CYT_MSG_SOLICITUD_DECLARACION_JURADA', 'Declaro bajo juramento que los datos consignados son veraces. Asimismo me comprometo, a presentar un informe por escrito, constancia de la rendición del área administrativo-financiera efectuada en mi Unidad Académica y adjuntar para los Subsidios tipo A la constancia de participación y para los Subsidios tipo B  una constancia del trabajo realizado, avalada por la institución receptora, en el término de 60 días después de finalizada la actividad.', true);
define('CYT_MSG_SOLICITUD_FIRMA_LUGAR', 'Lugar y Fecha', true);
define('CYT_MSG_SOLICITUD_FIRMA_ACLARACION', 'Firma y Aclaración', true);
define('CYT_MSG_SOLICITUD_FIRMA_AVAL', 'AVAL DE LA ', true);
define('CYT_MSG_SOLICITUD_FIRMA_DECANO', 'Firma del Decano', true);
define('CYT_MSG_SOLICITUD_UNIVERSIDAD', 'UNIVERSIDAD', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_DESCRIPCION', 'Indicar y describir la aplicación del subsidio en caso que le sea otorgado. La descripcion deberá ser lo mas detallada y precisa posible.', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_PRESUPUESTO', 'PRESUPUESTO ESTIMADO PRELIMINAR', true);
define('CYT_MSG_SOLICITUD_SEPARADOR_SERVICIOS_NO_PERSONALES', 'SERVICIOS NO PERSONALES', true);
define('CYT_MSG_SOLICITUD_TOTAL', 'TOTAL', true);


/* EVALUACIONES */

define('CYT_MSG_EVALUACION_TITLE_LIST', 'Evaluaciones', true);
define('CYT_MSG_EVALUACION_TITLE_ADD', 'Agregar ' . CYT_LBL_EVALUACION, true);
define('CYT_MSG_EVALUACION_TITLE_UPDATE', 'Modificar ' . CYT_LBL_EVALUACION , true);
define('CYT_MSG_EVALUACION_TITLE_VIEW', 'Visualizar ' . CYT_LBL_EVALUACION , true);
define('CYT_MSG_EVALUACION_TITLE_DELETE', 'Borrar ' . CYT_LBL_EVALUACION , true);
define('CYT_MSG_EVALUACION_CONSIDERAR_PUBLICADO', 'Considerar sólo lo publicado', true);

//PDF evaluación

define('CYT_MSG_EVALUACION_PDF_HEADER_TITLE', 'PLANILLA DE EVALUACION', true);
define('CYT_MSG_EVALUACION_PDF_MOTIVO', 'Motivo de la Solicitud', true);
define('CYT_MSG_EVALUACION_SEPARADOR_NEGRO_1_1', 'P. Max/ITEM', true);
define('CYT_MSG_EVALUACION_SEPARADOR_NEGRO_1_2', 'DETALLE Y PUNTAJE', true);
define('CYT_MSG_EVALUACION_SEPARADOR_NEGRO_1_3', 'P. OTORGADO', true);
define('CYT_MSG_EVALUACION_PLAN_TRABAJO', 'PLAN DE TRABAJO', true);
define('CYT_MSG_EVALUACION_PLAN_TRABAJO_ANEXO', '-Objetivo general de la estadía.<br>-Objetivos específicos de la estadía.<br>-Plan de trabajo de investigación a realizar en el período.<br>-Cronograma', true);
define('CYT_MSG_EVALUACION_PLAN_TRABAJO_ANEXO_PDF_1', '-Objetivo general de la estadía. -Objetivos específicos de la estadía.', true);
define('CYT_MSG_EVALUACION_PLAN_TRABAJO_ANEXO_PDF_3', '-Plan de trabajo de investigación a realizar en el período. -Cronograma', true);

define('CYT_MSG_EVALUACION_PLAN_TRABAJO_JUSTIFICACION', 'Justifique el punt. otorgado', true);
define('CYT_MSG_EVALUACION_PLAN_TRABAJO_JUSTIFICACION_PDF', 'Justificación del puntaje otorgado al Plan de Trabajo', true);
define('CYT_MSG_EVALUACION_EVENTO_JUSTIFICACION', 'Justificación del puntaje del ítem superior', true);
define('CYT_MSG_EVALUACION_EVENTO_JUSTIFICACION_PDF', 'Justificación del puntaje del ítem', true);
define('CYT_MSG_EVALUACION_MAX', 'Max.', true);
define('CYT_MSG_EVALUACION_PT', 'pt.', true);
define('CYT_MSG_EVALUACION_CV_VISITANTE', 'Y CV DEL VISITANTE', true);
define('CYT_MSG_EVALUACION_CATEGORIA', 'CATEGORIA', true);
define('CYT_MSG_EVALUACION_CARGO', 'CARGO DOCENTE', true);
define('CYT_MSG_EVALUACION_CARGO_ACTUAL', 'ACTUAL EN LA UNLP', true);
define('CYT_MSG_EVALUACION_CANT', 'Cant.', true);
define('CYT_MSG_EVALUACION_CV_SOLICITANTE', 'DEL SOLIC.', true);
define('CYT_MSG_EVALUACION_5_YEARS', '5 AÑOS', true);
define('CYT_MSG_EVALUACION_SUBTOTAL', 'Subtotal', true);
define('CYT_MSG_EVALUACION_PROD_ULTIMOS', 'PROD. ULTIMOS', true);
define('CYT_MSG_EVALUACION_HASTA', 'Hasta', true);
define('CYT_MSG_EVALUACION_C_U', 'c/u', true);
define('CYT_MSG_EVALUACION_FORMACION', 'FORMACION', true);
define('CYT_MSG_EVALUACION_RR_HH', 'RECURSOS HUMANOS', true);
define('CYT_MSG_EVALUACION_TOTAL', 'TOTAL', true);
define('CYT_MSG_EVALUACION_OBSERVACIONES', 'Observaciones', true);
define('CYT_MSG_EVALUACION_FIRMA', 'Firma Evaluador', true);
define('CYT_MSG_EVALUACION_ACLARACION', 'Aclaración', true);


define('CYT_MSG_EVALUACION_PLAN_REQUIRED', CYT_MSG_EVALUACION_PLAN_TRABAJO . ' es requerido', true);

define('CYT_MSG_EVALUACION_PLAN_TRABAJO_JUSTIFICACION_REQUERIDA', 'Faltan la justificación del puntaje otorgado en el plan de trabajo', true);
define('CYT_MSG_EVALUACION_JUSTIFICACION_REQUERIDA', 'Faltan las justificaciones de uno o más puntajes otorgados', true);

/* CAMBIOS */

define('CYT_MSG_CAMBIO_TITLE_LIST', 'Cambios', true);
define('CYT_MSG_CAMBIO_TITLE_ADD', 'Agregar ' . CYT_LBL_CAMBIO, true);
define('CYT_MSG_CAMBIO_TITLE_UPDATE', 'Modificar ' . CYT_LBL_CAMBIO , true);
define('CYT_MSG_CAMBIO_TITLE_VIEW', 'Visualizar ' . CYT_LBL_CAMBIO , true);
define('CYT_MSG_CAMBIO_TITLE_DELETE', 'Borrar ' . CYT_LBL_CAMBIO , true);

define('CYT_MSG_CAMBIO_ELIMINAR_PROHIBIDO', 'Sólo se pueden eliminar los cambios con estado CREADA', true);
define('CYT_MSG_CAMBIO_MODIFICAR_PROHIBIDO', 'Sólo se pueden modificar los cambios con estado CREADA', true);
define('CYT_MSG_CAMBIO_ENVIAR_PROHIBIDO', 'Sólo se pueden enviar los cambios con estado CREADA', true);
define('CYT_MSG_CAMBIO_ENVIAR_PREGUNTA', '¿Enviar el cambio?', true);

define('CYT_MSG_CAMBIO_PDF_TITLE', 'VISUALIZAR CAMBIO', true);
define('CYT_MSG_CAMBIO_ARCHIVO_NOMBRE', 'CAMBIO_', true);

define('CYT_MSG_SOLICITUD_FECHA_HASTA_MAYOR', CYT_MSG_SOLICITUD_PDF_FECHA . ' es mayor que '.CYT_MSG_SOLICITUD_PDF_FECHA_HASTA.' en la pestaña motivo', true);

define('CYT_MSG_INTEGRANTE_CV_PROBLEMA', 'Hubo un error al subir el Curriculum, intente nuevamente, si el problema persiste envíenos un mail a proyectos.secyt@presi.unlp.edu.ar', true);
define('CYT_MSG_INTEGRANTE_CVPROFESOR_PROBLEMA', 'Hubo un error al subir el Curriculum del Profesor, intente nuevamente, si el problema persiste envíenos un mail a proyectos.secyt@presi.unlp.edu.ar', true);
define('CYT_MSG_INTEGRANTE_ACEPTACION_PROBLEMA', 'Hubo un error al subir la Aceptacion, intente nuevamente, si el problema persiste envíenos un mail a proyectos.secyt@presi.unlp.edu.ar', true);
define('CYT_MSG_INTEGRANTE_INVITACIONGRUPO_PROBLEMA', 'Hubo un error al subir la invitacion, intente nuevamente, si el problema persiste envíenos un mail a proyectos.secyt@presi.unlp.edu.ar', true);



/* RENDICIONES */

define('CYT_MSG_RENDICION_TITLE_LIST', 'Rendiciones', true);
define('CYT_MSG_RENDICION_TITLE_ADD', 'Agregar ' . CYT_LBL_RENDICION, true);
define('CYT_MSG_RENDICION_TITLE_UPDATE', 'Modificar ' . CYT_LBL_RENDICION , true);
define('CYT_MSG_RENDICION_TITLE_VIEW', 'Visualizar ' . CYT_LBL_RENDICION , true);
define('CYT_MSG_RENDICION_TITLE_DELETE', 'Borrar ' . CYT_LBL_RENDICION , true);

define('CYT_MSG_RENDICION_ELIMINAR_PROHIBIDO', 'Sólo se pueden eliminar los rendiciones con estado CREADA', true);
define('CYT_MSG_RENDICION_MODIFICAR_PROHIBIDO', 'Sólo se pueden modificar los rendiciones con estado CREADA', true);
define('CYT_MSG_RENDICION_ENVIAR_PROHIBIDO', 'Sólo se pueden enviar los rendiciones con estado CREADA', true);
define('CYT_MSG_RENDICION_ENVIAR_PREGUNTA', '¿Enviar la rendicion?', true);

define('CYT_MSG_RENDICION_PDF_TITLE', 'VISUALIZAR RENDICION', true);
define('CYT_MSG_RENDICION_ARCHIVO_NOMBRE', 'RENDICION_', true);

define('CYT_MSG_RENDICION_CREADA', 'Sólo se puede crear una rendición por solicitud', true);

define('CYT_MSG_RENDICION_RENDICION_PROBLEMA', 'Hubo un error al subir la rendición, intente nuevamente, si el problema persiste envíenos un mail a viajes.secyt@presi.unlp.edu.ar', true);
define('CYT_MSG_RENDICION_INFORME_PROBLEMA', 'Hubo un error al subir el informe técnico, intente nuevamente, si el problema persiste envíenos un mail a viajes.secyt@presi.unlp.edu.ar', true);
define('CYT_MSG_RENDICION_CONSTANCIA_PROBLEMA', 'Hubo un error al subir la constancia, intente nuevamente, si el problema persiste envíenos un mail a viajes.secyt@presi.unlp.edu.ar', true);

define('CYT_MSG_RENDICION_PDF_HEADER_TITLE', 'RENDICION DE SUBSIDIOS ', true);
?>
