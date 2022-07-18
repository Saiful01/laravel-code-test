app.controller('myCtrl', function ($scope, $http, $location) {

    console.log("App Created")
    $scope.registrationOtp = function () {
        console.log($scope.name);
        console.log($scope.email);


        if ($scope.user_type == null) {
            Swal.fire({
                icon: 'error',
                text: 'Please Enter User Type',
            })
            return;
        }
        if ($scope.name == null) {
            Swal.fire({
                icon: 'error',
                text: 'Please Enter Your Name',
            })
            return;
        }
        if ($scope.email == null) {
            Swal.fire({
                icon: 'error',
                text: 'Please Enter Your Phone',
            })
            return;
        }

        let url = "/registration/otp-sent";
        let params = {
            'name': $scope.name,
            'email': $scope.email,
        };

        $http.post(url, params).then(function success(response) {
            console.log(response.data)

            if (response.data.code == 200) {

                messageSuccess("Please Check Email,OTP has been sent to your Email");
                $scope.startCounter(120);
            } else if (response.data.code == 201) {
                Swal.fire({
                    icon: 'error',
                    text: response.data.message,
                });
                document.getElementById("otp_area").style.display = "block";
                document.getElementById("otp_button").style.display = "none";
                document.getElementById("timer").style.display = "none";
            } else {
                Swal.fire({
                    icon: 'error',
                    text: response.data.message,
                })
            }


        });
    }

    $scope.startCounter = function (time) {

        document.getElementById("otp_area").style.display = "block";
        document.getElementById("otp_button").style.display = "none";
        document.getElementById("timer").style.display = "block";

        var sec = time;
        setInterval(function () {
            document.getElementById("timer").innerHTML = sec + " Seconds remaining";
            sec--;
            if (sec == 0) {

                document.getElementById("timer").style.display = "none";
                document.getElementById("otp_area").style.display = "none";
                document.getElementById("otp_button").style.display = "block";
            }
        }, 1000);
    }
    $scope.registration = function () {
        console.log($scope.otp)
        if ($scope.user_type == null || $scope.name == null || $scope.email == null || $scope.password == null || $scope.otp == null) {
            Swal.fire({
                icon: 'error',
                text: 'All fields are Required',
            })
            return;
        }

        let url = "/registration/save";
        let params = {
            'name': $scope.name,
            'user_type': $scope.user_type,
            'email': $scope.email,
            'otp': $scope.otp,
            'password': $scope.password,
        };
        $http.post(url, params).then(function success(response) {

            if (response.data.status == 200) {
                if (response.data.data.user_type == 1) {
                    window.location.href = "/admin/dashboard";
                }
                if (response.data.data.user_type == 2) {
                    window.location.href = "/agent/dashboard";
                }
                if (response.data.data.user_type == 3) {
                    window.location.href = "/user/dashboard";
                }

            }
            if (response.data.status == 400) {
                messageError(response.data.message)

            }
            console.log(response.data);

        });

    }

    function messageError(message) {
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: message,
            showConfirmButton: false,
            timer: 3000
        })

        //toastr.warning(message, 'Failed')
    }

    function messageSuccess(message) {
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: message,
            showConfirmButton: false,
            timer: 3000
        })

        // toastr.success(message, 'Success')
    }


});


