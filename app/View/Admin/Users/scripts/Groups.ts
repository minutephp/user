/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class GroupListController {
        constructor(public $scope:any, public $minute:any, public $ui:any, public $timeout:ng.ITimeoutService,
                    public gettext:angular.gettext.gettextFunction, public gettextCatalog:angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.groups = $scope.user[0].groups;
            $scope.now = new Date();
        }

        update = (group) => {
            this.$ui.popupUrl('/group-editor.html', false, null, {group: group});
        };

        save = () => {
            this.$scope.groups.save(this.gettext('Groups saved successfully'));
        };
    }

    angular.module('groupListApp', ['MinuteFramework', 'MinuteDirectives', 'MinuteFilters', 'angular.filter', 'gettext'])
        .controller('groupListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', GroupListController]);
}