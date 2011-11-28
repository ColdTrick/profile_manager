<?php 
	/**
	* Profile Manager
	* 
	* French language
	* translation by Facyla
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	$french = array(
	
		// Generic action words 
		'add' => "Ajouter",
		
		// entity names
		'item:object:custom_profile_field' => 'Champs de profil personnalisé',
		'item:object:custom_profile_field_category' => 'Catégorie de profil personnalisée',
		'item:object:custom_profile_type' => 'Type de profil personnalisé',
		'item:object:custom_group_field' => 'Champ de profil personnalisé',
	
		// admin menu 
		'admin:appearance:group_fields' => "Modifier les champs des groupes",
		'admin:appearance:export_fields' => "Exporter les données des profils",
	
		// plugin settings
		'profile_manager:settings:registration' => 'Création de compte',
		'profile_manager:settings:edit_profile' => 'Modifier le profil',
		'profile_manager:settings:view_profile' => 'Voir le profil',
		'profile_manager:settings:other' => 'Autre',
	
		'profile_manager:settings:profile_icon_on_register' => "Ajouter un champ 'image de profil' obligatoire dans le formulaire d'inscription",
		'profile_manager:settings:simple_access_control' => "Ne montrer qu'un seul sélecteur de niveau d'accès dans le formulaire d'édition du profil",
		'profile_manager:settings:default_profile_type' => "Type de profil par défaut dans le formulaire d'inscription",
	
		'profile_manager:settings:hide_non_editables' => "Cacher les champs non éditables du formulaire d'édition du profil",
		
		'profile_manager:settings:edit_profile_mode' => "Type d'affichage de l'écran d'édition du profil",
		'profile_manager:settings:edit_profile_mode:list' => "Liste",
		'profile_manager:settings:edit_profile_mode:tabbed' => "Onglet",
	
		'profile_manager:settings:show_profile_type_on_profile' => "Montrer le type de profil de membre sur le profil",
		
		'profile_manager:settings:display_categories' => 'Sélectionner la manière dont les différentes catégories sont affichées sur le profil',
		'profile_manager:settings:display_categories:option:plain' => 'Plan (à la suite)',
		'profile_manager:settings:display_categories:option:accordion' => 'Accordéon',
	
		'profile_manager:settings:display_system_category' => 'Montrer une catégorie supplémentaire sur le profil avec les données système (pour les administrateurs seulement)',
	
		'profile_manager:settings:profile_type_selection' => 'Qui peut modifier le type de profil ?',
		'profile_manager:settings:profile_type_selection:option:user' => 'Le membre',
		'profile_manager:settings:profile_type_selection:option:admin' => 'Un administrateur seulement',
	
		'profile_manager:settings:allow_profile_noindex' => "Autoriser les membres à masquer leur profil des moteurs de recherche",
	
		'profile_manager:settings:show_members_search' => "Utiliser la page de recherche de membres de Profile manager",
		'profile_manager:settings:enable_profile_completeness_widget' => "Activer le widget de niveau de complétion du profil",
		
		'profile_manager:settings:registration:terms' => "Pour afficher un champ 'Accepter les mentions légales' sur le formulaire d'inscription, veuillez renseigner l'URL vers les mentions légales ci-dessous",
		'profile_manager:settings:registration:extra_fields' => "Choisir où afficher les champs de profil supplémentaires",
		'profile_manager:settings:registration:extra_fields:extend' => "Sous le formulaire d'inscription",
		'profile_manager:settings:registration:extra_fields:beside' => "Au-dessus du formulaire d'inscription",
		'profile_manager:settings:registration:free_text' => "Saisissez un texte supplémentaire à afficher sur la page d'inscription",
		
		// Field Configuration
		'profile_manager:admin:metadata_name' => 'Nom',	
		'profile_manager:admin:metadata_label' => 'Label',
		'profile_manager:admin:metadata_hint' => 'Astuce (aide contextuelle)',
		'profile_manager:admin:metadata_description' => 'Description',
		'profile_manager:admin:metadata_label_translated' => 'Label (traduit)',
		'profile_manager:admin:metadata_label_untranslated' => 'Label (non traduit)',
		'profile_manager:admin:metadata_options' => 'Options (séparées par des virgules)',
		'profile_manager:admin:field_type' => "Type de champ",
		'profile_manager:admin:options:datepicker' => 'Sélecteur de date',
		'profile_manager:admin:options:pm_datepicker' => 'Sélecteur de date (façon Profile Manager)',
		'profile_manager:admin:options:pulldown' => 'Liste déroulante',
		'profile_manager:admin:options:radio' => 'Bouton radio',
		'profile_manager:admin:options:multiselect' => 'Liste à choix multiples',
		'profile_manager:admin:options:file' => 'Fichier',
		'profile_manager:admin:show_on_members' => "Afficher sur la page des 'Membres'",
		
		'profile_manager:admin:additional_options' => 'Options additionelles',
		'profile_manager:admin:show_on_register' => "Montrer sur le formulaire d'inscription",	
		'profile_manager:admin:mandatory' => "Obligatoire",
		'profile_manager:admin:user_editable' => 'Le membre peut modifier ce champ',
		'profile_manager:admin:output_as_tags' => 'Montrer sur le profil sous forme de tags',
		'profile_manager:admin:admin_only' => 'Champ admin seulement',
		'profile_manager:admin:simple_search' => 'Montrer sur le formulaire de recherche simple',	
		'profile_manager:admin:advanced_search' => 'Montrer sur le formulaire de recherche avancée',
		'profile_manager:admin:count_for_completeness' => 'Considérer ce champ pour le widget du niveau de complétion du profil',
		'profile_manager:admin:blank_available' => 'Ce champ a une option vide', 
		'profile_manager:admin:option_unavailable' => 'Option indisponible',
	
		// field options additionals description
		'profile_manager:admin:show_on_register:description' => "Activez si vous souhaitez intégrer ce champ au formulaire d'inscription.",	
		'profile_manager:admin:mandatory:description' => "Activez si vous souhaitez que ce champ soit obligatoire (ne s'applique qu'au formulaire d'inscription).",
		'profile_manager:admin:user_editable:description' => "Si paramétré sur 'Non' les utilisateurs ne peuvent pas modifier ce champ (pratique lorsque les données sont gérées dans un système externe ou via un autre plugin).",
		'profile_manager:admin:output_as_tags:description' => "Les données seront gérées comme des tags (ne s'applique qu'au profil du membre).",
		'profile_manager:admin:admin_only:description' => "Choisissez 'Oui' si le champ est réservé aux administrateurs.",
		'profile_manager:admin:simple_search:description' => "Choisissez 'Oui' si le champ fait partie du formulaire de recherche simple.",	
		'profile_manager:admin:advanced_search:description' => "Choisissez 'Oui' si le champ fait partie du formulaire de recherche avancée.",
		'profile_manager:admin:blank_available:description' => "Sélectionnez 'Oui' si une option vide doit être ajouté aux options disponibles du champ",	
	
		// profile fields
		'profile_manager:profile_fields:list:title' => "Champs de profil",	
	
		'profile_manager:profile_fields:no_fields' => "Aucun champ n'est actuellement configuré via le plugin Profile Manager. Ajoutez vos propres champs ou importez-en via l'une des actions ci-après.",
		
		'profile_manager:profile_fields:add' => "Ajouter un nouveau champ de profil",
		'profile_manager:profile_fields:edit' => "Modifier un champ de profil",
		'profile_manager:profile_fields:add:description' => "Vous pouvez modifier ici les champs qu'un membre peut modifier sur son profil",
	
		// group fields
		'profile_manager:group_fields:list:title' => "Champs de profil des groupes",	
	
		'profile_manager:group_fields:add:description' => "Vous pouvez modifier ici les champs affichés sur la page de profil d'un groupe",
		'profile_manager:group_fields:add' => "Ajouter un nouveau champ de profil de groupe",
		'profile_manager:group_fields:edit' => "Modifier un champ de profil de groupe",
	
		// Custom fields categories
		'profile_manager:categories:add' => "Ajouter une nouvelle catétorie",
		'profile_manager:categories:edit' => "Modifier une catégorie",
		'profile_manager:categories:list:title' => "Catégories",
		'profile_manager:categories:list:default' => "Par défaut",
		'profile_manager:categories:list:system' => "Système (administrateur seulement)",	
		'profile_manager:categories:list:view_all' => "Montrer tous les champs",
		'profile_manager:categories:list:no_categories' => "Aucune catégorie définie",
		'profile_manager:categories:delete:confirm' => "Etes-vous sûr de vouloir supprimer cette catégorie ?",
		
		// Custom Profile Types
		'profile_manager:profile_types:add' => "Ajouter un nouveau champ de profil",
		'profile_manager:profile_types:edit' => "Modifier un champ de profil",
		'profile_manager:profile_types:list:title' => "Types de profils",
		'profile_manager:profile_types:list:no_types' => "AUcun type de profil défini",
		'profile_manager:profile_types:delete:confirm' => "Etes-vous sûr de vouloir supprimer ce type de profil ?",
		'profile_manager:user_details:profile_type' => "Type de profil",
	
		// admin actions
		'profile_manager:actions:title' => 'Actions',
	
		// Reset
		'profile_manager:actions:reset' => 'Réinitialiser',
		'profile_manager:actions:reset:description' => 'Supprime tous les champs de profil personnalisés',
		'profile_manager:actions:reset:confirm' => 'Etes-vous sûr de vouloir réinitialiser tous les champs de profil ?',
		'profile_manager:actions:reset:error:unknown' => 'Erreur inconnue lors de la réinitialisation de tous les champs de profil',
		'profile_manager:actions:reset:error:wrong_type' => 'Mauvais types de champs de profil (groupe ou profil)',
		'profile_manager:actions:reset:success' => 'Réinitialisation réussie',
	
		// import from custom
		'profile_manager:actions:import:from_custom' => 'Importer les champs de profil',
		'profile_manager:actions:import:from_custom:description' => "Importe les champs de profil prédéfinis (avec les fonctionnalités d'Elgg par défaut",
		'profile_manager:actions:import:from_custom:confirm' => 'Etes-vous sûr de vouloir importer les champs personnalisés ?',
		'profile_manager:actions:import:from_custom:no_fields' => 'Aucun champ de profil personnalisé disponible à importer',
		'profile_manager:actions:import:from_custom:new_fields' => 'Import réussi de <b>%s</b> champs de profil personnlisés',
	
		// import from default
		'profile_manager:actions:import:from_default' => 'Importer les champs par défaut',
		'profile_manager:actions:import:from_default:description' => "Importer les champs de profil par défaut d'Elgg",
		'profile_manager:actions:import:from_default:confirm' => 'Etes-vous sûr de vouloir importer les champs de profil par défaut ?',
		'profile_manager:actions:import:from_default:no_fields' => 'Aucun champ de profil par défaut disponible à importer',
		'profile_manager:actions:import:from_default:new_fields' => 'Import réussi de <b>%s</b> champs de profil par défaut',
		'profile_manager:actions:import:from_default:error:wrong_type' => 'Mauvais type de champ de profil (groupe ou profil)',
	
		// Export
		'profile_manager:actions:export' => "Exporter",
		'profile_manager:actions:export:description' => "Exporter les données de profil dans un fichier CSV",
		'profile_manager:export:title' => "Exporter les données de profil",
		'profile_manager:export:description:custom_profile_field' => "This function will export all <b>user</b> métadonnée based on selected fields.",
		'profile_manager:export:description:custom_group_field' => "This function will export all <b>group</b> métadonnée based on selected fields.",
		'profile_manager:export:list:title' => "Select the fields which you want to be exported",
		'profile_manager:export:nofields' => "No custom profile fields available for export",
	
		// Configuration Backup and Restore
		'profile_manager:actions:configuration:backup' => "Sauvegarde",
		'profile_manager:actions:configuration:backup:description' => "Sauvegarder la configuration de ces champs (les catégories et les types ne sont pas sauvegardés)",
		'profile_manager:actions:configuration:restaurer' => "Restauration",
		'profile_manager:actions:configuration:restaurer:description' => "Restaurer un fichier de configuration précédemment sauvegardé (<b>vous perdrez toutes les relations entre les champs et les catégories</b>)",
		
		'profile_manager:actions:configuration:restaurer:upload' => "Restauration",
	
		'profile_manager:actions:restaurer:success' => "Restauration réussie",
		'profile_manager:actions:restaurer:error:deleting' => "Erreur lors de la restauration : impossible de supprimer les champs actuels",	
		'profile_manager:actions:restaurer:error:fieldtype' => "Erreur lors de la restauration : les types de champs ne correspondent pas",
		'profile_manager:actions:restaurer:error:corrupt' => "Erreur lors de la restauration : le fichier de restauration semble corrompu ou les informations sont manquantes",
		'profile_manager:actions:restaurer:error:json' => "Erreur lors de la restauration : fichier JSON invalide",
		'profile_manager:actions:restaurer:error:nofile' => "Erreur lors de la restauration : aucun fichier envoyé",
	
		// new
		'profile_manager:actions:new:success' => 'Champ de profil personnalisé bien ajouté',	
		'profile_manager:actions:new:error:metadata_name_missing' => 'Aucun nom de métadonnée fourni',	
		'profile_manager:actions:new:error:metadata_name_invalid' => 'Le nom de la métadonnée est invalide',	
		'profile_manager:actions:new:error:metadata_options' => 'Vous devez saisir les options possibles en utilisant ce type',	
		'profile_manager:actions:new:error:unknown' => "Une erreur inconnue est survenue lors de la sauvegarde du nouveau champ de profil",
		'profile_manager:action:new:error:type' => 'Mauvais type de champ de profil (groupe ou profil)',
		
		// edit
		'profile_manager:actions:edit:error:unknown' => 'Erreur en chargeant les données du champ de profil',
	
		//delete
		'profile_manager:actions:delete:confirm' => 'Etes-vous sûr de vouloir supprimer ce champ ?',
		'profile_manager:actions:delete:error:unknown' => 'Erreur inconnue lors de la suppression',

		// toggle option
		'profile_manager:actions:toggle_option:error:unknown' => "Une erreur inconnue est survenue lors de la modification de l'option",
	
		// category to field
		'profile_manager:actions:change_category:error:unknown' => "Une erreur inconnue est survenue lors du changement de catégorie",
	
		// add category
		'profile_manager:action:category:add:error:name' => "Aucun nom, ou nom invalide fourni pour la catégorie",
		'profile_manager:action:category:add:error:object' => "Erreur lors de la création de la catégorie de l'objet",
		'profile_manager:action:category:add:error:save' => "Erreur lors de la sauvegarde de la catégorie de l'objet",
		'profile_manager:action:category:add:succes' => "La catégorie a bien été créée",
	
		// delete category
		'profile_manager:action:category:delete:error:guid' => "Aucun GUID fourni",
		'profile_manager:action:category:delete:error:type' => "Le GUID fourni n'est pas une catégorie de champ de profil personnalisé",
		'profile_manager:action:category:delete:error:delete' => "Une erreur est survenue lors de la suppression de la catégorie",
		'profile_manager:action:category:delete:succes' => "La catégorie a bien été supprimée",
	
		// add profile type
		'profile_manager:action:profile_types:add:error:name' => "Aucun nom ou nom invalide fourni pour le champ de profil personnalisé",
		'profile_manager:action:profile_types:add:error:object' => "Erreur lors de la création du champ de profil personnalisé",
		'profile_manager:action:profile_types:add:error:save' => "Erreur lors de la sauvegarde du champ de profil personnalisé",
		'profile_manager:action:profile_types:add:succes' => "Le champ de profil personnalisé a bien été créé",
		
		// delete profile type
		'profile_manager:action:profile_types:delete:error:guid' => "Aucun GUID fourni",
		'profile_manager:action:profile_types:delete:error:type' => "Le GUID fourni n'est pas un champ de profil personnalisé",
		'profile_manager:action:profile_types:delete:error:delete' => "Une erreur inconnue est survenue lors de la suppression du type de champ de profil personnalisé",
		'profile_manager:action:profile_types:delete:succes' => "Le type de champ de profil personnalisé a bien été supprimé",
	
		// Tooltips
		'profile_manager:tooltips:profile_field' => "
			<b>Champs de profil</b><br />
			Vous pouvez ajouter ici un nouveau champ de profil.<br /><br />
			Si vous laissez le label vide, vous pouvez internationaliser le label du champ de profil (via <i>profile:[name]</i>).<br /><br />
			Utilisez le champ astuce pour fournir une aide contextuelle sur les formulaires de saisie (inscription et édition du profil/groupe) sous forme d'infobulle au survol d'une icône avec une desciption du champ.
			Si vous laissez le champ astuce vide, vous pouvez l'internationaliser (via <i>profile:hint:[name]</i>).<br /><br />
			Les options doivent être obligatoirement définies pour les types de champs <i>Liste déroulante, Boutons radio et Liste à choix multiples</i>.
		",
		'profile_manager:tooltips:profile_field_additional' => "
			<b>Montrer sur le formulaire d'inscription</b><br />
			Si vous souhaitez que ce champ soit intégré au formulaire d'inscription.<br /><br />
			
			<b>Obligatoire</b><br />
			Si vous souhaitez que ce champ soit obligatoire (ne s'applique qu'au formulaire d'inscription).<br /><br />
			
			<b>Modifiable par les membres</b><br />
			Si défini sur 'Non' les membres ne peuvent pas modifier ce champ (pratique lorsque les données sont gérées via un système externe ou un autre plugin).<br /><br />
			
			<b>Afficher sous forme de tags</b><br />
			Les données seront affichées sous forme de tags (ne s'apllique qu'au profil du membre).<br /><br />
			
			<b>Champs administrateur seulement</b><br />
			Sélectionnez 'Oui' si le champ n'est disponible qu'aux administrateurs.
		",
		'profile_manager:tooltips:category' => "
			<b>Catégorie</b><br />
			Vous pouvez ajouter ici une nouvelle catégorie de profil.<br /><br />
			Si vous laissez le label vide, vous pouvez internationaliser le label de la catégorie (via <i>profile:categories:[name]</i>).<br /><br />
			
			Si els types de profils sont définis vous pouvez choisir à quels types de profils ces catégories s'appliquent. Si aucun type de profil n'est défini, la catégorie s'applique à tous les types de profils (même indéfini).
		",
		'profile_manager:tooltips:category_list' => "
			<b>Catégories</b><br />
			Affiche une liste de toutes les catégories configurées.<br /><br />
			
			<i>Par défaut</i> est la catégorie qui s'appplique à tous les profils.<br /><br />
			
			Ajouter des champs à ces catégories en les faisant glisser sur les catégories.<br /><br />
			
			Cliquez sur le label de la catégorie pour filtrer les champs visibles. Cliquez sur montrer tous les champs affiche tous les champs.<br /><br />
			
			Vous pouvez également modifier l'ordre des catégories en les faisant glisser (<i>Par défaut ne peut pas être déplacée</i>. <br /><br />
			
			Cliquez sur l'icône d'édition pour modifier la catégorie.
		",
		'profile_manager:tooltips:profile_type' => "
			<b>Type de profil</b><br />
			Vous pouvez ajouter ici un nouveau type de profil.<br /><br />
			Si vous laissez le label vide, vous pouvez intenationaliser le label du type de profil (via <i>profile:types:[name]</i>).<br /><br />
			Saisissez une description que les membres verront lorsqu'ils sélectionneront ce type de profil, ou laissez vide pour l'internationaliser (via <i>profile:types:[name]:description</i>).<br /><br />
			Vous pouvez ajouter ce type de profil comme filtre sur la page de recherche de membres<br /><br />
			
			Si les catégories sont définies vous pouvez choisir quelles catégories s'appliquent à ce type de profil.
		",
		'profile_manager:tooltips:profile_type_list' => "
			<b>Types de profils</b><br />
			Affiche une liste des types de profils configurés.<br /><br />
			Cliquez sur l'icône d'édition pour modifier le type de profil.
		",
		'profile_manager:tooltips:actions' => "
			<b>Actions</b><br />
			Diverses actions liées à ces champs de profil.
		",
	
		// widgets
		'widgets:profile_completeness:title' => 'Complétion du profil',
		'widgets:profile_completeness:description' => 'Montrer le niveau de complétion du profil',
		'widgets:profile_completeness:view:tips' => 'Astuce ! Renseignez votre %s pour améliorer le niveau de complétion de votre profil.',
		'widgets:profile_completeness:view:complete' => 'Bravo ! Votre profil est complet à 100% !',
	
		// datepicker		
		'profile_manager:datepicker:trigger' => 'Sélectionnez une date',
		'profile_manager:datepicker:output:dateformat' => '%a %d %b %Y', // For available notations see http://nl.php.net/manual/en/function.strftime.php
		'profile_manager:datepicker:input:localisation' => '', // change it to the available localized js files in custom_profile_fields/vendors/jquery.datepick.package-3.5.2 (e.g. jquery.datepick-nl.js), leave blank for default 
		'profile_manager:datepicker:input:dateformat' => '%m/%d/%Y', // Notation is based on strftime, but must result in output like http://keith-wood.name/datepick.html#format
		'profile_manager:datepicker:input:dateformat_js' => 'mm/dd/yyyy', // Notation is based on strftime, but must result in output like http://keith-wood.name/datepick.html#format
	
		// Edit profile => profile type selector
		'profile_manager:profile:edit:custom_profile_type:label' => "Choisissez votre type de profil",
		'profile_manager:profile:edit:custom_profile_type:description' => "Description du type de profil",
		'profile_manager:profile:edit:custom_profile_type:default' => "Par défaut",
	
		// non_editable
		'profile_manager:non_editable:info' => 'Ce champ ne peut pas être édité',
		
		// register form mandatory notice
		'profile_manager:register:mandatory' => "Les champs marqués avec un * sont obligatoires",
		
		// register profile icon
		'profile_manager:register:profile_icon' => 'Ce site demande une image pour votre profil',
		
		// register accept terms
		'profile_manager:registration:accept_terms' => "J'ai bien lu et j'accepte les %sMentions légales%s",
	
		// simple access control
		'profile_manager:simple_access_control' => 'Sélectionnez qui peut voir les informations de votre profil',
	
		// register pre check
		'profile_manager:register_pre_check:missing' => 'Le prochain champ doit être renseigné : %s',
		'profile_manager:register_pre_check:profile_icon:error' => "Erreur lors de l'envoi de votre image de profil (probablement liée à la taille du fichier)",
		'profile_manager:register_pre_check:profile_icon:nosupportedimage' => "L'image de profil envoyée n'est pas au bon format de fichier (jpg, gif, png)",
	
		//Profile NoIndex
		'profile_manager:profile:noindex' => "Protéger votre profil des moteurs de recherche",
		
		'profile_manager:usersettings:hide_from_search_engine' => "Masquer votre profile des moteurs de recherche",
		'profile_manager:usersettings:hide_from_search_engine:explain' => "Cela peut prendre plusieurs jours pour que votre profil disparaisse des index des moteurs de recherche.",
	
		// Admin add user form
		'profile_manager:admin:adduser:notify' => "Notifier l'utilisateur",
		'profile_manager:admin:adduser:use_default_access' => "Métadonnées supplémentaires créées sur la base du niveau d'accès par défaut du site",
		'profile_manager:admin:adduser:extra_métadonnée' => "Ajouter des données de profil supplémentaires",
	
/*	
	
		// Membres
		'profile_manager:members:menu' => "Membres",
		'profile_manager:members:submenu' => "Recherche de membres",
		'profile_manager:members:searchform:title' => "Rechercher des membres",
		'profile_manager:members:searchform:simple:title' => "Recherche simple",
		'profile_manager:members:searchform:advanced:title' => "Recherche avancée",
		'profile_manager:members:searchform:sorting' => "Tri des résultats",
		'profile_manager:members:searchform:sorting:alphabetic' => "Alphabétique",
		'profile_manager:members:searchform:sorting:newest' => "Récents",
		'profile_manager:members:searchform:sorting:popular' => "Populaires",
		'profile_manager:members:searchform:sorting:online' => "En ligne",
		'profile_manager:members:searchform:date:from' => "de",
		'profile_manager:members:searchform:date:to' => "vers",
		'profile_manager:members:searchresults:title' => "Résultats de la recherche",
		'profile_manager:members:searchresults:query' => "REQUETE",
		'profile_manager:members:searchresults:noresults' => "Votre recherche n'a retourné aucun résultat",
		'profile_manager:members:searchform:reset' => "Réinitialiser",
	
	*/
	);
	
	add_translation("fr", $french);
	