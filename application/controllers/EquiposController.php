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
		$this->load->library('session'); // Carga la librería de sesión
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
		$this->EquiposModel->crearEquipo($equipo);
		$this->session->set_flashdata('equipo_creado', true);
		redirect('EquiposController/crearEstacion');
	}

	public function actualizarEstacion($idEquipo)
	{
		$datoEquipo['equipo'] = $this->EquiposModel->obtenerEquipo($idEquipo);
		$this->load->view('actualizarEstacion', $datoEquipo);
	}

	public function eliminarEquipo($idEquipo)
	{
		$this->EquiposModel->eliminarEquipo($idEquipo);
		redirect('EquiposController/listarEstaciones');
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

	public function listarEstaciones()
	{
		$datosEquipos['equipos'] = $this->EquiposModel->mostrarEquipos();
		$this->load->view('listaEstaciones', $datosEquipos);
	}

	public function listarHistorial()
	{
		$datosHistoriales['historiales'] = $this->EquiposModel->mostrarHistorial();
		$this->load->view('historial', $datosHistoriales);
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
}
