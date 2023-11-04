<?php
session_start();

if (isset($_SESSION['username']) && isset($_POST['score'])) 
{
    $db = new PDO('mysql:dbname=quiz;host=127.0.0.1', 'root', '');

    $username = $_SESSION['username'];
    $score = $_POST['score'];

    $existingRecordQuery = $db->prepare("SELECT * FROM results WHERE username = ?");
    $existingRecordQuery->execute([$username]);
    $existingRecord = $existingRecordQuery->fetch();

    if ($existingRecord) 
    {
        $correctAnswers = $score;
        $wrongAnswers = 10 - $score;
        
        $updateScoreQuery = $db->prepare("UPDATE results SET correct_answer = ?, wrong_answer = ? WHERE username = ?");
        $updateScoreQuery->execute([$correctAnswers, $wrongAnswers, $username]);
    } 
    else 
    {

        $correctAnswers = $score;
        $wrongAnswers = 10 - $score;
        
        $insertScoreQuery = $db->prepare("INSERT INTO results (username, correct_answer, wrong_answer) VALUES (?, ?, ?)");
        $insertScoreQuery->execute([$username, $correctAnswers, $wrongAnswers]);
    }

    echo "Score submitted successfully!";
} 
else 
{
    echo "Unauthorized access.";
}
?>
