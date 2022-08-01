  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="<?php echo RUTA_USER; ?>index.php">Blog PHP 8</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php if (isset($_SESSION['activo'])) : ?>
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Administración
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="<?php echo RUTA_ADMIN; ?>articulos.php">Artículos</a>
                </li>
                <li>
                  <a class="dropdown-item" href="<?php echo RUTA_ADMIN; ?>comentarios.php">Comentarios</a>
                </li>
                <li>
                  <a class="dropdown-item" href="<?php echo RUTA_ADMIN; ?>usuarios.php">Usuarios</a>
                </li>
              </ul>
            </li>
          </ul>
        <?php endif; ?>

        <ul class="navbar-nav mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo RUTA_USER; ?>index.php">Inicio</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?php echo RUTA_USER; ?>registro.php">Registrarse</a>
          </li>
          <?php if (empty($_SESSION['activo'])) : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo RUTA_USER; ?>acceder.php">Acceder</a>
          </li>
          <?php endif; ?>
          <?php if (!empty($_SESSION['activo'])) : ?>
            <li class="nav-item">
              <p class="text-white mt-2"><i class="bi bi-person-circle"></i> </p>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo RUTA_USER; ?>salir.php">Salir</a>
            </li>
          <?php endif; ?>

        </ul>
      </div>
    </div>
  </nav>