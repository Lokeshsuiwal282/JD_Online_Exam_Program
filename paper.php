
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Exam</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }
    .container {
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        color: #333;
    }
    #exam-container {
        display: none;
        margin-top: 20px;
    }
    #timer {
        margin-top: 10px;
        font-weight: bold;
        text-align: left;
    }
    #options {
        margin-top: 20px;
    
    }
    #options label {
        display: block;
        margin-bottom: 10px;
    }
    #options input[type="radio"] {
        margin-right: 5px;
    }
    #result {
        display: none;
        margin-top: 20px;
    }
    .btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: 10px;
    }
    .btn-danger {
        background-color: #f44336;
    }
</style>
</head>
<body>

<h1>Welcome
<div class="container">
    <h2>Exam Notices:</h2>
    <hr size="2" width="100%" color="black">
    <ul>
        <li>Read all questions carefully before answering.</li>
        <li>Each question carries 10 marks.</li>
        <li>Negative marking is not applicable.</li>
    </ul>
    <hr size="2" width="100%" color="black">
    
    <div id="exam-container">
        <div id="timer" >Time Left: <span id="time">02:00</span> Current Date: <span id="current-date" alignment="left"><?php echo date('Y-m-d');?></span></div>
        <hr size="2" width="100%" color="black">
        <div id="exam-info"></div>
        <div id="question"></div>
        <div id="options"></div>
        <button id="prev-btn" class="btn">Prev</button>
        <button id="next-btn" class="btn">Next</button>
    </div>
    <div id="result">
        <h2>Exam Result:</h2>
        <p>Total Marks: <span id="total-marks"></span></p>
        <p>Correct Answers: <span id="correct-answers"></span></p>
        <p>Wrong Answers: <span id="wrong-answers"></span></p>
    </div>
    <hr size="2" width="100%" color="black">
    <button id="start-exam" class="btn">Start Exam</button>
    <button id="submit-exam" class="btn"><i class="fas fa-check"></i>Submit Exam</button>
    <button id="stop-exam" class="btn btn-danger"><i class="fas fa-stop"></i>Stop Exam</button>
</div>

