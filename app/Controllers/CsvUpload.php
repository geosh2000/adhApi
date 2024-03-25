<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CsvUpload extends Controller
{
    public function upload()
    {
        helper(['form', 'url']);

        // Cargar el modelo
        $llamadasModel = new \App\Models\LlamadasModel();

        // Procesar el archivo CSV
        if ($this->request->getMethod() === 'post' && $this->validate(['csv_file' => 'uploaded[csv_file]|max_size[csv_file,1024]'])) {
            $csv = $this->request->getFile('csv_file');

            // Leer el archivo CSV
            $csvData = array_map('str_getcsv', file($csv->getTempName()));

            // Insertar datos en la base de datos
            foreach ($csvData as $row) {
                $llamadasModel->insert([
                    'Fecha' => date('Y-m-d', strtotime($row[0])), // Suponiendo que la fecha está en la primera columna
                    'Hora' => date('H:i:s', strtotime($row[1])), // Suponiendo que la hora está en la segunda columna
                    'Queue' => $row[2], // Ajusta los índices según la estructura de tu CSV
                    'Agent' => $row[3],
                    'Number' => $row[4],
                    'Event' => $row[5],
                    'WaitTime' => $row[6],
                    'TalkTime' => $row[7],
                    'uniqueid' => $row[8]
                ]);
            }

            // Redirigir a la página de inicio o mostrar un mensaje de éxito
            return redirect()->to('/');
        } else {
            // Mostrar la vista de carga del archivo
            return view('upload_csv');
        }
    }
}
