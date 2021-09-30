<?php


//envÃ­o de emails.


//desarrollo.
define('CDT_POP_MAIL_FROM', 'marcosp@presi.unlp.edu.ar');
define('CDT_POP_MAIL_FROM_NAME', 'Subsidios Ciencia y Técnica U.N.L.P.');
define('CDT_POP_MAIL_HOST', 'cyt.presi.unlp.edu.ar');
//define('CDT_POP_MAIL_PORT', '465');
define('CDT_POP_MAIL_MAILER', 'smtp');
define('CDT_POP_MAIL_USERNAME', 'marcosp@presi.unlp.edu.ar');
define('CDT_POP_MAIL_PASSWORD', 'elMaster1');
define('CDT_MAIL_ENVIO_POP', true);

define("CDT_DEBUG_LOG", true);
define("CDT_ERROR_LOG", true);
define("CDT_MESSAGE_LOG", true);
define("CDT_TEST_MODE", true);

define('CYT_DATE_FORMAT', 'd/m/Y');
define('CYT_DATETIME_FORMAT', 'd/m/Y H:i:s');
define('CYT_DATETIME_FORMAT_STRING', 'YmdHis');


//lista de permisos
define('CYT_FUNCTION_AGREGAR_SOLICITUD', '60');
define('CYT_FUNCTION_LISTAR_ESTADO', '65');
define('CYT_FUNCTION_VER_PUNTAJE', '66');
define('CYT_FUNCTION_VER_ANTERIORES', '67');
define('CYT_FUNCTION_ENVIAR_SOLICITUD', '68');
define('CYT_FUNCTION_ADMITIR_SOLICITUD', '69');
define('CYT_FUNCTION_RECHAZAR_SOLICITUD', '70');
define('CYT_FUNCTION_VER_EVALUACION', '76');
define('CYT_FUNCTION_EVALUAR_SOLICITUD', '74');
define('CYT_FUNCTION_LISTAR_CAMBIOS', '77');
define('CYT_FUNCTION_LISTAR_RENDICIONES', '80');

define('CYT_PERIODO_INICIAL', '2009');

define('CYT_PERIODO_YEAR', '2019');
define('CYT_RANGO_INI', '01/07/');
define('CYT_RANGO_FIN', '30/06/');
define('CYT_DIA_MES_BECA', '-03-31');
define('CYT_DIFERENCIA', 10);
define('CYT_PERIODO_ANTERIORES_OTORGADOS', '1');
define('CYT_MONTO_MAXIMO', 37500);
define('CYT_RESUMEN_PALABRAS_MAXIMO', 300);

//motivos
define('CYT_MOTIVO_A', 1);
define('CYT_MOTIVO_B', 2);
define('CYT_MOTIVO_C', 3);

define('CYT_CD_CONGRESO', 1);
define('CYT_DS_CONGRESO', 'CONGRESO');
define('CYT_CD_CONFERENCIA', 2);
define('CYT_DS_CONFERENCIA', 'CONFERENCIA');
define('CYT_CD_NACIONAL', 1);
define('CYT_DS_NACIONAL', 'NACIONAL');
define('CYT_CD_INTERNACIONAL', 2);
define('CYT_DS_INTERNACIONAL', 'INTERNACIONAL');

define('CYT_MODELO_PLANILLA_C', '5,10,15,20,25,30,35,40,45');
define('CYT_MODELO_PLANILLA_A', '1,2,6,7,11,12,16,17,21,22,26,27,31,32,36,37,41,42');

define('CYT_MODELO_PLANILLA_ITERADORES', '1=>9,2=>9,3=>9,4=>9,5=>9,6=>8,7=>9,8=>8,9=>9,10=>8,11=>8,12=>9,13=>8,14=>9,15=>8,16=>8,17=>9,18=>8,19=>9,20=>8,21=>9,22=>9,23=>9,24=>9,25=>9,26=>9,27=>9,28=>9,29=>9,30=>9,31=>9,32=>10,33=>9,34=>10,35=>9,36=>9,37=>10,38=>9,39=>10,40=>9,41=>9,42=>10,43=>9,44=>10,45=>9');
define('CYT_MODELO_PLANILLA_ITERADORES_2', '1=>12,2=>12,3=>12,4=>12,5=>12,6=>11,7=>12,8=>11,9=>12,10=>11,11=>11,12=>12,13=>11,14=>12,15=>11,16=>11,17=>12,18=>11,19=>12,20=>11,21=>12,22=>12,23=>12,24=>12,25=>12,26=>12,27=>12,28=>12,29=>12,30=>12,31=>12,32=>13,33=>12,34=>13,35=>12,36=>12,37=>13,38=>12,39=>13,40=>12,41=>12,42=>13,43=>12,44=>13,45=>12');

define('CYT_FECHA_CIERRE', '2017-03-01');

define('PATH_CAMBIOS', 'cambios');

define('CYT_CD_GROUPS_MOSTRAR', '3,4,8,9,10,11');

define('CYT_TIPO_INVESTIGADOR_MOSTRADOS', '3,4');

define('PATH_RENDICIONES', 'rendicones');

?>
