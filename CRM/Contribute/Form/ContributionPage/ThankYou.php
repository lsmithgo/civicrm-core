<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.6                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2015                                |
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
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2015
 */

/**
 * Form to configure thank-you messages and receipting features for an online contribution page.
 */
class CRM_Contribute_Form_ContributionPage_ThankYou extends CRM_Contribute_Form_ContributionPage {

  /**
   * Set default values for the form. Note that in edit/view mode
   * the default values are retrieved from the database
   *
   *
   * @return void
   */
  public function setDefaultValues() {
    $title = CRM_Core_DAO::getFieldValue('CRM_Contribute_DAO_ContributionPage', $this->_id, 'title');
    CRM_Utils_System::setTitle(ts('Thank-you and Receipting') . " ($title)");
    return parent::setDefaultValues();
  }

  /**
   * Build the form object.
   *
   * @return void
   */
  public function buildQuickForm() {
    $this->registerRule('emailList', 'callback', 'emailList', 'CRM_Utils_Rule');

    // thank you title and text (html allowed in text)
    $this->add('text', 'thankyou_title', ts('Thank-you Page Title'), CRM_Core_DAO::getAttribute('CRM_Contribute_DAO_ContributionPage', 'thankyou_title'), TRUE);

    $attributes = CRM_Core_DAO::getAttribute('CRM_Contribute_DAO_ContributionPage', 'thankyou_text') + array('class' => 'collapsed');
    $this->add('wysiwyg', 'thankyou_text', ts('Thank-you Message'), $attributes);
    $this->add('wysiwyg', 'thankyou_footer', ts('Thank-you Footer'), $attributes);

    $this->addElement('checkbox', 'is_email_receipt', ts('Email Receipt to Contributor?'), NULL, array('onclick' => "showReceipt()"));
    $this->add('text', 'receipt_from_name', ts('Receipt From Name'), CRM_Core_DAO::getAttribute('CRM_Contribute_DAO_ContributionPage', 'receipt_from_name'));
    $this->add('text', 'receipt_from_email', ts('Receipt From Email'), CRM_Core_DAO::getAttribute('CRM_Contribute_DAO_ContributionPage', 'receipt_from_email'));
    $this->add('textarea', 'receipt_text', ts('Receipt Message'), CRM_Core_DAO::getAttribute('CRM_Contribute_DAO_ContributionPage', 'receipt_text'));

    $this->add('text', 'cc_receipt', ts('CC Receipt To'), CRM_Core_DAO::getAttribute('CRM_Contribute_DAO_ContributionPage', 'cc_receipt'));
    $this->addRule('cc_receipt', ts('Please enter a valid list of comma delimited email addresses'), 'emailList');

    $this->add('text', 'bcc_receipt', ts('BCC Receipt To'), CRM_Core_DAO::getAttribute('CRM_Contribute_DAO_ContributionPage', 'bcc_receipt'));
    $this->addRule('bcc_receipt', ts('Please enter a valid list of comma delimited email addresses'), 'emailList');

    parent::buildQuickForm();
    $this->addFormRule(array('CRM_Contribute_Form_ContributionPage_ThankYou', 'formRule'), $this);
  }

  /**
   * Global form rule.
   *
   * @param array $fields
   *   The input form values.
   * @param array $files
   *   The uploaded files if any.
   * @param array $options
   *   Additional user data.
   *
   * @return bool|array
   *   true if no errors, else array of errors
   */
  public static function formRule($fields, $files, $options) {
    $errors = array();

    // if is_email_receipt is set, the receipt message must be non-empty
    if (!empty($fields['is_email_receipt'])) {
      //added for CRM-1348
      $email = trim(CRM_Utils_Array::value('receipt_from_email', $fields));
      if (empty($email) || !CRM_Utils_Rule::email($email)) {
        $errors['receipt_from_email'] = ts('A valid Receipt From Email address must be specified if Email Receipt to Contributor is enabled');
      }
    }
    return $errors;
  }

  /**
   * Process the form.
   *
   * @return void
   */
  public function postProcess() {
    // get the submitted form values.
    $params = $this->controller->exportValues($this->_name);

    $params['id'] = $this->_id;
    $params['is_email_receipt'] = CRM_Utils_Array::value('is_email_receipt', $params, FALSE);
    if (!$params['is_email_receipt']) {
      $params['receipt_from_name'] = NULL;
      $params['receipt_from_email'] = NULL;
      $params['receipt_text'] = NULL;
      $params['cc_receipt'] = NULL;
      $params['bcc_receipt'] = NULL;
    }

    $dao = CRM_Contribute_BAO_ContributionPage::create($params);
    parent::endPostProcess();
  }

  /**
   * Return a descriptive name for the page, used in wizard header
   *
   * @return string
   */
  public function getTitle() {
    return ts('Thanks and Receipt');
  }

}
