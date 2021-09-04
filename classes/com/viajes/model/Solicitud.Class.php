<?php

/**
 * Solicitud
 *
 * @author Marcos
 * @since 13-11-2013
 */

class Solicitud extends Entity{

	//variables de instancia.

	private $estado;
	
	private $docente;
	private $periodo;
	private $ds_investigador;
	private $nu_cuil;
	  private $ds_mail;
	  private $nu_telefono;
	  private $dt_fecha;
	  private $ds_calle;
	  private $nu_nro;
	  private $nu_piso;
	  private $ds_depto;
	  private $nu_cp;
	  private $titulo;
	  private $ds_titulogrado;
	  private $lugarTrabajo;	
	  private $ds_direccion;	
	  private $ds_telefono;
	  private $cargo;	
	  	
	  private $deddoc;	
	  	
	  private $facultad;	
	  	
	  private $facultadplanilla;	
	  	
	  private $bl_becario;
	  private $bl_unlp;
	  private $ds_tipobeca;
  	  private $ds_orgbeca;
  	  private $lugarTrabajoBeca;	
  	 
	  private $ds_periodobeca;
	  private $bl_carrera;
	  private $carrerainv;	
	  	
	  private $organismo;	
	  	
	 private $lugarTrabajoCarrera;	
	  private $dt_ingreso;	
	  private $categoria;
	  
	  private $tipoInvestigador;
	  
	  private $motivo;
	  
	  private $ds_objetivo;
	  private $nu_monto;
	  private $ds_curriculum;
	  private $ds_curriculumT;
	  private $ds_trabajo;
	  private $ds_trabajoT;
	  private $ds_aceptacion;
	  private $ds_aceptacionT;
	  private $ds_titulotrabajo;
	  private $ds_autorestrabajo;
	  private $ds_congreso;
	  private $ds_lugartrabajo;
	  private $dt_fechatrabajo;
	  private $dt_fechatrabajohasta;
	  private $ds_resumentrabajo;
	  private $ds_relevanciatrabajo;
	  private $ds_modalidadtrabajo;
	  private $ds_invitaciongrupo;
	  private $ds_invitaciongrupoT;
	  private $ds_aval;	
	  private $ds_avalT;	
	  private $ds_actividades;
	  private $ds_actividadesT;
	  private $ds_convenio;
	  private $ds_convenioT;
	  private $ds_cvprofesor;	
	  private $ds_cvprofesorT;	
	  private $ds_profesor;		
	  private $ds_lugarprofesor;
	  private $nu_puntaje;
	  private $nu_diferencia;	
	  private $ambitos;
	  private $montos;	
	  private $presupuestos;
	  private $ds_libros;
	  private $ds_compilados;
	  private $ds_capitulos;
	  private $ds_articulos;
	  private $ds_congresos;
	  private $ds_patentes;
	  private $ds_intelectuales;
	  private $ds_informes;
	  private $bl_congreso;
	  private $ds_tesis;
	  private $ds_tesinas;
	  private $ds_becas;
	  private $bl_nacional;
	  private $ds_observaciones;
	  private $bl_notificacion;
	  private $ds_objetivoC;
	  private $ds_planC;
	  private $ds_relacionProyectoC;
	private $ds_aportesC;
	private $ds_actividadesC;
	private $ds_generalB;
	private $ds_especificoB;
	private $ds_actividadesB;
	private $ds_cronogramaB;
	private $ds_aportesB;
	private $ds_relevanciaB;
	private $ds_justificacionB;
	private $ds_relevanciaA;
	private $ds_disciplina;	
	private $cat;
	
	private $proyectos;
	
	private $tipoinvestigador_oid;
	
	private $ds_googleScholar;	
	
