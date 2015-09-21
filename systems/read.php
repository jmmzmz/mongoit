<?php 
	
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	$search = "";
	if (isset($_GET['search'])) {		
		$search = $_GET['search'];
	}
	
	if ( null==$id ) 
		header("Location: index.php" . "?search=" . $search);

	
	require_once 'db.php'; 
	$conn = dbConnect();	
	$collection = $conn->tfg1->sistemas;
	$data = $collection->findOne(array('_id' => new MongoId($id)),array('_id' => false) );
	
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
		    			<h3>Consultar Sistema</h3>
		    		</div>
    		

					  <div class="form-group">
					    <label class="col-md-4">Object Id:</label>
					      <div>
						    <label class="form-control"> 	<?php echo $id ;?>  </label>
					      </div>
					  </div>
					  <div class="form-group">
					    <label for="json">Data</label>
					    <div class="col-md-8" >
					      <label class="row-fluid" rows="10"><?php echo '<pre>'.json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ).'</pre>'; ?></textarea>
		 			  	    <?php if (!empty($json)): ?>
					      		<span class="help-inline"><?php echo $emailError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					
					  <div class="form-actions">
			  
						  <a class="btn" href="index.php?search=<?php echo $search; ?>">Volver</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
	
	
	
	
  </body>
</html>