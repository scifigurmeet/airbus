@include('header')
<?php
$url_of_api = 'http://localhost/airbus/api.php';
?>
<table id="dataTable" class="table table-hover">
	<thead>
		<td>ID</td>
		<td>flight ID</td><td>Passengers</td><td>price</td><td>email</td><td>Phone</td>		<td>Options</td>
	</thead>
</table>
<script>
$(document).ready(function(){
    $('#dataTable').DataTable({
		"processing" : true,
        "ajax" : {
            "url" : "http://localhost/smart/api.php",
			dataSrc : ''
        },
		"columns" : [
		{"data" : "id"},
				{"data" : "flight_id"},
				{"data" : "passengers"},
				{"data" : "price"},
				{"data" : "email"},
				{"data" : "phone"},
				{"render": function (data, type, row, meta) {
					return '<a class="btn btn-danger" href="mailto:'+row.email+'" target="_blank">Send Offers</a>';
			}
		}
        ]
	});
});

function editModal(id){
	$('#editModal').modal('show');
	$('#serial').attr("count",id);
		$('#editModal [name=flight_id]').val("");
	$('#editModal [name=flight_id]').prop('disabled', true);
		$('#editModal [name=passengers]').val("");
	$('#editModal [name=passengers]').prop('disabled', true);
		$('#editModal [name=price]').val("");
	$('#editModal [name=price]').prop('disabled', true);
		$('#editModal [name=email]').val("");
	$('#editModal [name=email]').prop('disabled', true);
		$('#editModal [name=phone]').val("");
	$('#editModal [name=phone]').prop('disabled', true);
		$.ajax({
		type: 'GET',
		url: "http://localhost/smart/api.php",
		data: {id: id},
		success: function(response){
			data = response[0];
						$('#editModal [name=flight_id]').val(data.flight_id);
			$('#editModal [name=flight_id]').prop('disabled', false);
						$('#editModal [name=passengers]').val(data.passengers);
			$('#editModal [name=passengers]').prop('disabled', false);
						$('#editModal [name=price]').val(data.price);
			$('#editModal [name=price]').prop('disabled', false);
						$('#editModal [name=email]').val(data.email);
			$('#editModal [name=email]').prop('disabled', false);
						$('#editModal [name=phone]').val(data.phone);
			$('#editModal [name=phone]').prop('disabled', false);
					}
	});
}

function deleteModal(id){
	$('#deleteModal').modal('show');
	$('#deleteSerial').attr("count",id);
}

function deleteField(id){
	$.ajax({
		type: 'DELETE',
		url: "http://localhost/smart/api.php",
		data: {id: id},
		success: function(response){
			$('#dataTable').DataTable().ajax.reload();
				toast(response);
			}
	});
	$('#deleteModal').modal('hide');
}

function addModal(){
	$('#addModal').modal('show');
		type = $('#addModal [name=flight_id]').attr('type');
	if(type != 'checkbox' && type != 'radio'){
	$('#addModal [name=flight_id]').val("");
	}
		type = $('#addModal [name=passengers]').attr('type');
	if(type != 'checkbox' && type != 'radio'){
	$('#addModal [name=passengers]').val("");
	}
		type = $('#addModal [name=price]').attr('type');
	if(type != 'checkbox' && type != 'radio'){
	$('#addModal [name=price]').val("");
	}
		type = $('#addModal [name=email]').attr('type');
	if(type != 'checkbox' && type != 'radio'){
	$('#addModal [name=email]').val("");
	}
		type = $('#addModal [name=phone]').attr('type');
	if(type != 'checkbox' && type != 'radio'){
	$('#addModal [name=phone]').val("");
	}
	}

function addNew(){
	formData = $("#addModal form").serializeArray();
	$.ajax({
		type: 'POST',
		url: "http://localhost/smart/api.php",
		data: formData,
		success: function(response){
			$('#dataTable').DataTable().ajax.reload();
				toast(response);
			}
	});
	$('#addModal').modal('hide');
}

function save(id){
	formData = $("#editModal form").serializeArray();
	formData.push({name: "id", value: id});
	$.ajax({
		type: 'PUT',
		url: "http://localhost/smart/api.php",
		data: formData,
		success: function(response){
			$('#dataTable').DataTable().ajax.reload();
				toast(response);
			}
	});
	$('#editModal').modal('hide');
}

function toast(message){
	$('#toastMessage').text(message);
	$('#toast').toast('show');
	beep();
}

function beep() {
    var snd = new Audio("data:audio/wav;base64,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qJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=");  
    snd.play();
}

</script>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Field</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" enctype="multipart/form-data">

<!-- flight ID -->
<div class="form-group">
<label>flight ID</label>
<input class="form-control" type="number" name="flight_id" placeholder="flight ID">
</div>


<!-- Passengers -->
<div class="form-group">
<label>Passengers</label>
<input class="form-control" type="text" name="passengers" placeholder="Passengers">
</div>


<!-- price -->
<div class="form-group">
<label>price</label>
<input class="form-control" type="number" name="price" placeholder="price">
</div>


<!-- email -->
<div class="form-group">
<label>email</label>
<input class="form-control" type="email" name="email" placeholder="email">
</div>


<!-- Phone -->
<div class="form-group">
<label>Phone</label>
<input class="form-control" type="text" name="phone" placeholder="Phone">
</div>


</form>      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="serial" type="button" class="btn btn-primary" onclick="save(this.getAttribute('count'));">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Insert Modal -->
<div class="modal fade" id="addModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add New Field</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" enctype="multipart/form-data">

<!-- flight ID -->
<div class="form-group">
<label>flight ID</label>
<input class="form-control" type="number" name="flight_id" placeholder="flight ID">
</div>


<!-- Passengers -->
<div class="form-group">
<label>Passengers</label>
<input class="form-control" type="text" name="passengers" placeholder="Passengers">
</div>


<!-- price -->
<div class="form-group">
<label>price</label>
<input class="form-control" type="number" name="price" placeholder="price">
</div>


<!-- email -->
<div class="form-group">
<label>email</label>
<input class="form-control" type="email" name="email" placeholder="email">
</div>


<!-- Phone -->
<div class="form-group">
<label>Phone</label>
<input class="form-control" type="text" name="phone" placeholder="Phone">
</div>


</form>      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="addNew();">Submit Data</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Delete Field</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure that you want to delete this field?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO, TAKE ME BACK</button>
        <button id="deleteSerial" type="button" class="btn btn-primary" onclick="deleteField(this.getAttribute('count'));">YES, DELETE</button>
      </div>
    </div>
  </div>
</div>

<div id="toast" class="toast" role="toast" aria-live="assertive" aria-atomic="true" data-delay="5000" style="display: block; position: fixed; top: 10px; right: 10px; min-width: 200px;">
  <div class="toast-header">
    <i class="fa fa-paper-plane"></i>&nbsp;
    <strong class="mr-auto">Response</strong>
    <small class="text-muted">Just Now</small>
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body" id="toastMessage">
  </div>
</div>
@include('footer')