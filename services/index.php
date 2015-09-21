<?php
	$titulo = "MongoDB para TI";
	
	$search = "";
	if (isset($_GET['search'])) {		
		$search = $_GET['search'];
	}
		
	$page  = isset($_GET['page']) ? (int) $_GET['page'] : 1;
	$page = $page < 1 ? 1 : $page;
 ?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8" />
<title><?php echo $titulo;?></title>
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/bootstrap-theme.min.css" rel="stylesheet">
<script src="../js/jquery-1.10.2.js"></script> 
<script src="../js/bootstrap.min.js"></script>
<link rel="icon" href="../img/favicon.ico" type="image/x-icon">
</head>
<body>
<div class="wrapper" style="margin:20px">
  <div class="page-header">
    <h1 class="orangeFont noMargin"><small>Trabajo de Fin de Grado UNIR</small></h1>
    <div class="panel panel-default">
      <div class="panel-body">
        <h3 class="blueFont"><?php echo $titulo;?></h3>
      </div>
    </div>
  </div>
  
   
<ul class="nav nav-pills">
  <li role="presentation"><a href="../systems/index.php">Sistemas</a></li>
  <li role="presentation" class="active"><a href="../services/index.php">Servicios</a></li>
  <li role="presentation"><a href="#">Salida</a></li>
</ul>
  
  
  
  
  
  
  <div class="mainContent">
    <form class="form-horizontal" role="form" method="get">
      <div class="form-group">
        <label for="search" class="col-lg-8 control-label">Consulta:&nbsp;</label>
        <div class="input-group col-lg-12">
          <input id="search" name="search" type="text" class="form-control input-lg" placeholder="Texto" value="<?php echo $search; ?>" />
			 <input id="page" name="page" type="hidden" value="<?php echo $page; ?>" />
          <span class="input-group-btn">
				<button type="button" class="btn btn-default btnSearch">Búsqueda</button>				
          </span> 
			 <div><a href="create.php" class="btn btn-success">Insertar</a></div>
			</div>
      </div>
    </form>
    <div class="col-sm-2"></div>
    <div class="col-sm-8"> 
      <!-- This table is where the data is display. it is fill by jQuery and Ajax, the information is drop into the body tag -->
      <table id="resultTable" class="table table-striped table-hover">
        <thead>
			 <th width="200">Object Id</th>
          <th>JSON DATA</th>
          <th width="250">&nbsp;</th>
            </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript">        
    	jQuery(document).ready(function($) {
			// Let us trigger the search if the user clicks on the search button.
    		$('.btnSearch').click(function(){// Call back function.
    			makeAjaxRequest();// Since this code will be repeated in different place I have place it as a function
    		});
            // Let us trigger the search if the user submit the form by an enter.
            $('form').submit(function(e){
                e.preventDefault(); // This will prevent the submit event to bubble and therefore not firing the event.
                makeAjaxRequest();// Since this code will be repeated in different place I have place it as a function
                return false; // This will tell the function to do nothing.
            });
            /**
             * This function will make the Ajax request using the jQuery $.ajax() function
             * see: http://api.jquery.com/jQuery.ajax/
             * @return void
             */
            function makeAjaxRequest() {
                $.ajax({
                    url: 'search.php', // This is the file where all the stuff with the database will happen.
                    data: {search: $('input#search').val(), page: $('input#page').val()},						  
                    /*
                        A Javascript Object with the information. You can also do it like a query string like this:

                        'search='+$('input#search').val()
                    */
                    type: 'get', // The type of method to be submitted.
						  cache: false,
                    success: function(response) { // Call back function that will execute if the Ajax call was succesful.
                        // Let us fill the table by targetting with the selector 'table#resultTable tbody' and filling it
                        // with the $.html() function. response is the result from the server.
                        $('table#resultTable tbody').html(response);
                    }
                });
            }
				
				makeAjaxRequest();
    	});
    </script>
</body>
</html>