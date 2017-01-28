/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class UserListController {
        constructor(public $scope:any, public $minute:any, public $ui:any, public $timeout:ng.ITimeoutService,
                    public gettext:angular.gettext.gettextFunction, public gettextCatalog:angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }

        actions = (item) => {
            let gettext = this.gettext;
            let actions = [
                {'text': gettext('Details'), 'icon': 'fa-search', 'hint': gettext('View user'), 'href': '/admin/users/edit/' + item.user_id},
                {'text': gettext('Login as..'), 'icon': 'fa-sign-in', 'hint': gettext('Sign in as user..'), 'href': '/admin/users/login-as/' + item.user_id},
                {'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this user'), 'click': 'item.removeConfirm("Removed")'},
            ];

            this.$ui.bottomSheet(actions, gettext('Actions for user #') + item.user_id, this.$scope, {item: item, ctrl: this});
        };

        clone = (user) => {
            let gettext = this.gettext;
            this.$ui.prompt(gettext('Enter new slug'), gettext('/new-slug')).then(function (slug) {
                user.clone().attr('slug', slug).save(gettext('User duplicated')).then(function (copy) {
                    angular.forEach(user.contents, (content) => copy.item.contents.cloneItem(content).save());
                });
            });
        }
    }

    angular.module('userListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('userListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', UserListController]);
}
