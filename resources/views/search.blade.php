@include('header')
<?php
$url_of_api = 'http://localhost/airbus/api.php';
?>
<div class="row" style="background: white; padding: 25px; border-radius: 20px;">
<form id="searchForm" action="" method="POST">
<div class="col col-md-12">
<div class="row">
<div class="col col-md-5">
<h4 style="margin: 10px;">Origin</h4>
<select id="origin" name="origin" class="form-control">
<option name="Ludhiana (LUH)">Ludhiana (LUH)</option>
<option name="Chandigarh (IXC)" selected>Chandigarh (IXC)</option>
<option name="Delhi (DEL)">Delhi (DEL)</option>
</select>
</div>
<div class="col col-md-2">
<img src="images/fly.gif" style="border-radius: 20px; margin-top: 20px;">
</div>
<div class="col col-md-5">
<h4 style="margin: 10px;">Destination</h4>
<select id="destination" name="destination" class="form-control">
<option name="Ludhiana (LUH)">Ludhiana (LUH)</option>
<option name="Chandigarh (IXC)">Chandigarh (IXC)</option>
<option name="Delhi (DEL)" selected>Delhi (DEL)</option>
</select>
</div>
</div>
</div>
<div class="col col-md-12">
<br>
<center>
<div class="row">
	<div class="col col-md-3">
	Departure Date
	<input id="date" type="date" class="form-control" value="0" name="departure_date" value="2019-12-08">
	</div>
	<div class="col col-md-2">
	Adults
	<input id="adults" type="number" class="form-control" value="1" name="adults_count">
	</div>
	<div class="col col-md-2">
	Infants
	<input id="infants" type="number" class="form-control" value="0" name="infants_count">
	</div>
	<div class="col col-md-2">
	Children*
	<input id="children" type="number" class="form-control" value="0" name="children_count">
	</div>
	<div class="col col-md-3">
	Class
	<select id="class" name="class" class="form-control">
		<option value="Economy">Economy</option>
		<option value="Premium Economy">Premium Economy</option>
		<option value="Business">Business</option>
	</select>
	</div>
</div>
<br>
<input type="hidden" name="flight_search">
<div class="btn btn-success" onclick="searchFlights();">Search Flights <i class="fab fa-searchengin"></i></div>
</center>
</div>
</form>
</div>
<br>
<div id="results" class="row" style="display: none;background: white; padding: 10px; border-radius: 20px;">
	<div class="col col-md-12">
		<table id="dataTable" class="table table-hover table-responsive">
	<thead>
		<td>ID</td>
		<td style="width: 200px !important;">Airline</td>
		<td>Origin</td><td>Destination</td><td>Departure Date & Time</td><td>Arrival Date & Time</td><td>Fare</td>		<td>Options</td>
	</thead>
</table>
	</div>
</div>
<script>

function searchFlights(){
	formData = $("#searchForm").serializeArray();
	 $('#dataTable').DataTable({
		"language": {
        "emptyTable":"No Flights Available As Per Your Search!"
		},
		"destroy": true,
		"processing" : true,
        "ajax" : {
            "url" : "<?php echo $url_of_api; ?>?flight_search=True&origin=" + $('#origin').val() + "&destination=" + $('#destination').val() + "&date=" + $('#date').val(),
			dataSrc : '',
        },
		"columns" : [
		{"data" : "id"},
		{"render": function (data, type, row, meta) {
					return '<img src="images/air_india_logo.png">';
			}
		},
				{"data" : "origin"},
				{"data" : "destination"},
				{"render": function (data, type, row, meta) {
					return row.arrival_date + "\<br>" + row.arrival_time;
			}
		},
				{"render": function (data, type, row, meta) {
					return row.departure_date + "\<br>" + row.departure_time;
			}
		},
				{"render": function (data, type, row, meta) {
					fareClass = $('#class').val();
					
					if(fareClass == "Economy"){fare = row.economy_fare}
					else if(fareClass == "Premium Economy"){fare = row.premium_economy_fare}
					else {fare = row.business_fare}
					
					fare = $('#adults').val()*fare; + $('#children').val()*fare/2;
				return fare;
			}
		},
				{"render": function (data, type, row, meta) {
				return '<button class="m-1 btn btn-danger" onclick="bookNow(' + row.id + ')">Book Now <i class="fa fa-inr"></i></button>';
			}
		}
        ]
	});
	$('#results').show();
}

function bookNow(id){
	window.location.replace("booking?id="+id+"&class="+$('#class').val());
}

