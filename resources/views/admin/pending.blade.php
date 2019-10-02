@extends('layout.body')
@section('content')
<style type="text/css">
    .desabled {
        pointer-events: none;
    }
    textarea {
        max-width: 46em;
        resize: vertical;
        padding: 10px 0px 0px 10px;
    }
</style>
<div class="col-md-12">
    <div class="card card-default">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <strong>All Order Need Approved</strong>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="table_data" width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Customer Name</th>
                        <th>Start Time</th>
                        <th>End Time</th> 
                        <th>Status</th>
                        <th>Picture</th>
                        <th width="250px" class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Delete Model -->
<form action="" method="POST" class="users-remove-record-model form-horizontal">
    <div id="remove-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Reject Order</h4>
                    <button type="button" class="close remove-data-from-delete-form" data-dismiss="modal"
                        aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="rejectBody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form"
                        data-dismiss="modal">Close</button>
                    <button type="button"
                        class="btn btn-danger waves-effect waves-light rejectMatchRecord">Reject</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Update Model -->
<form action="" method="POST" class="users-update-record-model form-horizontal">
    <div id="update-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content" style="overflow: hidden;">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Update Record</h4>
                    <button type="button" class="close update-data-from-delete-form" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="updateBody">
                    <h4>Are you sure want to approve this order?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect update-data-from-delete-form" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success waves-effect waves-light updateUserRecord">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="https://www.gstatic.com/firebasejs/5.10.1/firebase.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="{{URL::asset('DataTables/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('DataTables/js/datatables.bootstrap.min.js')}}"></script>
<script>
    // Initialize Firebase
var config = {
    apiKey: "AIzaSyCc667hw1EAFD3vh-hXnMNna5WeOG7i_Bs",
    authDomain: "talaravel-591d8.firebaseapp.com",
    databaseURL: "https://talaravel-591d8.firebaseio.com",
    projectId: "talaravel-591d8",
    storageBucket: "talaravel-591d8.appspot.com",
    messagingSenderId: "1079386289801",
    appId: "1:1079386289801:web:3bc40b3105fc762bbaf858"
};

$(function () {
    var obj = [];
    var obj2 = [];
    var no = 0;
    firebase.database().ref('order').orderByChild('status')
            .equalTo("In Approve").on('value', function(snapshot) {
    var order = snapshot.val();
    obj = [];    
    no++;
    $.each(order, function(index ,order){
        if(order) {
            obj2 = [no,order.name,order.startTime,order.endTime,'<span class="label label-warning">'+order.status+'</span>','<img height="125" width="125" src='+ order.image +'></img>','<a data-toggle="modal" data-target="#update-modal" class="btn btn-success updateData" data-id="'+index+'">Update</a>\
        		<a data-toggle="modal" data-target="#remove-modal" class="btn btn-danger removeData" data-id="'+index+'">Reject</a>'];
            obj.push(obj2);
        }
        });
    addTable(obj);
    function addTable(data){
    $('#table_data').DataTable().clear().draw();
    $('#table_data').DataTable().rows.add(data).draw();
    }
});
});
firebase.initializeApp(config);
firebase.auth().onAuthStateChanged(function(user) {
  if (user) {

  } else {
    window.location.href = "{{url('login')}}";
  }
});

function logout(){
    firebase.auth().signOut();
 }

var database = firebase.database();
var lastIndex = 0;

// Update Data
var updateID = 0;
$('body').on('click', '.updateData', function() {
	updateID = $(this).attr('data-id');
	firebase.database().ref('order/' + updateID).on('value', function(snapshot) {
		var values = snapshot.val();
	});
});

$('.updateUserRecord').on('click', function() {
    firebase.database().ref('order/' +updateID).on('value', function(snapshot) {
    var data = snapshot.val();
	var postData = {
        orderid:data.orderid,
        endTime:data.endTime,
        startTime:data.startTime,
        image:data.image,
        phone:data.phone,
        userid:data.userid,
        note:data.note,
        name:data.name,
        time:data.time,
        status:"In Proccess"
    };
    
	var updates = {};
	updates['order/' + updateID] = postData;
	firebase.database().ref().update(updates);
	$("#update-modal").modal('hide');
});
});

//Reject Order
var updateID = 0;
$('body').on('click', '.removeData', function() {
	updateID = $(this).attr('data-id');
	firebase.database().ref('order/' + updateID).on('value', function(snapshot) {
		var values = snapshot.val();
		var updateData = 
            '<div class="form-group">\
		        <label for="name" class="col-md-12 col-form-label">Customer Name</label>\
		        <div class="col-md-12">\
		            <input id="name" type="text" class="form-control" readonly name="name" value="'+values.name+'">\
		        </div>\
		    </div>\
		    <div class="form-group">\
		        <label for="time" class="col-md-12 col-form-label">Order Time</label>\
		        <div class="col-md-12">\
		            <input id="time" type="text" class="form-control" readonly name="time" value="'+values.time+'">\
		        </div>\
		    </div>\
            <div class="form-group">\
		        <label for="note" class="col-md-12 col-form-label">Note</label>\
		        <div class="col-md-12">\
		            <textarea id="note" name="note" class="form-control" placeholder="Problems . . ." cols="85" rows="5"></textarea>\
		        </div>\
		    </div>';

		    $('#rejectBody').html(updateData);
	});
});

$('.rejectMatchRecord').on('click', function() {
    firebase.database().ref('order/' +updateID).on('value', function(snapshot) {
    var data = snapshot.val();
	var values = $(".users-remove-record-model").serializeArray();

	var postData = {
        name:values[0].value,
        time:values[1].value,
        orderid:data.orderid,
        endTime:data.endTime,
        startTime:data.startTime,
        image:data.image,
        phone:data.phone,
        userid:data.userid,
        note:data.note,
        status:"Rejected"
	};
	var updates = {};
	updates['/order/' + updateID] = postData;
	firebase.database().ref().update(updates); 
	firebase.database().ref().child('/orderReject/'+data.orderid).set({
        userid:data.userid,
        orderid:data.orderid,
        name:values[0].value,
        time:values[1].value,
        note:values[2].value
    }); 

	$("#remove-modal").modal('hide');
});
});

</script>
@endsection