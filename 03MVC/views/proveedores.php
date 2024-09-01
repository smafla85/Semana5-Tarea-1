<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Proveedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid mt-3">
        <h2>Gestión de Proveedores</h2>
        
        <div class="row">
            <!-- Formulario para agregar/editar proveedor -->
            <div class="col-md-4 mb-3">
                <form id="proveedorForm" class="p-3 border rounded">
                    <input type="hidden" id="idProveedores" name="idProveedores">
                    <div class="mb-2">
                        <label for="Nombre_Empresa" class="form-label">Nombre de la Empresa</label>
                        <input type="text" class="form-control form-control-sm" id="Nombre_Empresa" name="Nombre_Empresa" required>
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
                        <label for="Contacto_Empresa" class="form-label">Contacto de la Empresa</label>
                        <input type="text" class="form-control form-control-sm" id="Contacto_Empresa" name="Contacto_Empresa" required>
                    </div>
                    <div class="mb-2">
                        <label for="Teleofno_Contacto" class="form-label">Teléfono de Contacto</label>
                        <input type="tel" class="form-control form-control-sm" id="Teleofno_Contacto" name="Teleofno_Contacto" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar Proveedor</button>
                </form>
            </div>

            <!-- Tabla de proveedores -->
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre Empresa</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Contacto Empresa</th>
                                <th>Teléfono Contacto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="proveedoresTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Cargar proveedores al iniciar
            cargarProveedores();

            // Manejar envío del formulario
            $('#proveedorForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var idProveedores = $('#idProveedores').val();
                var url = idProveedores ? '../controllers/proveedores.controller.php?op=actualizar' : '../controllers/proveedores.controller.php?op=insertar';

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert(idProveedores ? 'Proveedor actualizado' : 'Proveedor agregado');
                        cargarProveedores();
                        $('#proveedorForm')[0].reset();
                        $('#idProveedores').val('');
                    },
                    error: function() {
                        alert('Error en la operación');
                    }
                });
            });

            // Función para cargar proveedores
            function cargarProveedores() {
                $.ajax({
                    url: '../controllers/proveedores.controller.php?op=todos',
                    type: 'GET',
                    success: function(response) {
                        var proveedores = JSON.parse(response);
                        var tbody = $('#proveedoresTableBody');
                        tbody.empty();
                        proveedores.forEach(function(proveedor) {
                            tbody.append(`
                                <tr>
                                    <td>${proveedor.idProveedores}</td>
                                    <td>${proveedor.Nombre_Empresa}</td>
                                    <td>${proveedor.Direccion}</td>
                                    <td>${proveedor.Telefono}</td>
                                    <td>${proveedor.Contacto_Empresa}</td>
                                    <td>${proveedor.Teleofno_Contacto}</td>
                                    <td>
                                        <button onclick="editarProveedor(${proveedor.idProveedores})" class="btn btn-sm btn-warning">Editar</button>
                                        <button onclick="eliminarProveedor(${proveedor.idProveedores})" class="btn btn-sm btn-danger">Eliminar</button>
                                    </td>
                                </tr>
                            `);
                        });
                    }
                });
            }

            // Función para editar proveedor
            window.editarProveedor = function(id) {
                $.ajax({
                    url: '../controllers/proveedores.controller.php?op=uno',
                    type: 'POST',
                    data: { idProveedores: id },
                    success: function(response) {
                        var proveedor = JSON.parse(response);
                        $('#idProveedores').val(proveedor.idProveedores);
                        $('#Nombre_Empresa').val(proveedor.Nombre_Empresa);
                        $('#Direccion').val(proveedor.Direccion);
                        $('#Telefono').val(proveedor.Telefono);
                        $('#Contacto_Empresa').val(proveedor.Contacto_Empresa);
                        $('#Teleofno_Contacto').val(proveedor.Teleofno_Contacto);
                    }
                });
            }

            // Función para eliminar proveedor
            window.eliminarProveedor = function(id) {
                if (confirm('¿Está seguro de eliminar este proveedor?')) {
                    $.ajax({
                        url: '../controllers/proveedores.controller.php?op=eliminar',
                        type: 'POST',
                        data: { idProveedores: id },
                        success: function(response) {
                            alert('Proveedor eliminado');
                            cargarProveedores();
                        }
                    });
                }
            }
        });
    </script>
</body>
</html>