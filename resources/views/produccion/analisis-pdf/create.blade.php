@extends('layouts.app')

@section('title', 'Análisis de PDF con IA')

@section('css')
<!-- Bootstrap CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
/* Estilos personalizados para análisis PDF */
.page-heading {
    margin-bottom: 0 !important;
}

.card {
    border: 1px solid rgba(0,0,0,.125) !important;
    transition: all 0.3s ease !important;
    background-color: #ffffff !important;
    margin-bottom: 1rem !important;
    height: 100% !important;
}

.card:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
}

.card-header {
    background-color: #f8f9fa !important;
    border-bottom: 1px solid rgba(0,0,0,.125) !important;
    padding: 1rem !important;
}

.card-title {
    margin-bottom: 0 !important;
    color: #495057 !important;
    font-weight: 600 !important;
}

.alert {
    border: 1px solid transparent !important;
    border-radius: 0.375rem !important;
}

.alert-info {
    background-color: #d1ecf1 !important;
    border-color: #bee5eb !important;
    color: #0c5460 !important;
}

.alert-warning {
    background-color: #fff3cd !important;
    border-color: #ffeaa7 !important;
    color: #856404 !important;
}

.btn {
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

.btn-lg {
    padding: 0.75rem 1.5rem !important;
    font-size: 1.125rem !important;
    border-radius: 0.5rem !important;
}

.form-control {
    border: 1px solid #ced4da !important;
    border-radius: 0.375rem !important;
    padding: 0.5rem 0.75rem !important;
}

.form-control:focus {
    border-color: #86b7fe !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
}

.form-label {
    font-weight: 600 !important;
    color: #495057 !important;
    margin-bottom: 0.5rem !important;
}

.form-text {
    color: #6c757d !important;
    font-size: 0.875rem !important;
}

/* Responsive */
@media (max-width: 768px) {
    .row.g-4 {
        margin-left: -0.5rem !important;
        margin-right: -0.5rem !important;
    }

    .col-lg-6 {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }
}

/* Drag & Drop Zone */
.drag-drop-zone {
    border: 2px dashed #dee2e6 !important;
    border-radius: 0.5rem !important;
    padding: 2rem !important;
    text-align: center !important;
    transition: all 0.3s ease !important;
    background-color: #f8f9fa !important;
    min-height: 200px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.drag-drop-zone:hover {
    border-color: #0d6efd !important;
    background-color: #e7f1ff !important;
}

.drag-drop-zone.dragover {
    border-color: #0d6efd !important;
    background-color: #e7f1ff !important;
    transform: scale(1.02) !important;
}

.drag-drop-content {
    width: 100% !important;
}

.drag-drop-zone .fa-3x {
    color: #6c757d !important;
}

.drag-drop-zone:hover .fa-3x {
    color: #0d6efd !important;
}

/* File Selected */
.file-selected {
    background-color: #ffffff !important;
    border: 1px solid #dee2e6 !important;
    border-radius: 0.5rem !important;
    padding: 1rem !important;
    margin-top: 1rem !important;
}

.file-selected .fa-file-pdf {
    color: #dc3545 !important;
}

/* Spacing improvements */
.row.g-4.mb-4 {
    margin-bottom: 2rem !important;
}

.row.mb-4 {
    margin-bottom: 2rem !important;
}

.card {
    margin-bottom: 1.5rem !important;
}

.card:last-child {
    margin-bottom: 0 !important;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-heading card" style="box-shadow: none !important">
        {{-- Titulos --}}
        <div class="page-title card-body p-3">
            <div class="row justify-content-between">
                <div class="col-12 col-md-4 order-md-1 order-first">
                    <h3><i class="fas fa-robot"></i> Análisis de PDF con IA</h3>
                    <p class="text-subtitle text-muted">Procesamiento inteligente de pedidos</p>
                </div>

                <div class="col-12 col-md-4 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('produccion.dashboard') }}">Producción</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Análisis de PDF</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensajes de sesión -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Cards en la misma fila cuando hay espacio disponible -->
    <div class="row g-4">
        <!-- Card de Instrucciones -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Instrucciones
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Sube el PDF del pedido que quieres analizar</li>
                        <li>La IA extraerá automáticamente la información del pedido</li>
                        <li>Revisa los datos extraídos antes de crear el pedido</li>
                        <li>Puedes reprocesar si la información no es correcta</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Card de Tiempo de Procesamiento -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock me-2"></i>Tiempo de procesamiento
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>PDFs pequeños (1-2 páginas): 10-30 segundos</li>
                        <li>PDFs grandes (3+ páginas): 1-2 minutos</li>
                        <li>No cierres la página durante el procesamiento</li>
                        <li>Si tarda más de 2 minutos, el sistema usará datos simulados</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de Subida -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-upload me-2"></i>Subir PDF para Análisis
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('analisis-pdf.analizar') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="archivo_pdf" class="form-label">Archivo PDF del Pedido</label>
                            <input type="file" class="form-control @error('archivo_pdf') is-invalid @enderror"
                                   id="archivo_pdf" name="archivo_pdf" accept=".pdf" required>
                            <div class="form-text">
                                Máximo 10MB. Solo archivos PDF.
                            </div>
                            @error('archivo_pdf')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-robot me-2"></i>Analizar PDF con IA
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Información sobre el proceso -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-lightbulb me-2"></i>¿Qué hace la IA?
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-search me-2 text-primary"></i>Extracción de Datos</h6>
                            <p class="text-muted">La IA analiza el PDF y extrae automáticamente información como:</p>
                            <ul>
                                <li>Número de pedido</li>
                                <li>Datos del cliente</li>
                                <li>Lista de piezas y cantidades</li>
                                <li>Especificaciones técnicas</li>
                                <li>Fechas de entrega</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-cog me-2 text-success"></i>Procesamiento Inteligente</h6>
                            <p class="text-muted">El sistema procesa la información para:</p>
                            <ul>
                                <li>Validar datos extraídos</li>
                                <li>Identificar inconsistencias</li>
                                <li>Generar códigos de pieza</li>
                                <li>Calcular tiempos estimados</li>
                                <li>Crear estructura del pedido</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Análisis de PDF con IA inicializado con Bootstrap CDN');

    // Verificar que Bootstrap esté cargado
    if (typeof bootstrap !== 'undefined') {
        console.log('✅ Bootstrap cargado correctamente');

        // Inicializar tooltips si existen
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });

        console.log(`✅ ${tooltipTriggerList.length} tooltips de Bootstrap inicializados`);
    } else {
        console.error('❌ Bootstrap no está cargado');
    }

    // Verificar iconos de Font Awesome
    const iconos = document.querySelectorAll('.fas, .fa');
    console.log(`✅ ${iconos.length} iconos de Font Awesome encontrados`);

    // Verificar botones
    const botones = document.querySelectorAll('.btn');
    console.log(`✅ ${botones.length} botones encontrados`);

    // Inicializar Drag & Drop
    initializeDragAndDrop();

    console.log('✅ Análisis de PDF con IA inicializado correctamente');
});

