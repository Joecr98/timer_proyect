<?php
class NotificacionesModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function mostrarNotificaciones()
    {
        // Realiza la consulta JOIN para obtener los datos de la tabla equipos
        $this->db->select('notificaciones.*, equipos.nombre AS nombreEquipo');
        $this->db->from('notificaciones');
        $this->db->join('equipos', 'equipos.idEquipo = notificaciones.idEquipoNotificacion', 'left');
        return $this->db->get()->result();
    }

    public function obtenerNotificaciones()
    {
        $query = $this->db->get('notificaciones');
        return $query->result_array();
    }

    public function existeNombreNotificacion($nombreNotificacion)
    {
        $this->db->where('nombreNotificacion', $nombreNotificacion);
        $query = $this->db->get('notificaciones');
        return $query->num_rows() > 0;
    }


    public function crearNotificacion($notificacion)
    {
        if (!$this->existeNombreNotificacion($notificacion['nombreNotificacion'])) {
            $this->db->insert('notificaciones', $notificacion);
            return true; // Indica que se insertó correctamente
        }
        return false; // Indica que el nombre ya existe
    }

    public function obtenerNotificacionbyId($idNotificacion)
    {
        $query = $this->db->get_where('notificaciones', array('idNotificacion' => $idNotificacion));
        return $query->row();
    }

    public function editarNotificacion($notificacion, $idNotificacion)
    {
        $this->db->where('idNotificacion', $idNotificacion);
        $updated = $this->db->update('notificaciones', $notificacion);

        return $updated;
    }

    public function eliminarNotificacion($idNotificacion)
    {
        $this->db->where('idNotificacion', $idNotificacion);
        $deleted = $this->db->delete('notificaciones');

        return $deleted;
    }
}
