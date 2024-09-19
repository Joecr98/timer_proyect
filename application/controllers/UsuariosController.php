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
                    redirect('UsuariosController/listaUsuarios');
                } else {
                    $data['error'] = 'Hubo un problema al crear el usuario.';
                }
            }
        }
        $this->load->view('gestionUsuarios/crear_usuario', $data);
    }


    public function listaUsuarios()
    {
        if ($this->session->userdata('rol') !== 'administrador') {
            show_error('No tienes permisos para acceder a esta página.', 403);
        }
    
        $data['usuarios'] = $this->UsuariosModel->obtenerTodos();
        $this->load->view('gestionUsuarios/lista_usuario', $data);
    }
    
    public function editar($id)
    {
        // Verificar que sea administrador
        if ($this->session->userdata('rol') !== 'administrador') {
            show_error('No tienes permisos para editar usuarios.', 403);
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
                redirect('UsuariosController/listaUsuarios');
            }
        }
        $data['usuario'] = $usuario;
        $this->load->view('gestionUsuarios/editar_usuario', $data);
    }


    public function eliminar($id)
    {
        // Verificar que sea administrador
        if ($this->session->userdata('rol') !== 'administrador') {
            show_error('No tienes permisos para eliminar usuarios.', 403);
        }

        $this->UsuariosModel->eliminar($id);
        redirect('UsuariosController/listaUsuarios');
    }


    public function login()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Contraseña', 'required');
            
            if ($this->form_validation->run() === TRUE) {
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                
                // Obtener usuario por email
                $usuario = $this->UsuariosModel->obtenerPorEmail($email);
                
                // Verificar si el usuario existe
                if ($usuario) {
                    // Verificar la contraseña
                    if (password_verify($password, $usuario->password)) {
                        // Guardar información del usuario en la sesión
                        $this->session->set_userdata([
                            'idUsuario' => $usuario->idUsuario,
                            'nombre' => $usuario->nombre,
                            'rol' => $usuario->rol,
                            'is_logged_in' => TRUE
                        ]);
                        
                        // Redirigir al panel de equipos o página principal
                        redirect('equipos');
                    } else {
                        // Contraseña incorrecta
                        $this->session->set_flashdata('error', 'Credenciales inválidas.');
                    }
                } else {
                    // Usuario no encontrado
                    $this->session->set_flashdata('error', 'Credenciales inválidas.');
                }
            }
        }
        
        // Cargar vista de login
        $this->load->view('login');
    }
    


    public function logout()
    {
        // Destruir la sesión del usuario
        $this->session->sess_destroy();
        redirect('login');
    }
    
}