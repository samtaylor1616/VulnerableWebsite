  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e6e6e6;">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item <?php echo $page == "Home" ? "active" : ""; ?>">
          <a class="nav-link" href="welcomePage.php">Home</a>
        </li>
        <li class="nav-item <?php echo $page == "Search" ? "active" : ""; ?>">
          <a class="nav-link" href="searchPage.php">Search</a>
        </li>
        <li class="nav-item <?php echo $page == "Settings" ? "active" : ""; ?>">
          <a class="nav-link" href="settings.php">Settings</a>
        </li>

      <!-- IF ADMIN FLAG IS SET -->
      <?php 
        if (isset($_SESSION['isAdmin'])) {
          $isAdminPage = $page === 'Admin' ? 'active' : '';
          echo '<li class="nav-item '.$isAdminPage.'">';
          echo '<a class="nav-link" href="admin.php">Admin Page</a>';
          echo '</li>';
        }
      ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="nav-item navRight">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- END NAVBAR -->