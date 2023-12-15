<?php
include_once('../../../../database/connection.php');
require_once('../../../../models/job.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../dashboard.css">

     
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
		integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="side">
            <div class="h-100">
                <div class="sidebar_logo d-flex align-items-end">

                    <a href="#" class="nav-link text-white-50">Dashboard</a>

                </div>

                <ul class="sidebar_nav">
                    <li class="sidebar_item active" style="width: 100%;">
                        <a href="../dashboard.php" class="sidebar_link"> <img src="../img/1. overview.svg"
                                alt="icon">Overview</a>
                    </li>
                    <li class="sidebar_item">
                        <a href="../candidat.php" class="sidebar_link"> <img src="../img/agents.svg"
                                alt="icon">Candidat</a>
                    </li>
                    <li class="sidebar_item">
                        <a href="../offre.php" class="sidebar_link"> <img src="../img/task.svg" alt="icon">Offre</a>
                    </li>
                    <li class="sidebar_item">
                        <a href="../contact.php" class="sidebar_link"><img src="../img/agent.svg" alt="icon">Contact</a>
                    </li>
                    <li class="sidebar_item">
                        <a href="#" class="sidebar_link"><img src="../img/articles.svg" alt="icon">Articles</a>
                    </li>

                </ul>
                <div class="line"></div>
                <a href="#" class="sidebar_link"><img src="../img/settings.svg" alt="">Settings</a>


            </div>
        </aside>
        <div class="main">
            <nav class="navbar justify-content-space-between pe-4 ps-2">
                <button class="btn open">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar  gap-4">
                    <div class="">
                        <input type="search" class="search " placeholder="Search">
                        <img class="search_icon" src="../img/search.svg" alt="iconicon">
                    </div>
                    <!-- <img src="img/search.svg" alt="icon"> -->
                    <img class="notification" src="../img/new.svg" alt="icon">
                    <div class="card new w-auto">
                        <div class="list-group list-group-light">
                            <div class="list-group-item px-3 d-flex justify-content-between align-items-center ">
                                <p class="mt-auto">Notification</p><a href="#"><img src="../img/settingsno.svg"
                                        alt="icon"></a>
                            </div>
                            <div class="list-group-item px-3 d-flex"><img src="../img/notif.svg" alt="iconimage">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text mb-3">Some quick example text to build on the card title and
                                        make up
                                        the bulk of the card's content.</p>
                                    <small class="card-text">1 day ago</small>
                                </div>
                            </div>
                            <div class="list-group-item px-3 d-flex"><img src="../img/notif.svg" alt="iconimage">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text mb-3">Some quick example text to build on the card title and
                                        make up
                                        the bulk of the card's content.</p>
                                    <small class="card-text">1 day ago</small>
                                </div>
                            </div>
                            <div class="list-group-item px-3 text-center"><a href="#">View all notifications</a></div>
                        </div>
                    </div>
                    <div class="inline"></div>
                    <div class="name">Admin</div>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-icon pe-md-0 position-relative" data-bs-toggle="dropdown">
                                <img src="../img/photo_admin.svg" alt="icon">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end position-absolute">
                                <a class="dropdown-item" href="#">Profile</a>
                                <a class="dropdown-item" href="#">Account Setting</a>
                                <a class="dropdown-item" href="/PeoplePerTask/project/pages/index.html">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <section class="Agents px-4">
                <div class="col-sm-6 ">
                    <a href="#addEmployeeModal" class="btn btn-secondary" data-toggle="modal"><i
                            class="material-icons">&#xE147;</i> <span>Ajouter une offre</span></a>
                </div>

                <table class="agent table align-middle bg-white">
                    <thead class="bg-light">
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Company</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Date de création</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $offreQuery = new Job($conn);
                        $allOffres = $offreQuery->getOffres();

                        foreach ($allOffres as $offre) {
                            ?>

                            <tr class="freelancer">
                                <td>
                                    <div class="d-flex align-items-center">
                                       
                                        <div class="ms-3">
                                            <p class="fw-bold mb-1 f_title">
                                                <?php echo $offre['title']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="fw-normal mb-1 f_title">
                                        <?php echo $offre['description']; ?>
                                    </p>

                                </td>
                                <td>
                                    <p class="fw-normal mb-1 f_title">
                                        <?php echo $offre['company']; ?>
                                    </p>

                                </td>
                                <td>
                                    <p class="fw-normal mb-1 f_title">
                                        <?php echo $offre['location']; ?>
                                    </p>

                                </td>
                                <td>
                                    <p class="fw-normal mb-1 f_title">
                                        <?php echo $offre['status']; ?>
                                    </p>

                                </td>
                                <td>
                                    <p class="fw-normal mb-1 f_title">
                                        <?php echo $offre['date_created']; ?>
                                    </p>
                                </td>
                                <td>
                                   <a href="delete.php?id=<?php echo$offre['job_id']; ?>"><img class="delet_user" src="../img/user-x.svg" alt=""></a>
                                   <a href="edit.php?id=<?php echo$offre['job_id']; ?>"><img class="ms-2 edit" src="../img/edit.svg" alt=""></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>



                    </tbody>
                </table>


            </section>
           
        </div>
    </div>

    <div id="addEmployeeModal" class="modal">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<form id="employeeForm" method="post" action="add.php" enctype="multipart/form-data">
					<div class="modal-header">
						<h4 class="modal-title">Add Offre</h4>
						<button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Title</label>
							<input type="text" class="form-control" name="title" >
						</div>
						<div class="form-group">
							<label>Description</label>
							<input type="text" class="form-control" name="description" >
						</div>
                        <div class="form-group">
							<label>Company</label>
							<input type="text" class="form-control" name="company" >
						</div>
                        <div class="form-group">
							<label>Location</label>
							<input type="text" class="form-control" name="location" >
						</div>
                        <div class="form-group">
							<label>Status</label>
							<input type="text" class="form-control" name="status" >
						</div>
                        <div class="form-group">
							<label>Date de création</label>
							<input type="date" class="form-control" name="date_created" >
						</div>
                        <div class="form-group">
							<label>Image </label>
							<input type="file" class="form-control" name="image_path" accept="image/*" >
						</div>


					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default"  data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-success" value="Add">
					</div>
				</form>
			</div>
		</div>
	</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    
</body>

</html>