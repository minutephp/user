<div class="content-wrapper ng-cloak" ng-app="userEditApp" ng-controller="userEditController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content">
            <minute-event name="IMPORT_USER_GET_PROFILE_FIELDS" as="data.fields"></minute-event>

            <div id="tabs"></div>

            <div class="tab-content">
                <form class="form-horizontal" name="userForm" ng-submit="mainCtrl.save()">
                    <div class="box box-solid">
                        <div class="box-header with-border text-bold">
                            <span translate="" ng-show="!user.user_id">New user</span>
                            <span ng-show="!!user.user_id"><span translate="">Edit user</span></span>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="first_name"><span translate="">First name:</span></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="first_name" placeholder="Enter First name" ng-model="user.first_name" ng-required="true">
                                </div>
                                <label class="col-sm-3 control-label" for="last_name"><span translate="">Last name:</span></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="last_name" placeholder="Enter Last name" ng-model="user.last_name" ng-required="false">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="email"><span translate="">Email:</span></label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" placeholder="Enter Email" ng-model="user.email" ng-required="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="photo_url"><span translate="">Picture:</span></label>
                                <div class="col-sm-9">
                                    <minute-uploader ng-model="user.photo_url" type="image" preview="true" remove="true" label="Profile pic"></minute-uploader>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="info"><span translate="">Created:</span></label>
                                <div class="col-sm-9">
                                    <p class="help-block" translate="">{{user.created_at | timeAgo}}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="info"><span translate="">Login as user:</span></label>
                                <div class="col-sm-9">
                                    <p class="help-block">
                                        <a class="btn btn-flat btn-default btn-sm" ng-href="/admin/users/login-as/{{user.user_id}}?redir={{data.self}}" target="_top">
                                            <i class="fa fa-check"></i> <span translate="">Login as..</span>
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <hr ng-show="!!data.fields.length" />

                            <div class="form-group" ng-repeat="field in data.fields">
                                <label class="col-sm-3 control-label">{{field.label}}:</label>
                                <div class="col-sm-9">
                                    <input type="{{field.type || 'text'}}" class="form-control" placeholder="{{field.placeholder || 'Enter ' + field.label}}"
                                           ng-model="user.data[mainCtrl.indexOf(field.field)].data" ng-required="field.required">
                                </div>
                            </div>

                        </div>

                        <div class="box-footer with-border">
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-flat btn-primary">
                                        <span translate="" ng-show="!user.user_id">Create</span>
                                        <span translate="" ng-show="!!user.user_id">Update</span>
                                        <span translate="">user</span>
                                        <i class="fa fa-fw fa-angle-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </section>
    </div>
</div>
