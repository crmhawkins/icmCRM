# Orden Correcto de Migraciones para icmCRM

## 1. Tablas Base del Sistema (Sin dependencias)
- `001_create_users_table.php` - Tabla users de Laravel
- `002_create_password_reset_tokens_table.php` - Tokens de reset de contraseña
- `003_create_password_resets_table.php` - Reset de contraseñas (legacy)
- `004_create_failed_jobs_table.php` - Jobs fallidos
- `005_create_personal_access_tokens_table.php` - Tokens de acceso personal

## 2. Tablas de Usuarios y Permisos
- `01_admin_user_access_level.php` - Niveles de acceso
- `02_admin_user_department.php` - Departamentos
- `03_admin_user_position.php` - Posiciones
- `04_create_users_table.php` - Tabla admin_user principal

## 3. Tablas de Clientes y Contactos
- `05_clients.php` - Tabla de clientes
- `06_clientes_emails.php` - Emails de clientes
- `07_clientes_faxes.php` - Faxes de clientes
- `08_clientes_phones.php` - Teléfonos de clientes
- `09_clientes_webs.php` - Webs de clientes
- `11_civil_status.php` - Estados civiles
- `12_contacts.php` - Tabla de contactos
- `13_clientes_x_contactos.php` - Relación clientes-contactos
- `14_contacts_emails.php` - Emails de contactos
- `15_contacts_faxes.php` - Faxes de contactos
- `16_contacts_phones.php` - Teléfonos de contactos
- `17_contacts_webs.php` - Webs de contactos
- `18_contact_by.php` - Tipos de contacto

## 4. Tablas de Presupuestos y Servicios
- `19_budget_status.php` - Estados de presupuestos
- `15_update_services.php` - Servicios
- `16_update_budgets_concepts.php` - Conceptos de presupuestos
- `17_update_budget_concept_supplier_requests.php` - Solicitudes de proveedores
- `18_update_budget_concept_supplier_units.php` - Unidades de proveedores
- `14_update_budgets.php` - Presupuestos principales
- `19_update_purcharse_order.php` - Órdenes de compra
- `20_update_budgets_sends.php` - Envíos de presupuestos

## 5. Tablas Comerciales
- `21_update_commercial_commission.php` - Comisiones comerciales
- `22_update_commercial_contracts.php` - Contratos comerciales

## 6. Tablas de Actividades CRM
- `23_update_crm_activities_calls.php` - Llamadas CRM
- `24_update_crm_activities_mails.php` - Emails CRM
- `25_update_crm_activities_meetings.php` - Reuniones CRM
- `26_update_crm_activities_meetings_comments.php` - Comentarios de reuniones
- `27_update_crm_activities_meetings_x_users.php` - Usuarios en reuniones
- `28_update_crm_activities_notes.php` - Notas CRM
- `29_update_crm_activities_tasks.php` - Tareas CRM

## 7. Tablas de Dominios y Vacaciones
- `30_update_dominios.php` - Dominios
- `31_update_holidays.php` - Vacaciones
- `32_update_holidays_additions.php` - Adiciones de vacaciones
- `33_update_holidays_petition.php` - Peticiones de vacaciones

## 8. Tablas de Facturación
- `34_update_invoices.php` - Facturas
- `35_update_invoice_concepts.php` - Conceptos de facturación

## 9. Tablas de Newsletter
- `36_update_newsletters.php` - Newsletters
- `37_update_newsletters_favourites.php` - Favoritos de newsletter

## 10. Tablas de Configuración
- `38_update_admin_users_notes.php` - Notas de usuarios
- `39_update_company_passwords.php` - Contraseñas de empresa
- `40_update_purchase_order.php` - Órdenes de compra
- `41_update_survey_clients.php` - Encuestas de clientes

