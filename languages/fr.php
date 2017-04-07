<?php
/**
* Profile Manager
*
* English language
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

return array(
				
	// entity names
	'item:object:custom_profile_field' => 'Champ de profil personnalisé',
	'item:object:custom_profile_field_category' => 'Catégorie de champ personnalisé du profil',
	'item:object:custom_profile_type' => 'Type du profil personnalisé',
	'item:object:custom_group_field' => 'Champ personnalisé du groupe',

	'profile:custom_profile_type' => 'Type du profil personnalisé',
	
	// admin menu
	'admin:appearance:group_fields' => "Modifier les champs du groupe",
	'admin:appearance:export_fields' => "Exporter les données de profil",
	
	'admin:groups' => "Groupes",
	'admin:groups:export' => "Export de groupes",
	
	'admin:users:export' => "Export de membres",
	'admin:users:inactive' => "Liste des membres inactifs",

	// plugin settings
	'profile_manager:settings:registration' => 'Enregistrement',
	'profile_manager:settings:edit_profile' => 'Modifier le profil',
	'profile_manager:settings:view_profile' => 'Voir le profil',
	'profile_manager:settings:group' => "Modifier le profil du groupe",

	'profile_manager:settings:generate_username_from_email' => "Générer nom d'utilisateur du courrier électronique",
	'profile_manager:settings:profile_icon_on_register' => "Ajouter un champ obligatoire sur le formulaire d'inscription",
	'profile_manager:settings:profile_icon_on_register:option:optional' => 'Optionnel',
	'profile_manager:settings:show_account_hints' => "Afficher les astuces d'inscription pour les comptes par défaut",
	'profile_manager:settings:simple_access_control' => "Afficher un seul contrôle d'accès déroulant pour modifier la forme du profil",
	'profile_manager:settings:default_profile_type' => "Profil par défaut sur le formulaire d'inscription",
	'profile_manager:settings:hide_profile_type_default' => "Masquer le profil par défaut sur le formulaire d'inscription",

	'profile_manager:settings:edit_profile_mode' => "Comment afficher l'écran 'modifier le profil'",
	'profile_manager:settings:edit_profile_mode:list' => "Liste",
	'profile_manager:settings:edit_profile_mode:tabbed' => "Onglet",

	'profile_manager:settings:show_profile_type_on_profile' => "Afficher le type de profil de l'utilisateur sur le profil",

	'profile_manager:settings:display_categories' => 'Sélectionnez la façon dont les différentes catégories sont affichées sur le profil',
	'profile_manager:settings:display_categories:option:plain' => 'Simple',
	'profile_manager:settings:display_categories:option:accordion' => 'Accordéon',

	'profile_manager:settings:display_system_category' => 'Afficher une catégorie supplémentaire sur le profil avec les données du système (uniquement pour les admins )',

	'profile_manager:settings:profile_type_selection' => 'Qui peut changer le type de profil ?',
	'profile_manager:settings:profile_type_selection:option:user' => 'Utilisateur',
	'profile_manager:settings:profile_type_selection:option:admin' => 'Administrateur uniquement',
	
	'profile_manager:settings:enable_profile_completeness_widget' => "Activer le widget profil complet",
	'profile_manager:settings:enable_username_change' => "Permettre aux utilisateurs de changer leur nom d'utilisateur dans les paramètres",
	'profile_manager:settings:enable_username_change:option:admin' => "Administrateur uniquement",
	'profile_manager:settings:enable_site_join_river_event' => "Ajouter un événement sur le fil d'activités quand les gens rejoignent ce site",
	'profile_manager:settings:profile_completeness:avatar' => "Pourcentage de completude avec l'avatar",
	'profile_manager:settings:profile_completeness:avatar:help' => "Si vous utilisez les fonctionnalités de completude du profil, vous pouvez eventuellement parametrer combien vaut l'avatar. Ce pourcentage restant sera utilisé pour la configuration des champs du profile.",
	
	'profile_manager:settings:registration:terms' => "Pour afficher un champ «Accepter les termes» sur la page d'inscription, merci de remplir les termes dans l'URL ci-dessous",
	'profile_manager:settings:registration:extra_fields' => "Où afficher les champs de profil supplémentaires",
	'profile_manager:settings:registration:extra_fields:extend' => "Ci-dessous le formulaire d'inscription par défaut",
	'profile_manager:settings:registration:extra_fields:beside' => "Outre le formulaire d'inscription",
	'profile_manager:settings:registration:free_text' => "Entrez le texte supplémentaire à afficher sur la page d'inscription",
		
	
	'profile_manager:settings:group:group_limit_name' => "Le nombre maximum de fois où un nom de groupe peut être édité",
	'profile_manager:settings:group:group_limit_description' => "Le nombre maximum de fois où une description de groupe peut être éditée",
	'profile_manager:settings:group:limit:unlimited' => "Illimité",
	'profile_manager:settings:group:limit:info' => "Ces limites ne sont pas applicables aux administrateurs du site",
	
	// Field Configuration
	'profile_manager:admin:metadata_name' => 'Nom',
	'profile_manager:admin:metadata_label' => 'Libellé',
	'profile_manager:admin:metadata_input_label' => 'Label du champ',
	'profile_manager:admin:metadata_input_label:help' => "Utilisé à l'inscription et à la modification du profile à la place du libellé",
	'profile_manager:admin:metadata_hint' => 'Conseil',
	'profile_manager:admin:metadata_placeholder' => 'Paramètre substituable',	
	'profile_manager:admin:metadata_options' => 'Options (séparées par des virgules)',
	'profile_manager:admin:field_type' => "Type de champs",
	'profile_manager:admin:options:dropdown' => 'Menu déroulant',
	'profile_manager:admin:options:radio' => 'Radio',
	'profile_manager:admin:options:tel' => 'Téléphone',
	'profile_manager:admin:options:multiselect' => 'Sélection multiple',
	'profile_manager:admin:options:file' => 'Fichier',
	'profile_manager:admin:options:pm_rating' => 'Évaluation',
	'profile_manager:admin:options:pm_twitter' => 'Twitter',
	'profile_manager:admin:options:pm_facebook' => 'Facebook',
	'profile_manager:admin:options:pm_linkedin' => 'LinkedIn',
	
	'profile_manager:admin:additional_options' => 'Options supplémentaires',
	'profile_manager:admin:show_on_register' => "Voir sur le formulaire d'enregistrement",
	'profile_manager:admin:mandatory' => 'Obligatoire',
	'profile_manager:admin:user_editable' => "L'utilisateur peut modifier ce champ",
	'profile_manager:admin:output_as_tags' => 'Voir sur le profil en tant que balises',
	'profile_manager:admin:admin_only' => 'Champ administrateur uniquement',
	'profile_manager:admin:count_for_completeness' => 'Comptez ce champ dans le profil widget complétude',
	'profile_manager:admin:blank_available' => 'Ce champ a une option vide',
	'profile_manager:admin:option_unavailable' => 'Option non valable',

	// field options additionals description
	'profile_manager:admin:show_on_register:description' => "Si vous souhaitez que ce champ soit sur le formulaire d'inscription.",
	'profile_manager:admin:mandatory:description' => "Si vous souhaitez que ce champ soit obligatoire (valable uniquement pour le formulaire d'inscription ).",
	'profile_manager:admin:user_editable:description' => "Si la valeur aux utilisateurs «Non» ne peut pas modifier ce champ ( pratique lorsque les données sont gérées dans un système externe ).",
	'profile_manager:admin:output_as_tags:description' => "La sortie de données sera traitée en tant que balises (uniquement sur ​​le profil de l'utilisateur).",
	'profile_manager:admin:admin_only:description' => "Sélectionnez «Oui» si le champ est uniquement disponible pour les administrateurs .",
	'profile_manager:admin:blank_available:description' => "Sélectionnez «Oui» si une option vide doit être ajoutée aux options de champ",

	// profile fields
	'profile_manager:profile_fields:list:title' => "Les champs Profil",

	'profile_manager:profile_fields:no_fields' => "Actuellement aucun champs n'est configuré à l'aide du plug-in Profile Manager. Ajoutez le vôtre ou importez l'une des actions ci-dessous.",
	
	'profile_manager:profile_fields:add' => "Ajouter un nouveau champ de profil",
	'profile_manager:profile_fields:edit' => "Modifier un champ de profil",
	'profile_manager:profile_fields:add:description' => "Ici, vous pouvez modifier les champs qu'un utilisateur peut éditer sur son profil",

	// group fields
	'profile_manager:group_fields:list:title' => "Champs de profil du groupe",

	'profile_manager:group_fields:add:description' => "Ici, vous pouvez modifier les champs du profil de groupe",
	'profile_manager:group_fields:add' => "Ajouter un nouveau champ de profil de groupe",
	'profile_manager:group_fields:edit' => "Modifier un champ de profil de groupe",

	// Custom fields categories
	'profile_manager:categories:add' => "Ajouter une nouvelle catégorie",
	'profile_manager:categories:edit' => "Modifier une catégorie",
	'profile_manager:categories:edit:related_types' => "Types de profil liés",
	'profile_manager:categories:list:title' => "Catégories",
	'profile_manager:categories:list:default' => "Défaut",
	'profile_manager:categories:list:system' => "Système (administrateur uniquement)",
	'profile_manager:categories:list:view_all' => "Voir tous les champs",
	'profile_manager:categories:list:no_categories' => "Aucune catégorie n'est définie",
	'profile_manager:categories:delete:confirm' => "Êtes-vous sûr de vouloir supprimer cette catégorie ?",
	
	// Custom Profile Types
	'profile_manager:profile_types:add' => "Ajouter un nouveau type de profil",
	'profile_manager:profile_types:edit' => "Modifier un type de profil",
	'profile_manager:profile_types:edit:related_categories' => "Catégories liées",
	'profile_manager:profile_types:edit:metadata_label:singular' => "Libellé (singulier)",
	'profile_manager:profile_types:edit:metadata_label:plural' => "Libellé (pluriel)",
	'profile_manager:profile_types:list:title' => "Profils types",
	'profile_manager:profile_types:list:no_types' => "Aucun type de profil n'est défini",
	'profile_manager:profile_types:delete:confirm' => "Êtes-vous sûr de vouloir supprimer ce type de profil ?",
	'profile_manager:user_details:profile_type' => "Profil type",
	
	// profile manager inactive users
	'profile_manager:admin:users:inactive:last_login' => "Dernière connexion avant",
	'profile_manager:admin:users:inactive:list' => "Utilisateurs inactifs",

	// admin actions
	'profile_manager:actions:title' => 'Actions',

	// Reset
	'profile_manager:actions:reset:description' => 'Supprime tous les champs de profil personnalisé',
	'profile_manager:actions:reset:confirm' => 'Etes-vous sûr de vouloir réinitialiser tous les champs de profil ?',
	'profile_manager:actions:reset:error:unknown' => 'Une erreur inconnue est survenue lors de la réinitialisation de tous les champs de profil',
	'profile_manager:actions:reset:error:wrong_type' => 'Type de champ de profil incorrect (groupe ou profil )',
	'profile_manager:actions:reset:success' => 'Réinitialisation réussi',

	// import from custom
	'profile_manager:actions:import:from_custom' => "Champs d'importation personnalisés",
	'profile_manager:actions:import:from_custom:description' => 'Importations précédemment définis (Fonctionnalité Elgg par défaut) pour les champs de profil',
	'profile_manager:actions:import:from_custom:confirm' => 'Etes-vous sûr de vouloir importer les champs personnalisés ?',
	'profile_manager:actions:import:from_custom:no_fields' => "Pas de champs personnalisés disponibles pour l'importation",
	'profile_manager:actions:import:from_custom:new_fields' => 'Nouveaux champs importés avec succès <b>%s</b>',

	// import from default
	'profile_manager:actions:import:from_default' => "Champ d'importation par défaut",
	'profile_manager:actions:import:from_default:description' => "Champs d'importations par défaut Elgg",
	'profile_manager:actions:import:from_default:confirm' => 'Etes-vous sûr de vouloir importer les champs par défaut ?',
	'profile_manager:actions:import:from_default:no_fields' => "Aucun champs par défaut n'est disponible pour l'importation",
	'profile_manager:actions:import:from_default:new_fields' => 'Nouveaux champs importés avec succès <b>%s</b>',
	'profile_manager:actions:import:from_default:error:wrong_type' => 'Type de champ de profil incorrect (groupe ou profil )',

	// Export
	'profile_manager:actions:export:description' => "Profil d'exportation de données vers un fichier csv",
	'profile_manager:export:title' => "Exporter les données du profil",
	'profile_manager:export:description:custom_profile_field' => "Cette fonction va exporter toutes les métadonnées de <b> user </b> basées sur des champs sélectionnés.",
	'profile_manager:export:description:custom_group_field' => "Cette fonction va exporter toutes les métadonnées du groupe <b> groupe </b> basées sur des champs sélectionnés.",
	'profile_manager:export:list:title' => "Sélectionnez les champs que vous souhaitez exporter",
	'profile_manager:export:list:include_group_membership' => "Inclure l'appartenance au groupe",
	'profile_manager:export:nofields' => "Pas de champs de profil personnalisés disponibles pour l'exportation",

	// Group Edit
	'profile_manager:group:edit:limit' => "Vous pouvez modifier ce champ encore %s fois",
	
	// Configuration Backup and Restore
	'profile_manager:actions:configuration:backup' => "Sauvegarde",
	'profile_manager:actions:configuration:backup:description' => "Sauvegarde de la configuration de ces champs (catégories et types ne sont pas sauvegardés)",
	'profile_manager:actions:configuration:restore' => "Restaurer",
	'profile_manager:actions:configuration:restore:description' => "Restaurer un fichier de configuration précédemment sauvegardé (<b> vous perdrez les relations entre les champs et les catégories </b>)",
	
	'profile_manager:actions:configuration:restore:upload' => "Restaurer",

	'profile_manager:actions:restore:success' => "Restauration réussie",
	'profile_manager:actions:restore:error:deleting' => "Erreur lors de la restauration : impossible de supprimer les champs actuels",
	'profile_manager:actions:restore:error:fieldtype' => "Erreur lors de la restauration : les types de champs ne correspondent pas",
	'profile_manager:actions:restore:error:corrupt' => "Erreur lors de la restauration : le fichier de sauvegarde semble être endommagé ou l'information est manquante",
	'profile_manager:actions:restore:error:json' => "Erreur lors de la restauration : fichier JSON invalide",
	'profile_manager:actions:restore:error:nofile' => "Erreur lors de la restauration : aucun fichier téléchargé",

	// new
	'profile_manager:actions:new:success' => 'Vous avez ajouté un nouveau champ de profil personnalisé',
	'profile_manager:actions:new:error:metadata_name_missing' => 'Aucun nom de métadonnées fournies',
	'profile_manager:actions:new:error:metadata_name_invalid' => 'Le nom de métadonnées est un nom invalide',
	'profile_manager:actions:new:error:metadata_options' => "Vous devez entrer des options lors de l'utilisation de ce type",
	'profile_manager:actions:new:error:unknown' => "Une erreur inconnue est survenue lors de l'enregistrement d'un nouveau champ de profil personnalisé",
	'profile_manager:action:new:error:type' => 'Type de champ de profil incorrect (groupe ou profil )',
	
	// edit
	'profile_manager:actions:edit:error:unknown' => 'Erreur de recherche des données du champ de profil',

	//delete
	'profile_manager:actions:delete:confirm' => 'Êtes- vous sûr de vouloir supprimer ce champ ?',
	'profile_manager:actions:delete:error:unknown' => 'Erreur inconnue lors de la suppression',

	// toggle option
	'profile_manager:actions:toggle_option:error:unknown' => "Une erreur inconnue est survenue lors de la modification de l'option",

	// category to field
	'profile_manager:actions:change_category:error:unknown' => "Une erreur inconnue est survenue lors du changement de la catégorie",

	// add category
	'profile_manager:action:category:add:error:name' => "Aucun nom ou un nom invalide a été fourni pour la catégorie",
	'profile_manager:action:category:add:error:object' => "Erreur lors de la création de l'objet de la catégorie",
	'profile_manager:action:category:add:error:save' => "Erreur lors de la sauvegarde de l'objet de la catégorie",
	'profile_manager:action:category:add:succes' => "La catégorie a été créée avec succès",

	// delete category
	'profile_manager:action:category:delete:error:guid' => "Aucun GUID fourni",
	'profile_manager:action:category:delete:error:type' => "Le GUID fourni n'est pas une catégorie de champ profil personnalisé",
	'profile_manager:action:category:delete:error:delete' => "Une erreur est survenue lors de la suppression de la catégorie",
	'profile_manager:action:category:delete:succes' => "La catégorie a été supprimé avec succès",

	// add profile type
	'profile_manager:action:profile_types:add:error:name' => "Aucun nom ou un nom invalide fourni pour le type de profil personnalisé",
	'profile_manager:action:profile_types:add:error:object' => "Erreur lors de la création du profil type personnalisé",
	'profile_manager:action:profile_types:add:error:save' => "Erreur lors de l'enregistrement du type de profil personnalisé",
	'profile_manager:action:profile_types:add:succes' => "Le profil type personnalisé a été créé avec succès",
	
	// delete profile type
	'profile_manager:action:profile_types:delete:error:guid' => "Aucun GUID fourni",
	'profile_manager:action:profile_types:delete:error:type' => "Le GUID fourni ne constitue pas un type de profil personnalisé",
	'profile_manager:action:profile_types:delete:error:delete' => "Une erreur inconnue est survenue lors de la suppression du type de profil personnalisé",
	'profile_manager:action:profile_types:delete:succes' => "Le profil type personnalisé a été supprimé avec succès",
	
	// change username action
	'profile_manager:action:username:change:succes' => "Votre nom d'utilisateur a été changé avec succès",

	// Tooltips
	'profile_manager:tooltips:profile_field' => "
		<b>Champ de profil</b><br />
		Ici, vous pouvez ajouter un nouveau champ de profil.<br /><br />
		Si vous laissez l'étiquette vide, vous pouvez internationaliser l'étiquette de champ de profil(<i>profil:[name]</i>).<br /><br />
		Use the hint field to supply on input forms (register and profile/group edit) a hoverable icon with a field description.
		If you leave the hint empty, you can internationalize the hint (<i>profile:hint:[name]</i>).<br /><br />
		Les options ne sont que des types de champs de formulaire obligatoires <i> Dropdown , Radio et Multi Select</i>.
	",
	'gestionnaire de profil : infobulles : profile_field_additional' => "
		<b>Voir le registre</b><br />
		Si vous souhaitez que ce champ soit sur le formulaire d'inscription . <br /> <br />
		
		<b>Obligatoire</b><br />
		Si vous souhaitez que ce champ soit obligatoire (valable uniquement pour le formulaire d'inscription ). <br /> <br />
		
		<b>Utilisateur modifiable </ b> <br />
		Si la valeur aux utilisateurs «Non» ne peut pas modifier ce champ ( pratique lorsque les données sont gérées dans un système externe ) . <br /> <br />
		
		<b>Afficher sous forme de balises </ b> <br />
		La sortie de données sera traitée en tant que balise (applicable uniquement sur ​​le profil de l'utilisateur) . <br /> <br />
		
		<b>Champ uniquement Administrateur</ b> < bar / >
		Sélectionnez «Oui» si le champ est uniquement disponible pour les administrateurs.
	",
	'gestionnaire profil : infobulles : catégorie' => "
		<b>Catégorie</b><br />
		Vous pouvez ajouter une nouvelle catégorie de profil ici. <br /> <br />
		Si vous laissez l'étiquette vide, vous pouvez internationaliser le label de la catégorie (<i> Profil : Catégories : [name] </i>).<br /><br />
		
		Si les profils types sont définis, vous pouvez choisir d'appliquer le type profil de cette catégorie. Si aucun profil n'est spécifié, la catégorie s'applique à tous les types de profils (même indéfinis).
	",
	'gestionnaire de profil : infobulles : category_list' => "
		<b>Catégories</b><br />
		Affiche une liste de toutes les catégories configurées. <br /> <br />
		
		La catégorie par <i>Défaut</i> s'applique à tous les profils. <br /> <br />
		
		Ajouter des champs à ces catégories en les déposant sur les catégories . <br /> <br />
		
		Cliquez sur l'étiquette de catégorie pour filtrer les champs visibles. Cliquer sur la liste de tous les champs affiche tous les champs. <br /> <br />
		
		Vous pouvez également modifier l'ordre des catégories en les faisant glisser (<i> par défaut ne peux pas être glissé </ i>.<br /><br />
		
		Cliquez sur l'icône de modification pour modifier la catégorie.
	",
	'gestionnaire de profil : infobulles : profile_type' => "
		<b>Profil type</b><br />
		Vous pouvez ajouter un nouveau type de profil ici. <br /> <br />
		Si vous laissez l'étiquette vide, vous pouvez internationaliser l'étiquette du type de profil ( < i> profile:types:[name] </ i> ).<br /><br />
		Entrez une description que les utilisateurs peuvent voir lors de la sélection de ce type de profil ou le laisser vide pour internationaliser (<i>profile:types:[name]:description</i>).<br /><br />
		
		Si les catégories sont définies, vous pouvez choisir les catégories à appliquer à ce type de profil.
	",
	'profile_manager:tooltips:profile_type_list' => "
		<b>Profils types</b><br />
		Affiche une liste de tous les types de profils configurés. <br /> <br />
		Cliquez sur l'icône de modification pour modifier le type de profil.
	",
	'profile_manager:tooltips:actions' => "
		<b>Actions</b><br />
		Diverses actions liées à ces champs de profil.
	",
	
	// custom input/output views
	'profile_manager:pm_twitter:input:placeholder' => "Entrez votre nom d'utilisateur Twitter ici",
	'profile_manager:pm_twitter:output:follow' => "Suivre @%s",
	'profile_manager:pm_facebook:input:placeholder' => "Entrez votre url Facebook ici",
	'profile_manager:pm_linkedin:input:placeholder' => "Entrez votre url LinkedIn ici",

	// widgets
	'widgets:profile_completeness:title' => 'Profil complet',
	'widgets:profile_completeness:description' => 'Affiche les profils complets',
	'widgets:profile_completeness:view:tips' => "Tip ! Mettez à jour votre %s pour améliorer l'Exhaustivité de votre profil.",
	'widgets:profile_completeness:view:complete' => 'Félicitations ! Votre profil est 100% complet!',
	
	'widgets:register:title' => "S'inscrire",
	'widgets:register:description' => "Afficher une boîte d'enregistrement",
	'widgets:register:loggedout' => "Vous devez être connecté pour utiliser ce widget",

	'profile_manager:input:multi_select:empty_text' => "S'il vous plaît sélectionnez ...",
		'profile_manager:input:multi_select:selected_text' => '# selected', // @TODO

	// Edit profile => profile type selector
	'profile_manager:profile:edit:custom_profile_type:label' => "Sélectionnez votre type de profil",
	'profile_manager:profile:edit:custom_profile_type:description' => "Description du type de profil sélectionné",
	'profile_manager:profile:edit:custom_profile_type:default' => "Défaut",
	
	// register form mandatory notice
	'profile_manager:register:mandatory' => "Les champs marqués d'une * sont obligatoires",

	// register account field hints
	'profile_manager:register:hints:name' => "Entrez le nom qui sera affiché sur votre profil",
	'profile_manager:register:hints:username' => "Vous pouvez utiliser votre nom d'utilisateur pour vous connecter",
	'profile_manager:register:hints:email' => "Cette adresse e-mail sera utilisée pour vous envoyer des mails. Les autres utilisateurs ne peuvent pas voir cette adresse",
	'profile_manager:register:hints:password' => "Vous aurez besoin d'un mot de passe pour vous connecter au site",
	'profile_manager:register:hints:passwordagain' => "Saisissez à nouveau le même mot de passe pour la validation",
	
	// register profile icon
	'profile_manager:register:profile_icon' => 'Ce site vous oblige à télécharger une icône de profil',
	
	// register accept terms
	'profile_manager:registration:accept_terms' => "Je l'ai lu et accepté les %s Conditions générales d'utilisation %s",

	// simple access control
	'profile_manager:simple_access_control' => 'Sélectionnez qui peut voir vos informations de profil',

	// register pre check
	'profile_manager:register_pre_check:missing' => 'Le champ suivant doit être rempli :%s',
	'profile_manager:register_pre_check:terms' => "Vous devez accepter les conditions pour terminer l'enregistrement",
	'profile_manager:register_pre_check:profile_icon:error' => 'Erreur lors du téléchargement de votre icône de profil (probablement liée à la taille du fichier)',
	'profile_manager:register_pre_check:profile_icon:nosupportedimage' => "Vous ne pouvez pas importer l'icône de profil. Peut-être n'a-t-elle pas le bon type d'extension (jpg, gif , png) ?",

	// Admin add user form
	'profile_manager:admin:adduser:notify' => "Notifier l'utilisateur",
	'profile_manager:admin:adduser:use_default_access' => "Les métadonnées supplémentaires créés sont basées sur le niveau d'accès par défaut du site",
	'profile_manager:admin:adduser:extra_metadata' => "Ajouter des données de profil supplémentaire",
	
	// change username form
	'profile_manager:account:username:button' => "Cliquez pour changer votre nom d'utilisateur",
	'profile_manager:account:username:info' => "Changer votre nom d'utilisateur. Une icône vous indiquera si le nom d'utilisateur saisi est valide et disponible.",
	
	// river events
	'river:join:site:default' => '%s a rejoint le site',

	// login history
	'profile_manager:account:login_history' => "Historique de connexion",
	'profile_manager:account:login_history:date' => "Date",
	'profile_manager:account:login_history:ip' => "Adresse IP",
	
);