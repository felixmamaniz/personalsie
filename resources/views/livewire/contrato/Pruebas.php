<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JS</title>
    <style>
        #img{
            display: none;
        }
    </style>
</head>
<body>

	
	<div class="form-check">
	  <input class="form-check-input" onclick="mostrar();" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
	  <label class="form-check-label" for="flexRadioDefault1">
		Mostrar
		</label>
	</div>
	<div class="form-check">
		<input class="form-check-input" onclick="ocultar();" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
		<label class="form-check-label" for="flexRadioDefault2">
		Ocultar
		</label>
	</div>
	<br>
    <div id="img">
       <button type="button" class="btn btn-warning">Seleccionar Accion</button>
    </div>
	
	<br>
	<form  id="ben" hidden>
		  <div class="mb-3">
			<label for="exampleInputEmail1" class="form-label">Email address</label>
			<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
			<div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
		  </div>
		  <div class="mb-3">
			<label for="exampleInputPassword1" class="form-label">Password</label>
			<input type="password" class="form-control" id="exampleInputPassword1">
		  </div>
		  <div class="mb-3 form-check">
			<input type="checkbox" class="form-check-input" id="exampleCheck1">
			<label class="form-check-label" for="exampleCheck1">Check me out</label>
		  </div>
		  <button type="submit" class="btn btn-primary">Submit</button>
	</form>


    <script>
	
        function mostrar(){
            document.getElementById('img').style.display = 'block';
			document.getElementById('ben').style.display = 'none';
		}
		function ocultar(){
            document.getElementById('img').style.display = 'none';
			document.getElementById('ben').style.display = 'block';
        }
    </script>
</body>
</html>