<?php
/**
* Profile Manager
*
* Spanish language
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

return [

	// entity names
	'item:object:custom_profile_field' => 'Campo personalizado de perfil',
	'item:object:custom_profile_field_category' => 'Categoría del campo personalizado de perfil',
	'item:object:custom_profile_type' => 'Tipo de campo personalizado de perfil',
	'item:object:custom_group_field' => 'Campo personalizado de grupo',

	'profile:custom_profile_type' => 'Tipo de perfil personalizado',

	// admin menu
	'admin:appearance:group_fields' => "Editar campos del grupo",
	'admin:appearance:export_fields' => "Exportar datos del perfil",

	'admin:groups' => "Grupos",
	'admin:groups:export' => "Exportar grupos",

	'admin:users:export' => "Exportar usuarios",
	'admin:users:inactive' => "Listar usuarios inactivos",

	// plugin settings
	'profile_manager:settings:registration' => 'Registro',
	'profile_manager:settings:edit_profile' => 'Editar perfil',
	'profile_manager:settings:view_profile' => 'Ver perfil',
	'profile_manager:settings:group' => "Editar perfil de grupo",

	'profile_manager:settings:generate_username_from_email' => 'Generar nombre de usuario a partir del correo electrónico',
	'profile_manager:settings:profile_icon_on_register' => 'Agregar campo para subir imagen de perfil en el formulario de registro',
	'profile_manager:settings:profile_icon_on_register:option:optional' => 'Opcional',
	'profile_manager:settings:show_account_hints' => 'Mostrar consejos para las preguntas del formulario de registro por defecto',
	'profile_manager:settings:simple_access_control' => 'Mostrar solo un desplegable de control de acceso en el formulario de edición de perfil',
	'profile_manager:settings:default_profile_type' => "Tipo de perfil seleccionado por defecto en el formulario de registro",
	'profile_manager:settings:hide_profile_type_default' => "Ocultar el tipo de formulario por defecto ('Default') en el formulario de registro",

	'profile_manager:settings:edit_profile_mode' => "Cómo mostrar la pantalla de edición del perfil",
	'profile_manager:settings:edit_profile_mode:list' => "Lista",
	'profile_manager:settings:edit_profile_mode:tabbed' => "Pestañas",

	'profile_manager:settings:show_profile_type_on_profile' => "Mostrar el tipo perfil de usuaio en el perfil",

	'profile_manager:settings:display_categories' => 'Selecciona como se muestran las categorías en el perfil',
	'profile_manager:settings:display_categories:option:plain' => 'Plano',
	'profile_manager:settings:display_categories:option:accordion' => 'Acordeón',

	'profile_manager:settings:display_system_category' => 'Mostrar una categoría extra en el perfil con systemdata (solo para admins)',

	'profile_manager:settings:profile_type_selection' => '¿Quién puede cambiar el tipo de perfil?',
	'profile_manager:settings:profile_type_selection:option:user' => 'Usuario',
	'profile_manager:settings:profile_type_selection:option:admin' => 'Solo los administradores',

	'profile_manager:settings:enable_profile_completeness_widget' => "Habilitar el widget que muestra el grado de completado del pefil",
	'profile_manager:settings:enable_username_change' => "Permitir que los usuarios cambien su nombre de usuario",
	'profile_manager:settings:enable_username_change:option:admin' => "Solamente administradores",
	'profile_manager:settings:enable_site_join_river_event' => "Agregar un evento al river cuando alguien se registre en el sitio",

	'profile_manager:settings:registration:terms' => "Para mostrar una casilla de 'Aceptar términos de uso' en el formulario de registro, ingresa la URL a la página con los detellas de los Términos de Uso",
	'profile_manager:settings:registration:extra_fields' => "Dónode mostrar los campos extra de perfil",
	'profile_manager:settings:registration:extra_fields:extend' => "Debajo del formulario de registro",
	'profile_manager:settings:registration:extra_fields:beside' => "Al costado del formulario de registro",
	'profile_manager:settings:registration:free_text' => "Texto adicional para mostrar en el formulario de registro",

	'profile_manager:settings:group:group_limit_name' => "Número máximo de veces que el nombre de un grupo puede ser cambiado",
	'profile_manager:settings:group:group_limit_description' => "Número máximo de veces que la descripción de un grupo puede ser cambiado",
	'profile_manager:settings:group:limit:unlimited' => "Ilimitado",
	'profile_manager:settings:group:limit:info' => "Estos límites no se aplican a los administradores",

	// Field Configuration
	'profile_manager:admin:metadata_name' => 'Nombre',
	'profile_manager:admin:metadata_label' => 'Etiqueta',
	'profile_manager:admin:metadata_hint' => 'Consejo',
	'profile_manager:admin:metadata_placeholder' => 'Texto en el campo (placeholder)',
	'profile_manager:admin:metadata_options' => 'Opciones (separadas por coma)',
	'profile_manager:admin:field_type' => "Tipo de campo",
	'profile_manager:admin:options:dropdown' => 'Desplegable',
	'profile_manager:admin:options:radio' => 'Radio',
	'profile_manager:admin:options:multiselect' => 'Selección múltiple',
	'profile_manager:admin:options:file' => 'Archivo',
	'profile_manager:admin:options:pm_rating' => 'Rating',
	'profile_manager:admin:options:pm_twitter' => 'Twitter',
	'profile_manager:admin:options:pm_facebook' => 'Facebook',
	'profile_manager:admin:options:pm_linkedin' => 'LinkedIn',

	'profile_manager:admin:additional_options' => 'Opciones adicionales',
	'profile_manager:admin:show_on_register' => 'Mostrar en formulario de registro',
	'profile_manager:admin:mandatory' => 'Obligatorio',
	'profile_manager:admin:user_editable' => 'El usuario puede editar este campo',
	'profile_manager:admin:output_as_tags' => 'Mostrar en el perfil como etiquetas',
	'profile_manager:admin:admin_only' => 'Campo solo para administradores',
	'profile_manager:admin:count_for_completeness' => 'Contar este campo en el perfil de progreso de completado de perfil',
	'profile_manager:admin:blank_available' => 'El campo tiene una opción en blanco',
	'profile_manager:admin:option_unavailable' => 'Opción no disponible',

	// field options additionals description
	'profile_manager:admin:show_on_register:description' => "Si quieres que este campo aparezca en el formulario de registro",
	'profile_manager:admin:mandatory:description' => "Si quieres que este campo sea obligatorio (solo aplica al formulario de registro)",
	'profile_manager:admin:user_editable:description' => "Si se marca 'No', el usuario no puede editar este campo (útil cuando el dato se modifica mediante un sistema externo)",
	'profile_manager:admin:output_as_tags:description' => "La salida de datos se manejara como etiquetas",
	'profile_manager:admin:admin_only:description' => "Indica 'Si' para que solo lo puedan cambiar los admins",
	'profile_manager:admin:blank_available:description' => "Agrega una opción en blanco al campo",

	// profile fields
	'profile_manager:profile_fields:list:title' => "Campos del perfil",

	'profile_manager:profile_fields:no_fields' => "Actualmente no existe campos configurados con el plugin Profile Manager. Agrega los tuyos o importalos usando las siguientes opciones.",

	'profile_manager:profile_fields:add' => "Agregar un nuevo campo de perfil",
	'profile_manager:profile_fields:edit' => "Editar un campo de perfil",
	'profile_manager:profile_fields:add:description' => "Aqui puedes determinar cuales campos puede un usuario editar",

	// group fields
	'profile_manager:group_fields:list:title' => "Campos de perfl de grupo",

	'profile_manager:group_fields:add:description' => "Aqui puedes determinar cuales campos de un grupo se muestran",
	'profile_manager:group_fields:add' => "Agregar un nuego campo de perfil de grupo",
	'profile_manager:group_fields:edit' => "Editar un campo de perfil de grupo",

	// Custom fields categories
	'profile_manager:categories:add' => "Agregar una nueva categoría",
	'profile_manager:categories:edit' => "Editar una categoría",
	'profile_manager:categories:list:title' => "Categorías",
	'profile_manager:categories:list:default' => "Por defecto",
	'profile_manager:categories:list:system' => "Sistema (solo administradores)",
	'profile_manager:categories:list:view_all' => "Ver todos los campos",
	'profile_manager:categories:list:no_categories' => "No hay categorías definidas",
	'profile_manager:categories:delete:confirm' => "¿Estas seguro de eliminar esta categoría?",

	// Custom Profile Types
	'profile_manager:profile_types:add' => "Agregar un nuevo tipo de perfil",
	'profile_manager:profile_types:edit' => "Editar tipo de perfil",
	'profile_manager:profile_types:list:title' => "Tipos de perfil",
	'profile_manager:profile_types:list:no_types' => "No hay tipos de perfil definidos",
	'profile_manager:profile_types:delete:confirm' => "¿Estas seguro de querer eliminar este tipo de perfil",
	'profile_manager:user_details:profile_type' => "Tipo de perfil",

	// profile manager inactive users
	'profile_manager:admin:users:inactive:last_login' => "Último ingreso antes de",
	'profile_manager:admin:users:inactive:list' => "Usuario inactivos",

	// admin actions
	'profile_manager:actions:title' => 'Acciones',

	// Reset
	'profile_manager:actions:reset:description' => 'Eliminar todos los campos personzalidos del perfil',
	'profile_manager:actions:reset:confirm' => '¿Estas seguro de que quieres resetear todos los campos personalizados?',
	'profile_manager:actions:reset:error:unknown' => 'Un error desconocido ocurrió al resetar',
	'profile_manager:actions:reset:error:wrong_type' => 'Tipo de perfil erróneo',
	'profile_manager:actions:reset:success' => 'Reseteo exitoso',

	// import from custom
	'profile_manager:actions:import:from_custom' => 'Importar campos personalizados',
	'profile_manager:actions:import:from_custom:description' => 'Importar campos previamente definidos',
	'profile_manager:actions:import:from_custom:confirm' => '¿Estas seguro de querer importar campos personalizados?',
	'profile_manager:actions:import:from_custom:no_fields' => 'No hay campos personalizados para importar',
	'profile_manager:actions:import:from_custom:new_fields' => 'Se han importado exitosamente <b>%s</b> campos nuevos',

	// import from default
	'profile_manager:actions:import:from_default' => 'Importar campos por fefecto',
	'profile_manager:actions:import:from_default:description' => "Importa los campos de Elgg por defecto",
	'profile_manager:actions:import:from_default:confirm' => '¿Estas seguro de querer importar campos por defecto>',
	'profile_manager:actions:import:from_default:no_fields' => 'No hay campos disponibles para ser importados',
	'profile_manager:actions:import:from_default:new_fields' => 'Se importan exitosamente  <b>%s</b> nuevos campos',
	'profile_manager:actions:import:from_default:error:wrong_type' => 'Tipo de perfil erróneo',

	// Export
	'profile_manager:actions:export:description' => "Exportar datos de perfil a un archivo CSV",
	'profile_manager:export:title' => "Exportar datos de perfil",
	'profile_manager:export:description:custom_profile_field' => "Esta función exportara los datos de todos los usuarios teniendo en cuenta los campos seleccionados.",
	'profile_manager:export:description:custom_group_field' => "Esta función exportara los datos de todos los grupos teniendo en cuenta los campos seleccionados.",
	'profile_manager:export:list:title' => "Elige los campos que quieres que sean exportados",
	'profile_manager:export:list:include_group_membership' => "Incluír membresía de grupo",
	'profile_manager:export:nofields' => "No hay campos personalizados disponibles para exportar",

	// Group Edit
	'profile_manager:group:edit:limit' => "(Puedes editar este campo %s veces mas)",

	// Configuration Backup and Restore
	'profile_manager:actions:configuration:backup' => "Backup",
	'profile_manager:actions:configuration:backup:description' => "Backup de la configuración de estos campos (las categorías y los tipos no son incluídos en el backup)",
	'profile_manager:actions:configuration:restore' => "Restaurar",
	'profile_manager:actions:configuration:restore:description' => "Restaurar a partir de un backup previo",

	'profile_manager:actions:configuration:restore:upload' => "Restaurar",

	'profile_manager:actions:restore:success' => "La restauración fue exitosa",
	'profile_manager:actions:restore:error:deleting' => "Error al restaurar: no se pudieron eliminar los campos actuales",
	'profile_manager:actions:restore:error:fieldtype' => "Error al restaurar: el tipo de campos no coinciden",
	'profile_manager:actions:restore:error:corrupt' => "Error al restaurar: el archivo de backup parece estar corrupto o falta información",
	'profile_manager:actions:restore:error:json' => "Error al restaurar: no es un archivos JSON válido",
	'profile_manager:actions:restore:error:nofile' => "Error al restaurar: no se cargó el archivo",

	// new
	'profile_manager:actions:new:success' => 'El campo nuevo se agregó con éxito',
	'profile_manager:actions:new:error:metadata_name_missing' => 'No se indico nombre de metadatos',
	'profile_manager:actions:new:error:metadata_name_invalid' => 'El nombre de metadatos es inválido',
	'profile_manager:actions:new:error:metadata_options' => 'Debes ingresar opciones al usar este tipo de campo',
	'profile_manager:actions:new:error:unknown' => 'Se produjo un error desconocido',
	'profile_manager:action:new:error:type' => 'Tipo de campo de perfil erróneo',

	// edit
	'profile_manager:actions:edit:error:unknown' => 'Error al obtener los datos del campo',

	//delete
	'profile_manager:actions:delete:confirm' => '¿Estas seguro de querer borrar este campo?',
	'profile_manager:actions:delete:error:unknown' => 'Un error desconocido ocurrió al borrar el campo',

	// toggle option
	'profile_manager:actions:toggle_option:error:unknown' => 'Un error desconocido ocurrió al cambiar la opción',

	// category to field
	'profile_manager:actions:change_category:error:unknown' => "Un error desconocido ocurrió al cambiar la categoría",

	// add category
	'profile_manager:action:category:add:error:name' => "Nombre inválido para la categoría",
	'profile_manager:action:category:add:error:object' => "Error al crear la categoría",
	'profile_manager:action:category:add:error:save' => "Error al guardar la categoría",
	'profile_manager:action:category:add:succes' => "La categoría fue creada exitosamente",

	// delete category
	'profile_manager:action:category:delete:error:guid' => "No se indico el GUID",
	'profile_manager:action:category:delete:error:type' => "El GUID indicado no es de una categoría de campo personalizado",
	'profile_manager:action:category:delete:error:delete' => "Ocurrió un error el editar la categoría",
	'profile_manager:action:category:delete:succes' => "La categoría se eliminó correctamente",

	// add profile type
	'profile_manager:action:profile_types:add:error:name' => "Nombre inválido para el tipo de perfil personalizado",
	'profile_manager:action:profile_types:add:error:object' => "Error al crear el tipo de perfil personalizado",
	'profile_manager:action:profile_types:add:error:save' => "Error al guardar el tipo de perfil personalizado",
	'profile_manager:action:profile_types:add:succes' => "El tipo de perfil personalizado se guardó correctamente",

	// delete profile type
	'profile_manager:action:profile_types:delete:error:guid' => "No GUID provided",
	'profile_manager:action:profile_types:delete:error:type' => "El GUID indicado no es de una categoría de campo personalizado",
	'profile_manager:action:profile_types:delete:error:delete' => "Un error desconocido ocurrió al eliminar el tipo de perfil customizado",
	'profile_manager:action:profile_types:delete:succes' => "El tipo de perfil customizado fue eliminado correctamente",

	// change username action
	'profile_manager:action:username:change:succes' => "Su nombre de usuario se cambió correctamente",

	// Tooltips
	'profile_manager:tooltips:profile_field' => "
		<b>Campo personalizado</b><br />
		Aqui puedes agregar un nuevo campo para el perfil.<br /><br />
		Si dejas la eriqueta vacia, puedes internacionalizar la etiqueta del campo (<i>profile:[name]</i>).<br /><br />
		Usa el campo de consejo para indicar un mensaje que se muestra al pasar el mouse sore el icono de descripción al lado del campo.
		Si dejas el campo de consejo vacío, puedes internacionalizar el consejo (<i>profile:hint:[name]</i>).<br /><br />
		El campo de opciones obligatorio por el tipo de campos: <i>Desplegble, Radio y selección múltiple</i>.
	",
	'profile_manager:tooltips:profile_field_additional' => "
		<b>Mostrar en el registro</b><br />
		Si quieres que el campo este en el formulario de registro.<br /><br />

		<b>Obligatorio</b><br />
		Si quieres que el campo sea obligatorio en el formulario de registro.<br /><br />

		<b>Editable por el usuario</b><br />
		Si se indica 'No', los usuario no pueden cambiarlo.<br /><br />

		<b>Mostrar como etiquetas</b><br />
		La salida se muestra como etiquetas.<br /><br />

		<b>Solo administradores</b><br />
		Si se indica 'Si', solo estará disponible para los admins.
	",
	'profile_manager:tooltips:category' => "
		<b>Categoría</b><br />
		Here you can add a new profile category.<br /><br />
		If you leave the label empty, you can internationalize the category label (<i>profile:categories:[name]</i>).<br /><br />

		If Profile Types are defined you can choose on which profile type this category applies. If no profile is specified, the category applies to all profile types (even undefined).
	",
	'profile_manager:tooltips:category_list' => "
		<b>Categories</b><br />
		Shows a list of all configured categories.<br /><br />

		<i>Default</i> is the category that applies to all profiles.<br /><br />

		Add fields to these categories by dropping them on the categories.<br /><br />

		Click the category label to filter the visible fields. Clicking view all fields shows all fields.<br /><br />

		You can also change the order of the categories by dragging them (<i>Default can't be dragged</i>. <br /><br />

		Click the edit icon to edit the category.
	",
	'profile_manager:tooltips:profile_type' => "
		<b>Profile Type</b><br />
		Here you can add a new profile type.<br /><br />
		If you leave the label empty, you can internationalize the profile type label (<i>profile:types:[name]</i>).<br /><br />
		Enter a description which users can see when selecting this profile type or leave it empty to internationalize (<i>profile:types:[name]:description</i>).<br /><br />

		If Categories are defined you can choose which categories apply to this profile type.
	",
	'profile_manager:tooltips:profile_type_list' => "
		<b>Profile Types</b><br />
		Shows a list of all configured profile types.<br /><br />
		Click the edit icon to edit the profile type.
	",
	'profile_manager:tooltips:actions' => "
		<b>Actions</b><br />
		Various actions related to these profile fields.
	",

	// custom input/output views
	'profile_manager:pm_twitter:input:placeholder' => "Ingresa tu nombre de usuario de Twitter",
	'profile_manager:pm_twitter:output:follow' => "Seguir @%s",
	'profile_manager:pm_facebook:input:placeholder' => "Ingresa la URL de tu perfil de Facebook",
	'profile_manager:pm_linkedin:input:placeholder' => "Ingresa la URL de tu perfil de Linkedin",

	// widgets
	'widgets:profile_completeness:title' => 'Completitud del perfil',
	'widgets:profile_completeness:description' => 'Muestra cuan completa esta el perfil',
	'widgets:profile_completeness:view:tips' => 'Tip! Actualiza tu %s para mejorar la completitud de u perfil.',
	'widgets:profile_completeness:view:complete' => '¡Felicitaciones! Tu perfil esta totalmente completo',

	'widgets:register:title' => "Registración",
	'widgets:register:description' => "Mostrar caja de registro",
	'widgets:register:loggedout' => "Tienes que ingresar para usar este widget",

	'profile_manager:input:multi_select:empty_text' => 'Por favor seleccionar ...',

	// Edit profile => profile type selector
	'profile_manager:profile:edit:custom_profile_type:label' => "Selecciona tu tipo de perfil",
	'profile_manager:profile:edit:custom_profile_type:description' => "Descripción de tu tipo de perfil",
	'profile_manager:profile:edit:custom_profile_type:default' => "Por defecto",

	// register form mandatory notice
	'profile_manager:register:mandatory' => "Los campos marcados con * son obligatorios",

	// register account field hints
	'profile_manager:register:hints:name' => "Ingresa el nombre que se mostrará en tu perfil",
	'profile_manager:register:hints:username' => "Puedes usar tu nombre de usuario para ingresar",
	'profile_manager:register:hints:email' => "Usaremos esta dirección de correo electrónico para enviarte mensajes. Los otros usuario no pueden ver esta dirección",
	'profile_manager:register:hints:password' => "Tu contraseña para ingresar con tu usuario",
	'profile_manager:register:hints:passwordagain' => "Ingresa tu contraseña dos veces para validarla",

	// register profile icon
	'profile_manager:register:profile_icon' => 'Por favor, elige la imagen que usarás para identificar tu usuario',

	// register accept terms
	'profile_manager:registration:accept_terms' => "He leído y acepto los %sTérminos de Uso%s",

	// simple access control
	'profile_manager:simple_access_control' => 'Elige quien quieres que vea la información de tu perfil de usuario',

	// register pre check
	'profile_manager:register_pre_check:missing' => 'Este campo debe ser completado: %s',
	'profile_manager:register_pre_check:terms' => 'Debes aceptar los Términos de uso para completar el registro',
	'profile_manager:register_pre_check:profile_icon:error' => 'Hubo un error al cargar tu imagen de usuario (posiblemente relacionado con el tamaño del archivo)',
	'profile_manager:register_pre_check:profile_icon:nosupportedimage' => "El archivo indicado no parece ser una imagen. Debe ser una imagen válida en formato JPG, GIF o PNG.",

	// Admin add user form
	'profile_manager:admin:adduser:notify' => "Notificar al usuario",
	'profile_manager:admin:adduser:use_default_access' => "Metadatos extra creados a partir del nivel de acceso por defecto del sitio",
	'profile_manager:admin:adduser:extra_metadata' => "Agregar información sobre el campo personalizado",

	// change username form
	'profile_manager:account:username:button' => "Cambia tu nombre de uaurio",
	'profile_manager:account:username:info' => "Puedes cambiar tu nombre de usuario, el icono te indicará si el mismo es válido y está disponible.",

	// river events
	'river:join:site:default' => '%s se sumo al sitio',

	// login history
	'profile_manager:account:login_history' => "Registro de ingreso",
	'profile_manager:account:login_history:date' => "Fecha",
	'profile_manager:account:login_history:ip' => "Dirección IP",

];
