<?php

/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.5                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2014                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
*/

/**
 * File for the CiviCRM APIv3 sms_provider functions
 *
 * @package CiviCRM_APIv3
 * @subpackage API_sms_provider
 *
 */

/**
 * Save an sms_provider
 *
 * Allowed @params array keys are:
 * {@getfields sms_provider_create}
 * @example sms_providerCreate.php
 *
 * @return array of newly created sms_provider property values.
 * @access public
 */
function civicrm_api3_sms_provider_create($params) {
  return _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * Get an sms_provider
 *
 * Allowed @params array keys are:
 * {@getfields sms_provider_get}
 * @example sms_providerCreate.php
 *
 * @return array of retrieved sms_provider property values.
 * @access public
 */
function civicrm_api3_sms_provider_get($params) {
  return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * Delete an sms_provider
 *
 * Allowed @params array keys are:
 * {@getfields sms_provider_delete}
 * @example sms_providerCreate.php
 *
 * @return array of deleted values.
 * @access public
 */
function civicrm_api3_sms_provider_delete($params) {
  return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}