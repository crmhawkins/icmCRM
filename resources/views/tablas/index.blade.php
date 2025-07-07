<style>
    body {
        background-color: #f2f4f7;
        color: #333;
        font-family: 'Inter', 'Segoe UI', 'Roboto', Arial, sans-serif;
    }

    .container {
        max-width: 1800px;
        margin: 0 auto;
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #222;
        border: none;
        border-radius: 6px;
        padding: 0.5rem 1.2rem;
        font-weight: 600;
        transition: background 0.2s;
        font-family: inherit;
    }
    .btn-secondary:hover {
        background: #d1d5db;
        color: #111;
    }

    table.table {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        margin-bottom: 2rem;
        border-collapse: separate;
        border-spacing: 0;
        font-family: inherit;
    }
    .table-bordered th {
        background: #111;
        color: #fff;
        font-weight: 700;
        font-size: 1rem;
        text-transform: uppercase;
        padding: 1rem 0.5rem;
        border: none;
        letter-spacing: 1px;
        font-family: inherit;
    }
    .table-bordered td {
        background: #f8fafc;
        color: #222;
        padding: 0.7rem 0.5rem;
        font-size: 1rem;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
        font-family: inherit;
    }
    .table-bordered tr:last-child td {
        border-bottom: none;
    }
    .table-bordered td strong {
        font-weight: 700;
        color: #1e293b;
    }
    .form-label {
        font-weight: 700;
        color: #222;
        text-transform: uppercase;
        font-size: 0.95rem;
        margin-bottom: 0.2rem;
        font-family: inherit;
    }
    .form-control, .form-control-sm {
        background: #f3f4f6;
        color: #222;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        box-shadow: none;
        transition: border 0.2s;
        font-size: 1rem;
        font-family: inherit;
    }
    .form-control:focus, .form-control-sm:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 0.15rem rgba(59,130,246,0.15);
    }
    .td_foot {
        display: flex;
        justify-content: space-between;
        background: #f1f5f9;
        padding: 1rem 1.25rem;
        font-size: 1.05rem;
        border-top: none;
        align-items: center;
        border-radius: 0 0 12px 12px;
        font-family: inherit;
    }
    .td_foot strong {
        margin-right: 0.5rem;
    }
    .td_foot input {
        width: 80px !important;
        text-align: center;
        background: #fff;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        font-weight: 600;
        font-family: inherit;
    }
    .td_foot span {
        margin-left: 0.2rem;
    }
    .fw-bold {
        font-weight: 700;
    }
    .text-primary {
        color: #2563eb;
    }
    .read_only {
        background: transparent !important;
        border: none !important;
        box-shadow: none;
        text-align: right;
        font-weight: normal;
        color: inherit;
        padding: 0;
        width: 100%;
        pointer-events: none;
        font-family: inherit;
    }
    input[readonly] {
        background: transparent !important;
        border: none !important;
        pointer-events: none;
        font-family: inherit;
    }
    .total-coste, .beneficio, .total-venta {
        text-align: right !important;
    }
    /* Mejorar la visualización de los inputs */
    input[type="text"], input[type="number"], input[type="numeric"] {
        padding: 0.3rem 0.5rem;
        font-size: 1rem;
        border-radius: 4px;
        border: 1px solid #d1d5db;
        background: #f9fafb;
        transition: border 0.2s;
        font-family: inherit;
    }
    input[type="text"][readonly], input[type="number"][readonly], input[type="numeric"][readonly] {
        border: none !important;
        background: transparent !important;
        color: #222;
        font-weight: 600;
    }
    input[type="text"]:focus, input[type="number"]:focus, input[type="numeric"]:focus {
        border-color: #2563eb;
        background: #fff;
    }
    /* Encabezados de secciones */
    h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1e293b;
        margin: 2rem 0 1rem 0;
        letter-spacing: 1px;
        font-family: inherit;
    }
    /* Responsive */
    @media (max-width: 1200px) {
        .container {
            max-width: 98vw;
        }
        table.table {
            font-size: 0.95rem;
        }
    }

    .css-96uzu9 {
        z-index: -1;
    }

    .form-label {
        font-weight: 600;
        color: black;
        text-transform: uppercase;
        font-size: 0.85rem;
    }

    .form-control, .form-control-sm {
        background-color: #ffffff;
        color: #333;
        border: 1px solidrgb(0, 0, 0);
        border-radius: 6px;
        box-shadow: none;
        transition: all 0.2s ease-in-out;
    }

    .form-control:focus, .form-control-sm:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }

    .table {
        background-color: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
    }

    .table-bordered th {
        background-color: #000000;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        padding: 0.75rem;
        border: none;
    }

    .table-bordered td {
        background-color: #f8fafc;
        color: #333;
        padding: 0.5rem;
        font-size: 0.9rem;
    }

    .table-bordered td strong {
        font-weight: 600;
        color: #1e293b;
    }

    .btn-primary {
        background-color: #3b82f6;
        border-color: #3b82f6;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 6px;
        transition: background-color 0.2s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #2563eb;
        border-color: #2563eb;
    }

    .form-section {
        margin-bottom: 2rem;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    tfoot td, tfoot th {
        padding: 0.75rem;
        vertical-align: middle;
        font-size: 0.9rem;
        color: #111;
    }

    tfoot .text-end {
        text-align: right;
    }

    tfoot .fw-bold {
        font-weight: 600;
    }

    tfoot .fw-semibold {
        font-weight: 500;
    }

    tfoot .fs-5 {
        font-size: 1rem;
    }

    tfoot .text-primary {
        color: #2563eb;
    }

    .bg-light {
        background-color:rgb(255, 255, 255) !important;
    }

    .td_foot {
        display: flex;
        justify-content: space-between;
        background-color: #f8f9fa;
        padding: 1rem 1.25rem;
        font-size: 0.95rem;
        border-top: none;
        align-items: center;
    }

    .td_foot div {
        display: flex;
        align-items: center;
    }

    .td_foot strong {
        margin-right: 0.5rem;  /* Ajusta este valor para reducir el espacio */
    }

    .td_foot input {
        width: 60px !important;
        text-align: center;
    }

    .td_foot span {
        margin-left: 0.2rem; /* Ajusta este margen para tener un buen espaciado */
    }

    .fw-bold {
        font-weight: 600;
    }

    .text-primary {
        color: #2563eb;
    }

    .read_only {
        background-color: transparent !important;
        border: none;
        box-shadow: none;
        text-align: right;
        font-weight: normal;
        color: inherit;
        padding: 0;
        width: 100%;
        pointer-events: none; /* Desactiva la interactividad */
    }

    input[readonly] {
        background-color: transparent !important;
        pointer-events: none
    }

    .total-coste, .beneficio, .total-venta {
        text-align: right !important;
    }

    .contenedor_principal {
        max-width: 3000px;
        display: flex;
        flex-direction: row;

        gap: 10rem;
    }

    .column {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        width: 120rem;
    }

    .column2 {
        display: flex;
        flex-direction: column;
        width: 120rem;
        margin-left: -50% !important; 
    }

    .row {
        display: flex;
        flex-direction: row;
        gap: 1.5rem;
        width: 100%;
    }

    .row2 {
        display: flex;
        flex-direction: row;
        width: 100%;
    }

    .mg-top {
        margin-top: 1.5rem;
    }

    .text-right {
        text-align: right;
    }

    .text-left {
        text-align: left;
    }

    .text-center {
        text-align: center;
    }
    
</style>

<div class="container p-4 bg-white rounded" style="margin: 3rem 3rem 3rem 3rem;">
    <div class="container" style="margin-top: 1.5rem;">
        <a href="/projects" class="btn btn-secondary">
            <i class="fas fa-home me-2"></i>Proyectos
        </a>
    </div>
    <form id="tablas-form" action="{{ route('tablas.guardar', $project->id)}}" method="POST">
        <div class="contenedor_principal">
            @csrf
            <div class="column mg-top">
                <div class="row form-section">
                    <div class="col">
                        <label class="form-label">REFERENCIA ICM</label>
                        <input type="text" name="referencia" class="form-control" value="{{ $data->referencia ?? '' }}">
                    </div>
                    <div class="col">
                        <label class="form-label">PEDIDO CLIENTE</label>
                        <input type="text" name="pedido_cliente" class="form-control" value="{{ $project->name }}" readonly>
                    </div>
                    <div class="col">
                        <label class="form-label">CLIENTE</label>
                        <input type="text" name="cliente" class="form-control" value="{{ $client->name }}" readonly>
                    </div>
                    <div class="col">
                        <label class="form-label">ARTÍCULO</label>
                        <input type="text" name="articulo" class="form-control" value="{{ $data->articulo ?? '' }}">
                    </div>
                    <div class="col">
                        <label class="form-label">REVISIÓN</label>
                        <input type="text" name="revision" class="form-control" value="{{ $data->revision ?? '' }}">
                    </div>
                </div>

                <table class="table table-bordered table-sm text-center align-middle">
                    <thead>
                        <tr>
                            <th>TRABAJOS DE PRODUCCIÓN</th>
                            <th>UNIDAD</th>
                            <th>COSTE UNITARIO (€/h)</th>
                            <th>TOTAL COSTE</th>
                            <th style="white-space: nowrap; font-size: 0.95rem;">
                                PRECIO VENTA UNITARIO (€/H)
                            </th>
                            <th>BENEFICIO</th>
                            <th>TOTAL VENTA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $trabajos = [
                                'CIZALLA Y/O PLEGADORA',
                                'CORTE DE SIERRA',
                                'MONTAJE DE PIEZAS PUNT.',
                                'TORNO Y FRESA',
                                'SOLDADURA A/C',
                                'SOLDADURA ALUMINIO',
                                'SOLDADURA INOX',
                                'CHORREADO Y LIMPIEZA',
                                'TERMINACIÓN Y PINTURA',
                                'VERIFICACIÓN',
                                'EMBALAJE',
                                'TÉCNICOS',
                                'MONTAJE EN OBRA',
                                'MONTAJE ELÉCTRICO E HIDRÁULICO',
                                'SUMATORIO DE TIEMPOS (SI NO HAY DESGLOSE)',
                            ];

                            // Costes y precios por defecto (índice coincidente con $trabajos)
                            $valores = [
                                ['coste' => 32.05, 'venta' => 39.60],
                                ['coste' => 32.05, 'venta' => 37.80],
                                ['coste' => 32.05, 'venta' => 39.60],
                                ['coste' => 32.80, 'venta' => 43.00],
                                ['coste' => 32.80, 'venta' => 39.60],
                                ['coste' => 33.80, 'venta' => 39.60],
                                ['coste' => 33.80, 'venta' => 39.60],
                                ['coste' => 32.05, 'venta' => 39.60],
                                ['coste' => 27.30, 'venta' => 39.60],
                                ['coste' => 27.30, 'venta' => 35.00],
                                ['coste' => 32.05, 'venta' => 39.60],
                                ['coste' => 33.80, 'venta' => 39.60],
                                ['coste' => 32.80, 'venta' => 39.60],
                                ['coste' => 32.80, 'venta' => 39.60],
                                ['coste' => 31.90, 'venta' => 37.50],
                            ];
                        @endphp

                        @foreach ($trabajos as $i => $nombre)
                        @php
                            $trabajo = $data->trabajos[$i] ?? null;
                        @endphp
                        <tr>
                            <td class="text-left">
                                <strong>{{ $nombre }}</strong>
                                <input type="hidden" name="trabajos[{{ $i }}][nombre]" value="{{ $nombre }}">
                            </td>
                            <td>
                                <input type="number" id="produccion_minutos_{{ $i }}" name="trabajos[{{ $i }}][minutos]" class="form-control form-control-sm text-end" min="0" value="{{ $trabajo['minutos'] ?? 0 }}">
                            </td>
                            <td>
                                <input type="text" id="produccion_coste_unitario_{{ $i }}" step="0.01" name="trabajos[{{ $i }}][coste_unitario]" class="form-control form-control-sm text-end" min="0" value="{{ sprintf('%.2f', $trabajo['coste_unitario'] ?? $valores[$i]['coste']) }}">
                            </td>
                            <td>
                                <input type="number" readonly class="total-coste" id="produccion_total_coste_{{ $i }}" name="trabajos[{{ $i }}][total_coste]" value="0.00">
                            </td>
                            <td>
                                <input type="numeric" id="produccion_precio_venta_unitario_{{ $i }}" step="0.01" name="trabajos[{{ $i }}][precio_venta_unitario]" class="form-control form-control-sm text-end" min="0" value="{{ sprintf('%.2f', $trabajo['precio_venta_unitario'] ?? $valores[$i]['venta']) }}">
                            </td>
                            <td>
                                <input type="numeric" readonly class="beneficio" id="produccion_beneficio_{{ $i }}" name="trabajos[{{ $i }}][beneficio]" value="{{ sprintf('%.1f', $trabajo['beneficio'] ?? 0) }}">
                            </td>
                            <td>
                                <input type="text" readonly class="total-venta" id="produccion_total_venta_{{ $i }}" name="trabajos[{{ $i }}][total_venta]" value="{{ sprintf('%.2f', $trabajo['total_venta'] ?? 0.00) }}">
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" style="padding: 0;">
                                <div class="td_foot">
                                    <div>
                                        <strong>TOTAL HORAS:</strong>
                                        <input type="text" id="produccion_total-horas" name="total_horas" value ="0.00" readonly>
                                    </div>
                                    <div>
                                        <strong>COSTE PRODUCCIÓN:</strong>
                                        <input type="text" id="produccion_coste-total" name="coste_total" value="0.00" readonly>
                                    </div>

                                    <div>
                                        <strong>PRECIO VENTA TOTAL:</strong>
                                        <input type="text" id="produccion_venta-total" name="venta_total" value="0.00" class="text-primary fw-bold" readonly>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                {{-- Tabla de cortes --}}
                <table class="table table-bordered table-sm text-center align-middle">
                    <thead>
                        <tr>
                            <th>TRABAJOS DE CORTE POR LASER - AGUA</th>
                            <th>UNIDAD</th>
                            <th style="white-space: nowrap; font-size: 0.95rem;">
                                COSTE UNITARIO (€/h)
                            </th>
                            <th>TOTAL COSTE</th>
                            <th style="white-space: nowrap; font-size: 0.95rem;">
                                PRECIO VENTA UNITARIO (€/H)
                            </th>
                            <th>BENEFICIO</th>
                            <th>TOTAL VENTA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $cortes = [
                                'LASER INOX 0 - 3 MM',
                                'LASER INOX 4 - 6 MM',
                                'LASER INOX 8 - 10 MM',
                                'LASER INOX 12 MM',
                                'LASER A/C 0 - 15 MM',
                                'LASER ALUM 0 - 3 MM',
                                'LASER INOX 4 - 6 MM',
                                'LASER-TUBO INOXIDABLE',
                                'LASER-TUBO ACERO AL CARBONO',
                                'LASER-TUBO ALUMINIO',
                                'AGUA SIMPLE CABEZAL',
                                'AGUA DOBLE CABEZAL',
                            ];

                        @endphp

                        @foreach ($cortes as $i => $nombre)
                            @php
                                $corte = $data->cortes[$i] ?? null;
                            @endphp
                            <tr>
                                <td class="text-left">
                                    <strong class="text-left">{{ $nombre }}</strong>
                                    <input type="hidden" name="cortes[{{ $i }}][nombre]" value="{{ $nombre }}">
                                </td>
                                <td>
                                    <input type="number" id="cortes_minutos_{{ $i }}" name="cortes[{{ $i }}][minutos]" class="form-control form-control-sm text-end" min="0" value="{{ $corte['minutos'] ?? 0 }}">
                                </td>
                                <td>
                                    <input type="text" id="cortes_coste_unitario_{{ $i }}" step="0.01" name="cortes[{{ $i }}][coste_unitario]" class="form-control form-control-sm text-end" min="0" value="{{ sprintf('%.2f', $corte['coste_unitario'] ?? 0.00) }}">
                                </td>
                                <td>
                                    <input type="number" readonly class="total-coste rdonly" id="cortes_total_coste_{{ $i }}" name="cortes[{{ $i }}][total_coste]" value="{{ sprintf('%.2f', $corte['total_coste'] ?? 0.00) }}">
                                </td>
                                <td>
                                    <input type="numeric" id="cortes_precio_venta_unitario_{{ $i }}" step="0.01" name="cortes[{{ $i }}][precio_venta_unitario]" class="form-control form-control-sm text-end" min="0" value="{{ sprintf('%.2f', $corte['precio_venta_unitario'] ?? 0.00) }}">
                                </td>
                                <td>
                                    <input type="numeric" readonly class="beneficio rdonly" id="cortes_beneficio_{{ $i }}" name="cortes[{{ $i }}][beneficio]" value="{{ sprintf('%.1f', $corte['beneficio'] ?? 0) }}">
                                </td>
                                <td>
                                    <input type="text" readonly class="total-venta rdonly" id="cortes_total_venta_{{ $i }}" name="cortes[{{ $i }}][total_venta]" value="{{ sprintf('%.2f', $corte['total_venta'] ?? 0.00) }}">
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" style="padding: 0;">
                                <div class="td_foot">
                                    <div>
                                        <strong>COSTE CORTE LASER-AGUA:</strong>
                                        <input type="text" id="cortes_coste-total" name="coste_total_corte" value="0.00" class="rdonly" readonly>
                                    </div>

                                    <div>
                                        <strong>PRECIO VENTA TOTAL:</strong>
                                        <input type="text" id="cortes_venta-total" name="venta_total_corte" value="0.00" class="text-primary fw-bold rdonly" readonly>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                {{-- Tabla de otros --}}
                <table class="table table-bordered table-sm text-center align-middle">
                    <thead>
                        <tr>
                            <th>OTROS SERVICIOS</th>
                            <th>UNIDAD</th>
                            <th style="white-space: nowrap; font-size: 0.95rem;">
                                COSTE UNITARIO (€/h)
                            </th>
                            <th>TOTAL COSTE</th>
                            <th style="white-space: nowrap; font-size: 0.95rem;">
                                PRECIO VENTA UNITARIO (€/H)
                            </th>
                            <th>BENEFICIO</th>
                            <th>TOTAL VENTA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $trabajos = [
                                'PORTES, GRUAS Y/O DIETAS',
                                'PINTURA Y/O CHORREADO (SUBCONTRATACION)',
                                'HIDRAULICA Y/O ELECTRICIDAD (SUBCONTRATACION)',
                                'MECANIZADO (SUBCONTRATACION)',
                                'OTROS (SUBCONTRATACION)',
                                'OTROS',
                            ];

                        @endphp

                        @foreach ($trabajos as $i => $nombre)
                            @php
                                $otro = $data->otros[$i] ?? null;
                            @endphp
                            <tr>
                                <td class="text-left">
                                    <strong>{{ $nombre }}</strong>
                                    <input type="hidden" name="otros[{{ $i }}][nombre]" value="{{ $nombre }}">
                                </td>
                                <td>
                                    <input type="number" id="otros_minutos_{{ $i }}" name="otros[{{ $i }}][minutos]" class="form-control form-control-sm text-end" min="0" value="{{ $otro['minutos'] ?? 0 }}">
                                </td>
                                <td>
                                    <input type="text" id="otros_coste_unitario_{{ $i }}" step="0.01" name="otros[{{ $i }}][coste_unitario]" class="form-control form-control-sm text-end" min="0" value="{{ sprintf('%.2f', $otro['coste_unitario'] ?? 0.00) }}">
                                </td>
                                <td>
                                    <input type="number" readonly class="total-coste rdonly" id="otros_total_coste_{{ $i }}" name="otros[{{ $i }}][total_coste]" value="{{ sprintf('%.2f', $otro['total_coste'] ?? 0.00) }}">
                                </td>
                                <td>
                                    <input type="numeric" id="otros_precio_venta_unitario_{{ $i }}" step="0.01" name="otros[{{ $i }}][precio_venta_unitario]" class="form-control form-control-sm text-end" min="0" value="{{ sprintf('%.2f', $otro['precio_venta_unitario'] ?? 0.00) }}">
                                </td>
                                <td>
                                    <input type="numeric" readonly class="beneficio rdonly" id="otros_beneficio_{{ $i }}" name="otros[{{ $i }}][beneficio]" value="{{ sprintf('%.1f', $otro['beneficio'] ?? 0) }}">
                                </td>
                                <td>
                                    <input type="text" readonly class="total-venta rdonly" id="otros_total_venta_{{ $i }}" name="otros[{{ $i }}][total_venta]" value="{{ sprintf('%.2f', $otro['total_venta'] ?? 0.00) }}">
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" style="padding: 0;">
                                <div class="td_foot">
                                    <div>
                                        <strong>COSTE OTROS SERVICIOS:</strong>
                                        <input type="text" id="otros_coste-total" name="coste_total_otros" value="0.00" class="rdonly" readonly>
                                    </div>

                                    <div>
                                        <strong>PRECIO VENTA TOTAL:</strong>
                                        <input type="text" id="otros_venta-total" name="venta_total_otros" value="0.00" class="text-primary fw-bold rdonly" readonly>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                {{-- Tabla de materiales --}}
                <table class="table table-bordered table-sm text-center align-middle">
                    <thead>
                        <tr>
                            <th>MATERIALES</th>
                            <th>UNIDAD</th>
                            <th style="white-space: nowrap; font-size: 0.95rem;">COSTE UNITARIO (€/h)</th>
                            <th>TOTAL COSTE</th>
                            <th style="white-space: nowrap; font-size: 0.95rem;">PRECIO VENTA UNITARIO (€/H)</th>
                            <th>BENEFICIO</th>
                            <th>TOTAL VENTA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $trabajos = [
                                'CHAPAS (TABLA CHAPAS)',
                                'RESTO DE MATERIA PRIMA Y TUBOS',
                                'COMERCIALES',
                                'OTROS MATERIALES',
                                'MATERIAL HIDRÁULICO',
                                'MATERIAL ELÉCTRICO',
                                'IMPRIMACIÓN EPOXI + CATALIZADOR',
                                'PINTURA POLIURETANO + CATALIZADOR',
                            ];
                        @endphp

                        @foreach ($trabajos as $i => $nombre)
                            @php
                                $material = $data->materiales[$i] ?? null;
                            @endphp
                            <tr>
                                <td class="text-left">
                                    <strong>{{ $nombre }}</strong>
                                    <input type="hidden" name="materiales[{{ $i }}][nombre]" value="{{ $nombre }}">
                                </td>
                                <td>
                                    <input type="number" id="materiales_minutos_{{ $i }}" name="materiales[{{ $i }}][minutos]" class="form-control form-control-sm text-end" min="0" value="{{ $material['minutos'] ?? 0 }}">
                                </td>
                                <td>
                                    @if ($nombre === 'CHAPAS (TABLA CHAPAS)' || $nombre === 'RESTO DE MATERIA PRIMA Y TUBOS')
                                        <input type="text" readonly id="materiales_coste_unitario_{{ $i }}" step="0.01" name="materiales[{{ $i }}][coste_unitario]" class="text-right text-primary fw-bold rdonly" min="0" value="{{ sprintf('%.2f', $material['coste_unitario'] ?? 0.00) }}">
                                    @else
                                        <input type="text" id="materiales_coste_unitario_{{ $i }}" step="0.01" name="materiales[{{ $i }}][coste_unitario]" class="form-control form-control-sm text-end" min="0" value="{{ sprintf('%.2f', $material['coste_unitario'] ?? 0.00) }}">
                                    @endif
                                </td>
                                <td>
                                    <input type="number" readonly class="total-coste rdonly" id="materiales_total_coste_{{ $i }}" name="materiales[{{ $i }}][total_coste]" value="{{ sprintf('%.2f', $material['total_coste'] ?? 0.00) }}">
                                </td>
                                <td>
                                    <input type="number" id="materiales_precio_venta_unitario_{{ $i }}" step="0.01" name="materiales[{{ $i }}][precio_venta_unitario]" class="form-control form-control-sm text-end" min="0" value="{{ sprintf('%.2f', $material['precio_venta_unitario'] ?? 0.00) }}">
                                </td>
                                <td>
                                    <input type="number" readonly class="beneficio rdonly" id="materiales_beneficio_{{ $i }}" name="materiales[{{ $i }}][beneficio]" value="{{ sprintf('%.1f', $material['beneficio'] ?? 0) }}">
                                </td>
                                <td>
                                    <input type="text" readonly class="total-venta rdonly" id="materiales_total_venta_{{ $i }}" name="materiales[{{ $i }}][total_venta]" value="{{ sprintf('%.2f', $material['total_venta'] ?? 0.00) }}">
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" style="padding: 0;">
                                <div class="td_foot">
                                    <div>
                                        <strong>COSTE MATERIALES:</strong>
                                        <input type="text" id="materiales_coste-total" name="coste_total_materiales" value="0.00" class="rdonly" readonly>
                                    </div>

                                    <div>
                                        <strong>PRECIO VENTA TOTAL:</strong>
                                        <input type="text" id="materiales_venta-total" name="venta_total_materiales" value="0.00" class="text-primary fw-bold rdonly" readonly>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                {{-- Tablas de precios --}}
                <div class="row">
                    <div class="column">
                        @php
                            $precio_metro = $data->precio_metro;
                        @endphp

                        <!-- PRECIO €/m -->
                        <table class="table table-bordered table-sm text-center align-middle" style="min-width:220px;">
                            <thead>
                                <tr><th colspan="2" class="black text-white">PRECIO €/m</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-left">
                                        Longitud unitaria de la pieza (m)
                                    </td>
                                    <td>
                                        <input type="text" id="longitud_unitaria-metro" name="longitud_unitaria_metro" value=" {{ $precio_metro['longitud_unitaria_metro'] ?? 0.00 }} " class="form-control form-control-sm text-center fw-bold bg_transparent border_transparent">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-transparent"></td>
                                    <td style="width: 150px;">
                                        <input type="text" id="total_unitaria-metro" name="total_unitaria_metro" value=" {{ $precio_metro['total_metro'] ?? 0.00 }} " class="text-center text-primary fw-bold" readonly>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        @php
                            $precio_kg = $data->precio_kg;
                        @endphp

                        <!-- PRECIO €/kg -->
                        <table class="table table-bordered table-sm text-center align-middle" style="min-width:220px;">
                            <thead>
                                <tr><th colspan="2" class="black text-white">PRECIO €/m</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-left">
                                        Peso unitario de la pieza (kg)
                                    </td>
                                    <td>
                                        <input type="text" id="longitud_unitaria-peso" name="longitud_unitaria_peso" value=" {{ $precio_kg['longitud_unitaria_peso'] ?? 0.00 }} " class="form-control form-control-sm text-center fw-bold bg_transparent border_transparent">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-transparent"></td>
                                    <td style="width: 150px;">
                                        <input type="text" id="total_unitaria-peso" name="total_unitaria_peso" value=" {{ $precio_kg['total_peso'] ?? 0.00 }} " class="text-center text-primary fw-bold" readonly>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="column">
                    
                        @php
                            $resumen_venta = $data->resumen_venta;
                        @endphp

                        <!-- RESUMEN VENTA -->
                        <table class="table table-bordered table-sm text-center align-middle" style="min-width:350px;">
                            <thead>
                                <tr><th colspan="3" class="black text-white">RESUMEN VENTA</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-left">
                                        BENEFICIO EN PRODUCCIÓN
                                    </td>
                                    <td>
                                        <input type="text" id="beneficio_produccion-porcentaje" name="beneficio_produccion_porcentaje" value=" {{ $resumen_venta['beneficio_produccion_porcentaje'] ?? 0.00 }} " class="text-center text-primary fw-bold" readonly>
                                    </td>
                                    <td style="width: 150px;">
                                        <input type="text" id="beneficio_produccion-euro" name="beneficio_produccion_euro" value=" {{ $resumen_venta['beneficio_produccion_euro'] ?? 0.00 }} " class="text-center text-primary fw-bold" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        BENEFICIO EN CORTE
                                    </td>
                                    <td>
                                        <input type="text" id="beneficio_corte-porcentaje" name="beneficio_corte_porcentaje" value=" {{ $resumen_venta['beneficio_corte_porcentaje'] ?? 0.00 }} " class="text-center text-primary fw-bold" readonly>
                                    </td>
                                    <td style="width: 150px;">
                                        <input type="text" id="beneficio_corte-euro" name="beneficio_corte_euro" value=" {{ $resumen_venta['beneficio_corte_euro'] ?? 0.00 }} " class="text-center text-primary fw-bold" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        BENEFICIO EN OTROS SERVICIOS
                                    </td>
                                    <td>
                                        <input type="text" id="beneficio_otros-porcentaje" name="beneficio_otros_porcentaje" value=" {{ $resumen_venta['beneficio_otros_porcentaje'] ?? 0.00 }} " class="text-center text-primary fw-bold" readonly>
                                    </td>
                                    <td style="width: 150px;">
                                        <input type="text" id="beneficio_otros-euro" name="beneficio_otros_euro" value=" {{ $resumen_venta['beneficio_otros_euro'] ?? 0.00 }} " class="text-center text-primary fw-bold" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        BENEFICIO EN MATERIALES
                                    </td>
                                    <td>
                                        <input type="text" id="beneficio_materiales-porcentaje" name="beneficio_materiales_porcentaje" value=" {{ $resumen_venta['beneficio_materiales_porcentaje'] ?? 0.00 }} " class="text-center text-primary fw-bold" readonly>

                                    <td style="width: 150px;">
                                        <input type="text" id="beneficio_materiales-euro" name="beneficio_materiales_euro" value=" {{ $resumen_venta['beneficio_materiales_euro'] ?? 0.00 }} " class="text-center text-primary fw-bold" readonly>
                                    </td>
                                </tr>
                                <tr><td class="text-left">
                                    GASTOS FINANCIEROS
                                </td>
                                <td style="width: 150px;">
                                    <input type="text" id="gastos-financieros" name="gastos_financieros_porcentaje" value=" {{ $resumen_venta['gastos_financieros_porcentaje'] ?? 0.00 }} " class="form-control form-control-sm text-center fw-bold bg_transparent border_transparent">
                                </td>
                                <td>
                                    <input type="text" id="gastos_finaciero-euro" name="gastos_financieros_euro" value=" {{ $resumen_venta['gastos_financieros_euro'] ?? 0.00 }} " class="text-center text-primary fw-bold" readonly>
                                </td>
                            </tr>
                                <tr class="fw-bold"><td class="text-left">BENEFICIO TEORICO TOTAL (no material, ni financieros)</td>
                                <td>
                                    <input type="text" id="beneficio_teorico_total-porcentaje" name="beneficio_teorico_total_porcentaje" value=" {{ $resumen_venta['beneficio_teorico_total_porcentaje'] ?? 0.00 }} " class="text-center text-primary fw-bold" readonly>
                                </td>
                                <td>
                                    <input type="text" id="beneficio_teorico_total-euro" name="beneficio_teorico_total_euro" value=" {{ $resumen_venta['beneficio_teorico_total_euro'] ?? 0.00 }} " class="text-center text-primary fw-bold" readonly>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        @php
                            $precios_teoricos = $data->precios_teoricos;
                        @endphp

                        <!-- PRECIO DE VENTA TEÓRICO -->
                        <table class="table table-bordered table-sm text-center align-middle" style="min-width:250px;">
                            <thead>
                                <tr><th>TIPO</th><th>UNIDAD</th><th>TOTAL</th><th>UNITARIO</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-left">
                                        PRECIO DE VENTA TEÓRICO
                                    </td>
                                    <td></td>
                                    <td style="width: 150px;">
                                        <input type="text" id="precio_venta-total" name="precio_venta_total" value=" {{ $precios_teoricos['precio_venta_total'] ?? 0.00 }} " class="text-center text-primary fw-bold" readonly>
                                    </td>
                                    <td  style="width: 150px;">
                                        <input type="text" id="unitario-total" name="unitario_total" value=" {{ $precios_teoricos['unitario_total'] ?? 0.00 }} " class="text-center text-primary fw-bold" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        UNIDADES VALORADAS EN LA TABLA
                                    </td>
                                    <td style="width: 150px;">
                                        <input type="text" id="unidades-valoradas" name="unidades_valoradas" value="{{ $precios_teoricos['unidades_valoradas'] ?? 0 }}" class="form-control form-control-sm text-center fw-bold bg_transparent border_transparent">
                                    </td><td></td>
                                </tr>
                            </tbody>
                        </table>

                        @php
                            $precio_final = $data->precio_final;
                        @endphp

                        <!-- PRECIO FINAL -->
                        <table class="table table-bordered table-sm text-center align-middle" style="min-width:250px;">
                            <thead>
                                <tr><th>PRECIO FINAL</th><th>TOTAL</th><th>UNITARIO</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-left">SUBASTA DE PRECIO - PRECIO A FACTURAR</td>
                                    <td style="width: 150px;">
                                        <input type="number" id="subasta-total" name="subasta_total" value="{{ $precio_final['subasta_total'] ?? 0.00 }}" class="form-control form-control-sm text-center fw-bold bg_transparent border_transparent">
                                    </td>
                                    <td>
                                        <input type="text" id="subasta-unitario" name="subasta_unitario" value="{{ $precio_final['subasta_unitario'] ?? 0.00 }}" class="text-center text-primary fw-bold" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">% BENEFICIO RESPECTO A LA FACTURACION</td>
                                    <td>
                                        <input type="text" id="porcentaje_beneficio-total" name="porcentaje_beneficio_total" value="{{ $precio_final['porcentaje_beneficio'] ?? 0.00 }}" class="text-center text-primary fw-bold" readonly>
                                    </td>
                                    <td>
                                <tr>
                                    <td class="text-left">
                                        € BENEFICIO TRAS FACTURACION
                                    </td>
                                    <td>
                                        <input type="text" id="euro_beneficio-total" name="euro_beneficio_total" value="{{ $precio_final['euro_beneficio'] ?? 0.00 }}" class="text-center text-primary fw-bold" readonly>
                                    </td>
                            </tbody>
                        </table>
            
                        @php
                            $apoyo_facturar = $data->apoyo_facturar;
                        @endphp

                        <!-- APOYO PARA FACTURAR A UN % DETERMINADO -->
                        <table class="table table-bordered table-sm text-center align-middle" style="min-width:250px;">
                            <thead>
                                <tr><th colspan="2" class="black text-white">APOYO PARA FACTURAR A UN % DETERMINADO</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-left">% DESEADO</td>
                                    <td style="width: 150px;">
                                        <input type="number" id="porcentaje_deseado" name="porcentaje_deseado" value="{{ $apoyo_facturar['porcentaje_deseado'] ?? 0.00 }}" class="form-control form-control-sm text-center fw-bold bg_transparent border_transparent">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">PRECIO APROX A FACTURAR</td>
                                    <td>
                                        <input type="text" id="precio_aproximado-facturar" name="precio_aproximado_facturar" value="{{ $apoyo_facturar['precio_aproximado'] ?? 0.00 }}" class="text-center text-primary fw-bold" readonly>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row2" style="margin-top: 2.3rem;">
                <div class="column">
                    <div class="d-flex flex-wrap gap-4 mb-4">
                        <h3 class="text-left w-100">CALCULO DE MATERIALES</h3>
                        <table class="table table-bordered table-sm text-center align-middle" style="min-width:250px;">
                            <thead>
                                <tr>
                                    <th class="black text-white">UD</th>
                                    <th class="black text-white">DESCRIPCIÓN</th>
                                    <th class="black text-white">PRECIO UNITARIO</th>
                                    <th class="black text-white">COSTE PARTIDA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    for ($i = 0; $i < 24; $i++) {
                                        $material = $data->calculo_materiales[$i] ?? null;
                                @endphp
                                
                                <tr>
                                    <td style="display: flex; justify-content: center; align-items: center;">
                                        <input style="width: 150px;" type="text" id="calculo_materiales_unidad_{{ $i }}" name="calculo_materiales[{{ $i }}][unidad]" value="{{ $material['unidad'] ?? '0' }}" class="form-control form-control-sm text-right">
                                    </td>
                                    <td>
                                        <input type="text" id="calculo_materiales_descripcion_{{ $i }}" name="calculo_materiales[{{ $i }}][descripcion]" value="{{ $material['descripcion'] ?? '' }}" class="form-control form-control-sm text-center">
                                    </td>
                                    <td style="display: flex; justify-content: center; align-items: center;"> 
                                        <input style="width: 150px;" type="text" id="calculo_materiales_precio_unitario_{{ $i }}" name="calculo_materiales[{{ $i }}][precio_unitario]" value="{{ sprintf('%.2f', $material['precio_unitario'] ?? 0.00) }}" class="form-control form-control-sm text-end">
                                    </td>
                                    <td>
                                        <input style="width: 150px;" type="text" id="calculo_materiales_coste_partida_{{ $i }}" name="calculo_materiales[{{ $i }}][coste_partida]" value="{{ sprintf('%.2f', $material['coste_partida'] ?? 0.00) }}" class="text-right text-primary fw-bold" readonly>
                                    </td>
                                </tr>
                                @php
                                    }
                                @endphp
                            </tbody>
                            <tfooter>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end">   
                                        <strong>TOTAL DE MATERIAL EMPLEADO:</strong>
                                    </td>
                                    <td>
                                        <input style="width: 150px;" type="text" id="calculo_materiales-total" name="calculo_materiales_total" value="{{ $data->calculo_materiales_total ?? '0.00' }}" class="text-primary fw-bold rdonly text-right" readonly>
                                    </td>
                                </tr>
                            </tfooter>
                        </table>

                        <h3 class="text-left w-100">CALCULO DE MATERIAL PARA LASER-TUBO</h3>
                        <table class="table table-bordered table-sm text-center align-middle" style="min-width:250px;">
                            <thead>
                                <tr>
                                    <th class="black text-white">METROS</th>
                                    <th class="black text-white">DESCRIPCIÓN</th>
                                    <th class="black text-white">PRECIO €/m</th>
                                    <th class="black text-white">COSTE PARTIDA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    for ($i = 0; $i < 12; $i++) {
                                        $material = $data->calculo_materiales_laser[$i] ?? null;
                                @endphp
                                
                                <tr>
                                    <td style="display: flex; justify-content: center; align-items: center;">
                                        <input style="width: 150px;" type="text" id="calculo_materiales_laser_metros_{{ $i }}" name="calculo_material_laser[{{ $i }}][metros]" value="{{ $material['metros'] ?? '0' }}" class="form-control form-control-sm text-right">
                                    </td>
                                    <td>
                                        <input type="text" id="calculo_materiales_laser_descripcion_{{ $i }}" name="calculo_material_laser[{{ $i }}][descripcion]" value="{{ $material['descripcion'] ?? '' }}" class="form-control form-control-sm text-center">
                                    </td>
                                    <td style="display: flex; justify-content: center; align-items: center;"> 
                                            <input style="width: 150px;" type="text" id="calculo_materiales_laser_precio_metro_{{ $i }}" name="calculo_material_laser[{{ $i }}][precio_metro]" value="{{ sprintf('%.2f', $material['precio_metro'] ?? 0.00) }}" class="form-control form-control-sm text-end">
                                        </td>
                                    <td>
                                        <input style="width: 150px;" type="text" id="calculo_materiales_laser_costepartida_{{ $i }}" name="calculo_material_laser[{{ $i }}][coste_partida]" value="{{ sprintf('%.2f', $material['coste_partida'] ?? 0.00) }}" class="text-right text-primary fw-bold" readonly>
                                    </td>
                                </tr>
                                @php
                                    }
                                @endphp
                            </tbody>
                            <tfooter>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end">
                                        <strong>TOTAL TUBOS EMPLEADOS:</strong>
                                    </td>
                                    <td>
                                        <input style="width: 150px;" type="text" id="calculo_materiales_laser_total" name="calculo_materiales_laser_total" value="{{ $data->calculo_materiales_laser_total ?? '0.00' }}" class="text-primary fw-bold rdonly text-right" readonly>
                                    </td>
                                </tr>
                            </tfooter>
                        </table>

                        <table class="table table-bordered table-sm text-center align-middle" style="min-width:250px;">
                            <tbody>
                                <tr>
                                    <td class="text-start">
                                        <strong><i>¿CUÁNTOS TIPOS DIFERENTES DE TUBOS HAY QUE CORTAR EN LÁSER?</i></strong>
                                    </td>
                                    <td>
                                        <input style="width: 80px;" type="text" name="tipos_tubos_laser" id="tipos_tubos_laser" value="{{ $data->tipos_tubos_laser ?? '0' }}" class="text-primary fw-bold rdonly text-right" readonly>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h3 class="text-left w-100">CALCULO DE PRECIOS DE CHAPAS</h3>
                        <table class="table table-bordered table-sm text-center align-middle" style="min-width:250px;">
                            <thead>
                                <tr>
                                    <th class="black text-white">UD</th>
                                    <th class="black text-white">CHAPA</th>
                                    <th class="black text-white">LARGO</th>
                                    <th class="black text-white">X</th>
                                    <th class="black text-white">ANCHO</th>
                                    <th class="black text-white">X</th>
                                    <th class="black text-white">ESPESOR</th>
                                    <th class="black text-white">MATERIAL</th>
                                    <th class="black text-white">COSTE</th>
                                    <th class="black text-white">KG</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    for ($i = 0; $i < 20; $i++) {
                                        $chapa = $data->calculo_precios_chapas[$i] ?? null;
                                @endphp
                                <tr>
                                    <td>
                                        <input type="text" id="calculo_precios_chapas_unidad_{{ $i }}" name="calculo_precios_chapas[{{ $i }}][unidad]" value="{{ $chapa['unidad'] ?? '0' }}" class="form-control form-control-sm text-center">
                                    </td>
                                    <td>
                                        <input type="text" name="calculo_precios_chapas[{{ $i }}][chapa]" value="{{ $chapa['chapa'] ?? 'CHAPA' }}" class="form-control form-control-sm text-center">
                                    </td>
                                    <td>
                                        <input type="text" id="calculo_precios_chapas_largo_{{ $i }}" name="calculo_precios_chapas[{{ $i }}][largo]" value="{{ $chapa['largo'] ?? '0' }}" class="form-control form-control-sm text-end">
                                    </td>
                                    <td><strong>X</strong></td>
                                    <td>
                                        <input type="text" id="calculo_precios_chapas_ancho_{{ $i }}" name="calculo_precios_chapas[{{ $i }}][ancho]" value="{{ $chapa['ancho'] ?? '0' }}" class="form-control form-control-sm text-end">
                                    </td>
                                    <td><strong>X</strong></td>
                                    <td>
                                        <input type="text" id="calculo_precios_chapas_espesor_{{ $i }}" name="calculo_precios_chapas[{{ $i }}][espesor]" value="{{ $chapa['espesor'] ?? '0' }}" class="form-control form-control-sm text-end">
                                    </td>
                                    <td>
                                        <select id="calculo_precios_chapas_material_{{ $i }}" name="calculo_precios_chapas[{{ $i }}][material]" class="form-control form-control-sm text-center">
                                            @php
                                                $materiales = [
                                                    'A/C', 'AISI 304', 'AISI 316', 'ALUMINIO', 'ANODIZADO',
                                                    'AISI 304 BRILLO', 'AISI 304 SATIN', 'AISI 316 BRI SAT',
                                                    'ALUMINIO PALILLOS', 'DAMERO ITURRI (ALUMINIO)', 'ALUMINIO TOP-GRIP', 'GALVANIZADO'
                                                ];
                                                $materialSeleccionado = $chapa['material'] ?? null;
                                            @endphp
                                            <option value="">-</option>
                                            @foreach ($materiales as $mat)
                                                <option value="{{ $mat }}" @selected($materialSeleccionado == $mat)>{{ $mat }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" id="calculo_precios_chapas_coste_{{ $i }}" name="calculo_precios_chapas[{{ $i }}][coste]" value="{{ $chapa['coste'] ?? '0.00' }}" class="text-primary fw-bold rdonly text-right" readonly>
                                    </td>
                                    <td>
                                        <input type="text" id="calculo_precios_chapas_kg_{{ $i }}" name="calculo_precios_chapas[{{ $i }}][kg]" value="{{ $chapa['kg'] ?? '0' }}" class="text-primary fw-bold rdonly text-right" readonly>
                                    </td>
                                </tr>
                                @php } @endphp
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8" class="text-end"><strong>TOTAL DE CHAPAS EMPLEADAS:</strong></td>
                                    <td>
                                        <input type="text" id="calculo_precios_chapas_total_coste" name="calculo_precios_chapas_total_coste" value="{{ $data->calculo_precios_chapas_total_coste ?? '0,00 €' }}" class="text-primary fw-bold rdonly text-right" readonly>
                                    </td>
                                    <td>
                                        <input type="text" id="calculo_precios_chapas_total_kg" name="calculo_precios_chapas_total_kg" value="{{ $data->calculo_precios_chapas_total_kg ?? '0' }}" class="text-primary fw-bold rdonly text-right" readonly>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        <table class="table table-bordered table-sm text-center align-middle" style="min-width:250px;">
                            <thead>
                                <tr>
                                    <th class="black text-white text-left">COMERCIAL O TÉCNICO</th>
                                    <th class="black text-white"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select style="width:250px;" id="comercial_seleccionado" name="comercial_seleccionado" class="form-control form-control-sm text-center">
                                            @php
                                                $comercialSeleccionado = $data->comercial_seleccionado ?? null;
                                            @endphp

                                            <option value="">-</option>
                                            @foreach ($data->comerciales as $com)
                                                <option value="{{ $com['nombre'] }}" @selected($comercialSeleccionado == $com['nombre'])>
                                                    {{ $com['nombre'] }}
                                                </option>
                                            @endforeach
                                        </select>                
                                    </td>
                                    <td>
                                        <input type="text" id="tecnico_siglas" name="tecnico_siglas" value="{{ $data->tecnico_siglas ?? '' }}" class="text-primary fw-bold rdonly text-right text-black" readonly>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered table-sm text-center align-middle" style="min-width:250px;">
                            <thead>
                                <tr>
                                    <th class="black text-white text-left">FECHA DE REALIZACIÓN</th>
                                    <th class="black text-white"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input style="width: 150px;" type="text" id="fecha_realizacion" name="fecha_realizacion" value="{{ $data->fecha_realizacion }}" placeholder="dd/mm/YYYY" class="form-control form-control-sm text-center">
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="column2">
                    <h3 class="text-left w-100">MATERIALES / PRECIO COSTE</h3>
                    <table class="table table-bordered table-sm text-center align-middle" style="min-width:250px;">
                        <thead>
                            <tr>
                                <th class="black text-white">MATERIALES</th>
                                <th class="black text-white">PRECIO COSTE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $materialesDefault = [
                                    ['nombre' => 'A/C', 'precio' => '1,35'],
                                    ['nombre' => 'AISI 304', 'precio' => '3,20'],
                                    ['nombre' => 'AISI 316', 'precio' => '4,75'],
                                    ['nombre' => 'ALUMINIO', 'precio' => '4,90'],
                                    ['nombre' => 'ANODIZADO', 'precio' => '7,30'],
                                    ['nombre' => 'AISI 304 BRILLO', 'precio' => '3,99'],
                                    ['nombre' => 'AISI 304 SATIN', 'precio' => '3,68'],
                                    ['nombre' => 'AISI 316 BRI SAT', 'precio' => '5,40'],
                                    ['nombre' => 'ALUMINIO PALILLOS', 'precio' => '5,78'],
                                    ['nombre' => 'DAMERO ITURRI (ALUMINIO)', 'precio' => '6,28'],
                                    ['nombre' => 'ALUMINIO TOP-GRIP', 'precio' => '6,02'],
                                    ['nombre' => 'GALVANIZADO', 'precio' => '1,45'],
                                ];

                                $materiales = $data->materiales_precio_coste ?? $materialesDefault;
                            @endphp

                            @foreach ($materiales as $i => $mat)
                                <tr>
                                    <td>
                                        <input type="text" id="materiales_precio_coste_nombre{{ $i }}" name="materiales_precio_coste[{{ $i }}][nombre]" value="{{ $mat['nombre'] ?? '' }}" class="form-control form-control-sm text-center">
                                    </td>
                                    <td>
                                        <input type="text" id="materiales_precio_coste_precio{{ $i }}" name="materiales_precio_coste[{{ $i }}][precio]" value="{{ $mat['precio'] ?? '' }}" class="form-control form-control-sm text-end">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h3 class="text-left w-100">COMERCIAL / TÉCNICO</h3>
                    <table class="table table-bordered table-sm text-center align-middle" style="min-width:250px;">
                        <thead>
                            <tr>
                                <th class="black text-white">NOMBRE</th>
                                <th class="black text-white">CÓDIGO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $comercialesDefault = [
                                    ['nombre' => 'MIGUEL ANGEL CABALLERO', 'codigo' => 'MAC'],
                                    ['nombre' => 'JOSE ANTONIO CASTILLO', 'codigo' => 'JAC'],
                                    ['nombre' => 'NICOLAS TAPIA', 'codigo' => 'NT'],
                                    ['nombre' => 'MOISES SANTIAGO', 'codigo' => 'MS'],
                                    ['nombre' => 'ELAYN POU', 'codigo' => 'EP'],
                                    ['nombre' => 'JUANO', 'codigo' => 'JFE'],
                                    ['nombre' => 'ANZONI', 'codigo' => 'AM'],
                                    ['nombre' => 'OTRO', 'codigo' => 'OT'],
                                ];

                                $comerciales = $data->comerciales ?? $comercialesDefault;
                            @endphp

                            @foreach ($comerciales as $i => $com )
                                <tr>
                                    <td>
                                        <input type="text" id="comerciales_nombre_{{ $i }}" name="comerciales[{{ $i }}][nombre]" value="{{ $com['nombre'] ?? '' }}" class="form-control form-control-sm text-center">
                                    </td>
                                    <td>
                                        <input type="text" id="comerciales_codigo_{{ $i }}" name="comerciales[{{ $i }}][codigo]" value="{{ $com['codigo'] ?? '' }}" class="form-control form-control-sm text-center">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>

    <div class="container mt-4 mb-4">
        <div class="d-flex justify-content-end">
            <button type="submit" form="tablas-form" class="btn btn-primary btn-lg">
                <i class="fas fa-save me-2"></i>Guardar Tablas
            </button>
        </div>
    </div>

    <script>
        function redondear(valor) {
            return Math.round((valor + Number.EPSILON) * 100) / 100;
        }

        function actualizarBeneficio(i, tableId) {
            const costeUnit = parseFloat(document.getElementById(`${tableId}_coste_unitario_${i}`)?.value) || 0;
            const ventaUnit = parseFloat(document.getElementById(`${tableId}_precio_venta_unitario_${i}`)?.value) || 0;
            const beneficio = costeUnit > 0 ? redondear(((ventaUnit - costeUnit) / costeUnit) * 100) : 0;
            document.getElementById(`${tableId}_beneficio_${i}`).value = beneficio.toFixed(1);
        }

        function actualizarFilaCoste(i, tableId) {
            console.log(tableId)
            const inputMinutos = document.getElementById(`${tableId}_minutos_${i}`);
            const inputCosteUnitario = document.getElementById(`${tableId}_coste_unitario_${i}`);
            const totalCosteElement = document.getElementById(`${tableId}_total_coste_${i}`);

            const minutos = parseFloat(inputMinutos?.value) || 0;
            const costeUnit = parseFloat(inputCosteUnitario?.value) || 0;

            if (tableId === 'produccion') {
                const totalCoste = redondear((minutos / 60) * costeUnit);
                totalCosteElement.value = totalCoste.toFixed(2);
            } else {
                const totalCoste = redondear(minutos * costeUnit);
                totalCosteElement.value = totalCoste.toFixed(2);
            }
        }

        function actualizarFilaVenta(i, tableId) {
            const inputMinutos = document.getElementById(`${tableId}_minutos_${i}`);
            const inputVentaUnitario = document.getElementById(`${tableId}_precio_venta_unitario_${i}`);
            const tdTotalVenta = document.getElementById(`${tableId}_total_venta_${i}`);

            const minutos = parseFloat(inputMinutos?.value) || 0;
            const ventaUnit = parseFloat(inputVentaUnitario?.value) || 0;

            if (tableId === 'produccion') {
                const totalVenta = redondear((minutos / 60) * ventaUnit);
                tdTotalVenta.value = totalVenta.toFixed(2);
            } else {
                const totalVenta = redondear(minutos * ventaUnit);
                tdTotalVenta.value = totalVenta.toFixed(2);
            }
        }

        function recalcularTotalCosteGlobal(tableId) {
            let total = 0;
            const maxRows = tableId === 'produccion' ? 14 : (tableId === 'cortes' ? 11 : 5); // 15 rows for production, 12 for cuts, 6 for otros
            for (let i = 0; i <= maxRows; i++) {
                const input = document.getElementById(`${tableId}_total_coste_${i}`);
                if (input) {
                    const valor = parseFloat(input.value) || 0;
                    total += valor;
                }
            }
            document.getElementById(`${tableId}_coste-total`).value = redondear(total).toFixed(2);

            totalBeneficioProduccion();

            totalCorteProduccion();
            totalOtrosProduccion();
            totalMaterialesProduccion();
            totalBeneficioTeoricoEuro();  

            totalPorcentajeProduccion();
            totalPorcentajeCorte();
            totalPorcentajeOtros();
            totalPorcentajeMateriales();

            calcularPrecioFacturar()
        }

        function recalcularTotalVentaGlobal(tableId) {
            let total = 0;
            const maxRows = tableId === 'produccion' ? 14 : (tableId === 'cortes' ? 11 : 5); // 15 rows for production, 12 for cuts, 6 for otros
            for (let i = 0; i <= maxRows; i++) {
                const input = document.getElementById(`${tableId}_total_venta_${i}`);
                if (input) {
                    const valor = parseFloat(input.value) || 0;
                    total += valor;
                }
            }
            document.getElementById(`${tableId}_venta-total`).value = redondear(total).toFixed(2);

            totalVentaTeorico()

            totalBeneficioProduccion();
            totalCorteProduccion();
            totalOtrosProduccion();
            totalMaterialesProduccion();
            totalBeneficioTeoricoEuro();

            totalPorcentajeProduccion();
            totalPorcentajeCorte();
            totalPorcentajeOtros();
            totalPorcentajeMateriales();

            calcularPrecioFacturar()
        }

        function recalcularTotalHoras(tableId) {
            let total = 0;
            const maxRows = tableId === 'produccion' ? 14 : (tableId === 'cortes' ? 11 : 5); // 15 rows for production, 12 for cuts, 6 for otros
            for (let i = 0; i <= maxRows; i++) {
                const input = document.getElementById(`${tableId}_minutos_${i}`);
                if (input) {
                    const minutos = parseFloat(input.value) || 0;
                    total += minutos / 60;
                }
            }
            document.getElementById(`${tableId}_total-horas`).value = redondear(total).toFixed(2);
        }

        function totalLongitudUnitariaMetros() {
            const longitudInput = document.getElementById('longitud_unitaria-metro');
            const subastaUnitInput = document.getElementById('subasta-unitario');
            const totalMetroOutput = document.getElementById('total_unitaria-metro');

            const longitud = parseFloat(longitudInput?.value) || 0;
            const subastaUnit = parseFloat(subastaUnitInput?.value) || 0;

            let precioPorMetro = 0;
            if (longitud > 0) {
                precioPorMetro = subastaUnit / longitud;
            }

            totalMetroOutput.value = precioPorMetro.toFixed(2);
        }

        function totalPesoUnitariaMetros() {
            const pesoInput = document.getElementById('longitud_unitaria-peso');
            const subastaUnitInput = document.getElementById('subasta-unitario');
            const totalPesoOutput = document.getElementById('total_unitaria-peso');

            const peso = parseFloat(pesoInput?.value) || 0;
            const subastaUnit = parseFloat(subastaUnitInput?.value) || 0;

            let precioPorKg = 0;
            if (peso > 0) {
                precioPorKg = subastaUnit / peso;
            }

            totalPesoOutput.value = precioPorKg.toFixed(2);
        }

        function totalBeneficioProduccion() {
            const beneficioProduccionInput = document.getElementById('beneficio_produccion-euro');
            const costeProduccion = parseFloat(document.getElementById('produccion_coste-total')?.value) || 0;
            const ventaProduccion = parseFloat(document.getElementById('produccion_venta-total')?.value) || 0;

            const beneficioProduccion = redondear(ventaProduccion - costeProduccion);
            beneficioProduccionInput.value = `${beneficioProduccion.toFixed(2)}`;
        }

        function totalCorteProduccion() {
            const beneficioCorteInput = document.getElementById('beneficio_corte-euro');
            const costeCorte = parseFloat(document.getElementById('cortes_coste-total')?.value) || 0;
            const ventaCorte = parseFloat(document.getElementById('cortes_venta-total')?.value) || 0;

            const beneficioCorte = redondear(ventaCorte - costeCorte);
            beneficioCorteInput.value = `${beneficioCorte.toFixed(2)}`;
        }

        function totalOtrosProduccion() {
            const beneficioOtrosInput = document.getElementById('beneficio_otros-euro');
            const costeOtros = parseFloat(document.getElementById('otros_coste-total')?.value) || 0;
            const ventaOtros = parseFloat(document.getElementById('otros_venta-total')?.value) || 0;

            const beneficioOtros = redondear(ventaOtros - costeOtros);
            beneficioOtrosInput.value = `${beneficioOtros.toFixed(2)}`;
        }

        function totalMaterialesProduccion() {
            const beneficioMaterialesInput = document.getElementById('beneficio_materiales-euro');
            const costeMateriales = parseFloat(document.getElementById('materiales_coste-total')?.value) || 0;
            const ventaMateriales = parseFloat(document.getElementById('materiales_venta-total')?.value) || 0;

            const beneficioMateriales = redondear(ventaMateriales - costeMateriales);
            beneficioMaterialesInput.value = `${beneficioMateriales.toFixed(2)}`;
        }

        function totalGastosFinancieros() {
            const gastosFinancierosInput = document.getElementById('gastos_finaciero-euro');
            const gastosFinacierosPorcentaje = parseFloat(document.getElementById('gastos-financieros')?.value) || 0;
            const precioVentaTotal = parseFloat(document.getElementById('precio_venta-total')?.value) || 0;

            const totalCoste = redondear((gastosFinacierosPorcentaje/100) * precioVentaTotal);

            gastosFinancierosInput.value = `${totalCoste.toFixed(2)}`;
        }

        function totalPorcentajeProduccion() {
            const porcentajeProduccionInput = document.getElementById('beneficio_produccion-porcentaje');
            const beneficioProduccionEuro = parseFloat(document.getElementById('beneficio_produccion-euro')?.value) || 0;
            const precioVentaTotal = parseFloat(document.getElementById('precio_venta-total')?.value) || 0;

            let porcentajeProduccion = 0;
            if (precioVentaTotal > 0) {
                porcentajeProduccion = redondear(beneficioProduccionEuro / precioVentaTotal * 100);
            }

            porcentajeProduccionInput.value = `${porcentajeProduccion.toFixed(2)}`;
        }

        function totalPorcentajeCorte() {
            const porcentajeCorteInput = document.getElementById('beneficio_corte-porcentaje');
            const beneficioCorteEuro = parseFloat(document.getElementById('beneficio_corte-euro')?.value) || 0;
            const precioVentaTotal = parseFloat(document.getElementById('precio_venta-total')?.value) || 0;

            let porcentajeCorte = 0;
            if (precioVentaTotal > 0) {
                porcentajeCorte = redondear((beneficioCorteEuro / precioVentaTotal) * 100);
            }

            porcentajeCorteInput.value = `${porcentajeCorte.toFixed(2)}`;
        }

        function totalPorcentajeOtros() {
            const porcentajeOtrosInput = document.getElementById('beneficio_otros-porcentaje');
            const beneficioOtrosEuro = parseFloat(document.getElementById('beneficio_otros-euro')?.value) || 0;
            const precioVentaTotal = parseFloat(document.getElementById('precio_venta-total')?.value) || 0;

            let porcentajeOtros = 0;
            if (precioVentaTotal > 0) {
                porcentajeOtros = redondear((beneficioOtrosEuro / precioVentaTotal) * 100);
            }

            porcentajeOtrosInput.value = `${porcentajeOtros.toFixed(2)}`;
        }

        function totalPorcentajeMateriales() {
            const porcentajeMaterialesInput = document.getElementById('beneficio_materiales-porcentaje');
            const beneficioMaterialesEuro = parseFloat(document.getElementById('beneficio_materiales-euro')?.value) || 0;
            const precioVentaTotal = parseFloat(document.getElementById('precio_venta-total')?.value) || 0;

            let porcentajeMateriales = 0;
            if (precioVentaTotal > 0) {
                porcentajeMateriales = redondear((beneficioMaterialesEuro / precioVentaTotal) * 100);
            }

            porcentajeMaterialesInput.value = `${porcentajeMateriales.toFixed(2)}`;
        }
        
        function totalBeneficioTeoricoEuro() {
            const beneficioTotalEuro = document.getElementById('beneficio_teorico_total-euro');
            const beneficioProduccion = parseFloat(document.getElementById('beneficio_produccion-euro')?.value) || 0;
            const beneficioCorte = parseFloat(document.getElementById('beneficio_corte-euro')?.value) || 0;
            const gastosFinacieros = parseFloat(document.getElementById('gastos_finaciero-euro')?.value) || 0;

            const totalCoste = redondear(beneficioProduccion + beneficioCorte - gastosFinacieros);

            beneficioTotalEuro.value = totalCoste.toFixed(2);
        }

        function totalBeneficioTeoricoPorcentaje() {
            const porcentajeTotal = document.getElementById('beneficio_teorico_total-porcentaje');
            const beneficioProduccion = parseFloat(document.getElementById('beneficio_produccion-porcentaje')?.value) || 0;
            const beneficioCorte = parseFloat(document.getElementById('beneficio_corte-porcentaje')?.value) || 0;
            const beneficioOtros = parseFloat(document.getElementById('beneficio_otros-porcentaje')?.value) || 0;
            const gastosFinancieros= parseFloat(document.getElementById('gastos-financieros')?.value) || 0;

            const total = redondear(beneficioProduccion + beneficioCorte + beneficioOtros - gastosFinancieros);

            porcentajeTotal.value = `${total.toFixed(2)}`;
        }

        function totalVentaTeorico() {
            const totalVentaTeoricoInput = document.getElementById('precio_venta-total');

            const costeProduccion = parseFloat(document.getElementById('produccion_venta-total')?.value) || 0;
            const costeCorte = parseFloat(document.getElementById('cortes_venta-total')?.value) || 0;
            const costeOtros = parseFloat(document.getElementById('otros_venta-total')?.value) || 0;
            const costeMateriales = parseFloat(document.getElementById('materiales_venta-total')?.value) || 0;

            const totalCoste = redondear(costeProduccion + costeCorte + costeOtros + costeMateriales);

            totalVentaTeoricoInput.value = totalCoste.toFixed(2);

            totalGastosFinancieros();

            totalPorcentajeProduccion();
            totalPorcentajeCorte();
            totalPorcentajeOtros();
            totalPorcentajeMateriales();
            totalBeneficioTeoricoPorcentaje();
        }

        function totalUnitariaTeorico() {
            const totalUnitariaTeoricoInput = document.getElementById('unitario-total');

            const totalVentaTeorico = parseFloat(document.getElementById('precio_venta-total')?.value) || 0;
            const unidadesValoradas = parseFloat(document.getElementById('unidades-valoradas')?.value) || 0;

            let totalUnitario = 0;

            if (unidadesValoradas !== 0) {
                totalUnitario = totalVentaTeorico / unidadesValoradas;
            }

            totalUnitariaTeoricoInput.value = totalUnitario.toFixed(2); // mostrará correctamente negativo
        }
        
        function recalcularPrecioFinal() {
            const subastaTotalInput = document.getElementById('subasta-total');
            const subastaUnitarioInput = document.getElementById('subasta-unitario');
            const beneficioPorcentajeInput = document.getElementById('porcentaje_beneficio-total');
            const beneficioEurosInput = document.getElementById('euro_beneficio-total');
            const unidadesValoradasInput = document.getElementById('unidades-valoradas');
            const gastoFinancieroInput = document.getElementById('gastos-financieros');

            const subastaTotal = parseFloat(subastaTotalInput?.value) || 0;
            const horasTotales = parseFloat(unidadesValoradasInput?.value) || 1;
            const porcentajeFinanciero = parseFloat(gastoFinancieroInput?.value) || 0;

            const costeProduccion = parseFloat(document.getElementById('produccion_coste-total')?.value) || 0;
            const costeCorte = parseFloat(document.getElementById('cortes_coste-total')?.value) || 0;
            const costeOtros = parseFloat(document.getElementById('otros_coste-total')?.value) || 0;
            const costeMateriales = parseFloat(document.getElementById('materiales_coste-total')?.value) || 0;

            const gastosFinancieros = redondear(subastaTotal * (porcentajeFinanciero / 100));

            const totalCoste = redondear(costeProduccion + costeCorte + costeOtros + costeMateriales + gastosFinancieros);
            const beneficioEuros = redondear(subastaTotal - totalCoste);
            const beneficioPorcentaje = subastaTotal > 0 ? redondear((beneficioEuros / subastaTotal) * 100) : 0;
            const unitario = horasTotales > 0 ? redondear(subastaTotal / horasTotales) : 0;

            subastaUnitarioInput.value = unitario.toFixed(2);
            beneficioEurosInput.value = beneficioEuros.toFixed(2);
            beneficioPorcentajeInput.value = beneficioPorcentaje.toFixed(1);

            totalLongitudUnitariaMetros();
            totalPesoUnitariaMetros()
        }

        function calcularPrecioFacturar() {
            const costeProduccion = parseFloat(document.getElementById('produccion_coste-total')?.value) || 0;
            const costeCorte = parseFloat(document.getElementById('cortes_coste-total')?.value) || 0;
            const ventaOtros = parseFloat(document.getElementById('otros_venta-total')?.value) || 0;
            const ventaMateriales = parseFloat(document.getElementById('materiales_venta-total')?.value) || 0;

            const precioVentaTeorico = parseFloat(document.getElementById('precio_venta-total')?.value) || 0;
            const porcentajeFinanciero = parseFloat(document.getElementById('gastos-financieros')?.value) || 0;
            const porcentajeDeseado = parseFloat(document.getElementById('porcentaje_deseado')?.value) || 0;

            const precioAproxFacturarInput = document.getElementById('precio_aproximado-facturar');

            const costeFinanciero = precioVentaTeorico * (porcentajeFinanciero / 100);
            const divisor = 1 - (porcentajeDeseado / 100);

            if (divisor > 0) {
                const total = costeProduccion + costeCorte + ventaOtros + ventaMateriales + costeFinanciero;
                const resultado = total / divisor;
                precioAproxFacturarInput.value = resultado.toFixed(2);
            } else {
                precioAproxFacturarInput.value = "Error";
            }
        }

        function restoMateriaPrima() {
            const materialesTotal = parseFloat(document.getElementById('calculo_materiales-total').value) || 0;
            const tubosEmpleadosTotal = parseFloat(document.getElementById('calculo_materiales_laser_total').value) || 0;
            const resto = document.getElementById('materiales_coste_unitario_1');

            const total = materialesTotal + tubosEmpleadosTotal;

            console.log(total);

            resto.value = total.toFixed(2);
        }

        function calcularCostePartida(fila) {
            const unidadInput = document.getElementById(`calculo_materiales_unidad_${fila}`);
            const precioUnitarioInput = document.getElementById(`calculo_materiales_precio_unitario_${fila}`);
            const costePartidaInput = document.getElementById(`calculo_materiales_coste_partida_${fila}`);

            const unidad = parseFloat(unidadInput?.value) || 0;
            const precioUnitario = parseFloat(precioUnitarioInput?.value) || 0;

            const costePartida = redondear(unidad * precioUnitario);
            costePartidaInput.value = costePartida.toFixed(2);
        }

        function calcularTotalMaterialeEmpleado() {
            let total = 0;

            for (let i = 0; i < 24; i++) {
                const costePartidaInput = document.getElementById(`calculo_materiales_coste_partida_${i}`);
                if (costePartidaInput) {
                    const valor = parseFloat(costePartidaInput.value) || 0;
                    total += valor;
                }
            }

            document.getElementById('calculo_materiales-total').value = redondear(total).toFixed(2);
            restoMateriaPrima();
        }

        function calcularCostePartidaLaser(fila) {
            const metrosInput = document.getElementById(`calculo_materiales_laser_metros_${fila}`);
            const precioMetroInput = document.getElementById(`calculo_materiales_laser_precio_metro_${fila}`);
            const costePartidaInput = document.getElementById(`calculo_materiales_laser_costepartida_${fila}`);

            const metros = parseFloat(metrosInput?.value) || 0;
            const precioMetro = parseFloat(precioMetroInput?.value) || 0;

            const costePartida = redondear(metros * precioMetro);
            costePartidaInput.value = costePartida.toFixed(2);
        }

        function calcularTotalMaterialeLaserEmpleado() {
            let total = 0;

            for (let i = 0; i < 12; i++) {
                const costePartidaInput = document.getElementById(`calculo_materiales_laser_costepartida_${i}`);
                if (costePartidaInput) {
                    const valor = parseFloat(costePartidaInput.value) || 0;
                    total += valor;
                }
            }

            document.getElementById('calculo_materiales_laser_total').value = redondear(total).toFixed(2);
            restoMateriaPrima();
        }

        function calcularTiposTuboLaser() {
            const tiposTuboInput = document.getElementById('tipos_tubos_laser');
            let contador = 0;

            for (let i = 0; i < 12; i++) {
                const metrosInput = document.getElementById(`calculo_materiales_laser_descripcion_${i}`);
                if (metrosInput.value.trim() !== '') {
                    contador++;
                }
            }

            tiposTuboInput.value = contador;
        }

        function calcularCostePesoTotal() {
            const costeTotalInput = document.getElementById(`calculo_precios_chapas_total_coste`);
            const pesoTotalInput = document.getElementById(`calculo_precios_chapas_total_kg`);
            const chapa = document.getElementById('materiales_coste_unitario_0');

            let costeTotal = 0;
            let pesoTotal = 0;

            for (let i = 0; i < 20; i++) {
                const costeInput = parseFloat(document.getElementById(`calculo_precios_chapas_coste_${i}`).value) || 0;
                const pesoInput = parseFloat(document.getElementById(`calculo_precios_chapas_kg_${i}`).value) || 0;

                costeTotal += costeInput;
                pesoTotal += pesoInput;
            }

            console.log(costeTotal, pesoTotal);

            costeTotalInput.value = costeTotal.toFixed(2);
            pesoTotalInput.value = pesoTotal.toFixed(4);
            chapa.value = costeTotal.toFixed(2);
        }

        function calcularCosteChapa(j) {
            const unidad = parseFloat(document.getElementById(`calculo_precios_chapas_unidad_${j}`).value) || 0;
            const largo = parseFloat(document.getElementById(`calculo_precios_chapas_largo_${j}`).value) || 0;
            const ancho = parseFloat(document.getElementById(`calculo_precios_chapas_ancho_${j}`).value) || 0;
            const espesor = parseFloat(document.getElementById(`calculo_precios_chapas_espesor_${j}`).value) || 0;
            const materialIndex = document.getElementById(`calculo_precios_chapas_material_${j}`).value;

            if (materialIndex === '') {
                return
            }

            let precio = 0;

            const arr1 = ['A/C', 'AISI 304', 'AISI 316',
                'AISI 304 BRILLO', 'AISI 304 SATIN',
                'AISI 316 BRI SAT', 'ALUMINIO TOP-GRIP', 'GALVANIZADO'];

            const arr3 = ['ALUMINIO PALILLOS', 'DAMERO ITURRI (ALUMINIO)', 
                'ALUMINIO TOP-GRIP', 'GALVANIZADO'];

            for (let i = 0; i < 20; i++) {
                const nombre = document.getElementById(`materiales_precio_coste_nombre${i}`).value;
                const valor = document.getElementById(`materiales_precio_coste_precio${i}`).value;

                if (nombre === materialIndex) {
                    precio = parseFloat(valor.replace(',', '.')) || 0;
                    break;
                }
            }

            const costeInput = document.getElementById(`calculo_precios_chapas_coste_${j}`);
            const kgInput = document.getElementById(`calculo_precios_chapas_kg_${j}`);

            let densidad = arr1.includes(materialIndex) ? 8 : 2.7;

            const volumen = (largo / 1000) * (ancho / 1000) * espesor;
            const peso = unidad * volumen * densidad;
            const coste = unidad * volumen * densidad * precio;

            costeInput.value = parseFloat(coste.toFixed(2));

            if (arr3.includes(materialIndex)) {
                kgInput.value = 0;
            } else {
                kgInput.value = parseFloat(peso.toFixed(4));
            }

            calcularCostePesoTotal()
        }

        function obtenerSiglasComercial(comercialSeleccionado) {
            const siglasInput = document.getElementById('tecnico_siglas');
            let siglas = "";

            for (let i = 0; i < 8; i++) {
                let comercial = document.getElementById(`comerciales_nombre_${i}`).value;
                let codigo = document.getElementById(`comerciales_codigo_${i}`).value;

                if (comercialSeleccionado === comercial) {
                    siglas = codigo;
                }
            }

            siglasInput.value = siglas;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const tables = ['produccion', 'cortes', 'otros', 'materiales'];

            tables.forEach(tableId => {
                const maxRows = tableId === 'produccion' ? 14 :
                              (tableId === 'cortes' ? 11 :
                              (tableId === 'otros' ? 5 : 7)); // 15 rows for production, 12 for cuts, 6 for otros, 8 for materiales

                // Inicializar todos los cálculos al cargar la página
                for (let i = 0; i <= maxRows; i++) {
                    actualizarFilaCoste(i, tableId);
                    actualizarFilaVenta(i, tableId);
                    actualizarBeneficio(i, tableId);
                }
                recalcularTotalCosteGlobal(tableId);
                recalcularTotalVentaGlobal(tableId);
                if (tableId === 'produccion') {
                    recalcularTotalHoras(tableId);
                }

                totalGastosFinancieros();
                recalcularPrecioFinal();

                totalVentaTeorico();
                totalUnitariaTeorico();
                
                totalLongitudUnitariaMetros();
                totalPesoUnitariaMetros()

                totalBeneficioProduccion();
                totalCorteProduccion();
                totalOtrosProduccion();
                totalMaterialesProduccion();

                totalPorcentajeProduccion();
                totalPorcentajeCorte();
                totalPorcentajeOtros();
                totalPorcentajeMateriales();

                // Configurar los event listeners
                for (let i = 0; i <= maxRows; i++) {
                    const inputMinutos = document.getElementById(`${tableId}_minutos_${i}`);
                    const inputCosteUnitario = document.getElementById(`${tableId}_coste_unitario_${i}`);
                    const inputVentaUnitario = document.getElementById(`${tableId}_precio_venta_unitario_${i}`);
                    const inputSubastaTotal = document.getElementById('subasta-total')?.addEventListener('input', recalcularPrecioFinal);
                    const inputUnidadesValoradas = document.getElementById('unidades-valoradas');
                    const inputLongitudUnidad = document.getElementById('longitud_unitaria-metro');
                    const pesoInput = document.getElementById('longitud_unitaria-peso');
                    const inputBeneficioProduccion = document.getElementById('beneficio_produccion-euro');
                    const inputBeneficioCorte = document.getElementById('beneficio_corte-euro');
                    const inputBeneficioOtros = document.getElementById('beneficio_otros-euro');
                    const inputBeneficioMateriales = document.getElementById('beneficio_materiales-euro');
                    const gastosFinancierosInput = document.getElementById('gastos-financieros');
                    const porcentajeDeseadoInput = document.getElementById('porcentaje_deseado');

                    if (inputMinutos) {
                        inputMinutos.addEventListener('input', function () {
                            actualizarFilaCoste(i, tableId);
                            actualizarFilaVenta(i, tableId);
                            recalcularTotalCosteGlobal(tableId);
                            recalcularTotalVentaGlobal(tableId);
                            if (tableId === 'produccion') {
                                recalcularTotalHoras(tableId);
                            }
                            totalVentaTeorico();
                            totalUnitariaTeorico();
                            recalcularPrecioFinal()
                            totalLongitudUnitariaMetros();
                        });
                    }

                    if (inputCosteUnitario) {
                        inputCosteUnitario.addEventListener('input', function () {
                            actualizarFilaCoste(i, tableId);
                            actualizarBeneficio(i, tableId);
                            recalcularTotalCosteGlobal(tableId);
                            totalVentaTeorico();
                            totalUnitariaTeorico();
                            recalcularPrecioFinal()
                            totalLongitudUnitariaMetros();
                        });
                    }

                    if (inputVentaUnitario) {
                        inputVentaUnitario.addEventListener('input', function () {
                            actualizarFilaVenta(i, tableId);
                            actualizarBeneficio(i, tableId);
                            recalcularTotalVentaGlobal(tableId);
                            totalVentaTeorico();
                            totalUnitariaTeorico();
                            recalcularPrecioFinal()
                            totalLongitudUnitariaMetros();
                        });
                    }

                    if (inputSubastaTotal) {
                        recalcularPrecioFinal();
                        totalLongitudUnitariaMetros();
                    }

                    if (inputUnidadesValoradas) {
                        inputUnidadesValoradas.addEventListener('input', function () {
                            console.log("tont")
                            totalUnitariaTeorico();
                            recalcularPrecioFinal();
                        });
                    }

                    if (inputLongitudUnidad) {
                        inputLongitudUnidad.addEventListener('input', () => {
                            totalLongitudUnitariaMetros();
                        });
                    }

                    if (pesoInput) {
                        pesoInput.addEventListener('input', () => {
                            totalPesoUnitariaMetros();
                        });
                    }

                    if (inputBeneficioProduccion) {
                        inputBeneficioProduccion.addEventListener('input', totalBeneficioProduccion);
                    }

                    if (inputBeneficioCorte) {
                        inputBeneficioCorte.addEventListener('input', totalCorteProduccion);    
                    }

                    if (inputBeneficioOtros) {
                        inputBeneficioOtros.addEventListener('input', totalOtrosProduccion);
                    }

                    if (inputBeneficioMateriales) {
                        inputBeneficioMateriales.addEventListener('input', totalMaterialesProduccion);
                    }

                    if (gastosFinancierosInput) {
                        gastosFinancierosInput.addEventListener('input', () => {
                            totalGastosFinancieros();
                            recalcularPrecioFinal();
                            totalBeneficioTeoricoPorcentaje();
                            calcularPrecioFacturar()
                        });
                    }

                    if (porcentajeDeseadoInput) {
                        porcentajeDeseadoInput.addEventListener('input', () => {
                            calcularPrecioFacturar();
                        });
                    }
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            for (let j = 0; j <= 24; j++) {
                const unidadInput = document.getElementById(`calculo_materiales_unidad_${j}`);
                const precioUnitarioInput = document.getElementById(`calculo_materiales_precio_unitario_${j}`);

                if (unidadInput) {
                    unidadInput.addEventListener('input', function () {
                        calcularCostePartida(j);
                        calcularTotalMaterialeEmpleado();
                    });
                } 
                
                if( precioUnitarioInput) {
                    precioUnitarioInput.addEventListener('input', function () {
                        calcularCostePartida(j);
                        calcularTotalMaterialeEmpleado();
                    });
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            for (let j = 0; j < 12; j++) {
                const metrosInput = document.getElementById(`calculo_materiales_laser_metros_${j}`);
                const precioMetroInput = document.getElementById(`calculo_materiales_laser_precio_metro_${j}`);
                const descripcionInput = document.getElementById(`calculo_materiales_laser_descripcion_${j}`);
                
                const materialCalculoPreciosInput = document.getElementById(`calculo_precios_chapas_material_${j}`);
                const unidadInput = document.getElementById(`calculo_precios_chapas_unidad_${j}`);
                const largoInput = document.getElementById(`calculo_precios_chapas_largo_${j}`);
                const anchoInput = document.getElementById(`calculo_precios_chapas_ancho_${j}`);
                const espesorInput = document.getElementById(`calculo_precios_chapas_espesor_${j}`);

                if (metrosInput) {
                    metrosInput.addEventListener('input', function () {
                        calcularCostePartidaLaser(j);
                        calcularTotalMaterialeLaserEmpleado();
                    });
                }

                if (precioMetroInput) {
                    precioMetroInput.addEventListener('input', function () {
                        calcularCostePartidaLaser(j);
                        calcularTotalMaterialeLaserEmpleado();
                    });
                }

                if (descripcionInput) {
                    descripcionInput.addEventListener('input', function () {
                        calcularTiposTuboLaser();
                    });
                }

                if (materialCalculoPreciosInput) {
                    materialCalculoPreciosInput.addEventListener('change', function () {
                        calcularCosteChapa(j);
                    });
                }

                if (unidadInput) {
                    unidadInput.addEventListener('input', function () {
                        calcularCosteChapa(j);
                    });
                }

                if (largoInput) {
                    largoInput.addEventListener('input', function () {
                        calcularCosteChapa(j);
                    });
                }

                if (anchoInput) {
                    anchoInput.addEventListener('input', function () {
                        calcularCosteChapa(j);
                    });
                }

                if (espesorInput) {
                    espesorInput.addEventListener('input', function () {
                        calcularCosteChapa(j);
                    });
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            for (let j = 0; j < 20; j++) {
                const materialCalculoPreciosInput = document.getElementById(`calculo_precios_chapas_material_${j}`);
                const unidadInput = document.getElementById(`calculo_precios_chapas_unidad_${j}`);
                const largoInput = document.getElementById(`calculo_precios_chapas_largo_${j}`);
                const anchoInput = document.getElementById(`calculo_precios_chapas_ancho_${j}`);
                const espesorInput = document.getElementById(`calculo_precios_chapas_espesor_${j}`);
                const comercialSeleccionado = document.getElementById('comercial_seleccionado');

                if (materialCalculoPreciosInput) {
                    materialCalculoPreciosInput.addEventListener('change', function () {
                        calcularCosteChapa(j);
                    });
                }

                if (unidadInput) {
                    unidadInput.addEventListener('input', function () {
                        calcularCosteChapa(j);
                    });
                }

                if (largoInput) {
                    largoInput.addEventListener('input', function () {
                        calcularCosteChapa(j);
                    });
                }

                if (anchoInput) {
                    anchoInput.addEventListener('input', function () {
                        calcularCosteChapa(j);
                    });
                }

                if (espesorInput) {
                    espesorInput.addEventListener('input', function () {
                        calcularCosteChapa(j);
                    });
                }

                if (comercialSeleccionado) {
                    comercialSeleccionado.addEventListener('change', function () {
                        obtenerSiglasComercial(comercialSeleccionado.value);
                    });
                }
            }
        });
    </script>