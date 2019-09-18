@extends('layout.body')
@section('box')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="tile-stats">
                            <div class="panel-body">
                            <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                            <h3><div class="count" id="count"></div></h3>
                            <h3>Order Pending</h3>
                            <a href="{{url('pendingOrder')}}" type="button" class="btn btn-info">Show</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://www.gstatic.com/firebasejs/5.10.1/firebase.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    var config = {
        apiKey: "AIzaSyCc667hw1EAFD3vh-hXnMNna5WeOG7i_Bs",
        authDomain: "talaravel-591d8.firebaseapp.com",
        databaseURL: "https://talaravel-591d8.firebaseio.com",
        projectId: "talaravel-591d8",
        storageBucket: "talaravel-591d8.appspot.com",
        messagingSenderId: "1079386289801",
        appId: "1:1079386289801:web:3bc40b3105fc762bbaf858"
    };
    firebase.initializeApp(config);
    var ref = firebase.database().ref("order").orderByChild('status').equalTo("In Approve");
        ref.once("value")
        .then(function(snapshot) {
            var order = snapshot.numChildren();
            $('#count').append(order);
        }); 
</script>
@endsection
@section('content')
<h2>Selamat Datang Admin !</h2>
@endsection