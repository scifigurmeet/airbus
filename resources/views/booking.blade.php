@include('header')
	<?php $url_of_api = "http://localhost/airbus/api.php"; ?>
<div class="row">
	<div class="col col-md-12">
		<h3>Flight Details</h3><br>
		<div class="row" style="background: white; border-radius: 20px; padding: 20px;">
		<div class="col col-md-4">
		<img src="images/air_india_logo.png">
		</div>
		<div class="col col-md-8">
		<div>
		FROM <b style="font-size: 120%;" id="from"></b> TO <b style="font-size: 120%;" id="to"></b><br>
		Departure TIME <b style="font-size: 120%;" id="time1"></b><br>
		Expected Destination Arrival TIME <b style="font-size: 120%;" id="time2"></b><br>
		CLASS <b style="font-size: 120%;" id="class"><?php echo $_GET['class']; ?></b>
		</div>
		</div>
		</div>
		<br>
		<form id="dataForm">
		<input type="hidden" name="flight_id" value="<?php echo $_GET['id']; ?>">
		<input type="email" name="email" style="width: 400px; display: inline-block;" class="form-control" placeholder="Contact Email">
		<input type="text" name="phone" style="width: 400px; display: inline-block;" class="form-control" placeholder="Contact Phone">
		<input type="hidden" id="pp" name="pp" value="0">
		<input type="hidden" id="str" name="str" value="">
		</form><br>
		<h3>Add Passenger(s) Details</h3><br>
			<table class="table table-hover">
				<tbody id="fields">
				</tbody>
			</table>
			<center><br>
			<div class="btn btn-info" onclick="addNew();">Add A Passenger <i class="fa fa-plus"></i></div><br><br>
			<div class="alert alert-success" style="display: inline-block; font-size: 250%;"><b>₹ <span id="price">0</span></b></div><br>
			<button class="btn btn-success" name="submit" onclick="addTransaction();">Proceed To Payement <i class="fa fa-inr"></i></button>
			</center>
	</div>
</div>
<script>

function addTransaction(){
	formData = $("#dataForm").serializeArray();
	$.ajax({
		type: 'POST',
		url: "<?php echo $url_of_api; ?>",
		data: formData,
		success: function(response){
			$('#dataTable').DataTable().ajax.reload();
				alert('Transaction is Successful. You have booked your ticket successfully.');
				window.location.replace("transactions");
			}
	});
	$('#addModal').modal('hide');
}

$(document).ready(function(){
	getFlight(<?php echo $_GET['id']?>);
});
	//Initial Count
	function addNew(){
		row = '<tr class="fieldROW">'+
			'<td class="fieldCount"></td>'+
			'<td><input type="text" class="form-control fieldName" name="field_name" placeholder="Passenger Name"></td>'+
			'<td>'+
				'<select onchange="countify();" name="field_type" class="form-control fieldType">'+
					'<option value="adult">Adult</option>'+
					'<option value="infant">Infant</option>'+
					'<option value="children">Children</option>'+
				'</select>'+
			'</td>'+
			'<td><select class="form-control" name="gender"><option value="MALE">MALE</option><option value="FEMALE">FEMALE</option><option value="OTHERS">OTHERS</option></select></td>'+
			'<td><button class="btn btn-danger" onclick="$(this).parent().parent().remove();countify();">Delete <i class="fa fa-trash"></i></button></td>'+
		'</tr>';
		$('#fields').append(row);
		countify();
	}
	function countify(){
		i = 1;
		price = 0;
		str = "";
		$('.fieldROW').each(function(index,row){
			$(row).attr("id","row"+i);
			$("#row" + i + " .fieldCount").attr("id","field_"+i);
			$("#row" + i + " .fieldCount").text(i);
			$("#row" + i + " .fieldName").attr("id","field_name_"+i);
			$("#row" + i + " .fieldName").attr("name","field_name_"+i);
			$("#row" + i + " .fieldType").attr("id","field_type_"+i);
			$("#row" + i + " .fieldType").attr("name","field_type_"+i);
			$("#row" + i + " .fieldOptions").attr("id","field_options_"+i);
			$("#row" + i + " .fieldOptions").attr("name","field_options_"+i);
			if($("#row" + i + " .fieldType").val() == "adult"){
				price += parseInt(fare);
			} 
			else if($("#row" + i + " .fieldType").val() == "children"){
				price += parseInt(fare*0.5);
			}
			i++;
			str = $("#row" + i + " .fieldName").val() + " " + $("#row" + i + " .fieldType") + " " + $("#row" + i + " .fieldOptions") + "\n";
		});
		$('#price').text(price);
		$('#pp').val(price);
		$('#str').val(str);
	}
	function getFlight(id){
	$.ajax({
		type: 'GET',
		url: "<?php echo $url_of_api; ?>",
		data: {id: id},
		success: function(response){
			response = response[0];
			$('#from').text(response.origin);
			$('#to').text(response.destination);
			$('#time1').text(response.departure_time);
			$('#time2').text(response.arrival_time);
			fareClass = "<?php echo $_GET['class']; ?>";
					if(fareClass == "Economy"){fare = response.economy_fare}
					else if(fareClass == "Premium Economy"){fare = response.premium_economy_fare}
					else {fare = response.business_fare}
			}
	});
}
</script>
@include('footer')