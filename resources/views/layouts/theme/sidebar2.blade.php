		<!-- Sidebar -->
		<div class="sidebar sidebar-style-2">
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="{{ asset('storage/usuarios/' . auth()->user()->imagen) }}" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									{{ auth()->user()->name }}
									<span class="user-level">{{ auth()->user()->profile }}</span>
									<span class="caret"></span>
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								<ul class="nav">
									<li>
										<a href="#profile">
											<span class="link-collapse">Mi Perfil</span>
										</a>
									</li>
									<li>
										<a href="#edit">
											<span class="link-collapse">Editar Perfil</span>
										</a>
									</li>
									<li>
										<a href="#settings">
											<span class="link-collapse">Ajustes</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<ul class="nav nav-primary">

						<li class="nav-item active">
							<a data-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false" style="background-color: #ee761c!important;">
								<i class="fas icon-chart"></i>
								<p>Level</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="dashboard">
								<ul class="nav nav-collapse">
									<li>
										<a href="">
											<span class="sub-item">Level</span>
										</a>
									</li>
									<li>
										<a href="">
											<span class="sub-item">Level</span>
										</a>
									</li>
									<li>
										<a href="">
											<span class="sub-item">Level</span>
										</a>
									</li>
									@can('Reporte_Movimientos_General')
									<li>
										<a href="">
											<i class="fa fas fa-minus"></i>
											Level</a>
									</li>
									@endcan
									@can('Reporte_Movimientos_General')
									<li>
										<a href="">
											<i class="fa fas fa-minus"></i>
											Level</a>
									</li>
									@endcan
									@can('Reporte_Movimientos_General')
									<li>
										<a href="">
											<i class="fa fas fa-minus"></i>
											Level</a>
									</li>
									@endcan
								</ul>
							</div>
						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Level</h4>
						</li>

						<li class="nav-item">
							<a data-toggle="collapse" href="#tables">
								<img src="assets/img/administracion.png" width="25" height="35" alt="navbar brand" class="navbar-brand">
								<p>Administración</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="tables">
								<ul class="nav nav-collapse">
									@can('Roles_Index')
									<li>
										<a href="{{ url('roles') }}">
											<i class="fa fas fa-minus"></i>
											Roles </a>
									</li>
									@endcan
									<li>
										<a href="{{ url('areaspermissions') }}">
											<i class="fa fas fa-minus"></i>
											Areas De Permisos </a>
									</li>
									@can('Permission_Index')
										<li>
											<a href="{{ url('permisos') }}">
												<i class="fa fas fa-minus"></i>
												Permisos </a>
										</li>
									@endcan
									@can('Asignar_Index')
										<li>
											<a href="{{ url('asignar') }}">
												<i class="fa fas fa-minus"></i>
												Asignar permisos </a>
										</li>
									@endcan
									@can('Usuarios_Index')
										<li>
											<a href="{{ url('users') }}">
												<i class="fa fas fa-minus"></i>
												Usuarios </a>
										</li>
									@endcan
									@can('Empresa_Index')
										<li>
											<a href="{{ url('companies') }}">
												<i class="fa fas fa-minus"></i>
												Empresa </a>
										</li>
									@endcan
									@can('Sucursal_Index')
										<li>
											<a href="{{ url('sucursales') }}">
												<i class="fa fas fa-minus"></i>
												Sucursales </a>
										</li>
									@endcan
									@can('Sucursal_Index')
										<li>
											<a href="{{ url('areas_de_trabajos') }}">
												<i class="fa fas fa-minus"></i>
												Areas de Trabajo</a>
										</li>
									@endcan
									@can('Sucursal_Index')
										<li>
											<a href="{{ url('function_areas') }}">
												<i class="fa fas fa-minus"></i>
												Funciones</a>
										</li>
									@endcan
									@can('Sucursal_Index')
										<li>
											<a href="{{ url('employees') }}">
												<i class="fa fas fa-minus"></i>
												Empleados</a>
										</li>
									@endcan
									@can('Sucursal_Index')
										<li>
											<a href="{{ url('puesto_trabajos') }}">
												<i class="fa fas fa-minus"></i>
												Puestos de Trabajo</a>
										</li>
									@endcan
									<li>
										<a href="{{ url('attendance') }}">
											<i class="fa fas fa-minus"></i>
											Horario </a>
									</li>
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#base">
								<i class="fas fa-layer-group"></i>
								<p>Level</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="base">
								<ul class="nav nav-collapse">
									<li>
										<a href="">
											<i class="fa fas fa-minus"></i>
											Level</a>
									  </li>
								</ul>
								<ul class="nav nav-collapse">
									<li>
										<a href="">
											<i class="fa fas fa-minus"></i>
											Level</a>
									  </li>
								  @can('Arqueos_Tigo_Index')
									  <li>
										<a href="">
											<i class="fa fas fa-minus"></i>
											Level</a>
									  </li>
								  @endcan

								  @can('Reportes_Tigo_Index')
									  <li>
										<a href="">
											<i class="fa fas fa-minus"></i>
											Level</a>
									  </li>
								  @endcan
								  @can('Reportes_Tigo_Index')
								  <li>
									<a href="">
										<i class="fa fas fa-minus"></i>
										Level</a>
								  </li>
								  @endcan
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#sidebarLayouts">
								<i class="fas fa-layer-group"></i>
								<p>Level</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarLayouts">
								<ul class="nav nav-collapse">
									@can('Cuentas_Index')
										<li>
											<a href="">
												<i class="fa fas fa-minus"></i>
												Level </a>
										</li>
									@endcan
									@can('Perfiles_Index')
										<li>
											<a href="">
												<i class="fa fas fa-minus"></i>
												Level </a>
										</li>
									@endcan
								</ul>
								<ul class="nav nav-collapse">
									@can('Planes_Index')
										<li>
											<a href="">
												<i class="fa fas fa-minus"></i>
												Level </a>
										</li>
									@endcan
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#forms">
								<i class="fas fa-layer-group"></i>
								<p>Level</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="forms">
								<ul class="nav nav-collapse">
								@can('Cat_Prod_Service_Index')
								<li>
									<a href="">
										<i class="fa fas fa-minus"></i>
										Level </a>
								</li>
								@endcan
								</ul>
							</div>
						</li>






						<li class="nav-item">
							<a data-toggle="collapse" href="#charts">
								<i class="fas fa-layer-group"></i>
								<p>Level</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="charts">
								<ul class="nav nav-collapse">
									<li>
										<a href="">
											<i class="fa fas fa-minus"></i>
											Level </a>
									</li>
								</ul>
							</div>
						</li>





						<li class="nav-item">
							<a data-toggle="collapse" href="#submenu">
								<i class="fas fa-layer-group"></i>
								<p>Level</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="submenu">
								<ul class="nav nav-collapse">

									<li>
										<a href="">
											<i class="fa fas fa-minus"></i>
											Level </a>
									</li>
									<li>
										<a data-toggle="collapse" href="#subnav2">
											<span class="sub-item">Level 1</span>
											<span class="caret"></span>
										</a>
										<div class="collapse" id="subnav2">
											<ul class="nav nav-collapse subnav">
												<li>
													<a href="#">
														<span class="sub-item">Level 2</span>
													</a>
												</li>
											</ul>
										</div>
									</li>
									<li>
										<a href="#">
											<span class="sub-item">Level 1</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="mx-4 mt-2">
								<a style="background-color: #ee761c!important;" class="btn btn-primary btn-block" href="{{ route('logout') }}"
									onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
									<span class="btn-label mr-2">
										<i class="fa icon-logout"></i>
									   </span>Cerrar Sesión
								</a>
								<form action="{{ route('logout') }}" method="POST" id="logout-form">
								@csrf
								</form>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->
