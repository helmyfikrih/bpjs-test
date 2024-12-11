<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login BPJS</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.container {
			max-width: 400px;
			margin-top: 50px;
		}

		.form-group {
			margin-bottom: 15px;
		}
	</style>
</head>

<body>

	<div class="container">
		<h2 class="text-center">Login BPJS</h2>
		<form id="loginForm">
			<div class="form-group">
				<label for="email">Username</label>
				<input type="text" class="form-control" id="username" required>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" required>
			</div>
			<button type="submit" class="btn btn-primary btn-block">Login</button>
		</form>
		<div id="errorMessage" class="alert alert-danger mt-3" style="display: none;"></div>
	</div>

	<!-- Include jQuery, Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

	<script>
		const apiUrl = "http://localhost/bpjs/index.php/api/auth/login"; // Update with your API URL

		$(document).ready(function() {
			$('#loginForm').on('submit', function(e) {
				e.preventDefault();

				// Get email and password values
				const username = $('#username').val();
				const password = $('#password').val();

				// Send login request to API
				$.ajax({
					url: apiUrl,
					method: 'POST',
					data: {
						username: username,
						password: password
					},
					success: function(response) {
						// If login is successful, store the JWT token in localStorage
						
						if (response.code  == 200 && response.data.token) {
							console.log(response.data.token);
							localStorage.setItem('jwt_token', response.data.token);
							alert('Login successful! Token saved in localStorage.');
							// Redirect to dashboard or home page
							window.location.href = '/bpjs/index.php'; // Change this to your main page
						}
					},
					error: function() {
						$('#errorMessage').text('Invalid credentials. Please try again.').show();
					}
				});
			});
		});
	</script>

</body>

</html>