function editModal(id){
	$('#editModal').modal('show');
	$('#serial').attr("count",id);
		$('#editModal [name=origin]').val("");
	$('#editModal [name=origin]').prop('disabled', true);
		$('#editModal [name=destination]').val("");
	$('#editModal [name=destination]').prop('disabled', true);
		$('#editModal [name=departure_date]').val("");
	$('#editModal [name=departure_date]').prop('disabled', true);
		$('#editModal [name=departure_time]').val("");
	$('#editModal [name=departure_time]').prop('disabled', true);
		$('#editModal [name=arrival_date]').val("");
	$('#editModal [name=arrival_date]').prop('disabled', true);
		$('#editModal [name=arrival_time]').val("");
	$('#editModal [name=arrival_time]').prop('disabled', true);
		$('#editModal [name=fare]').val("");
	$('#editModal [name=fare]').prop('disabled', true);
		$.ajax({
		type: 'GET',
		url: "<?php echo $url_of_api; ?>",
		data: {id: id},
		success: function(response){
			data = response[0];
						$('#editModal [name=origin]').val(data.origin);
			$('#editModal [name=origin]').prop('disabled', false);
						$('#editModal [name=destination]').val(data.destination);
			$('#editModal [name=destination]').prop('disabled', false);
						$('#editModal [name=departure_date]').val(data.departure_date);
			$('#editModal [name=departure_date]').prop('disabled', false);
						$('#editModal [name=departure_time]').val(data.departure_time);
			$('#editModal [name=departure_time]').prop('disabled', false);
						$('#editModal [name=arrival_date]').val(data.arrival_date);
			$('#editModal [name=arrival_date]').prop('disabled', false);
						$('#editModal [name=arrival_time]').val(data.arrival_time);
			$('#editModal [name=arrival_time]').prop('disabled', false);
						$('#editModal [name=fare]').val(data.fare);
			$('#editModal [name=fare]').prop('disabled', false);
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
		url: "<?php echo $url_of_api; ?>",
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
		type = $('#addModal [name=origin]').attr('type');
	if(type != 'checkbox' && type != 'radio'){
	$('#addModal [name=origin]').val("");
	}
		type = $('#addModal [name=destination]').attr('type');
	if(type != 'checkbox' && type != 'radio'){
	$('#addModal [name=destination]').val("");
	}
		type = $('#addModal [name=departure_date]').attr('type');
	if(type != 'checkbox' && type != 'radio'){
	$('#addModal [name=departure_date]').val("");
	}
		type = $('#addModal [name=departure_time]').attr('type');
	if(type != 'checkbox' && type != 'radio'){
	$('#addModal [name=departure_time]').val("");
	}
		type = $('#addModal [name=arrival_date]').attr('type');
	if(type != 'checkbox' && type != 'radio'){
	$('#addModal [name=arrival_date]').val("");
	}
		type = $('#addModal [name=arrival_time]').attr('type');
	if(type != 'checkbox' && type != 'radio'){
	$('#addModal [name=arrival_time]').val("");
	}
		type = $('#addModal [name=fare]').attr('type');
	if(type != 'checkbox' && type != 'radio'){
	$('#addModal [name=fare]').val("");
	}
	}

function addNew(){
	formData = $("#addModal form").serializeArray();
	$.ajax({
		type: 'POST',
		url: "<?php echo $url_of_api; ?>",
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
		url: "<?php echo $url_of_api; ?>",
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

<!-- Origin -->
<div class="form-group">
<label>Origin</label>
<input class="form-control" type="text" name="origin" placeholder="Origin">
</div>


<!-- Destination -->
<div class="form-group">
<label>Destination</label>
<input class="form-control" type="text" name="destination" placeholder="Destination">
</div>


<!-- Departure Date -->
<div class="form-group">
<label>Departure Date</label>
<input class="form-control" type="text" name="departure_date" placeholder="Departure Date">
</div>


<!-- Departure Time -->
<div class="form-group">
<label>Departure Time</label>
<input class="form-control" type="text" name="departure_time" placeholder="Departure Time">
</div>


<!-- Arrival Date -->
<div class="form-group">
<label>Arrival Date</label>
<input class="form-control" type="text" name="arrival_date" placeholder="Arrival Date">
</div>


<!-- Arrival Time -->
<div class="form-group">
<label>Arrival Time</label>
<input class="form-control" type="text" name="arrival_time" placeholder="Arrival Time">
</div>


<!-- Fare -->
<div class="form-group">
<label>Fare</label>
<input class="form-control" type="text" name="fare" placeholder="Fare">
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

<!-- Origin -->
<div class="form-group">
<label>Origin</label>
<input class="form-control" type="text" name="origin" placeholder="Origin">
</div>


<!-- Destination -->
<div class="form-group">
<label>Destination</label>
<input class="form-control" type="text" name="destination" placeholder="Destination">
</div>


<!-- Departure Date -->
<div class="form-group">
<label>Departure Date</label>
<input class="form-control" type="date" name="departure_date" placeholder="Departure Date">
</div>


<!-- Departure Time -->
<div class="form-group">
<label>Departure Time</label>
<input class="form-control" type="time" name="departure_time" placeholder="Departure Time">
</div>


<!-- Arrival Date -->
<div class="form-group">
<label>Arrival Date</label>
<input class="form-control" type="date" name="arrival_date" placeholder="Arrival Date">
</div>


<!-- Arrival Time -->
<div class="form-group">
<label>Arrival Time</label>
<input class="form-control" type="time" name="arrival_time" placeholder="Arrival Time">
</div>


<!-- Fare -->
<div class="form-group">
<label>Fare</label>
<input class="form-control" type="text" name="fare" placeholder="Fare">
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

<div id="toast" class="toast" role="toast" aria-live="assertive" aria-atomic="true" data-delay="5000" style=" background: white !important; padding: 5px; border-radius: 10px; position: fixed; bottom: 10px; right: 10px; min-width: 200px;">
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