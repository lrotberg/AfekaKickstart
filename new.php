<?php
	session_start();
	if (isset($_SESSION['id'])) {
		$rightSide = '<h6 class="navbar-nav text-white" style="font-size: 1.3em;">Hello '.$_SESSION['un'].'!</h6><a class="nav-link text-light" href="#" id="logout">Logout</a>';
		// <button class="btn btn-link text-light" id="logout">Logout</button>';
	}
	else {
		$_SESSION['un'] = 'Guest';
		$rightSide = '<div class="nav-item dropdown">
		                <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                    Login
		                </a>
		                <div class="dropdown-menu bg-success" aria-labelledby="navbarDropdown">
		                	<form id="login-form">
			                	<label class="text-white" for="loginUserName" style="margin-bottom: 0; margin-left: .5rem">User Name</label>
			                    <input class="form-control mr-sm-2 login" name="loginUserName" type="text" placeholder="">
			                    <label class="text-white" for="loginPassword" style="margin-bottom: 0; margin-left: .5rem">Password</label>
			                    <input class="form-control mr-sm-2 login" name="loginPassword" type="password" placeholder="">
			                    <input type="submit" class="dropdown-item text-light" value="Login">
			                </form>
			                <div class="dropdown-divider"></div>
			                <a class="dropdown-item text-light" href="/afekakickstart/signup">Sign Up</a>
		                </div>
		            </div>';
	}

    if (isset($_GET['proj'])) {
        $db = mysqli_connect("127.0.0.1", "root", "", "afekakickstart");
        $projName = $_GET['proj'];

        $selectProject = "SELECT *,(SELECT SUM(amount) FROM `donation` WHERE donation.project_id = project.id) as raised FROM `project` where name = '$projName'";
        $data = mysqli_fetch_all(mysqli_query($db,$selectProject),MYSQLI_ASSOC);
        mysqli_close($db);
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <title>Afeka Kickstarter</title>
</head>
<body style="font-family: 'Lato', sans-serif; padding-bottom: 50px;">

<nav class="navbar navbar-expand-lg navbar-light bg-success">
    <div class="container">
        <a class="navbar-brand text-light" href="/afekakickstart" style="font-size: 1.4em; font-weight: 700">Afeka Kickstart</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link text-light" href="/afekakickstart/allprojects">All Projects <span class="sr-only">(current)</span></a>
                </li>
            </ul>

            <?php echo $rightSide; ?>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="projectHeader">Add New Project</h1>
        </div>
    </div>
    <form id="submitProject" style="font-size: 1.3em;">
        <input type="hidden" name="action" value=<?php if (isset($_GET['proj']))echo 'editProject';else echo 'newProject'; ?>>
        <input type="hidden" name="activeName" value=<?php if (isset($_GET['proj']))echo $_GET['proj'];else echo ''; ?>>
        <div class="form-group row">
            <div class="col-4">
                <label for="projectName">Projects Name:</label>
                <input class="form-control" name="projectName" rows="1" placeholder="Enter projects name" value='<?php if (isset($_GET['proj'])) {$p_name = $data[0]['name'];print_r($p_name);}?>'>
            </div>
            <div class="col-4"></div>
            <?php
                echo '<div class="col-4">
                        <label for="projectCreator">Creator:</label>
                        <input type="text" name="projectCreator" readonly class="form-control-plaintext" placeholder="'
                        .$_SESSION['un'].'" style="padding: 0;" value="'.$_SESSION['un'].'">
                         </div>';
            ?>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label for="projectAmount">Amount:</label>
                <input type="number" name="projectAmount" class="form-control" placeholder="Enter amount" value=
                <?php 
                    if (isset($_GET['proj']))
                        echo $data[0]['amount']; 
                ?>
            >
            </div>
            <div class="col-4" style="text-align: center;">
                <label>Start date:</label></br>
                <?php 
                    if (isset($_GET['proj']))
                        echo date_format(date_create($data[0]['start_date']), 'd/m/Y');
                    else
                        echo date('d/m/Y'); 
                ?>
            </div>
            <div class="col-2">
                <label for="endDate">End date:</label>
                <input id="endDate" class="form-control">
                <script>
                    $('#endDate').datepicker({
                        uiLibrary: 'bootstrap4'
                    });
                    var datepicker = $('#endDate').datepicker();
                    //datepicker.value("<?php if (isset($_GET['proj'])) echo $data[0]['end_date']->format('M/d/Y'); ?>");
                </script>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-10">
                <label for="projectPreview">Projects Preview</label>
                <textarea class="form-control" name="projectPreview" rows="3"><?php if (isset($_GET['proj']))echo $data[0]['overview'];?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label for="projectThumb">Projects Thumbnail</label>
                <div class="input-group">
                    <span class="input-group-btn">
                        <span class="btn btn-success" onclick="$(this).parent().find('input[type=file]').click();">Browse</span>
                            <input name="uploaded_file" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                        </span>
                    <span class="form-control"></span>
                </div>
            </div>
            <div class="col-4">
                <label for="projectThumb">Projects Cover</label>
                <div class="input-group">
                    <span class="input-group-btn">
                        <span class="btn btn-success" onclick="$(this).parent().find('input[type=file]').click();">Browse</span>
                            <input name="uploaded_file" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                        </span>
                    <span class="form-control"></span>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col">
                <button class="btn btn-success my-2 my-sm-0" type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript" src="include/script.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/js/mdb.min.js"></script>
</body>
</html>