<?php 
	
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ){	
		header("Location: index.php");
	}
	
	$valid = false;

	if (isset($_POST['json'])) {
	
		$jsondata = $_POST['json'];
		$json_decoded = json_decode($jsondata);
		if (!isset($json_decoded)){ /*valido el JSON */
			$jsonError = 'JSON INVÁLIDO';
			$valid = false;
		}
		// ok
		$valid = true;
	}

	$search = "";	
	if (isset($_GET['search'])) {		
		$search = $_GET['search'];		
	}

	require_once 'db.php'; 
	$conn = dbConnect();
	if ($valid) {
		$collection = $conn->tfg1->servicios;
		$collection->update(array('_id' => new MongoId($id)), $json_decoded, array('upsert' => true) );
		header("Location: index.php" . "?search=" . $search);
	}
	else {
		$collection = $conn->tfg1->servicios;
		$data = $collection->findOne(array('_id' => new MongoId($id)),array('_id' => false) );
    }	
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
	<link   href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
	<link rel="icon" href="../img/favicon.ico" type="image/x-icon">
</head>

<body>
    <div class="container-fluid">
    

    				<div class="row-fluid">
		    			<h3>Actualizar Servicio</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update.php?id=<?php echo $id?>&search=<?php echo $search; ?>" method="post" id="update">
					  <div class="form-group">
					    <label class="col-md-4">Object Id:</label>
					      <div>
						    <label class="form-control"> 	<?php echo $id ;?>  </label>
					      </div>
					  </div>
					  <div class="form-group">
					    <label for="json">Data</label>
					    <div class="col-md-8" >
					      <textarea class="row-fluid" rows="10" name="json" form="update"><?php echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></textarea>
		 			  	    <?php if (!empty($json)): ?>
					      		<span class="help-inline"><?php echo $emailError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					
					  <div class="form-actions">						
						  <button type="submit" class="btn btn-success">Actualizar</button>						  
						  <a class="btn" href="index.php?search=<?php echo $search; ?>">Volver</a>						  
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
	
	
	
	
  </body>
</html>