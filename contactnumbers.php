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
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function contactnumbers_civicrm_install() {
  _contactnumbers_civix_civicrm_install();
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
