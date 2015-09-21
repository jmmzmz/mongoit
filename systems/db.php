<?php
function dbConnect (){
 
    $conn = new MongoClient('mongodb://localhost:27017');
	return $conn; 
 }

 ?>