<?php
	require_once 'db.php';
	$conn = dbConnect();

	$search = isset($_GET['search']) ? $_GET['search'] : "";

	// Create the query
	$collection = $conn->tfg1->sistemas;
	
	$regex = new MongoRegex("/".$search."/i");
	$where = array("hostname" => $regex);

	$page  = isset($_GET['page']) ? (int) $_GET['page'] : 1;	
	$limit = 10;
	$skip  = ($page - 1) * $limit;	

	$cursor = $collection->find($where)->skip($skip)->limit($limit);

	$total = $cursor->count();

	$pages = ceil($total / $limit);
	
	$next  = ($page + 1) > $pages ? $pages : ($page + 1);
	$prev  = ($page - 1) < 1 ? 1 : ($page - 1);

	// Si no hay registros..
	if(empty($cursor)) {
		echo '<tr>';
		echo '<td colspan="3">No hay registros</td>';
		echo '</tr>';
	}
	else {
		foreach ($cursor as $id => $value) {
			echo '<tr>';
			echo '<td>'. $id . '</td>';
			echo '<td>'. json_encode($value, JSON_PARTIAL_OUTPUT_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE, 1) . '</td>';
			echo '<td>';
			echo '<a class="btn" href="read.php?id='.$id.'&search='.$search.'">Leer</a>';
			echo '&nbsp;';
			echo '<a class="btn btn-success" href="update.php?id='.$id.'&search='.$search.'">Modificar</a>';
			echo '&nbsp;';
			echo '<a class="btn btn-danger" href="delete.php?id='.$id.'&search='.$search.'">Borrar</a>';
			echo '</td>';
			echo '</tr>';
		}
		echo '<tr>';
		echo '<td colspan="3">';
		echo '<table border="0" cellspacing="0" cellpadding="0" width="100%">';
		echo '<tr>';
		echo '<td style="border-top:none">';
		echo '<strong>Mostrando del ' . ($skip + 1) . ' al ' . (($page * $limit) > $total ? $total : $page * $limit) . ' de ' . $total . ' total objetos</strong>';
		echo '</td>';		
		echo '<td style="border-top:none; text-align:right">';
		// Boton primero
		echo '<a class="btn" href="?page=1">Primer Página</a>';
		// Boton previo
		echo ' <a class="btn ' . (($page <= 1) ? 'disabled' : '') . '" href="?page=' . $prev . '">Previa</a>';
		// Botones paginas
		for ($i = 1; $i <= $pages; $i++) {
			echo ' <a class="btn ' . (($i == $page) ? 'active' : '') . '" href="?page=' . $i . '">' . $i . '</a>';
		}
		// Boton siguiente
		echo ' <a class="btn ' . (($page == $pages) ? 'disabled' : '') . '" href="?page=' . $next . '">Próxima</a>';		
		// Boton ultimo
		echo ' <a class="btn ' . (($page == $pages) ? 'disabled' : '') . '" href="?page=' . $pages . '">Última Página</a>';
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		echo '</td>';
		echo '</tr>';
	}
?>