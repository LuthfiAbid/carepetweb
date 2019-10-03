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
                        <th>No.</th>
                        <th>Customer Name</th>
                        <th>Report Time</th>
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
                        class="btn btn-danger waves-effect waves-light deleteMatchRecord">Reject</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Update Model -->
<form action="" method="POST" class="users-update-record-model form-horizontal">
    <div id="update-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content" style="overflow: hidden;">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Update Record</h4>
                    <button type="button" class="close update-data-from-delete-form" data-dismiss="modal"
                        aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="updateBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect update-data-from-delete-form"
                        data-dismiss="modal">Close</button>
                    <button type="button"
                        class="btn btn-success waves-effect waves-light updateUserRecord">Update</button>
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
var reportfRef = firebase.database().ref('reportOrder');

//Get Data
$(function () {
    var obj = [];
    var obj2 = [];
    var no = 1;
    reportfRef.once('value', function(snapshot) {    
        var report = snapshot.val();
    obj = [];
    $.each(report, function(index ,report){
                obj2 = [no++,report.username,report.time,'<a data-toggle="modal" data-target="#update-modal" class="btn btn-info updateData" data-id="'+index+'">Reply</a>'];
            obj.push(obj2);
        });
    addTable(obj);
    function addTable(data){
    $('#table_data').DataTable().clear().draw();
    $('#table_data').DataTable().rows.add(data).draw();
    }
    });
});

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

// Reply Data
var updateID = 0;
$('body').on('click', '.updateData', function() {
	updateID = $(this).attr('data-id');
    alert(updateID)
	firebase.database().ref('reportOrder/' + updateID).once('value', function(snapshot) {
            var values = snapshot.val();
            console.log(values)
        var updateData = 
            '<div class="form-group">\
		        <label for="name" class="col-md-12 col-form-label">Customer Name</label>\
		        <div class="col-md-12">\
		            <input id="name" type="text" class="form-control" readonly name="name" value="'+values.username+'">\
		        </div>\
		    </div>\
		    <div class="form-group">\
		        <label for="time" class="col-md-12 col-form-label">Order Time</label>\
		        <div class="col-md-12">\
		            <input id="time" type="text" class="form-control" readonly name="time" value="'+values.time+'">\
		        </div>\
		    </div>\
            <div class="form-group">\
		        <label for="note" class="col-md-12 col-form-label">Report from user</label>\
		        <div class="col-md-12">\
		            <textarea id="note" name="note" class="form-control" placeholder="'+values.report+'" readonly cols="85" rows="5"></textarea>\
		        </div>\
		    </div>\
            <div class="form-group">\
		        <label for="note" class="col-md-12 col-form-label">Reply</label>\
		        <div class="col-md-12">\
		            <textarea id="note" name="note" class="form-control" placeholder="Problems . . ." cols="85" rows="5"></textarea>\
		        </div>\
		    </div>';
		    $('#updateBody').html(updateData);
	});
});

$('.updateUserRecord').on('click', function() {
    firebase.database().ref('reportOrder/' +updateID).once('value', function(snapshot) {
    var data = snapshot.val();	

    // firebase.database().ref('reportOrder/' +updateID).update({
    //     id:data.id,
    //     orderid:data.orderid,
    //     report:data.report,
    //     status:"Replied",
    //     time:data.time,
    //     username:data.username,
    // });
    
    var values = $(".users-update-record-model").serializeArray();
    var postData = {
            reply:values[3].value,
        };
    
    alert(values[3].value)
    var updates = {};
    updates['reportOrder/' + updateID +'/reply'] = postData;
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