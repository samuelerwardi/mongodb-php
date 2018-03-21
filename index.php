<?php
require_once __DIR__ . "/vendor/autoload.php";
// connect
$database = (new MongoDB\Client)->testing;

// list collections
$cursor = $database->command(['listCollections' => 1]);
break_line("list collections");
foreach ($cursor as $collection) {
	// print_data($collection['name']);
}

break_line("list datas");
// search record with regex
$regex = new MongoDB\BSON\Regex ( '^can');
$datas = $database->product->find(["item" => $regex]);

// $datas = $database->product->find();
foreach ($datas as $document) {
   print_data($document->_id);
}
die;
// select a collection (analogous to a relational database's table)
$collection = $database->cartoons;

// add a record
$document = array( "title" => "Calvin and Hobbes", "author" => "Bill Watterson" );
$insert = $collection->insertOne($document);

// add many records
$insertManyResults = $collection->insertMany([
		[
			"title" => "Captain Tsubasa 1",
			"author" => "A"
		],
		[
			"title" => "Captain Tsubasa 2",
			"author" => "A"
		],
				[
			"title" => "Captain Tsubasa 3",
			"author" => "C"
		],
	]);

print_data($insertManyResults);
// print_data($insert);
break_line("find one data");
// find one data
$findOne = $collection->findOne(['title' => 'Calvin and Hobbes']);
// print_data($findOne);

// add another record, with a different "shape"
$document = array( "title" => "XKCD", "online" => true );
$collection->insert($document);



// find everything in the collection
$cursor = $collection->find();
// iterate through the results
foreach ($cursor as $document) {
	print_data($document);
}
die;


function print_data($value='')
{
	echo "<pre>";
	print_r($value);
	echo "</pre>";
}

function break_line($param)
{
	echo "=========================="."<br>";
	echo $param."<br>";
	echo "=========================="."<br>";
}
?>