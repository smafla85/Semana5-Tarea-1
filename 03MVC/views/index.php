<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .content {
            display: none;
        }
        .content.active {
            display: block;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistema de Gestión</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-content="clientes">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-content="productos">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-content="proveedores">Proveedores</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div id="clientesContent" class="content active">
            <?php include 'clientes.php'; ?>
        </div>
        <div id="productosContent" class="content">
            <?php include 'productos.php'; ?>
        </div>
        <div id="proveedoresContent" class="content">
            <?php include 'proveedores.php'; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.navbar-nav .nav-link').on('click', function(e) {
                e.preventDefault();
                $('.navbar-nav .nav-link').removeClass('active');
                $(this).addClass('active');
                
                var target = $(this).data('content');
                $('.content').removeClass('active');
                $('#' + target + 'Content').addClass('active');
            });
        });
    </script>
</body>
</html>