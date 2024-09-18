<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UsuariosController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UsuariosModel');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index()
    {
        // Verificar si el usuario tiene permisos de administrador
        if (!$this->session->userdata('administrador')) {
            redirect('login');
        }

        $data['usuarios'] = $this->UsuariosModel->obtenerTodos();
        $this->load->view('usuarios/lista', $data);
    }

    public function crearUsuario()
    {
        $data = array();

        if ($this->input->post()) {
            $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
            $this->form_validation->set_rules('apellido', 'Apellido', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[usuarios.email]');
            $this->form_validation->set_rules('password', 'Contraseña', 'required|min_length[8]');
            $this->form_validation->set_rules('rol', 'Rol', 'required|in_list[administrador,operador]');

            if ($this->form_validation->run() === TRUE) {
                $datos = array(
                    'nombre' => $this->input->post('nombre'),
                    'apellido' => $this->input->post('apellido'),
                    'email' => $this->input->post('email'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'rol' => $this->input->post('rol')
                );

                if ($this->UsuariosModel->crear($datos)) {
                    $this->session->set_flashdata('success', 'Usuario creado exitosamente.');
                    redirect('UsuariosController/listarUsuarios');
                } else {
                    $data['error'] = 'Hubo un problema al crear el usuario.';
                }
            }
        }

        $this->load->view('crear_usuario', $data);
    }

    public function listarUsuarios()
    {
        $data['usuarios'] = $this->UsuariosModel->obtenerTodos();
        $this->load->view('lista_usuarios', $data);
    }

    public function editar($id)
    {
        if (!$this->session->userdata('is_admin')) {
            redirect('login');
        }

        $usuario = $this->UsuariosModel->obtenerPorId($id);

        if ($this->input->post()) {
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('apellido', 'Apellido', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('rol', 'Rol', 'required|in_list[administrador,operador]');

            if ($this->form_validation->run() === TRUE) {
                $datos = [
                    'nombre' => $this->input->post('nombre'),
                    'apellido' => $this->input->post('apellido'),
                    'email' => $this->input->post('email'),
                    'rol' => $this->input->post('rol')
                ];

                $this->UsuariosModel->actualizar($id, $datos);
                redirect('usuarios');
            }
        }

        $data['usuario'] = $usuario;
        $this->load->view('usuarios/editar', $data);
    }

    public function eliminar($id)
    {
        if (!$this->session->userdata('is_admin')) {
            redirect('login');
        }

        $this->UsuariosModel->eliminar($id);
        redirect('usuarios');
    }

    public function login()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Contraseña', 'required');

            if ($this->form_validation->run() === TRUE) {
                $email = $this->input->post('email');
                $password = $this->input->post('password');

                $usuario = $this->UsuariosModel->obtenerPorEmail($email);

                if ($usuario && password_verify($password, $usuario->password)) {
                    // Configuramos los datos de la sesión
                    $session_data = array(
                        'idUsuario' => $usuario->idUsuario,
                        'nombre' => $usuario->nombre,
                        'email' => $usuario->email,
                        'rol' => $usuario->rol,
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata($session_data);

                    // Redireccionar según el rol del usuario
                    redirect('equipos');
                } else {
                    $this->session->set_flashdata('error', 'Credenciales inválidas');
                }
            }
        }

        $this->load->view('login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}