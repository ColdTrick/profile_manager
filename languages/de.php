<?php
	/**
	* Profile Manager
	*
	* German language
	*
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	$german = array(
		'profile_manager' => "Profilmanager",
		'custom_profile_fields' => "Benutzerdefinierte Profilfelder?",
		'item:object:custom_profile_field' => 'Benutzerdefiniertes Profil-Feld',
		'item:object:custom_profile_field_category' => 'Benutzerdefinierte Profilfeld-Kategorie',
		'item:object:custom_profile_type' => 'Benutzerdefinierter Profiltyp',
		'item:object:custom_group_field' => 'Benutzerdefiniertes Gruppen-Feld',

		// admin
		'profile_manager:admin:metadata_name' => 'Name',
		'profile_manager:admin:metadata_label' => 'Bezeichnung',
		'profile_manager:admin:metadata_hint' => 'Hinweis',
		'profile_manager:admin:metadata_description' => 'Beschreibung',
		'profile_manager:admin:metadata_label_translated' => 'Bezeichnung (&uuml;bersetzt)',
		'profile_manager:admin:metadata_label_untranslated' => 'Bezeichnung (nicht &uuml;bersetzt)',
                 'profile_manager:admin:field_type' => "Feldtyp",
		'profile_manager:admin:metadata_options' => 'Optionen (durch Komma getrennt)',
		'profile_manager:admin:options:datepicker' => 'Datepicker',
                 'profile_manager:admin:options:pm_datepicker' => 'Datepicker (Style: Profil-Manager )',
		'profile_manager:admin:options:pulldown' => 'Auswahlliste',
		'profile_manager:admin:options:radio' => 'Radio-Button',
		'profile_manager:admin:options:multiselect' => 'Auswahlliste (Mehrfachauswahl)',
		'profile_manager:admin:show_on_members' => "Als Filter auf der \"Mitglieder\"-Seite zeigen ",

		'profile_manager:admin:additional_options' => 'Zus&auml;tzliche Optionen',
		'profile_manager:admin:show_on_register' => 'Im Registrierungsformular anzegen',
		'profile_manager:admin:mandatory' => 'Pflichtangabe',
		'profile_manager:admin:user_editable' => 'Benutzer kann dieses Feld &auml;ndern',
		'profile_manager:admin:output_as_tags' => 'Auf Profil als Tags anzeigen',
		'profile_manager:admin:admin_only' => 'Administrator-Feld',
		'profile_manager:admin:simple_search' => 'In "Einfache Suche" anzeigen',
		'profile_manager:admin:advanced_search' => 'In "Erweiterte Suche" anzeigen',
                 'profile_manager:admin:blank_available' => 'Field besitzt eine Leer-Option',
		'profile_manager:admin:option_unavailable' => 'Option nicht verf&uuml;gbar',

		'profile_manager:admin:profile_icon_on_register' => 'Pflichtangabe f&uuml;r das Profilfoto (Eingabefeld) im Registrierungsformular hinzuf&uuml;gen',
		'profile_manager:admin:simple_access_control' => 'Nur eine Zugriffskontroll-Auswahlliste auf dem "Profil bearbeiten"-Formular anzeigen.',

          	'profile_manager:admin:hide_non_editables' => 'Ausblenden der nicht editierbaren Felder aus der "Profil bearbeiten"-Ansicht',

		'profile_manager:admin:edit_profile_mode' => "Wie kann ich die \"Profil bearbeiten\"-Ansicht anzeigen lassen.",
		'profile_manager:admin:edit_profile_mode:list' => "Liste",
		'profile_manager:admin:edit_profile_mode:tabbed' => "Tabs",

		'profile_manager:admin:show_full_profile_link' => 'Link zur vollst&auml;ndigen Profil-Seite anzeigen',

		'profile_manager:admin:display_categories' => 'Bitte w&auml;hlen Sie, wie die verschiedenen Kategorien auf dem Profil angezeigt werden sollen',
		'profile_manager:admin:display_categories:option:plain' => 'Einfach',
		'profile_manager:admin:display_categories:option:accordion' => 'Typ Accordion',

		'profile_manager:admin:profile_type_selection' => 'Wer kann den Profiltyp &auml;ndern?',
		'profile_manager:admin:profile_type_selection:option:user' => 'Benutzer',
		'profile_manager:admin:profile_type_selection:option:admin' => 'Nur der Admin',

		'profile_manager:admin:show_admin_stats' => "Admin-Statistiken anzeigen",
		'profile_manager:admin:show_members_search' => "Anzeigen der Profil-Manager \"Mitglieder\"-Suchseite",

		'profile_manager:admin:warning:profile' => "ACHTUNG: Dieses Plugin sollte unter dem Profil-Plugin plaziert werden",

		// profile field additionals description
		'profile_manager:admin:show_on_register:description' => "Wenn Sie m&ouml;chten, da&szlig; dieses Feld im Registrierungsformular erscheinen soll.",
		'profile_manager:admin:mandatory:description' => "Wenn Sie m&ouml;chten, da&szlig; dieses Feld ein Pflichtfeld ist (bezieht sich nur auf das Anmeldeformular).",
		'profile_manager:admin:user_editable:description' => "Bei der Einstellung \"Nein\" k&ouml;nnen Benutzer dieses Feld nicht &auml;ndern (praktisch, wenn Daten in einem externen System verwaltet werden).",
		'profile_manager:admin:output_as_tags:description' => "Datenausgabe wird als Tag gehandhabt (gilt nur f&uuml;r sichtbare Benutzer).",
		'profile_manager:admin:admin_only:description' => "W&auml;hlen Sie \"Ja\", wenn das Feld nur f&uuml;r den Admin verf&uuml;gbar sein soll.",
		'profile_manager:admin:simple_search:description' => "W&auml;hlen Sie \"Ja\", wenn das Feld mit der \"Einfachen Profilsuche\" durchsuchbar sein soll.",
		'profile_manager:admin:advanced_search:description' => "W&auml;hlen Sie \"Ja\", wenn das Feld mit der \"Erweiterten Profilsuche\" durchsuchbar sein soll.",
                 'profile_manager:admin:blank_available:description' => "W&auml;hlen Sie - Ja -, wenn eine Leer-Option auf die Feld-Optionen hinzugef&uuml;gt werden soll.",

		// non_editable
		'profile_manager:non_editable:info' => 'Dieses Feld kann nicht ge&auml;ndert werden.',

		// profile user links
		'profile_manager:show_full_profile' => 'Alle Profildaten',

		// datepicker
		'profile_manager:datepicker:output:dateformat' => '%d.%m.%Y', // For available notations see http://nl.php.net/manual/en/function.strftime.php
		'profile_manager:datepicker:input:localisation' => 'jquery.datepick-de.js', // change it to the available localized js files in custom_profile_fields/vendors/jquery.datepick.package-3.5.2 (e.g. jquery.datepick-nl.js), leave blank for default
		'profile_manager:datepicker:input:dateformat' => '%d.%m.%Y', // Notation is based on strftime, but must result in output like http://keith-wood.name/datepick.html#format
		'profile_manager:datepicker:input:dateformat_js' => 'dd.mm.yyyy', // Notation is based on strftime, but must result in output like http://keith-wood.name/datepick.html#format

		// register form mandatory notice
		'profile_manager:register:mandatory' => "Felder mit einem  * sind Pflichtfelder",

		// register profile icon
		'profile_manager:register:profile_icon' => 'Diese Feld erfordert den Upload eines Profilbildes',

		// simple access control
		'profile_manager:simple_access_control' => 'Wem wollen Sie Ihr Profil zug&auml;nglich machen?',

		// register pre check
		'profile_manager:register_pre_check:missing' => 'Folgendes Feld muss ausgef&uuml;llt werden: %s',
		'profile_manager:register_pre_check:profile_icon:error' => 'Fehler beim Hochladen Ihres Profilfotos (wahrscheinlich auf die Dateigr&ouml;&szlig;e bezogen)',
		'profile_manager:register_pre_check:profile_icon:nosupportedimage' => 'Hochgeladenes Profilfoto ist nicht der richtige Typ (jpg, gif, png)',

		// actions
		// new
		'profile_manager:actions:new:success' => 'Neues benutzerdefiniertes Profilfeld erfolgreich hinzugef&uuml;gt',
		'profile_manager:actions:new:error:metadata_name_missing' => 'Keine Metadaten eingetragen',
		'profile_manager:actions:new:error:metadata_name_invalid' => 'Ung&uuml;ltiger Metadaten Name',
		'profile_manager:actions:new:error:metadata_options' => 'Sie m&uuml;ssen Optionen eingeben, wenn Sie diesen Typ benutzen',
		'profile_manager:actions:new:error:unknown' => 'Unbekannter Fehler beim Speichern eines neuen benutzerdefinierten Profilfeldes',
		'profile_manager:action:new:error:type' => 'Falscher Profilfeld-Typ (Gruppe oder Profil)',

		// edit
		'profile_manager:actions:edit:error:unknown' => 'Fehler beim Abrufen der Profilfeld-Daten',

		//reset
		'profile_manager:actions:reset' => 'Zur&uuml;cksetzen',
		'profile_manager:actions:reset:description' => 'Entfernt alle benutzerdefinierten Profilfelder.',
		'profile_manager:actions:reset:confirm' => 'Sie sind sicher, dass Sie alle Profilfelder zur&uuml;cksetzen m&ouml;chten?',
		'profile_manager:actions:reset:error:unknown' => 'Unbekannter Fehler beim Zur&uuml;cksetzen aller Profilfelder',
		'profile_manager:actions:reset:error:wrong_type' => 'Falscher Profilfeld-Typ (Gruppe oder Profil)',
		'profile_manager:actions:reset:success' => 'Erfolgreich zur&uuml;ckgesetzt',

		//delete
		'profile_manager:actions:delete:confirm' => 'Sie sind sicher, dass Sie dieses Feld l&ouml;schen m&ouml;chten?',
		'profile_manager:actions:delete:error:unknown' => 'Unbekannter Fehler w&auml;hrend des L&ouml;schvorgangs',

		// toggle option
		'profile_manager:actions:toggle_option:error:unknown' => 'Unbekannter Fehler w&auml;hrend des Änderns der Option',

		// actions
		'profile_manager:actions:title' => 'Aktionen',

		// import from custom
		'profile_manager:actions:import:from_custom' => 'Benutzderdefinierte Felder importieren',
		'profile_manager:actions:import:from_custom:description' => 'Importiert zuvor definierte (mit Standard Elgg Funktionalit&auml;t) Profilfelder.',
		'profile_manager:actions:import:from_custom:confirm' => 'Sie sind sicher, dass Sie die benutzerdefinierten Felder importieren m&ouml;chten?',
		'profile_manager:actions:import:from_custom:no_fields' => 'Keine benutzerdefinierten Felder f&uuml;r den Import verf&uuml;gbar',
		'profile_manager:actions:import:from_custom:new_fields' => 'Erfolgreich <b>%s</b> neue Felder importiert',

		// import from default
		'profile_manager:actions:import:from_default' => 'Importiert Standardfelder',
		'profile_manager:actions:import:from_default:description' => "Importiert Elgg-Standardfelder.",

		'profile_manager:actions:import:from_default:confirm' => 'Sie sind sicher, dass Sie die Standardfelder importieren m&ouml;chten?',
		'profile_manager:actions:import:from_default:no_fields' => 'Keine Standardfelder f&uuml;r den Import verf&uuml;gbar',
		'profile_manager:actions:import:from_default:new_fields' => 'Erfolgreich <b>%s</b> neue Felder importiert',
		'profile_manager:actions:import:from_default:error:wrong_type' => 'Falscher Profilfeld-Typ (Gruppe oder Profil)',

		// category to field
		'profile_manager:actions:change_category:error:unknown' => "Ein unbekannter Fehler trat beim Ändern der Kategorie auf",

		// add category
		'profile_manager:action:category:add:error:name' => "Kein oder ein ung&uuml;ltiger Name f&uuml;r die Kategorie vergeben",
		'profile_manager:action:category:add:error:object' => "Fehler beim Erstellen des Kategorie-Objekts",
		'profile_manager:action:category:add:error:save' => "Fehler beim Speichern des Kategorie-Objekts",
		'profile_manager:action:category:add:succes' => "Die Kategorie wurde erfolgreich erstellt",

		// delete category
		'profile_manager:action:category:delete:error:guid' => "Keine GUID vergeben",
		'profile_manager:action:category:delete:error:type' => "Die vergebene GUID ist keine benutzerdefinierte Profilfeld-Kategorie",
		'profile_manager:action:category:delete:error:delete' => "Fehler beim L&ouml;schen der Kategorie",
		'profile_manager:action:category:delete:succes' => "Die Kategorie wurde erfolgreich gel&ouml;scht",

		// add profile type
		'profile_manager:action:profile_types:add:error:name' => "Kein oder ein ung&uuml;ltiger Name f&uuml;r den benutzerdefinierten Profiltyp vergeben",
		'profile_manager:action:profile_types:add:error:object' => "Fehler beim Erstellen des benutzerdefinierten Profiltyps",
		'profile_manager:action:profile_types:add:error:save' => "Fehler beim Speichern der benutzerdefinierten Profiltyps",
		'profile_manager:action:profile_types:add:succes' => "Der benutzerdefinierte Profiltyp wurde erfolgreich erstellt",

		// delete profile type
		'profile_manager:action:profile_types:delete:error:guid' => "Keine GUID vergeben",
		'profile_manager:action:profile_types:delete:error:type' => "Die vergebene GUID ist kein benutzerdefinierter Profiltyp",
		'profile_manager:action:profile_types:delete:error:delete' => "Unbekannter Fehler beim L&ouml;schen des benutzerdefinierten Profiltyps",
		'profile_manager:action:profile_types:delete:succes' => "Der benutzerdefinierte Profiltyp wurde erfolgreich gel&ouml;scht",

		// Custom Group Fields
		'profile_manager:group_fields' => "Gruppenfelder ersetzen",
		'profile_manager:group_fields:title' => "Gruppen-Profilfelder ersetzen",

		'profile_manager:group_fields:add:description' => "Hier k&ouml;nnen Sie die Felder &auml;ndern, die auf einer Gruppen-Profilseite angezeigt werden",
		'profile_manager:group_fields:add:link' => "Neues Gruppen-Profilfeld hinzuf&uuml;gen",
                 'profile_manager:profile_fields:no_fields' => "Derzeit sind keine Felder konfiguriert, die das Profil-Manager-Plugin benutzen. F&uuml;gen Sie Ihre eigenen hinzu oder importieren Sie Ihre Felder mit einer der nachstehenden Aktionen.",
		'profile_manager:profile_fields:add:description' => "Hier k&ouml;nnen Sie die Felder bearbeiten, die f&uuml;r Benutzer im Profil zug&auml;nglich sind.",
		'profile_manager:profile_fields:add:link' => "Neues Profilfeld hinzuf&uuml;gen",

		// Custom fields categories
		'profile_manager:categories:add:link' => "Neue Kategorie hinzuf&uuml;gen",

		'profile_manager:categories:list:title' => "Kategorien",
		'profile_manager:categories:list:default' => "Standard",
		'profile_manager:categories:list:view_all' => "Alle Felder auflisten",
		'profile_manager:categories:list:no_categories' => "Keine Kategorien definiert",

		'profile_manager:categories:delete:confirm' => "Sie sind sicher, dass Sie diese Kategorie l&ouml;schen m&ouml;chten?",

		// Custom Profile Types
		'profile_manager:profile_types:add:link' => "Neuen Profiltyp hinzuf&uuml;gen",

		'profile_manager:profile_types:list:title' => "Profiltypen",
		'profile_manager:profile_types:list:no_types' => "keine Profiltypen definiert",

		'profile_manager:profile_types:delete:confirm' => "Sind Sie sicher, dass Sie diesen Profiltyp l&ouml;schen m&ouml;chten?",

		// Export
		'profile_manager:actions:export' => "Profildaten exportieren",
		'profile_manager:actions:export:description' => "Profildaten in eine CSV-Datei exportieren",
		'profile_manager:export:title' => "Profildaten exportieren",
		'profile_manager:export:description:custom_profile_field' => "Diese Funktion exportiert alle <b>Benutzer</ b>-Metadaten basierend auf alle ausgew&auml;hlten Felder.",
		'profile_manager:export:description:custom_group_field' => "Diese Funktion exportiert alle <b>Gruppen</ b>-Metadaten basierend auf alle ausgew&auml;hlten Felder.",
		'profile_manager:export:list:title' => "W&auml;hlen Sie die Felder, die exportiert werden sollen",
		'profile_manager:export:nofields' => "Keine benutzderdefinierten Profilfelder f&uuml;r den Export verf&uuml;gbar",

		// Configuration Backup and Restore
		'profile_manager:actions:configuration:backup' => "Felder-Konfiguration sichern",
		'profile_manager:actions:configuration:backup:description' => "Sichern der Konfiguration dieser Felder (<b> Kategorien und Typen werden nicht gesichert</ b>)",
		'profile_manager:actions:configuration:restore' => "Wiederherstellen der Felder-Konfiguration",
		'profile_manager:actions:configuration:restore:description' => "Wiederherstellen einer zuvor gesicherten Konfigurationsdatei (<b>Die Beziehungen zwischen den Feldern und Kategorien gehen verloren</b>)",

		'profile_manager:actions:configuration:restore:upload' => "Wiederherstellen",

		'profile_manager:actions:restore:success' => "Erfolgreich wiederhergestellt",
		'profile_manager:actions:restore:error:deleting' => "Fehler beim Wiederherstellen: bestehende Felder konnten nicht gel&ouml;scht werden",
		'profile_manager:actions:restore:error:fieldtype' => "Fehler beim Wiederherstellen: Feldtypen stimmen nicht &uuml;berein",
		'profile_manager:actions:restore:error:corrupt' => "Fehler beim Wiederherstellen: Backup-Datei scheint besch&auml;digt zu sein oder betreffende Informationen fehlen",
		'profile_manager:actions:restore:error:json' => "Fehler beim Wiederherstellen: ung&uuml;ltige JSON-Datei",
		'profile_manager:actions:restore:error:nofile' => "Fehler beim Wiederherstellen: keine Datei hochgeladen",

		// Tooltips
		'profile_manager:tooltips:profile_field' => "
			<b>Profilfeld</b><br />
			Hier k&ouml;nnen Sie ein neues Profilfeld hinzuf&uuml;gen.<br /><br />
			Wenn Sie die Bezeichnung  leer lassen, k&ouml;nnen Sie die Profilfeldbezeichnung internationalisieren (<i>profile:[name]</i>).<br /><br />
			Benutzen Sie das Hinweisfeld, um in Eingabeformularen (Registrierung / Profil / Gruppen) ein Icon mit einem Hover-Effekt f&uuml;r eine Feldbeschreibung bereitzustellen.<br /><br />
			Optionen sind nur f&uuml;r Feldtypen notwendig wie <i>Auswahllisten, Radio and MultiSelect-Auswahllisten</i>.
		",
		'profile_manager:tooltips:profile_field_additional' => "
			<b>Bei der Registrierung anzeigen</b><br />
			Wenn Sie dieses Feld w&auml;hrend der Registrierung anzeigen m&ouml;chten.<br /><br />

			<b>Pflichtfeld</b><br />
			Wenn dieses Feld ein Pflichtfeld sein soll (gilt nur f&uuml;r das Registrierungsformular).<br /><br />

			<b>Durch Benutzer editierbar</b><br />
			Bei der Einstellung - Nein - k&ouml;nnen Benutzer diesem Bereich nicht bearbeiten (praktisch, wenn Daten in einem externen System verwaltet werden).<br /><br />

			<b>Als Tags anzeigen</b><br />
			Datenausgabe wird als Tag gehandhabt (gilt nur f&uuml;r das Benutzerprofil).<br /><br />

			<b>Administrator-Feld</b><br />
			W&auml;hlen Sie - Ja -, wenn das Feld nur f&uuml;r Administratoren verf&uuml;gbar sein soll .
		",
		'profile_manager:tooltips:category' => "
			<b>Kategorie</b><br />
			Hier k&ouml;nnen Sie eine neue Profil-Kategorie hinzuzuf&uuml;gen.<br /><br />
			Wenn Sie die Bezeichnung leer lassen, k&ouml;nnen Sie die Kategoriebezeichnung internationalisieren (<i>profile:categories:[name]</i>).<br /><br />

			Wenn Profilfelder definiert sind, k&ouml;nnen Sie ausw&auml;hlen, welchem Profiltyp dieser Kategorie angeh&ouml;ren soll. Wenn kein Profil angegeben ist, gilt die Kategorie f&uuml;r alle Profiltypen (sogar undefinierte).
		",
		'profile_manager:tooltips:category_list' => "
			<b>Kategorien</b><br />
			Zeigt eine Liste aller bestehenden Kategorien.<br /><br />

			<i>Standard</i> ist die Kategorie, die f&uuml;r alle Profile verwendet wird.<br /><br />

			F&uuml;gen Sie Felder zu dieser Kategorie hinzu, indem Sie sie auf die Kategorien ziehen.<br /><br />

			Klicken Sie auf die Kategoriebezeichnung, um die sichtbaren Felder zu filtern. Klicken auf - Alle Felder anschauen - zeigt alle Felder.<br /><br />

			Sie k&ouml;nnen auch durch das Ziehen die Reihenfolge der Kategorien &auml;ndern (<i>Normalerweise ist das nicht m&ouml;glich</i>. <br /><br />

			Klicken Sie auf das Bearbeiten-Symbol, um die Kategorie zu bearbeiten.
		",
		'profile_manager:tooltips:profile_type' => "
			<b>Profiltyp</b><br />
			Hier k&ouml;nnen Sie einen neuen Profiltyp erstellen.<br /><br />
			Wenn Sie die Bezeichnung leer lassen, k&ouml;nnen Sie die Profiltyp-Bezeichnung internationalisieren (<i>profile:types:[name]</i>).<br /><br />
			Tragen Sie eine Beschreibung ein, die Benutzer sehen k&ouml;nnen, wenn Sie diesen Profiltyp ausw&auml;hlen oder leer lassen, um ihn zu internationalisieren (<i>profile:types:[name]:description</i>).<br /><br />
			Sie k&ouml;nnen diesen Profiltyp auf der Mitglieder-Suchseite - filterbar - machen.<br /><br />

			Wenn Kategorien definiert sind, k&ouml;nnen Sie w&auml;hlen, welche Kategorien f&uuml;r diesen Profiltyp gelten sollen.
		",
		'profile_manager:tooltips:profile_type_list' => "
			<b>Profiltypen</b><br />
			Zeigt eine Liste aller erstellten Profiltypen.<br /><br />
			Klicken Sie auf das Bearbeiten-Symbol, um den Profiltyp zu bearbeiten.
		",
		'profile_manager:tooltips:actions' => "
			<b>Aktionen</b><br />
			Verschiedene Aktionen sind mit diesen Profilfeldern verbunden.
		",

		// Edit profile => profile type selector
		'profile_manager:profile:edit:custom_profile_type:label' => "W&auml;hlen Sie Ihren Profiltyp",
		'profile_manager:profile:edit:custom_profile_type:description' => "Beschreibung des gew&auml;hlten Profiltyps",
		'profile_manager:profile:edit:custom_profile_type:default' => "Standard",

		// Admin Stats
		'profile_manager:admin_stats:title'=> "Profilmanager-Statistik",
		'profile_manager:admin_stats:total'=> "Gesamte Benutzeranzahl",
		'profile_manager:admin_stats:profile_types'=> "Anzahl der Benutzer mit einem Profiltyp",

		// Members
		'profile_manager:members:menu' => "Mitglieder",
		'profile_manager:members:submenu' => "Mitgliedersuche",
		'profile_manager:members:searchform:title' => "Suche nach Mitgliedern",
		'profile_manager:members:searchform:simple:title' => "Einfache Suche",
		'profile_manager:members:searchform:advanced:title' => "Erweiterte Suche",
		'profile_manager:members:searchform:sorting' => "Sortierungskriterien:",
                 'profile_manager:members:searchform:sorting:alphabetic' => "&nbsp;alphabetisch",
                 'profile_manager:members:searchform:sorting:newest' => "&nbsp;neueste",
                 'profile_manager:members:searchform:sorting:popular' => "&nbsp;beliebt",
                 'profile_manager:members:searchform:sorting:online' => "&nbsp;online",

		'profile_manager:members:searchform:date:from' => "von",
		'profile_manager:members:searchform:date:to' => "bis",
		'profile_manager:members:searchresults:title' => "Suchergebnisse",
		'profile_manager:members:searchresults:query' => "QUERY",
		'profile_manager:members:searchresults:noresults' => "Es konnten leider keine passenden Mitglieder gefunden werden",
                 'profile_manager:members:searchform:reset' => "Zur&uuml;cksetzen",

		// Admin add user form
		'profile_manager:admin:adduser:notify' => "Benutzer benachrichtigen",
		'profile_manager:admin:adduser:use_default_access' => "Zus&auml;tzliche Metadaten, basierend auf den Standardzugangslevel, erstellt",
		'profile_manager:admin:adduser:extra_metadata' => "Zus&auml;tzliche Profildaten hinzuf&uuml;gen",

	);

	add_translation("de", $german);
?>