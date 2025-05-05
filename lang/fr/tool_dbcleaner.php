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

$string['privacy:metadata'] = 'Le plugin de nettoayge de base de données ne détient aucune donnée personnelle.';

$string['addkey'] = 'Ajouter une définition de clef étrangère';
$string['cachedef_cleanmap'] = 'Nettoyeur de base';
$string['cleandb'] = 'Nettoyer les données en base';
$string['cleanup'] = 'Nettoyer ce plugin';
$string['cleanupplugins'] = 'Nettoyer les plugins supprimés (configurations)';
$string['dbcleaner'] = 'Outil de nettoyage du modèle de données';
$string['deletedplugins'] = 'Plugins supprimés';
$string['deletedplugins_desc'] = 'Scanne les plugins et supprime les données de plugins absents du disque dur.';
$string['evaluating'] = 'Trouvé {$a->q} orphelins dans la table {$a->t} -- Taux de corruption : {$a->cr}%';
$string['fkeys'] = 'Intégrité des clefs étrangères (enregistrements orphelins)';
$string['fkeys_desc'] = 'Scanne la base de données en examinant les dépendances référencées entre tables, détecte et supprime les enregistrement orphelins';
$string['fromcomponentmanager'] = 'Par le gestionnaire de composants';
$string['fromversionrecords'] = 'Par les enregistrements de version';
$string['goback'] = 'Annuler';
$string['nomissingplugins'] = 'Aucun plugin n\'est manquant';
$string['path'] = 'Chemin';
$string['plugincleaned'] = 'Plugin {$a} nettoyé.';
$string['pluginname'] = 'Nettoyeur de base de données';
$string['pluginnamestr'] = 'Plugin';
$string['process'] = 'Traitement';
$string['purging'] = 'Suppression des orphelins dans {$a}';
$string['purgingrecursive'] = 'Suppression de {$a->q} cascades pour {$a->src}';
$string['purgekey'] = 'Purger cette clef';
$string['purgelogs'] = 'Purger les journeaux';
$string['purgelogs_desc'] = 'Purge les journaux selon les origines choisies jusqu\'à une certaine date';
$string['recheck'] = 'Tester à nouveau';
$string['remotekeyfield'] = 'Clef étrangère';
$string['remotekeytable'] = 'Table liée';
$string['scan'] = 'Examiner la base de données';
$string['simulate'] = 'Simuler';
$string['sourcefield'] = 'Champ';
$string['sourcetable'] = 'Table';

$string['cancelactive_desc'] = 'Une seule tâche de nettoyage des journaux peut être active à la fois. Pour changer le paramétrage
de la tâche de nettoyage, vous devez d\'abord arrêter la tâche en cours, puis en relancer une nouvelle.';
$string['cancelactive'] = 'Supprimer la tâche de nettoyage en cours. Les éléments supprimés ne seront pas restaurés.';
$string['origin'] = 'Origine';
$string['allorigins'] = 'Tous les journeaux';
$string['web'] = 'Web';
$string['nonweb'] = 'Tout sauf web';
$string['cli'] = 'Cli';
$string['restore'] = 'Restaurations';
$string['ws'] = 'Webservices';
$string['until'] = 'Jusqu\'à ';
$string['records'] = ' enregistrements';
$string['bunchsize'] = 'Taille du lot de suppression';

