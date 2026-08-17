<?php
    if (!empty($_SESSION['lang'])) {
        $sessionLang = $_SESSION['lang'];
        require_once ('assets/lang/'.$sessionLang.'.php');
    } else {
        require_once ('assets/lang/en.php');
    }
?>
 <header id="page-topbar">
     <div class="navbar-header">
         <div class="d-flex">
             <!-- LOGO -->
             <div class="navbar-brand-box">
                 <a href="index.php" class="logo logo-dark">
                     <span class="logo-sm">
                         <img src="assets/images/logo-sm.svg" alt="" height="30">
                     </span>
                     <span class="logo-lg">
                         <img src="assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">Rahat Villas</span>
                     </span>
                 </a>

                 <a href="index.php" class="logo logo-light">
                     <span class="logo-sm">
                         <img src="assets/images/logo-sm.svg" alt="" height="30">
                     </span>
                     <span class="logo-lg">
                         <img src="assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">Rahat Villas</span>
                     </span>
                 </a>
             </div>

             <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                 <i class="fa fa-fw fa-bars"></i>
             </button>

             <!-- App Search-->
             <!-- <form class="app-search d-none d-lg-block">
                 <div class="position-relative">
                     <input type="search" class="form-control" placeholder="Search...">
                     <button class="btn btn-primary" type="button"><i class="bx bx-search-alt align-middle"></i></button>
                 </div>
             </form> -->
         </div>

         <div class="d-flex">

             <div class="dropdown d-inline-block d-lg-none ms-2">
                 <button type="button" class="btn header-item" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i data-feather="search" class="icon-lg"></i>
                 </button>
                 <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">

                     <form class="p-3">
                         <div class="form-group m-0">
                             <div class="input-group">
                                 <input type="text" class="form-control" placeholder="Search ..." aria-label="Search Result">

                                 <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                             </div>
                         </div>
                     </form>
                 </div>
             </div>

             <div class="dropdown d-inline-block language-switch">
                 <button type="button" class="btn header-item" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <?php
                        if (!empty($_SESSION['lang'])) {
                            $lang = $_SESSION['lang'];
                            if ($lang == "en") {
                                $imgPath = 'assets/images/flags/us.jpg';
                            } elseif ($lang == "es") {
                                $imgPath = 'assets/images/flags/spain.jpg';
                            } elseif ($lang == "de") {
                                $imgPath = 'assets/images/flags/germany.jpg';
                            } elseif ($lang == "it") {
                                $imgPath = 'assets/images/flags/italy.jpg';
                            } elseif ($lang == "ru") {
                                $imgPath = 'assets/images/flags/russia.jpg';
                            } else {
                                $imgPath = 'assets/images/flags/us.jpg';
                            }
                        } else {
                            $imgPath = 'assets/images/flags/us.jpg';
                        }
                    ?>
                    <img class="header-lang-img" src="<?php echo $imgPath; ?>" alt="Header Language" height="16">
                 </button>
                 <div class="dropdown-menu dropdown-menu-end">

                     <!-- item-->
                     <a href="?lang=en" class="dropdown-item notify-item language" data-lang="eng">
                         <img src="assets/images/flags/us.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">English</span>
                     </a>
                 </div>
             </div>

             <div class="dropdown d-none d-sm-inline-block">
                 <button type="button" class="btn header-item" id="mode-setting-btn">
                     <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                     <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                 </button>
             </div>


             <!-- <div class="dropdown d-inline-block">
                 <button type="button" class="btn header-item right-bar-toggle me-2">
                     <i data-feather="settings" class="icon-lg"></i>
                 </button>
             </div> -->
            
             <div class="dropdown d-inline-block">
                 <button type="button" class="btn header-item bg-light-subtle border-start border-end" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img class="rounded-circle header-profile-user user-profile-image" src="assets/images/users/user.png" alt="Header Avatar" id="user_image">
                     <span class="d-none d-xl-inline-block ms-1 fw-medium setting_user_name" id="setting_user_name">User</span>
                     <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                 </button>
                 <div class="dropdown-menu dropdown-menu-end">
                     <a class="dropdown-item" href="logout.php"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
                 </div>
             </div>

         </div>
     </div>
 </header>