<?php
#------------------------------------------------------------------------------------------------------------

require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://@localhost:27017/");
$db = $client->stockBase;
$collection = $db->Stocks;

#declares $client as MongoDB server client	|	$db as stockBase database	|	$collection as collection Stocks

$result = $collection->find( [] );
if (!isset($_GET['sor']))
{
	$result=$collection->find([]);
}
if (isset($_GET['sor']))
{
	if ($_GET['sor'] == '_id')
	{
		$result=$collection->find([],['sort'=>['_id'=>1]]);
	}
	elseif ($_GET['sor'] == 'Symbol')
	{
		$result=$collection->find([],['sort'=>['Symbol'=>1]]);
	}
	elseif ($_GET['sor'] == 'Name')
	{
		$result=$collection->find([],['sort'=>['Name'=>1]]);
	}
	elseif ($_GET['sor'] == 'Price')
	{
		$result=$collection->find([],['sort'=>['Price'=>1]]);
	}
	elseif ($_GET['sor'] == 'Change')
	{
		$result=$collection->find([],['sort'=>['Change'=>1]]);
	}
	elseif ($_GET['sor'] == 'Volume')
	{
		$result=$collection->find([],['sort'=>['Volume'=>1]]);
	}
}
#------------------------------------------------------------------------------------------------------------
echo "<table border='1'>\n";
	#table header
	echo "<thead>\n";
		echo "<tr>\n";
			echo "<th><a href=\"?sor=_id\">Index</a></th><th><a href=\"?sor=Symbol\">Symbol</a></th><th><a href=\"?sor=Name\">Name</a></th><th><a href=\"?sor=Price\">Price(Intraday)</a></th><th><a href=\"?sor=Change\">Change</a></th><th><a href=\"?sor=Volume\">Volume</a></th>";
		echo "</tr>\n";
	echo "</thead>\n";

	# table body
	echo "<tbody>\n";
	foreach ($result as $doc) 
	{
		echo "<tr>\n  ";
		echo "<td>{$doc['_id']}</td>";
		echo "<td>{$doc['Symbol']}</td>";
		echo "<td>{$doc['Name']}</td>";
		echo "<td>{$doc['Price']}</td>";
		echo "<td>{$doc['Change']}</td>";
		echo "<td>{$doc['Volume']}</td>";
		/*foreach ($doc as $key => $value)
		{
			echo "<td>";
			echo "${value}";
			echo "</td>";
		}*/
		echo "\n</tr>\n";
	}
	echo "</tbody>\n";
echo "</table>\n";
?>
