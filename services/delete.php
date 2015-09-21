<?php 
	require 'database.php';
	$id = 0;
	
	if (!empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	$search = "";	
	if (isset($_GET['search'])) {		
		$search = $_GET['search'];
	}
	if (isset($_POST['search'])) {
		$search = $_POST['search'];
	}		
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['id'];
		
		// delete data
		require_once 'db.php'; 		
		$conn = dbConnect();
		$collection = $conn->tfg1->servicios;
		$collection->remove(array('_id' => new MongoId($id)), array("justOne" => true));
		header("Location: index.php" . "?search=" . $search);
	} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta charset="utf-8">
    <link   href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Eliminar Documento de Servicios</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="delete.php" method="post">
	    			  <input type="hidden" name="id" value="<?php echo $id;?>"/>
					  <input type="hidden" name="search" value="<?php echo $search;?>"/>
					  <p class="alert alert-error">¿Estás seguro de Eliminar el documento: <?php echo $id; ?>?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Sí</button>
						  <a class="btn" href="index.php?search=<?php echo $search; ?>">No</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>