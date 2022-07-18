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
@include('sweetalert::alert')
<div class="container register-form">
    <div class="form">
        <div class="note">
            <p>Welcome to Saiful Islam Coding Test Demo</p>
        </div>

        <div class="form-content">

            <div class="row">
                <div class="col-md-6 mx-auto">
                    <h5 class="mx-auto"> Login Form</h5>
                    <form method="post" action="login-check">
                        @csrf


                        <div class="form-group">
                            <input type="email" class="form-control" name="email" ng-model="email"
                                   placeholder="Your Email *" required/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control"
                                   id="pwd"
                                   placeholder="Enter password" name="password" ng-model="password">
                        </div>

                        <button type="submit" class="btnSubmit">Login</button>

                    </form>

                </div>

            </div>

        </div>
    </div>
</div>
</body>