	public function __construct(){
		 
		
		  $this->docente = new Docente();
		  
		  $this->periodo = new Periodo();
		  
		   $this->cat = new Cat();
		  
		   $this->ds_investigador = '';
		   
		   $this->nu_cuil = '';
		   
		  $this->ds_mail = '';
		  $this->nu_telefono = '';
		  $this->dt_fecha = '';
		  $this->ds_calle = '';
		  $this->nu_nro = '';
		  $this->nu_piso = '';
		  $this->ds_depto = '';
		  $this->nu_cp = '';
		  $this->ds_titulogrado = '';
		  $this->titulo = new Titulo();
		  $this->lugarTrabajo = new LugarTrabajo();	
		  $this->lugarTrabajoBeca = new LugarTrabajo();	
		  $this->lugarTrabajoCarrera = new LugarTrabajo();	
		  
		  
		  $this->cargo = new Cargo();	
		  
		  $this->deddoc = New DedDoc();	
		 	
		  $this->facultad = new Facultad();	
		  $this->facultadplanilla = new Facultad();	
		  
		  $this->bl_becario = 0;
		  $this->bl_unlp = 0;
		  $this->ds_tipobeca = '';
		  $this->ds_orgbeca = '';
		 
		  $this->ds_periodobeca = '';
		  $this->bl_carrera = 0;
		  $this->carrerainv = new CarreraInv();	
		 
		  $this->organismo = new Organismo();	
		  
		 
		  $this->dt_ingreso = '';	
		  $this->categoria = new Categoria();
		  
		 $this->tipoInvestigador = new Tipoinvestigador();
		  
		  $this->motivo = new Motivo();
		  
		  $this->ds_objetivo = '';
		  $this->nu_monto = '';
		  $this->ds_curriculum = '';
		  $this->ds_curriculumT = '';
		  $this->ds_trabajo = '';
		  $this->ds_trabajoT = '';
		  $this->ds_aceptacion = '';
		  $this->ds_aceptacionT = '';
		  $this->ds_titulotrabajo = '';
		  $this->ds_autorestrabajo = '';
		  $this->ds_congreso = '';
		  $this->ds_lugartrabajo = '';
		  $this->dt_fechatrabajo = '';
		  $this->dt_fechatrabajohasta = '';
		  $this->ds_resumentrabajo = '';
		  $this->ds_relevanciatrabajo = '';
		  $this->ds_modalidadtrabajo = '';
		  $this->ds_invitaciongrupo = '';
		  $this->ds_invitaciongrupoT = '';
		  $this->ds_aval = '';	
		  $this->ds_avalT = '';	
		  $this->ds_actividades = '';
		  $this->ds_actividadesT = '';
		  $this->ds_convenio = '';
		  $this->ds_convenioT = '';
		  $this->ds_cvprofesor = '';
		  $this->ds_cvprofesorT = '';	
		  $this->ds_profesor = '';		
		  $this->ds_lugarprofesor = '';	
		  $this->nu_puntaje = 0;	
		  $this->nu_diferencia = 0;	
		  $this->ambitos= new ItemCollection();
		  $this->montos= new ItemCollection();
		  $this->presupuestos= new ItemCollection();
		  $this->ds_libros='';
		  $this->ds_compilados='';
		  $this->ds_capitulos='';
		  $this->ds_articulos='';
		  $this->ds_congresos='';
		  $this->ds_patentes='';
		  $this->ds_intelectuales='';
		  $this->ds_informes='';
		  $this->bl_congreso=0;
		  $this->ds_tesis='';
		  $this->ds_tesinas='';
		  $this->ds_becas='';
		  $this->bl_nacional=0;
		  $this->ds_observaciones = '';
		  $this->bl_notificacion = 0;
		  $this->ds_objetivoC = '';
		  $this->ds_planC= '';
		  $this->ds_relacionProyectoC= '';
		  $this->ds_aportesC= '';
		  $this->ds_actividadesC= '';
		  $this->ds_generalB= '';
		  $this->ds_especificoB= '';
		  $this->ds_actividadesB= '';
		  $this->ds_cronogramaB= '';
		  $this->ds_aportesB= '';
		  $this->ds_relevanciaB= '';
		  $this->ds_relevanciaA= '';
		  $this->ds_disciplina = "";	
		  $this->proyectos= new ItemCollection();
	}




	

	


		

	public function getDocente()
	{
	    return $this->docente;
	}

	public function setDocente($docente)
	{
	    $this->docente = $docente;
	}

	public function getPeriodo()
	{
	    return $this->periodo;
	}

	public function setPeriodo($periodo)
	{
	    $this->periodo = $periodo;
	}

	public function getDs_mail()
	{
	    return $this->ds_mail;
	}

