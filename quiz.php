<?php
 ob_start();
?>
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

function editQuestion(questionNum){
	questionID = 'question' + questionNum;
	document.getElementById(questionID).style='display: block;';
}

function editAnswer(answerNum){
	answerID = 'answer' + answerNum;
	document.getElementById(answerID).style='display: block;';
}

function newQuestion(questionNum){
	questionID = 'new-question-form' + questionNum;
	document.getElementById(questionID).style="display: block;";
}

function lastQuestion(){
	document.getElementById("new-question-last").style="display: block;";
}

function newAnswer(answerNum){
	insertAnswerID = 'new-answer-form' + answerNum;
	document.getElementById(insertAnswerID).style="display: block;";
}

function lastAnswer(lastAnswer){
	lastAnswerID = 'new-answer-last' + lastAnswer;
	document.getElementById(lastAnswerID).style="display: block;";
}

</script>
<body>
<div class="container">
    <div class="row">
	<a href="quizzes.php">< Back To Quizzes</a>
	</div>
	<div class="row">
		<div class="col-12">
		<?php
		if(isset($_GET['id'])){
			$quiz_id = mysqli_real_escape_string($connect_db, $_GET['id']);
			$sql_select_questions = "SELECT * FROM questions WHERE quiz_FK = $quiz_id ORDER BY question_order ASC";
			$sql_questions_result = mysqli_query($connect_db, $sql_select_questions);
			$questions = mysqli_fetch_all($sql_questions_result, MYSQLI_ASSOC);
			if($questions){
				$quiz_name = $_GET['name'];
				echo '<h1 class="quiz-name">'.$quiz_name.'</h1>';
			}else{
				$sql_select_quiz = "SELECT quiz_ID from quizzes WHERE quiz_ID = '$quiz_id'";
				$sql_quiz_result = mysqli_query($connect_db, $sql_select_quiz);
				$quiz  = mysqli_fetch_all($sql_quiz_result, MYSQLI_ASSOC);
				if($quiz){
					if($_SESSION['permissions'] === 'Edit'){
						echo '<h2>Quiz Found Please Create Some Questions Below</h2>';
						echo '<form method="post"><input type="text" name="new-question" placeholder="Create New Question" required><button type="submit" name="create-question">Add</button></form>';
						if(isset($_POST['create-question'])){
							$create_question = $_POST['new-question'];
							$sql_create_question = "INSERT INTO questions (question_order ,quiz_FK, question) VALUES ('1','$quiz_id','$create_question')";
							if(mysqli_query($connect_db, $sql_create_question)){
								header("Refresh:0");
								exit();
							}else{
								echo 'Query Error On Question Table: ' . mysqli_error($connect_db);
							}
						}
					}else{
						echo '<h2>No Questions Found For This Quiz</h2>';
					}
					
				}else{
					echo '<h2>No Quiz Can Be Found</h2>';
				}
			}
		}?>
		</div>
		<?php
		$question_counter = 0;
		foreach($questions as $question){
			$question_counter++;
		?>
		<div class="text-center col-12">
		<?php
			if($_SESSION['permissions'] === "Edit"){
				echo '<button onclick="newQuestion('.$question_counter.')" class="add-quiz-btn action-buttons"><i  class="fa-2x fas fa-plus-square"></i></button>';
				echo '<form id="new-question-form'.$question_counter.'" style="display: none;" method="post"><input type="text" name="new-question" placeholder="Create New Question" required><input style="display: none;" type="text" name="question_order" value="'.$question['question_order'].'"><button type="submit" name="insert-question">Add</button></form>';
			}
			if(isset($_POST['insert-question'])){
				$new_question = $_POST['new-question'];
				$order_ID = $_POST['question_order'];
				$sql_update_IDs = "UPDATE questions SET question_order = question_order + 1 WHERE quiz_FK = '$quiz_id' AND question_order >= '$order_ID'";
				$sql_insert_question = "INSERT INTO questions (question_order ,quiz_FK, question) VALUES ('$order_ID','$quiz_id','$new_question')";
				if(mysqli_query($connect_db, $sql_update_IDs) && mysqli_query($connect_db, $sql_insert_question)){
					header("Refresh:0");
					exit();
				}else{
					echo 'Query Error On Question Table: ' . mysqli_error($connect_db);
				}
			}
		?>
		</div>
		<div class="card text-left col-lg-12">
			<div class="card-inner">
				<h3 class="questions"><?php echo $question_counter.') '.$question['question'];?></h3>
				<?php 
				if($_SESSION['permissions'] === 'Edit'){
					echo '<a href="#"><i class="edit-icons fas fa-edit" onclick="editQuestion('.$question_counter.')"></i></a>';
					echo '<form id="question'.$question_counter.'" style="display: none;" method="post"><input type="text" name="question" placeholder="Enter New Question" required><input style="display: none;" type="text" name="questionID" value="'.$question['questions_ID'].'"><button type="submit" name="update">Update</button></form>';
					echo '<form class="delete-question-form" id="question'.$question_counter.'" method="post"><input style="display: none;" type="text" name="questionID" value="'.$question['questions_ID'].'"><button type="submit" name="delete-question"><i class="delete-icons fa-lg fas fa-trash-alt"></i></button></form>';
					if(isset($_POST['update'])){
						$update_question_ID = $_POST["questionID"];
						$updated_question = $_POST["question"];
						$updated_question = mysqli_real_escape_string($connect_db, $updated_question);
						$sql_update_question = "UPDATE questions SET question='$updated_question' WHERE questions_ID ='$update_question_ID'";
						if(mysqli_query($connect_db, $sql_update_question)){
							header("Refresh:0");
							exit();
						}else{
							echo 'Query Error On Question Table: ' . mysqli_error($connect_db);
						}
					}else if(isset($_POST['delete-question'])){					
						$question_ID = $_POST["questionID"];
						$sql_delete_question = "DELETE from questions WHERE questions_ID ='$question_ID'";
						if(mysqli_query($connect_db, $sql_delete_question)){
							header("Refresh:0");
							exit();
						}else{
							echo 'Query Error On Quiz Table: ' . mysqli_error($connect_db);
						}
					}
				}
				if($_SESSION['permissions'] === 'Edit' || $_SESSION['permissions'] === 'View'){
					$question_ID = $question['questions_ID'];
					$sql_select_answers = "SELECT * FROM answers WHERE question_FK = $question_ID ORDER BY answer_order ASC";
					$sql_answers_result = mysqli_query($connect_db, $sql_select_answers);
					$answers = mysqli_fetch_all($sql_answers_result, MYSQLI_ASSOC);
					if($answers){
						echo '<ol type="A">';
						$answer_counter = 0;
						foreach($answers as $answer){
							$answer_counter++;
							if($_SESSION['permissions'] === 'Edit'){
								echo '<button onclick="newAnswer('.$answer_counter.')" class="insert-answer"><i class="fa-lg fas fa-plus-square"></i></button>';
								echo '<form id="new-answer-form'.$answer_counter.'" class="new-answer-form" style="display: none;" method="post"><input type="text" name="new-answer" placeholder="Create New Answer" required><input style="display: none;" type="text" name="answer_order" value="'.$answer['answer_order'].'"><button type="submit" name="insert-answer">Add</button></form>';
								echo '<li>'.$answer['answer'].'<a href="#"><i class="edit-icons fas fa-edit" onclick="editAnswer('.$answer['answer_ID'].')"></i></a>';
								echo '<form class="delete-answer-form" method="post"><input style="display: none;" type="text" name="answerID" value="'.$answer['answer_ID'].'"><button type="submit" name="delete-answers"><i class="delete-icons fas fa-trash-alt"></i></button></form></li>';
								echo '<form id="answer'.$answer['answer_ID'].'" style="display: none;" method="post"><input type="text" name="answer" placeholder="Enter New Answer" required><input style="display: none;" type="text" name="answerID" value="'.$answer['answer_ID'].'"><button type="submit" name="update-questions">Update</button></form>';
							}else{
								echo '<li>'.$answer['answer'].'</li>';
							}
							if(isset($_POST['insert-answer'])){
								$new_answer = $_POST['new-answer'];
								$answer_order_ID = $_POST['answer_order'];
								$sql_update_answer_IDs = "UPDATE answers SET answer_order = answer_order + 1 WHERE question_FK = '$question_ID' AND answer_order >= '$answer_order_ID'";
								$sql_insert_answer = "INSERT INTO answers (answer_order ,question_FK, answer) VALUES ('$answer_order_ID','$question_ID','$new_answer')";
								echo $question_ID;
								if(mysqli_query($connect_db, $sql_update_answer_IDs) && mysqli_query($connect_db, $sql_insert_answer)){
									header("Refresh:0");
									exit();
								}else{
									echo 'Query Error On Answers Table: ' . mysqli_error($connect_db);
								}
							}		
							if(isset($_POST['delete-answers'])){
								$answer_ID = $_POST["answerID"];
								$sql_delete_answer = "DELETE from answers WHERE answer_ID ='$answer_ID'";
								if(mysqli_query($connect_db, $sql_delete_answer)){
									header("Refresh:0");
									exit();
								}else{
									echo 'Query Error On Answers Table: ' . mysqli_error($connect_db);
								}
							}
							if(isset($_POST['update-questions'])){
								$update_answer_ID = $_POST["answerID"];
								$updated_answer = $_POST["answer"];
								$updated_question = mysqli_real_escape_string($connect_db, $updated_answer);
								$sql_update_answer = "UPDATE answers SET answer='$updated_answer' WHERE answer_ID ='$update_answer_ID'";
								if(mysqli_query($connect_db, $sql_update_answer)){
									header("Refresh:0");
									exit();
								}else{
									echo 'Query Error On Answer Table: ' . mysqli_error($connect_db);
								}
							}
						}
						if($answer_counter == sizeof($answers)){ 
							if($_SESSION['permissions'] === 'Edit'){
								$new_last_answer_order_ID = $answer['answer_order'] + 1;
								echo '<button onclick="lastAnswer('.$question_ID.')" class="insert-answer"><i class="fa-lg fas fa-plus-square"></i></button>';
								echo '<form id="new-answer-last'.$question_ID.'" style="display: none;" method="post"><input type="text" name="new-last-answer" placeholder="Create New Answer" required><input style="display: none;" type="text" name="last_answer_order" value="'.$new_last_answer_order_ID.'"><button type="submit" name="create-last-answer">Add</button></form>';
								if(isset($_POST['create-last-answer'])){
									$new_last_answer = $_POST['new-last-answer'];
									$last_answer_order_ID = $_POST['last_answer_order'];
									$sql_new_last_answer = "INSERT INTO answers (answer_order ,question_FK, answer) VALUES ('$last_answer_order_ID','$question_ID','$new_last_answer')";
									if(mysqli_query($connect_db, $sql_new_last_answer)){
										header("Refresh:0");
										exit();
									}else{
										echo 'Query Error On Question Table: ' . mysqli_error($connect_db);
									}
								}
							}
						}
						echo '</ol>';
					}else{
						if($_SESSION['permissions'] === 'Edit'){
							echo "<p>No Answers Found</P>";
							echo '<form method="post"><input type="text" name="new-answer" placeholder="Create Answer" required><button type="submit" name="create-answer">Add</button></form>';
							if(isset($_POST['create-answer'])){
								$create_answer = $_POST['new-answer'];
								$sql_create_question = "INSERT INTO answers (answer_order ,question_FK, answer) VALUES ('1','$question_ID','$create_answer')";
								if(mysqli_query($connect_db, $sql_create_question)){
									header("Refresh:0");
									exit();
								}else{
									echo 'Query Error On Answer Table: ' . mysqli_error($connect_db);
								}
							}
						}
					}
				}
				?>
			</div>
		</div>
		<div class="text-center col-12">
		<?php
			if($_SESSION['permissions'] === 'Edit'){
				if($question_counter == sizeof($questions)){
					$new_last_order_ID = $question['question_order'] + 1;
					echo '<button onclick="lastQuestion()" class="add-quiz-btn action-buttons"><i  class="fa-2x fas fa-plus-square"></i></button>';
					echo '<form id="new-question-last" style="display: none;" method="post"><input type="text" name="new-last-question" placeholder="Create New Question" required><input style="display: none;" type="text" name="last_question_order" value="'.$new_last_order_ID.'"><button type="submit" name="create-last-question">Add</button></form>';
					if(isset($_POST['create-last-question'])){
						$new_last_question = $_POST['new-last-question'];
						$last_order_ID = $_POST['last_question_order'];
						$sql_new_last_question = "INSERT INTO questions (question_order ,quiz_FK, question) VALUES ('$last_order_ID','$quiz_id','$new_last_question')";
						if(mysqli_query($connect_db, $sql_new_last_question)){
							header("Refresh:0");
							exit();
						}else{
							echo 'Query Error On Question Table: ' . mysqli_error($connect_db);
						}
					}	
				}
			}
		?>
		</div>
	<?php } ?>
	</div>
</div>
	
</body>
</html>