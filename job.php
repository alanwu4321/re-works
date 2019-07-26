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
    <!-- <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre.min.css">
<link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-exp.min.css">
<link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-icons.min.css"> -->
</head>
<div class="php">
    <?php
    include "cookies.php";
    $env = "dev";
	include "env.php";
    $curUser = checkCookies();
    $curUserID = $curUser[0];
    $curUserType = $curUser[1];
    $curUserUsername = $curUser[2];
    $curUserName = ucwords($curUser[3]);
    $curUserTypeID = $curUser[4];


    ?>
</div>
<?php
include "dbConfig.php";
include "asset.php";
$jobID = $_GET["id"];
$sql = "SELECT j.jobID, j.companyID, j.openings, j.title, j.category, j.expLevel, j.duration, j.location, j.description, c.name, c.division FROM Job as j JOIN Company as c on j.companyID = c.companyID WHERE j.jobID=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $jobID);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($jobID, $companyID, $openings, $title, $category, $expLevel, $duration, $location, $description, $name, $division);
$stmt->fetch();

$sqlSJ = "SELECT * FROM SJ_Ranks WHERE s_Id=? AND jobID=? and 'rank' IS NOT NULL";
$stmt = $mysqli->prepare($sqlSJ);
$stmt->bind_param("ii", $curUserID, $jobID);
$stmt->execute();
$arrSJ = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];

$sqlJS = "SELECT * FROM JS_Ranks WHERE s_Id=? and jobID=? and 'rank' IS NOT NULL";
$stmt = $mysqli->prepare($sqlJS);
$stmt->bind_param("ii", $curUserID, $jobID);
$stmt->execute();
$arrJS = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];

// //rank is not null by s_id and job_id = ? 
// $sqlJS = "SELECT rank FROM JS_Ranks WHERE s_Id=? and jobID=? and rank IS NOT NULL";
// $stmt = $mysqli->prepare($sqlJS);
// $stmt->bind_param("ii", $curUserID, $jobID);
// $stmt->execute();
// $arrJS = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];


// //rank is not null by s_id and job_id = ? 
// $sqlJS = "SELECT rank FROM SJ_Ranks WHERE s_Id=? and jobID=? and rank IS NOT NULL";
// $stmt = $mysqli->prepare($sqlJS);
// $stmt->bind_param("ii", $curUserID, $jobID);
// $stmt->execute();
// $arrJS = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];

$rankArray = "Select Count(SJ_Ranks.rank) From escheer.SJ_Ranks group by s_Id having AVG(SJ_Ranks.rank) <= (Select SJ_Ranks.rank from escheer.SJ_Ranks where jobID = 1 and s_Id = 8 and SJ_Ranks.rank is not null)";
$rankArraymt = $mysqli->prepare($rankArray);
// $rankArraymt->bind_param("i", $jobID);
$rankArraymt->execute();
$rankArrayres = $rankArraymt->get_result()->fetch_all(MYSQLI_ASSOC);
$sum = 0; 
foreach($rankArrayres as $el) {
    $sum += $el["Count(SJ_Ranks.rank)"];
}
// print_r($sum);

$JSRankprob = $arrJS["rank"];
$SJRankprob = $arrSJ["rank"];
$matchChance = 0;
if ($JSRankprob == 1 AND $SJRankprob == 1) { 
    $matchChance = 100;
    // echo $matchChance;
} elseif ($JSRankprob == "Not Ranked") {
    $matchChance = 0;
    // echo $matchChance;
} else {
    $matchChance =  $sum/(sizeof(rankArrayres)*$SJRankprob)*10;
    // echo $matchChance; 
}

// echo $matchChance . "%";



//note is not null
$sqlComment = "SELECT * FROM (SELECT * FROM SJ_Ranks WHERE jobID=? and note IS NOT NULL) as comment NATURAL JOIN Student NATURAL JOIN User ORDER BY date DESC";
$stmt = $mysqli->prepare($sqlComment);
$stmt->bind_param("i", $jobID);
$stmt->execute();
$arrComment = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
// print_r($arrComment);
$sqlOffer = "SELECT s_Id FROM JS_Ranks as ranks WHERE ranks.jobID=? and ranks.rank='1' ";
$stmt = $mysqli->prepare($sqlOffer);
$stmt->bind_param("i", $jobID);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($offerUser);
$stmt->fetch();

$interviwerIDForJob = $curUserType == "Student" ? getInterviewerIDbyJobID($jobID): $curUserTypeID;