	public function setDs_mail($ds_mail)
	{
	    $this->ds_mail = $ds_mail;
	}

	public function getNu_telefono()
	{
	    return $this->nu_telefono;
	}

	public function setNu_telefono($nu_telefono)
	{
	    $this->nu_telefono = $nu_telefono;
	}

	public function getDt_fecha()
	{
	    return $this->dt_fecha;
	}

	public function setDt_fecha($dt_fecha)
	{
	    $this->dt_fecha = $dt_fecha;
	}

	public function getDs_calle()
	{
	    return $this->ds_calle;
	}

	public function setDs_calle($ds_calle)
	{
	    $this->ds_calle = $ds_calle;
	}

	public function getNu_nro()
	{
	    return $this->nu_nro;
	}

	public function setNu_nro($nu_nro)
	{
	    $this->nu_nro = $nu_nro;
	}

	public function getNu_piso()
	{
	    return $this->nu_piso;
	}

	public function setNu_piso($nu_piso)
	{
	    $this->nu_piso = $nu_piso;
	}

	public function getDs_depto()
	{
	    return $this->ds_depto;
	}

	public function setDs_depto($ds_depto)
	{
	    $this->ds_depto = $ds_depto;
	}

	public function getNu_cp()
	{
	    return $this->nu_cp;
	}

	public function setNu_cp($nu_cp)
	{
	    $this->nu_cp = $nu_cp;
	}

	public function getDs_titulogrado()
	{
	    return $this->ds_titulogrado;
	}

	public function setDs_titulogrado($ds_titulogrado)
	{
	    $this->ds_titulogrado = $ds_titulogrado;
	}

	public function getLugarTrabajo()
	{
	    return $this->lugarTrabajo;
	}

	public function setLugarTrabajo($lugarTrabajo)
	{
	    $this->lugarTrabajo = $lugarTrabajo;
	}

	public function getCargo()
	{
	    return $this->cargo;
	}

	public function setCargo($cargo)
	{
	    $this->cargo = $cargo;
	}

	public function getDeddoc()
	{
	    return $this->deddoc;
	}

	public function setDeddoc($deddoc)
	{
	    $this->deddoc = $deddoc;
	}

	public function getFacultad()
	{
	    return $this->facultad;
	}

	public function setFacultad($facultad)
	{
	    $this->facultad = $facultad;
	}

	public function getFacultadplanilla()
	{
	    return $this->facultadplanilla;
	}

	public function setFacultadplanilla($facultadplanilla)
	{
	    $this->facultadplanilla = $facultadplanilla;
	}

	public function getBl_becario()
	{
	    return $this->bl_becario;
	}

	public function setBl_becario($bl_becario)
	{
	    $this->bl_becario = $bl_becario;
	}

	public function getBl_unlp()
	{
	    return $this->bl_unlp;
	}

	public function setBl_unlp($bl_unlp)
	{
	    $this->bl_unlp = $bl_unlp;
	}

	public function getDs_tipobeca()
	{
	    return $this->ds_tipobeca;
	}

	public function setDs_tipobeca($ds_tipobeca)
	{
	    $this->ds_tipobeca = $ds_tipobeca;
	}

	public function getDs_orgbeca()
	{
	    return $this->ds_orgbeca;
	}

	public function setDs_orgbeca($ds_orgbeca)
	{
	    $this->ds_orgbeca = $ds_orgbeca;
	}

	public function getLugarTrabajoBeca()
	{
	    return $this->lugarTrabajoBeca;
	}

	public function setLugarTrabajoBeca($lugarTrabajoBeca)
	{
	    $this->lugarTrabajoBeca = $lugarTrabajoBeca;
	}

	public function getDs_periodobeca()
	{
	    return $this->ds_periodobeca;
	}

	public function setDs_periodobeca($ds_periodobeca)
	{
	    $this->ds_periodobeca = $ds_periodobeca;
	}

	public function getBl_carrera()
	{
	    return $this->bl_carrera;
	}

	public function setBl_carrera($bl_carrera)
	{
	    $this->bl_carrera = $bl_carrera;
	}

	public function getCarrerainv()
	{
	    return $this->carrerainv;
	}

	public function setCarrerainv($carrerainv)
	{
	    $this->carrerainv = $carrerainv;
	}