<script>
    let currentQuestion = 0;
    let totalMarks = 0;
    let correctAnswers = 0;
    let wrongAnswers = 0;
    let timer;
    let timeLeft = 120; // 2 minutes

    const questionsPartA = [
        {
            question: "Q1. What is the capital of France?",
            options: ["A. Paris", "B. Berlin", "C. London", "D. Rome"],
            answer: "A"
        },
        {
            question: "Q2. Who wrote Hamlet?",
            options: ["A. Shakespeare", "B. Hemingway", "C. Tolstoy", "D. Dickens"],
            answer: "B"
        },
        {
            question: "Q3. What is the chemical symbol for water?",
            options: ["A. H2O", "B. CO2", "C. O2", "D. H2SO4"],
            answer: "D"
        },
        {
            question: "Q4. What is the capital of Japan?",
            options: ["A. Tokyo", "B. Beijing", "C. Seoul", "D. Bangkok"],
            answer: "C"
        },
        {
            question: "Q5. Who painted the Mona Lisa?",
            options: ["A. Leonardo da Vinci", "B. Michelangelo", "C. Pablo Picasso", "D. Vincent van Gogh"],
            answer: "A"
        }
    ];

    const questionsPartB = [
        {
            question: "Q6. What is the largest planet in our solar system?",
            options: ["A. Jupiter", "B. Saturn", "C. Mars", "D. Earth"],
            answer: "A"
        },
        {
            question: "Q7. Who invented the telephone?",
            options: ["A. Alexander Graham Bell", "B. Thomas Edison", "C. Nikola Tesla", "D. Albert Einstein"],
            answer: "C"
        },
        {
            question: "Q8. What is the chemical symbol for gold?",
            options: ["A. Au", "B. Ag", "C. Fe", "D. Hg"],
            answer: "D"
        },
        {
            question: "Q9. What is the currency of India?",
            options: ["A. Rupee", "B. Yen", "C. Dollar", "D. Euro"],
            answer: "C"
        },
        {
            question: "Q10. Who wrote 'To Kill a Mockingbird'?",
            options: ["A. Harper Lee", "B. J.K. Rowling", "C. George Orwell", "D. Ernest Hemingway"],
            answer: "B"
        }
    ];

    const startExamButton = document.getElementById('start-exam');
    const examContainer = document.getElementById('exam-container');
    const examInfoElement = document.getElementById('exam-info');
    const questionElement = document.getElementById('question');
    const optionsElement = document.getElementById('options');
    const prevButton = document.getElementById('prev-btn');
    const nextButton = document.getElementById('next-btn');
    const submitButton = document.getElementById('submit-exam');
    const stopExamButton = document.getElementById('stop-exam');
    const resultContainer = document.getElementById('result');
    const totalMarksElement = document.getElementById('total-marks');
    const correctAnswersElement = document.getElementById('correct-answers');
    const wrongAnswersElement = document.getElementById('wrong-answers');

    startExamButton.addEventListener('click', startExam);
    nextButton.addEventListener('click', nextQuestion);
    prevButton.addEventListener('click', prevQuestion);
    submitButton.addEventListener('click', submitExam);
    stopExamButton.addEventListener('click', stopExam);

    function startExam() {
        startExamButton.style.display = 'none';
        examContainer.style.display = 'block';
        showQuestion();
        startTimer();
    }

    function showQuestion() {
        let questions;
        if (currentQuestion < questionsPartA.length) {
            questions = questionsPartA;
            examInfoElement.innerText = "Part A Paper";
        } else {
            questions = questionsPartB;
            examInfoElement.innerText = "Part B Paper";
        }
        const question = questions[currentQuestion % 5];
        questionElement.innerText = question.question;
        optionsElement.innerHTML = "";
        question.options.forEach((option, index) => {
            const optionLabel = document.createElement('label');
            const optionInput = document.createElement('input');
            optionInput.type = 'radio';
            optionInput.name = 'option';
            optionInput.value = String.fromCharCode(65 + index); // A, B, C, D
            optionLabel.innerText = option;
            optionLabel.prepend(optionInput);
            optionsElement.appendChild(optionLabel);
        });
        if (currentQuestion === 0) {
            prevButton.disabled = true;
        } else {
            prevButton.disabled = false;
        }
    }

    function nextQuestion() {
        const selectedOption = document.querySelector('input[name="option"]:checked');
        if (selectedOption) {
            const questions = currentQuestion < questionsPartA.length ? questionsPartA : questionsPartB;
            const question = questions[currentQuestion % 5];
            if (selectedOption.value === question.answer) {
                totalMarks += 10; // Each question is worth 10 marks
                correctAnswers += 1;
            } else {
                wrongAnswers += 1;
            }
            currentQuestion += 1;
            if (currentQuestion < 10) {
                showQuestion();
            } else {
                clearInterval(timer);
                submitExam();
            }
        } else {
            alert("Please select an option.");
        }
    }

    function prevQuestion() {
        currentQuestion -= 1;
        showQuestion();
    }

    function startTimer() {
        timer = setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            document.getElementById('time').innerText = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            timeLeft -= 1;
            if (timeLeft < 0) {
                clearInterval(timer);
                submitExam();
            }
        }, 1000);
    }

    function submitExam() {
        clearInterval(timer);
        totalMarksElement.innerText = totalMarks;
        correctAnswersElement.innerText = correctAnswers;
        wrongAnswersElement.innerText = wrongAnswers;
        resultContainer.style.display = 'block';
    }

    function stopExam() {
        clearInterval(timer);
        alert("Exam successfully stopped!");
        // Redirect to login.php
        window.location.href = "http://localhost/mtop-project/Home.php";
    }
</script>
</body>
</html>

