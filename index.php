
<?php
include_once('database/connection.php');
require_once('models/job.php');
session_start();


?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		JobEase
	</title>




	<link rel="stylesheet" href="styles/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
		integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
		integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
		integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
		crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
	<header>


		<nav class="navbar navbar-expand-md navbar-dark">
			<div class="container">
				<!-- Brand/logo -->
				<a class="navbar-brand" href="#">
					<i class="fas fa-code"></i>
					<h1>JobEase &nbsp &nbsp</h1>
				</a>

				<!-- Toggler/collapsibe Button -->
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
					<span class="navbar-toggler-icon"></span>
				</button>

				<!-- Navbar links -->
				<div class="collapse navbar-collapse" id="collapsibleNavbar">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item active">
							<a class="nav-link" href="#">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Features</a>
						</li>
						<?php if (isset($_SESSION['id'])) { ?>
						<li class="nav-item">
							<a class="nav-link" href="views/candidat/job/notification.php">Notifications</a>
							
						</li>
						<?php 
						}
						?>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
								data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								language
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="#">FR</a>
								<a class="dropdown-item" href="#">EN</a>
							</div>
						</li>
						<span class="nav-item active">
							<a class="nav-link" href="#">EN</a>
						</span>
						<li class="nav-item">
							<?php if (isset($_SESSION['id'])) { ?>
								<a class="nav-link" href="views/auth/logout.php">Logout</a>
							<?php } else { ?>
								<a class="nav-link" href="views/auth/login.php">Login</a>
							<?php } ?>
						</li>

					</ul>
				</div>
			</div>
		</nav>
	</header>




	<section class="search">
		<h2>Find Your Dream Job</h2>
		<form class="form-inline" method="post" onsubmit="event.preventDefault(); filterjob();">
			<div class="form-group mb-2">
				<input type="text" id="title" placeholder="Keywords">


			</div>
			<div class="form-group mx-sm-3 mb-2">
				<input type="text" id="location" placeholder="Location">
			</div>
			<div class="form-group mx-sm-3 mb-2">
				<input type="text" id="company" placeholder="Company">
			</div>
			<button type="submit" class="btn btn-primary mb-2">Search</button>

		</form>
	</section>

	<div id="results">

		<!--------------------------  card  --------------------->
		<section class="light">
			<h2 class="text-center py-3">Latest Job Listings</h2>
			<div class="container py-2">
				<?php
				if (isset($_GET) or isset($_POST)) {
					$title = isset($_POST['title']) ? $_POST['title'] : NULL;

					$offreQuery = new Job($conn);
					$allOffres = $offreQuery->search($title);

					foreach ($allOffres as $offre):
						?>


				<article class="postcard light green">
					<a class="postcard__img_link" href="#">
						<?php
						$imagePath = "views/admin/dashboard/img/" . $offre['image_path'];
						?>
						<img class="postcard__img" src="<?php echo $imagePath; ?>" alt="Image Title" />
					</a>
					<div class="postcard__text t-dark">
						<h3 class="postcard__title green"><a href="#">
								<?php echo $offre['title']; ?>
							</a></h3>
						<div class="postcard__subtitle small">
							<time datetime="2020-05-25 12:00:00">
								<i class="fas fa-calendar-alt mr-2"></i>
								<?php echo $offre['company']; ?>
							</time>
						</div>
						<div class="postcard__bar"></div>
						<div class="postcard__preview-txt">
							<?php echo $offre['description']; ?>
						</div>
						<ul class="postcard__tagbox">
							<li class="tag__item"><i class="fas fa-tag mr-2"></i>
								<?php echo $offre['location']; ?>
							</li>
							<li class="tag__item"><i class="fas fa-clock mr-2"></i>55 mins.</li>
							<li class="tag__item play green">
								<a
									href="<?php echo isset($_SESSION['id']) ? 'views/candidat/job/offre.php?id=' . $offre['job_id'] : 'views/auth/login.php'; ?>">
									<i class="fas fa-play mr-2"></i>
									<?php echo isset($_SESSION['id']) ? 'POSTULER' : 'APPLY NOW'; ?>
								</a>


							</li>
						</ul>
					</div>
				</article>
				<?php
					endforeach;
				}
				?>
			</div>
		</section>
	</div>




	<footer>
		<p>© 2023 JobEase </p>
	</footer>
</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="script.js"></script>

</html>