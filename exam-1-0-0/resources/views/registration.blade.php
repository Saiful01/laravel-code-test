<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="/asset/css/custom.css" rel="stylesheet">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- Fontawesome CSS -->

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

<script>
    var app = angular.module('myApp', []);
</script>
<script src="/asset/js/custom-angular.js"></script>
<body ng-app="myApp" ng-controller="myCtrl">
<div class="container register-form">
    <div class="form">
        <div class="note">
            <p>Welcome to Saiful Islam Coding Test Demo</p>
        </div>

        <div class="form-content">

            <div class="row">
                <div class="col-md-6 mx-auto">
                    <h5 class="mx-auto"> Registration Form</h5>
                    <form>
                        @csrf
                        <div class="form-group">
                            <select class="form-control" name="user_type" ng-model="user_type">
                                <option value="">Choose User Type</option>
                                <option value="1">Admin</option>
                                <option value="2">Agent</option>
                                <option value="3">User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="Text" class="form-control" id="name"
                                   placeholder="Enter Name"
                                   name="name" ng-model="name">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" ng-model="email"
                                   placeholder="Your Email *" required/>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btnSubmit" id="otp_button"
                                    ng-click="registrationOtp()">Send OTP
                            </button>
                            <p id="timer" class="badge badge-danger p-2" style="display: none">0</p>
                        </div>

                        <div style="display: none" id="otp_area">
                            <div class="form-group">
                                <div class="form-group">
                                    <input placeholder="Please Enter Your OTP From Inbox" type="text"
                                           name="otp" required="" class="form-control " ng-model="otp">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control"
                                       id="pwd"
                                       placeholder="Enter password" name="password" ng-model="password">
                            </div>

                            <button type="submit" class="btnSubmit" ng-click="registration()">Submit</button>
                        </div>


                    </form>
                    <p>If You Have Account? <a href="/login" class="btn btn-success">Login</a></p>

                </div>

            </div>

        </div>
    </div>
</div>
</body>


