<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container pb-5">
    <h2 class="text-center mt-4 mb-4">Confirmación de Eliminación</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p>¿Estás seguro de que deseas eliminar el siguiente registro?</p>
                    <ul>
                        <li><strong>ID:</strong> <?= $transpo['id'] ?></li>
                        <li><strong>Guest:</strong> <?= $transpo['guest'] ?></li>
                        <li><strong>Tipo:</strong> <?= $transpo['tipo'] ?></li>
                        <li><strong>Folio:</strong> <?= $transpo['folio'] ?></li>
                    </ul>
                    <div class="text-center">
                        <form action="<?= site_url('transpo/delete/'.$transpo['id']) ?>" method="post" class="d-inline">
                            <input type="hidden" name="_method" value="DELETE">    
                            <button type="submit" class="btn btn-danger">BORRAR</button>
                        </form>
                        <a href="<?= site_url('transpo/reservation').'?'.$_SERVER['QUERY_STRING'] ?>" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
