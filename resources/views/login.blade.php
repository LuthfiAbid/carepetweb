<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>

<div class="vertical-align-wrap">
    <div class="vertical-align-middle">
        <div class="auth-box ">
            <div class="left">
                <div class="content">
                    <div class="header">
                        <p class="lead">
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="signin-email" class="control-label sr-only">Email</label>
                        <input type="email" id="email" class="form-control" name="username" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="signin-password" class="control-label sr-only">Password</label>
                        <input type="password" id="password" class="form-control" name="password"
                            placeholder="Password">
                    </div>
                    {{-- <div class="form-group clearfix">
                            <label class="fancy-checkbox element-left">
                                <input type="checkbox">
                                <span>Remember me</span>
                            </label>
                        </div> --}}
                    <button type="submit" onclick="login()" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                    {{-- <button type="submit" onclick="daftar()" class="btn btn-primary btn-lg btn-block">DAFTAR</button> --}}
                </div>
            </div>
            <div class="right">
                <div class="overlay"></div>
                <div class="content text">
                    <h1 class="heading">Login Admin</h1>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
</div>
<script src="https://www.gstatic.com/firebasejs/5.10.1/firebase.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/jquery-1.12.0.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
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

// function daftar(){
// var email = $("#email").val();
// var password = $("#password").val();
// // alert(passsword);
// //Register auth
// firebase.auth().createUserWithEmailAndPassword(email, password).catch(function(error) {
//   // Handle Errors here.
//   var errorCode = error.code;
//   var errorMessage = error.message;

//   window.alert(errorMessage);
//   // ...
//     });
// }

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