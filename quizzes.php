<!DOCTYPE html>
<html>
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
       <link rel="stylesheet" href="assets/font-awesome/css/all.css">
       <link rel="stylesheet" href="css/bootstrap.min.css">
       <link rel="stylesheet" href="css/styles.css">
   </head>
   <?php include('header.php');?>
<script>

function editQuizzes(){
	bins = document.getElementsByClassName("action-buttons");
	var counter;
	for (counter = 0; counter < bins.length; counter++) {
	  bins[counter].style="display: block;";
	}
}

function newQuiz(){
	document.getElementById("new-quiz-form").style="display: block;";
}

</script>
<body>
<div class="container">
	<div class="row text-right">
		<div class="col-12">
			<?php 
			if($_SESSION['permissions'] === "Edit"){
				echo '<a href="#"><i class="edit-icons fa-2x fas fa-edit" onclick="editQuizzes()"></i></a>';
			}	
			?>
		</div>	
	</div>
	<div class="row">
		<div class="col-12">
			<h3 class="text-center">Select A Quiz Below To <b>
			<?php 
				if($_SESSION['permissions'] === "Restricted"){ 
				echo "View (Only Questions)"; 
				}elseif($_SESSION['permissions'] === "View"){
					echo $_SESSION['permissions'];
				}else{
					echo $_SESSION['permissions'];
				}
			?>
			</b></h3>
		</div>
		<div class="text-center col-12">
		<?php 
			if($_SESSION['permissions'] === "Edit"){
				echo '<button onclick="newQuiz()" style="display: none;" class="add-quiz-btn action-buttons"><i  class="fa-2x fas fa-plus-square"></i></button>';
				echo '<form id="new-quiz-form" style="display: none;" method="post"><input type="text" name="new-quiz" placeholder="Create New Quiz" required><button type="submit" name="create-quiz">Add</button></form>';
			}
			if(isset($_POST['create-quiz'])){
				$new_quiz = $_POST['new-quiz'];
				$sql_create_quiz = "INSERT INTO quizzes (quiz_name) VALUES ('$new_quiz')";
				if(mysqli_query($connect_db, $sql_create_quiz)){
					header("Refresh:0");
					exit();
				}else{
						echo 'Query Error On Quiz Table: ' . mysqli_error($connect_db);
				}
			}
		?>
		</div>
	</div>
    <div class="row">
		<?php

$sql_quizzes = "SELECT * FROM quizzes ORDER BY quiz_ID ASC LIMIT 9";
$sql_result = mysqli_query($connect_db, $sql_quizzes);
$quizzes= mysqli_fetch_all($sql_result, MYSQLI_ASSOC);
$quiz_counter = 0;
foreach($quizzes as $quiz){
	$quiz_counter++;
	?>
        <div class="card text-center col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <div class="card-inner">
                <?php
                $quiz_ID =  $quiz['quiz_ID'];
                echo '<a href="quiz.php?id=' . $quiz_ID .'&name='.$quiz['quiz_name'].'">';
                ?>
					<h5>Quiz <?php echo $quiz_counter?></h5>
					<h2><?php echo $quiz['quiz_name'];?></h2>
                </a>
            </div>
			<?php
				if($_SESSION['permissions'] === "Edit"){
					echo '<form class="action-buttons" style="display: none;" method="post"><input style="display: none;" type="text" name="quizID" value="'.$quiz['quiz_ID'].'"><button type="submit" name="delete-quiz"><i class="delete-icons fa-lg fas fa-trash-alt"></i></button></form>';
				}
				if(isset($_POST['delete-quiz'])){
					$quiz_ID = $_POST["quizID"];
					$sql_delete_quiz = "DELETE from quizzes WHERE quiz_ID ='$quiz_ID'";
					if(mysqli_query($connect_db, $sql_delete_quiz)){
						header("Refresh:0");
						exit();
					}else{
						echo 'Query Error On Quiz Table: ' . mysqli_error($connect_db);
					}
				}
			?>
        </div>
<?php } ?>
	</div>
</div>

</body>
</html>