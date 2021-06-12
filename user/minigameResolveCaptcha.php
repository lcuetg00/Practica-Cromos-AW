<?php
	define("CANNONICALROOTPATH", "./../");
	include "../sessionManagement.php";
	if (!isset($_SESSION["user"]) ||
			isset($_SESSION["admin"])) {
		header("location: ../index.php");
		exit();
	}

	include "../cromosuser_header.php";


	$msg = '';

	// If user has given a captcha!
	if (isset($_POST['input']) && sizeof($_POST['input']) > 0)

	    // If the captcha is valid
	    if ($_POST['input'] == $_SESSION['captcha'])
	        $msg = '<span style="color:green">SUCCESSFUL!!!</span>';
	    else
	        $msg = '<span style="color:red">CAPTCHA FAILED!!!</span>';
?>

    <h2>Resuelve el captcha</h2>

    <div style='margin:15px'>
        <img src="./captchaGenerator/captcha.php">
    </div>

    <form method="POST" action=
            " <?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" name="input"/>
        <input type="hidden" name="flag" value="1"/>
        <input type="submit" value="Submit" name="submit"/>
    </form>

    <div style='margin-bottom:5px'>
        <?php echo $msg; ?>
    </div>

<?php
	include "../cromosuser_footer.php";
?>
