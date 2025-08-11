<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Models\Models\Produccion\ArchivoPieza;
use App\Models\Models\Produccion\Pieza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArchivoPiezaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pieza_id' => 'required|exists:piezas,id',
            'archivo' => 'required|file|max:51200', // 50MB max
            'tipo_archivo' => 'required|in:plano_pdf,plano_daw,plano_dwg,imagen,documento,especificacion,otro',
            'descripcion' => 'nullable|string',
            'es_principal' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $pieza = Pieza::findOrFail($request->pieza_id);
            $file = $request->file('archivo');

            // Generar nombre único para el archivo
            $extension = $file->getClientOriginalExtension();
            $nombreArchivo = uniqid() . '_' . time() . '.' . $extension;

            // Guardar archivo
            $rutaArchivo = $file->storeAs('piezas/archivos', $nombreArchivo, 'public');

            // Crear registro en base de datos
            $archivoPieza = ArchivoPieza::create([
                'pieza_id' => $request->pieza_id,
                'nombre_archivo' => $nombreArchivo,
                'nombre_original' => $file->getClientOriginalName(),
                'ruta_archivo' => $rutaArchivo,
                'extension' => $extension,
                'tipo_archivo' => $request->tipo_archivo,
                'descripcion' => $request->descripcion,
                'tamaño_mb' => $file->getSize() / 1024 / 1024, // Convertir a MB
                'hash_archivo' => hash_file('sha256', $file->getRealPath()),
                'usuario_subido_id' => auth()->id(),
                'es_principal' => $request->boolean('es_principal', false)
            ]);

            // Si es principal, desmarcar otros archivos principales
            if ($archivoPieza->es_principal) {
                ArchivoPieza::where('pieza_id', $request->pieza_id)
                    ->where('id', '!=', $archivoPieza->id)
                    ->update(['es_principal' => false]);
            }

            // Actualizar estado de archivos en la pieza
            $pieza->actualizarEstadoArchivos();

            return redirect()->back()
                ->with('success', 'Archivo subido exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al subir el archivo: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArchivoPieza $archivo)
    {
        try {
            // Eliminar archivo físico
            if (Storage::disk('public')->exists($archivo->ruta_archivo)) {
                Storage::disk('public')->delete($archivo->ruta_archivo);
            }

            // Eliminar registro
            $archivo->delete();

            // Actualizar estado de archivos en la pieza
            $archivo->pieza->actualizarEstadoArchivos();

            return redirect()->back()
                ->with('success', 'Archivo eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el archivo: ' . $e->getMessage());
        }
    }

    /**
     * Descargar archivo
     */
    public function download(ArchivoPieza $archivo)
    {
        try {
            if (!Storage::disk('public')->exists($archivo->ruta_archivo)) {
                abort(404, 'Archivo no encontrado');
            }

            return Storage::disk('public')->download(
                $archivo->ruta_archivo,
                $archivo->nombre_original
            );

        } catch (\Exception $e) {
            abort(404, 'Error al descargar el archivo');
        }
    }

    /**
     * Ver archivo
     */
    public function view(ArchivoPieza $archivo)
    {
        try {
            if (!Storage::disk('public')->exists($archivo->ruta_archivo)) {
                abort(404, 'Archivo no encontrado');
            }

            // Verificar si es un archivo visualizable
            if (!$archivo->es_visualizable) {
                abort(400, 'Este tipo de archivo no se puede visualizar');
            }

            $mimeType = Storage::disk('public')->mimeType($archivo->ruta_archivo);
            $contents = Storage::disk('public')->get($archivo->ruta_archivo);

            return response($contents)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="' . $archivo->nombre_original . '"');

        } catch (\Exception $e) {
            abort(404, 'Error al visualizar el archivo');
        }
    }

    /**
     * Marcar archivo como principal
     */
    public function marcarPrincipal(ArchivoPieza $archivo)
    {
        try {
            // Desmarcar otros archivos principales de la misma pieza
            ArchivoPieza::where('pieza_id', $archivo->pieza_id)
                ->where('id', '!=', $archivo->id)
                ->update(['es_principal' => false]);

            // Marcar este archivo como principal
            $archivo->update(['es_principal' => true]);

            return redirect()->back()
                ->with('success', 'Archivo marcado como principal exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al marcar como principal: ' . $e->getMessage());
        }
    }
}
