<?php require_once "config/conexion.php";
require_once "config/config.php";

if (!empty($_SESSION['active'])) {
    if ($_SESSION['perfil'] == "cliente") {
        header('Location: ../carrito.php');
    } else {
        header('Location: productos.php');
    }
    //header('location: productos.php');
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Carrito de Compras</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" /> -->
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/estilos.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="./">PharmaPlus</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </div>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Carrito</h1>
                <p class="lead fw-normal text-white-50 mb-0">Tus Productos Seleccionados</p>
            </div>
        </div>
    </header>
    <br>
    <div class="container px-4 px-lg-5">
        <!-- <div class="container px-4 px-lg-5">
            <div class="row">
                
            </div>
        </div> -->
        <div class="row">
            <div class="col-md-4">
                <form>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">1. DETALLES DE FACTURACIÓN</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="email" class="form-label">E-Mail *</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección 1 *</label>
                                <input type="text" class="form-control" id="direccion" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono *</label>
                                <input type="tel" class="form-control" id="telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="nit" class="form-label">NIT *</label>
                                <input type="text" class="form-control" id="nit" value="Consumidor Final" required>
                            </div>

                        </div>
                    </div>


                </form>
            </div>


            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">2. ENVÍO</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="envio" id="envio1" value="departamentos">
                            <label class="form-check-label" for="envio1">
                                Envío a departametos (Cargo Q 45.00)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="envio" id="envio2" value="tienda" checked>
                            <label class="form-check-label" for="envio2">
                                Recoger en Tienda
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">3. PAGO</h5>
                    </div>
                    <div class="card-body">
                        <form id="paymentForm" method="post" enctype="multipart/form-data">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pago" id="pagoEfectivo" value="efectivo" checked>
                                <label class="form-check-label" for="pagoEfectivo">
                                    Pago Efectivo
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pago" id="pagoDeposito" value="deposito">
                                <label class="form-check-label" for="pagoDeposito">
                                    Depósito Bancario Cuentas Monetarias Banrural: 3419003734 G&T: 03-0011551-3 Industrial: 039-007098-5 BAC: 90-165864-1 Interbanco: 81-0130161-5
                                </label>
                            </div>

                            <div id="boletaContainer" class="mb-3" style="display: none;">
                                <label for="boleta" class="form-label">Cargar Boleta (Obligatorio)</label>
                                <input class="form-control" type="file" id="boleta" name="boleta" required>
                                <div class="invalid-feedback">
                                    La carga de la boleta es obligatoria.
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var pagoEfectivo = document.getElementById('pagoEfectivo');
                        var pagoDeposito = document.getElementById('pagoDeposito');
                        var boletaContainer = document.getElementById('boletaContainer');

                        function toggleBoletaContainer() {
                            if (pagoDeposito.checked) {
                                boletaContainer.style.display = 'block';
                            } else {
                                boletaContainer.style.display = 'none';
                            }
                        }

                        toggleBoletaContainer();

                        pagoEfectivo.addEventListener('change', toggleBoletaContainer);
                        pagoDeposito.addEventListener('change', toggleBoletaContainer);
                    });
                </script>


                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">4. CUPÓN DESCUENTO</h5>
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Ingrese su código de cupón">
                            <button class="btn btn-outline-secondary" type="button">Guardar</button>
                        </div>
                    </div>
                </div>
                

            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">5. CARRO DE COMPRA</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblCarrito">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-5 ms-auto">
                            <h4>Total a Pagar: <span id="total_pagar">0.00</span></h4>
                            <div class="d-grid gap-2">
                                <div id="paypal-button-container"></div>
                                <button class="btn btn-warning" type="button" id="btnVaciar">Vaciar Carrito</button>
                                <button class="btn btn-info" type="button" id="btnAgregar">Seguir comprando</button>
                                <button class="btn btn-success" type="button" id="btnPagar">Pagar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">6. CONFIRMAR COMPRA</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="notas" class="form-label">Notas y solicitudes especiales</label>
                            <textarea class="form-control" id="notas" rows="3"></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terminos">
                            <label class="form-check-label" for="terminos">Pinche aquí para leer los términos de servicio y marque la casilla para aceptarlos.</label>
                        </div>
                        <div class="mb-3">
                            <label for="telefono-confirmacion" class="form-label">Teléfono *</label>
                            <input type="tel" class="form-control" id="telefono-confirmacion" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Confirmar Compra</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; AS 2024, UMG XELA</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&locale=<?php echo LOCALE; ?>"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
        //     document.getElementById('btnAgregar').addEventListener('click', function() {
        //     window.location.href = '../card';
        // });
        // document.addEventListener('DOMContentLoaded', function() {
        // Llamada a la función mostrarCarrito cuando la página haya cargado
        mostrarCarrito();

        // Configuración del botón para redirigir a la URL deseada
        var btnAgregar = document.getElementById('btnAgregar');
        if (btnAgregar) {
            btnAgregar.addEventListener('click', function() {
                window.location.href = '../card/';
            });
        }
        // });



        function mostrarCarrito() {
            if (localStorage.getItem("productos") != null) {
                let array = JSON.parse(localStorage.getItem('productos'));
                if (array.length > 0) {
                    $.ajax({
                        url: 'ajax.php',
                        type: 'POST',
                        async: true,
                        data: {
                            action: 'buscar',
                            data: array
                        },
                        success: function(response) {
                            console.log(response);
                            const res = JSON.parse(response);
                            let html = '';
                            res.datos.forEach(element => {
                                html += `
                            <tr>
                                <td>${element.id}</td>
                                <td>${element.nombre}</td>
                                <td>${element.precio}</td>
                                <td>1</td>
                                <td>${element.precio}</td>
                            </tr>
                            `;
                            });
                            $('#tblCarrito').html(html);
                            $('#total_pagar').text(res.total);
                            paypal.Buttons({
                                style: {
                                    color: 'blue',
                                    shape: 'pill',
                                    label: 'pay'
                                },
                                createOrder: function(data, actions) {
                                    // This function sets up the details of the transaction, including the amount and line item details.
                                    return actions.order.create({
                                        purchase_units: [{
                                            amount: {
                                                value: res.total
                                            }
                                        }]
                                    });
                                },
                                onApprove: function(data, actions) {
                                    // This function captures the funds from the transaction.
                                    return actions.order.capture().then(function(details) {
                                        // This function shows a transaction success message to your buyer.
                                        alert('Transaction completed by ' + details.payer.name.given_name);
                                    });
                                }
                            }).render('#paypal-button-container');
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            }
        }
    </script>
</body>

</html>