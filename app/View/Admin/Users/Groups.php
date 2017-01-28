<div class="content-wrapper ng-cloak" ng-app="groupListApp" ng-controller="groupListController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content">

            <div id="tabs"></div>

            <div class="tab-content">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span translate="">All groups</span>
                        </h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-flat btn-primary btn-sm" ng-click="mainCtrl.update(groups.create())">
                                <i class="fa fa-plus-circle"></i> <span translate="">Add member to another group</span>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <div ng-if="!groups.length">
                            <h4><span translate="">Member does not belong to any group yet.</span></h4>
                        </div>

                        <div class="list-group-item list-group-item-bar list-group-item-bar-{{now > group.expires_at && 'danger' || 'success'}}" ng-repeat="group in groups | orderBy:'expires_at':true">
                            <div class="pull-left">
                                <h4 class="list-group-item-heading">{{group.group_name | ucfirst}}</h4>
                                <p class="list-group-item-text hidden-xs">
                                    {{group.credits}} credit(s) /
                                    <span translate="" ng-if="now > group.expires_at">expired</span>
                                    <span translate="" ng-if="now < group.expires_at">expires</span>
                                    {{group.expires_at | timeAgo}}
                                </p>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-default btn-flat btn-sm" ng-click="mainCtrl.update(group)"><span translate="">update</span></a>
                                <a class="btn btn-default btn-flat btn-sm" ng-click="group.removeConfirm()"><span translate="">remove</span></a>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="row">
                            <div class="col-xs-12 col-md-6 col-md-push-6">
                                <minute-pager class="pull-right" on="groups" no-results="{{'No groups found' | translate}}"></minute-pager>
                            </div>
                            <div class="col-xs-12 col-md-6 col-md-pull-6">
                                <minute-search-bar on="groups" columns="group_name, comments" label="{{'Search groups..' | translate}}"></minute-search-bar>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script type="text/ng-template" id="/group-editor.html">
        <div class="box container">
            <div class="box-header with-border">
                <b class="pull-left">
                    <span translate="" ng-if="!group.group_id">Add</span><span translate="" ng-if="group.group_id">Edit</span> <span translate="">group</span>
                </b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
            </div>

            <form class="form-horizontal" name="groupForm">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="group_name"><span translate="">Group name:</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="group_name" placeholder="Enter Group name" ng-model="group.group_name" ng-required="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="expires_at"><span translate="">Expires on:</span></label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="expires_at" placeholder="Enter Expires on" ng-model="group.expires_at" ng-required="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="credits"><span translate="">Credits:</span></label>
                        <div class="col-sm-8">
                            <input type="number" min="0" step="1" class="form-control" id="credits" placeholder="Enter Credits" ng-model="group.credits" ng-required="true">
                        </div>
                    </div>
                </div>

                <div class="box-footer with-border">
                    <button type="button" class="btn btn-flat btn-primary pull-right close-button" ng-disabled="!groupForm.$valid" ng-click="group.save(true)">
                        <span translate>Save</span> <i class="fa fa-fw fa-angle-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </script>
</div>
