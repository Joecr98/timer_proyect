<?php
class EquiposModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function crearEquipo($equipo)
    {
        $this->db->insert('equipos', $equipo);
    }

    public function mostrarEquipos()
    {
        $this->db->select('*');
        $this->db->from('equipos');
        return $this->db->get()->result();
    }

    public function mostrarHistorial()
    {
        // Realiza la consulta JOIN para obtener los datos de la tabla equipos
        $this->db->select('historial.*, equipos.nombre AS nombreEquipo');
        $this->db->from('historial');
        $this->db->join('equipos', 'equipos.idEquipo = historial.idEquipoHistorial', 'left');
        return $this->db->get()->result();
    }


    // Función para obtener un equipo por ID
    public function obtenerEquipo($idEquipo)
    {
        $query = $this->db->get_where('equipos', array('idEquipo' => $idEquipo));
        return $query->row(); // Devuelve una sola fila
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

    public function iniciarHistorial($idEquipo, $inicioTiempo, $finalTiempo)
    {
        $data = array(
            'inicioEquipoHistorial' => $inicioTiempo,
            'finEquipoHistorial' => $finalTiempo,
            'idEquipoHistorial' => $idEquipo
        );

        // Intentar insertar el historial y manejar posibles errores
        if (!$this->db->insert('historial', $data)) {
            $error = $this->db->error(); // Obtener detalles del error
            throw new Exception('Error de base de datos: ' . $error['message']);
        }

        return $this->db->insert_id();
    }

    public function detenerHistorial($idHistorial, $finTiempo)
    {
        $data = array(
            'finEquipoHistorial' => $finTiempo
        );

        $this->db->where('idHistorial', $idHistorial);
        $this->db->update('historial', $data);
    }
}
