<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    /* Estilos para los enlaces de paginación */

.pagination {
    margin-top: 20px; /* Espacio entre la tabla y la paginación */
    text-align: center; /* Centrar los enlaces de paginación */
}

.pagination li {
    display: inline-block;
    margin-right: 5px; /* Espacio entre los enlaces */
}

.pagination a {
    padding: 5px 10px;
    background-color: transparent;
    color: #007bff; /* Color de los enlaces */
    text-decoration: none;
    border: 1px solid #007bff; /* Borde de los enlaces */
    border-radius: 3px; /* Borde redondeado */
    transition: background-color 0.3s, color 0.3s; /* Transición suave */
}

.pagination a:hover {
    background-color: #007bff; /* Cambio de color al pasar el ratón */
    color: #fff; /* Cambio de color al pasar el ratón */
}

.pagination .active a {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
    pointer-events: none; /* Desactivar el enlace activo */
}


</style>
<div class="container-fluid px-5">
    <div class="container">
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
                <span><?= session('success') ?></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php elseif (session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between" role="alert">
                <span><?= session('error') ?></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <h2 class="text-center mt-4 mb-4">Transportaciones</h2>
    
        <!-- Formulario de filtro -->
        <div class="d-flex justify-content-between mb-3">
            <form action="<?= site_url('transpo/reservation') ?>" method="get" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <label for="inicio">Fecha de inicio:</label>
                        <input type="date" name="inicio" id="inicio" class="form-control" value="<?= $inicio ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="fin">Fecha de fin:</label>
                        <input type="date" name="fin" id="fin" class="form-control" value="<?= $fin ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="status">Status:</label>
                        <select name="status[]" id="status" class="form-control" multiple>
                            <option value="cortesia" <?= in_array('cortesia', $status) ? 'selected' : '' ?>>Cortesia</option>
                            <option value="incluida" <?= in_array('incluida', $status) ? 'selected' : '' ?>>Incluida</option>
                            <option value="pagada" <?= in_array('pagada', $status) ? 'selected' : '' ?>>Pagada</option>
                            <option value="pago destino" <?= in_array('pago destino', $status) ? 'selected' : '' ?>>Pago Destino</option>
                            <option value="pago pendiente" <?= in_array('pago pendiente', $status) ? 'selected' : '' ?>>Pago Pendiente</option>
                            <option value="cancelada" <?= in_array('cancelada', $status) ? 'selected' : '' ?>>Cancelada</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="hotel">Hotel:</label>
                        <select name="hotel[]" id="hotel" class="form-control" multiple>
                            <option value="ATELIER" <?= in_array('ATELIER', $hotel) ? 'selected' : '' ?>>ATELIER</option>
                            <option value="OLEO" <?= in_array('OLEO', $hotel) ? 'selected' : '' ?>>OLEO</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="tipo">Tipo:</label>
                        <select name="tipo[]" id="tipo" class="form-control" multiple>
                            <option value="ENTRADA" <?= in_array('ENTRADA', $tipo) ? 'selected' : '' ?>>ENTRADA</option>
                            <option value="SALIDA" <?= in_array('SALIDA', $tipo) ? 'selected' : '' ?>>SALIDA</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="guest">Guest:</label>
                        <input type="text" name="guest" id="guest" class="form-control" value="<?= $guest ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="correo">Correo:</label>
                        <input type="email" name="correo" id="correo" class="form-control" value="<?= $correo ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="folio">Folio:</label>
                        <input type="text" name="folio" id="folio" class="form-control" value="<?= $folio ?>">
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary mr-2">Filtrar</button>
                    <a href="<?= site_url('transpo/create') ?>" class="btn btn-success">Crear</a>
                </div>
            </form>
        </div>
    </div>



    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Hotel</th>
                    <th>Folio</th>
                    <th>Tipo</th>
                    <th>Date</th>
                    <th>Pax</th>
                    <th>Guest</th>
                    <th>Correo</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transpo as $transportacion): ?>
                <tr>
                    <td><?= $transportacion['id'] ?></td>
                    <td><?= $transportacion['hotel'] ?></td>
                    <td><?= $transportacion['folio'] ?></td>
                    <td><?= $transportacion['tipo'] ?></td>
                    <td><?= $transportacion['date'] ?></td>
                    <td><?= $transportacion['pax'] ?></td>
                    <td><?= $transportacion['guest'] ?></td>
                    <td><?= $transportacion['correo'] ?></td>
                    <td><?= $transportacion['status'] ?></td>
                    <td>
                        <a href="<?= site_url('transpo/edit/'.$transportacion['id']) ?>?<?= $_SERVER['QUERY_STRING'] ?>" class="btn btn-info"><i class="fas fa-edit"></i></a>
                        <a href="<?= site_url('transpo/confirmDelete/'.$transportacion['id']).'?'.$_SERVER['QUERY_STRING'] ?>" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <?= $pager->links('table1', 'default_full') ?>
</div>

<?= $this->endSection() ?>
