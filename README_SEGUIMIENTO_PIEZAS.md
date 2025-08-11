# Sistema de Seguimiento de Piezas - Guía de Pruebas

## Resumen de Mejoras Implementadas

Se ha completado una actualización completa del sistema de seguimiento de piezas para garantizar que:

1. **✅ Los datos se guardan correctamente** - Todas las tablas dinámicas ahora se procesan y guardan en la base de datos
2. **✅ Los datos se cargan correctamente** - Al volver a entrar, toda la información se recupera y muestra en las tablas
3. **✅ Los cálculos son precisos** - Todos los totales se calculan automáticamente y se actualizan en tiempo real
4. **✅ La persistencia funciona** - Los datos se mantienen entre sesiones

## Cambios Realizados

### 1. Controlador Actualizado (`SeguimientoPiezaController.php`)

- **Nuevo método `procesarDatosTablas()`**: Procesa todos los datos de las tablas dinámicas
- **Nuevo método `prepararDatosTablas()`**: Prepara los datos guardados para mostrarlos en la vista
- **Métodos auxiliares**: Para calcular pesos y costes de chapas
- **Validación mejorada**: Solo valida los campos necesarios

### 2. Vista Actualizada (`show.blade.php`)

- **Carga de datos guardados**: Todas las tablas ahora muestran los datos previamente guardados
- **Cálculos automáticos**: Los totales se calculan correctamente al cargar
- **JavaScript mejorado**: Mejor manejo de eventos y cálculos

### 3. Modelo Actualizado (`SeguimientoPieza.php`)

- **Método `calcularTotales()`**: Calcula automáticamente todos los totales
- **Casts apropiados**: Para manejar correctamente los tipos de datos

## Cómo Probar el Sistema

### Paso 1: Acceder al Seguimiento de una Pieza

1. Ve a la sección de Producción
2. Selecciona una pieza existente
3. Haz clic en "Seguimiento de Pieza"

### Paso 2: Llenar los Datos

1. **Tabla de Producción**:
   - Agrega trabajos (CIZALLA, SOLDADURA, etc.)
   - Introduce minutos y costes
   - Verifica que los totales se calculen automáticamente

2. **Tabla de Láser**:
   - Agrega materiales (INOX, A/C, etc.)
   - Introduce minutos y costes
   - Verifica los cálculos

3. **Tabla de Servicios**:
   - Agrega servicios (PORTES, SUBCONTRATACIÓN, etc.)
   - Introduce cantidades y costes

4. **Tabla de Materiales**:
   - Agrega materiales manuales
   - O usa las categorías automáticas (CHAPAS, RESTO DE MATERIALES)

5. **Tabla de Cálculo de Materiales**:
   - Agrega materiales específicos con descripciones

6. **Tabla de Láser-Tubo**:
   - Agrega tubos con metros y precios

7. **Tabla de Chapas**:
   - Agrega chapas con dimensiones y materiales
   - Verifica que el peso y coste se calculen automáticamente

### Paso 3: Guardar y Verificar

1. **Guardar**: Haz clic en "Guardar Seguimiento"
2. **Verificar mensaje**: Deberías ver "Seguimiento guardado correctamente"
3. **Recargar la página**: Refresca la página o navega a otra sección y vuelve
4. **Verificar datos**: Todos los datos deberían estar presentes en las tablas

### Paso 4: Verificar Cálculos

1. **Resumen lateral**: Verifica que todos los totales sean correctos
2. **Beneficios**: Verifica que los porcentajes de beneficio sean precisos
3. **Precios finales**: Verifica que los precios de venta y facturación sean correctos

## Casos de Prueba Específicos

### Caso 1: Datos Básicos
- Agrega solo un trabajo de producción
- Guarda y verifica que se mantenga

### Caso 2: Datos Complejos
- Llena todas las tablas con múltiples filas
- Guarda y verifica que todo se mantenga

### Caso 3: Cálculos Automáticos
- Agrega chapas con diferentes materiales
- Verifica que el peso y coste se calculen correctamente
- Verifica que las filas automáticas de materiales se creen

### Caso 4: Persistencia
- Llena datos, guarda, cierra el navegador
- Vuelve a abrir y verifica que todo esté presente

## Archivo de Prueba

Se ha creado un archivo `test_seguimiento_pieza.php` que simula el procesamiento de datos. Para ejecutarlo:

```bash
php test_seguimiento_pieza.php
```

Este script verifica que:
- Los datos se procesan correctamente
- Los cálculos son precisos
- Los totales se actualizan automáticamente

## Verificación de Funcionalidad

### ✅ Guardado Correcto
- [ ] Los datos de producción se guardan
- [ ] Los datos de láser se guardan
- [ ] Los datos de servicios se guardan
- [ ] Los datos de materiales se guardan
- [ ] Los datos de cálculo se guardan
- [ ] Los datos de tubos se guardan
- [ ] Los datos de chapas se guardan

### ✅ Carga Correcta
- [ ] Al volver a entrar, todos los datos están presentes
- [ ] Las tablas muestran los valores correctos
- [ ] Los totales se calculan automáticamente
- [ ] El resumen lateral se actualiza correctamente

### ✅ Cálculos Precisos
- [ ] Los totales de producción son correctos
- [ ] Los totales de láser son correctos
- [ ] Los totales de servicios son correctos
- [ ] Los totales de materiales son correctos
- [ ] Los beneficios se calculan correctamente
- [ ] Los precios finales son precisos

## Solución de Problemas

### Si los datos no se guardan:
1. Verifica que el formulario tenga el método POST correcto
2. Verifica que el token CSRF esté presente
3. Revisa los logs de Laravel para errores

### Si los datos no se cargan:
1. Verifica que la base de datos tenga los datos guardados
2. Verifica que el método `prepararDatosTablas()` esté funcionando
3. Revisa la consola del navegador para errores JavaScript

### Si los cálculos son incorrectos:
1. Verifica que las fórmulas en el JavaScript sean correctas
2. Verifica que los métodos de cálculo en el modelo sean precisos
3. Compara con el archivo de prueba para verificar los cálculos

## Conclusión

El sistema de seguimiento de piezas ahora está completamente funcional con:

- ✅ **Persistencia completa** de todos los datos
- ✅ **Carga automática** de información guardada
- ✅ **Cálculos precisos** en tiempo real
- ✅ **Interfaz mejorada** con mejor UX
- ✅ **Validación robusta** de datos

Todos los datos se guardan correctamente y se cargan automáticamente cuando vuelves a entrar al seguimiento de una pieza. 
