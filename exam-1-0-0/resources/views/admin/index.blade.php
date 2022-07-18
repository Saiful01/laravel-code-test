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
            <p>Welcome to Admin Dashboard</p>
        </div>
        <form action="/admin/dashboard" method="post">
            @csrf
        <div class="row mt-5">
            <input type="hidden" name="data" value="{{json_encode($old_data)}}">

                <div class="col-md-4">
                    <select class="form-control" name="user_type">
                        <option value="">All</option>
                        <option value="1">Admin</option>
                        <option value="2">Agent</option>
                        <option value="3">User</option>
                    </select>
                </div>
                <div class="col-md-4">

                    <input type="text" class="form-control" name="user_input"
                           placeholder="Name Or User id"/>

                </div>
                <div class="col-md-4">

                    <button type="submit" class="btnSubmit">Search</button>

                </div>


        </div>
        </form>
        <div class="row mt-5">
            <h5> Total User List</h5>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">#SL</th>
                    <th scope="col">User Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">User Type</th>
                </tr>
                </thead>
                <tbody>
                @php($i=1)
                @foreach($result as $res)
                    <tr>

                        <th scope="row">{{$i}}</th>
                        <td>{{$res['user_id']}}</td>
                        <td>{{$res['name']}}</td>
                        <td>{{$res['email']}}</td>
                        <td>
                            @if($res['user_type']==1)
                                <span class="badge badge-danger">Admin</span>
                            @elseif($res['user_type']==2)
                                <span class="badge badge-warning">Agent</span>
                            @else
                                <span class="badge badge-primary">User</span>
                            @endif
                        </td>

                    </tr>

                    @php($i++)
                @endforeach
                </tbody>
            </table>
        </div>
        <a href="/logout" class="btn btn-danger">
            Logout

        </a>


    </div>
</div>
</body>