	public function getOrganismo()
	{
	    return $this->organismo;
	}

	public function setOrganismo($organismo)
	{
	    $this->organismo = $organismo;
	}

	public function getLugarTrabajoCarrera()
	{
	    return $this->lugarTrabajoCarrera;
	}

	public function setLugarTrabajoCarrera($lugarTrabajoCarrera)
	{
	    $this->lugarTrabajoCarrera = $lugarTrabajoCarrera;
	}

	public function getDt_ingreso()
	{
	    return $this->dt_ingreso;
	}

	public function setDt_ingreso($dt_ingreso)
	{
	    $this->dt_ingreso = $dt_ingreso;
	}

	public function getCategoria()
	{
	    return $this->categoria;
	}

	public function setCategoria($categoria)
	{
	    $this->categoria = $categoria;
	}

	public function getTipoInvestigador()
	{
	    return $this->tipoInvestigador;
	}

	public function setTipoInvestigador($tipoInvestigador)
	{
	    $this->tipoInvestigador = $tipoInvestigador;
	}

	public function getMotivo()
	{
	    return $this->motivo;
	}

	public function setMotivo($motivo)
	{
	    $this->motivo = $motivo;
	}

	public function getDs_objetivo()
	{
	    return $this->ds_objetivo;
	}

	public function setDs_objetivo($ds_objetivo)
	{
	    $this->ds_objetivo = $ds_objetivo;
	}

	public function getNu_monto()
	{
	    return $this->nu_monto;
	}

	public function setNu_monto($nu_monto)
	{
	    $this->nu_monto = $nu_monto;
	}

	public function getDs_curriculum()
	{
	    return $this->ds_curriculum;
	}

	public function setDs_curriculum($ds_curriculum)
	{
	    $this->ds_curriculum = $ds_curriculum;
	}

	public function getDs_curriculumT()
	{
	    return $this->ds_curriculumT;
	}

	public function setDs_curriculumT($ds_curriculumT)
	{
	    $this->ds_curriculumT = $ds_curriculumT;
	}

	public function getDs_trabajo()
	{
	    return $this->ds_trabajo;
	}

	public function setDs_trabajo($ds_trabajo)
	{
	    $this->ds_trabajo = $ds_trabajo;
	}

	public function getDs_trabajoT()
	{
	    return $this->ds_trabajoT;
	}

	public function setDs_trabajoT($ds_trabajoT)
	{
	    $this->ds_trabajoT = $ds_trabajoT;
	}

	public function getDs_aceptacion()
	{
	    return $this->ds_aceptacion;
	}

	public function setDs_aceptacion($ds_aceptacion)
	{
	    $this->ds_aceptacion = $ds_aceptacion;
	}

	public function getDs_aceptacionT()
	{
	    return $this->ds_aceptacionT;
	}

	public function setDs_aceptacionT($ds_aceptacionT)
	{
	    $this->ds_aceptacionT = $ds_aceptacionT;
	}

	public function getDs_titulotrabajo()
	{
	    return $this->ds_titulotrabajo;
	}

	public function setDs_titulotrabajo($ds_titulotrabajo)
	{
	    $this->ds_titulotrabajo = $ds_titulotrabajo;
	}

	public function getDs_autorestrabajo()
	{
	    return $this->ds_autorestrabajo;
	}

	public function setDs_autorestrabajo($ds_autorestrabajo)
	{
	    $this->ds_autorestrabajo = $ds_autorestrabajo;
	}

	public function getDs_congreso()
	{
	    return $this->ds_congreso;
	}

	public function setDs_congreso($ds_congreso)
	{
	    $this->ds_congreso = $ds_congreso;
	}

	public function getDs_lugartrabajo()
	{
	    return $this->ds_lugartrabajo;
	}

	public function setDs_lugartrabajo($ds_lugartrabajo)
	{
	    $this->ds_lugartrabajo = $ds_lugartrabajo;
	}

	public function getDt_fechatrabajo()
	{
	    return $this->dt_fechatrabajo;
	}

	public function setDt_fechatrabajo($dt_fechatrabajo)
	{
	    $this->dt_fechatrabajo = $dt_fechatrabajo;
	}

	public function getDs_resumentrabajo()
	{
	    return $this->ds_resumentrabajo;
	}

