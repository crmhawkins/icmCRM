<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Hoja de Producción - Pedido {{ $pedido->numero_pedido }}</title>
<style>
/* Página A4 */
@page { size: A4; margin: 16mm 12mm 16mm 12mm; }
body { font-family: Arial, sans-serif; font-size: 10px; color:#000; margin:0; }

/* Tablas DOMPDF-friendly */
table { width:100%; border-collapse: collapse; table-layout: fixed; }
th, td { border: 1px solid #000; padding: 3px 5px; vertical-align: middle; }
th { background:#f2f2f2; }

/* ===== CABECERA ===== */
.header{
  width:100%;
  border:2px solid #000;
  margin-bottom:8px;
  padding:10px 12px 12px;
  position:relative;        /* para posicionar la referencia */
  text-align:center;
}

/* LOGO con dimensiones fijas tipo modelo (ancho x alto) */
.company-logo{
  display:block;
  margin:0 auto 4px;
  width:42mm;               /* mismo “look” ancho/bajo */
  height:14mm;
  border:1px solid #000;    /* marco como en el modelo */
  box-sizing:border-box;
  overflow:hidden;
}
.company-logo img{
  width:100%;
  height:100%;
  object-fit:contain;
  object-position:center;
  display:block;
}

/* Tagline y título */
.company-tagline{
  font-size:9px;
  letter-spacing:.3px;
  margin:3px 0 4px;
  color:#000;               /* más contraste, como el modelo */
}
.document-title{
  font-size:14px;
  font-weight:bold;
  letter-spacing:.5px;
  margin:0;                 /* compactar */
}

/* Referencia arriba-derecha dentro del marco */
.document-ref{
  position:absolute;
  top:6px;
  right:10px;
  font-size:11px;
  font-weight:bold;
  color:#000;
}

/* ===== FICHA SUPERIOR ===== */
.ficha{ margin-bottom:6px; }
.ficha td.lbl{
  background:#f2f2f2;
  font-weight:bold;
  width:18%;
}
.ficha td.val{ width:32%; }

/* ===== RESUMEN PUNTOS ===== */
.resumen{ margin-bottom:8px; }
.resumen td{ text-align:center; font-weight:bold; }
.resumen .ttl{ background:#f2f2f2; width:18%; }
.resumen .val{ width:15%; }

/* ===== SECCIONES ===== */
.section{
  font-weight:bold;
  text-transform:uppercase;
  margin:8px 0 4px;
  padding:4px 6px;
  border:1px solid #000;
  background:#fff;
  text-align:left;
}

/* ===== OBS (cabecera) ===== */
.obs-top th{ text-align:center; }
.obs-top td{ height:20px; }

/* ===== MÉTODO DE TRABAJO ===== */
.mt th{ text-align:center; font-weight:bold; }
.mt .c-num{ width:10%; }
.mt .c-op { width:48%; text-align:left; }
.mt .c-ter{ width:14%; }
.mt .c-aut{ width:8%; }
.mt .c-pun{ width:20%; text-align:right; white-space:nowrap; }

/* ===== OBS (inferior) ===== */
.obs-mid th{ text-align:center; }
.obs-mid td{ height:36px; }

/* ===== SEGUIMIENTO / MATERIALES ===== */
.seg th, .mat th{ text-align:center; }
.seg td, .mat td{ height:18px; }

/* Paginación */
.page{ page-break-after:always; }
.page:last-child{ page-break-after:auto; }

/* Utilidades */
.t-right{ text-align:right; }
.t-center{ text-align:center; }
.no-b{ border:none !important; }
.small{ font-size:9px; }

</style>
</head>
<body>

@php
    $fmt = fn($n) => is_numeric($n) ? number_format((float)$n, 2, ',', '.') : $n;
@endphp

@foreach($pedido->piezas as $index => $pieza)
    @if($pieza->colaTrabajo && $pieza->colaTrabajo->count() > 0)
        @foreach($pieza->colaTrabajo as $colaTrabajo)

        <!-- ===== PÁGINA 1 ===== -->
        <div class="page">
            <div class="header">
                <div class="company-logo">
                    <img src="{{ $logoPath }}" alt="Logo ICM" style="max-height: 60px; max-width: 200px;">
                </div>
                <div class="company-tagline">CREAMOS SOLUCIONES DE FUTURO</div>
                <div class="document-title">HOJA DE PRODUCCIÓN - PIEZA {{ $index + 1 }}</div>
                <div class="document-ref">R-07-01</div>
            </div>

            <!-- FICHA -->
            <table class="ficha">
                <tr>
                    <td class="lbl">Obra Nº:</td>
                    <td class="val">{{ $colaTrabajo->codigo_trabajo ?? '' }}</td>
                    <td class="lbl">Denominación:</td>
                    <td class="val">
                        {{ $pieza->nombre ?? '' }}
                        <span style="float:right;">Cód.Artículo:&nbsp;{{ $pieza->codigo ?? '' }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="lbl">Fecha Inicio:</td>
                    <td class="val">{{ $colaTrabajo->fecha_inicio_estimada ? $colaTrabajo->fecha_inicio_estimada->format('d/m/Y') : '' }}</td>
                    <td class="lbl">Fecha Fin:</td>
                    <td class="val">{{ $colaTrabajo->fecha_fin_estimada ? $colaTrabajo->fecha_fin_estimada->format('d/m/Y') : '' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Pedido:</td>
                    <td class="val">{{ $pedido->numero_pedido ?? '' }}</td>
                    <td class="lbl">CANTIDAD:</td>
                    <td class="val">{{ $pieza->cantidad ?? '1' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Cliente:</td>
                    <td class="val">{{ $pedido->nombre_cliente ?? '' }}</td>
                    <td class="lbl">Fecha Entrega:</td>
                    <td class="val">{{ $pedido->fecha_entrega_estimada ? \Carbon\Carbon::parse($pedido->fecha_entrega_estimada)->format('d/m/Y') : '' }}</td>
                </tr>
            </table>

            <!-- MÉTODO DE TRABAJO -->
            <div class="section">MÉTODO DE TRABAJO</div>
            <table class="mt">
                <thead>
                    <tr>
                        <th class="c-num">NUMERACIÓN</th>
                        <th class="c-op">OPERACIÓN<br><span class="small">ELEGIR BIEN EL TIPO DE MATERIAL</span></th>
                        <th class="c-ter">TERMINACIÓN</th>
                        <th class="c-aut">Autoc.</th>
                        <th class="c-pun">PUNTOS ASIGNADOS</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $trabajosMostrados = [];
                    $trabajosOrdenados = [];
                    $numeroActual = 1;
                    $totalPuntosAsignados = 0;
                @endphp

                {{-- PRODUCCIÓN --}}
                @if($pieza->seguimiento && $pieza->seguimiento->datos_produccion)
                    @php
                        $datosProduccion = is_array($pieza->seguimiento->datos_produccion)
                            ? $pieza->seguimiento->datos_produccion
                            : json_decode($pieza->seguimiento->datos_produccion, true);
                    @endphp
                    @if(is_array($datosProduccion))
                        @foreach($datosProduccion as $i => $trabajo)
                            @if(!empty($trabajo['trabajo']) && !in_array($trabajo['trabajo'], $trabajosMostrados))
                                @php
                                    $puntos = isset($trabajo['minutos']) ? $trabajo['minutos'] : 0;
                                    $totalPuntosAsignados += $puntos;
                                    $trabajosOrdenados[] = [
                                        'numero' => $numeroActual++,
                                        'trabajo' => $trabajo['trabajo'],
                                        'terminacion' => '',
                                        'puntos' => $puntos,
                                        'tipo' => 'produccion'
                                    ];
                                    $trabajosMostrados[] = $trabajo['trabajo'];
                                @endphp
                            @endif
                        @endforeach
                    @endif
                @endif

                {{-- LÁSER --}}
                @if($pieza->seguimiento && $pieza->seguimiento->datos_laser)
                    @php
                        $datosLaser = is_array($pieza->seguimiento->datos_laser)
                            ? $pieza->seguimiento->datos_laser
                            : json_decode($pieza->seguimiento->datos_laser, true);
                    @endphp
                    @if(is_array($datosLaser))
                        @foreach($datosLaser as $i => $trabajo)
                            @if(!empty($trabajo['material']) && !in_array($trabajo['material'], $trabajosMostrados))
                                @php
                                    $puntos = isset($trabajo['minutos']) ? $trabajo['minutos'] : 0;
                                    $totalPuntosAsignados += $puntos;
                                    $trabajosOrdenados[] = [
                                        'numero' => $numeroActual++,
                                        'trabajo' => 'Corte Láser ' . $trabajo['material'],
                                        'terminacion' => '',
                                        'puntos' => $puntos,
                                        'tipo' => 'laser'
                                    ];
                                    $trabajosMostrados[] = $trabajo['material'];
                                @endphp
                            @endif
                        @endforeach
                    @endif
                @endif

                {{-- OTROS --}}
                @if($pieza->seguimiento && $pieza->seguimiento->cantidad_otros_servicios > 0)
                    @if(!in_array('OTROS SERVICIOS', $trabajosMostrados))
                        @php
                            $puntos = $pieza->seguimiento->cantidad_otros_servicios;
                            $totalPuntosAsignados += $puntos;
                            $trabajosOrdenados[] = [
                                'numero' => $numeroActual++,
                                'trabajo' => $pieza->seguimiento->tipo_otros_servicios ?? 'OTROS SERVICIOS',
                                'terminacion' => '',
                                'puntos' => $puntos,
                                'tipo' => 'otros_servicios'
                            ];
                            $trabajosMostrados[] = 'OTROS SERVICIOS';
                        @endphp
                    @endif
                @endif
                @if($pieza->seguimiento && $pieza->seguimiento->coste_materiales_total > 0)
                    @if(!in_array('MATERIALES', $trabajosMostrados))
                        @php
                            $puntos = $pieza->seguimiento->coste_materiales_total;
                            $totalPuntosAsignados += $puntos;
                            $trabajosOrdenados[] = [
                                'numero' => $numeroActual++,
                                'trabajo' => 'MATERIALES',
                                'terminacion' => '',
                                'puntos' => $puntos,
                                'tipo' => 'materiales'
                            ];
                            $trabajosMostrados[] = 'MATERIALES';
                        @endphp
                    @endif
                @endif
                @if($pieza->seguimiento && $pieza->seguimiento->peso_total_kg > 0)
                    @if(!in_array('PESO', $trabajosMostrados))
                        @php
                            $puntos = $pieza->seguimiento->peso_total_kg * 10;
                            $totalPuntosAsignados += $puntos;
                            $trabajosOrdenados[] = [
                                'numero' => $numeroActual++,
                                'trabajo' => 'PESO TOTAL (' . number_format($pieza->seguimiento->peso_total_kg, 2, ',', '.') . ' KG)',
                                'terminacion' => '',
                                'puntos' => $puntos,
                                'tipo' => 'peso'
                            ];
                            $trabajosMostrados[] = 'PESO';
                        @endphp
                    @endif
                @endif

                @foreach($trabajosOrdenados as $t)
                    <tr>
                        <td class="t-center">{{ $t['numero'] }}</td>
                        <td>{{ $t['trabajo'] }}</td>
                        <td>{{ $t['terminacion'] }}</td>
                        <td></td>
                        <td class="t-right">{{ number_format($t['puntos'], 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- RESUMEN PUNTOS -->
            <table class="resumen">
                <tr>
                    <td class="ttl">Puntos asignados:</td>
                    <td class="val">{{ number_format($totalPuntosAsignados, 2, ',', '.') }}</td>
                    <td class="ttl">Puntos invertidos:</td>
                    <td class="val">{{ $fmt(0) }}</td>
                    <td class="ttl">Dif. Puntos:</td>
                    <td class="val">{{ number_format($totalPuntosAsignados - 0, 2, ',', '.') }}</td>
                </tr>
            </table>

            <!-- OBS CABECERA -->
            <div class="section">OBSERVACIONES</div>
            <table class="obs-top">
                <tr>
                    <th>COMERCIAL</th>
                    <th>JEFE TALLER</th>
                    <th class="t-center">PESO (KG)</th>
                </tr>
                <tr>
                    <td></td><td></td><td class="t-center"></td>
                </tr>
            </table>

            <!-- Observaciones artículo/pedido -->
            <table class="obs-mid" style="margin-top:6px;">
                <tr>
                    <th style="width:50%;">Observaciones del artículo:</th>
                    <th style="width:50%;">Observaciones del pedido:</th>
                </tr>
                <tr>
                    <td>{{ $colaTrabajo->notas ?? '' }}</td>
                    <td>{{ $pedido->notas_manuales ?? '' }}</td>
                </tr>
            </table>
        </div>

        <!-- ===== PÁGINA 2 ===== -->
        <div class="page">
            <table class="header">
                <tr>
                    <td class="h-left">
                        @if(file_exists($logoPath))
                            <img src="{{ $logoPath }}" class="logo-box" alt="LOGO">
                        @else
                            <div class="logo-box" style="display:flex;align-items:center;justify-content:center;font-weight:bold;">LOGO</div>
                        @endif
                        <div class="brand-small t-center">CREAMOS SOLUCIONES DE FUTURO</div>
                    </td>
                    <td class="h-center"><div class="title-big">HOJA DE PRODUCCIÓN</div></td>
                    <td class="h-right">R-07-01</td>
                </tr>
            </table>

            <div class="section">MATERIALES OBRA - PIEZA {{ $index + 1 }}: {{ $pieza->nombre }}</div>
            <table class="seg">
                <thead>
                    <tr>
                        <th style="width:12%;">FECHA</th>
                        <th style="width:28%;">OPERACIÓN</th>
                        <th style="width:28%;">NOMBRE DEL OPERARIO</th>
                        <th style="width:12%;">COD. OPERARIO</th>
                        <th style="width:10%;">TOTAL PUNTOS</th>
                        <th style="width:10%;">OBSERVACIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 1; $i <= 25; $i++)
                    <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                    @endfor
                </tbody>
            </table>

            <div class="section">MATERIALES OBRA</div>
            <table class="mat">
                <thead>
                    <tr>
                        <th style="width:60%;">MATERIAL</th>
                        <th style="width:20%;">CANTIDAD</th>
                        <th style="width:20%;">COSTE</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 1; $i <= 15; $i++)
                    <tr><td></td><td></td><td></td></tr>
                    @endfor
                </tbody>
            </table>
        </div>

        @endforeach
    @endif
@endforeach

</body>
</html>
