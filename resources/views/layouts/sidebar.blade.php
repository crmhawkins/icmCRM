<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="/dashboard"><img src="{{asset('assets/images/logo/logo.png')}}" alt="Logo" srcset="" class="img-fluid"></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{route('dashboard')}}" class='sidebar-link'>
                        <i class="bi bi-grid-fill fs-5"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{route('mostrarDiagramaGantt')}}" class='sidebar-link'>
                        <i class="bi bi-grid-fill fs-5"></i>
                        <span>Diagrama Gantt</span>
                    </a>
                    {{-- <a href="{{route('cola-de-trabajo.index')}}" class='sidebar-link'>
                        <i class="bi bi-grid-fill fs-5"></i>
                        <span>Cola de trabajo</span>
                    </a> --}}
                </li>
                <li class="sidebar-title">Empresa</li>

                @php
                    $clientesActive = request()->routeIs('clientes.index') || request()->routeIs('clientes.create') || request()->routeIs('clientes.show') || request()->routeIs('cliente.createFromBudget') || request()->routeIs('clientes.edit');
                    $presupuestoActive = request()->routeIs('presupuestos.index') || request()->routeIs('presupuesto.create') || request()->routeIs('presupuesto.show');
                    //$dominiosActive = request()->routeIs('dominios.index') || request()->routeIs('dominios.create') || request()->routeIs('dominios.edit');
                    $projectActive = request()->routeIs('campania.*') ;
                    $servicesActive = request()->routeIs('servicios.*') || request()->routeIs('serviciosCategoria.*');
                    $peticionesActive = request()->routeIs('peticion.*');
                    $personalActive = request()->routeIs('users.*') ;
                    $tareaActive = request()->routeIs('tareas.*') ;
                    $vacacionesActive = request()->routeIs('holiday.admin.*') ;
                    $nominasActive = request()->routeIs('nominas.*') ;
                    $contratosActive = request()->routeIs('contratos.*') ;
                    $poveedoresActive= request()->routeIs('proveedores.*');
                    $actasActive= request()->routeIs('reunion.*');
                    $cargoActive= request()->routeIs('cargo.*');
                    $departamentoActive= request()->routeIs('departamento.*');
                    $tesoreriaActive = request()->routeIs('ingreso.*')  || request()->routeIs('diarioCaja.*') || request()->routeIs('gasto.*') || request()->routeIs('gasto-asociado.*') || request()->routeIs('gasto-sin-clasificar.*') || request()->routeIs('gastos-asociado.*') || request()->routeIs('categorias-gastos*');
                    $cofiguracionActive = request()->routeIs('configuracion.*');
                    $EmailConfig = request()->routeIs('admin.categoriaEmail.*') || request()->routeIs('admin.statusMail.*');
                    $BajaActive = request()->routeIs('bajas.*');
                    $StadisticsActive = request()->routeIs('estadistica.*');
                    $ContabilidadActive = request()->routeIs('cuentasContables.*') || request()->routeIs('subCuentasContables.*') || request()->routeIs('subCuentasHijaContables.*') || request()->routeIs('grupoContabilidad.*') || request()->routeIs('subGrupoContabilidad.*') || request()->routeIs('admin.planContable.index');
                    $admin = (Auth::user()->access_level_id == 1);
                    $gerente = (Auth::user()->access_level_id == 2);
                    $contable = (Auth::user()->access_level_id == 3);
                    $gestor = (Auth::user()->access_level_id == 4);
                    $personal = (Auth::user()->access_level_id == 5);
                    $comercial = (Auth::user()->access_level_id == 6);
                    @endphp


                <li class="sidebar-item has-sub {{ $clientesActive ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="fa-solid fa-people-group fs-5"></i>
                        <span>Clientes</span>
                    </a>
                    <ul class="submenu" style="{{ $clientesActive ? 'display:block;' : 'display:none' }}">
                        <li class="submenu-item {{ request()->routeIs('clientes.index') ? 'active' : '' }} ">
                            <a href="{{route('clientes.index')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    Ver todos
                                </span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('clientes.create') ? 'active' : '' }} {{ request()->routeIs('cliente.createFromBudget') ? 'active' : ''}}">
                            <a href="{{route('clientes.create')}}">
                                <i class="fa-solid fa-plus"></i>
                                <span>
                                    Crear cliente
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub {{ $presupuestoActive ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="fa-solid fa-file-invoice-dollar fs-5"></i>

                        <span>Presupuestos</span>
                    </a>
                    <ul class="submenu" style="{{ $presupuestoActive ? 'display:block;' : 'display:none;' }}">
                        <li class="submenu-item {{ request()->routeIs('presupuestos.index') ? 'active' : '' }}">
                            <a href="{{route('presupuestos.index')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    Ver todos
                                </span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('presupuesto.create') ? 'active' : '' }}">
                            <a href="{{route('presupuesto.create')}}">
                                <i class="fa-solid fa-plus"></i>
                                <span>
                                    Crear presupuesto
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub {{ $peticionesActive ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="fa-solid fa-clipboard fs-5"></i>
                        <span>Peticiones</span>
                    </a>
                    <ul class="submenu" style="{{ $peticionesActive ? 'display:block;' : 'display:none;' }}">
                        <li class="submenu-item {{ request()->routeIs('peticion.index') ? 'active' : '' }}">
                            <a href="{{route('peticion.index')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    Ver todos
                                </span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('peticion.create') ? 'active' : '' }}">
                            <a href="{{route('peticion.create')}}">
                                <i class="fa-solid fa-plus"></i>
                                <span>
                                    Crear petición
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub {{ $projectActive ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="fa-solid fa-diagram-project fs-5"></i>
                        <span>Campañas</span>
                    </a>
                    <ul class="submenu" style="{{ $projectActive ? 'display:block;' : 'display:none;' }}">
                        <li class="submenu-item {{ request()->routeIs('campania.index') ? 'active' : '' }}">
                            <a href="{{route('campania.index')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    Ver todos
                                </span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('campania.create') ? 'active' : '' }}">
                            <a href="{{route('campania.create')}}">
                                <i class="fa-solid fa-plus"></i>
                                <span>
                                    Crear campaña
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub {{ $tareaActive ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="fa-solid fa-list-check fs-5"></i>
                        <span>Tareas</span>
                    </a>
                    <ul class="submenu" style="{{ $tareaActive ? 'display:block;' : 'display:none;' }}">
                        <li class="submenu-item {{ request()->routeIs('tareas.index') ? 'active' : '' }}">
                            <a href="{{route('tareas.index')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    Ver todos
                                </span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('tareas.asignar') ? 'active' : '' }}">
                            <a href="{{route('tareas.asignar')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    Por Asignar
                                </span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('tareas.cola') ? 'active' : '' }}">
                            <a href="{{route('tareas.cola')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    En Cola
                                </span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('tareas.revision') ? 'active' : '' }}">
                            <a href="{{route('tareas.revision')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    En Revisión
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub {{ $ContabilidadActive ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="fa-solid fa-calculator fs-5"></i>
                        <span>Contablilidad</span>
                    </a>
                    <ul class="submenu" style="{{ $ContabilidadActive ? 'display:block;' : 'display:none;' }}">
                        <li class="submenu-item {{ request()->routeIs('admin.planContable.index') ? 'active' : '' }}">
                            <a href="{{route('admin.planContable.index')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    Plan Contable
                                </span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('grupoContabilidad.index') ? 'active' : '' }}">
                            <a href="{{route('grupoContabilidad.index')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    Grupo Contable
                                </span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('subGrupoContabilidad.index') ? 'active' : '' }}">
                            <a href="{{route('subGrupoContabilidad.index')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    Subgrupo Contable
                                </span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('cuentasContables.index') ? 'active' : '' }}">
                            <a href="{{route('cuentasContables.index')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    Cuenta Contable
                                </span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('subCuentasContables.index') ? 'active' : '' }}">
                            <a href="{{route('subCuentasContables.index')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    Subcuenta Contable
                                </span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('subCuentasHijaContables.index') ? 'active' : '' }}">
                            <a href="{{route('subCuentasHijaContables.index')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    Subcuenta hija Contable
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="sidebar-item has-sub {{ $dominiosActive ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="fa-solid fa-globe fs-5"></i>
                        <span>Dominios</span>
                    </a>
                    <ul class="submenu" style="{{ $dominiosActive ? 'display:block;' : 'display:none;' }}">
                        <li class="submenu-item {{ request()->routeIs('dominios.index') ? 'active' : '' }}">
                            <a href="{{route('dominios.index')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    Ver todos
                                </span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('dominios.create') ? 'active' : '' }}">
                            <a href="{{route('dominios.create')}}">
                                <i class="fa-solid fa-plus"></i>
                                <span>
                                    Crear domino
                                </span>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                <li class="sidebar-item has-sub {{ $poveedoresActive ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="fa-solid fa-user-tie fs-5"></i>
                        <span>Proveedores</span>
                    </a>
                    <ul class="submenu" style="{{ $poveedoresActive ? 'display:block;' : 'display:none;' }}">
                        <li class="submenu-item {{ request()->routeIs('proveedores.index') ? 'active' : '' }}">
                            <a href="{{route('proveedores.index')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    Ver todos
                                </span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('proveedores.create') ? 'active' : '' }}">
                            <a href="{{route('proveedores.create')}}">
                                <i class="fa-solid fa-plus"></i>
                                <span>
                                    Crear nuevo
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub {{ $actasActive ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="fa-solid fa-address-book fs-5"></i>
                        <span>Actas de reunion</span>
                    </a>
                    <ul class="submenu" style="{{ $actasActive ? 'display:block;' : 'display:none;' }}">
                        <li class="submenu-item {{ request()->routeIs('reunion.index') ? 'active' : '' }}">
                            <a href="{{route('reunion.index')}}">
                                <i class="fa-solid fa-list"></i>
                                <span>
                                    Ver todos
                                </span>
                            </a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('reunion.create') ? 'active' : '' }}">
                            <a href="{{route('reunion.create')}}">
                                <i class="fa-solid fa-plus"></i>
                                <span>
                                    Crear nuevo
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>



                @if ($admin || $gerente || $contable)
                    <li class="sidebar-item {{ request()->routeIs('facturas.index') ? 'active' : '' }}">
                        <a href="{{route('facturas.index')}}" class='sidebar-link'>
                            <i class="fa-solid fa-file-invoice-dollar fs-5"></i>
                            <span>Facturas</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('order.indexAll') ? 'active' : '' }}">
                        <a href="{{route('order.indexAll')}}" class='sidebar-link'>
                            <i class="fa-solid fa-receipt"></i>
                            <span>Todas las ordenes</span>
                        </a>
                    </li>
                    <li class="sidebar-item has-sub {{ $tesoreriaActive ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="fa-solid fa-coins fs-5"></i>
                            <span>Tesorería</span>
                        </a>
                        <ul class="submenu" style="{{ $tesoreriaActive ? 'display:block;' : 'display:none;' }}">
                            <li class="submenu-item {{ request()->routeIs('ingreso.index') ? 'active' : '' }}">
                                <a href="{{route('ingreso.index')}}">
                                    <i class="fa-solid fa-list"></i>
                                    <span>
                                        Ver Ingresos
                                    </span>
                                </a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('ingreso.create') ? 'active' : '' }}">
                                <a href="{{route('ingreso.create')}}">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>
                                        Añadir Ingreso
                                    </span>
                                </a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('gasto.index') ? 'active' : '' }}">
                                <a href="{{route('gasto.index')}}">
                                    <i class="fa-solid fa-list"></i>
                                    <span>
                                        Ver Gastos
                                    </span>
                                </a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('gasto.create') ? 'active' : '' }}">
                                <a href="{{route('gasto.create')}}">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>
                                        Añadir Gasto
                                    </span>
                                </a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('gasto-asociados.index') ? 'active' : '' }}">
                                <a href="{{route('gasto-asociados.index')}}">
                                    <i class="fa-solid fa-list"></i>
                                    <span>
                                        Ver Gastos Asociados
                                    </span>
                                </a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('gasto-asociado.create') ? 'active' : '' }}">
                                <a href="{{route('gasto-asociado.create')}}">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>
                                        Añadir Gasto Asociado
                                    </span>
                                </a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('gasto-sin-clasificar.index') ? 'active' : '' }}">
                                <a href="{{route('gasto-sin-clasificar.index')}}">
                                    <i class="fa-solid fa-list"></i>
                                    <span>
                                        Ver Gastos Sin Clasificar
                                    </span>
                                </a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('admin.treasury.index') ? 'active' : '' }}">
                                <a target="_blank" href="{{route('admin.treasury.index')}}">
                                    <i class="fa-solid fa-list"></i>
                                    <span>
                                        Cuadro de Tesoreria
                                    </span>
                                </a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('categorias-gastos.index') ? 'active' : '' }}">
                                <a target="_blank" href="{{route('categorias-gastos.index')}}">
                                    <i class="fa-solid fa-list"></i>
                                    <span>
                                        Categorias de gastos
                                    </span>
                                </a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('categorias-gastos.create') ? 'active' : '' }}">
                                <a target="_blank" href="{{route('categorias-gastos.create')}}">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>
                                        Crear categoria de gastos
                                    </span>
                                </a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('categorias-gastos-asociados.index') ? 'active' : '' }}">
                                <a target="_blank" href="{{route('categorias-gastos-asociados.index')}}">
                                    <i class="fa-solid fa-list"></i>
                                    <span>
                                        Categorias de gastos asociados
                                    </span>
                                </a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('categorias-gastos-asociados.create') ? 'active' : '' }}">
                                <a target="_blank" href="{{route('categorias-gastos-asociados.create')}}">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>
                                       Crear categoria de gastos asociados
                                    </span>
                                </a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('diarioCaja.index') ? 'active' : '' }}">
                                <a target="_blank" href="{{route('diarioCaja.index')}}">
                                    <i class="fa-solid fa-list"></i>
                                    <span>
                                       Diario de caja
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item has-sub {{ $contratosActive ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="fa-solid fa-file-invoice fs-5"></i>
                                <span>Contratos</span>
                        </a>
                        <ul class="submenu" style="{{ $contratosActive ? 'display:block;' : 'display:none;' }}">
                            <li class="submenu-item {{ request()->routeIs('contratos.index') ? 'active' : '' }}">
                                <a href="{{route('contratos.index')}}">
                                    <i class="fa-solid fa-list"></i>
                                    <span>
                                        Ver todos
                                    </span>
                                </a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('contratos.create') ? 'active' : '' }}">
                                <a href="{{route('contratos.create')}}">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>
                                        Crear contrato
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item has-sub {{ $nominasActive ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="fa-solid fa-file-invoice-dollar fs-5"></i>
                            <span>Nominas</span>
                        </a>
                        <ul class="submenu" style="{{ $nominasActive ? 'display:block;' : 'display:none;' }}">
                            <li class="submenu-item {{ request()->routeIs('nominas.index') ? 'active' : '' }}">
                                <a href="{{route('nominas.index')}}">
                                    <i class="fa-solid fa-list"></i>
                                    <span>
                                        Ver todos
                                    </span>
                                </a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('nominas.create') ? 'active' : '' }}">
                                <a href="{{route('nominas.create')}}">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>
                                        Crear nomina
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item has-sub {{ $BajaActive ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="fa-solid fa-house-user"></i>
                            <span>Bajas</span>
                        </a>
                        <ul class="submenu" style="{{ $BajaActive ? 'display:block;' : 'display:none;' }}">
                            <li class="submenu-item {{ request()->routeIs('bajas.index') ? 'active' : '' }}">
                                <a href="{{route('bajas.index')}}">
                                    <i class="fa-solid fa-list"></i>
                                    <span>
                                        Ver todos
                                    </span>
                                </a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('bajas.create') ? 'active' : '' }}">
                                <a href="{{route('bajas.create')}}">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>
                                        Crear baja
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item has-sub {{ $vacacionesActive ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="fa-solid fa-umbrella-beach fs-5"></i>
                            <span>Vacaciones</span>
                        </a>
                        <ul class="submenu" style="{{ $vacacionesActive ? 'display:block;' : 'display:none;' }}">
                            <li class="submenu-item {{ request()->routeIs('holiday.admin.petitions') ? 'active' : '' }}">
                                <a href="{{route('holiday.admin.petitions')}}">
                                    <i class="fa-solid fa-list"></i>
                                    <span>
                                        Gestionar
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('productividad.index') ? 'active' : '' }}">
                        <a href="{{route('productividad.index')}}" class='sidebar-link'>
                            <i class="fa-solid fa-chart-column"></i>
                            <span>Productividad</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('horas.index') ? 'active' : '' }}">
                        <a href="{{route('horas.index')}}" class='sidebar-link'>
                            <i class="fa-regular fa-clock"></i>
                            <span>Jornadas</span>
                        </a>
                    </li>
                    <li class="sidebar-item has-sub {{ request()->routeIs('logs.*') ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="fa-solid fa-list"></i>
                            <span>Logs</span>
                        </a>
                        <ul class="submenu" style="{{ request()->routeIs('logs.*') ? 'display:block;' : 'display:none;' }}">
                            <li class="submenu-item {{ request()->routeIs('logs.index') ? 'active' : '' }}">
                                <a href="{{route('logs.index')}}">
                                    <i class="fa-solid fa-list"></i>
                                    <span>
                                        Ver Logs
                                    </span>
                                </a>
                            </li>
                            {{-- <li class="submenu-item {{ request()->routeIs('logs.clasificado') ? 'active' : '' }}">
                                <a href="{{route('logs.clasificado')}}">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>
                                        Ver Logs por usuario
                                    </span>
                                </a>
                            </li> --}}
                        </ul>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('estadistica.index') ? 'active' : '' }}">
                        <a href="{{route('estadistica.index')}}" class='sidebar-link'>
                            <i class="fa-solid fa-chart-line"></i>
                            <span>Estadisticas</span>
                        </a>
                    </li>
                    <li class="sidebar-item has-sub {{ request()->routeIs('iva.*') ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="fa-solid fa-list"></i>
                            <span>Tipos de iva</span>
                        </a>
                        <ul class="submenu" style="{{ request()->routeIs('iva.*') ? 'display:block;' : 'display:none;' }}">
                            <li class="submenu-item {{ request()->routeIs('iva.index') ? 'active' : '' }}">
                                <a href="{{route('iva.index')}}">
                                    <i class="fa-solid fa-list"></i>
                                    <span>
                                        Ver
                                    </span>
                                </a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('iva.create') ? 'active' : '' }}">
                                <a href="{{route('iva.create')}}">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>
                                        Crear tipo de iva
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if ($admin || $gerente )
                        <li class="sidebar-item has-sub {{ $servicesActive ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="fa-solid fa-sliders fs-5"></i>
                                <span>Servicios</span>
                            </a>
                            <ul class="submenu" style="{{ $servicesActive ? 'display:block;' : 'display:none;' }}">
                                <li class="submenu-item {{ request()->routeIs('servicios.index') ? 'active' : '' }}">
                                    <a href="{{route('servicios.index')}}">
                                        <i class="fa-solid fa-list"></i>
                                        <span>
                                            Ver todos
                                        </span>
                                    </a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('servicios.create') ? 'active' : '' }}">
                                    <a href="{{route('servicios.create')}}">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>
                                            Crear servicio
                                        </span>
                                    </a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('serviciosCategoria.index') ? 'active' : '' }}">
                                    <a href="{{route('serviciosCategoria.index')}}">
                                        <i class="fa-solid fa-list"></i>
                                        <span>
                                            Ver Categorias
                                        </span>
                                    </a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('serviciosCategoria.create') ? 'active' : '' }}">
                                    <a href="{{route('serviciosCategoria.create')}}">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>
                                            Crear categoria de servicio
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item has-sub {{ $departamentoActive ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="fa-solid fa-user-group fs-5"></i>
                                <span>Departamentos</span>
                            </a>
                            <ul class="submenu" style="{{ $departamentoActive ? 'display:block;' : 'display:none;' }}">
                                <li class="submenu-item {{ request()->routeIs('departamento.index') ? 'active' : '' }}">
                                    <a href="{{route('departamento.index')}}">
                                        <i class="fa-solid fa-list"></i>
                                        <span>
                                            Ver todos
                                        </span>
                                    </a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('departamento.create') ? 'active' : '' }}">
                                    <a href="{{route('departamento.create')}}">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>
                                            Crear departamento
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item has-sub {{ $cargoActive ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="fa-solid fa-user-group fs-5"></i>
                                <span>Cargos</span>
                            </a>
                            <ul class="submenu" style="{{ $cargoActive ? 'display:block;' : 'display:none;' }}">
                                <li class="submenu-item {{ request()->routeIs('cargo.index') ? 'active' : '' }}">
                                    <a href="{{route('cargo.index')}}">
                                        <i class="fa-solid fa-list"></i>
                                        <span>
                                            Ver todos
                                        </span>
                                    </a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('cargo.create') ? 'active' : '' }}">
                                    <a href="{{route('cargo.create')}}">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>
                                            Crear cargo
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item has-sub {{ $personalActive ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="fa-solid fa-user-group fs-5"></i>
                                <span>Personal</span>
                            </a>
                            <ul class="submenu" style="{{ $personalActive ? 'display:block;' : 'display:none;' }}">
                                <li class="submenu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                    <a href="{{route('users.index')}}">
                                        <i class="fa-solid fa-list"></i>
                                        <span>
                                            Ver todos
                                        </span>
                                    </a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                    <a href="{{route('users.create')}}">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>
                                            Crear usuario
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item has-sub {{ $cofiguracionActive ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="fa-solid fa-list"></i>
                                <span>Cofiguracion</span>
                            </a>
                            <ul class="submenu" style="{{ $cofiguracionActive ? 'display:block;' : 'display:none;' }}">
                                <li class="submenu-item {{ request()->routeIs('configuracion.index') ? 'active' : '' }}">
                                    <a href="{{route('configuracion.index')}}" class='sidebar-link'>
                                        <i class="fa-solid fa-gears fs-5"></i>
                                        <span>Cofiguracion Empresa</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- <li class="sidebar-item has-sub {{ $EmailConfig ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="fa-solid fa-sliders fs-5"></i>
                                <span>Configuración Email</span>
                            </a>
                            <ul class="submenu" style="{{ $EmailConfig ? 'display:block;' : 'display:none;' }}">
                                <li class="submenu-item {{ request()->routeIs('admin.statusMail.index') ? 'active' : '' }}">
                                    <a href="{{route('admin.statusMail.index')}}">
                                        <i class="fa-solid fa-list"></i>
                                        <span>
                                            Ver Estados
                                        </span>
                                    </a>
                                </li>

                                <li class="submenu-item {{ request()->routeIs('admin.statusMail.create') ? 'active' : '' }}">
                                    <a href="{{route('admin.statusMail.create')}}">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>
                                            Crear Estado
                                        </span>
                                    </a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('admin.categoriaEmail.index') ? 'active' : '' }}">
                                    <a href="{{route('admin.categoriaEmail.index')}}">
                                        <i class="fa-solid fa-list"></i>
                                        <span>
                                            Ver Categorias
                                        </span>
                                    </a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('admin.categoriaEmail.create') ? 'active' : '' }}">
                                    <a href="{{route('admin.categoriaEmail.create')}}">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>
                                            Crear Categoria
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                    @endif
                @endif
                <li class="sidebar-item {{ request()->routeIs('file-manager') ? 'active' : '' }}">
                    <a href="{{route('file-manager')}}" class='sidebar-link'>
                        <i class="fa-solid fa-folder-open"></i>
                        <span>Archivos</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('calendar.index') ? 'active' : '' }}">
                    <a href="{{route('calendar.index')}}" class='sidebar-link'>
                        <i class="fa-solid fa-calendar fs-5"></i>
                        <span>Calendario</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('backup.index') ? 'active' : '' }}">
                    <a href="{{route('backup.index')}}" class='sidebar-link'>
                        <i class="fa-solid fa-box-archive fs-5"></i>
                        <span>Backup</span>
                    </a>
                </li>

            </ul>
            <div class="sidebar-footer mt-3">
                <p>
                    <b>Clientes:</b> <br> {{App\Models\Clients\Client::all()->count()}} / ILIMITADO<br>
                    <b>Facturas:</b> <br> {{App\Models\Invoices\Invoice::all()->count()}} / ILIMITADO<br>
                    <b>Categorias:</b> <br> {{App\Models\Services\ServiceCategories::all()->count()}} / ILIMITADO<br>
                    <b>Servicos:</b> <br> {{App\Models\Services\Service::all()->count()}} / ILIMITADO<br>
                </p>

                <p>
                    <b>Versión de software:</b> <br> 5.0.1<br>
                    <b>Build:</b> <br> 3.0.1<br>
                    <b>Versión de la IU:</b> <br> 2.5
                </p>
            </div>
        </div>
        {{-- <button class="sidebar-toggler btn x"><i data-feather="x"></i></button> --}}
        <button type="button" class="btn btn-outline-secondary mt-1" data-bs-toggle="modal" data-bs-target="#textoModal">
            Ficha técnica
          </button>
        </div>
    </div>
    <div class="modal fade" id="textoModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Datasheet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe src="{{env('DATASHEET')}}" width="100%" height="600px" style="border: none;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
