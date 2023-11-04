<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Quiz Results</title>
    <style>
        body 
        {
            font-family: 'Poppins', sans-serif;
            background-color: white;
            text-align: center;
            padding: 20px;
        }
        .menu-bar 
        { 
            background-color: darkblue;
            color: white;
            padding: 10px 0;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        .menu-bar a 
        {
            text-decoration: none;
            color: #000000; 
        }

        #home-button 
        {
            background-color: rgba(214, 212, 212, 0.9);
            padding: 5px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 20px;
        }

        #logout-button 
        {
            background-color: rgba(214, 212, 212, 0.9);
            padding: 5px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        h1 
        {
            color: white;
            background-color: black;
        }

        .user-score 
        {
            background-color: lightgrey;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 20px 0;           
        }

        .user-score h2 
        {
            color: black;
        }

        .user-score p 
        {
            color: black;
        }

        .participants-table 
        {
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 20px auto;
            width: 15%;
        }

        .participants-table th, .participants-table td 
        {
            padding: 8px 12px;
            border-bottom: 1px solid #ccc;
        }

        .participants-table th 
        {
            background-color: black;
            color: #fff;
        }

        .participants-table tr:nth-child(even) 
        {
            background-color: lightgray;
        }

        .participants-table tr:nth-child(odd) 
        {
            background-color: white;
        }
    </style>
</head>
<body>
        <div class="menu-bar">
            <button id="home-button"><a href="quiz.html">Home</a></button>
            <button id="logout-button"><a href="login.php">Logout</a></button>
        </div>
        <h1>Quiz Results</h1>

    <?php
    session_start();

    if (isset($_SESSION['username'])) 
    {
        $db = new PDO('mysql:dbname=quiz;host=127.0.0.1', 'root', '');

        $username = $_SESSION['username'];
        $userScoreQuery = $db->prepare("SELECT correct_answer, wrong_answer FROM results WHERE username = ?");
        $userScoreQuery->execute([$username]);
        $userScore = $userScoreQuery->fetch();
        ?>

        <div class="user-score">
            <h2>Your Score: <?= $userScore['correct_answer'] ?></h2>
            <p>Correct Answers: <?= $userScore['correct_answer'] ?></p>
            <p>Wrong Answers: <?= $userScore['wrong_answer'] ?></p>
        </div>
    
        <div class="participants-table">
            <table>
                <tr>
                    <th>Username</th>
                    <th>Correct Answers</th>
                    <th>Wrong Answers</th>
                </tr>
                <?php
                $allScoresQuery = $db->query("SELECT username, correct_answer, wrong_answer FROM results");
                while ($row = $allScoresQuery->fetch()) 
                {
                    echo "<tr>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['correct_answer'] . "</td>";
                    echo "<td>" . $row['wrong_answer'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    
        <?php
        } 
        else 
        {
            echo "You must be logged in to view the results.";
        }
        ?>
</body>
</html>