<?php
    session_start();
    if (isset($_SESSION['id'])) {
        $rightSide = '<h6 class="navbar-nav text-white" style="font-size: 1.3em;">Hello '.$_SESSION['un'].'!</h6><a class="nav-link text-light" href="#" id="logout">Logout</a>';
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
		<?php
            $db = mysqli_connect("127.0.0.1", "root", "", "afekakickstart");
            $projName = $_GET['proj'];

            $selectProject = "SELECT *,(SELECT SUM(amount) FROM `donation` WHERE donation.project_id = project.id) as raised FROM `project` where name = '$projName'";

            $data = mysqli_fetch_all(mysqli_query($db,$selectProject),MYSQLI_ASSOC);
            $start_date = date_create($data[0]['start_date']);
            $end_date = date_create($data[0]['end_date']);
            $status;
            if ($data[0]['active'] == 1)
                $status = "Active";
            else
                $status = "Not Active";

			echo '<img class="projectImage" src="images/'.$data[0]['id'].'.jpg"" style="margin-top: 10px;">';

            if (empty($data[0]['raised']))
                $data[0]['raised'] = 0;

            echo '<div class="row">
                    <div class="col-6">
                        <h1 class="projectHeader">'.$data[0]['name'].'</h1>
                        <h3>'.$data[0]['creator'].'</h2>
                    </div>
                    <div class="col-6">
                        <h4 style="padding-top: 5px:">Project start: '.date_format($start_date, "d/m/Y").'</br>Project End: '.date_format($end_date, "d/m/Y").' at '.date_format($end_date, "H:i").'</h4>
                        <div style="font-size: 1.2em;">Status: '.$status.'</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8"><div class="project-overview">'.$data[0]['overview'].'</div></div>
                    <div class="col-4"><h4>'.$data[0]['raised'].' raised out of '.$data[0]['amount'].'</h4></div>
                </div>
                <div class="row">
                    <div class="col-12">';
                    if ($data[0]['creator'] === $_SESSION['un'] || $_SESSION['type'] == 3)
                        echo '<a href="new.php?proj='.$_GET['proj'].'" class="proj btn btn-success">Edit</a>';
                    else
                        echo '<button class="proj btn btn-success" data-name="'.$data[0]['name'].'" data-id="'.$data[0]['id'].'">Donate</button>';
                   echo ' </div>
                </div>';
            mysqli_close($db);
		?>
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
</body>
</html>