	public function setDs_resumentrabajo($ds_resumentrabajo)
	{
	    $this->ds_resumentrabajo = $ds_resumentrabajo;
	}

	public function getDs_invitaciongrupo()
	{
	    return $this->ds_invitaciongrupo;
	}

	public function setDs_invitaciongrupo($ds_invitaciongrupo)
	{
	    $this->ds_invitaciongrupo = $ds_invitaciongrupo;
	}

	public function getDs_invitaciongrupoT()
	{
	    return $this->ds_invitaciongrupoT;
	}

	public function setDs_invitaciongrupoT($ds_invitaciongrupoT)
	{
	    $this->ds_invitaciongrupoT = $ds_invitaciongrupoT;
	}

	public function getDs_aval()
	{
	    return $this->ds_aval;
	}

	public function setDs_aval($ds_aval)
	{
	    $this->ds_aval = $ds_aval;
	}

	public function getDs_avalT()
	{
	    return $this->ds_avalT;
	}

	public function setDs_avalT($ds_avalT)
	{
	    $this->ds_avalT = $ds_avalT;
	}

	public function getDs_actividades()
	{
	    return $this->ds_actividades;
	}

	public function setDs_actividades($ds_actividades)
	{
	    $this->ds_actividades = $ds_actividades;
	}

	public function getDs_actividadesT()
	{
	    return $this->ds_actividadesT;
	}

	public function setDs_actividadesT($ds_actividadesT)
	{
	    $this->ds_actividadesT = $ds_actividadesT;
	}

	public function getDs_convenio()
	{
	    return $this->ds_convenio;
	}

	public function setDs_convenio($ds_convenio)
	{
	    $this->ds_convenio = $ds_convenio;
	}

	public function getDs_convenioT()
	{
	    return $this->ds_convenioT;
	}

	public function setDs_convenioT($ds_convenioT)
	{
	    $this->ds_convenioT = $ds_convenioT;
	}

	public function getDs_cvprofesor()
	{
	    return $this->ds_cvprofesor;
	}

	public function setDs_cvprofesor($ds_cvprofesor)
	{
	    $this->ds_cvprofesor = $ds_cvprofesor;
	}

	public function getDs_cvprofesorT()
	{
	    return $this->ds_cvprofesorT;
	}

	public function setDs_cvprofesorT($ds_cvprofesorT)
	{
	    $this->ds_cvprofesorT = $ds_cvprofesorT;
	}

	public function getDs_profesor()
	{
	    return $this->ds_profesor;
	}

	public function setDs_profesor($ds_profesor)
	{
	    $this->ds_profesor = $ds_profesor;
	}

	public function getDs_lugarprofesor()
	{
	    return $this->ds_lugarprofesor;
	}

	public function setDs_lugarprofesor($ds_lugarprofesor)
	{
	    $this->ds_lugarprofesor = $ds_lugarprofesor;
	}

	public function getNu_puntaje()
	{
	    return $this->nu_puntaje;
	}

	public function setNu_puntaje($nu_puntaje)
	{
	    $this->nu_puntaje = $nu_puntaje;
	}

	public function getNu_diferencia()
	{
	    return $this->nu_diferencia;
	}

	public function setNu_diferencia($nu_diferencia)
	{
	    $this->nu_diferencia = $nu_diferencia;
	}

	public function getAmbitos()
	{
	    return $this->ambitos;
	}

	public function setAmbitos($ambitos)
	{
	    $this->ambitos = $ambitos;
	}

	public function getMontos()
	{
	    return $this->montos;
	}

	public function setMontos($montos)
	{
	    $this->montos = $montos;
	}

	public function getPresupuestos()
	{
	    return $this->presupuestos;
	}

	public function setPresupuestos($presupuestos)
	{
	    $this->presupuestos = $presupuestos;
	}

	public function getDs_libros()
	{
	    return $this->ds_libros;
	}

	public function setDs_libros($ds_libros)
	{
	    $this->ds_libros = $ds_libros;
	}

	public function getDs_compilados()
	{
	    return $this->ds_compilados;
	}

	public function setDs_compilados($ds_compilados)
	{
	    $this->ds_compilados = $ds_compilados;
	}

