<?php
	/**
	* Profile Manager
	* 
	* Dutch language
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
 
	$dutch = array(
		'profile_manager' => "Profile Manager",
		'custom_profile_fields' => "Custom Profile Fields",
		'item:object:custom_profile_field' => 'Custom Profile Field',
		'item:object:custom_profile_field_category' => 'Custom Profile Field Category',
		'item:object:custom_profile_type' => 'Custom Profile Type',
		'item:object:custom_group_field' => 'Custom Group Field',
	
		// admin
		'profile_manager:admin:metadata_name' => 'Naam',	
		'profile_manager:admin:metadata_label' => 'Label',
		'profile_manager:admin:metadata_hint' => 'Hint',	
		'profile_manager:admin:metadata_description' => 'Omschrijving',
		'profile_manager:admin:metadata_label_translated' => 'Label (Vertaald)',
		'profile_manager:admin:metadata_label_untranslated' => 'Label (Onvertaald)',
		'profile_manager:admin:metadata_options' => 'Opties (komma gescheiden)',
		'profile_manager:admin:field_type' => "Veld Type",
		'profile_manager:admin:options:datepicker' => 'Datepicker',
		'profile_manager:admin:options:pulldown' => 'Pulldown',
		'profile_manager:admin:options:radio' => 'Radio',
		'profile_manager:admin:options:multiselect' => 'MultiSelect',
		'profile_manager:admin:blank_available' => 'Lege optie',		
		'profile_manager:admin:show_on_members' => "Toon als filter op 'Leden' pagina",
	
		'profile_manager:admin:additional_options' => 'Extra opties',
		'profile_manager:admin:show_on_register' => 'Toon op registreer formulier',	
		'profile_manager:admin:mandatory' => 'Verplicht',
		'profile_manager:admin:user_editable' => 'Bewerkbaar door gebruiker',
		'profile_manager:admin:output_as_tags' => 'Toon als tags op profiel',
		'profile_manager:admin:admin_only' => 'Veld alleen voor beheerders',	
		'profile_manager:admin:simple_search' => 'Toon op eenvoudig zoek formulier',	
		'profile_manager:admin:advanced_search' => 'Toon op geavanceerd zoek formulier',
		'profile_manager:admin:option_unavailable' => 'Deze optie is niet beschikbaar',
	
		'profile_manager:admin:profile_icon_on_register' => 'Voeg een verplicht profiel foto veld toe aan het registratie formulier',
		'profile_manager:admin:simple_access_control' => 'Toon slechts &eacute;&eacute;n pulldown om aan te geven wie de informatie van een profiel mag zien',
	
		'profile_manager:admin:hide_non_editables' => 'Verberg de niet bewerkbare velden van het Bewerk Profiel formulier',
		
		'profile_manager:admin:edit_profile_mode' => "Hoe moet het 'bewerk profiel' scherm getoont worden",
		'profile_manager:admin:edit_profile_mode:list' => "Lijst",
		'profile_manager:admin:edit_profile_mode:tabbed' => "Tabbladen",
		
		'profile_manager:admin:show_full_profile_link' => 'Toon een link naar een pagina met het volledige profiel',
	
		'profile_manager:admin:display_categories' => 'Hoe moeten verschillende categorie&euml;n op het profiel worden getoond?',
		'profile_manager:admin:display_categories:option:plain' => 'Standaard',
		'profile_manager:admin:display_categories:option:accordion' => 'Accordion',
	
		'profile_manager:admin:profile_type_selection' => 'Wie kan het profiel type aanpassen',
		'profile_manager:admin:profile_type_selection:option:user' => 'Gebruiker',
		'profile_manager:admin:profile_type_selection:option:admin' => 'Alleen de beheerder',
	
		'profile_manager:admin:show_admin_stats' => "Toon admin statistieken",
		'profile_manager:admin:show_members_search' => "Toon de profile manager 'Leden' zoek pagina",
	
		'profile_manager:admin:warning:profile' => "WAARSCHUWING: Deze plugin moet onder de Profile plugin staan",
		
		// profile field additionals description
		'profile_manager:admin:show_on_register:description' => "Indien het veld ook op het registratie formulier ingevuld kan worden.",	
		'profile_manager:admin:mandatory:description' => "Indien het veld verplicht moet worden ingevuld (dit geldt alleen op het registratie formulier).",
		'profile_manager:admin:user_editable:description' => "Indien 'Nee' kunnen gebruikers dit veld niet bewerken (handig als de data uit een extern systeem komt).",
		'profile_manager:admin:output_as_tags:description' => "Data output zal worden behandeld als tags (alleen van toepassing op profiel weergave).",
		'profile_manager:admin:admin_only:description' => "Kies 'Ja' indien het veld alleen zichtbaar is voor beheerders.",
		'profile_manager:admin:simple_search:description' => "Kies 'Ja' indien het veld zoekbaar is op het eenvoudige zoekformulier.",	
		'profile_manager:admin:advanced_search:description' => "Kies 'Ja' indien het veld zoekbaar is op het geavanceerde zoekformulier.",
		'profile_manager:admin:blank_available:description' => "Kies 'Ja' indien een lege optie aan de opties moet worden toegevoegd.",
		
		// non_editable
		'profile_manager:non_editable:info' => 'Dit veld kan niet worden bewerkt.',
	
		// profile user links
		'profile_manager:show_full_profile' => 'Volledig profiel',
		
		// datepicker
		'profile_manager:datepicker:output:dateformat' => '%a %d %b %Y', // For available notations see http://nl.php.net/manual/en/function.strftime.php
		'profile_manager:datepicker:input:localisation' => 'jquery.datepick-nl.js', // change it to the available localized js files in custom_profile_fields/vendors/jquery.datepick.package-3.5.2 (e.g. jquery.datepick-nl.js), leave blank for default 
		'profile_manager:datepicker:input:dateformat' => '%d/%m/%Y', // Notation is based on strftime, but must result in output like http://keith-wood.name/datepick.html#format
		'profile_manager:datepicker:input:dateformat_js' => 'dd/mm/yyyy', // Notation is based on strftime, but must result in output like http://keith-wood.name/datepick.html#format
		
		// register form mandatory notice
		'profile_manager:register:mandatory' => "Velden met een * zijn verplicht",	
	
		// register profile icon
		'profile_manager:register:profile_icon' => 'Op deze site is het verplicht om een profielafbeelding te uploaden',
	
		// simple access control
		'profile_manager:simple_access_control' => 'Selecteer wie je profielinformatie mag zien',
		
		// register pre check
		'profile_manager:register_pre_check:missing' => 'Het volgende veld mag niet leeg zijn: %s',
		'profile_manager:register_pre_check:profile_icon:error' => 'Error bij het uploaden van het profiel icoon (waarschijnlijk gerelateerd aan de grootte)',
		'profile_manager:register_pre_check:profile_icon:nosupportedimage' => 'Het profiel icoon is niet van het juiste type (jpg, gif, png)',
	
		// actions
		// new
		'profile_manager:actions:new:success' => 'Succesvol een nieuw custom profile field aangemaakt',	
		'profile_manager:actions:new:error:metadata_name_missing' => 'Geen metadata naam meegegeven',	
		'profile_manager:actions:new:error:metadata_name_invalid' => 'Metadata naam is een ongeldige naam',	
		'profile_manager:actions:new:error:metadata_options' => 'Je moet opties opgeven als je dit type veld gebruikt',	
		'profile_manager:actions:new:error:unknown' => 'Onbekend probleem opgetreden tijdens het opslaan van het veld',
		'profile_manager:action:new:error:type' => 'Verkeerd profiel type (groep of profiel)',	
		
		// edit
		'profile_manager:actions:edit:error:unknown' => 'Probleem opgetreden tijdens het ophalen van profiel veld informatie',
	
		//reset
		'profile_manager:actions:reset' => 'Reset',
		'profile_manager:actions:reset:description' => 'Verwijderd alle custom profiel velden.',
		'profile_manager:actions:reset:confirm' => 'Weet je zeker dat je alle velden wilt verwijderen?',
		'profile_manager:actions:reset:error:unknown' => 'Onbekend probleem opgetreden tijdens het resetten van de velden',
		'profile_manager:actions:reset:error:wrong_type' => 'Verkeerd profiel type (groep of profiel)',
		'profile_manager:actions:reset:success' => 'Reset succesvol',
	
		//delete
		'profile_manager:actions:delete:confirm' => 'Weet je zeker dat je dit veld wilt verwijderen?',
		'profile_manager:actions:delete:error:unknown' => 'Onbekend probleem opgetreden tijdens het verwijderen',

		// toggle option
		'profile_manager:actions:toggle_option:error:unknown' => 'Onbekend probleem opgetreden tijdens het wijzigen van deze optie',

		// actions
		'profile_manager:actions:title' => 'Acties',
		
		// import from custom
		'profile_manager:actions:import:from_custom' => 'Importeer custom fields',
		'profile_manager:actions:import:from_custom:description' => 'Importeert eerder gedefinieerde (met de standaard Elgg functionaliteit) profiel velden.',
		'profile_manager:actions:import:from_custom:confirm' => 'Weet je zeker dat je de custom fields wilt importeren?',
		'profile_manager:actions:import:from_custom:no_fields' => 'Geen custom fields beschikbaar voor import',
		'profile_manager:actions:import:from_custom:new_fields' => 'Succesvol <b>%s</b> nieuwe velden ge-importeerd',
	
		// import from default
		'profile_manager:actions:import:from_default' => 'Importeer default fields',
		'profile_manager:actions:import:from_default:description' => "Importeert Elgg's standaard velden.",
		'profile_manager:actions:import:from_default:confirm' => 'Weet je zeker dat je de default fields wilt importeren?',
		'profile_manager:actions:import:from_default:no_fields' => 'Geen default fields beschikbaar voor import',
		'profile_manager:actions:import:from_default:new_fields' => 'Succesvol <b>%s</b> nieuwe velden ge-importeerd',
		'profile_manager:actions:import:from_default:error:wrong_type' => 'Verkeerd profiel type (groep of profiel)',
		
		// category to field
		'profile_manager:actions:change_category:error:unknown' => "Onbekend probleem opgetreden tijdens het wijzigen van de categorie",
	
		// add category
		'profile_manager:action:category:add:error:name' => "Geen naam opgegeven voor de categorie",
		'profile_manager:action:category:add:error:object' => "Er is een probleem opgetreden tijdens het aanmaken van het categorie object",
		'profile_manager:action:category:add:error:save' => "Er is een probleem opgetreden tijdens het opslaan van het categorie object",
		'profile_manager:action:category:add:succes' => "Categorie succesvol aangemaakt",
	
		// delete category
		'profile_manager:action:category:delete:error:guid' => "Categorie ID ontbreekt",
		'profile_manager:action:category:delete:error:type' => "Opgegeven ID is geen custom profile field categorie",
		'profile_manager:action:category:delete:error:delete' => "Er is een probleem opgetreden tijdens het verwijderen van de categorie",
		'profile_manager:action:category:delete:succes' => "Categorie succesvol verwijderd",
	
		// add profile type
		'profile_manager:action:profile_types:add:error:name' => "Geen naam opgegeven voor het profiel type",
		'profile_manager:action:profile_types:add:error:object' => "Er is een probleem opgetreden tijdens het aanmaken van het profiel type object",
		'profile_manager:action:profile_types:add:error:save' => "Er is een probleem opgetreden tijdens het opslaan van het profiel type object",
		'profile_manager:action:profile_types:add:succes' => "Profiel type succesvol aangemaakt",
		
		// delete profile type
		'profile_manager:action:profile_types:delete:error:guid' => "Profiel type ID ontbreekt",
		'profile_manager:action:profile_types:delete:error:type' => "Opgegeven ID is geen custom profile field profiel type",
		'profile_manager:action:profile_types:delete:error:delete' => "Er is een probleem opgetreden tijdens het verwijderen van het profiel type",
		'profile_manager:action:profile_types:delete:succes' => "Profiel type succesvol verwijderd",
		
		// Custom Group Fields
		'profile_manager:group_fields' => "Vervang Groep velden",
		'profile_manager:group_fields:title' => "Vervang Groep profiel velden",
		
		'profile_manager:group_fields:add:description' => "Hier is het mogelijk om de Groeps Profiel velden aan te passen",
		'profile_manager:group_fields:add:link' => "Voeg een nieuw Groeps Profiel veld toe",
		
		'profile_manager:profile_fields:no_fields' => "Op dit moment zijn er geen velden geconfigureerd met behulp van de Profile Manager plugin. Voeg deze toe of importeer ze met behulp van een van onderstaande acties.",
		'profile_manager:profile_fields:add:description' => "Hier is het mogelijk de Profiel velden die een gebruiker kan invullen aan te passen",
		'profile_manager:profile_fields:add:link' => "Voeg een nieuw Profiel veld toe",
		
		// Custom fields categories
		'profile_manager:categories:add:link' => "Nieuwe categorie toevoegen",
		
		'profile_manager:categories:list:title' => "Categorie&euml;n",
		'profile_manager:categories:list:default' => "Standaard",
		'profile_manager:categories:list:view_all' => "Toon alle velden",
		'profile_manager:categories:list:no_categories' => "Geen categorie&euml;n gedefinieerd",
		
		'profile_manager:categories:delete:confirm' => "Weet u zeker dat u deze categorie wilt verwijderen?",
		
		// Custom Profile Types
		'profile_manager:profile_types:add:link' => "Nieuw profiel type toevoegen",
		
		'profile_manager:profile_types:list:title' => "Profiel Types",
		'profile_manager:profile_types:list:no_types' => "Geen profiel types gedefinieerd",
		
		'profile_manager:profile_types:delete:confirm' => "Weet u zeker dat u dit profiel type wilt verwijderen?",
		
		// Export
		'profile_manager:actions:export' => "Exporteer Profiel Informatie",
		'profile_manager:actions:export:description' => "Exporteer profiel informatie naar csv bestand",
		'profile_manager:export:title' => "Exporteer Profiel Informatie",
		'profile_manager:export:description:custom_profile_field' => "Deze functie zal alle <b>gebruikers</b> metadata gebaseerd op de geselecteerde velden exporteren.",
		'profile_manager:export:description:custom_group_field' => "Deze functie zal alle <b>groeps</b> metadata gebaseerd op de geselecteerde velden exporteren.",
		'profile_manager:export:list:title' => "Selecteer de velden die je wilt exporteren",
		'profile_manager:export:nofields' => "Geen profielvelden beschikbaar voor export",
	
		// Configuration Backup and Restore
		'profile_manager:actions:configuration:backup' => "Backup Velden Configuratie",
		'profile_manager:actions:configuration:backup:description' => "Backup de configuratie van deze velden (<b>categorie&euml;n en types worden niet gebackupped</b>)",
		'profile_manager:actions:configuration:restore' => "Herstel Velden Configuratie",
		'profile_manager:actions:configuration:restore:description' => "Herstel een eerder gemaakte backup van de configuratie (<b>je zult wel de relatie tussen de velden en categorie&euml; verliezen</b>)",
		
		'profile_manager:actions:configuration:restore:upload' => "Herstel",
	
		'profile_manager:actions:restore:success' => "Herstellen van velden gelukt",
		'profile_manager:actions:restore:error:deleting' => "Fout tijdens herstellen: kan bestaande velden niet verwijderen",	
		'profile_manager:actions:restore:error:fieldtype' => "Fout tijdens herstellen: veldtypes komen niet overeen",
		'profile_manager:actions:restore:error:corrupt' => "Fout tijdens herstellen: backup bestand lijkt corrupt of er ontbreekt informatie",
		'profile_manager:actions:restore:error:json' => "Fout tijdens herstellen: ongeldig json bestand",
		'profile_manager:actions:restore:error:nofile' => "Fout tijdens herstellen: geen bestand geselecteerd",
	
		// Tooltips
		'profile_manager:tooltips:profile_field' => "
			<b>Profiel Veld</b><br />
			Hier kun je een nieuw profiel veld toevoegen.<br /><br />
			Indien je het label leeg laat, kun je het label internationaliseren in een taal bestand(<i>profile:[naam]</i>).<br /><br />
			Gebruik de hint om op invoerformulieren (registratie en profiel/groep bewerken) een icoon met extra informatie over het veld te tonen.<br /><br />
			Opties zijn alleen verplicht voor de veldtypes <i>Pulldown, Radio and MultiSelect</i>.
		",
		'profile_manager:tooltips:profile_field_additional' => "
			<b>Toon op registreer formulier</b><br />
			Indien het veld ook op het registratie formulier ingevuld kan worden.<br /><br />
			
			<b>Verplicht</b><br />
			Indien het veld verplicht moet worden ingevuld (dit geldt alleen op het registratie formulier).<br /><br />
			
			<b>Bewerkbaar door gebruiker</b><br />
			Indien 'Nee' kunnen gebruikers dit veld niet bewerken (handig als de data uit een extern systeem komt).<br /><br />
			
			<b>Toon als tags</b><br />
			Data output zal worden behandeld als tags (alleen van toepassing op profiel weergave).<br /><br />
			
			<b>Alleen voor beheerders</b><br />
			Kies 'Ja' indien het veld alleen zichtbaar is voor beheerders.
		",
		'profile_manager:tooltips:category' => "
			<b>Categorie</b><br />
			Hier kun je een nieuwe profiel categorie toevoegen.<br /><br />
			Indien je het label leeg laat, kun je het label internationaliseren in een taal bestand(<i>profile:categories:[naam]</i>).<br /><br />
			
			Indien profiel types zijn gedefinieerd, kun je selecteren bij welk type deze categorie van toepassing is. Indien geen profiel type is geselecteerd is deze categorie op alle profielen van toepassing.
		",
		'profile_manager:tooltips:category_list' => "
			<b>Categorie&euml;n</b><br />
			Toont een lijst van alle geconfigureerde categorie&euml;n.<br /><br />
			
			<i>Standaard</i> is de categorie die van toepassing is op alle profielen.<br /><br />
			
			Voeg velden toe aan de categorie&euml;n door ze er op te slepen.<br /><br />
			
			Klik op de categorie label om de weergegeven profiel velden te filteren. Klik op 'Alle velden weergeven' om alle velden weer te geven.<br /><br />
			
			Je kunt ook de volgorde van de categorie&euml;n aanpassen door ze onderling te verslepen (<i>Standaard kan niet worden verplaatst</i>. <br /><br />
			
			Klik op het bewerk icoon om de categorie te bewerken.
		",
		'profile_manager:tooltips:profile_type' => "
			<b>Profiel Type</b><br />
			Hier kun je een nieuwe profiel type aanmaken.<br /><br />
			Indien je het label leeg laat, kun je het label internationaliseren in een taal bestand(<i>profile:types:[naam]</i>).<br /><br />
			Voeg een omschrijving toe die gebruikers kunnen zien wanneer ze het profieltype selecteren of laat het leeg om het te internationaliseren (<i>profile:types:[name]:description</i>).<br /><br />
			Je kunt dit profiel type toevoegen als filter op de Leden Zoek pagina<br /><br />
			
			Indien er categorie&euml;n zijn gedefinieerd kan we worden aangegeven welke categorie&euml;n van toepassing zijn op dit profiel.
		",
		'profile_manager:tooltips:profile_type_list' => "
			<b>Profiel Types</b><br />
			Toont een lijst van alle geconfigureerde profiel types<br /><br />
			Klik op het bewerk icoon om het profiel type te bewerken.
		",
		'profile_manager:tooltips:actions' => "
			<b>Acties</b><br />
			Verschillende acties die van toepassing zijn op de profiel velden.
		",
	
		// Edit profile => profile type selector
		'profile_manager:profile:edit:custom_profile_type:label' => "Selecteer je profiel type",
		'profile_manager:profile:edit:custom_profile_type:description' => "Omschrijving van geselecteerde profiel type",
		'profile_manager:profile:edit:custom_profile_type:default' => "Standaard",
	
		// Admin Stats
		'profile_manager:admin_stats:title'=> "Profile Manager Statistieken",
		'profile_manager:admin_stats:total'=> "Totaal aantal gebruikers",
		'profile_manager:admin_stats:profile_types'=> "Aantal gebruikers met profiel type",
	
		// Members
		'profile_manager:members:menu' => "Leden",
		'profile_manager:members:submenu' => "Zoek Leden",
		'profile_manager:members:searchform:title' => "Zoek naar Leden",
		'profile_manager:members:searchform:simple:title' => "Eenvoudig Zoeken",
		'profile_manager:members:searchform:advanced:title' => "Geavanceerd Zoeken",
		'profile_manager:members:searchform:sorting' => "Sortering",
		'profile_manager:members:searchform:date:from' => "van",
		'profile_manager:members:searchform:date:to' => "tot",
		'profile_manager:members:searchresults:title' => "Zoekresultaten",
		'profile_manager:members:searchresults:query' => "QUERY",
		'profile_manager:members:searchresults:noresults' => "De zoekopdracht leverde geen overeenkomstige leden",
	
		// Admin add user form
		'profile_manager:admin:adduser:notify' => "Mail account informatie naar gebruiker",
		'profile_manager:admin:adduser:use_default_access' => "Extra profiel informatie luistert naar standaard toegangsniveau",
		'profile_manager:admin:adduser:extra_metadata' => "Extra profiel informatie toevoegen",
	
	
	
		//Profile NoIndex
		'profile_manager:profile:noindex' => "Verberg je profiel voor zoekmachines",
		
		'profile_manager:usersettings:hide_from_search_engine' => "Verberg je profiel voor zoekmaschienes",
		'profile_manager:usersettings:hide_from_search_engine:explain' => "Het kan een aantal dagen duren voor je profiel uit de zoekmachines zijn verwijdert.",
		'profile_manager:admin:allow_profile_noindex' => "Gebruikers toestaan om profiel te verbergen",
	);
	
	add_translation("nl", $dutch);
?>