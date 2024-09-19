<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property EquiposModel $EquiposModel
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_DB $db
 * @property CI_Load $load
 * @property CI_Session $session
 */
class EquiposController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->model('EquiposModel');
		$this->load->library('session');
	}

	public function index()
	{
		$data['equipos'] = $this->EquiposModel->mostrarEquipos();
		$this->load->view('verEstaciones', $data);
	}

	public function crearEstacion()
	{
		$this->load->view('crearEstacion');
	}

	public function crearEquipo()
	{
		$equipo = [
			'nombre' => $this->input->post('nombre'),
			'descripcion' => $this->input->post('descripcion'),
			'estado' => $this->input->post('estado')
		];

		// Intenta crear el equipo
		if ($this->EquiposModel->crearEquipo($equipo)) {
			$this->session->set_flashdata('equipo_creado', true);
			redirect('EquiposController/crearEstacion');
		} else {
			$this->session->set_flashdata('error_equipo', 'El nombre del equipo ya existe.');
			redirect('EquiposController/crearEstacion');
		}
	}

	public function actualizarEstacion($idEquipo)
	{
		$datoEquipo['equipo'] = $this->EquiposModel->obtenerEquipo($idEquipo);
		$this->load->view('actualizarEstacion', $datoEquipo);
	}

	public function editarEquipo($idEquipo)
	{
		$equipo = [
			'nombre' => $this->input->post('nombre'),
			'descripcion' => $this->input->post('descripcion'),
			'estado' => $this->input->post('estado')
		];

		$this->EquiposModel->editarEquipo($equipo, $idEquipo);
		redirect('EquiposController/listarEstaciones');
	}

	public function eliminarEquipo($idEquipo)
	{
		$this->EquiposModel->eliminarEquipo($idEquipo);
		redirect('EquiposController/listarEstaciones');
	}


	public function listarEstaciones()
	{
		$datosEquipos['equipos'] = $this->EquiposModel->mostrarEquipos();
		$this->load->view('listaEstaciones', $datosEquipos);
	}

	public function listarEstacionesInactivas()
	{
		$datosEquipos['equipos'] = $this->EquiposModel->mostrarEquiposInactivos();
		$this->load->view('listaEstacionesInactivas', $datosEquipos);
	}


	public function listarHistorial()
	{
		$datosHistoriales['historiales'] = $this->EquiposModel->mostrarHistorial();
		$datosEquipos['equipos'] = $this->EquiposModel->mostrarEquipos(); // Obtener los nombres de equipos
		$this->load->view('historial', array_merge($datosHistoriales, $datosEquipos)); // Enviar ambos arrays a la vista
	}

	public function iniciarTiempo()
	{
		// Obtener el cuerpo de la solicitud en formato JSON
		$input = json_decode($this->input->raw_input_stream, true);

		// Verificar que idEquipo exista en los datos recibidos
		if (!isset($input['idEquipo']) || empty($input['idEquipo'])) {
			$response = array('error' => 'ID del equipo no proporcionado.');
			header('Content-Type: application/json');
			echo json_encode($response);
			return;
		}

		$idEquipo = $input['idEquipo'];
		$inicioTiempo = date('Y-m-d H:i:s');
		$finalTiempo = date('Y-m-d H:i:s');

		// Intentar insertar el historial y manejar posibles errores
		try {
			$idHistorial = $this->EquiposModel->iniciarHistorial($idEquipo, $inicioTiempo, $finalTiempo);

			// Devolver el ID del historial como respuesta
			$response = array('idHistorial' => $idHistorial);
			header('Content-Type: application/json');
			echo json_encode($response);
		} catch (Exception $e) {
			// Manejar errores y devolver respuesta adecuada
			$response = array('error' => 'Error al procesar la solicitud.', 'details' => $e->getMessage());
			header('Content-Type: application/json');
			echo json_encode($response);
		}
	}
	public function detenerTiempo()
	{
		$input = json_decode($this->input->raw_input_stream, true); // Obtener el cuerpo de la solicitud en formato JSON
		$idHistorial = isset($input['idHistorial']) ? $input['idHistorial'] : null;

		if ($idHistorial) {
			$finTiempo = date('Y-m-d H:i:s'); // Obtener la fecha y hora actual
			try {
				$this->EquiposModel->detenerHistorial($idHistorial, $finTiempo);
				echo json_encode(array('status' => 'success'));
			} catch (Exception $e) {
				echo json_encode(array('status' => 'error', 'message' => 'Error al detener el tiempo: ' . $e->getMessage()));
			}
		} else {
			echo json_encode(array('status' => 'error', 'message' => 'ID del historial no proporcionado.'));
		}
	}

	public function obtenerEstadisticas()
	{
		$estacionMasRegistros = $this->EquiposModel->estacionConMasRegistros();
		$estacionMenosUsada = $this->EquiposModel->estacionMenosUsada();

		$data = [
			'estacionMasRegistros' => $estacionMasRegistros ? $estacionMasRegistros : (object) ['nombreEstacion' => 'Desconocida', 'cantidad' => 0],
			'estacionMenosUsada' => $estacionMenosUsada ? $estacionMenosUsada : (object) ['nombreEstacion' => 'Desconocida', 'cantidad' => 0]
		];
		echo json_encode($data);
	}

	public function listarNotificaciones()
	{
		$datosNotificaciones['notificaciones'] = $this->EquiposModel->mostrarNotificaciones();
		$datosEquipos['equipos'] = $this->EquiposModel->mostrarEquipos(); // Obtener los nombres de equipos
		$this->load->view('listaNotificaciones', array_merge($datosNotificaciones, $datosEquipos)); // Enviar ambos arrays a la vista;
	}

	public function obtenerNotificaciones()
	{
		$notificaciones = $this->EquiposModel->obtenerNotificaciones(); // Supongamos que devuelve un array de notificaciones
		echo json_encode($notificaciones);
	}

	public function cargarVistaCrearNotificaciones()
	{
		$datosEquipos['equipos'] = $this->EquiposModel->mostrarEquipos(); // Obtener los nombres de equipos
		$this->load->view('crearNotificacion', $datosEquipos);
	}

	public function crearNotificacion()
	{
		$notificacion = [
			'nombreNotificacion' => $this->input->post('name'),
			'iconoNotificacion' => trim($this->input->post('icon')) ?: null,
			'tituloNotificacion' => trim($this->input->post('title')) ?: null,
			'textoNotificacion' => trim($this->input->post('text')) ?: null,
			'colorBotonNotificacion' => $this->input->post('colorButton'),
			'idEquipoNotificacion' => trim($this->input->post('estacionFilter')) ?: null,
			'tiempoConfiguradoNotificacion' => $this->input->post('configureTime'),
			'imagenUrlNotificacion' => trim($this->input->post('imageUrl')) ?: null,
			'anchoImagenNotificacion' => trim($this->input->post('imageWidth')) ?: null,
			'largoImagenNotificacion' => trim($this->input->post('imageHeight')) ?: null,
			'nombreAlternoImagenNotificacion' => trim($this->input->post('altName')) ?: null,
			'imagenUrlBackgroundNotificacion' => trim($this->input->post('BackgroundImageUrl')) ?: null,
			'colorBackgroundNotificacion' => $this->input->post('BackgroundColor'),
			'colorBackdropNotificacion' => $this->input->post('BackdropColor'),
		];

		// Intenta crear la notificación
		if ($this->EquiposModel->crearNotificacion($notificacion)) {
			$this->session->set_flashdata('notificacion_creada', true);
			redirect('EquiposController/cargarVistaCrearNotificaciones');
		} else {
			$this->session->set_flashdata('error_notificacion', true);
			redirect('EquiposController/cargarVistaCrearNotificaciones');
		}
	}

	public function vistaActualizarNotificacion($idNotificacion)
	{
		$datoNotificacion['notificacion'] = $this->EquiposModel->obtenerNotificacionbyId($idNotificacion);
		$datosEquipos['equipos'] = $this->EquiposModel->mostrarEquipos(); // Obtener los nombres de equipos
		$this->load->view('actualizarNotificacion', array_merge($datoNotificacion, $datosEquipos));
	}

	public function editarNotificacion($idNotificacion)
	{
		$notificacion = [
			'nombreNotificacion' => $this->input->post('name'),
			'iconoNotificacion' => trim($this->input->post('icon')) ?: null,
			'tituloNotificacion' => trim($this->input->post('title')) ?: null,
			'textoNotificacion' => trim($this->input->post('text')) ?: null,
			'colorBotonNotificacion' => $this->input->post('colorButton'),
			'idEquipoNotificacion' => trim($this->input->post('estacionFilter')) ?: null,
			'tiempoConfiguradoNotificacion' => $this->input->post('configureTime'),
			'imagenUrlNotificacion' => trim($this->input->post('imageUrl')) ?: null,
			'anchoImagenNotificacion' => trim($this->input->post('imageWidth')) ?: null,
			'largoImagenNotificacion' => trim($this->input->post('imageHeight')) ?: null,
			'nombreAlternoImagenNotificacion' => trim($this->input->post('altName')) ?: null,
			'imagenUrlBackgroundNotificacion' => trim($this->input->post('BackgroundImageUrl')) ?: null,
			'colorBackgroundNotificacion' => $this->input->post('BackgroundColor'),
			'colorBackdropNotificacion' => $this->input->post('BackdropColor'),
		];

		if ($this->EquiposModel->editarNotificacion($notificacion, $idNotificacion)) {
			$this->session->set_flashdata('notificacion_actualizada', true);
			redirect('EquiposController/listarNotificaciones');
		} else {
			$this->session->set_flashdata('error_actualizarNotificacion', true);
			redirect('EquiposController/vistaActualizarNotificacion/' . $idNotificacion);
		}
	}

	public function eliminarNotificacion($idNotificacion)
	{
		if ($this->EquiposModel->eliminarNotificacion($idNotificacion)) {
			$this->session->set_flashdata('notificacion_eliminada', true);
			redirect('EquiposController/listarNotificaciones');
		} else {
			$this->session->set_flashdata('error_eliminarNotificacion', true);
			redirect('EquiposController/listarNotificaciones');
		}
	}
}
