const questions = [
    {
        question: "Who wrote the play 'Romeo and Juliet'?",
        answers: [
            {text: "Charles Dickens", correct: false},
            {text: "Jane Austen", correct: false},
            {text: "William Shakespeare", correct: true},
            {text: "Mark Twain", correct: false},
        ]
    },
    {
        question: "Which famous scientist developed the theory of general relativity?",
        answers: [
            {text: "Isaac Newton", correct: false},
            {text: "Albert Einstein", correct: true},
            {text: "Galileo Galilei", correct: false},
            {text: "Charles Darwin", correct: false},
        ]
    },
    {
        question: "Which country is famous for the martial art known as Karate?",
        answers: [
            {text: "China", correct: false},
            {text: "Brazil", correct: false},
            {text: "Japan", correct: true},
            {text: "India", correct: false},
        ]
    },
    {
        question: "Who is the author of the Harry Potter book series?",
        answers: [
            {text: "J.R.R. Tolkien", correct: false},
            {text: "J.K. Rowling", correct: true},
            {text: "George Orwell", correct: false},
            {text: "Agatha Christie", correct: false},
        ]
    },
    {
        question: "Which of the following programming languages is often used for data analysis and scientific computing?",
        answers: [
            {text: "Java", correct: false},
            {text: "Python", correct: true},
            {text: "C++", correct: false},
            {text: "Ruby", correct: false},
        ]
    },
    {
        question: "What is the largest mammal in the world?",
        answers: [
            {text: "Elephant", correct: false},
            {text: "Blue whale", correct: true},
            {text: "Giraffe", correct: false},
            {text: "Lion", correct: false},
        ]
    },
    {
        question: "Which gas do plants absorb from the atmosphere during photosynthesis?",
        answers: [
            {text: "Oxygen", correct: false},
            {text: "Carbon dioxide", correct: true},
            {text: "Nitrogen", correct: false},
            {text: "Hydrogen", correct: false},
        ]
    },
    {
        question: "Who painted the Mona Lisa?",
        answers: [
            {text: "Pablo Picasso", correct: false},
            {text: "Leonardo da Vinci", correct: true},
            {text: "Vincent van Gogh", correct: false},
            {text: "Michelangelo", correct: false},
        ]
    },
    {
        question: "What is the largest planet in our solar system?",
        answers: [
            {text: "Earth", correct: false},
            {text: "Mars", correct: false},
            {text: "Jupiter", correct: true},
            {text: "Venus", correct: false},
        ]
    },
    {
        question: "Who is the Greek god of the sea?",
        answers: [
            {text: "Zeus", correct: false},
            {text: "Hades", correct: false},
            {text: "Poseidon", correct: true},
            {text: "Apollo", correct: false},
        ]
    }
    
];


let timer;
let timeLeft = 30; 

function startTimer() 
{
    clearInterval(timer);
    updateTimerDisplay();

    timer = setInterval(function () 
    {
        if (timeLeft <= 0) 
        {
            clearInterval(timer);
            handleNextButton();
        } else 
        {
            timeLeft--;
            updateTimerDisplay();
        }
    }, 1000);
}

function updateTimerDisplay() 
{
    const timerDisplay = document.getElementById("timer");
    timerDisplay.textContent = `${(timeLeft).toLocaleString('en-US', { minimumIntegerDigits: 2 })}`;
}

startTimer();

function shuffleArray(array) 
{
    for (let i = array.length - 1; i > 0; i--) 
    {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}

shuffleArray(questions);


const questionElement = document.getElementById("question");
const answerButtons = document.getElementById("answer-buttons");
const nextButton = document.getElementById("next-button");

let currentQuestionIndex = 0;
let score = 0;

function startQuiz()
{
    currentQuestionIndex = 0;
    score = 0;
    nextButton.innerHTML = "Next";
    showQuestion();
}

function showQuestion()
{
    resetState();
    let currentQuestion = questions[currentQuestionIndex];
    questionElement.innerHTML = currentQuestion.question;

    currentQuestion.answers.forEach(answer => 
        {
        const button = document.createElement("button");
        button.innerHTML = answer.text;
        button.classList.add("btn");
        answerButtons.appendChild(button);
        if(answer.correct)
        {
            button.dataset.correct = answer.correct;
        }
        button.addEventListener("click", selectAnswer);
        });
        document.getElementById("question-number").textContent = currentQuestionIndex + 1;
        document.getElementById("total-questions").textContent = questions.length;
}

function resetState()
{
    nextButton.style.display = "none";
    while(answerButtons.firstChild)
    {
        answerButtons.removeChild(answerButtons.firstChild);
    }
}

function selectAnswer(e)
{
    const selectedBtn = e.target;
    const isCorrect = selectedBtn.dataset.correct === "true";
    if(isCorrect)
    {
        selectedBtn.classList.add("correct");
        score++;
    }
    else
    {
        selectedBtn.classList.add("incorrect");
    }
    Array.from(answerButtons.children).forEach(button => 
        {
        if(button.dataset.correct === "true")
        {
            button.classList.add("correct");
        }
        button.disabled = true;
        });
        nextButton.style.display = "block";
}

function showScore() 
{
    resetState();
    window.location.href = "result.php";
}

function submitScore() 
{
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "submit_score.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () 
    {
         if (xhr.readyState === 4 && xhr.status === 200) 
         {
            const response = xhr.responseText;
            window.location.href = "result.php";
         }
    };
    xhr.send("score=" + score); 
}

function handleNextButton() 
{
clearInterval(timer);
timeLeft = 30;
currentQuestionIndex++;

if (currentQuestionIndex < questions.length) 
{
    showQuestion();
    startTimer();
} 
else 
{
    nextButton.style.display = "none"; 
    const submitButton = document.createElement("button");
    submitButton.innerHTML = "Submit";
    submitButton.classList.add("submit-button");
    submitButton.addEventListener("click", submitScore);
    answerButtons.appendChild(submitButton);
}
}


nextButton.addEventListener("click", () => {
    if(currentQuestionIndex < questions.length)
    {
        handleNextButton();
    }
    else
    {
        startQuiz();
    }
});

startQuiz();