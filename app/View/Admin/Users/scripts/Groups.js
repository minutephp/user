/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var GroupListController = (function () {
        function GroupListController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.update = function (group) {
                _this.$ui.popupUrl('/group-editor.html', false, null, { group: group });
            };
            this.save = function () {
                _this.$scope.groups.save(_this.gettext('Groups saved successfully'));
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.groups = $scope.user[0].groups;
            $scope.now = new Date();
        }
        return GroupListController;
    }());
    Admin.GroupListController = GroupListController;
    angular.module('groupListApp', ['MinuteFramework', 'MinuteDirectives', 'MinuteFilters', 'angular.filter', 'gettext'])
        .controller('groupListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', GroupListController]);
})(Admin || (Admin = {}));
