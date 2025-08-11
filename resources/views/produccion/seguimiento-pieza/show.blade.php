@extends('layouts.content-fluid')

@section('title', 'Seguimiento de Pieza - ' . $pieza->codigo_pieza)

<style>
    .header-naranja {
        background-color: #ea761c !important;
        color: white !important;
    }

    .header-gris {
        background-color: #5B5B5B !important;
        color: white !important;
    }

    .btn-naranja {
        background-color: #ea761c !important;
        border-color: #ea761c !important;
        color: white !important;
    }

    .btn-naranja:hover {
        background-color: #d66815 !important;
        border-color: #d66815 !important;
        color: white !important;
    }

    .btn-gris {
        background-color: #5B5B5B !important;
        border-color: #5B5B5B !important;
        color: white !important;
    }

    .btn-gris:hover {
        background-color: #4a4a4a !important;
        border-color: #4a4a4a !important;
        color: white !important;
    }

    .table-header-small {
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        white-space: nowrap !important;
        padding: 0.5rem 0.25rem !important;
    }

    .table-input-small {
        font-size: 0.75rem !important;
        height: 1.5rem !important;
        padding: 0.125rem 0.25rem !important;
        min-width: 60px !important;
        max-width: 80px !important;
    }

    .table-select-small {
        font-size: 0.75rem !important;
        height: 1.5rem !important;
        padding: 0.125rem 0.25rem !important;
        min-width: 80px !important;
        max-width: 120px !important;
    }

    .table-cell-small {
        font-size: 0.75rem !important;
        padding: 0.25rem 0.25rem !important;
        vertical-align: middle !important;
        white-space: nowrap !important;
    }

    .table-cell-small br {
        display: none !important;
    }

        /* Optimizar columnas para el layout de ancho completo */
    .col-lg-8 {
        flex: 0 0 75% !important;
        max-width: 75% !important;
    }

    .col-lg-4 {
        flex: 0 0 25% !important;
        max-width: 25% !important;
    }

    /* Añadir más espacio superior */
    .mt-5 {
        margin-top: 3rem !important;
    }

    /* Ajustar espaciado del header */
    .card-header {
        padding: 1rem 1.5rem !important;
    }

    /* Asegurar que los botones de eliminar sean visibles */
    .btn-danger {
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* Estilos para el sistema de categorías de servicios */
    .servicio-select-container {
        position: relative;
    }
    .servicio-select-container select {
        width: 100%;
    }

    .btn-danger i {
        display: inline-block !important;
        visibility: visible !important;
    }

    /* Asegurar que las celdas de acción tengan el ancho correcto */
    .text-center {
        text-align: center !important;
        min-width: 50px !important;
    }
</style>

@section('content')
<div class="container-fluid">
    <!-- Header con información de la pieza -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header header-naranja">
                    <h4 class="mb-0">
                        <i class="mdi mdi-cube-outline me-2"></i>
                        Seguimiento de Pieza: {{ $pieza->codigo_pieza }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>REFERENCIA ICM:</strong> {{ $pieza->codigo_pieza }}<br>
                            <strong>PEDIDO CLIENTE:</strong> {{ $pieza->pedido->numero_pedido ?? 'N/A' }}<br>
                            <strong>CLIENTE:</strong> {{ $pieza->pedido->cliente ?? 'N/A' }}
                        </div>
                        <div class="col-md-4">
                            <strong>ARTICULO:</strong> {{ $pieza->codigo_pieza }}<br>
                            <strong>REVISIÓN:</strong> R1<br>
                            <strong>Cantidad:</strong> {{ $pieza->cantidad }} unidades
                        </div>
                        <div class="col-md-4">
                            <strong>Precio Unitario:</strong> {{ number_format($pieza->precio_unitario, 2) }} €<br>
                            <strong>Descripción:</strong> {{ $pieza->descripcion ?? 'Sin descripción' }}<br>
                            <strong>Estado:</strong>
                            <span class="badge bg-{{ $seguimiento->estado == 'pendiente' ? 'warning' : ($seguimiento->estado == 'en_proceso' ? 'info' : ($seguimiento->estado == 'completado' ? 'success' : 'danger')) }} fs-6 px-2 py-1 ms-1">
                                <i class="mdi mdi-{{ $seguimiento->estado == 'pendiente' ? 'clock' : ($seguimiento->estado == 'en_proceso' ? 'play' : ($seguimiento->estado == 'completado' ? 'check' : 'alert')) }} me-1"></i>
                                {{ ucfirst(str_replace('_', ' ', $seguimiento->estado ?? 'pendiente')) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('seguimiento-pieza.store', $pieza->id) }}" method="POST" id="seguimientoForm">
        @csrf

        <div class="row">
            <!-- Columna Izquierda - Trabajos y Costos -->
            <div class="col-lg-8">

                <!-- TRABAJOS DE PRODUCCIÓN -->
                <div class="card mb-4">
                    <div class="card-header header-naranja">
                        <h5 class="mb-0"><i class="mdi mdi-factory me-2"></i>TRABAJOS DE PRODUCCIÓN</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="tabla-produccion">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="table-header-small" title="Tipo de trabajo a realizar">TRABAJO</th>
                                        <th class="table-header-small" title="Unidad de medida">UNIDAD</th>
                                        <th class="table-header-small" title="Tiempo en minutos">MIN</th>
                                        <th class="table-header-small" title="Coste por unidad">COSTE U.</th>
                                        <th class="table-header-small" title="Coste total">TOTAL C.</th>
                                        <th class="table-header-small" title="Precio de venta por unidad">PRECIO U.</th>
                                        <th class="table-header-small" title="Porcentaje de beneficio">BENEF.</th>
                                        <th class="table-header-small" title="Precio total de venta">TOTAL V.</th>
                                        <th class="table-header-small" title="Acciones disponibles">ACC.</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-produccion">
                                    @if(isset($datosTablas['produccion']) && count($datosTablas['produccion']) > 0)
                                        @foreach($datosTablas['produccion'] as $fila)
                                            <tr class="fila-produccion">
                                                <td class="table-cell-small">
                                                    <select class="form-control table-select-small" name="trabajo[]">
                                                        <option value="CIZALLA Y/O PLEGADORA" {{ $fila['trabajo'] == 'CIZALLA Y/O PLEGADORA' ? 'selected' : '' }}>CIZALLA Y/O PLEGADORA</option>
                                                        <option value="CORTE DE SIERRA" {{ $fila['trabajo'] == 'CORTE DE SIERRA' ? 'selected' : '' }}>CORTE DE SIERRA</option>
                                                        <option value="MONTAJE DE PIEZAS PUNT." {{ $fila['trabajo'] == 'MONTAJE DE PIEZAS PUNT.' ? 'selected' : '' }}>MONTAJE DE PIEZAS PUNT.</option>
                                                        <option value="TORNO Y FRESA" {{ $fila['trabajo'] == 'TORNO Y FRESA' ? 'selected' : '' }}>TORNO Y FRESA</option>
                                                        <option value="SOLDADURA A/C" {{ $fila['trabajo'] == 'SOLDADURA A/C' ? 'selected' : '' }}>SOLDADURA A/C</option>
                                                        <option value="SOLDADURA ALUMINIO" {{ $fila['trabajo'] == 'SOLDADURA ALUMINIO' ? 'selected' : '' }}>SOLDADURA ALUMINIO</option>
                                                        <option value="SOLDADURA INOX" {{ $fila['trabajo'] == 'SOLDADURA INOX' ? 'selected' : '' }}>SOLDADURA INOX</option>
                                                        <option value="CHORREADO Y LIMPIEZA" {{ $fila['trabajo'] == 'CHORREADO Y LIMPIEZA' ? 'selected' : '' }}>CHORREADO Y LIMPIEZA</option>
                                                        <option value="TERMINAZIÓN Y PINTURA" {{ $fila['trabajo'] == 'TERMINAZIÓN Y PINTURA' ? 'selected' : '' }}>TERMINAZIÓN Y PINTURA</option>
                                                        <option value="VERIFICACIÓN" {{ $fila['trabajo'] == 'VERIFICACIÓN' ? 'selected' : '' }}>VERIFICACIÓN</option>
                                                        <option value="EMBALAJE" {{ $fila['trabajo'] == 'EMBALAJE' ? 'selected' : '' }}>EMBALAJE</option>
                                                        <option value="TECNICOS" {{ $fila['trabajo'] == 'TECNICOS' ? 'selected' : '' }}>TECNICOS</option>
                                                        <option value="MONTAJE EN OBRA" {{ $fila['trabajo'] == 'MONTAJE EN OBRA' ? 'selected' : '' }}>MONTAJE EN OBRA</option>
                                                        <option value="MONTAJE ELÉCTRICO E HIDRAULICO" {{ $fila['trabajo'] == 'MONTAJE ELÉCTRICO E HIDRAULICO' ? 'selected' : '' }}>MONTAJE ELÉCTRICO E HIDRAULICO</option>
                                                    </select>
                                                </td>
                                                <td class="table-cell-small">min</td>
                                                <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small minutos" name="minutos[]" value="{{ $fila['minutos'] }}" onchange="calcularFila(this)"></td>
                                                <td class="table-cell-small">
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" step="0.01" class="form-control table-input-small coste-unitario me-1" name="coste_unitario[]" value="{{ $fila['coste_unitario'] }}" onchange="calcularFila(this)">
                                                        <span class="text-nowrap">€/h</span>
                                                    </div>
                                                </td>
                                                <td class="table-cell-small"><span class="total-coste">{{ number_format(($fila['coste_unitario'] * $fila['minutos']) / 60, 2) }}</span> €</td>
                                                <td class="table-cell-small">
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" step="0.01" class="form-control table-input-small precio-venta me-1" name="precio_venta[]" value="{{ $fila['precio_venta'] }}" onchange="calcularFila(this)">
                                                        <span class="text-nowrap">€/h</span>
                                                    </div>
                                                </td>
                                                <td class="table-cell-small">24%</td>
                                                <td class="table-cell-small"><span class="total-venta">{{ number_format(($fila['precio_venta'] * $fila['minutos']) / 60, 2) }}</span> €</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)" title="Eliminar fila">
                                                        <i class="mdi mdi-delete me-1"></i>Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-naranja btn-sm" onclick="agregarFilaProduccion()" style="display: block !important; margin: 5px 0;">
                                    <i class="mdi mdi-plus me-1"></i>Agregar Trabajo
                                </button>
                            </div>
                            <div class="col-md-6 text-end">
                                <strong>COSTE PRODUCCIÓN:</strong> <span id="coste_produccion_final">0.00</span> €<br>
                                <strong>PRECIO VENTA TOTAL:</strong> <span id="precio_venta_produccion_final">0.00</span> €<br>
                                <strong>TOTAL HORAS:</strong> <span id="total_horas_produccion">0.00</span> h
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TRABAJOS DE CORTE POR LASER - AGUA -->
                <div class="card mb-4">
                    <div class="card-header header-gris">
                        <h5 class="mb-0"><i class="mdi mdi-laser-pointer me-2"></i>TRABAJOS DE CORTE POR LASER - AGUA</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="tabla-laser">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="table-header-small" title="Tipo de material">MATERIAL</th>
                                        <th class="table-header-small" title="Unidad de medida">UNIDAD</th>
                                        <th class="table-header-small" title="Tiempo en minutos">MIN</th>
                                        <th class="table-header-small" title="Coste por unidad">COSTE U.</th>
                                        <th class="table-header-small" title="Coste total">TOTAL C.</th>
                                        <th class="table-header-small" title="Precio de venta por unidad">PRECIO U.</th>
                                        <th class="table-header-small" title="Porcentaje de beneficio">BENEF.</th>
                                        <th class="table-header-small" title="Precio total de venta">TOTAL V.</th>
                                        <th class="table-header-small" title="Acciones disponibles">ACC.</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-laser">
                                    @if(isset($datosTablas['laser']) && count($datosTablas['laser']) > 0)
                                        @foreach($datosTablas['laser'] as $fila)
                                            <tr class="fila-laser">
                                                <td class="table-cell-small">
                                                    <select class="form-control table-select-small" name="material_laser[]">
                                                        <option value="INOX 0-3MM" {{ $fila['material'] == 'INOX 0-3MM' ? 'selected' : '' }}>INOX 0-3MM</option>
                                                        <option value="INOX 4-6MM" {{ $fila['material'] == 'INOX 4-6MM' ? 'selected' : '' }}>INOX 4-6MM</option>
                                                        <option value="INOX 8-10MM" {{ $fila['material'] == 'INOX 8-10MM' ? 'selected' : '' }}>INOX 8-10MM</option>
                                                        <option value="INOX 12MM" {{ $fila['material'] == 'INOX 12MM' ? 'selected' : '' }}>INOX 12MM</option>
                                                        <option value="A/C 0-15MM" {{ $fila['material'] == 'A/C 0-15MM' ? 'selected' : '' }}>A/C 0-15MM</option>
                                                        <option value="ALUM 0-3MM" {{ $fila['material'] == 'ALUM 0-3MM' ? 'selected' : '' }}>ALUM 0-3MM</option>
                                                        <option value="ALUM 4-6MM" {{ $fila['material'] == 'ALUM 4-6MM' ? 'selected' : '' }}>ALUM 4-6MM</option>
                                                        <option value="LASER-TUBO INOXIDABLE" {{ $fila['material'] == 'LASER-TUBO INOXIDABLE' ? 'selected' : '' }}>LASER-TUBO INOXIDABLE</option>
                                                        <option value="LASER-TUBO ACERO AL CARBONO" {{ $fila['material'] == 'LASER-TUBO ACERO AL CARBONO' ? 'selected' : '' }}>LASER-TUBO ACERO AL CARBONO</option>
                                                        <option value="LASER-TUBO ALUMINIO" {{ $fila['material'] == 'LASER-TUBO ALUMINIO' ? 'selected' : '' }}>LASER-TUBO ALUMINIO</option>
                                                        <option value="AGUA SIMPLE CABEZAL" {{ $fila['material'] == 'AGUA SIMPLE CABEZAL' ? 'selected' : '' }}>AGUA SIMPLE CABEZAL</option>
                                                        <option value="AGUA DOBLE CABEZAL" {{ $fila['material'] == 'AGUA DOBLE CABEZAL' ? 'selected' : '' }}>AGUA DOBLE CABEZAL</option>
                                                    </select>
                                                </td>
                                                <td class="table-cell-small">min</td>
                                                <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small minutos-laser" name="minutos_laser[]" value="{{ $fila['minutos'] }}" onchange="calcularFilaLaser(this)"></td>
                                                <td class="table-cell-small">
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" step="0.01" class="form-control table-input-small coste-unitario-laser me-1" name="coste_unitario_laser[]" value="{{ $fila['coste_unitario'] }}" onchange="calcularFilaLaser(this)">
                                                        <span class="text-nowrap">€/min</span>
                                                    </div>
                                                </td>
                                                <td class="table-cell-small"><span class="total-coste-laser">{{ number_format($fila['coste_unitario'] * $fila['minutos'], 2) }}</span> €</td>
                                                <td class="table-cell-small">
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" step="0.01" class="form-control table-input-small precio-venta-laser me-1" name="precio_venta_laser[]" value="{{ $fila['precio_venta'] }}" onchange="calcularFilaLaser(this)">
                                                        <span class="text-nowrap">€/min</span>
                                                    </div>
                                                </td>
                                                <td class="table-cell-small">71%</td>
                                                <td class="table-cell-small"><span class="total-venta-laser">{{ number_format($fila['precio_venta'] * $fila['minutos'], 2) }}</span> €</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFilaLaser(this)" title="Eliminar fila">
                                                        <i class="mdi mdi-delete me-1"></i>Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-naranja btn-sm" onclick="agregarFilaLaser()" style="display: block !important; margin: 5px 0;">
                                    <i class="mdi mdi-plus me-1"></i>Agregar Fila Láser
                                </button>
                            </div>
                            <div class="col-md-6 text-end">
                                <strong>COSTE CORTE LASER-AGUA:</strong> <span id="coste_laser_final">0.00</span> €<br>
                                <strong>PRECIO VENTA TOTAL:</strong> <span id="precio_venta_laser_final">0.00</span> €
                            </div>
                        </div>
                    </div>
                </div>

                <!-- OTROS SERVICIOS -->
                <div class="card mb-4">
                    <div class="card-header header-naranja">
                        <h5 class="mb-0"><i class="mdi mdi-tools me-2"></i>OTROS SERVICIOS</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="tabla-otros-servicios">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="table-header-small" title="Tipo de servicio">SERVICIO</th>
                                        <th class="table-header-small" title="Cantidad requerida">CANT.</th>
                                        <th class="table-header-small" title="Unidad de medida">UNIDAD</th>
                                        <th class="table-header-small" title="Coste por unidad">COSTE U.</th>
                                        <th class="table-header-small" title="Coste total">TOTAL C.</th>
                                        <th class="table-header-small" title="Precio de venta por unidad">PRECIO U.</th>
                                        <th class="table-header-small" title="Porcentaje de beneficio">BENEF.</th>
                                        <th class="table-header-small" title="Precio total de venta">TOTAL V.</th>
                                        <th class="table-header-small" title="Acciones disponibles">ACC.</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-otros-servicios">
                                    @if(isset($datosTablas['servicios']) && count($datosTablas['servicios']) > 0)
                                        @foreach($datosTablas['servicios'] as $fila)
                                            <tr class="fila-otros-servicios">
                                                <td class="table-cell-small">
                                                    <div class="servicio-select-container">
                                                        <select class="form-control table-select-small categoria-servicio" name="categoria_servicio[]" onchange="cambiarSubcategoria(this)">
                                                            <option value="">Seleccionar categoría...</option>
                                                            <option value="PORTES, GRUAS Y/O DIETAS" {{ $fila['servicio'] == 'PORTES, GRUAS Y/O DIETAS' ? 'selected' : '' }}>PORTES, GRUAS Y/O DIETAS</option>
                                                            <option value="SUBCONTRATACION" {{ $fila['servicio'] == 'SUBCONTRATACION' ? 'selected' : '' }}>SUBCONTRATACION</option>
                                                            <option value="OTROS" {{ $fila['servicio'] == 'OTROS' ? 'selected' : '' }}>OTROS</option>
                                                        </select>
                                                        <select class="form-control table-select-small subcategoria-servicio" name="servicio[]" style="display: none;">
                                                            <option value="">Seleccionar subcategoría...</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small cantidad-servicios" name="cantidad_servicios[]" value="{{ $fila['cantidad'] }}" onchange="calcularFilaServicios(this)"></td>
                                                <td class="table-cell-small">
                                                    <select class="form-control table-select-small" name="unidad_servicios[]">
                                                        <option value="ud">ud</option>
                                                        <option value="h">h</option>
                                                        <option value="min">min</option>
                                                        <option value="kg">kg</option>
                                                        <option value="m">m</option>
                                                        <option value="m2">m²</option>
                                                        <option value="m3">m³</option>
                                                        <option value="l">l</option>
                                                    </select>
                                                </td>
                                                <td class="table-cell-small">
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" step="0.01" class="form-control table-input-small coste-unitario-servicios me-1" name="coste_unitario_servicios[]" value="{{ $fila['coste_unitario'] }}" onchange="calcularFilaServicios(this)">
                                                        <span class="text-nowrap">€</span>
                                                    </div>
                                                </td>
                                                <td class="table-cell-small"><span class="total-coste-servicios">{{ number_format($fila['coste_unitario'] * $fila['cantidad'], 2) }}</span> €</td>
                                                <td class="table-cell-small">
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" step="0.01" class="form-control table-input-small precio-venta-servicios me-1" name="precio_venta_servicios[]" value="{{ $fila['precio_venta'] }}" onchange="calcularFilaServicios(this)">
                                                        <span class="text-nowrap">€</span>
                                                    </div>
                                                </td>
                                                <td class="table-cell-small">20%</td>
                                                <td class="table-cell-small"><span class="total-venta-servicios">{{ number_format($fila['precio_venta'] * $fila['cantidad'], 2) }}</span> €</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFilaServicios(this)" title="Eliminar fila">
                                                        <i class="mdi mdi-delete me-1"></i>Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-naranja btn-sm" onclick="agregarFilaServicios()" style="display: block !important; margin: 5px 0;">
                                    <i class="mdi mdi-plus me-1"></i>Agregar Servicio
                                </button>
                            </div>
                            <div class="col-md-6 text-end">
                                <strong>COSTE OTROS SERVICIOS:</strong> <span id="coste_otros_servicios_final">0.00</span> €<br>
                                <strong>PRECIO VENTA TOTAL:</strong> <span id="precio_venta_otros_servicios_final">0.00</span> €
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MATERIALES -->
                <div class="card mb-4">
                    <div class="card-header header-gris">
                        <h5 class="mb-0"><i class="mdi mdi-package-variant me-2"></i>MATERIALES</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="tabla-materiales">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="table-header-small" title="Tipo de material">MATERIAL</th>
                                        <th class="table-header-small" title="Cantidad requerida">CANT.</th>
                                        <th class="table-header-small" title="Unidad de medida">UNIDAD</th>
                                        <th class="table-header-small" title="Coste por unidad">COSTE U.</th>
                                        <th class="table-header-small" title="Coste total">TOTAL C.</th>
                                        <th class="table-header-small" title="Precio de venta por unidad">PRECIO U.</th>
                                        <th class="table-header-small" title="Porcentaje de beneficio">BENEF.</th>
                                        <th class="table-header-small" title="Precio total de venta">TOTAL V.</th>
                                        <th class="table-header-small" title="Acciones disponibles">ACC.</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-materiales">
                                    @if(isset($datosTablas['materiales']) && count($datosTablas['materiales']) > 0)
                                        @foreach($datosTablas['materiales'] as $fila)
                                            <tr class="fila-materiales">
                                                <td class="table-cell-small">
                                                    <select class="form-control table-select-small material-manual" name="material[]" onchange="cambiarUnidadMaterial(this)">
                                                        <option value="">Seleccionar material...</option>
                                                        <option value="COMERCIALES" {{ $fila['material'] == 'COMERCIALES' ? 'selected' : '' }}>COMERCIALES</option>
                                                        <option value="OTROS MATERIALES" {{ $fila['material'] == 'OTROS MATERIALES' ? 'selected' : '' }}>OTROS MATERIALES</option>
                                                        <option value="MATERIAL HIDRÁULICO" {{ $fila['material'] == 'MATERIAL HIDRÁULICO' ? 'selected' : '' }}>MATERIAL HIDRÁULICO</option>
                                                        <option value="MATERIAL ELÉCTRICO" {{ $fila['material'] == 'MATERIAL ELÉCTRICO' ? 'selected' : '' }}>MATERIAL ELÉCTRICO</option>
                                                        <option value="IMPRIMACIÓN EPOXI + CATALIZADOR" {{ $fila['material'] == 'IMPRIMACIÓN EPOXI + CATALIZADOR' ? 'selected' : '' }}>IMPRIMACIÓN EPOXI + CATALIZADOR</option>
                                                        <option value="PINTURA POLIURETANO + CATALIZADOR" {{ $fila['material'] == 'PINTURA POLIURETANO + CATALIZADOR' ? 'selected' : '' }}>PINTURA POLIURETANO + CATALIZADOR</option>
                                                    </select>
                                                </td>
                                                <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small cantidad-materiales" name="cantidad_materiales[]" value="{{ $fila['cantidad'] }}" onchange="calcularFilaMateriales(this)"></td>
                                                <td class="table-cell-small">
                                                    <select class="form-control table-select-small unidad-material" name="unidad_materiales[]">
                                                        <option value="kg">kg</option>
                                                        <option value="m">m</option>
                                                        <option value="m2">m²</option>
                                                        <option value="m3">m³</option>
                                                        <option value="ud" selected>ud</option>
                                                        <option value="l">l</option>
                                                        <option value="rollo">rollo</option>
                                                        <option value="paquete">paquete</option>
                                                    </select>
                                                </td>
                                                <td class="table-cell-small">
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" step="0.01" class="form-control table-input-small coste-unitario-materiales me-1" name="coste_unitario_materiales[]" value="{{ $fila['coste_unitario'] }}" onchange="calcularFilaMateriales(this)">
                                                        <span class="text-nowrap">€</span>
                                                    </div>
                                                </td>
                                                <td class="table-cell-small"><span class="total-coste-materiales">{{ number_format($fila['coste_unitario'] * $fila['cantidad'], 2) }}</span> €</td>
                                                <td class="table-cell-small">
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" step="0.01" class="form-control table-input-small precio-venta-materiales me-1" name="precio_venta_materiales[]" value="{{ $fila['precio_venta'] }}" onchange="calcularFilaMateriales(this)">
                                                        <span class="text-nowrap">€</span>
                                                    </div>
                                                </td>
                                                <td class="table-cell-small">20%</td>
                                                <td class="table-cell-small"><span class="total-venta-materiales">{{ number_format($fila['precio_venta'] * $fila['cantidad'], 2) }}</span> €</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFilaMateriales(this)" title="Eliminar fila">
                                                        <i class="mdi mdi-delete me-1"></i>Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-naranja btn-sm" onclick="agregarFilaMateriales()" style="display: block !important; margin: 5px 0;">
                                    <i class="mdi mdi-plus me-1"></i>Agregar Material
                                </button>
                            </div>
                            <div class="col-md-6 text-end">
                                <strong>COSTE MATERIALES:</strong> <span id="coste_materiales_final">0.00</span> €<br>
                                <strong>PRECIO VENTA TOTAL:</strong> <span id="precio_venta_materiales_final">0.00</span> €
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CÁLCULO DE MATERIALES -->
                <div class="card mb-4">
                    <div class="card-header header-gris">
                        <h5 class="mb-0"><i class="mdi mdi-calculator me-2"></i>CÁLCULO DE MATERIALES</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="tabla-calculo-materiales">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="table-header-small" title="Cantidad de material">CANT.</th>
                                        <th class="table-header-small" title="Descripción del material">DESCRIPCIÓN</th>
                                        <th class="table-header-small" title="Precio por unidad">PRECIO U.</th>
                                        <th class="table-header-small" title="Coste total de la partida">COSTE P.</th>
                                        <th class="table-header-small" title="Acciones disponibles">ACC.</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-calculo-materiales">
                                    @if(isset($datosTablas['calculo_materiales']) && count($datosTablas['calculo_materiales']) > 0)
                                        @foreach($datosTablas['calculo_materiales'] as $fila)
                                            <tr class="fila-calculo-materiales">
                                                <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small cantidad-calculo-materiales" name="cantidad_material_empleado[]" value="{{ $fila['cantidad'] }}" onchange="calcularFilaCalculoMateriales(this)"></td>
                                                <td class="table-cell-small"><input type="text" class="form-control table-input-small" name="descripcion_material[]" value="{{ $fila['descripcion'] }}" onchange="calcularFilaCalculoMateriales(this)"></td>
                                                <td class="table-cell-small">
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" step="0.01" class="form-control table-input-small precio-unitario-calculo-materiales me-1" name="precio_unitario_material[]" value="{{ $fila['precio_unitario'] }}" onchange="calcularFilaCalculoMateriales(this)">
                                                        <span class="text-nowrap">€</span>
                                                    </div>
                                                </td>
                                                <td class="table-cell-small"><span class="coste-partida-materiales">{{ number_format($fila['cantidad'] * $fila['precio_unitario'], 2) }}</span> €</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFilaCalculoMateriales(this)" title="Eliminar fila">
                                                        <i class="mdi mdi-delete me-1"></i>Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-naranja btn-sm" onclick="agregarFilaCalculoMateriales()" style="display: block !important; margin: 5px 0;">
                                    <i class="mdi mdi-plus me-1"></i>Agregar Material
                                </button>
                            </div>
                            <div class="col-md-6 text-end">
                                <strong>COSTE TOTAL MATERIALES:</strong> <span id="coste_total_calculo_materiales">10.00</span> €
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CÁLCULO DE MATERIAL PARA LASER-TUBO -->
                <div class="card mb-4">
                    <div class="card-header header-naranja">
                        <h5 class="mb-0"><i class="mdi mdi-pipe me-2"></i>CÁLCULO DE MATERIAL PARA LASER-TUBO</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="tabla-laser-tubo">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="table-header-small" title="Metros de tubo">METROS</th>
                                        <th class="table-header-small" title="Descripción del tubo">DESCRIPCIÓN</th>
                                        <th class="table-header-small" title="Precio por metro">PRECIO /m</th>
                                        <th class="table-header-small" title="Total de tubos">TOTAL T.</th>
                                        <th class="table-header-small" title="Acciones disponibles">ACC.</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-laser-tubo">
                                    @if(isset($datosTablas['laser_tubo']) && count($datosTablas['laser_tubo']) > 0)
                                        @foreach($datosTablas['laser_tubo'] as $fila)
                                            <tr class="fila-laser-tubo">
                                                <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small metros-tubos" name="metros_tubos[]" value="{{ $fila['metros'] }}" onchange="calcularFilaLaserTubo(this)"></td>
                                                <td class="table-cell-small"><input type="text" class="form-control table-input-small" name="descripcion_tubos[]" value="{{ $fila['descripcion'] }}" onchange="calcularFilaLaserTubo(this)"></td>
                                                <td class="table-cell-small">
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" step="0.01" class="form-control table-input-small precio-metro-tubos me-1" name="precio_metro_tubos[]" value="{{ $fila['precio_metro'] }}" onchange="calcularFilaLaserTubo(this)">
                                                        <span class="text-nowrap">€/m</span>
                                                    </div>
                                                </td>
                                                <td class="table-cell-small"><span class="total-tubos">{{ number_format($fila['metros'] * $fila['precio_metro'], 2) }}</span> €</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFilaLaserTubo(this)" title="Eliminar fila">
                                                        <i class="mdi mdi-delete me-1"></i>Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-naranja btn-sm" onclick="agregarFilaLaserTubo()" style="display: block !important; margin: 5px 0;">
                                    <i class="mdi mdi-plus me-1"></i>Agregar Tubo
                                </button>
                            </div>
                            <div class="col-md-6 text-end">
                                <strong>TOTAL TUBOS EMPLEADOS:</strong> <span id="total_tubos_empleados_final">0.00</span> €
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CÁLCULO DE PRECIOS DE CHAPAS -->
                <div class="card mb-4">
                    <div class="card-header header-gris">
                        <h5 class="mb-0"><i class="mdi mdi-square-outline me-2"></i>CÁLCULO DE PRECIOS DE CHAPAS</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="tabla-chapas">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="table-header-small" title="Cantidad de chapas">CANT.</th>
                                        <th class="table-header-small" title="Material de la chapa">MATERIAL</th>
                                        <th class="table-header-small" title="Largo en milímetros">LARGO</th>
                                        <th class="table-header-small" title="Ancho en milímetros">ANCHO</th>
                                        <th class="table-header-small" title="Espesor en milímetros">ESP.</th>
                                        <th class="table-header-small" title="Peso en kilogramos">PESO</th>
                                        <th class="table-header-small" title="Coste en euros">COSTE</th>
                                        <th class="table-header-small" title="Total de la chapa">TOTAL</th>
                                        <th class="table-header-small" title="Acciones disponibles">ACC.</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-chapas">
                                    @if(isset($datosTablas['chapas']) && count($datosTablas['chapas']) > 0)
                                        @foreach($datosTablas['chapas'] as $fila)
                                            <tr class="fila-chapas">
                                                <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small cantidad-chapas" name="cantidad_chapas[]" value="{{ $fila['cantidad'] }}" onchange="calcularFilaChapas(this)"></td>
                                                <td class="table-cell-small">
                                                    <select class="form-control table-select-small material-chapa" name="material_chapa[]" onchange="calcularFilaChapas(this)">
                                                        <option value="">Seleccionar material...</option>
                                                        <option value="A/C" {{ $fila['material'] == 'A/C' ? 'selected' : '' }}>A/C</option>
                                                        <option value="AISI 304" {{ $fila['material'] == 'AISI 304' ? 'selected' : '' }}>AISI 304</option>
                                                        <option value="AISI 316" {{ $fila['material'] == 'AISI 316' ? 'selected' : '' }}>AISI 316</option>
                                                        <option value="ALUMINIO" {{ $fila['material'] == 'ALUMINIO' ? 'selected' : '' }}>ALUMINIO</option>
                                                        <option value="ANODIZADO" {{ $fila['material'] == 'ANODIZADO' ? 'selected' : '' }}>ANODIZADO</option>
                                                        <option value="AISI 304 BRILLO" {{ $fila['material'] == 'AISI 304 BRILLO' ? 'selected' : '' }}>AISI 304 BRILLO</option>
                                                        <option value="AISI 304 SATIN" {{ $fila['material'] == 'AISI 304 SATIN' ? 'selected' : '' }}>AISI 304 SATIN</option>
                                                        <option value="AISI 316 BRI SAT" {{ $fila['material'] == 'AISI 316 BRI SAT' ? 'selected' : '' }}>AISI 316 BRI SAT</option>
                                                        <option value="ALUMINIO PALILLOS" {{ $fila['material'] == 'ALUMINIO PALILLOS' ? 'selected' : '' }}>ALUMINIO PALILLOS</option>
                                                        <option value="DAMERO ITURRI (ALUMINIO)" {{ $fila['material'] == 'DAMERO ITURRI (ALUMINIO)' ? 'selected' : '' }}>DAMERO ITURRI (ALUMINIO)</option>
                                                        <option value="ALUMINIO TOP-GRIP" {{ $fila['material'] == 'ALUMINIO TOP-GRIP' ? 'selected' : '' }}>ALUMINIO TOP-GRIP</option>
                                                        <option value="GALVANIZADO" {{ $fila['material'] == 'GALVANIZADO' ? 'selected' : '' }}>GALVANIZADO</option>
                                                    </select>
                                                </td>
                                                <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small largo-chapa" name="largo_chapa_mm[]" value="{{ $fila['largo'] }}" onchange="calcularFilaChapas(this)"></td>
                                                <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small ancho-chapa" name="ancho_chapa_mm[]" value="{{ $fila['ancho'] }}" onchange="calcularFilaChapas(this)"></td>
                                                <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small espesor-chapa" name="espesor_chapa_mm[]" value="{{ $fila['espesor'] }}" onchange="calcularFilaChapas(this)"></td>
                                                <td class="table-cell-small"><span class="peso-chapa">{{ number_format($fila['peso'] ?? 0, 3) }}</span> kg</td>
                                                <td class="table-cell-small"><span class="coste-chapa">{{ number_format($fila['coste'] ?? 0, 2) }}</span> €</td>
                                                <td class="table-cell-small"><span class="total-chapa">{{ number_format($fila['total'] ?? 0, 2) }}</span> €</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFilaChapas(this)" title="Eliminar fila">
                                                        <i class="mdi mdi-delete me-1"></i>Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-naranja btn-sm" onclick="agregarFilaChapas()" style="display: block !important; margin: 5px 0;">
                                    <i class="mdi mdi-plus me-1"></i>Agregar Chapa
                                </button>
                            </div>
                            <div class="col-md-6 text-end">
                                <strong>TOTAL CHAPAS EMPLEADAS:</strong> <span id="total_chapas_empleadas_final">{{ number_format($seguimiento->total_chapas_empleadas, 2) }}</span> €<br>
                                <strong>PESO TOTAL (kg):</strong> <span id="peso_total_kg_final">{{ number_format($seguimiento->peso_total_kg, 3) }}</span> kg
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Columna Derecha - Resumen y Precios -->
            <div class="col-lg-4" style="position: sticky; top: 20px; height: fit-content;">

                <!-- RESUMEN VENTA -->
                <div class="card mb-4">
                    <div class="card-header header-gris">
                        <h5 class="mb-0"><i class="mdi mdi-chart-line me-2"></i>RESUMEN VENTA</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-6"><strong>Coste Producción:</strong></div>
                            <div class="col-6" id="coste_produccion_total_resumen">0.00 €</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Precio Venta Producción:</strong></div>
                            <div class="col-6" id="precio_venta_total_produccion">0.00 €</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Total Horas:</strong></div>
                            <div class="col-6" id="total_horas_produccion">0.00 h</div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Coste Corte Laser:</strong></div>
                            <div class="col-6" id="coste_corte_laser_total_resumen">0.00 €</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Precio Venta Corte:</strong></div>
                            <div class="col-6" id="precio_venta_total_corte_laser">0.00 €</div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Coste Otros Servicios:</strong></div>
                            <div class="col-6" id="coste_otros_servicios_total_resumen">0.00 €</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Precio Venta Otros:</strong></div>
                            <div class="col-6" id="precio_venta_total_otros_servicios">0.00 €</div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Coste Materiales:</strong></div>
                            <div class="col-6" id="coste_materiales_total_resumen">0.00 €</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Precio Venta Materiales:</strong></div>
                            <div class="col-6" id="precio_venta_total_materiales">0.00 €</div>
                        </div>
                    </div>
                </div>

                <!-- BENEFICIOS -->
                <div class="card mb-4">
                    <div class="card-header header-naranja">
                        <h5 class="mb-0"><i class="mdi mdi-trending-up me-2"></i>BENEFICIOS</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-6"><strong>Beneficio Producción:</strong></div>
                            <div class="col-6" id="beneficio_produccion_porcentaje">{{ number_format($seguimiento->beneficio_produccion_porcentaje, 2) }}% ({{ number_format($seguimiento->beneficio_produccion_valor, 2) }} €)</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Beneficio Corte:</strong></div>
                            <div class="col-6" id="beneficio_corte_porcentaje">{{ number_format($seguimiento->beneficio_corte_porcentaje, 2) }}% ({{ number_format($seguimiento->beneficio_corte_valor, 2) }} €)</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Beneficio Otros Servicios:</strong></div>
                            <div class="col-6" id="beneficio_otros_servicios_porcentaje">{{ number_format($seguimiento->beneficio_otros_servicios_porcentaje, 2) }}% ({{ number_format($seguimiento->beneficio_otros_servicios_valor, 2) }} €)</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Beneficio Materiales:</strong></div>
                            <div class="col-6" id="beneficio_materiales_porcentaje">{{ number_format($seguimiento->beneficio_materiales_porcentaje, 2) }}% ({{ number_format($seguimiento->beneficio_materiales_valor, 2) }} €)</div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Gastos Financieros:</strong></div>
                            <div class="col-6">
                                <input type="number" step="0.01" class="form-control form-control-sm" name="gastos_financieros_porcentaje"
                                       value="{{ $seguimiento->gastos_financieros_porcentaje }}" onchange="calcularTotales()" style="width: 50px; display: inline-block; font-size: 0.75rem; height: 1.5rem; padding: 0.125rem 0.25rem;">%
                                <span id="gastos_financieros_valor">({{ number_format($seguimiento->gastos_financieros_valor, 2) }} €)</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Beneficio Teórico Total:</strong></div>
                            <div class="col-6" id="beneficio_teorico_total_porcentaje">{{ number_format($seguimiento->beneficio_teorico_total_porcentaje, 2) }}% ({{ number_format($seguimiento->beneficio_teorico_total_valor, 2) }} €)</div>
                        </div>
                    </div>
                </div>

                <!-- PRECIOS FINALES -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="mdi mdi-currency-eur me-2"></i>PRECIOS FINALES</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-6"><strong>Precio Venta Teórico Total:</strong></div>
                            <div class="col-6" id="precio_venta_teorico_total">{{ number_format($seguimiento->precio_venta_teorico_total, 2) }} €</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Precio Venta Teórico Unitario:</strong></div>
                            <div class="col-6" id="precio_venta_teorico_unitario">{{ number_format($seguimiento->precio_venta_teorico_unitario, 2) }} €</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Unidades Valoradas:</strong></div>
                            <div class="col-6">
                                <input type="number" step="1" class="form-control form-control-sm" name="unidades_valoradas_tabla"
                                       value="{{ $seguimiento->unidades_valoradas_tabla ?? 1 }}" onchange="calcularTotales()" style="width: 60px; display: inline-block; font-size: 0.75rem; height: 1.5rem; padding: 0.125rem 0.25rem;">
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Precio Final Total:</strong></div>
                            <div class="col-6" id="precio_final_total">{{ number_format($seguimiento->precio_final_total, 2) }} €</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Precio Final Unitario:</strong></div>
                            <div class="col-6" id="precio_final_unitario">{{ number_format($seguimiento->precio_final_unitario, 2) }} €</div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Precio Subasta Total:</strong></div>
                            <div class="col-6">
                                <input type="number" step="0.01" class="form-control form-control-sm" name="precio_subasta_total"
                                       value="{{ $seguimiento->precio_subasta_total ?? 0 }}" onchange="calcularTotales()" style="width: 80px; display: inline-block; font-size: 0.75rem; height: 1.5rem; padding: 0.125rem 0.25rem;">€
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Precio Subasta Unitario:</strong></div>
                            <div class="col-6" id="precio_subasta_unitario">{{ number_format($seguimiento->precio_subasta_unitario ?? 0, 2) }} €</div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-6"><strong>% Beneficio Facturación:</strong></div>
                            <div class="col-6" id="porcentaje_beneficio_facturacion">{{ number_format($seguimiento->porcentaje_beneficio_facturacion, 2) }}%</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Beneficio Tras Facturación:</strong></div>
                            <div class="col-6" id="beneficio_tras_facturacion">{{ number_format($seguimiento->beneficio_tras_facturacion, 2) }} €</div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-6"><strong>% Deseado Facturación:</strong></div>
                            <div class="col-6">
                                <input type="number" step="0.01" class="form-control form-control-sm" name="porcentaje_deseado_facturacion"
                                       value="{{ $seguimiento->porcentaje_deseado_facturacion }}" onchange="calcularTotales()" style="width: 50px; display: inline-block; font-size: 0.75rem; height: 1.5rem; padding: 0.125rem 0.25rem;">%
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Precio Aprox. Facturar:</strong></div>
                            <div class="col-6" id="precio_aprox_facturar">{{ number_format($seguimiento->precio_aprox_facturar, 2) }} €</div>
                        </div>
                    </div>
                </div>

                <!-- CONTROL Y ESTADO -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="mdi mdi-cog me-2"></i>CONTROL Y ESTADO</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label">Estado</label>
                                <select class="form-control" name="estado" required>
                                    <option value="pendiente" {{ $seguimiento->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="en_proceso" {{ $seguimiento->estado == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                    <option value="completado" {{ $seguimiento->estado == 'completado' ? 'selected' : '' }}>Completado</option>
                                    <option value="cancelado" {{ $seguimiento->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label">Comercial/Técnico</label>
                                <input type="text" class="form-control" name="comercial_tecnico"
                                       value="{{ $seguimiento->comercial_tecnico }}" placeholder="Ej: MAC, EP, JFE">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label">Observaciones</label>
                                <textarea class="form-control" name="observaciones" rows="3"
                                          placeholder="Observaciones adicionales...">{{ $seguimiento->observaciones }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="mdi mdi-content-save me-2"></i>Guardar Seguimiento
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<!-- JavaScript para cálculos automáticos -->
<script>
// Funciones para manejar filas dinámicas
function agregarFilaProduccion() {
    const tbody = document.getElementById('tbody-produccion');
    const nuevaFila = document.createElement('tr');
    nuevaFila.className = 'fila-produccion';

    nuevaFila.innerHTML = `
        <td class="table-cell-small">
            <select class="form-control table-select-small" name="trabajo[]">
                <option value="CIZALLA Y/O PLEGADORA">CIZALLA Y/O PLEGADORA</option>
                <option value="CORTE DE SIERRA">CORTE DE SIERRA</option>
                <option value="MONTAJE DE PIEZAS PUNT.">MONTAJE DE PIEZAS PUNT.</option>
                <option value="TORNO Y FRESA">TORNO Y FRESA</option>
                <option value="SOLDADURA A/C">SOLDADURA A/C</option>
                <option value="SOLDADURA ALUMINIO">SOLDADURA ALUMINIO</option>
                <option value="SOLDADURA INOX">SOLDADURA INOX</option>
                <option value="CHORREADO Y LIMPIEZA">CHORREADO Y LIMPIEZA</option>
                <option value="TERMINAZIÓN Y PINTURA">TERMINAZIÓN Y PINTURA</option>
                <option value="VERIFICACIÓN">VERIFICACIÓN</option>
                <option value="EMBALAJE">EMBALAJE</option>
                <option value="TECNICOS">TECNICOS</option>
                <option value="MONTAJE EN OBRA">MONTAJE EN OBRA</option>
                <option value="MONTAJE ELÉCTRICO E HIDRAULICO">MONTAJE ELÉCTRICO E HIDRAULICO</option>
            </select>
        </td>
        <td class="table-cell-small">min</td>
        <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small minutos" name="minutos[]" value="10" onchange="calcularFila(this)"></td>
        <td class="table-cell-small">
            <div class="d-flex align-items-center">
                <input type="number" step="0.01" class="form-control table-input-small coste-unitario me-1" name="coste_unitario[]" value="32.05" onchange="calcularFila(this)">
                <span class="text-nowrap">€/h</span>
            </div>
        </td>
        <td class="table-cell-small"><span class="total-coste">5.34</span> €</td>
        <td class="table-cell-small">
            <div class="d-flex align-items-center">
                <input type="number" step="0.01" class="form-control table-input-small precio-venta me-1" name="precio_venta[]" value="39.60" onchange="calcularFila(this)">
                <span class="text-nowrap">€/h</span>
            </div>
        </td>
        <td class="table-cell-small">24%</td>
        <td class="table-cell-small"><span class="total-venta">6.60</span> €</td>
                                                        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)" title="Eliminar fila">
                <i class="mdi mdi-delete me-1"></i>Eliminar
            </button>
        </td>
    `;

    tbody.appendChild(nuevaFila);
}

function eliminarFila(button) {
    const fila = button.closest('tr');
    fila.remove();
    calcularTotalesProduccion();
}

function calcularFila(input) {
    const fila = input.closest('tr');
    const minutos = parseFloat(fila.querySelector('.minutos').value) || 0;
    const costeUnitario = parseFloat(fila.querySelector('.coste-unitario').value) || 0;
    const precioVenta = parseFloat(fila.querySelector('.precio-venta').value) || 0;

    const totalCoste = (costeUnitario * minutos) / 60; // Convertir de €/h a €/min
    const totalVenta = (precioVenta * minutos) / 60;

    fila.querySelector('.total-coste').textContent = totalCoste.toFixed(2);
    fila.querySelector('.total-venta').textContent = totalVenta.toFixed(2);

    calcularTotalesProduccion();
}

// Funciones para manejar filas de láser
function agregarFilaLaser() {
    const tbody = document.getElementById('tbody-laser');
    const nuevaFila = document.createElement('tr');
    nuevaFila.className = 'fila-laser';

    nuevaFila.innerHTML = `
        <td class="table-cell-small">
            <select class="form-control table-select-small" name="material_laser[]">
                <option value="INOX 0-3MM">INOX 0-3MM</option>
                <option value="INOX 4-6MM">INOX 4-6MM</option>
                <option value="INOX 8-10MM">INOX 8-10MM</option>
                <option value="INOX 12MM">INOX 12MM</option>
                <option value="A/C 0-15MM">A/C 0-15MM</option>
                <option value="ALUM 0-3MM">ALUM 0-3MM</option>
                <option value="ALUM 4-6MM">ALUM 4-6MM</option>
                <option value="LASER-TUBO INOXIDABLE">LASER-TUBO INOXIDABLE</option>
                <option value="LASER-TUBO ACERO AL CARBONO">LASER-TUBO ACERO AL CARBONO</option>
                <option value="LASER-TUBO ALUMINIO">LASER-TUBO ALUMINIO</option>
                <option value="AGUA SIMPLE CABEZAL">AGUA SIMPLE CABEZAL</option>
                <option value="AGUA DOBLE CABEZAL">AGUA DOBLE CABEZAL</option>
            </select>
        </td>
        <td class="table-cell-small">min</td>
        <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small minutos-laser" name="minutos_laser[]" value="13.63" onchange="calcularFilaLaser(this)"></td>
        <td class="table-cell-small">
            <div class="d-flex align-items-center">
                <input type="number" step="0.01" class="form-control table-input-small coste-unitario-laser me-1" name="coste_unitario_laser[]" value="1.75" onchange="calcularFilaLaser(this)">
                <span class="text-nowrap">€/min</span>
            </div>
        </td>
        <td class="table-cell-small"><span class="total-coste-laser">23.85</span> €</td>
        <td class="table-cell-small">
            <div class="d-flex align-items-center">
                <input type="number" step="0.01" class="form-control table-input-small precio-venta-laser me-1" name="precio_venta_laser[]" value="3.00" onchange="calcularFilaLaser(this)">
                <span class="text-nowrap">€/min</span>
            </div>
        </td>
        <td class="table-cell-small">71%</td>
        <td class="table-cell-small"><span class="total-venta-laser">29.70</span> €</td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFilaLaser(this)" title="Eliminar fila">
                <i class="mdi mdi-delete me-1"></i>Eliminar
            </button>
        </td>
    `;

    tbody.appendChild(nuevaFila);
}

function eliminarFilaLaser(button) {
    const fila = button.closest('tr');
    fila.remove();
    calcularTotalesLaser();
}

function calcularFilaLaser(input) {
    const fila = input.closest('tr');
    const minutos = parseFloat(fila.querySelector('.minutos-laser').value) || 0;
    const costeUnitario = parseFloat(fila.querySelector('.coste-unitario-laser').value) || 0;
    const precioVenta = parseFloat(fila.querySelector('.precio-venta-laser').value) || 0;

    const totalCoste = costeUnitario * minutos; // Ya está en €/min
    const totalVenta = precioVenta * minutos;

    fila.querySelector('.total-coste-laser').textContent = totalCoste.toFixed(2);
    fila.querySelector('.total-venta-laser').textContent = totalVenta.toFixed(2);

    calcularTotalesLaser();
}

function calcularTotalesLaser() {
    let totalCoste = 0;
    let totalVenta = 0;

    document.querySelectorAll('.fila-laser').forEach(fila => {
        const coste = parseFloat(fila.querySelector('.total-coste-laser').textContent) || 0;
        const venta = parseFloat(fila.querySelector('.total-venta-laser').textContent) || 0;

        totalCoste += coste;
        totalVenta += venta;
    });

    document.getElementById('coste_laser_final').textContent = totalCoste.toFixed(2);
    document.getElementById('precio_venta_laser_final').textContent = totalVenta.toFixed(2);

    // Actualizar resumen lateral
    calcularTotales();
}

// Funciones para manejar filas de otros servicios
function cambiarSubcategoria(select) {
    const fila = select.closest('tr');
    const categoriaSelect = fila.querySelector('.categoria-servicio');
    const subcategoriaSelect = fila.querySelector('.subcategoria-servicio');
    const categoria = categoriaSelect.value;

    // Limpiar subcategorías
    subcategoriaSelect.innerHTML = '<option value="">Seleccionar subcategoría...</option>';

    if (categoria === 'SUBCONTRATACION') {
        // Mostrar subcategorías de subcontratación
        subcategoriaSelect.style.display = 'block';
        categoriaSelect.style.display = 'none';

        const subcategorias = [
            'PINTURA Y/O CHORREADO',
            'HIDRAULICA Y/O ELECTRICIDAD',
            'MECANIZADO',
            'OTROS'
        ];

        subcategorias.forEach(subcat => {
            const option = document.createElement('option');
            option.value = subcat;
            option.textContent = subcat;
            subcategoriaSelect.appendChild(option);
        });
    } else if (categoria === 'PORTES, GRUAS Y/O DIETAS' || categoria === 'OTROS') {
        // Para estas categorías, usar directamente el valor de la categoría
        subcategoriaSelect.style.display = 'none';
        categoriaSelect.style.display = 'block';
    }
}

function agregarFilaServicios() {
    const tbody = document.getElementById('tbody-otros-servicios');
    const nuevaFila = document.createElement('tr');
    nuevaFila.className = 'fila-otros-servicios';

                nuevaFila.innerHTML = `
        <td class="table-cell-small">
            <div class="servicio-select-container">
                <select class="form-control table-select-small categoria-servicio" name="categoria_servicio[]" onchange="cambiarSubcategoria(this)">
                    <option value="">Seleccionar categoría...</option>
                    <option value="PORTES, GRUAS Y/O DIETAS">PORTES, GRUAS Y/O DIETAS</option>
                    <option value="SUBCONTRATACION">SUBCONTRATACION</option>
                    <option value="OTROS">OTROS</option>
                </select>
                <select class="form-control table-select-small subcategoria-servicio" name="servicio[]" style="display: none;">
                    <option value="">Seleccionar subcategoría...</option>
                </select>
            </div>
        </td>
        <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small cantidad-servicios" name="cantidad_servicios[]" value="1" onchange="calcularFilaServicios(this)"></td>
        <td class="table-cell-small">
            <select class="form-control table-select-small" name="unidad_servicios[]">
                <option value="ud">ud</option>
                <option value="h">h</option>
                <option value="min">min</option>
                <option value="kg">kg</option>
                <option value="m">m</option>
                <option value="m2">m²</option>
                <option value="m3">m³</option>
                <option value="l">l</option>
            </select>
        </td>
        <td class="table-cell-small">
            <div class="d-flex align-items-center">
                <input type="number" step="0.01" class="form-control table-input-small coste-unitario-servicios me-1" name="coste_unitario_servicios[]" value="25.00" onchange="calcularFilaServicios(this)">
                <span class="text-nowrap">€</span>
            </div>
        </td>
        <td class="table-cell-small"><span class="total-coste-servicios">25.00</span> €</td>
        <td class="table-cell-small">
            <div class="d-flex align-items-center">
                <input type="number" step="0.01" class="form-control table-input-small precio-venta-servicios me-1" name="precio_venta_servicios[]" value="30.00" onchange="calcularFilaServicios(this)">
                <span class="text-nowrap">€</span>
            </div>
        </td>
        <td class="table-cell-small">20%</td>
        <td class="table-cell-small"><span class="total-venta-servicios">30.00</span> €</td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFilaServicios(this)" title="Eliminar fila">
                <i class="mdi mdi-delete me-1"></i>Eliminar
            </button>
        </td>
    `;

    tbody.appendChild(nuevaFila);
}

function eliminarFilaServicios(button) {
    const fila = button.closest('tr');
    fila.remove();
    calcularTotalesServicios();
}

function calcularFilaServicios(input) {
    const fila = input.closest('tr');
    const cantidad = parseFloat(fila.querySelector('.cantidad-servicios').value) || 0;
    const costeUnitario = parseFloat(fila.querySelector('.coste-unitario-servicios').value) || 0;
    const precioVenta = parseFloat(fila.querySelector('.precio-venta-servicios').value) || 0;

    const totalCoste = costeUnitario * cantidad;
    const totalVenta = precioVenta * cantidad;

    fila.querySelector('.total-coste-servicios').textContent = totalCoste.toFixed(2);
    fila.querySelector('.total-venta-servicios').textContent = totalVenta.toFixed(2);

    calcularTotalesServicios();
}

function calcularTotalesServicios() {
    let totalCoste = 0;
    let totalVenta = 0;

    document.querySelectorAll('.fila-otros-servicios').forEach(fila => {
        const coste = parseFloat(fila.querySelector('.total-coste-servicios').textContent) || 0;
        const venta = parseFloat(fila.querySelector('.total-venta-servicios').textContent) || 0;

        totalCoste += coste;
        totalVenta += venta;
    });

    document.getElementById('coste_otros_servicios_final').textContent = totalCoste.toFixed(2);
    document.getElementById('precio_venta_otros_servicios_final').textContent = totalVenta.toFixed(2);

    // Actualizar resumen lateral
    calcularTotales();
}

// Funciones para manejar filas de materiales
function cambiarTipoMaterial(select) {
    console.log('cambiarTipoMaterial - Iniciando para categoría:', select.value);
    const fila = select.closest('tr');
    const categoria = select.value;

    if (categoria === 'CHAPAS (TABLA CHAPAS)') {
        // Obtener el total de chapas desde la tabla de cálculo de chapas
        const totalChapas = parseFloat(document.getElementById('total_chapas_empleadas_final').textContent) || 0;
        console.log('cambiarTipoMaterial - totalChapas:', totalChapas);

        // Verificar que se encontraron los elementos
        const cantidadInput = fila.querySelector('.cantidad-materiales');
        const unidadSelect = fila.querySelector('select[name="unidad_materiales[]"]');
        const costeInput = fila.querySelector('.coste-unitario-materiales');
        const precioInput = fila.querySelector('.precio-venta-materiales');

        console.log('cambiarTipoMaterial - Elementos encontrados (CHAPAS):', {
            cantidadInput: !!cantidadInput,
            unidadSelect: !!unidadSelect,
            costeInput: !!costeInput,
            precioInput: !!precioInput
        });

        // Actualizar los campos de la fila
        if (cantidadInput) cantidadInput.value = '1';
        if (unidadSelect) unidadSelect.value = 'ud';
        if (costeInput) costeInput.value = totalChapas.toFixed(2);
        if (precioInput) precioInput.value = (totalChapas * 1.1).toFixed(2); // 10% de beneficio

        // Calcular la fila
        if (cantidadInput) {
            console.log('cambiarTipoMaterial - Llamando a calcularFilaMateriales para CHAPAS');
            calcularFilaMateriales(cantidadInput);
        } else {
            console.log('cambiarTipoMaterial - ERROR: No se encontró cantidadInput para CHAPAS');
        }

    } else if (categoria === 'RESTO DE MATERIA PRIMA Y TUBOS') {
        // Obtener los totales de las otras tablas
        const totalMateriales = parseFloat(document.getElementById('coste_total_calculo_materiales')?.textContent) || 0;
        const totalTubos = parseFloat(document.getElementById('total_tubos_empleados_final')?.textContent) || 0;
        const totalResto = totalMateriales + totalTubos;

        console.log('cambiarTipoMaterial - totalMateriales:', totalMateriales, 'totalTubos:', totalTubos, 'totalResto:', totalResto);

        // Verificar que se encontraron los elementos
        const cantidadInput = fila.querySelector('.cantidad-materiales');
        const unidadSelect = fila.querySelector('select[name="unidad_materiales[]"]');
        const costeInput = fila.querySelector('.coste-unitario-materiales');
        const precioInput = fila.querySelector('.precio-venta-materiales');

        console.log('cambiarTipoMaterial - Elementos encontrados:', {
            cantidadInput: !!cantidadInput,
            unidadSelect: !!unidadSelect,
            costeInput: !!costeInput,
            precioInput: !!precioInput
        });

        // Actualizar los campos de la fila
        if (cantidadInput) cantidadInput.value = '1';
        if (unidadSelect) unidadSelect.value = 'ud';
        if (costeInput) costeInput.value = totalResto.toFixed(2);
        if (precioInput) precioInput.value = (totalResto * 1.1).toFixed(2); // 10% de beneficio

        // Calcular la fila
        if (cantidadInput) {
            console.log('cambiarTipoMaterial - Llamando a calcularFilaMateriales');
            calcularFilaMateriales(cantidadInput);
        } else {
            console.log('cambiarTipoMaterial - ERROR: No se encontró cantidadInput');
        }
    }

    console.log('cambiarTipoMaterial - Completado');
}

function cambiarUnidadMaterial(select) {
    const fila = select.closest('tr');
    const material = select.value;
    const unidadSelect = fila.querySelector('.unidad-material');

    console.log('cambiarUnidadMaterial - Material seleccionado:', material);

    // Definir qué materiales usan kg y cuáles usan ud
    const materialesPorKg = [
        'IMPRIMACIÓN EPOXI + CATALIZADOR',
        'PINTURA POLIURETANO + CATALIZADOR'
    ];

    const materialesPorUnidad = [
        'COMERCIALES',
        'OTROS MATERIALES',
        'MATERIAL HIDRÁULICO',
        'MATERIAL ELÉCTRICO'
    ];

    if (unidadSelect) {
        if (materialesPorKg.includes(material)) {
            unidadSelect.value = 'kg';
            console.log('cambiarUnidadMaterial - Unidad cambiada a kg');
        } else if (materialesPorUnidad.includes(material)) {
            unidadSelect.value = 'ud';
            console.log('cambiarUnidadMaterial - Unidad cambiada a ud');
        }
    }
}

function actualizarMaterialesDependientes() {
    // Actualizar todas las filas de materiales que dependen de otras tablas
    document.querySelectorAll('.fila-materiales').forEach(fila => {
        const categoriaSelect = fila.querySelector('.categoria-material');
        if (categoriaSelect && categoriaSelect.value) {
            // Simular el cambio para actualizar los valores
            cambiarTipoMaterial(categoriaSelect);
        }
    });
}

function verificarYCrearFilaMateriales(categoria) {
    console.log('verificarYCrearFilaMateriales - categoria:', categoria);
    const tbody = document.getElementById('tbody-materiales');

    // Buscar si ya existe una fila con esta categoría
    let filaExistente = null;
    const filasExistentes = tbody.querySelectorAll('.fila-materiales');

    filasExistentes.forEach(fila => {
        const categoriaSelect = fila.querySelector('.categoria-material');
        if (categoriaSelect && categoriaSelect.value === categoria) {
            filaExistente = fila;
        }
    });

    console.log('verificarYCrearFilaMateriales - filaExistente:', filaExistente);

    // Si no existe, crear la fila
    if (!filaExistente) {
        console.log('verificarYCrearFilaMateriales - Creando nueva fila');
        const nuevaFila = document.createElement('tr');
        nuevaFila.className = 'fila-materiales';

        nuevaFila.innerHTML = `
            <td class="table-cell-small">
                <select class="form-control table-select-small categoria-material" name="categoria_material[]" onchange="cambiarTipoMaterial(this)">
                    <option value="">Seleccionar categoría...</option>
                    <option value="CHAPAS (TABLA CHAPAS)" ${categoria === 'CHAPAS (TABLA CHAPAS)' ? 'selected' : ''}>CHAPAS (TABLA CHAPAS)</option>
                    <option value="RESTO DE MATERIA PRIMA Y TUBOS" ${categoria === 'RESTO DE MATERIA PRIMA Y TUBOS' ? 'selected' : ''}>RESTO DE MATERIA PRIMA Y TUBOS</option>
                </select>
            </td>
            <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small cantidad-materiales" name="cantidad_materiales[]" value="1" onchange="calcularFilaMateriales(this)"></td>
            <td class="table-cell-small">
                <select class="form-control table-select-small" name="unidad_materiales[]">
                    <option value="kg">kg</option>
                    <option value="m">m</option>
                    <option value="m2">m²</option>
                    <option value="m3">m³</option>
                    <option value="ud" selected>ud</option>
                    <option value="l">l</option>
                    <option value="rollo">rollo</option>
                    <option value="paquete">paquete</option>
                </select>
            </td>
            <td class="table-cell-small">
                <div class="d-flex align-items-center">
                    <input type="number" step="0.01" class="form-control table-input-small coste-unitario-materiales me-1" name="coste_unitario_materiales[]" value="0.00" onchange="calcularFilaMateriales(this)">
                    <span class="text-nowrap">€</span>
                </div>
            </td>
            <td class="table-cell-small"><span class="total-coste-materiales">0.00</span> €</td>
            <td class="table-cell-small">
                <div class="d-flex align-items-center">
                    <input type="number" step="0.01" class="form-control table-input-small precio-venta-materiales me-1" name="precio_venta_materiales[]" value="0.00" onchange="calcularFilaMateriales(this)">
                    <span class="text-nowrap">€</span>
                </div>
            </td>
            <td class="table-cell-small">10%</td>
            <td class="table-cell-small"><span class="total-venta-materiales">0.00</span> €</td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFilaMateriales(this)" title="Eliminar fila">
                    <i class="mdi mdi-delete me-1"></i>Eliminar
                </button>
            </td>
        `;

        tbody.appendChild(nuevaFila);
        filaExistente = nuevaFila;

        // Calcular automáticamente los valores de la nueva fila
        setTimeout(() => {
            const categoriaSelect = filaExistente.querySelector('.categoria-material');
            console.log('verificarYCrearFilaMateriales - Ejecutando cambiarTipoMaterial para:', categoria);

            // Forzar la ejecución de cambiarTipoMaterial
            if (categoriaSelect) {
                console.log('verificarYCrearFilaMateriales - categoriaSelect encontrado, ejecutando cambiarTipoMaterial');
                cambiarTipoMaterial(categoriaSelect);
            } else {
                console.log('verificarYCrearFilaMateriales - ERROR: No se encontró categoriaSelect');
            }
        }, 100);
    } else {
        console.log('verificarYCrearFilaMateriales - Actualizando fila existente');
        // Si ya existe, actualizar sus valores
        const categoriaSelect = filaExistente.querySelector('.categoria-material');
        cambiarTipoMaterial(categoriaSelect);
    }
}

function agregarFilaMateriales() {
    const tbody = document.getElementById('tbody-materiales');
    const nuevaFila = document.createElement('tr');
    nuevaFila.className = 'fila-materiales';

    nuevaFila.innerHTML = `
        <td class="table-cell-small">
            <select class="form-control table-select-small material-manual" name="material[]" onchange="cambiarUnidadMaterial(this)">
                <option value="">Seleccionar material...</option>
                <option value="COMERCIALES">COMERCIALES</option>
                <option value="OTROS MATERIALES">OTROS MATERIALES</option>
                <option value="MATERIAL HIDRÁULICO">MATERIAL HIDRÁULICO</option>
                <option value="MATERIAL ELÉCTRICO">MATERIAL ELÉCTRICO</option>
                <option value="IMPRIMACIÓN EPOXI + CATALIZADOR">IMPRIMACIÓN EPOXI + CATALIZADOR</option>
                <option value="PINTURA POLIURETANO + CATALIZADOR">PINTURA POLIURETANO + CATALIZADOR</option>
            </select>
        </td>
        <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small cantidad-materiales" name="cantidad_materiales[]" value="1" onchange="calcularFilaMateriales(this)"></td>
        <td class="table-cell-small">
            <select class="form-control table-select-small unidad-material" name="unidad_materiales[]">
                <option value="kg">kg</option>
                <option value="m">m</option>
                <option value="m2">m²</option>
                <option value="m3">m³</option>
                <option value="ud" selected>ud</option>
                <option value="l">l</option>
                <option value="rollo">rollo</option>
                <option value="paquete">paquete</option>
            </select>
        </td>
        <td class="table-cell-small">
            <div class="d-flex align-items-center">
                <input type="number" step="0.01" class="form-control table-input-small coste-unitario-materiales me-1" name="coste_unitario_materiales[]" value="15.00" onchange="calcularFilaMateriales(this)">
                <span class="text-nowrap">€</span>
            </div>
        </td>
        <td class="table-cell-small"><span class="total-coste-materiales">15.00</span> €</td>
        <td class="table-cell-small">
            <div class="d-flex align-items-center">
                <input type="number" step="0.01" class="form-control table-input-small precio-venta-materiales me-1" name="precio_venta_materiales[]" value="18.00" onchange="calcularFilaMateriales(this)">
                <span class="text-nowrap">€</span>
            </div>
        </td>
        <td class="table-cell-small">20%</td>
        <td class="table-cell-small"><span class="total-venta-materiales">18.00</span> €</td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFilaMateriales(this)" title="Eliminar fila">
                <i class="mdi mdi-delete me-1"></i>Eliminar
            </button>
        </td>
    `;

    tbody.appendChild(nuevaFila);
}

function eliminarFilaMateriales(button) {
    const fila = button.closest('tr');
    fila.remove();
    calcularTotalesMateriales();
}

function calcularFilaMateriales(input) {
    console.log('calcularFilaMateriales - Iniciando');
    const fila = input.closest('tr');
    const cantidad = parseFloat(fila.querySelector('.cantidad-materiales').value) || 0;
    const costeUnitario = parseFloat(fila.querySelector('.coste-unitario-materiales').value) || 0;
    const precioVenta = parseFloat(fila.querySelector('.precio-venta-materiales').value) || 0;

    const totalCoste = costeUnitario * cantidad;
    const totalVenta = precioVenta * cantidad;

    console.log('calcularFilaMateriales - cantidad:', cantidad, 'costeUnitario:', costeUnitario, 'precioVenta:', precioVenta);
    console.log('calcularFilaMateriales - totalCoste:', totalCoste, 'totalVenta:', totalVenta);

    fila.querySelector('.total-coste-materiales').textContent = totalCoste.toFixed(2);
    fila.querySelector('.total-venta-materiales').textContent = totalVenta.toFixed(2);

    calcularTotalesMateriales();
    console.log('calcularFilaMateriales - Completado');
}

function calcularTotalesMateriales() {
    let totalCoste = 0;
    let totalVenta = 0;

    document.querySelectorAll('.fila-materiales').forEach(fila => {
        const coste = parseFloat(fila.querySelector('.total-coste-materiales').textContent) || 0;
        const venta = parseFloat(fila.querySelector('.total-venta-materiales').textContent) || 0;

        totalCoste += coste;
        totalVenta += venta;
    });

    document.getElementById('coste_materiales_final').textContent = totalCoste.toFixed(2);
        document.getElementById('precio_venta_materiales_final').textContent = totalVenta.toFixed(2);

    // Actualizar resumen lateral
    calcularTotales();
}

// Funciones para manejar filas de cálculo de materiales
function agregarFilaCalculoMateriales() {
    const tbody = document.getElementById('tbody-calculo-materiales');
    const nuevaFila = document.createElement('tr');
    nuevaFila.className = 'fila-calculo-materiales';

    nuevaFila.innerHTML = `
        <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small cantidad-calculo-materiales" name="cantidad_material_empleado[]" value="1" onchange="calcularFilaCalculoMateriales(this)"></td>
        <td class="table-cell-small"><input type="text" class="form-control table-input-small" name="descripcion_material[]" value="Material adicional" onchange="calcularFilaCalculoMateriales(this)"></td>
        <td class="table-cell-small">
            <div class="d-flex align-items-center">
                <input type="number" step="0.01" class="form-control table-input-small precio-unitario-calculo-materiales me-1" name="precio_unitario_material[]" value="10.00" onchange="calcularFilaCalculoMateriales(this)">
                <span class="text-nowrap">€</span>
            </div>
        </td>
        <td class="table-cell-small"><span class="coste-partida-materiales">10.00</span> €</td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFilaCalculoMateriales(this)" title="Eliminar fila">
                <i class="mdi mdi-delete me-1"></i>Eliminar
            </button>
        </td>
    `;

    tbody.appendChild(nuevaFila);

    // Calcular inmediatamente después de añadir la fila
    setTimeout(() => {
        calcularFilaCalculoMateriales(nuevaFila.querySelector('.cantidad-calculo-materiales'));
        // Forzar verificación de materiales automáticos
        verificarYCrearFilaMateriales('RESTO DE MATERIA PRIMA Y TUBOS');
    }, 100);
}

function eliminarFilaCalculoMateriales(button) {
    const fila = button.closest('tr');
    fila.remove();
    calcularTotalesCalculoMateriales();
}

function calcularFilaCalculoMateriales(input) {
    const fila = input.closest('tr');
    const cantidad = parseFloat(fila.querySelector('.cantidad-calculo-materiales').value) || 0;
    const precioUnitario = parseFloat(fila.querySelector('.precio-unitario-calculo-materiales').value) || 0;

    const costePartida = cantidad * precioUnitario;

    fila.querySelector('.coste-partida-materiales').textContent = costePartida.toFixed(2);

    calcularTotalesCalculoMateriales();

    // Forzar verificación inmediata
    setTimeout(() => {
        verificarYCrearFilaMateriales('RESTO DE MATERIA PRIMA Y TUBOS');
    }, 50);
}

function calcularTotalesCalculoMateriales() {
    let totalCoste = 0;

    document.querySelectorAll('.fila-calculo-materiales').forEach(fila => {
        const coste = parseFloat(fila.querySelector('.coste-partida-materiales').textContent) || 0;
        totalCoste += coste;
    });

    document.getElementById('coste_total_calculo_materiales').textContent = totalCoste.toFixed(2);

    console.log('calcularTotalesCalculoMateriales - totalCoste:', totalCoste);

    // Verificar si hay datos en cálculo de materiales o tubos para crear/actualizar la fila
    const totalTubos = parseFloat(document.getElementById('total_tubos_empleados_final')?.textContent) || 0;
    console.log('calcularTotalesCalculoMateriales - totalTubos:', totalTubos);

    if (totalCoste > 0 || totalTubos > 0) {
        console.log('calcularTotalesCalculoMateriales - Llamando a verificarYCrearFilaMateriales');
        verificarYCrearFilaMateriales('RESTO DE MATERIA PRIMA Y TUBOS');
    }

    // Actualizar filas de materiales que dependen de cálculo de materiales
    actualizarMaterialesDependientes();
}

// Funciones para manejar filas de láser-tubo
function agregarFilaLaserTubo() {
    const tbody = document.getElementById('tbody-laser-tubo');
    const nuevaFila = document.createElement('tr');
    nuevaFila.className = 'fila-laser-tubo';

    nuevaFila.innerHTML = `
        <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small metros-tubos" name="metros_tubos[]" value="5" onchange="calcularFilaLaserTubo(this)"></td>
        <td class="table-cell-small"><input type="text" class="form-control table-input-small" name="descripcion_tubos[]" value="Tubo adicional" onchange="calcularFilaLaserTubo(this)"></td>
        <td class="table-cell-small">
            <div class="d-flex align-items-center">
                <input type="number" step="0.01" class="form-control table-input-small precio-metro-tubos me-1" name="precio_metro_tubos[]" value="15.00" onchange="calcularFilaLaserTubo(this)">
                <span class="text-nowrap">€/m</span>
            </div>
        </td>
        <td class="table-cell-small"><span class="total-tubos">75.00</span> €</td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFilaLaserTubo(this)" title="Eliminar fila">
                <i class="mdi mdi-delete me-1"></i>Eliminar
            </button>
        </td>
    `;

    tbody.appendChild(nuevaFila);

    // Calcular inmediatamente después de añadir la fila
    setTimeout(() => {
        calcularFilaLaserTubo(nuevaFila.querySelector('.metros-tubos'));
        // Forzar verificación de materiales automáticos
        verificarYCrearFilaMateriales('RESTO DE MATERIA PRIMA Y TUBOS');
    }, 100);
}

function eliminarFilaLaserTubo(button) {
    const fila = button.closest('tr');
    fila.remove();
    calcularTotalesLaserTubo();
}

function calcularFilaLaserTubo(input) {
    const fila = input.closest('tr');
    const metros = parseFloat(fila.querySelector('.metros-tubos').value) || 0;
    const precioMetro = parseFloat(fila.querySelector('.precio-metro-tubos').value) || 0;

    const totalTubos = metros * precioMetro;

    fila.querySelector('.total-tubos').textContent = totalTubos.toFixed(2);

    calcularTotalesLaserTubo();

    // Forzar verificación inmediata
    setTimeout(() => {
        verificarYCrearFilaMateriales('RESTO DE MATERIA PRIMA Y TUBOS');
    }, 50);
}

function calcularTotalesLaserTubo() {
    let totalTubos = 0;

    document.querySelectorAll('.fila-laser-tubo').forEach(fila => {
        const total = parseFloat(fila.querySelector('.total-tubos').textContent) || 0;
        totalTubos += total;
    });

    document.getElementById('total_tubos_empleados_final').textContent = totalTubos.toFixed(2);

    console.log('calcularTotalesLaserTubo - totalTubos:', totalTubos);

    // Verificar si hay datos en cálculo de materiales o tubos para crear/actualizar la fila
    const totalMateriales = parseFloat(document.getElementById('coste_total_calculo_materiales')?.textContent) || 0;
    console.log('calcularTotalesLaserTubo - totalMateriales:', totalMateriales);

    if (totalMateriales > 0 || totalTubos > 0) {
        console.log('calcularTotalesLaserTubo - Llamando a verificarYCrearFilaMateriales');
        verificarYCrearFilaMateriales('RESTO DE MATERIA PRIMA Y TUBOS');
    }

    // Actualizar filas de materiales que dependen de tubos
    actualizarMaterialesDependientes();
}

// Funciones para manejar filas de chapas
function agregarFilaChapas() {
    console.log('Función agregarFilaChapas ejecutada');
    const tbody = document.getElementById('tbody-chapas');
    const nuevaFila = document.createElement('tr');
    nuevaFila.className = 'fila-chapas';

    nuevaFila.innerHTML = `
        <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small cantidad-chapas" name="cantidad_chapas[]" value="1" onchange="calcularFilaChapas(this)"></td>
        <td class="table-cell-small">
            <select class="form-control table-select-small material-chapa" name="material_chapa[]" onchange="calcularFilaChapas(this)">
                <option value="">Seleccionar material...</option>
                <option value="A/C">A/C</option>
                <option value="AISI 304">AISI 304</option>
                <option value="AISI 316">AISI 316</option>
                <option value="ALUMINIO">ALUMINIO</option>
                <option value="ANODIZADO">ANODIZADO</option>
                <option value="AISI 304 BRILLO">AISI 304 BRILLO</option>
                <option value="AISI 304 SATIN">AISI 304 SATIN</option>
                <option value="AISI 316 BRI SAT">AISI 316 BRI SAT</option>
                <option value="ALUMINIO PALILLOS">ALUMINIO PALILLOS</option>
                <option value="DAMERO ITURRI (ALUMINIO)">DAMERO ITURRI (ALUMINIO)</option>
                <option value="ALUMINIO TOP-GRIP">ALUMINIO TOP-GRIP</option>
                <option value="GALVANIZADO">GALVANIZADO</option>
            </select>
        </td>
        <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small largo-chapa" name="largo_chapa_mm[]" value="200" onchange="calcularFilaChapas(this)"></td>
        <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small ancho-chapa" name="ancho_chapa_mm[]" value="970" onchange="calcularFilaChapas(this)"></td>
        <td class="table-cell-small"><input type="number" step="0.01" class="form-control table-input-small espesor-chapa" name="espesor_chapa_mm[]" value="5" onchange="calcularFilaChapas(this)"></td>
        <td class="table-cell-small"><span class="peso-chapa">0.000</span> kg</td>
        <td class="table-cell-small"><span class="coste-chapa">0.00</span> €</td>
        <td class="table-cell-small"><span class="total-chapa">0.00</span> €</td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFilaChapas(this)" title="Eliminar fila">
                <i class="mdi mdi-delete me-1"></i>Eliminar
            </button>
        </td>
    `;

    tbody.appendChild(nuevaFila);
    console.log('Nueva fila de chapas agregada correctamente');

    // Calcular inmediatamente después de añadir la fila
    setTimeout(() => {
        calcularFilaChapas(nuevaFila.querySelector('.cantidad-chapas'));
        // Forzar verificación de materiales automáticos
        verificarYCrearFilaMateriales('CHAPAS (TABLA CHAPAS)');
    }, 100);
}

function eliminarFilaChapas(button) {
    console.log('Función eliminarFilaChapas ejecutada');
    const fila = button.closest('tr');
    fila.remove();
    calcularTotalesChapas();
    console.log('Fila eliminada correctamente');
}

function calcularFilaChapas(input) {
    const fila = input.closest('tr');
    const cantidad = parseFloat(fila.querySelector('.cantidad-chapas').value) || 0;
    const material = fila.querySelector('.material-chapa').value;
    const largo = parseFloat(fila.querySelector('.largo-chapa').value) || 0;
    const ancho = parseFloat(fila.querySelector('.ancho-chapa').value) || 0;
    const espesor = parseFloat(fila.querySelector('.espesor-chapa').value) || 0;

    console.log('calcularFilaChapas - Material:', material, 'Largo:', largo, 'Ancho:', ancho, 'Espesor:', espesor);

    // Tabla de precios por kg según el material (como en el Excel)
    const preciosPorKg = {
        'A/C': 1.35,
        'AISI 304': 3.20,
        'AISI 316': 4.75,
        'ALUMINIO': 4.90,
        'ANODIZADO': 7.30,
        'AISI 304 BRILLO': 3.99,
        'AISI 304 SATIN': 3.68,
        'AISI 316 BRI SAT': 5.40,
        'ALUMINIO PALILLOS': 5.78,
        'DAMERO ITURRI (ALUMINIO)': 6.28,
        'ALUMINIO TOP-GRIP': 6.02,
        'GALVANIZADO': 1.45
    };

    // Factores de densidad según el material (como en la fórmula del Excel)
    const densidadFactores = {
        'A/C': 8,           // Acero: 8000 kg/m³ / 1000
        'AISI 304': 8,      // Acero: 8000 kg/m³ / 1000
        'AISI 316': 8,      // Acero: 8000 kg/m³ / 1000
        'ALUMINIO': 2.7,    // Aluminio: 2700 kg/m³ / 1000
        'ANODIZADO': 2.7,   // Aluminio: 2700 kg/m³ / 1000
        'AISI 304 BRILLO': 8,   // Acero: 8000 kg/m³ / 1000
        'AISI 304 SATIN': 8,    // Acero: 8000 kg/m³ / 1000
        'AISI 316 BRI SAT': 8,  // Acero: 8000 kg/m³ / 1000
        'ALUMINIO PALILLOS': 2.7,   // Aluminio: 2700 kg/m³ / 1000
        'DAMERO ITURRI (ALUMINIO)': 2.7,  // Aluminio: 2700 kg/m³ / 1000
        'ALUMINIO TOP-GRIP': 2.7,  // Aluminio: 2700 kg/m³ / 1000
        'GALVANIZADO': 8    // Acero: 8000 kg/m³ / 1000
    };

    let peso = 0;
    let coste = 0;
    let totalChapa = 0;

    if (material && largo > 0 && ancho > 0 && espesor > 0) {
        // Calcular peso según la fórmula del Excel: (LARGO/1000) * (ANCHO/1000) * ESPESOR * DENSIDAD_FACTOR
        const densidadFactor = densidadFactores[material] || 0;
        peso = (largo / 1000) * (ancho / 1000) * espesor * densidadFactor;

        // Calcular coste: PRECIO_POR_KG * PESO
        const precioPorKg = preciosPorKg[material] || 0;
        coste = peso * precioPorKg;

        // Calcular total: CANTIDAD * COSTE
        totalChapa = cantidad * coste;

        console.log('calcularFilaChapas - Cálculos:', {
            densidadFactor: densidadFactor,
            peso: peso,
            precioPorKg: precioPorKg,
            coste: coste,
            totalChapa: totalChapa
        });
    }

    // Actualizar los campos en la fila
    fila.querySelector('.peso-chapa').textContent = peso.toFixed(3);
    fila.querySelector('.coste-chapa').textContent = coste.toFixed(2);
    fila.querySelector('.total-chapa').textContent = totalChapa.toFixed(2);

    calcularTotalesChapas();

    // Forzar verificación inmediata de materiales automáticos
    setTimeout(() => {
        verificarYCrearFilaMateriales('CHAPAS (TABLA CHAPAS)');
    }, 50);
}

function calcularTotalesChapas() {
    let totalChapas = 0;
    let pesoTotal = 0;

    document.querySelectorAll('.fila-chapas').forEach(fila => {
        const cantidad = parseFloat(fila.querySelector('.cantidad-chapas').value) || 0;
        const coste = parseFloat(fila.querySelector('.coste-chapa').textContent) || 0;
        const peso = parseFloat(fila.querySelector('.peso-chapa').textContent) || 0;

        totalChapas += cantidad * coste;
        pesoTotal += cantidad * peso;
    });

    document.getElementById('total_chapas_empleadas_final').textContent = totalChapas.toFixed(2);
    document.getElementById('peso_total_kg_final').textContent = pesoTotal.toFixed(3);

    console.log('calcularTotalesChapas - totalChapas:', totalChapas, 'pesoTotal:', pesoTotal);

    // Verificar si existe la fila de CHAPAS en materiales y crearla si no existe
    if (totalChapas > 0) {
        verificarYCrearFilaMateriales('CHAPAS (TABLA CHAPAS)');
    }

    // Actualizar filas de materiales que dependen de chapas
    actualizarMaterialesDependientes();
}

function calcularTotalesProduccion() {
    let totalCoste = 0;
    let totalVenta = 0;
    let totalMinutos = 0;

    document.querySelectorAll('.fila-produccion').forEach(fila => {
        const coste = parseFloat(fila.querySelector('.total-coste').textContent) || 0;
        const venta = parseFloat(fila.querySelector('.total-venta').textContent) || 0;
        const minutos = parseFloat(fila.querySelector('.minutos').value) || 0;

        totalCoste += coste;
        totalVenta += venta;
        totalMinutos += minutos;
    });

    const totalHoras = totalMinutos / 60;

    document.getElementById('coste_produccion_final').textContent = totalCoste.toFixed(2);
    document.getElementById('precio_venta_produccion_final').textContent = totalVenta.toFixed(2);
    document.getElementById('total_horas_produccion').textContent = totalHoras.toFixed(2);

    // Actualizar resumen lateral
    calcularTotales();
}

function calcularTotales() {
    console.log('Ejecutando calcularTotales()');

    // Obtener valores de las tablas dinámicas
    const costeProduccion = parseFloat(document.getElementById('coste_produccion_final').textContent) || 0;
    const precioVentaProduccion = parseFloat(document.getElementById('precio_venta_produccion_final').textContent) || 0;
    const totalHorasProduccion = parseFloat(document.getElementById('total_horas_produccion').textContent) || 0;

    console.log('Coste Producción:', costeProduccion);
    console.log('Precio Venta Producción:', precioVentaProduccion);
    console.log('Total Horas Producción:', totalHorasProduccion);

        const costeLaser = parseFloat(document.getElementById('coste_laser_final').textContent) || 0;
    const precioVentaLaser = parseFloat(document.getElementById('precio_venta_laser_final').textContent) || 0;

    const costeServicios = parseFloat(document.getElementById('coste_otros_servicios_final').textContent) || 0;
    const precioVentaServicios = parseFloat(document.getElementById('precio_venta_otros_servicios_final').textContent) || 0;

    const costeMateriales = parseFloat(document.getElementById('coste_materiales_final').textContent) || 0;
    const precioVentaMateriales = parseFloat(document.getElementById('precio_venta_materiales_final').textContent) || 0;

    console.log('Coste Láser:', costeLaser);
    console.log('Precio Venta Láser:', precioVentaLaser);
    console.log('Coste Servicios:', costeServicios);
    console.log('Precio Venta Servicios:', precioVentaServicios);
    console.log('Coste Materiales:', costeMateriales);
    console.log('Precio Venta Materiales:', precioVentaMateriales);

    // Calcular totales generales
    const costeTotal = costeProduccion + costeLaser + costeServicios + costeMateriales;
    const precioVentaTotal = precioVentaProduccion + precioVentaLaser + precioVentaServicios + precioVentaMateriales;

    // Calcular beneficios
    const beneficioProduccion = precioVentaProduccion - costeProduccion;
    const beneficioLaser = precioVentaLaser - costeLaser;
    const beneficioServicios = precioVentaServicios - costeServicios;
    const beneficioMateriales = precioVentaMateriales - costeMateriales;

    const beneficioTotal = beneficioProduccion + beneficioLaser + beneficioServicios + beneficioMateriales;

    // Calcular porcentajes de beneficio
    const beneficioProduccionPorcentaje = costeProduccion > 0 ? (beneficioProduccion / costeProduccion) * 100 : 0;
    const beneficioLaserPorcentaje = costeLaser > 0 ? (beneficioLaser / costeLaser) * 100 : 0;
    const beneficioServiciosPorcentaje = costeServicios > 0 ? (beneficioServicios / costeServicios) * 100 : 0;
    const beneficioMaterialesPorcentaje = costeMateriales > 0 ? (beneficioMateriales / costeMateriales) * 100 : 0;
    const beneficioTotalPorcentaje = costeTotal > 0 ? (beneficioTotal / costeTotal) * 100 : 0;

    // Obtener gastos financieros
    const gastosFinancierosPorcentaje = parseFloat(document.querySelector('input[name="gastos_financieros_porcentaje"]').value) || 0;
    const gastosFinancierosValor = (precioVentaTotal * gastosFinancierosPorcentaje) / 100;

    // Calcular beneficio teórico
    const beneficioTeoricoTotal = beneficioTotal - gastosFinancierosValor;
    const beneficioTeoricoPorcentaje = costeTotal > 0 ? (beneficioTeoricoTotal / costeTotal) * 100 : 0;

    // Obtener unidades valoradas
    const unidadesValoradas = parseInt(document.querySelector('input[name="unidades_valoradas_tabla"]').value) || 1;

    // Calcular precios unitarios
    const precioVentaTeoricoUnitario = unidadesValoradas > 0 ? precioVentaTotal / unidadesValoradas : 0;
    const precioFinalUnitario = unidadesValoradas > 0 ? precioVentaTotal / unidadesValoradas : 0;

    // Obtener precio de subasta (nuevo campo)
    const precioSubastaTotal = parseFloat(document.querySelector('input[name="precio_subasta_total"]').value) || 0;
    const precioSubastaUnitario = unidadesValoradas > 0 ? precioSubastaTotal / unidadesValoradas : 0;

    // Obtener porcentaje deseado de facturación
    const porcentajeDeseadoFacturacion = parseFloat(document.querySelector('input[name="porcentaje_deseado_facturacion"]').value) || 0;

    // Calcular precio aproximado a facturar (como en el Excel)
    // El Excel usa precios de venta, no costes totales
    const baseCalculo = precioVentaProduccion + precioVentaLaser + precioVentaServicios + precioVentaMateriales;
    const precioAproxFacturar = baseCalculo / (1 - porcentajeDeseadoFacturacion / 100);

    // Calcular beneficio tras facturación (como en el Excel)
    const beneficioTrasFacturacion = precioSubastaTotal - precioAproxFacturar;

    // Calcular % beneficio respecto a la facturación (como en el Excel)
    const porcentajeBeneficioFacturacion = precioSubastaTotal > 0 ? (beneficioTrasFacturacion / precioSubastaTotal) * 100 : 0;

    // Logs de depuración para verificar cálculos
    console.log('Cálculos de facturación:');
    console.log('Coste Total:', costeTotal);
    console.log('Precio Venta Total:', precioVentaTotal);
    console.log('Precio Venta Producción:', precioVentaProduccion);
    console.log('Precio Venta Laser:', precioVentaLaser);
    console.log('Precio Venta Servicios:', precioVentaServicios);
    console.log('Precio Venta Materiales:', precioVentaMateriales);
    console.log('Base Cálculo (suma precios venta):', baseCalculo);
    console.log('Precio Subasta Total:', precioSubastaTotal);
    console.log('Precio Subasta Unitario:', precioSubastaUnitario);
    console.log('% Deseado Facturación:', porcentajeDeseadoFacturacion);
    console.log('Precio Aprox Facturar:', precioAproxFacturar);
    console.log('Beneficio Tras Facturación:', beneficioTrasFacturacion);
    console.log('% Beneficio Facturación:', porcentajeBeneficioFacturacion);

    // Actualizar resumen lateral
    document.getElementById('coste_produccion_total_resumen').textContent = costeProduccion.toFixed(2) + ' €';
    document.getElementById('precio_venta_total_produccion').textContent = precioVentaProduccion.toFixed(2) + ' €';
    document.getElementById('total_horas_produccion').textContent = totalHorasProduccion.toFixed(2) + ' h';

    document.getElementById('coste_corte_laser_total_resumen').textContent = costeLaser.toFixed(2) + ' €';
    document.getElementById('precio_venta_total_corte_laser').textContent = precioVentaLaser.toFixed(2) + ' €';

    document.getElementById('coste_otros_servicios_total_resumen').textContent = costeServicios.toFixed(2) + ' €';
    document.getElementById('precio_venta_total_otros_servicios').textContent = precioVentaServicios.toFixed(2) + ' €';

    document.getElementById('coste_materiales_total_resumen').textContent = costeMateriales.toFixed(2) + ' €';
    document.getElementById('precio_venta_total_materiales').textContent = precioVentaMateriales.toFixed(2) + ' €';

    // Actualizar beneficios
    document.getElementById('beneficio_produccion_porcentaje').textContent = beneficioProduccionPorcentaje.toFixed(2) + '% (' + beneficioProduccion.toFixed(2) + ' €)';
    document.getElementById('beneficio_corte_porcentaje').textContent = beneficioLaserPorcentaje.toFixed(2) + '% (' + beneficioLaser.toFixed(2) + ' €)';
    document.getElementById('beneficio_otros_servicios_porcentaje').textContent = beneficioServiciosPorcentaje.toFixed(2) + '% (' + beneficioServicios.toFixed(2) + ' €)';
    document.getElementById('beneficio_materiales_porcentaje').textContent = beneficioMaterialesPorcentaje.toFixed(2) + '% (' + beneficioMateriales.toFixed(2) + ' €)';

    // Actualizar gastos financieros
    document.getElementById('gastos_financieros_valor').textContent = '(' + gastosFinancierosValor.toFixed(2) + ' €)';

    // Actualizar beneficio teórico total
    document.getElementById('beneficio_teorico_total_porcentaje').textContent = beneficioTeoricoPorcentaje.toFixed(2) + '% (' + beneficioTeoricoTotal.toFixed(2) + ' €)';

    // Actualizar precios finales
    document.getElementById('precio_venta_teorico_total').textContent = precioVentaTotal.toFixed(2) + ' €';
    document.getElementById('precio_venta_teorico_unitario').textContent = precioVentaTeoricoUnitario.toFixed(2) + ' €';
    document.getElementById('precio_final_total').textContent = precioVentaTotal.toFixed(2) + ' €';
    document.getElementById('precio_final_unitario').textContent = precioFinalUnitario.toFixed(2) + ' €';

    // Actualizar precios de subasta
    document.getElementById('precio_subasta_unitario').textContent = precioSubastaUnitario.toFixed(2) + ' €';

    // Actualizar cálculos de facturación
    document.getElementById('porcentaje_beneficio_facturacion').textContent = porcentajeBeneficioFacturacion.toFixed(2) + '%';
    document.getElementById('beneficio_tras_facturacion').textContent = beneficioTrasFacturacion.toFixed(2) + ' €';
    document.getElementById('precio_aprox_facturar').textContent = precioAproxFacturar.toFixed(2) + ' €';

    console.log('Resumen lateral actualizado');
}

// Calcular totales al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded - Iniciando cálculos');

    // Calcular totales de todas las tablas
    calcularTotalesProduccion();
    calcularTotalesLaser();
    calcularTotalesServicios();
    calcularTotalesMateriales();
    calcularTotalesCalculoMateriales();
    calcularTotalesLaserTubo();
    calcularTotalesChapas();

    // Actualizar resumen lateral
    calcularTotales();

    // Verificar si hay datos en las tablas de cálculo y crear filas automáticas
    setTimeout(() => {
        console.log('DOMContentLoaded - Verificando datos existentes');

        // Usar datos del servidor para crear filas automáticas
        const filasAutomaticas = @json($datosTablas['filas_automaticas_materiales'] ?? []);
        console.log('DOMContentLoaded - filasAutomaticas del servidor:', filasAutomaticas);

        // Crear filas automáticas basadas en datos del servidor
        filasAutomaticas.forEach(categoria => {
            console.log('DOMContentLoaded - Creando fila automática:', categoria);
            verificarYCrearFilaMateriales(categoria);
        });

        // También verificar cálculos del lado del cliente como respaldo
        const totalMateriales = parseFloat(document.getElementById('coste_total_calculo_materiales')?.textContent) || 0;
        const totalTubos = parseFloat(document.getElementById('total_tubos_empleados_final')?.textContent) || 0;
        const totalChapas = parseFloat(document.getElementById('total_chapas_empleadas_final')?.textContent) || 0;

        console.log('DOMContentLoaded - totalMateriales:', totalMateriales, 'totalTubos:', totalTubos, 'totalChapas:', totalChapas);

        // Solo crear si no existen ya (verificación adicional)
        if ((totalMateriales > 0 || totalTubos > 0) && !filasAutomaticas.includes('RESTO DE MATERIA PRIMA Y TUBOS')) {
            console.log('DOMContentLoaded - Creando fila RESTO DE MATERIA PRIMA Y TUBOS (respaldo)');
            verificarYCrearFilaMateriales('RESTO DE MATERIA PRIMA Y TUBOS');
        }

        if (totalChapas > 0 && !filasAutomaticas.includes('CHAPAS (TABLA CHAPAS)')) {
            console.log('DOMContentLoaded - Creando fila CHAPAS (TABLA CHAPAS) (respaldo)');
            verificarYCrearFilaMateriales('CHAPAS (TABLA CHAPAS)');
        }

        // Recalcular totales después de crear las filas automáticas
        setTimeout(() => {
            calcularTotalesMateriales();
            calcularTotales();
        }, 200);
    }, 500);

    // Función de prueba para debuggear
    window.testMateriales = function() {
        console.log('=== PRUEBA MANUAL DE MATERIALES ===');
        const totalMateriales = parseFloat(document.getElementById('coste_total_calculo_materiales')?.textContent) || 0;
        const totalTubos = parseFloat(document.getElementById('total_tubos_empleados_final')?.textContent) || 0;
        console.log('Total Materiales:', totalMateriales);
        console.log('Total Tubos:', totalTubos);
        console.log('Suma:', totalMateriales + totalTubos);

        // Forzar creación de fila
        verificarYCrearFilaMateriales('RESTO DE MATERIA PRIMA Y TUBOS');
    };
});
</script>
@endsection
