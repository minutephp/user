/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var LogListController = (function () {
        function LogListController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.actions = function (item) {
                var gettext = _this.gettext;
                var actions = [
                    { 'text': gettext('Edit..'), 'icon': 'fa-edit', 'hint': gettext('Edit log'), 'href': '/admin/logs/edit/' + item.log_id },
                    { 'text': gettext('Clone'), 'icon': 'fa-copy', 'hint': gettext('Clone log'), 'click': 'ctrl.clone(item)' },
                    { 'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this log'), 'click': 'item.removeConfirm("Removed")' },
                ];
                _this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.name, _this.$scope, { item: item, ctrl: _this });
            };
            this.clone = function (log) {
                var gettext = _this.gettext;
                _this.$ui.prompt(gettext('Enter new slug'), gettext('/new-slug')).then(function (slug) {
                    log.clone().attr('slug', slug).save(gettext('Log duplicated')).then(function (copy) {
                        angular.forEach(log.contents, function (content) { return copy.item.contents.cloneItem(content).save(); });
                    });
                });
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.logs = $scope.user[0].logs;
        }
        return LogListController;
    }());
    Admin.LogListController = LogListController;
    angular.module('logListApp', ['MinuteFramework', 'MinuteDirectives', 'MinuteFilters', 'gettext', 'angular.filter'])
        .controller('logListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', LogListController]);
})(Admin || (Admin = {}));