// Funcionalidad de Drag & Drop
function initializeDragAndDrop() {
    const dragDropZone = document.getElementById('dragDropZone');
    const fileInput = document.getElementById('archivo_pdf');
    const fileSelected = document.getElementById('fileSelected');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const submitBtn = document.getElementById('submitBtn');

    // Prevenir comportamiento por defecto del navegador
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dragDropZone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    // Resaltar zona de drop
    ['dragenter', 'dragover'].forEach(eventName => {
        dragDropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dragDropZone.addEventListener(eventName, unhighlight, false);
    });

    // Manejar archivo soltado
    dragDropZone.addEventListener('drop', handleDrop, false);

    // Manejar archivo seleccionado manualmente
    fileInput.addEventListener('change', handleFileSelect);

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight(e) {
        dragDropZone.classList.add('dragover');
    }

    function unhighlight(e) {
        dragDropZone.classList.remove('dragover');
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
            const file = files[0];
            if (validateFile(file)) {
                fileInput.files = files;
                displayFileInfo(file);
            }
        }
    }

    function handleFileSelect(e) {
        const file = e.target.files[0];
        if (file) {
            displayFileInfo(file);
        }
    }

    function validateFile(file) {
        // Validar tipo de archivo
        if (file.type !== 'application/pdf') {
            alert('Por favor, selecciona solo archivos PDF.');
            return false;
        }

        // Validar tamaño (10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert('El archivo es demasiado grande. Máximo 10MB.');
            return false;
        }

        return true;
    }

    function displayFileInfo(file) {
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);

        // Mostrar información del archivo
        document.querySelector('.drag-drop-content').style.display = 'none';
        fileSelected.style.display = 'block';

        // Habilitar botón de envío
        submitBtn.disabled = false;

        console.log('✅ Archivo seleccionado:', file.name, 'Tamaño:', formatFileSize(file.size));
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
}

function removeFile() {
    const fileInput = document.getElementById('archivo_pdf');
    const fileSelected = document.getElementById('fileSelected');
    const submitBtn = document.getElementById('submitBtn');

    // Limpiar input
    fileInput.value = '';

    // Ocultar información del archivo
    fileSelected.style.display = 'none';
    document.querySelector('.drag-drop-content').style.display = 'block';

    // Deshabilitar botón de envío
    submitBtn.disabled = true;

    console.log('✅ Archivo removido');
}
</script>
@endpush
