(function(angular, $, _) {
    var module = angular.module('organisationactivities', []);

    module.controller('OrganisationactivitiesCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.ts = CRM.ts('com.shkryob.organisationactivities');
        $scope.activities = [];
        $scope.inProgress = true;


        CRM.api3('Contact', 'get', {
            'sequential': 1,
            'id': CRM.vars.organisationactivities.org_id,
            'contact_type': 'Organization',
            'api.Relationship.get': {
                'contact_type': 'Individual',
                'api.Contact.get': {
                    'id': '$value.contact_id_a',
                    'api.Activity.get': {

                    }
                }
            }
        }).done(function(result) {
            var activities = [];
            for (var orgID in result.values) {
                var organization = result.values[orgID];
                for (var relID in organization['api.Relationship.get'].values) {
                    var relation = organization['api.Relationship.get'].values[relID];
                    for (var contactID in relation['api.Contact.get'].values) {
                        var contact = relation['api.Contact.get'].values[contactID];
                        for (var activityID in contact['api.Activity.get'].values) {
                            var activity = contact['api.Activity.get'].values[activityID];
                            activity.display_name = contact.display_name;
                            activities.push(activity);
                        }
                    }
                }
            }
            $scope.$apply(function() {
                $scope.activities = activities;
                $scope.inProgress = false;
            });
        });
    }]);
})(angular, CRM.$, CRM._);
