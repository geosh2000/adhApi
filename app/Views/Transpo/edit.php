<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container pb-5">
    <?php if (session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
            <span><?= session('success') ?></span>
            <a href="<?= site_url('transpo/reservation') ?>?<?= $_SERVER['QUERY_STRING'] ?>" class="btn btn-primary">Salir</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php elseif (session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between" role="alert">
            <span><?= session('error') ?></span>
            <a href="<?= site_url('transpo/reservation') ?>?<?= $_SERVER['QUERY_STRING'] ?>" class="btn btn-primary">Salir</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <div class="row justify-content-center">
        <div class="col-md-8">
        <?php if (strpos(current_url(), 'create') !== false): ?>
            <h2 class="text-center mt-4 mb-4">Nueva Reservación</h2>
        <?php else: ?>
            <h2 class="text-center mt-4 mb-4">Editar Transportación <?= $transpo ? $transpo['id'] : '' ?></h2>
        <?php endif; ?>
            

            <!-- Formulario de edición -->
            <form action="<?= site_url(strpos(current_url(), 'create') !== false ? 'transpo/store' : ('transpo/update/'.$transpo['id'])) ?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="shuttle">Shuttle:</label>
                            <input type="text" name="shuttle" id="shuttle" class="form-control" value="<?= $transpo ? $transpo['shuttle'] : 'QWANTOUR' ?>">
                        </div>
                        <div class="form-group">
                            <label for="hotel">Hotel:</label>
                            <select name="hotel" id="hotel" class="form-control">
                                <option value="ATELIER" <?= ($transpo && $transpo['hotel'] == 'ATELIER') ? 'selected' : '' ?>>ATELIER</option>
                                <option value="OLEO" <?= ($transpo && $transpo['hotel'] == 'OLEO') ? 'selected' : '' ?>>OLEO</option>
                                <!-- Agrega otras opciones de hotel aquí -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tipo">Tipo:</label>
                            <select name="tipo" id="tipo" class="form-control">
                                <option value="ENTRADA" <?= ($transpo && $transpo['tipo'] == 'ENTRADA') ? 'selected' : '' ?>>ENTRADA</option>
                                <option value="SALIDA" <?= ($transpo && $transpo['tipo'] == 'SALIDA') ? 'selected' : '' ?>>SALIDA</option>
                                <!-- Agrega otras opciones de tipo aquí -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="folio">Folio:</label>
                            <input type="text" name="folio" id="folio" class="form-control" value="<?= $transpo ? $transpo['folio'] : '' ?>" >
                        </div>
                        <div class="form-group">
                            <label for="date">Date:</label>
                            <input type="date" name="date" id="date" class="form-control" value="<?= $transpo ? $transpo['date'] : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pax">Pax:</label>
                            <input type="number" name="pax" id="pax" class="form-control" value="<?= $transpo ? $transpo['pax'] : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="guest">Guest:</label>
                            <input type="text" name="guest" id="guest" class="form-control" value="<?= $transpo ? $transpo['guest'] : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="time">Time:</label>
                            <input type="text" name="time" id="time" class="form-control" value="<?= $transpo ? $transpo['time'] : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="flight">Flight:</label>
                            <input type="text" name="flight" id="flight" class="form-control" value="<?= $transpo ? $transpo['flight'] : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="airline">Airline:</label>
                            <input type="text" name="airline" id="airline" class="form-control" value="<?= $transpo ? $transpo['airline'] : '' ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="pick_up">Pick-Up:</label>
                    <input type="text" name="pick_up" id="pick_up" class="form-control" value="<?= $transpo ? $transpo['pick_up'] : '' ?>">
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="PAGADA" <?= ($transpo && $transpo['status'] == 'PAGADA') ? 'selected' : '' ?>>PAGADA</option>
                        <option value="PAGO DESTINO" <?= ($transpo && $transpo['status'] == 'PAGO DESTINO') ? 'selected' : '' ?>>PAGO DESTINO</option>
                        <option value="INCLUIDA" <?= ($transpo && $transpo['status'] == 'INCLUIDA') ? 'selected' : '' ?>>INCLUIDA</option>
                        <option value="CORTESÍA" <?= ($transpo && $transpo['status'] == 'CORTESÍA') ? 'selected' : '' ?>>CORTESÍA</option>
                        <option value="PAGO PENDIENTE" <?= ($transpo && $transpo['status'] == 'PAGO PENDIENTE') ? 'selected' : '' ?>>PAGO PENDIENTE</option>
                        <option value="PAGO EN DESTINO" <?= ($transpo && $transpo['status'] == 'PAGO EN DESTINO') ? 'selected' : '' ?>>PAGO EN DESTINO</option>
                        <option value="CANCELADA" <?= ($transpo && $transpo['status'] == 'CANCELADA') ? 'selected' : '' ?>>CANCELADA</option>
                        <!-- Agrega otras opciones de status aquí -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="precio">Precio:</label>
                    <input type="text" name="precio" id="precio" class="form-control" value="<?= $transpo ? $transpo['precio'] : '' ?>">
                </div>
                <div class="form-group">
                    <label for="correo">Correo:</label>
                    <input type="email" name="correo" id="correo" class="form-control" value="<?= $transpo ? $transpo['correo'] : '' ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="<?= $transpo ? $transpo['phone'] : '' ?>">
                </div>
                <?php if (strpos(current_url(), 'create') !== false): ?>
                    <button type="submit" class="btn btn-primary btn-block">Guardar Reserva</button>
                <?php else: ?>
                    <button type="submit" class="btn btn-primary btn-block">Guardar Cambios</button>
                <?php endif; ?>
                <a href="<?= site_url('transpo/reservation') ?>?<?= $_SERVER['QUERY_STRING'] ?>" class="btn btn-danger btn-block mt-3">Cancelar</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

