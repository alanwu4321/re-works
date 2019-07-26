<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login V18</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!--===============================================================================================-->



</head>


<div class="php">
	<?php
	include "cookies.php";
	$curUser = checkCookies();
	$curUserID = $curUser[0];
	$curUserType = $curUser[1];
	$curUserUsername = $curUser[2];
	$curUserName = ucwords($curUser[3]);
	$curUserTypeID = $curUser[4];
	?>
</div>

<?php
include "asset.php";
include "dbConfig.php";

//Both Interview and Student (Count Jobs)
$studentSql = "SELECT DISTINCT r.jobID, r.title, a.name FROM (SELECT * FROM (Job Natural Join (SELECT jobID FROM SJ_Ranks where s_Id = ? ) as n)) as r JOIN Company as a on a.companyID = r.companyID";
$interviewerSql = "SELECT companies.jobID, companies.title, name FROM (SELECT title, companyID, jobs.jobID FROM (SELECT * FROM Interviewer Natural join Interviews_For where userId = ?) as jobs JOIN Job as j on j.jobID = jobs.jobID) as companies NATURAL JOIN Company";
$sql = ($curUserType == "Student") ? $studentSql : $interviewerSql;
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $curUserID);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($jobID, $title, $name);

//Student (Pending Jobs)
$JobLeftToRankCountStudentSQL = "SELECT COUNT(distinct jobID) FROM SJ_Ranks as r WHERE r.s_id = ? and r.rank IS NULL";
$stmtJobCount = $mysqli->prepare($JobLeftToRankCountStudentSQL);
$stmtJobCount->bind_param("i", $curUserID);
$stmtJobCount->execute();


$JobLeftToRankCountStudent = $stmtJobCount->get_result()->fetch_all(MYSQLI_ASSOC)[0]["COUNT(distinct jobID)"];
$numberOfJobs = $stmt->num_rows;

// Interview ID
// print_r($curUserTypeID);

//Interviewer (comments that interviews made)
$commentsCountInterviewSQL = "SELECT Count(i_Id) FROM (Select jobID, note from JS_Ranks where note is not null) as m natural join Interviews_For as i where i_Id = ? group by i_Id having Count(i_Id) > 0";
$commentsCountInterview = $mysqli->prepare($commentsCountInterviewSQL);
$commentsCountInterview->bind_param("i", $curUserTypeID);
$commentsCountInterview->execute();
$commentsCountInterviewCount = $commentsCountInterview->get_result()->fetch_all(MYSQLI_ASSOC)[0]["Count(i_Id)"];

$totalUserCountSQL = "SELECT Count(userID) FROM User";
$totalUserCountsmt = $mysqli->prepare($totalUserCountSQL);
$totalUserCountsmt->execute();
$totalUserCount = $totalUserCountsmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]["Count(userID)"];

// print_r($totalUserCount);
?>

