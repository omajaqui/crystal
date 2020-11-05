<?php
    $fotoPerfil = 'login-img.png';
    if (session('nombres') == 'omar') {$fotoPerfil = 'photo6.jpg';}
    if (session('nombres') == 'leidy Johana') {$fotoPerfil = 'profile-photo.jpg';}
?>
<div class="header">
    <div class="header-left">
        <div class="menu-icon dw dw-menu"></div>			
    </div>
    <div class="header-right">
        <div class="user-info-dropdown">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                    <span class="user-icon">
                        <img src="vendors/images/<?php echo $fotoPerfil; ?>" alt="">
                    </span>
                    <span class="user-name"><?php echo session('nombres').' '.session('apellidos');?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                    <a class="dropdown-item" href="profile.html"><i class="dw dw-user1"></i> Perfil</a>
                    <a class="dropdown-item" href="profile.html"><i class="dw dw-settings2"></i> Configuracion</a>
                    <a class="dropdown-item" href="faq.html"><i class="dw dw-help"></i> Ayuda</a>
                    <a class="dropdown-item" onclick="cerrarSesion()"><i class="dw dw-logout"></i> Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>