<?php
require_once "../config/conexion.php";

// Manejo de la solicitud de inserción y edición
if (isset($_POST) && !empty($_POST)) {
    $metodo = $_POST['metodo'];

    // Si hay un id presente, se realiza la edición
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        $query = mysqli_query($conexion, "UPDATE metodos_pago SET metodo = '$metodo' WHERE id = '$id'");
    } else {
        // Inserción de un nuevo método
        $query = mysqli_query($conexion, "INSERT INTO metodos_pago(metodo) VALUES ('$metodo')");
    }

    if ($query) {
        header('Location: metodos_pago.php');
    }
}

include("includes/header.php");
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Métodos de Pago</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="abrirMetodo"><i class="fas fa-plus fa-sm text-white-50"></i> Nuevo</a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conexion, "SELECT * FROM metodos_pago ORDER BY id DESC");
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo $data['metodo']; ?></td>
                            <td>
                                <!-- Botón para editar -->
                                <a href="#" class="btn btn-warning btn-sm editar" data-id="<?php echo $data['id']; ?>" data-metodo="<?php echo $data['metodo']; ?>">✏️</a>

                                <!-- Formulario para eliminar -->
                                <form action="eliminar.php" method="POST" class="d-inline eliminar-form">
                                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm eliminar-btn">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="metodos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="title">Nuevo Método de Pago</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" autocomplete="off">
                    <!-- Campo oculto para almacenar el ID cuando se edita -->
                    <input type="hidden" id="id_metodo" name="id">
                    
                    <div class="form-group">
                        <label for="metodo">Nombre</label>
                        <input id="metodo" class="form-control" type="text" name="metodo" placeholder="Método de Pago" required>
                    </div>
                    <button class="btn btn-primary" type="submit">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Capturar datos para edición
    document.querySelectorAll('.editar').forEach(boton => {
        boton.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const metodo = this.getAttribute('data-metodo');
            
            document.getElementById('id_metodo').value = id;
            document.getElementById('metodo').value = metodo;

            document.getElementById('title').innerText = 'Editar Método de Pago';
            $('#metodos').modal('show');
        });
    });

    // Reiniciar el formulario cuando se abre para un nuevo registro
    document.getElementById('abrirMetodo').addEventListener('click', function () {
        document.getElementById('id_metodo').value = '';
        document.getElementById('metodo').value = '';
        document.getElementById('title').innerText = 'Nuevo Método de Pago';
        $('#metodos').modal('show');
    });

    // Confirmación antes de eliminar
    document.querySelectorAll('.eliminar-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevenir el envío del formulario
            
            if (confirm('¿Está seguro de que desea eliminar este método de pago?')) {
                this.submit(); // Si confirma, se envía el formulario
            }
        });
    });
</script>

<?php include("includes/footer.php"); ?>
