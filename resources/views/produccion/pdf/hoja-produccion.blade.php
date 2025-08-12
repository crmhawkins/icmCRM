<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoja de Producción - {{ $colaTrabajo->codigo_trabajo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.2;
            margin: 0;
            padding: 10px;
        }
        
        .page {
            page-break-after: always;
            margin-bottom: 20px;
        }
        
        .page:last-child {
            page-break-after: avoid;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        
        .company-logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .company-tagline {
            font-size: 12px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .document-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .document-ref {
            font-size: 10px;
            text-align: right;
            margin-bottom: 10px;
        }
        
        .order-details {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .order-details-row {
            display: table-row;
        }
        
        .order-details-cell {
            display: table-cell;
            width: 50%;
            padding: 2px 5px;
            border: 1px solid #ccc;
            font-size: 9px;
        }
        
        .order-details-label {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        
        .work-method-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .work-method-table th,
        .work-method-table td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
            font-size: 8px;
        }
        
        .work-method-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .observations-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .observations-table th,
        .observations-table td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            font-size: 7px;
        }
        
        .observations-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .color-indicator {
            width: 15px;
            height: 15px;
            border: 1px solid #000;
            display: inline-block;
            margin-right: 5px;
        }
        
        .blue { background-color: #007bff; }
        .yellow { background-color: #ffc107; }
        .green { background-color: #28a745; }
        .cyan { background-color: #17a2b8; }
        .red { background-color: #dc3545; }
        
        .weight-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .weight-table th,
        .weight-table td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
            font-size: 9px;
        }
        
        .weight-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .tracking-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .tracking-table th,
        .tracking-table td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            font-size: 8px;
        }
        
        .tracking-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .materials-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .materials-table th,
        .materials-table td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            font-size: 8px;
        }
        
        .materials-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .section-title {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 5px;
            font-weight: bold;
            font-size: 12px;
            margin: 20px 0 10px 0;
        }
    </style>
</head>
<body>

<!-- PRIMERA PÁGINA: HOJA DE PRODUCCIÓN -->
<div class="page">
    <div class="header">
        <div class="company-logo">ICM</div>
        <div class="company-tagline">CREAMOS SOLUCIONES DE FUTURO</div>
        <div class="document-title">HOJA DE PRODUCCIÓN</div>
        <div class="document-ref">R-07-01</div>
    </div>

    <div class="order-details">
        <div class="order-details-row">
            <div class="order-details-cell order-details-label">Obra N°:</div>
            <div class="order-details-cell">{{ $colaTrabajo->codigo_trabajo }}</div>
            <div class="order-details-cell order-details-label">Cliente:</div>
            <div class="order-details-cell">{{ $colaTrabajo->pieza->pedido->cliente->nombre ?? 'N/A' }}</div>
        </div>
        <div class="order-details-row">
            <div class="order-details-cell order-details-label">Cód. Artículo:</div>
            <div class="order-details-cell">{{ $colaTrabajo->pieza->codigo ?? 'N/A' }}</div>
            <div class="order-details-cell order-details-label">Denominación:</div>
            <div class="order-details-cell">{{ $colaTrabajo->pieza->nombre ?? 'N/A' }}</div>
        </div>
        <div class="order-details-row">
            <div class="order-details-cell order-details-label">Fecha Inicio:</div>
            <div class="order-details-cell">{{ $colaTrabajo->fecha_inicio_estimada ? $colaTrabajo->fecha_inicio_estimada->format('d/m/Y') : 'N/A' }}</div>
            <div class="order-details-cell order-details-label">Fecha Fin:</div>
            <div class="order-details-cell">{{ $colaTrabajo->fecha_fin_estimada ? $colaTrabajo->fecha_fin_estimada->format('d/m/Y') : 'N/A' }}</div>
        </div>
        <div class="order-details-row">
            <div class="order-details-cell order-details-label">Fecha Entrega:</div>
            <div class="order-details-cell">{{ $colaTrabajo->pieza->pedido->fecha_entrega ? \Carbon\Carbon::parse($colaTrabajo->pieza->pedido->fecha_entrega)->format('d/m/Y') : 'N/A' }}</div>
            <div class="order-details-cell order-details-label">Pedido:</div>
            <div class="order-details-cell">{{ $colaTrabajo->pieza->pedido->numero_pedido ?? 'N/A' }}</div>
        </div>
        <div class="order-details-row">
            <div class="order-details-cell order-details-label">Puntos Asignados:</div>
            <div class="order-details-cell">{{ number_format($colaTrabajo->tiempo_estimado_horas ?? 0, 2, ',', '.') }}</div>
            <div class="order-details-cell order-details-label">Puntos Invertidos:</div>
            <div class="order-details-cell">0,00</div>
        </div>
        <div class="order-details-row">
            <div class="order-details-cell order-details-label">Dif. Puntos:</div>
            <div class="order-details-cell">{{ number_format(($colaTrabajo->tiempo_estimado_horas ?? 0) - 0, 2, ',', '.') }}</div>
            <div class="order-details-cell order-details-label">CANTIDAD:</div>
            <div class="order-details-cell">1</div>
        </div>
    </div>

    <h4>MÉTODO DE TRABAJO</h4>
    <table class="work-method-table">
        <thead>
            <tr>
                <th>NUMERACIÓN</th>
                <th>OPERACIÓN<br><small>ELEGIR BIEN EL TIPO DE MATERIAL</small></th>
                <th>Autoc.</th>
                <th>PUNTOS ASIGNADOS</th>
                <th>TERMINACIÓN<br><small>PUNTOS ASIGNADOS</small></th>
            </tr>
        </thead>
        <tbody>
            @if($colaTrabajo->tipoTrabajo)
            <tr>
                <td>1</td>
                <td>{{ $colaTrabajo->tipoTrabajo->nombre }}</td>
                <td></td>
                <td>{{ number_format($colaTrabajo->tiempo_estimado_horas ?? 0, 2, ',', '.') }}</td>
                <td></td>
            </tr>
            @endif
            <tr>
                <td>2</td>
                <td>Corte Agua</td>
                <td></td>
                <td>110,00</td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Corte Láser A/C</td>
                <td></td>
                <td>250,00</td>
                <td></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Corte Láser INOX - ALUMINIO (1 a 3 MM)</td>
                <td></td>
                <td>15,00</td>
                <td></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Corte Láser INOX - ALUMINIO (4 a 6 MM)</td>
                <td></td>
                <td>30,00</td>
                <td></td>
            </tr>
            <tr>
                <td>7</td>
                <td>Corte Láser INOX (+ 10 MM)</td>
                <td></td>
                <td>125,00</td>
                <td></td>
            </tr>
            <tr>
                <td>8</td>
                <td>Cizalla, Plegadora y/o Cilindrado</td>
                <td></td>
                <td>175,00</td>
                <td></td>
            </tr>
            <tr>
                <td>9</td>
                <td>Corte Sierra</td>
                <td></td>
                <td>100,00</td>
                <td></td>
            </tr>
            <tr>
                <td>10</td>
                <td>Montaje y Punteado de Piezas</td>
                <td></td>
                <td>3.125,00</td>
                <td></td>
            </tr>
            <tr>
                <td>11</td>
                <td>Torno y Fresa</td>
                <td></td>
                <td>600,00</td>
                <td></td>
            </tr>
            <tr>
                <td>12</td>
                <td>Soldadura A/C</td>
                <td></td>
                <td>2.000,00</td>
                <td></td>
            </tr>
            <tr>
                <td>17</td>
                <td>Carga y Embalaje</td>
                <td></td>
                <td>75,00</td>
                <td></td>
            </tr>
            <tr>
                <td>18</td>
                <td>Control Dimensional (Mínimo 1 pieza de cada 10)</td>
                <td></td>
                <td>50,00</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <h4>OBSERVACIONES</h4>
    <table class="observations-table">
        <thead>
            <tr>
                <th>COMERCIAL</th>
                <th>JUANO</th>
                <th>JEFE TALLER</th>
                <th>ZAMBRANO</th>
            </tr>
            <tr>
                <th><small>COLOR</small></th>
                <th><small>PROCESO</small></th>
                <th><small>TOLERANCIA</small></th>
                <th><small>TOLERANCIA CLIENTE</small></th>
                <th><small>OBSERVACIONES</small></th>
                <th><small>VISTO BUENO POR</small></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span class="color-indicator blue"></span></td>
                <td>OF. TECNICA</td>
                <td>REV. ESCALA</td>
                <td>N/A</td>
                <td>FIRMA</td>
                <td></td>
            </tr>
            <tr>
                <td><span class="color-indicator yellow"></span></td>
                <td>LASER</td>
                <td>CANTIDADES COLADA</td>
                <td>N/A</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><span class="color-indicator green"></span></td>
                <td>PLEGADO</td>
                <td>+/- 1MM</td>
                <td>N/A</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><span class="color-indicator cyan"></span></td>
                <td>TORNO</td>
                <td>H7</td>
                <td>N/A</td>
                <td>ANOTAR EN CNC Y/O PLANOS</td>
                <td></td>
            </tr>
            <tr>
                <td><span class="color-indicator red"></span></td>
                <td>MONTAJE</td>
                <td>+/- 1MM (100MM)</td>
                <td>N/A</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>+/- 1.5MM (2000MM)</td>
                <td>N/A</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>+/- 2MM (>2000MM)</td>
                <td>N/A</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <p><strong>Observaciones del artículo:</strong></p>
        <p style="border-bottom: 1px solid #000; min-height: 20px;">{{ $colaTrabajo->notas ?? '' }}</p>
        
        <p><strong>Observaciones del pedido:</strong></p>
        <p style="border-bottom: 1px solid #000; min-height: 20px;"></p>
    </div>

    <table class="weight-table" style="margin-top: 20px;">
        <tr>
            <th>PESO (KG)</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>

<!-- SEGUNDA PÁGINA: HOJA DE SEGUIMIENTO -->
<div class="page">
    <div class="section-title">MATERIALES OBRA</div>
    
    <table class="tracking-table">
        <thead>
            <tr>
                <th>FECHA</th>
                <th>OPERACIÓN</th>
                <th>NOMBRE DEL OPERARIO</th>
                <th>COD. OPERARIO</th>
                <th>TOTAL PUNTOS</th>
                <th>OBSERVACIONES</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 1; $i <= 25; $i++)
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endfor
        </tbody>
    </table>

    <div class="section-title">MATERIALES OBRA</div>
    
    <table class="materials-table">
        <thead>
            <tr>
                <th>MATERIAL</th>
                <th>CANTIDAD</th>
                <th>COSTE</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 1; $i <= 15; $i++)
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endfor
        </tbody>
    </table>
</div>

</body>
</html>
