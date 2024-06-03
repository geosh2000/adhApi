<?php

namespace App\Models\Transpo;

use CodeIgniter\Model;

class TransportacionesModel extends Model
{
    protected $DBGroup = 'production';
    protected $table = 'qwt_transportaciones';
    protected $primaryKey = 'id';
    protected $allowedFields = ['shuttle', 'hotel', 'tipo', 'folio', 'date', 'pax', 'guest', 'time', 'flight', 'airline', 'pick_up', 'status', 'precio', 'correo', 'phone'];

    public function getFilteredTransportaciones($inicio, $fin, $status, $hotel = null, $tipo = null, $guest = null, $correo = null, $folio = null)
    {
        $builder = $this->db->table('qwt_transportaciones');

        if (!empty($guest)) {
            $builder->like('guest', $guest);
        } elseif (!empty($folio)) {
            $builder->where('folio', $folio);
        } elseif (!empty($correo)) {
            $builder->like('correo', $correo);
        } else {

            $builder->where('date >=', $inicio);
            $builder->where('date <=', $fin);

            if (!empty($status)) {
                $builder->whereIn('status', $status);
            }

            if (!empty($hotel)) {
                $builder->whereIn('hotel', $hotel);
            }

            if (!empty($tipo)) {
                $builder->whereIn('tipo', $tipo);
            }

        }

        return $builder->get()->getResultArray();
    }
}
