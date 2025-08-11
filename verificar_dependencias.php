<?php

/**
 * Script para verificar dependencias de foreign keys en migraciones
 * Ejecutar: php verificar_dependencias.php
 */

echo "=== Verificación de Dependencias de Migraciones ===\n\n";

$migrationsDir = 'database/migrations/';
$migrations = glob($migrationsDir . '*.php');

$foreignKeys = [];
$tables = [];

// Analizar todas las migraciones
foreach ($migrations as $migration) {
    $content = file_get_contents($migration);
    $filename = basename($migration);

    // Extraer nombre de tabla
    if (preg_match('/Schema::create\s*\(\s*[\'"]([^\'"]+)[\'"]/', $content, $matches)) {
        $tableName = $matches[1];
        $tables[$filename] = $tableName;
    }

    // Extraer foreign keys - patrón corregido
    if (preg_match_all('/foreign\s*\(\s*[\'"]([^\'"]+)[\'"]\s*\)\s*->\s*references\s*\(\s*[\'"]([^\'"]+)[\'"]\s*\)\s*->\s*on\s*\(\s*[\'"]([^\'"]+)[\'"]/', $content, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            $foreignKeys[] = [
                'file' => $filename,
                'column' => $match[1],
                'references_table' => $match[2],
                'references_column' => $match[3]
            ];
        }
    }

    // Buscar también patrones alternativos de foreign keys
    if (preg_match_all('/foreign\s*\(\s*[\'"]([^\'"]+)[\'"]\s*\)\s*->\s*references\s*\(\s*[\'"]([^\'"]+)[\'"]/', $content, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            $foreignKeys[] = [
                'file' => $filename,
                'column' => $match[1],
                'references_table' => $match[2],
                'references_column' => 'id' // Por defecto
            ];
        }
    }
}

echo "Tablas encontradas:\n";
foreach ($tables as $file => $table) {
    echo "  - $file -> $table\n";
}

echo "\nForeign Keys encontradas:\n";
foreach ($foreignKeys as $fk) {
    echo "  - {$fk['file']}: {$fk['column']} -> {$fk['references_table']}.{$fk['references_column']}\n";
}

// Verificar dependencias
echo "\n=== Verificación de Dependencias ===\n";
$errors = [];

foreach ($foreignKeys as $fk) {
    $referencedTable = $fk['references_table'];
    $found = false;

    foreach ($tables as $file => $table) {
        if ($table === $referencedTable) {
            $found = true;
            break;
        }
    }

    if (!$found) {
        $errors[] = "ERROR: {$fk['file']} referencia tabla '$referencedTable' que no existe";
    }
}

if (empty($errors)) {
    echo "✅ Todas las dependencias están correctas\n";
} else {
    echo "❌ Errores encontrados:\n";
    foreach ($errors as $error) {
        echo "  $error\n";
    }
}

// Verificar orden de migraciones
echo "\n=== Verificación de Orden de Migraciones ===\n";
$orderedFiles = array_keys($tables);
sort($orderedFiles);

echo "Orden actual de migraciones:\n";
foreach ($orderedFiles as $index => $file) {
    echo "  " . ($index + 1) . ". $file -> {$tables[$file]}\n";
}

echo "\n=== Recomendaciones ===\n";
echo "1. Las migraciones deben ejecutarse en orden alfabético\n";
echo "2. Las tablas referenciadas deben crearse antes que las que las referencian\n";
echo "3. Usar el script reorganizar_migraciones.ps1 para reordenar automáticamente\n";
echo "4. Ejecutar: php artisan migrate:fresh después de reorganizar\n";

?>
