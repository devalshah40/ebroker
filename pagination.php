<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN”
“http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns=”http://www.w3.org/1999/xhtml”>
<head>
<meta http-equiv=”Content-Type” content=”text/html; charset=iso-8859-1? />
<title>Paginator</title>
<style type=”text/css”>
		.paginate {
		font-family: Arial, Helvetica, sans-serif;
		font-size: .7em;
		}
		a.paginate {
		border: 1px solid #000080;
		padding: 2px 6px 2px 6px;
		text-decoration: none;
		color: #000080;
		}
		a.paginate:hover {
		background-color: #000080;
		color: #FFF;
		text-decoration: underline;
		}
		a.current {
		border: 1px solid #000080;
		font: bold .7em Arial,Helvetica,sans-serif;
		padding: 2px 6px 2px 6px;
		cursor: default;
		background:#000080;
		color: #FFF;
		text-decoration: none;
		}
		span.inactive {
		border: 1px solid #999;
		font-family: Arial, Helvetica, sans-serif;
		font-size: .7em;
		padding: 2px 6px 2px 6px;
		color: #999;
		cursor: default;
		}
</style>
</head>
<body>
<?php
include("paginator.class.php");
include("include/config.php");
$query = "SELECT COUNT(*) FROM clients";
$result = mysql_query($query) or die(mysql_error());
$num_rows = mysql_fetch_row($result);

$pages = new Paginator;
$pages->items_total = $num_rows[0];
$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
$pages->paginate();

echo $pages->display_pages();
echo "<span class=\"\">".$pages->display_jump_menu().$pages->display_items_per_page()."</span>";

$query = "SELECT * FROM `clients` $pages->limit";
$result = mysql_query($query) or die(mysql_error());

echo "<table>
				<tr>
				    <th >NAME</th>
				    <th >ADDRESS</th>
				    <th >YEAR</th>
				    <th>BROKERAGE</th>
				    <th >ACTION</th>
				</tr>";
while($row = mysql_fetch_row($result))
{
	echo "<tr onmouseover=\"hilite(this)\" onmouseout=\"lowlite(this)\"><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td></tr>\n";
}
echo "</table>";

echo $pages->display_pages();
echo "<p class=\"paginate\">Page: $pages->current_page of $pages->num_pages</p>\n";
echo "<p class=\"paginate\">SELECT * FROM table $pages->limit (retrieve records $pages->low-$pages->high from table - $pages->items_total item total / $pages->items_per_page items per page)";
				
				
echo $pages->display_pages(); // Optional call which will display the page numbers after the results.
echo $pages->display_jump_menu(); // Optional – displays the page jump menu
echo $pages->display_items_per_page(); //Optional – displays the items per page menu
?>
</body>
</html>