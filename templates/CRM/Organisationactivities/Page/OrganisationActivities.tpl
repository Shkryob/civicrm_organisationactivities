<div data-ng-app="organisationactivities"
     data-ng-controller="OrganisationactivitiesCtrl">
    <div data-ng-show="inProgress">
        {ts}Please wait...{/ts}
    </div>
    <div data-ng-show="!inProgress && activities.length == 0">
        {ts}No activities found{/ts}
    </div>
    <table data-ng-if="!inProgress && activities.length != 0">
        <thead>
            <tr>
                <th>
                    {ts}Activity{/ts}
                </th>
                <th>
                    {ts}Person{/ts}
                </th>
                <th>
                    {ts}Status{/ts}
                </th>
                <th>
                    {ts}Date{/ts}
                </th>
            </tr>
        </thead>

        <tbody>
            <tr data-ng-repeat="activity in activities">
                <td>
                    {literal}{{activity.activity_name}}{/literal}
                </td>
                <td>
                    {literal}{{activity.display_name}}{/literal}
                </td>
                <td>
                    {literal}{{activity.status}}{/literal}
                </td>
                <td>
                    {literal}{{activity.activity_date_time}}{/literal}
                </td>
            </tr>
        </tbody>
    </table>
</div>
