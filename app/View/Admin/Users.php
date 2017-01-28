<div class="content-wrapper ng-cloak" ng-app="userListApp" ng-controller="userListController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1><span translate="">List of users</span> <small><span translate="">(recent signups)</span></small></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li class="active"><i class="fa fa-user"></i> <span translate="">User list</span></li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">{{users.getTotalItems()}} <span translate="">users</span></h3>
                </div>

                <div class="box-body">
                    <div class="list-group">
                        <div class="list-group-item list-group-item-bar list-group-item-bar-{{user.verified && 'success' || 'danger'}}"
                             ng-repeat="user in users" ng-click-container="mainCtrl.actions(user)">
                            <div class="pull-left">
                                <h4 class="list-group-item-heading" ng-switch on="(user.first_name || user.last_name) && true">
                                    <span ng-switch-when="true">{{(user.first_name + ' ' + user.last_name) | ucfirst}}</span>
                                    <span translate="" ng-switch-default="">No name</span>
                                    <span class="text-sm" ng-show="!!user.email">(<a href="mailto:{{user.email}}">{{user.email}}</a>)</span>
                                </h4>
                                <p class="list-group-item-text hidden-xs">
                                    <span translate="">Created:</span> {{user.created_at | timeAgo}}.
                                    <span translate="">Groups:</span>
                                    <span ng-if="!user.groups.length" translate="">None</span>
                                    <span ng-if="!!user.groups.length" ng-repeat="group in user.groups">{{group.group_name | ucfirst}}<i>{{$last && '.' || ', '}}</i></span>
                                </p>
                            </div>

                            <div class="md-actions pull-right">
                                <a class="btn btn-default btn-flat btn-sm" ng-href="/admin/users/edit/{{user.user_id}}">
                                    <i class="fa fa-pencil-square-o"></i> <span translate="">Edit..</span>
                                </a>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-push-6">
                            <minute-pager class="pull-right" on="users" no-results="{{'No users found' | translate}}"></minute-pager>
                        </div>
                        <div class="col-xs-12 col-md-6 col-md-pull-6">
                            <minute-search-bar on="users" columns="first_name, last_name, email" label="{{'Search user..' | translate}}"></minute-search-bar>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
