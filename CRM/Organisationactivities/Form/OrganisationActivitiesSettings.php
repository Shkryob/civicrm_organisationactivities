<?php

require_once 'CRM/Core/Form.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Organisationactivities_Form_OrganisationActivitiesSettings extends CRM_Core_Form {
  public function buildQuickForm() {

    $activityID = Civi::settings()->get('organisation_activities_activity_type_id');
    $relationTypeID = Civi::settings()->get('organisation_activities_relationship_type_id');

    $activityTypes = CRM_Core_OptionGroup::values('activity_type');
    array_unshift($activityTypes, ts('Any'));
    $this->add(
      'select', // field type
      'activity_type_id', // field name
      ts('Activity Type'), // field label
      $activityTypes, // list of options
      TRUE // is required
    )->setValue($activityID);

    $relTypes = CRM_Contact_BAO_Relationship::getContactRelationshipType(NULL, 'null', NULL, NULL, TRUE);
    array_unshift($relTypes, ts('Any'));
    $this->add(
      'select', // field type
      'relationship_type_id', // field name
      ts('Relationship Type'), // field label
      $relTypes, // list of options
      TRUE // is required
    )->setValue($relationTypeID);

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
    $values = $this->exportValues();
    $activityTypes = CRM_Core_OptionGroup::values('activity_type');
    if (isset($activityTypes[$values['activity_type_id']])) {
      Civi::settings()->set('organisation_activities_activity_type_id', $activityTypes[$values['activity_type_id']]);
    } else {
      Civi::settings()->set('organisation_activities_activity_type_id', '');
    }
    Civi::settings()->set('organisation_activities_relationship_type_id', $values['relationship_type_id']);

    parent::postProcess();
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }
}
