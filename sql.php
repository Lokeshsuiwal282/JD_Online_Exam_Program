
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
        text-align: right;
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

<h1>Welcome</h1>
<div class="container">
    <h2>Exam Notices: Paper 4</h2>
    <h2>MCA(Master of Computer Application)</h2>
    <h2>SQL(Structured Query Language)</h2>
    <h3>Maximum Marks: 100</h3>
    <hr size="2" width="100%" color="black">
    <ul>
        <li>Read all questions carefully before answering.</li>
        <li>Each question carries 10 marks.</li>
        <li>Negative marking is not applicable.</li>
    </ul>
    <hr size="2" width="100%" color="black">
    
    <div id="exam-container">
        <div id="timer" >Time Left: <span id="time">10:00</span> Date: <span id="current-date" alignment="left"><?php echo date('d-m-y');?></span></div>
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
    let timeLeft = 1000; // 2 minutes

    const questionsPartA = [
        {
            question: "Q1.What does SQL stand for? ",
            options: ["A. Standard Query Language", "B. Structured Question Language ", "C. Systematic Query Logic ", "D. Structured Query Language "],
            answer: "D"
        },
        {
            question: "Q2.Which SQL keyword is used to retrieve data from a database? ",
            options: ["A. RETRIEVE ", "B. SELECT ", "C. FETCH ", "D. EXTRACT"],
            answer: "B"
        },
        {
            question: "Q3.What is the purpose of the SQL WHERE clause?",
            options: ["A. To specify the order of the result set ", "B. To filter rows based on a condition", "C. To group rows with similar value", "D. To perform aggregate functions on the result set "],
            answer: "B"
        },
        {
            question: "Q4.Which SQL command is used to add new rows to a table? ",
            options: ["A. INSERT INTO ", "B.ADD ROW ", "C.CREATE ROW ", "D. UPDATE ROW "],
            answer: "A"
        },
        {
            question: "Q5.What does the SQL acronym 'DDL' stand for? ",
            options: ["A. Data Definition Language ", "B. Data Description Language ", "C. Data Declaration Language ", "D. Database Description Language "],
            answer: "A"
        },

        {
            question: "Q6.Which SQL function is used to find the number of rows in a table? ",
            options: ["A. ) ROWCOUNT() ", "B. ROWS() ", "C. COUNT() ", "D. NUMROWS()"],
            answer: "A"
        },
        {
            question: "Q7.What is the purpose of the SQL GROUP BY clause? ",
            options: ["A. To sort the result set in ascending order ", "B. To filter rows based on a condition ", "C. To perform aggregate functions on grouped data ", "D. To join multiple tables together "],
            answer: "C"
        },
        {
            question: "Q8.Which SQL command is used to delete data from a table? ",
            options: ["A. DELETE FROM ", "B. DROP ", "C. REMOVE FROM ", "D. TRUNCATE TABLE "],
            answer: "D"
        },
        {
            question: "Q9.What does the SQL acronym 'ACID' stand for? ",
            options: ["A. Atomicity, Consistency, Isolation, Durability ", "B.Association, Consistency, Isolation, Durability ", "C. Atomicity, Compatibility, Isolation, Durability ", "D. Atomicity, Consistency, Integrity, Durability "],
            answer: "A"
        },
        {
            question: "Q10.Which SQL clause is used to sort the result set in ascending or descending order? ",
            options: ["A. ORDER BY ", "B. SORT BY ", "C. ARRANGE BY ", "D. ) GROUP BY "],
            answer: "A"
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
            examInfoElement.innerText = "";
        } else {
            pass;
        }
        const question = questions[currentQuestion % 10];
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
            const minutes = Math.floor(timeLeft / 100);
            const seconds = timeLeft % 100;
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

        // Send exam results to PHP 
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_results.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                // Redirect to new HTML file after saving results
                window.location.href = 'http://localhost/mtop-project/Digital_Exam.php';
            }
        };
        xhr.send(`totalMarks=${totalMarks}&correctAnswers=${correctAnswers}&wrongAnswers=${wrongAnswers}`);
    }


    function stopExam() {
        clearInterval(timer);
        alert("Exam successfully stopped!");
        // Redirect to login.php
        window.location.href = "http://localhost/mtop-project/Digital_Exam.php";
    }
</script>
</body>
</html>