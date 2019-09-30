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
                    <strong>All Order History</strong>
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
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
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

//Get Data
$(function () {
    var obj = [];
    var obj2 = [];
    var no = 0;
    firebase.database().ref('order').orderByChild('status')
            .equalTo("Finish").on('value', function(snapshot) {
    var order = snapshot.val();
    obj = [];
    no++;
    $.each(order, function(index ,order){
        if(order) {
            obj2 = [no++,order.name,order.startTime,order.endTime,order.status,'<img height="125" width="125" src='+ order.image +'></img>'];
            obj.push(obj2);
        }
        });
    addTable(obj);
    function addTable(data){
    $('#table_data').DataTable({
        "language": {
                    "emptyTable": "Data Order Kosong",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "infoFiltered": "(disaring dari _MAX_ total data)",
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ Data",
                    "zeroRecords": "Tidak Ada Data yang Ditampilkan",
                    "oPaginate": {
                        "sFirst": "Awal",
                        "sLast": "Akhir",
                        "sNext": "Selanjutnya",
                        "sPrevious": "Sebelumnya"
                    },
                }
    }).clear().draw();
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
    var values = $(".users-update-record-model").serializeArray();
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