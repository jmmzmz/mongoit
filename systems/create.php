<?php
	if (isset($_POST['json']) && $_POST['json'] != "") {	
		$valid = false;
		$jsondata = $_POST['json'];
		$json_decoded = json_decode($jsondata);
		if (isset($json_decoded)){
			$valid = true;
		}
				
		require_once 'db.php'; 
		$conn = dbConnect();
		if ($valid) {
			$collection = $conn->tfg1->sistemas;
			$collection->insert($json_decoded, array('upsert' => true) );
			header("Location: index.php");
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<script src="../js/bootstrap.min.js"></script>
	<link rel="icon" href="../img/favicon.ico" type="image/x-icon">
</head>
<body>
	<div class="container-fluid">
		<div class="row-fluid">
			<h3>Crear Sistema</h3>
		</div>

		<form class="form-horizontal" action="create.php" method="post" id="update">					  
			<div class="form-group">
				<label for="json">Data</label>
				<div class="col-md-8" >
					<textarea class="row-fluid" rows="10" name="json" form="update"><?php echo (isset($_POST['json']) && $_POST['json'] != "") ? $_POST['json'] : ""; ?></textarea>
					<?php if (isset($_POST['json']) && $_POST['json'] != "" && !$valid){ ?>
						<div class="alert alert-danger" role="alert" style="margin-top:10px"><strong>Error!</strong> Error de validación de JSON</div>
					<?php } ?>
				</div>
			</div>

			<div class="form-actions">
				<button type="submit" class="btn btn-success">Insertar</button>
				<a class="btn" href="index.php">Volver</a>
			</div>
		</form>
	</div>	
  </body>
</html>