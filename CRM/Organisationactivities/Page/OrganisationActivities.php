<?php

require_once 'CRM/Core/Page.php';

class CRM_Organisationactivities_Page_OrganisationActivities extends CRM_Core_Page {
  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(ts('OrganisationActivities'));
    CRM_Core_Resources::singleton()->addScriptFile('civicrm', 'bower_components/angular/angular.min.js', 100, 'page-header');
    CRM_Core_Resources::singleton()->addScriptFile('com.shkryob.organisationactivities', 'js/OrganisationActivities.js', 200, 'page-header');

    $data = array(
      'org_id' => $_GET['cid'],
      'activity_type_id' => Civi::settings()->get('organisation_activities_activity_type_id'),
      'relation_type_id' => Civi::settings()->get('organisation_activities_relationship_type_id'),
    );
    CRM_Core_Resources::singleton()->addVars('organisationactivities', $data);

    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));

    parent::run();
  }
}