## 11. Tablas de Tareas y Productividad
- `42_update_tasks.php` - Tareas
- `43_update_ingresos.php` - Ingresos
- `44_update_gasto.php` - Gastos
- `45_update_create__petitions.php` - Peticiones
- `46_update_create_schedules_table.php` - Horarios
- `47_update_create_jornada.php` - Jornadas
- `48_update_create_pauses.php` - Pausas
- `49_update_create__alerts.php` - Alertas
- `50_update_create_events_table.php` - Eventos

## 12. Tablas de Mensajería
- `51_update_create_to-dos_table.php` - To-dos
- `52_update_create_message_reads_table.php` - Lecturas de mensajes
- `53_update_create_messages_table.php` - Mensajes

## 13. Tablas de Productividad
- `54_update_create_todo_users_table.php` - Usuarios de to-dos
- `55_update_create_last_years_balance.php` - Balance del año anterior

## 14. Tablas de Incidencias y Logs
- `56_update_create_incidences.php` - Incidencias
- `57_update_create_log_tasks.php` - Logs de tareas
- `58_update_create_llamadas.php` - Llamadas

## 15. Tablas de Configuración Avanzada
- `59_update_create_trello_config_user.php` - Configuración Trello
- `60_update_create_trello_meta.php` - Meta Trello
- `61_update_associated_expenses.php` - Gastos asociados
- `62_update_commercial_have_employee.php` - Empleados comerciales

## 16. Migraciones de 2024 (Nuevas funcionalidades)
- `2024_02_15_145611_mensaje.php` - Mensajes
- `2024_07_30_145611_respuestas_mensajes.php` - Respuestas de mensajes
- `2024_07_30_145612_mensaje_actualizar.php` - Actualización de mensajes
- `2024_09_03_080805_kit_digital.php` - Kit digital
- `2024_09_04_065239_kit_digital_estados.php` - Estados kit digital
- `2024_09_04_065244_kit_digital_servicios.php` - Servicios kit digital
- `2024_09_04_065805_update_kit_digital.php` - Actualización kit digital
- `2024_10_01_114128_create_emails_table.php` - Tabla de emails
- `2024_10_01_135554_status_email.php` - Estados de email
- `2024_10_01_135650_category_email.php` - Categorías de email
- `2024_10_02_135309_update_email.php` - Actualización de emails
- `2024_10_03_083659_alter_meetings_x_users.php` - Alteración reuniones-usuarios
- `2024_10_03_085320_create_crm_activities_meetings_x_contact.php` - Reuniones-contactos
- `2024_10_08_074211_create_log_actions.php` - Logs de acciones
- `2024_10_08_083054_alter_log_actions.php` - Alteración logs de acciones
- `2024_10_08_104630_create_logs_tipes_table.php` - Tipos de logs
- `2024_10_11_111332_create_user_email_configs.php` - Configuraciones de email

## 17. Migraciones Numeradas (Sistema alternativo)
- `3518_contact_by.php` - Tipos de contacto
- `35601_tast-status.php` - Estados de tareas
- `35602_task.php` - Tareas
- `3580_create_incidences_status.php` - Estados de incidencias
- `3581_create_incidences.php` - Incidencias
- `3582_estados_diario.php` - Estados diarios
- `3583_create_log_tasks.php` - Logs de tareas
- `3584_create_balance_trimestre.php` - Balance trimestral
- `3585_create_llamadas.php` - Llamadas
- `3586_create_trello_config_user.php` - Configuración Trello
- `3587_create_trello_meta.php` - Meta Trello
- `3588_associated_expenses.php` - Gastos asociados

## Notas Importantes:
1. Las migraciones con `update_` en el nombre son modificaciones de tablas existentes
2. Las migraciones con `alter_` son alteraciones de estructura
3. Las migraciones con `create_` crean nuevas tablas
4. Las migraciones numeradas (35xx) parecen ser un sistema alternativo de versionado

## Recomendación:
Ejecutar las migraciones en este orden para evitar errores de dependencias de foreign keys. 
