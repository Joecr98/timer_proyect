<?php
class EquiposModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function existeNombre($nombre)
    {
        $this->db->where('nombre', $nombre);
        $query = $this->db->get('equipos');
        return $query->num_rows() > 0;
    }

    public function crearEquipo($equipo)
    {
        // Verifica si el nombre ya existe
        if (!$this->existeNombre($equipo['nombre'])) {
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

    public function mostrarHistorial()
    {
        // Realiza la consulta JOIN para obtener los datos de la tabla equipos
        $this->db->select('historial.*, equipos.nombre AS nombreEquipo');
        $this->db->from('historial');
        $this->db->join('equipos', 'equipos.idEquipo = historial.idEquipoHistorial', 'left');
        return $this->db->get()->result();
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

    public function estacionConMasRegistros()
    {
        $this->db->select('e.nombre, COUNT(*) as cantidad');
        $this->db->from('historial h');
        $this->db->join('equipos e', 'e.idEquipo = h.idEquipoHistorial'); // Realiza la unión con la tabla equipos
        $this->db->group_by('e.nombre');
        $this->db->order_by('cantidad', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function estacionMenosUsada()
    {
        $this->db->select('e.nombre, COUNT(*) as cantidad');
        $this->db->from('historial h');
        $this->db->join('equipos e', 'e.idEquipo = h.idEquipoHistorial'); // Realiza la unión con la tabla equipos
        $this->db->group_by('e.nombre');
        $this->db->order_by('cantidad', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function existeNombreNotificacion($nombreNotificacion)
    {
        $this->db->where('nombreNotificacion', $nombreNotificacion);
        $query = $this->db->get('notificaciones');
        return $query->num_rows() > 0;
    }


    public function crearNotificacion($notificacion)
    {
        // Verifica si el nombre de la notificación ya existe
        if (!$this->existeNombreNotificacion($notificacion['nombreNotificacion'])) {
            $this->db->insert('notificaciones', $notificacion);
            return true; // Indica que se insertó correctamente
        }
        return false; // Indica que el nombre ya existe
    }

    public function obtenerNotificacionbyId($idNotificacion)
    {
        $query = $this->db->get_where('notificaciones', array('idNotificacion' => $idNotificacion));
        return $query->row(); // Devuelve una sola fila
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
