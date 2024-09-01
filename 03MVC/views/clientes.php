<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid mt-3">
        <h2>Gestión de Clientes</h2>
        
        <div class="row">
            <!-- Formulario para agregar/editar cliente -->
            <div class="col-md-4 mb-3">
                <form id="clienteForm" class="p-3 border rounded">
                    <input type="hidden" id="idClientes" name="idClientes">
                    <div class="mb-2">
                        <label for="Nombres" class="form-label">Nombres</label>
                        <input type="text" class="form-control form-control-sm" id="Nombres" name="Nombres" required>
                    </div>
                    <div class="mb-2">
                        <label for="Direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control form-control-sm" id="Direccion" name="Direccion" required>
                    </div>
                    <div class="mb-2">
                        <label for="Telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control form-control-sm" id="Telefono" name="Telefono" required>
                    </div>
                    <div class="mb-2">
                        <label for="Cedula" class="form-label">Cédula</label>
                        <input type="text" class="form-control form-control-sm" id="Cedula" name="Cedula" required>
                    </div>
                    <div class="mb-2">
                        <label for="Correo" class="form-label">Correo</label>
                        <input type="email" class="form-control form-control-sm" id="Correo" name="Correo" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar Cliente</button>
                </form>
            </div>

            <!-- Tabla de clientes -->
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombres</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Cédula</th>
                                <th>Correo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="clientesTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Cargar clientes al iniciar
            cargarClientes();

            // Manejar envío del formulario
            $('#clienteForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var idClientes = $('#idClientes').val();
                var url = idClientes ? '../controllers/clientes.controller.php?op=actualizar' : '../controllers/clientes.controller.php?op=insertar';

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert(idClientes ? 'Cliente actualizado' : 'Cliente agregado');
                        cargarClientes();
                        $('#clienteForm')[0].reset();
                        $('#idClientes').val('');
                    },
                    error: function() {
                        alert('Error en la operación');
                    }
                });
            });

            // Función para cargar clientes
            function cargarClientes() {
                $.ajax({
                    url: '../controllers/clientes.controller.php?op=todos',
                    type: 'GET',
                    success: function(response) {
                        var clientes = JSON.parse(response);
                        var tbody = $('#clientesTableBody');
                        tbody.empty();
                        clientes.forEach(function(cliente) {
                            tbody.append(`
                                <tr>
                                    <td>${cliente.idClientes}</td>
                                    <td>${cliente.Nombres}</td>
                                    <td>${cliente.Direccion}</td>
                                    <td>${cliente.Telefono}</td>
                                    <td>${cliente.Cedula}</td>
                                    <td>${cliente.Correo}</td>
                                    <td>
                                        <button onclick="editarCliente(${cliente.idClientes})" class="btn btn-sm btn-warning">Editar</button>
                                        <button onclick="eliminarCliente(${cliente.idClientes})" class="btn btn-sm btn-danger">Eliminar</button>
                                    </td>
                                </tr>
                            `);
                        });
                    }
                });
            }

            // Función para editar cliente
            window.editarCliente = function(id) {
                $.ajax({
                    url: '../controllers/clientes.controller.php?op=uno',
                    type: 'POST',
                    data: { idClientes: id },
                    success: function(response) {
                        var cliente = JSON.parse(response);
                        $('#idClientes').val(cliente.idClientes);
                        $('#Nombres').val(cliente.Nombres);
                        $('#Direccion').val(cliente.Direccion);
                        $('#Telefono').val(cliente.Telefono);
                        $('#Cedula').val(cliente.Cedula);
                        $('#Correo').val(cliente.Correo);
                    }
                });
            }

            // Función para eliminar cliente
            window.eliminarCliente = function(id) {
                if (confirm('¿Está seguro de eliminar este cliente?')) {
                    $.ajax({
                        url: '../controllers/clientes.controller.php?op=eliminar',
                        type: 'POST',
                        data: { idClientes: id },
                        success: function(response) {
                            alert('Cliente eliminado');
                            cargarClientes();
                        }
                    });
                }
            }
        });
    </script>
</body>
</html>