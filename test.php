<?php
include_once("connection.php");
include_once("function.php");
include_once("stickerfunctions.php");

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title> print stickersheets</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
function myFunction() {
    window.print();
}
    </script>
    <style>
        html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, caption {
    margin: 0;
    padding: 0;
    border: 0;
    outline: 0;
    font-size: 100%;
    vertical-align: baseline;
    background: transparent;
} 
        th {
            font-weight: normal;
        }

        table, th, td {
            width: 75%;
            border-collapse: collapse;
            text-align:center;
        }
        td ,th{
            width:25%;
        }
        th {
            height:5%;
             border: 1px solid black;
        }
        @page {
            size: 9.5in 11in;
        }
        table {
            height: 4in;
            page-break-inside: avoid;
             border: 1px solid black;
        }
        td {
            border-bottom:0 none;
            border-right:1px solid black;
        }
@media print
{
  table { page-break-after:auto }
  tr    { page-break-inside:avoid; page-break-after:auto }
  td    { page-break-inside:avoid; page-break-after:auto }
  thead { display:table-header-group }
  tfoot { display:table-footer-group }
}
    </style>
</head>
<body>
    <form id="form1">
    <div id="dvContainer">
        <?php
		$classesQuery = $db_stickers->query("SELECT * FROM offerings ORDER BY classname ASC");
        $classesResult = array();
        while($class = $classesQuery->fetch_assoc()) {
            array_push($classesResult, $class);
        }
        foreach($classesResult as $sub) {
            echo "<br>";
            $blackstickers = getstudents($sub["classid"],"blackstickers");
            $greystickers = getstudents($sub["classid"],"greystickers");
            $whitestickers = getstudents($sub["classid"],"whitestickers");
        
            $blackstickers = explode(",", $blackstickers[0]);
            $greystickers = explode(",", $greystickers[0]);
            $whitestickers = explode(",", $whitestickers[0]);
        
            $highestVal = max(count($blackstickers), count ($greystickers), count($whitestickers));
            
	?>	<table name= <?php echo $sub["classid"] ?> align="center">
			<caption > <b> <?php echo $sub["classname"] ?> </b> </caption>
			<colgroup>
				<col class='blackstickers'>
				<col class='greystickers'>
				<col class='whitestickers'>
			</colgroup>
			<tr>
				<th class='black'>Black</th>
				<th class='grey'>Grey</th>
				<th class='white'>White</th>
			</tr>
			<?php 
			for ($i = 0; $i < $highestVal; $i++) {
			?>
			<tr>
				<td class="stickercell"> <?php if (!empty($blackstickers[$i])) echo "<div class='blackstickers'>" . idToName($blackstickers[$i]) . "</div>"; ?> </td>
				<td class="stickercell"> <?php if (!empty($greystickers[$i]))  echo "<div class='greystickers'>" . idToName($greystickers[$i]) . "</div>";  ?> </td>
				<td class="stickercell"> <?php if (!empty($whitestickers[$i])) echo "<div class='whitestickers'>" . idToName($whitestickers[$i]) . "</div>"; ?> </td> 
			</tr>
			<?php
			}
        }
			?>
		 </table>
         <br />
    </div>
    <button onclick="myFunction()">Print this page</button>
    </form>
</body>
</html>