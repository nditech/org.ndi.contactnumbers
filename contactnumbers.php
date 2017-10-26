<?php

require_once 'contactnumbers.civix.php';
use CRM_Contactnumbers_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function contactnumbers_civicrm_config(&$config) {
  _contactnumbers_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function contactnumbers_civicrm_xmlMenu(&$files) {
  _contactnumbers_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function contactnumbers_civicrm_install() {
  _contactnumbers_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function contactnumbers_civicrm_postInstall() {
  _contactnumbers_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function contactnumbers_civicrm_uninstall() {
  _contactnumbers_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function contactnumbers_civicrm_enable() {
  _contactnumbers_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function contactnumbers_civicrm_disable() {
  _contactnumbers_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function contactnumbers_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _contactnumbers_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function contactnumbers_civicrm_managed(&$entities) {
  _contactnumbers_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function contactnumbers_civicrm_caseTypes(&$caseTypes) {
  _contactnumbers_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function contactnumbers_civicrm_angularModules(&$angularModules) {
  _contactnumbers_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function contactnumbers_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _contactnumbers_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function contactnumbers_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function contactnumbers_civicrm_navigationMenu(&$menu) {
  _contactnumbers_civix_insert_navigation_menu($menu, NULL, array(
    'label' => E::ts('The Page'),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _contactnumbers_civix_navigationMenu($menu);
} // */

/**
 * Implements hook_civicrm_alterReportVar().
 */
function contactnumbers_civicrm_alterReportVar($varType, &$var, &$object) {
  switch ($varType) {
    case 'columns':
      $var['civicrm_phone']['fields']['phones']['title'] = ts('Phone numbers');
      // Return the contact ID as a placeholder, then look up phone numbers for
      // each row separately.
      $var['civicrm_phone']['fields']['phones']['dbAlias'] = 'contact_civireport.id';
      $var['civicrm_phone']['fields']['phones']['alias'] = 'civicrm_phone_phones';
      break;
    case 'rows':
      foreach ($var as $index => $row) {
        if (array_key_exists('civicrm_phone_phones', $row)) {
          $phones = CRM_Core_BAO_Phone::allPhones($row['civicrm_phone_phones']);
          $html = '';
	  // By default, we add a comma at the end of each line, to simplify
	  // column splits in CSV exports, etc.
	  $comma = ',';
          $counter = 1;
          $last = count($phones);
          foreach ($phones as $key => $phone) {
            if ($key) {
	      // Drop the comma from the final phone number, since that would
	      // mess up column splits in CSV exports.
	      if ($counter == $last) $comma = '';
              $counter++;
              $html .= '<strong>' . ts($phone['locationType']) . ':</strong> ';
              $html .= $phone['phone'] . $comma . '<br />';
            }
          }
          // Replace our placeholder with the resulting phone numbers.
          $var[$index]['civicrm_phone_phones'] = $html;
        }
      }
      break;
  }
}