	public function getDs_capitulos()
	{
	    return $this->ds_capitulos;
	}

	public function setDs_capitulos($ds_capitulos)
	{
	    $this->ds_capitulos = $ds_capitulos;
	}

	public function getDs_articulos()
	{
	    return $this->ds_articulos;
	}

	public function setDs_articulos($ds_articulos)
	{
	    $this->ds_articulos = $ds_articulos;
	}

	public function getDs_congresos()
	{
	    return $this->ds_congresos;
	}

	public function setDs_congresos($ds_congresos)
	{
	    $this->ds_congresos = $ds_congresos;
	}

	public function getDs_patentes()
	{
	    return $this->ds_patentes;
	}

	public function setDs_patentes($ds_patentes)
	{
	    $this->ds_patentes = $ds_patentes;
	}

	public function getDs_intelectuales()
	{
	    return $this->ds_intelectuales;
	}

	public function setDs_intelectuales($ds_intelectuales)
	{
	    $this->ds_intelectuales = $ds_intelectuales;
	}

	public function getDs_informes()
	{
	    return $this->ds_informes;
	}

	public function setDs_informes($ds_informes)
	{
	    $this->ds_informes = $ds_informes;
	}

	public function getBl_congreso()
	{
	    return $this->bl_congreso;
	}

	public function setBl_congreso($bl_congreso)
	{
	    $this->bl_congreso = $bl_congreso;
	}

	public function getDs_tesis()
	{
	    return $this->ds_tesis;
	}

	public function setDs_tesis($ds_tesis)
	{
	    $this->ds_tesis = $ds_tesis;
	}

	public function getDs_tesinas()
	{
	    return $this->ds_tesinas;
	}

	public function setDs_tesinas($ds_tesinas)
	{
	    $this->ds_tesinas = $ds_tesinas;
	}

	public function getDs_becas()
	{
	    return $this->ds_becas;
	}

	public function setDs_becas($ds_becas)
	{
	    $this->ds_becas = $ds_becas;
	}

	public function getBl_nacional()
	{
	    return $this->bl_nacional;
	}

	public function setBl_nacional($bl_nacional)
	{
	    $this->bl_nacional = $bl_nacional;
	}

	public function getDs_observaciones()
	{
	    return $this->ds_observaciones;
	}

	public function setDs_observaciones($ds_observaciones)
	{
	    $this->ds_observaciones = $ds_observaciones;
	}

	public function getBl_notificacion()
	{
	    return $this->bl_notificacion;
	}

	public function setBl_notificacion($bl_notificacion)
	{
	    $this->bl_notificacion = $bl_notificacion;
	}

	public function getDs_objetivoC()
	{
	    return $this->ds_objetivoC;
	}

	public function setDs_objetivoC($ds_objetivoC)
	{
	    $this->ds_objetivoC = $ds_objetivoC;
	}

	public function getDs_planC()
	{
	    return $this->ds_planC;
	}

	public function setDs_planC($ds_planC)
	{
	    $this->ds_planC = $ds_planC;
	}

	public function getDs_aportesC()
	{
	    return $this->ds_aportesC;
	}

	public function setDs_aportesC($ds_aportesC)
	{
	    $this->ds_aportesC = $ds_aportesC;
	}

	public function getDs_actividadesC()
	{
	    return $this->ds_actividadesC;
	}

	public function setDs_actividadesC($ds_actividadesC)
	{
	    $this->ds_actividadesC = $ds_actividadesC;
	}

	public function getDs_generalB()
	{
	    return $this->ds_generalB;
	}

	public function setDs_generalB($ds_generalB)
	{
	    $this->ds_generalB = $ds_generalB;
	}

	public function getDs_especificoB()
	{
	    return $this->ds_especificoB;
	}

	public function setDs_especificoB($ds_especificoB)
	{
	    $this->ds_especificoB = $ds_especificoB;
	}

	public function getDs_actividadesB()
	{
	    return $this->ds_actividadesB;
	}

	public function setDs_actividadesB($ds_actividadesB)
	{
	    $this->ds_actividadesB = $ds_actividadesB;
	}

	public function getDs_cronogramaB()
	{
	    return $this->ds_cronogramaB;
	}

	public function setDs_cronogramaB($ds_cronogramaB)
	{
	    $this->ds_cronogramaB = $ds_cronogramaB;
	}

