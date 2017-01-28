/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var AdminApp;
(function (AdminApp) {
    var UserEditController = (function () {
        function UserEditController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.indexOf = function (key) {
                for (var i = 0; i < _this.$scope.user.data.length; i++) {
                    if (_this.$scope.user.data[i].key == key) {
                        return i;
                    }
                }
                return _this.$scope.user.data.create().attr('key', key);
            };
            this.save = function () {
                _this.$scope.user.save(_this.gettext('User profile updated successfully')).then(function () { return _this.$scope.user.data.saveAll(); });
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.user = $scope.users[0];
        }
        return UserEditController;
    }());
    AdminApp.UserEditController = UserEditController;
    angular.module('userEditApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('userEditController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', UserEditController]);
})(AdminApp || (AdminApp = {}));
