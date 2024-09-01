<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid mt-3">
        <h2>Gestión de Productos</h2>
        
        <div class="row">
            <!-- Formulario para agregar/editar producto -->
            <div class="col-md-4 mb-3">
                <form id="productoForm" class="p-3 border rounded">
                    <input type="hidden" id="idProductos" name="idProductos">
                    <div class="mb-2">
                        <label for="Codigo_Barras" class="form-label">Código de Barras</label>
                        <input type="text" class="form-control form-control-sm" id="Codigo_Barras" name="Codigo_Barras" required>
                    </div>
                    <div class="mb-2">
                        <label for="Nombre_Producto" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control form-control-sm" id="Nombre_Producto" name="Nombre_Producto" required>
                    </div>
                    <div class="mb-2">
                        <label for="Graba_IVA" class="form-label">Graba IVA</label>
                        <select class="form-select form-select-sm" id="Graba_IVA" name="Graba_IVA" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar Producto</button>
                </form>
            </div>

            <!-- Tabla de productos -->
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Código de Barras</th>
                                <th>Nombre del Producto</th>
                                <th>Graba IVA</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="productosTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Cargar productos al iniciar
            cargarProductos();

            // Manejar envío del formulario
            $('#productoForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var idProductos = $('#idProductos').val();
                var url = idProductos ? '../controllers/productos.controller.php?op=actualizar' : '../controllers/productos.controller.php?op=insertar';

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert(idProductos ? 'Producto actualizado' : 'Producto agregado');
                        cargarProductos();
                        $('#productoForm')[0].reset();
                        $('#idProductos').val('');
                    },
                    error: function() {
                        alert('Error en la operación');
                    }
                });
            });

            // Función para cargar productos
            function cargarProductos() {
                $.ajax({
                    url: '../controllers/productos.controller.php?op=todos',
                    type: 'GET',
                    success: function(response) {
                        var productos = JSON.parse(response);
                        var tbody = $('#productosTableBody');
                        tbody.empty();
                        productos.forEach(function(producto) {
                            tbody.append(`
                                <tr>
                                    <td>${producto.idProductos}</td>
                                    <td>${producto.Codigo_Barras}</td>
                                    <td>${producto.Nombre_Producto}</td>
                                    <td>${producto.Graba_IVA == 1 ? 'Sí' : 'No'}</td>
                                    <td>
                                        <button onclick="editarProducto(${producto.idProductos})" class="btn btn-sm btn-warning">Editar</button>
                                        <button onclick="eliminarProducto(${producto.idProductos})" class="btn btn-sm btn-danger">Eliminar</button>
                                    </td>
                                </tr>
                            `);
                        });
                    }
                });
            }

            // Función para editar producto
            window.editarProducto = function(id) {
                $.ajax({
                    url: '../controllers/productos.controller.php?op=uno',
                    type: 'POST',
                    data: { idProductos: id },
                    success: function(response) {
                        var producto = JSON.parse(response);
                        $('#idProductos').val(producto.idProductos);
                        $('#Codigo_Barras').val(producto.Codigo_Barras);
                        $('#Nombre_Producto').val(producto.Nombre_Producto);
                        $('#Graba_IVA').val(producto.Graba_IVA);
                    }
                });
            }

            // Función para eliminar producto
            window.eliminarProducto = function(id) {
                if (confirm('¿Está seguro de eliminar este producto?')) {
                    $.ajax({
                        url: '../controllers/productos.controller.php?op=eliminar',
                        type: 'POST',
                        data: { idProductos: id },
                        success: function(response) {
                            alert('Producto eliminado');
                            cargarProductos();
                        }
                    });
                }
            }
        });
    </script>
</body>
</html>