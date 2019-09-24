<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
    <link rel="icon" type="image/png" href="image/title.png"/>

	<link rel="stylesheet" type="text/css" href="assets/login/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="assets/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="assets/login/vendor/animate/animate.css">	
	<link rel="stylesheet" type="text/css" href="assets/login/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="assets/login/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="assets/login/vendor/select2/select2.min.css">	
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/daterangepicker/daterangepicker.css">
    
	<link rel="stylesheet" type="text/css" href="assets/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/login/css/main.css">
    <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
                        <span class="login100-form-title p-b-32">
                            Account Login
                        </span>
    
                        <span class="txt1 p-b-11">
                            Email
                        </span>
                        <div class="wrap-input100 validate-input m-b-36" data-validate = "Email is required">
                            <input class="input100" type="email" name="email" id="email" >
                            <span class="focus-input100"></span>
                        </div>
                        
                        <span class="txt1 p-b-11">
                            Password
                        </span>
                        <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
                            <span class="btn-show-pass">
                                <i class="fa fa-eye"></i>
                            </span>
                            <input class="input100" type="password" id="password" name="pass" >
                            <span class="focus-input100"></span>
                        </div>
                        <div class="container-login100-form-btn">
                            <button onclick="login()" class="login100-form-btn">
                                Login
                            </button>
                        </div>
                </div>
            </div>
        </div>
        
    
<div id="dropDownSelect1"></div>
<script src="https://www.gstatic.com/firebasejs/5.10.1/firebase.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/jquery-1.12.0.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
<script src="assets/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="assets/login/vendor/animsition/js/animsition.min.js"></script>
<script src="assets/login/vendor/bootstrap/js/popper.js"></script>
<script src="assets/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/login/vendor/select2/select2.min.js"></script>
<script src="assets/login/vendor/daterangepicker/moment.min.js"></script>
<script src="assets/login/vendor/daterangepicker/daterangepicker.js"></script>
<script src="assets/login/vendor/countdowntime/countdowntime.js"></script>
<script src="assets/login/js/main.js"></script>
<script>
    var config = {
    apiKey: "AIzaSyCc667hw1EAFD3vh-hXnMNna5WeOG7i_Bs",
    authDomain: "talaravel-591d8.firebaseapp.com",
    databaseURL: "https://talaravel-591d8.firebaseio.com",
    projectId: "talaravel-591d8",
    storageBucket: "",
    messagingSenderId: "1079386289801",
    appId: "1:1079386289801:web:3bc40b3105fc762bbaf858"
};
firebase.initializeApp(config);

firebase.auth().onAuthStateChanged(function(user) {    
  if (user) {
    var user = firebase.auth().currentUser;
    firebase.database().ref('dataUser/' + user.uid).once('value').then(function(snapshot) {
        var Nama = (snapshot.val() && snapshot.val().nama) || 'Anonymous';
        var Email = (snapshot.val() && snapshot.val().email) || 'Anonymous';
        var Status = (snapshot.val() && snapshot.val().status) || 'Anonymous';
        const Toast = Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Sign in success',
            showConfirmButton: false,
            timer: 1500
        })
        if (Status == "admin") {            
            $.ajax({
                type: "get",
                url: "{{url('loginPost')}}",
                data: {
                    _token: "{{csrf_token()}}",
                    email: email,
                    userId: user.uid,
                    password: password
                },
                processData: false,
                contentType: false,
                success: function (data) {
					// console.log(data);
					if(data == 1){                        
                        window.location.href = "{{url('home')}}";
                    }else{  

                 	 }
                }
            });            
        }else{
            firebase.auth().signOut();                     
        }
    })
  } else {
    Swal.fire({
    type: 'error',
    title: 'Oops...',
    text: 'Anda belum login!'
    })
  }
});


function login(){
var email = $("#email").val();
var password = $("#password").val();
//Login auth
firebase.auth().signInWithEmailAndPassword(email, password).catch(function(error) {
  // Handle Errors here.
  var errorCode = error.code;
  var errorMessage = error.message;
  Swal.fire({
    type: 'error',
    title: 'Oops...',
    text: 'Akun tidak terdaftar!'
    })
});

}
</script>