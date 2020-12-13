<div class="left-side-bar">
		<div class="brand-logo">
			<a href="#" @click="menu=1">
				<img src="imgs/logo_crystal_menu.png" alt="" class="dark-logo" style="width: 50% !important;">
				<img src="imgs/logo_crystal_menu.png" alt="" class="light-logo" style="width: 60% !important;">
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					<li @click="menu=1">
						<a href="#" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-house-1"></span><span class="mtext">Inicio</span>
						</a>
					</li>
                    <li @click="menu=2">
						<a href="#" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-money-1"></span><span class="mtext">Mis ahorros</span>
						</a>
					</li>
                    <li @click="menu=3">
						<a href="#" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-notebook"></span><span class="mtext">Reglas</span>
						</a>
					</li>					
				</ul>
				
			</div>
		</div>
    </div>