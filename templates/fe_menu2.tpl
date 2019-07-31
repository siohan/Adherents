
<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="{cms_action_url action=default display=default record_id=$username}">Bonjour {$prenom}</a>
 	{*$Retour*}
      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>
      
      <!-- Navbar Search -->
<!--
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
      -->
      <!-- Navbar -->
     <!-- <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <span class="badge badge-danger">9+</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-envelope fa-fw"></i>
            <span class="badge badge-danger">7</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#">Settings</a>
            <a class="dropdown-item" href="#">Activity Log</a>
            <div class="dropdown-divider"></div>-->
            <a class="dropdown-item" href="{cms_action_url module=FrontEndUsers action=logout}" data-toggle="modal" data-target="#logoutModal">Déconnexion</a>
          </div>
        </li>
      </ul>
 
    </nav>
 <div id="wrapper">

      <!-- Sidebar -->
	<ul class="sidebar navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="{cms_action_url action=default}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span>
          </a>
        </li>
        <!--<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <h6 class="dropdown-header">Login Screens:</h6>
            <a class="dropdown-item" href="login.html">Login</a>
            <a class="dropdown-item" href="register.html">Register</a>
            <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Other Pages:</h6>
            <a class="dropdown-item" href="404.html">404 Page</a>
            <a class="dropdown-item" href="blank.html">Blank Page</a>
          </div>
        </li>
-->{if $feu_fftt == 1}
        <li class="nav-item">
          <a class="nav-link" href="{cms_action_url action=fe_sportif record_id=$username}">
            <i class="fas fa-fw fa-table-tennis"></i>
            <span>Mes résultats officiels</span></a>
        </li>
		<li class="nav-item">
          <a class="nav-link" href="{cms_action_url action=fe_spid display=sportif record_id=$username}">
            <i class="fas fa-fw fa-chart-line"></i>
            <span>Mes points virtuels</span></a>
        </li>
		<li class="nav-item">
          <a class="nav-link" href="{cms_action_url action=fe_sit_mens record_id=$username}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Ma situation mensuelle</span></a>
        </li>
{/if}
{if $feu_commandes == 1}
		<li class="nav-item">
          <a class="nav-link" href="{cms_action_url action=fe_commandes display=infos record_id=$username}">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Mes commandes</span></a>
        </li>
{/if}
{if $feu_inscriptions ==1}
		<li class="nav-item">
          <a class="nav-link" href="{cms_action_url action=fe_inscriptions display=infos record_id=$username}">
            <i class="fas fa-fw fa-user-check"></i>
            <span>Mes inscriptions</span></a>
        </li>
{/if}
{if $feu_presences ==1}
		<li class="nav-item">
          <a class="nav-link" href="{cms_action_url action=fe_presences display=infos record_id=$username}">
            <i class="fas fa-fw fa-user-check"></i>
            <span>Mes présences</span></a>
        </li>
{/if}
{if $feu_compos ==1}
		<li class="nav-item">
          <a class="nav-link" href="{cms_action_url action=fe_compos display=infos record_id=$username}">
            <i class="fas fa-fw fa-user-friends"></i>
            <span>Mes convocations</span></a>
        </li>
{/if}
{if $feu_adhesions ==1}
        <li class="nav-item">
          <a class="nav-link" href="{cms_action_url action=fe_adhesions display=contacts record_id=$username}l">
            <i class="fas fa-fw fa-user-circle"></i>
            <span>Mes adhésions</span></a>
        </li>
{/if}
		<li class="nav-item">
          <a class="nav-link" href="{cms_action_url action=default display=infos record_id=$username}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Mes infos</span></a>
        </li>
{if $feu_contacts == 1}
        <li class="nav-item">
          <a class="nav-link" href="{cms_action_url action=fe_view_contacts display=contacts record_id=$username}l">
            <i class="fas fa-fw fa-user"></i>
            <span>Mes contacts</span></a>
        </li>
{/if}
      </ul>
	<div id="content-wrapper">

	        <div class="container-fluid">

	          <!-- Breadcrumbs-->
	          <ol class="breadcrumb">
	            <li class="breadcrumb-item">
	              <a href="#">Tableau de bord</a>
	            </li>
	            <li class="breadcrumb-item active">Vue générale</li>
	          </ol>

	          <!-- Icon Cards-->
			
	          <div class="row">
				{if $feu_messages == 1}
				<div class="col-xl-3 col-sm-6 mb-3">
	              <div class="card text-white bg-primary o-hidden h-100">
	                <div class="card-body">
	                  <div class="card-body-icon">
	                    <i class="fas fa-fw fa-envelope"></i>
	                  </div>
	                  <div class="mr-5">Mes Messages ({$nb_messages})</div>
	                </div>
	                <a class="card-footer text-white clearfix small z-1" href="{cms_action_url action=fe_messages  record_id=$username}">
	                  <span class="float-left">Détails</span>
	                  <span class="float-right">
	                    <i class="fas fa-angle-right"></i>
	                  </span>
	                </a>
	              </div>
	            </div>
	{/if}
	{if $feu_factures == 1}
	            <div class="col-xl-3 col-sm-6 mb-3">
	              <div class="card text-white bg-warning o-hidden h-100">
	                <div class="card-body">
	                  <div class="card-body-icon">
	                    <i class="fas fa-fw fa-euro-sign"></i>
	                  </div>
	                  <div class="mr-5">Mes factures</div>
	                </div>
	                <a class="card-footer text-white clearfix small z-1" href="{cms_action_url action=fe_paiements record_id=$username}">
	                  <span class="float-left">Détails</span>
	                  <span class="float-right">
	                    <i class="fas fa-angle-right"></i>
	                  </span>
	                </a>
	              </div>
	            </div>
	{/if}
	{if $feu_commandes == 1}
	            <div class="col-xl-3 col-sm-6 mb-3">
	              <div class="card text-white bg-success o-hidden h-100">
	                <div class="card-body">
	                  <div class="card-body-icon">
	                    <i class="fas fa-fw fa-shopping-cart"></i>
	                  </div>
	                  <div class="mr-5">{$nb_commandes} Commandes!</div>
	                </div>
	                <a class="card-footer text-white clearfix small z-1" href="{cms_action_url action=fe_commandes record_id=$username}">
	                  <span class="float-left">Détails</span>
	                  <span class="float-right">
	                    <i class="fas fa-angle-right"></i>
	                  </span>
	                </a>
	              </div>
	            </div>
{/if}
	<!--
	            <div class="col-xl-3 col-sm-6 mb-3">
	              <div class="card text-white bg-danger o-hidden h-100">
	                <div class="card-body">
	                  <div class="card-body-icon">
	                    <i class="fas fa-fw fa-life-ring"></i>
	                  </div>
	                  <div class="mr-5">13 New Tickets!</div>
	                </div>
	                <a class="card-footer text-white clearfix small z-1" href="#">
	                  <span class="float-left">Détails</span>
	                  <span class="float-right">
	                    <i class="fas fa-angle-right"></i>
	                  </span>
	                </a>
	              </div>
	            </div>
	-->
	          </div>
	