<?php

namespace App\Controllers\Transpo;

use App\Models\Transpo\TransportacionesModel;
use App\Controllers\BaseController;

class TransportacionController extends BaseController
{

    public function index()
    {
        $model = new TransportacionesModel();

        // Procesar los filtros
        $inicio = $this->request->getVar('inicio') ?? date('Y-m-d');
        $fin = $this->request->getVar('fin') ?? date('Y-m-d', strtotime($inicio . ' +1 month')); // Fecha máxima
        $status_raw = $this->request->getVar('status'); // Todos menos cancelado
        $hotel_raw = $this->request->getVar('hotel');
        $tipo_raw = $this->request->getVar('tipo');
        $guest = $this->request->getVar('guest');
        $correo = $this->request->getVar('correo');
        $folio = $this->request->getVar('folio');

        // Convertir a array si es nulo o un solo valor
        $status = is_null($status_raw) ? [] : $status_raw;
        $hotel = is_null($hotel_raw) ? [] : $hotel_raw;
        $tipo = is_null($tipo_raw) ? [] : $tipo_raw;

        // Consulta de la base de datos con filtros
        $data['transpo'] = $model->getFilteredTransportaciones($inicio, $fin, $status, $hotel, $tipo, $guest, $correo, $folio);


        // Configuración de la paginación
        $pager = \Config\Services::pager();
        $page = (int)$this->request->getVar('page_table1') ?? 1;
        $perPage = 50;
        $model->paginate($perPage, 'table1', $page);

        // Pasar el objeto Pager a la vista
        $data['pager'] = $pager;

        // Definir valores predeterminados si no se proporcionan
        $data['inicio'] = $inicio;
        $data['fin'] = $fin;
        $data['status'] = $status;
        $data['hotel'] = $hotel;
        $data['tipo'] = $tipo;
        $data['guest'] = $guest;
        $data['correo'] = $correo;
        $data['folio'] = $folio;

        return view('transpo/index', $data);
    }

    public function create()
    {
        // Mostrar formulario de creación
        return view('transpo/edit', ['transpo' => []]);
    }

    public function store()
    {
        // Obtener los datos del formulario
        $data = [
            'shuttle' => $this->request->getPost('shuttle'),
            'hotel' => $this->request->getPost('hotel'),
            'tipo' => $this->request->getPost('tipo'),
            'folio' => $this->request->getPost('folio'),
            'date' => $this->request->getPost('date'),
            'pax' => $this->request->getPost('pax'),
            'guest' => $this->request->getPost('guest'),
            'time' => $this->request->getPost('time'),
            'flight' => $this->request->getPost('flight'),
            'airline' => $this->request->getPost('airline'),
            'pick_up' => $this->request->getPost('pick_up'),
            'status' => $this->request->getPost('status'),
            'precio' => $this->request->getPost('precio'),
            'correo' => $this->request->getPost('correo'),
            'phone' => $this->request->getPost('phone'),
        ];

        // Validar los campos del formulario si es necesario
        $validation = \Config\Services::validation();
        $validation->setRules([
            // Define las reglas de validación aquí, por ejemplo:
            'shuttle' => 'required',
            'hotel' => 'required',
            'tipo' => 'required',
            'folio' => 'required',
            'date' => 'required|valid_date',
            'pax' => 'required|integer',
            'guest' => 'required',
            'time' => 'required',
            'flight' => 'required',
            'airline' => 'required',
            'status' => 'required',
            'precio' => 'required|numeric',
            'correo' => 'required|valid_email',
        ]);

        if (!$validation->run($data)) {
            return redirect()->back()->withInput()->with('error', json_encode($validation->getErrors()));
        }

        // Guardar los datos en la base de datos
        $transpoModel = new TransportacionesModel();
        $transpoModel->insert($data);

        // Obtener el ID del registro recién creado
        $lastInsertId = $transpoModel->getInsertID();

        // Redirigir al formulario de edición del registro recién creado
        return redirect()->to(site_url('transpo/edit/' . $lastInsertId))->with('success', 'Nueva reserva '.$lastInsertId.' creada correctamente.');
    }


    public function edit($id)
    {
        $model = new TransportacionesModel();

        // Obtener los datos de la transportación
        $data['transpo'] = $model->find($id);

        // Cargar la vista de edición
        return view('transpo/edit', $data);
    }

    public function update($id)
    {

        $model = new TransportacionesModel();

        // // Validar los campos del formulario
        // $validationRules = [
        //     // Definir reglas de validación...
        // ];

        // if (!$this->validate($validationRules)) {
        //     // Si la validación falla, regresar a la página de edición con los errores
        //     return redirect()->back()->withInput()->with('error', json_encode($this->validator));
        // }

        // Obtener los datos del formulario
        $data = [
            'shuttle' => $this->request->getPost('shuttle'),
            'hotel' => $this->request->getPost('hotel'),
            'tipo' => $this->request->getPost('tipo'),
            'folio' => $this->request->getPost('folio'),
            'date' => $this->request->getPost('date'),
            'pax' => $this->request->getPost('pax'),
            'guest' => $this->request->getPost('guest'),
            'time' => $this->request->getPost('time'),
            'flight' => $this->request->getPost('flight'),
            'airline' => $this->request->getPost('airline'),
            'pick_up' => $this->request->getPost('pick_up'),
            'status' => $this->request->getPost('status'),
            'precio' => $this->request->getPost('precio'),
            'correo' => $this->request->getPost('correo'),
            'phone' => $this->request->getPost('phone'),
        ];

        // Actualizar los datos en la base de datos
        if ($model->update($id, $data)) {
            // Mostrar la página de edición con un modal de éxito
            $data['transpo'] = $model->find($id);
            $data['success_modal'] = true; // Marcar que se debe mostrar el modal de éxito
            return redirect()->back()->with('success', 'Cambios guardados correctamente.');
        } else {
            // Si hay un error, redirigir a la página de edición con un mensaje de error
            return redirect()->back()->with('error', 'Error al guardar los cambios.');
        }

    
    }

    // Método para mostrar la vista de confirmación de eliminación
    public function confirmDelete($id)
    {
        $transpoModel = new TransportacionesModel();
        $transpo = $transpoModel->find($id);

        if (!$transpo) {
            return redirect()->to(site_url('transpo/reservation'))->with('error', 'Registro no encontrado.');
        }

        return view('transpo/confirm_delete', ['transpo' => $transpo]);
    }

    public function delete($id)
    {
        $transpoModel = new TransportacionesModel();

        // Intentar eliminar el registro
        if ($transpoModel->delete($id)) {
            // Si la eliminación es exitosa, redirigir con un mensaje de éxito
            return redirect()->to(site_url('transpo/reservation').'?'.$_SERVER['QUERY_STRING'])
                ->with('success', 'Registro '.$id.' Borrado');
        } else {
            return redirect()->to(site_url('transpo/reservation').'?'.$_SERVER['QUERY_STRING'])
                ->with('error', 'Registro no encontrado.');
        }
    }
}