$sqlIntComment = "SELECT * FROM (SELECT intf.i_Id,i.jobID, i.note, intf.date FROM (Select * from JS_Ranks where note is not null and jobID = ? ) as i JOIN Interviews_For as intf on i.jobID = intf.jobID where i_id = ?) as notes Natural JOIN Interviewer Natural join User ORDER BY notes.date DESC";
$stmtInt = $mysqli->prepare($sqlIntComment);
$stmtInt->bind_param("ii", $jobID, $interviwerIDForJob);
$stmtInt->execute();
$arrIntComment = $stmtInt->get_result()->fetch_all(MYSQLI_ASSOC);
// print_r($arrIntComment);
function getInterviewerIDbyJobID($jobID)
{
    include "dbConfig.php";
    $sqlID = "SELECT DISTINCT i_Id FROM Interviews_For WHERE jobID=?";
    $stmtID= $mysqli->prepare($sqlID);
    $stmtID->bind_param("i", $jobID);
    $stmtID->execute();
    return $stmtID->get_result()->fetch_all(MYSQLI_ASSOC)[0]["i_Id"];
};
?>
<body style="background-color: #666666;">
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-form" style="padding:0px; background:white; height:50vh; overflow-y:scroll;  ">
                    <div class="row bg-light" style="background:#f8f9fa; height:86px; z-index:10000; display: flex; justify-content:flex-end;">

                        <span style="margin:30px; margin-right:50px;"> <span style="margin:15px;"> <a href="<?php echo $host; ?>/login.php?action=logout">Logout</a></span>
                            <span> <a class="avatar" href="#">
                                    <img src="images/<?php echo $curUserID ?>.png" width="35" alt="Profile Avatar" title="Bradley Jones" />
                                </a> </span>
                        </span>
                    </div>
                    <div class="container" style="">
                        <ul class="comment-section">
                            <div class="" style="height:60vh; overflow-y:scroll;  overflow-x:unset; margin-bottom: -40px;">
                                <?php
                                foreach ($arrComment as $comment) {
                                    $type = ($comment["s_Id"] == $curUserID) ? "author-comment" : "user-comment";
                                    $ranked = ($comment["s_Id"] == $offerUser) ? "Offer" : "Ranked";
                                    // print_r($comment);
                                    echo "<li class=\"comment {$type}\">";
                                    echo "<div class=\"info\">";
                                    echo "<a href=\"#\">{$comment["name"]}</a>";
                                    echo "<span>{$comment["date"]}</span>";
                                    echo "</div>";
                                    echo "<a class=\"avatar\" data-html=\"true\" href=\"#\" data-container=\"body\" data-trigger=\"focus\" data-toggle=\"popover\" data-placement=\"top\" title=\"<b>{$comment["name"]} </b>\" 
                                    data-content=\"<div> <b>Ranking: </b> {$comment["rank"]} <br> <b>Job Ranking: </b> {$ranked} <br> <b>Email: </b> {$comment["email"]} <br> <b>Phone: </b> {$comment["phoneNumber"]} <br> <b> Grad Year: </b> {$comment["gradYear"]} <br> <b>Program: </b> {$comment["program"]} <br></div>\">";
                                    echo "<img src=\"images/{$comment["s_Id"]}.png\" width=\"35\" alt=\"Profile Avatar\" title=\"Anie Silverston\" />";
                                    echo "</a>";
                                    echo "<p>{$comment["note"]}</p>";
                                    echo "</li>";
                                }
                                ?>
                            </div>
                            <?php if($curUserType =="Student") :?>
                            <li class="write-new">
                                <form class="threadInput">
                                    <input class="" name="s_Id" type="hidden" value="<?php echo $curUserID ?>">
                                    <input class="" name="jobID" type="hidden" value="<?php echo $jobID ?>">
                                    <textarea placeholder="Write your comment here" name="comment"></textarea>
                                    <div>
                                        <img src="images/<?php echo $curUserID ?>.png" width="35" alt="Profile of Bradley Jones" title="Bradley Jones" />
                                        <button type="submit" style="background-color:#4099ff;">Submit</button>
                                    </div>
                                </form>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="login100-more" style="background-color:#fff;">
                    <!-- <img src="images/bf-03.jpg">  -->
                    <div class="hero-image" style="background-image: linear-gradient(25deg, <?php echo $colors[strtolower($name)] ?>, rgba(249, 209, 205, 0.05)), url(images/bg.png);">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light textfont">
                            <a class="navbar-brand" href="<?php echo $host; ?>/home.php" style="font-size:2.3em; font-weight:600;">
                                <img src="images/bg.png" width="65" height="60" class="textfont d-inline-block align-top" alt="">
                                re:works
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav">
                                <li class="nav-item ">
										<a class="nav-link" href="<?php echo $host; ?>/home.php">Home</a>
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
                                <h1 class="textfont" style="font-size:4em; color:white; font-weight:700;"> <?php echo $name ?></h1>
                                <!-- <p>And I'm a Photographer</p> -->
                                <button class="btn btn-primary purple-btn" style="background-color: #ded2d2; color:white; border:none;">Edit the Job</button>
                            </div>
                    </div>

                    <div class="container " style="padding-top:20px; overflow-y:scroll; height:60vh;  ">
                        <div class="row" style="padding-left: 33px; padding-bottom:6%;">
                            <div class="col-sm-5">
                                <?php
                                echo "<div class=\"card\" style=\"width: 18rem; margin-top:20px;\">";
                                echo "<div class=\"card-body\">";
                                echo "<h5 class=\"card-title\">{$name} <span class=\"circle\" style=\" background-color:{$colors[strtolower($name)]} \" >{$name[0]}</span> </h5>";
                                echo "<p class=\"card-text\">{$title}</p>";

                                // echo "<a href=\"/job.php?id={$row["id"]}\" class=\"btn btn-primary purple-btn \" style=\" background:white;  \">See Details</a>";
                                echo "</div>";
                                echo "</div>";

                                if($curUserType=="Student"){
                                echo "<div class=\"card\" style=\"width: 18rem; margin-top:20px;\">";
                                echo "<div class=\"card-body\">";
                                echo "<h5 class=\"card-title\"> Probability of Match </h5>";
                                echo "<h3 class=\"card-title\" style=\"color:{$colors[strtolower($name)]} \"  > {$matchChance} % </h3>";
                                echo "<hr> ";
                                $JSRank = ($arrJS["rank"] == null) ? " Pending " : $arrJS["rank"];
                                $SJRank = ($arrSJ["rank"] == null) ? " Pending " : $arrSJ["rank"];
                                echo "<p class=\"card-text\">Job Ranking: {$JSRank}</p>";
                                echo "<p class=\"card-text\">Your Ranking: {$SJRank}</p>";
                                echo "<p class=\"card-text\">Openings: {$openings}</p>";
                                // echo "<a href=\"/job.php?id={$row["id"]}\" class=\"btn btn-primary purple-btn \" style=\" background:white;  \">See Details</a>";
                                echo "</div>";
                                echo "</div>";
                                }



                                // echo "</div>";
                                ?>

                                <div class="container" style="padding-left:0px;">
                                    <ul class="comment-section">
                                        <div class="" style="height:30vh; overflow-y:scroll; overflow-x: hidden;  margin-bottom: -40px;">
                                        <?php
                                foreach ($arrIntComment as $comment) {
                                    $type = ($comment["userId"] == $curUserID) ? "author-comment" : "user-comment";
                                    // $ranked = ($comment["i_Id"] == $offerUser) ? "Offer" : "Ranked";
                                    // print_r($comment);
                                    $style = ($comment["userId"] == $curUserID) ? "padding-left:8px;" : "padding-right:5px;";
                                    echo "<li class=\"comment {$type}\">";
                                    echo "<div class=\"info\">";
                                    echo "<a href=\"#\">{$comment["name"]}</a>";
                                    echo "<span>{$comment["date"]}</span>";
                                    echo "</div>";
                                    echo "<a class=\"avatar\" style=\"{$style}\"data-html=\"true\" href=\"#\" data-container=\"body\" data-trigger=\"focus\" data-toggle=\"popover\" data-placement=\"top\" title=\"<b>{$comment["name"]} </b>\" 
                                    data-content=\"<div> <b>Company: </b> {$name} <br>  <b>Title: </b> {$comment["jobTitle"]} <br> <b>Email: </b> {$comment["email"]} <br> <b>Phone: </b> {$comment["phoneNumber"]} </div>\">";
                                    echo "<img src=\"images/{$comment["userId"]}.png\" width=\"35\" alt=\"Profile Avatar\" title=\"Anie Silverston\" />";
                                    echo "</a>";
                                    echo "<p>{$comment["note"]}</p>";
                                    echo "</li>";
                                }
                                ?>
                                        </div>
                                        <?php if($curUserType =="Interviewer") :?>
                                        <li class="write-new">
                                            <form action="#" method="post">
                                                <textarea placeholder="Write your comment here" name="comment"></textarea>
                                                <div>
                                                    <img src="images/<?php echo $curUserID ?>.png" width="35" alt="Profile of Bradley Jones" title="Bradley Jones" />
                                                    <button type="submit" style="background-color:#4099ff;">Submit</button>
                                                </div>
                                            </form>
                                        </li>
                                        <?php endif; ?>

                                    </ul>

                                </div>


                            </div>
                            <div class="col-md-7">
                              
                                <div class="card" style="border:0px;">
                                    <div class="card-body  job_description_card" style="border-color:#4099ff;">
                                        <h5 class="card-title">Company Info</h5>
                                        <p class="card-text">The company is located in <?php echo $location; ?>. You will be working under <?php echo $division; ?></p>
                                        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                    </div>
                                </div>
                                <div class="card" style=" border:0px;">
                                    <div class="card-body  job_description_card" style="border-color:#FFB64D;">
                                        <h5 class="card-title">Job Category</h5>
                                        <p class="card-text">The job falls under <?php echo $category; ?>. We are looking for people with <?php echo $expLevel; ?> level of experience. </p>
                                        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                    </div>
                                </div>
                                
                                <div class="card" style=" border:0px;">
                                    <div class="card-body  job_description_card" style="border-color:#FF5370;">
                                        <h5 class="card-title">Description</h5>
                                        <p class="card-text"><?php echo $description ?> </p>
                                        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                    </div>
                                </div>
                                <div class="card" style=" border:0px;">
                                    <div class="card-body  job_description_card" style="border-color:#2ed8b6;">
                                        <h5 class="card-title">About Job</h5>
                                        <p class="card-text">This will be a <?php echo $duration; ?> length work term. We are looking forward to working with you! </p>
                                        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





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