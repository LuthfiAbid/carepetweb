@extends('layout.body')
@section('content')
<style type="text/css">
    .desabled {
        pointer-events: none;
    }
</style>
<div class="col-md-12">
    <div class="card card-default">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <strong>All Order Listing</strong>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="table_data" width="100%">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Start Time</th>
                        <th>End Time</th> 
                        <th>Picture</th>
                        <th width="250px" class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Delete Model -->
<form action="" method="POST" class="users-remove-record-model">
    <div id="remove-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Delete Record</h4>
                    <button type="button" class="close remove-data-from-delete-form" data-dismiss="modal"
                        aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <h4>You Want You Sure Delete This Record?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form"
                        data-dismiss="modal">Close</button>
                    <button type="button"
                        class="btn btn-danger waves-effect waves-light deleteMatchRecord">Delete</button>
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
    firebase.database().ref('order').orderByChild('status')
            .equalTo("In Approve").on('value', function(snapshot) {
    var order = snapshot.val();
    obj = [];
    $.each(order, function(index ,order){
        if(order) {
            obj2 = [order.name,order.startTime,order.endTime,'<img height="125" width="125" src='+ order.image +'></img>','<a data-toggle="modal" data-target="#update-modal" class="btn btn-outline-success updateData" data-id="'+index+'">Update</a>\
        		<a data-toggle="modal" data-target="#remove-modal" class="btn btn-outline-danger removeData" data-id="'+index+'">Reject</a>'];
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
    window.location.href = "{{url('loginadmin')}}";
  }
});


function logout(){
    firebase.auth().signOut();
 }

    var database = firebase.database();
    var lastIndex = 0;
   

// Add Data
$('#submitUser').on('click', function(){
	var values = $("#addUser").serializeArray();
	var name = values[0].value;
	var address = values[1].value;
	var userID = lastIndex+1;

    firebase.database().ref('dataUser/' + userID).set({
        name: name,
        address: address,
    });
    // Reassign lastID value
    lastIndex = userID;
	$("#addUser input").val("");
});

// Update Data
var updateID = 0;
$('body').on('click', '.updateData', function() {
	updateID = $(this).attr('data-id');
	firebase.database().ref('order/' + updateID).on('value', function(snapshot) {
		var values = snapshot.val();
		var updateData = '<div class="form-group">\
		        <label for="name" class="col-md-12 col-form-label">First Name</label>\
		        <div class="col-md-12">\
		            <input id="name" type="text" class="form-control" name="name" value="'+values.name+'" required autofocus>\
		        </div>\
		    </div>\
		    <div class="form-group">\
		        <label for="address" class="col-md-12 col-form-label">Last Name</label>\
		        <div class="col-md-12">\
		            <input id="address" type="text" class="form-control" name="address" value="'+values.address+'" required autofocus>\
		        </div>\
		    </div>';

		    $('#updateBody').html(updateData);
	});
});

$('.updateUserRecord').on('click', function() {
    firebase.database().ref('order/' +updateID).on('value', function(snapshot) {
    // var values = $(".users-update-record-model").serializeArray();
    var data = snapshot.val();
	var postData = {
        orderid:data.orderid,
        endTime:data.endTime,
        startTime:data.startTime,
        jenis:data.jenis,
        image:data.image,
        phone:data.phone,
        userid:data.userid,
        note:data.note,
        name:data.name,
        status:"In Proccess"
    };
    
	var updates = {};
	updates['order/' + updateID] = postData;
	firebase.database().ref().update(updates);
	$("#update-modal").modal('hide');
});
});

// Remove Data
$("body").on('click', '.removeData', function() {
	var id = $(this).attr('data-id');
	$('body').find('.users-remove-record-model').append('<input name="id" type="hidden" value="'+ id +'">');
});

$('.deleteMatchRecord').on('click', function(){
	var values = $(".users-remove-record-model").serializeArray();
	var id = values[0].value;
	firebase.database().ref('dataUser/' + id).remove();
    $('body').find('.users-remove-record-model').find( "input" ).remove();
	$("#remove-modal").modal('hide');
});
$('.remove-data-from-delete-form').click(function() {
	$('body').find('.users-remove-record-model').find( "input" ).remove();
});

</script>
@endsection