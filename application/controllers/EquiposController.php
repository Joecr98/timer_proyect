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
}
