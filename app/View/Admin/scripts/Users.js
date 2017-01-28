/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var UserListController = (function () {
        function UserListController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
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
                    { 'text': gettext('Details'), 'icon': 'fa-search', 'hint': gettext('View user'), 'href': '/admin/users/edit/' + item.user_id },
                    { 'text': gettext('Login as..'), 'icon': 'fa-sign-in', 'hint': gettext('Sign in as user..'), 'href': '/admin/users/login-as/' + item.user_id },
                    { 'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this user'), 'click': 'item.removeConfirm("Removed")' },
                ];
                _this.$ui.bottomSheet(actions, gettext('Actions for user #') + item.user_id, _this.$scope, { item: item, ctrl: _this });
            };
            this.clone = function (user) {
                var gettext = _this.gettext;
                _this.$ui.prompt(gettext('Enter new slug'), gettext('/new-slug')).then(function (slug) {
                    user.clone().attr('slug', slug).save(gettext('User duplicated')).then(function (copy) {
                        angular.forEach(user.contents, function (content) { return copy.item.contents.cloneItem(content).save(); });
                    });
                });
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }
        return UserListController;
    }());
    Admin.UserListController = UserListController;
    angular.module('userListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('userListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', UserListController]);
})(Admin || (Admin = {}));
