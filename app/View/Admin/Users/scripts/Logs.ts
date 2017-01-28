/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class LogListController {
        constructor(public $scope:any, public $minute:any, public $ui:any, public $timeout:ng.ITimeoutService,
                    public gettext:angular.gettext.gettextFunction, public gettextCatalog:angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.logs = $scope.user[0].logs;
        }

        actions = (item) => {
            let gettext = this.gettext;
            let actions = [
                {'text': gettext('Edit..'), 'icon': 'fa-edit', 'hint': gettext('Edit log'), 'href': '/admin/logs/edit/' + item.log_id},
                {'text': gettext('Clone'), 'icon': 'fa-copy', 'hint': gettext('Clone log'), 'click': 'ctrl.clone(item)'},
                {'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this log'), 'click': 'item.removeConfirm("Removed")'},
            ];

            this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.name, this.$scope, {item: item, ctrl: this});
        };

        clone = (log) => {
            let gettext = this.gettext;
            this.$ui.prompt(gettext('Enter new slug'), gettext('/new-slug')).then(function (slug) {
                log.clone().attr('slug', slug).save(gettext('Log duplicated')).then(function (copy) {
                    angular.forEach(log.contents, (content) => copy.item.contents.cloneItem(content).save());
                });
            });
        }
    }

    angular.module('logListApp', ['MinuteFramework', 'MinuteDirectives', 'MinuteFilters', 'gettext', 'angular.filter'])
        .controller('logListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', LogListController]);
}
