(function(angular, $, _) {
    var module = angular.module('organisationactivities', []);

    module.controller('OrganisationactivitiesCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.ts = CRM.ts('com.shkryob.organisationactivities');
        $scope.activities = [];
        $scope.inProgress = true;
        var searchParams = {
            'sequential': 1,
            'contact_id_b': CRM.vars.organisationactivities.org_id,
            'contact_type': 'Individual',
            'api.Contact.get': {
                'sequential': 1,
                'id': '$value.contact_id_a',
                'api.Activity.get': {
                    'sequential': 1,
                    'id': 627
                }
            }
        };
        if (CRM.vars.organisationactivities.activity_type_id && CRM.vars.organisationactivities.activity_type_id != '0') {
            searchParams['api.Contact.get']['api.Activity.get']['activity_type_id'] = CRM.vars.organisationactivities.activity_type_id;
        }
        if (CRM.vars.organisationactivities.relation_type_id && CRM.vars.organisationactivities.activity_type_id != '0') {
            searchParams['relationship_type_id'] = parseInt(CRM.vars.organisationactivities.relation_type_id);
        }
        CRM.api3('Relationship', 'get', searchParams).done(function(result) {
            var activities = [];
            for (var relID in result.values) {
                var relation = result.values[relID];
                for (var contactID in relation['api.Contact.get'].values) {
                    var contact = relation['api.Contact.get'].values[contactID];
                    for (var activityID in contact['api.Activity.get'].values) {
                        var activity = contact['api.Activity.get'].values[activityID];
                        activity.display_name = contact.display_name;
                        activities.push(activity);
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
