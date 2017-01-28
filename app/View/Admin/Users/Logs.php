<div class="content-wrapper ng-cloak" ng-app="logListApp" ng-controller="logListController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content">

            <div id="tabs"></div>

            <div class="tab-content">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span translate="">All logs</span>
                        </h3>

                        <div class="box-tools">
                            <a class="btn btn-sm btn-primary btn-flat" ng-href="/admin/logs/edit">
                                <i class="fa fa-plus-circle"></i> <span translate="">Create new log</span>
                            </a>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="list-group">
                            <div class="list-group-item list-group-item-bar list-group-item-bar-default"
                                 ng-repeat="log in logs" ng-click-container="mainCtrl.actions(log)">
                                <div class="pull-left">
                                    <h4 class="list-group-item-heading">{{log.event.event_name | ucfirst}}</h4>
                                    <p class="list-group-item-text hidden-xs">
                                        <span translate="">Created:</span> {{log.created_at | timeAgo}}.
                                        <span translate="" ng-show="log.event_data">Info: {{log.event_data}}</span>
                                    </p>
                                </div>
                                <div class="md-actions pull-right">
                                    <a class="btn btn-default btn-flat btn-sm" ng-click="log.removeConfirm()">
                                        <i class="fa fa-pencil-square-o"></i> <span translate="">remove</span>
                                    </a>
                                </div>

                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <minute-pager num-pages="10" class="pull-right" on="logs" no-results="{{'No logs found' | translate}}"></minute-pager>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
