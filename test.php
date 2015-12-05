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
        $("#btnPrint").live("click", function () {
            var divContents = $("#dvContainer").html();
            var printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title>DIV Contents</title>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
    </script>
    <style> 
        th {
            font-weight: normal;
        }

        table, th, td {
            border: 1px solid black;
            width: 75%;
            height: 50%;
            border-collapse: collapse;
            text-align:center;
        }
        td ,th{
            width:25%;
        }
        th {
            height:10%;
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
    </div>
    <input type="button" value="Print Div Contents" id="btnPrint" />
    </form>
</body>
</html>