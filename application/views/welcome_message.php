<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CRUD BPJS with DataTable and API</title>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<style>
		.container {
			margin-top: 20px;
		}

		.modal-body {
			padding: 20px;
		}
	</style>
</head>

<body>

	<div class="container">
		<h2 class="text-center">CRUD BPJS</h2>
		<div class="row mb-3">
			<div class="col-md-3">
				<label for="searchCriteria">Search By</label>
				<select class="form-control" id="searchCriteria">
					<option value="search">--All--</option>
					<option value="nik">NIK</option>
					<option value="kpj">KPJ</option>
					<option value="first_name">First Name</option>
					<option value="last_name">Last Name</option>
					<option value="phone_number">Phone Number</option>
				</select>
			</div>
			<div class="col-md-3">
				<label for="searchQuery">Search Query</label>
				<input type="text" class="form-control" id="searchQuery" placeholder="Enter search term">
			</div>
			<div class="col-md-6">
				<button class="btn btn-primary mt-4" data-toggle="modal" id="searchBtn">Search</button>
			</div>
			<div class="col-md-6">
				<button class="btn btn-primary mt-4" data-toggle="modal" data-target="#addModal">Add New Participant</button>
			</div>
		</div>

		<table id="dataTable" class="table table-striped table-bordered mt-3">
			<thead>
				<tr>
					<th>NIK</th>
					<th>KPJ</th>
					<th>NAMA DEPAN</th>
					<th>NAMA BELAKANG</th>
					<th>NOMOR TELEPON</th>
					<th>EMAIL</th>
					<th>TEMPAT LAHIR</th>
					<th>TANGGAL LAHIR</th>
					<th>ALAMAT</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>

	<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addModalLabel">Add New Participant</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="participantForm">
						<div class="form-group">
							<label for="nik">NIK</label>
							<input type="text" class="form-control" id="nik" required>
							<span id="nik-error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="kpj">KPJ</label>
							<input type="text" class="form-control" id="kpj" required>
							<span id="kpj-error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="first_name">Nama Depan</label>
							<input type="text" class="form-control" id="first_name" required>
							<span id="first_name-error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="last_name">Nama Belakang</label>
							<input type="text" class="form-control" id="last_name">
							<span id="last_name-error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="phone_number">Nomor Telepon</label>
							<input type="text" class="form-control" id="phone_number" required>
							<span id="phone_number-error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" class="form-control" id="email">
							<span id="email-error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="birth_place">Tempat Lahir</label>
							<input type="text" class="form-control" id="birth_place" required>
							<span id="birth_place-error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="birth_date">Tanggal Lahir</label>
							<input type="date" class="form-control" id="birth_date" required>
							<span id="birth_date-error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="address">Alamat</label>
							<input type="text" class="form-control" id="address" required>
							<span id="address-error" class="text-danger"></span>
						</div>
						<button type="submit" class="btn btn-success">Add Participant</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editModalLabel">Edit Participant</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="editParticipantForm">
						<div class="form-group">
							<label for="kpj">KPJ</label>
							<input type="text" class="form-control" id="edit_kpj" required>
							<span id="edit_kpj-error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="first_name">Nama Depan</label>
							<input type="text" class="form-control" id="edit_first_name" required>
							<span id="edit_first_name-error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="last_name">Nama Belakang</label>
							<input type="text" class="form-control" id="edit_last_name">
							<span id="edit_last_name-error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="phone_number">Nomor Telepon</label>
							<input type="text" class="form-control" id="edit_phone_number" required>
							<span id="edit_phone_number-error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" class="form-control" id="edit_email">
							<span id="edit_email-error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="birth_place">Tempat Lahir</label>
							<input type="text" class="form-control" id="edit_birth_place" required>
							<span id="edit_birth_place-error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="birth_date">Tanggal Lahir</label>
							<input type="date" class="form-control" id="edit_birth_date" required>
							<span id="edit_birth_date-error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="address">Alamat</label>
							<input type="text" class="form-control" id="edit_address" required>
							<span id="edit_address-error" class="text-danger"></span>
						</div>
						<button type="submit" class="btn btn-warning">Update Participant</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

	<script>
		const apiUrl = "http://localhost/bpjs/api/bpjs";
		$(document).ajaxError(function(event, xhr, settings, thrownError) {
			console.error("Terjadi kesalahan saat memproses permintaan AJAX:");
			console.log("URL:", settings.url);
			console.log("Status:", xhr.status);
			console.log("Status Text:", xhr.statusText);
			console.log("Pesan Error:", xhr.responseText);
			resp = JSON.parse(xhr.responseText);
			if(resp.code == 401 && resp.message == 'Token Expired') {
				// localStorage.removeItem('jwt_token');
				alert(resp.message);
                window.location.href = "/bpjs/login";
			}
		});

		$(document).ready(function() {
			var table = $('#dataTable').DataTable();

			function loadParticipants(searchCriteria = '', searchQuery = '') {
				$.ajax({
					url: apiUrl,
					method: 'GET',
					headers: {
						'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
					},
					data: {
						search_criteria: searchCriteria,
						search_query: searchQuery
					},
					success: function(response) {
						table.clear();
						response.data.result.raw_data.forEach(function(participant) {
							table.row.add([
								participant.nik,
								participant.kpj,
								participant.first_name,
								participant.last_name,
								participant.phone_number,
								participant.email,
								participant.birth_place,
								participant.birth_date,
								participant.address,
								`<button class="btn btn-warning btn-sm editBtn" data-id="${participant.nik}">Edit</button> 
                             <button class="btn btn-danger btn-sm deleteBtn" data-id="${participant.nik}">Delete</button>`
							]).draw(false);
						});
					},
					error: function(res) {
						console.log(res);
						table.clear().draw();
					}
				});
			}



			$('#searchBtn').on('click', function() {
				var searchCriteria = $('#searchCriteria').val();
				var searchQuery = $('#searchQuery').val();
				loadParticipants(searchCriteria, searchQuery);
			});

			loadParticipants();

			$('#participantForm').on('submit', function(e) {
				e.preventDefault();

				var nik = $('#nik').val();
				var kpj = $('#kpj').val();
				var first_name = $('#first_name').val();
				var last_name = $('#last_name').val();
				var phone_number = $('#phone_number').val();
				var email = $('#email').val();
				var birth_date = $('#birth_date').val();
				var birth_place = $('#birth_place').val();
				var address = $('#address').val();

				$.ajax({
					url: apiUrl + '/create',
					method: 'POST',
					headers: {
						'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
					},
					data: {
						nik: nik,
						kpj: kpj,
						first_name: first_name,
						last_name: last_name,
						phone_number: phone_number,
						email: email,
						birth_date: birth_date,
						birth_place: birth_place,
						address: address
					},
					success: function(response) {
						console.log(response);
						loadParticipants();
						$('#participantForm')[0].reset();
						$('#addModal').modal('hide');
						$('.text-danger').text('');
					},
					error: function(res) {
						res_code = res.responseJSON.code;
						res_message = res.responseJSON.message;
						res_data = res.responseJSON.data;
						if (res_code == 400 && res_message == "Validation Error") {
							alert('Failed to add participant');
							$('.text-danger').text('');
							$.each(res_data, function(index, message) {
								document.getElementById(`${index}-error`).textContent = message;
							})
						}
						console.log(res.responseJSON);
					}
				});
			});

			$('#dataTable tbody').on('click', '.editBtn', function() {
				var participantId = $(this).data('id');

				$.ajax({
					url: apiUrl + '/view/' + participantId,
					method: 'GET',
					headers: {
						'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
					},
					success: function(response) {
						var participant = response.data;
						$('#edit_kpj').val(participant.kpj);
						$('#edit_first_name').val(participant.first_name);
						$('#edit_last_name').val(participant.last_name);
						$('#edit_phone_number').val(participant.phone_number);
						$('#edit_email').val(participant.email);
						$('#edit_birth_date').val(participant.birth_date);
						$('#edit_birth_place').val(participant.birth_place);
						$('#edit_address').val(participant.address);
						$('#editModal').modal('show');

						$('#editParticipantForm').on('submit', function(e) {
							e.preventDefault();

							var kpj = $('#edit_kpj').val();
							var first_name = $('#edit_first_name').val();
							var last_name = $('#edit_last_name').val();
							var phone_number = $('#edit_phone_number').val();
							var email = $('#edit_email').val();
							var birth_date = $('#edit_birth_date').val();
							var birth_place = $('#edit_birth_place').val();
							var address = $('#edit_address').val();

							$.ajax({
								url: apiUrl + '/update/' + participantId,
								method: 'PUT',
								headers: {
									'Authorization': 'Bearer ' + localStorage.getItem('jwt_token'),
									'Content-Type': 'application/json'
								},
								data: JSON.stringify({
									kpj: kpj,
									first_name: first_name,
									last_name: last_name,
									phone_number: phone_number,
									email: email,
									birth_date: birth_date,
									birth_place: birth_place,
									address: address
								}),
								success: function(response) {
									loadParticipants();
									$('#editModal').modal('hide');
								},
								error: function(res) {
									res_code = res.responseJSON.code;
									res_message = res.responseJSON.message;
									res_data = res.responseJSON.data;
									if (res_code == 400 && res_message == "Validation Error") {
										alert('Failed to add participant');
										$('.text-danger').text('');
										$.each(res_data, function(index, message) {
											document.getElementById(`edit_${index}-error`).textContent = message;
										})
									}
									console.log(res.responseJSON);
								}
							});
						});
					},
					error: function() {
						alert('Failed to load participant details');
					}
				});
			});

			$('#dataTable tbody').on('click', '.deleteBtn', function() {
				var participantId = $(this).data('id');

				$.ajax({
					url: apiUrl + '/delete/' + participantId,
					method: 'DELETE',
					headers: {
						'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
					},
					success: function(response) {
						loadParticipants();
					},
					error: function() {
						alert('Failed to delete participant');
					}
				});
			});
		});
	</script>

</body>

</html>
