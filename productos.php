<?php
	define("CANNONICALROOTPATH", "./");
	include "./sessionManagement.php";

	if (isset($_SESSION["dbId"])) {
		include "./cromosuser_header.php";
	} else if (isset($_SESSION["admin"])) {
		include "./cromosadmin_header.php";
	} else {
		include "./cromos_header.php";
	}
?>

<div class="content">
	<div class="vContainerCenteredContents">
		<h1>Productos</h1>
		<div style="padding:15px 0"></div>
		<div class="vContainerCenteredContents">
			<h2>Coleccion 1</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dictum turpis at elit semper, luctus congue ante accumsan. Nullam sed efficitur metus. Pellentesque malesuada turpis sed accumsan lobortis. Sed varius ut velit ac accumsan. Nulla eget elit cursus, imperdiet justo non, feugiat erat. Suspendisse ac bibendum purus. Nulla facilisi. Sed nulla sem, fringilla ultrices nisl a, consequat dictum lacus. Quisque vehicula ullamcorper libero, sed tincidunt metus tincidunt vitae. Proin venenatis mauris quis magna egestas, eget laoreet elit mollis. Aliquam in euismod ex, eu luctus purus.</p>
		</div>
		<div style="padding:20px 0"></div>
		<div class="vContainerCenteredContents">
			<h2>Coleccion 2</h2>
			<p>Suspendisse vestibulum in tortor id mattis. Aliquam rutrum est odio, sed pellentesque dui semper nec. Ut risus sem, vulputate et euismod eget, commodo nec orci. Sed luctus laoreet leo, id ultrices lorem rutrum ac. Nullam libero tellus, commodo ac fermentum id, sagittis at velit. Etiam interdum ipsum sit amet quam blandit maximus. Duis nec consequat est. Cras suscipit ante in diam cursus tempor.</p>
		</div>
		<div style="padding:20px 0"></div>
	</div>
</div>

<?php
	if (isset($_SESSION["dbId"])) {
		include "./cromosuser_footer.php";
	} else if (isset($_SESSION["admin"])) {
		include "./cromosadmin_footer.php";
	} else {
		include "./cromos_footer.php";
	}
?>
