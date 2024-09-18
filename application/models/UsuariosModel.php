<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UsuariosModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtenerTodos()
    {
        return $this->db->get('usuarios')->result();
    }

    public function obtenerPorId($id)
    {
        return $this->db->get_where('usuarios', ['idUsuario' => $id])->row();
    }

    public function obtenerPorEmail($email)
{
    return $this->db->get_where('usuarios', ['email' => $email])->row();
}


    public function crear($datos)
    {
        $this->db->insert('usuarios', $datos);
        return $this->db->affected_rows() > 0;
    }

    public function actualizar($id, $datos)
    {
        $this->db->where('idUsuario', $id);
        return $this->db->update('usuarios', $datos);
    }

    public function eliminar($id)
    {
        $this->db->where('idUsuario', $id);
        return $this->db->delete('usuarios');
    }
}