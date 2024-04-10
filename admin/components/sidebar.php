<header class="app-header fixed-top">

  <div class="app-header-inner">
    <div class="container-fluid py-2">
      <div class="app-header-content">
        <div class="row justify-content-between align-items-center">

          <div class="col-auto">
            <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img">
                <title>Menu</title>
                <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
              </svg>
            </a>
          </div><!--//col-->


          <div class="app-utilities col-auto">
            <div class="app-utility-item m-2">
              <a href="<?= SERVER_NAME . "/backend/nodes?action=logout" ?>">
                <i class="fa-solid fa-power-off"></i>
              </a>
            </div>

          </div><!--//app-utilities-->
        </div><!--//row-->
      </div><!--//app-header-content-->
    </div><!--//container-fluid-->
  </div><!--//app-header-inner-->

  <div id="app-sidepanel" class="app-sidepanel">
    <div id="sidepanel-drop" class="sidepanel-drop"></div>
    <div class="sidepanel-inner d-flex flex-column">
      <a href="javascript:void(0)" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
      <div class="app-branding">
        <a class="app-logo" href="index.html">
          <!-- <img class="logo-icon me-2" src="assets/images/app-logo.svg" alt="logo"> -->
          <span class="logo-text">EarnEdge</span>
        </a>

      </div><!--//app-branding-->

      <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
        <ul class="app-menu list-unstyled accordion" id="menu-accordion">
          <?php
          $get_sidebar_data = $helpers->get_sidebar_data($LOGIN_USER->role);

          foreach ($get_sidebar_data as $menu) :
            $menu = (object)$menu;
            $config = (object)$menu->config;

          ?>
            <li class="nav-item">
              <a class="nav-link <?= $helpers->is_active_menu($config->url, $_SERVER["PHP_SELF"]) ?>" href="<?= $config->url ?>">
                <span class="nav-icon">
                  <i class="<?= $config->icon ?>"></i>
                </span>
                <span class="nav-link-text">
                  <?= $menu->title ?>
                </span>
              </a><!--//nav-link-->
            </li><!--//nav-item-->
           
          <?php endforeach; ?>


        </ul><!--//app-menu-->
      </nav><!--//app-nav-->


    </div><!--//sidepanel-inner-->
  </div><!--//app-sidepanel-->

</header><!--//app-header-->