<body style="background-color: #666666;">
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">

				<div class="login100-form" style="padding:0px; background:white;">
					<div class="row bg-light" style="background:#f8f9fa; height:86px; z-index:10000; display: flex; justify-content:flex-end;">

						<span style="margin:30px; margin-right:50px;"> <span style="margin:15px;"> <a href="/~escheer/re-works/login.php?action=logout">Logout</a> </span>
							<span> <a class="avatar" href="#">
									<img src="images/<?php echo $curUserID ?>.png" width="35" alt="Profile Avatar" title="Bradley Jones" />
								</a> </span>
						</span>

					</div>
					<div class="card" style="border:0px; padding:2em; padding-top:0em; padding-bottom:0em;">
						<div class="card-body">
							<center class="m-t-30"> <img src="images/<?php echo $curUserID ?>.png" class="img-circle" width="150">
								<!-- <img src="" alt="Profile Image not Found"> -->
								<h4 class="card-title m-t-10"><?php echo $curUserName ?> </h4>
								<h6 class="card-subtitle">Accounts Manager Amix Corp</h6>
								<div class="row text-center justify-content-md-center">
									<div class="col-6">
										<font size="2" class="text-muted p-t-30 db">
											<h6>Mechanical Engineering
										</font>
										</h6>
									</div>
									<div class="col-2">
										<font size="2" class="text-muted p-t-30 db">
											<h6>2B
										</font>
										</h6>
									</div>
								</div>
							</center>
						</div>
						<div>
						</div>
						<div class="card-body">
							<!-- <small class="text-muted">Email Address </small>
							<h6>j99doe@edu.uwaterloo.ca</h6> <small class="text-muted p-t-30 db">Phone #</small>
							<h6>+1 613 589 9926</h6> <small class="text-muted p-t-30 db">LinkedIn</small>
							<h6><a href="https://www.linkedin.com/in/alan-wu-36b668157/">Click to go to LinkedIn Profile</a></h6> -->

							<div class="row">
								<div class="col-md-6 col-xl-6">
									<div class="card speical_card bg-c-blue order-card">
										<div class="card-block">
											<h6 class="m-b-20">Jobs</h6>
											<h2 class="text-right"><i class="fa fa-envelope-open-o f-left"></i><span><?php echo $numberOfJobs ?></span></h2>
											<p class="m-b-0">Total number of Jobs<span class="f-right"></span></p>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-xl-6">
									<div class="card speical_card bg-c-green order-card">
										<div class="card-block">
											<h6 class="m-b-20"><?php echo $card2Title = $curUserType == "Student" ? "Pending Jobs" : "Total Comments" ?></h6>
											<h2 class="text-right"><i class="fa fa-comment-o f-left"></i><span><?php echo $card2 = $curUserType == "Student" ? $JobLeftToRankCountStudent : $commentsCountInterviewCount ?></span></h2>
											<p class="m-b-0"><?php echo $card2Title = $curUserType == "Student" ? "Total Comment Count" : "Jobs left to be Ranked" ?><span class="f-right"></span></p>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 col-xl-6">
									<div class="card speical_card bg-c-yellow order-card">
										<div class="card-block">
											<h6 class="m-b-20">Time until Deadline</h6>
											<h2 class="text-right"><i class="fa fa-refresh f-left"></i><span><?php
																												$date1 = new DateTime('now');
																												$date2 = date_create("2019-07-30");
																												//difference between two dates
																												$diff = date_diff($date1, $date2);
																												//count days
																												echo $diff->format("%a ");
																												?></span></h2>
											<p class="m-b-0">Days until <?php $deadlineTime = mktime(23, 59, 59, 7, 28, 2019);
																echo date("F d, Y", $deadlineTime); ?><span class="f-right"></span></p>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-xl-6">
									<div class="card speical_card bg-c-pink order-card">
										<div class="card-block">
											<h6 class="m-b-20">Active Users</h6>
											<h2 class="text-right"><i class="fa fa-user f-left"></i><span><?php echo $totalUserCount; ?> </span></h2>
											<p class="m-b-0">Total number of Users <span class="f-right"></span></p>
										</div>
									</div>
								</div>
							</div>
							<br>
							<div class="map-box">
								<!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2895.4400855817703!2d-80.54704628435039!3d43.47228537912791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882bf6ad02edccff%3A0xdd9df23996268e17!2sUniversity+of+Waterloo!5e0!3m2!1sen!2sca!4v1563943903647!5m2!1sen!2sca" width="100%" height="100" frameborder="0" style="border:0" allowfullscreen></iframe> -->
							</div> <small class="text-muted p-t-30 db">Social Profile</small>
							<br>
							<button class="btn btn-circle btn-secondary"><i class="fa fa-github"></i></button>
							<button class="btn btn-circle btn-secondary"><i class="fa fa-facebook"></i></button>
							<button class="btn btn-circle btn-secondary"><i class="fa fa-instagram"></i></button>
						</div>
					</div>

				</div>

				<div class="login100-more" style="background-color:#fff;">
					<!-- <img src="images/bf-03.jpg">  -->

					<div class="hero-image">
						<nav class="navbar navbar-expand-lg navbar-light bg-light textfont">
							<a class="navbar-brand" href="/~escheer/re-works/home.php" style="font-size:2.3em; font-weight:600;">
								<img src="images/bg.png" width="65" height="60" class="textfont d-inline-block align-top" alt="">
								re:works
							</a>
							<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
								<span class="navbar-toggler-icon"></span>
							</button>
							<div class="collapse navbar-collapse" id="navbarNav">
								<ul class="navbar-nav">
									<li class="nav-item active">
										<a class="nav-link" href="/~escheer/re-works/home.php">Home <span class="sr-only">(current)</span></a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#"></a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#"></a>
									</li>
									<li class="nav-item">
										<a class="nav-link disabled" href="#">Hi, <span style="font-weight: 600; color:darkgray"> <?php echo $curUserName; ?> </span> ! You are logged in as <?php echo $pronoun = ($curUserType == "Student") ? "a" : "an"; ?> <span style="font-weight: 600; color:darkgray"> <?php echo $curUserType; ?> </span> </a>
									</li>
								</ul>
							</div>
							<div class="hero-text" style="margin-top:20px;">
								<h1 class="textfont" style="font-size:4em; color:white; font-weight:700;"> My Jobs</h1>
								<!-- <p>And I'm a Photographer</p> -->
								<button class="btn btn-primary purple-btn" data-toggle="modal" data-target="#exampleModal" style="background-color: #ded2d2; color:white; border:none; z-index: 100!important;">Add a Job</button>
							</div>
					</div>

					<!-- Button trigger modal -->


					<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<form class=" validate-form">
										<span class="login100-form-title p-b-43 loginTitle">
											Login to continue
										</span>


										<div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
											<input class="input100" type="text" name="email">
											<span class="focus-input100"></span>
											<span class="label-input100">Email</span>
										</div>
										<div class="wrap-input100 validate-input" data-validate="Password is required">
											<input class="input100" type="password" name="password">
											<span class="focus-input100"></span>
											<span class="label-input100">Password</span>
										</div>
										<div style="" class="wrap-input100 validate-input nameInput" data-validate="Password is required">
											<input class="input100" type="text" name="name">
											<span class="focus-input100"></span>
											<span class="label-input100">Name</span>
										</div>
										<div style="" class="wrap-input100 validate-input phoneInput" data-validate="Password is required">
											<input class="input100" type="text" name="phone">
											<span class="focus-input100"></span>
											<span class="label-input100">Phone</span>
										</div>

										<input class="toggleInput" name="toggle" type="hidden" value="login">

										<div class="flex-sb-m w-full p-t-3 p-b-32 rmbInput">
											<div class="contact100-form-checkbox">
												<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
												<label class="label-checkbox100" for="ckb1">
													Remember me
												</label>
											</div>

											<div>
												<button class="txt1 forgotpwInput">
													Forgot Password?
												</button>
											</div>
										</div>
										<div class="container-login100-form-btn">
											<button class="login100-form-btn buttonInput">
												Login
											</button>
										</div>


									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary">Save changes</button>
								</div>
							</div>
						</div>
					</div>

					<div class="container " style="padding-top:20px; overflow-y:scroll; height:60vh;  ">
						<div class="row" style="padding-left: 33px; padding-bottom:6%;">
							<?php

							while ($stmt->fetch()) {
								echo "<div class=\"col-sm-4\">";
								echo "<div class=\"card speical_card\" style=\"width: 18rem; margin-top:20px;\">";
								echo "<div class=\"card-body\">";
								echo "<h5 class=\"card-title\">{$name} <span class=\"circle\" style=\" background-color:{$colors[strtolower($name)]} \" >{$name[0]}</span> </h5>";
								echo "<p class=\"card-text\">{$title}</p>";
								// echo "<p class=\"card-text\">Ranking: {$row["rank"]}</p>";
								echo "<a href=\"/~escheer/re-works/job.php?id={$jobID}\" class=\"btn btn-primary purple-btn \" style=\" background:white;  \">See Details</a>";
								echo "</div>";
								echo "</div>";
								echo "</div>";
							}

							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

	<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>

</html>