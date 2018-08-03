<?php
	session_start();
	if (isset($_SESSION['id'])) {
		$rightSide = '<h6>Hello '.$_SESSION['un'].'</h6><button btn btn-info id="logout">Logout</button>';
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
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Afeka Kickstarter</title>
</head>
<body style="font-family: 'Lato', sans-serif;">

<nav class="navbar navbar-expand-lg navbar-light bg-success">
    <div class="container">
        <a class="navbar-brand text-light" href="/afekakickstart" style="font-size: 1.4em; font-weight: 700">Afeka Kickstart</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link text-light" href="#">All Projects <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <form class="form-inline my-2 my-lg-0">
                        <button class="btn btn-outline-success my-2 my-sm-0 text-light" type="submit">Search</button>
                        <input class="form-control mr-sm-2" type="search" placeholder="Search Project" aria-label="Search">
                    </form>
                </li>
            </ul>

            <?php echo $rightSide; ?>
        </div>
    </div>
</nav>

<div class="container">
    <header class="jumbotron" style="margin-top: 10px; font-size: 2em; padding-bottom: 0.5rem">
        <div class="container">
            <h1 style="text-align: center;">Welcome to Afeka Kickstarter!</h1>
            <div class="row">
                <div class="col-6" style="padding-left: 0;">
                    <h5>Explore # live projects</h5>
                </div>
                <div class="col-6" style="text-align: right; padding-right: 0;">
                    <h5>Kicked out # projects</h5>
                </div>
            </div>
            <div class="row">
                <p>
                    <a class="btn btn-success btn-lg" href="" style="margin-top: 35px">Add new Project</a>
                </p>
            </div>
        </div>
    </header>

    <div class="row">
    	<?php
    		$db = mysqli_connect("127.0.0.1", "root", "", "afekakickstart");
    		$selectAllProjects = "SELECT *,(SELECT SUM(amount) FROM `donation` WHERE donation.project_id = project.id) as raised FROM `project`";
			$data = mysqli_fetch_all(mysqli_query($db,$selectAllProjects),MYSQLI_ASSOC);
			foreach ($data as $key => $row) {
				echo '<div id="projects" class="md-col-3 sm-col-12">
			            <div class="card" style="width:300px">
			                <a href="/afekakickstart/project?proj='.$row['name'].'">
			                    <img class="card-img-top" src="images/'.$row['id'].'-thumb.jpg" alt="Card image">
			                </a>
			                <div class="card-body">
			                    <h4 class="card-title">'.$row['name'].'</h4>
			                    <h5>'.$row['raised'].' Of '.$row['amount'].' Funded</h5>
			                    <button class="proj btn btn-success" data-name="'.$row['name'].'" data-id="'.$row['id'].'">Donate</button>
			                </div>
			            </div>
			        </div>';
			}
			mysqli_close($db);
    	?>
        
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="donateModal" tabindex="-1" role="dialog" aria-labelledby="donateModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="donateModalLongTitle">Donate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript" src="include/script.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/js/mdb.min.js"></script>
</body>
</html>