/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module AdminApp {
    export class UserEditController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.user = $scope.users[0];
        }

        indexOf = (key) => {
            for (let i = 0; i < this.$scope.user.data.length; i++) {
                if (this.$scope.user.data[i].key == key) {
                    return i;
                }
            }

            return this.$scope.user.data.create().attr('key', key);
        };

        save = () => {
            this.$scope.user.save(this.gettext('User profile updated successfully')).then(() => this.$scope.user.data.saveAll());
        };
    }

    angular.module('userEditApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('userEditController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', UserEditController]);
}
