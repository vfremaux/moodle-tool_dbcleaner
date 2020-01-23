<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for component 'tool_dbcleaner', language 'en'.
 *
 * @package    tool_dbcleaner
 * @copyright  2011 Petr Skoda {@link http://skodak.org/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['cachedef_cleanmap'] = 'Nettoyeur de base';
$string['pluginname'] = 'Nettoyeur de base de données';
$string['pluginnamestr'] = 'Plugin';
$string['path'] = 'Chemin';
$string['dbcleaner'] = 'Outil de nettoyage du modèle de données';
$string['sourcetable'] = 'Table';
$string['sourcefield'] = 'Champ';
$string['remotekeytable'] = 'Table liée';
$string['remotekeyfield'] = 'Clef étrangère';
$string['simulate'] = 'Simuler';
$string['scan'] = 'Examiner la base de données';
$string['cleandb'] = 'Nettoyer les données en base';
$string['goback'] = 'Annuler';
$string['purging'] = 'Suppression des orphelins dans {$a}';
$string['purgingrecursive'] = 'Suppression de {$a->q} cascades pour {$a->src}';
$string['evaluating'] = 'Trouvé {$a->q} orphelins dans la table {$a->t} -- Taux de corruption : {$a->cr}%';
$string['addkey'] = 'Ajouter une définition de clef étrangère';
$string['recheck'] = 'Tester à nouveau';
$string['fkeys'] = 'Intégrité des clefs étrangères (enregistrements orphelins)';
$string['deletedplugins'] = 'Plugins supprimés';
$string['nomissingplugins'] = 'Aucun plugin n\'est manquant';
$string['deletedplugins_desc'] = 'Scanne les plugins et supprime les données de plugins absents du disque dur.';
$string['cleanupplugins'] = 'Nettoyer les plugins supprimés (configurations)';
$string['fkeys_desc'] = 'Scanne la base de données en examinant les dépendances référencées entre tables, détecte et supprime les enregistrement orphelins';
$string['fromcomponentmanager'] = 'Par le gestionnaire de composants';
$string['fromversionrecords'] = 'Par les enregistrements de version';
