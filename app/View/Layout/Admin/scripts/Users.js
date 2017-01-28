/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var UserLayoutController = (function () {
        function UserLayoutController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.makeTabs = function (tabs) {
                var tabHolder = $('#tabs');
                var html = "<ul class=\"nav nav-tabs\" role=\"tablist\">";
                tabs.sort(function (a, b) { return (parseInt(a.priority) || 0) - (parseInt(b.priority) || 0); });
                angular.forEach(tabs, function (tab) {
                    var tabClass = (tab.href || '').toLowerCase() === location.pathname.toLowerCase() ? 'active' : '';
                    html += "<li class=\"" + tabClass + "\"><a href=\"" + tab.href + "\"><i class=\"fa fa-fw " + tab.icon + "\"></i> " + tab.label + "</a></li>";
                });
                tabHolder.html(html + "</ul>");
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = { tabs: [] };
            $scope.$watch('data.tabs', function (tabs) {
                if (tabs && tabs.length > 0) {
                    _this.makeTabs(tabs);
                }
            });
        }
        ;
        return UserLayoutController;
    }());
    App.UserLayoutController = UserLayoutController;
    angular.module('UserLayoutApp', ['MinuteFramework', 'gettext'])
        .controller('UserLayoutController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', UserLayoutController]);
})(App || (App = {}));