	public function getDs_aportesB()
	{
	    return $this->ds_aportesB;
	}

	public function setDs_aportesB($ds_aportesB)
	{
	    $this->ds_aportesB = $ds_aportesB;
	}

	public function getProyectos()
	{
	    return $this->proyectos;
	}

	public function setProyectos($proyectos)
	{
	    $this->proyectos = $proyectos;
	}

	public function getCat()
	{
	    return $this->cat;
	}

	public function setCat($cat)
	{
	    $this->cat = $cat;
	}

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    
	public function __toString(){
		
		return $this->getDocente()->getDs_apellido().' '.$this->getDocente()->getDs_nombre();
	}

	public function getDs_investigador()
	{
	    return $this->ds_investigador;
	}

	public function setDs_investigador($ds_investigador)
	{
	    $this->ds_investigador = $ds_investigador;
	}

	public function getNu_cuil()
	{
	    return $this->nu_cuil;
	}

	public function setNu_cuil($nu_cuil)
	{
	    $this->nu_cuil = $nu_cuil;
	}

	public function getDs_direccion()
	{
	    return $this->ds_direccion;
	}

	public function setDs_direccion($ds_direccion)
	{
	    $this->ds_direccion = $ds_direccion;
	}

	public function getDs_telefono()
	{
	    return $this->ds_telefono;
	}

	public function setDs_telefono($ds_telefono)
	{
	    $this->ds_telefono = $ds_telefono;
	}

	public function getTitulo()
	{
	    return $this->titulo;
	}

	public function setTitulo($titulo)
	{
	    $this->titulo = $titulo;
	}

	public function getTipoinvestigador_oid()
	{
	    return $this->tipoinvestigador_oid;
	}

	public function setTipoinvestigador_oid($tipoinvestigador_oid)
	{
	    $this->tipoinvestigador_oid = $tipoinvestigador_oid;
	}

	public function getDs_disciplina()
	{
	    return $this->ds_disciplina;
	}

	public function setDs_disciplina($ds_disciplina)
	{
	    $this->ds_disciplina = $ds_disciplina;
	}

	public function getDt_fechatrabajohasta()
	{
	    return $this->dt_fechatrabajohasta;
	}

	public function setDt_fechatrabajohasta($dt_fechatrabajohasta)
	{
	    $this->dt_fechatrabajohasta = $dt_fechatrabajohasta;
	}

	public function getDs_relevanciatrabajo()
	{
	    return $this->ds_relevanciatrabajo;
	}

	public function setDs_relevanciatrabajo($ds_relevanciatrabajo)
	{
	    $this->ds_relevanciatrabajo = $ds_relevanciatrabajo;
	}

	public function getDs_modalidadtrabajo()
	{
	    return $this->ds_modalidadtrabajo;
	}

	public function setDs_modalidadtrabajo($ds_modalidadtrabajo)
	{
	    $this->ds_modalidadtrabajo = $ds_modalidadtrabajo;
	}

	public function getDs_relevanciaB()
	{
	    return $this->ds_relevanciaB;
	}

	public function setDs_relevanciaB($ds_relevanciaB)
	{
	    $this->ds_relevanciaB = $ds_relevanciaB;
	}

	public function getDs_relacionProyectoC()
	{
	    return $this->ds_relacionProyectoC;
	}

	public function setDs_relacionProyectoC($ds_relacionProyectoC)
	{
	    $this->ds_relacionProyectoC = $ds_relacionProyectoC;
	}

	public function getDs_relevanciaA()
	{
	    return $this->ds_relevanciaA;
	}

	public function setDs_relevanciaA($ds_relevanciaA)
	{
	    $this->ds_relevanciaA = $ds_relevanciaA;
	}

	public function getDs_justificacionB()
	{
	    return $this->ds_justificacionB;
	}

	public function setDs_justificacionB($ds_justificacionB)
	{
	    $this->ds_justificacionB = $ds_justificacionB;
	}

	public function getDs_googleScholar()
	{
	    return $this->ds_googleScholar;
	}

	public function setDs_googleScholar($ds_googleScholar)
	{
	    $this->ds_googleScholar = $ds_googleScholar;
	}
}
?>