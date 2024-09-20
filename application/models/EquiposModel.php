<?php
class EquiposModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function existeNombreEquipo($nombre)
    {
        $this->db->where('nombre', $nombre);
        $query = $this->db->get('equipos');
        return $query->num_rows() > 0;
    }

    public function crearEquipo($equipo)
    {
        // Verifica si el nombre ya existe
        if (!$this->existeNombreEquipo($equipo['nombre'])) {
            $this->db->insert('equipos', $equipo);
            return true; // Indica que se insertó correctamente
        }
        return false; // Indica que el nombre ya existe
    }


    public function mostrarEquipos()
    {
        $this->db->select('*');
        $this->db->from('equipos');
        $this->db->where('estado', '1');
        return $this->db->get()->result();
    }

    public function mostrarEquiposInactivos()
    {
        $this->db->select('*');
        $this->db->from('equipos');
        $this->db->where('estado', '0');
        return $this->db->get()->result();
    }

    public function obtenerEquipobyId($idEquipo)
    {
        $query = $this->db->get_where('equipos', array('idEquipo' => $idEquipo));
        return $query->row();
    }

    public function eliminarEquipo($idEquipo)
    {
        $this->db->where('idEquipo', $idEquipo);
        $this->db->delete('equipos');
    }

    public function editarEquipo($equipo, $idEquipo)
    {
        $this->db->where('idEquipo', $idEquipo);
        $this->db->update('equipos', $equipo);
    }
}
