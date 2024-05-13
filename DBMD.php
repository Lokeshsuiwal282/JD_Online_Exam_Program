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


<h1>Welcome To.</h1>
<div class="container">
    <h2>Exam Notices: Paper 1</h2>
    <h2>MCA(Master of Computer Application)</h2>
    <h2>DBMS(Database Management System)</h2>
    
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
        <p>Result: <span id="exam-result"></span></p>
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
    let examResult = "";
    let timer;
    let timeLeft = 1000; // 10 minutes

    const questionsPartA = [
        {
            question: "Q1. What does SQL stand for? ",
            options: ["A. Structured Query Language ", "B. Sequential Query Language ", "C. Standard Question Language ", "D. Systematic Query Logic "],
            answer: "A"
        },
        {
            question: "Q2. Which of the following is not a type of database model?",
            options: ["A. Hierarchical ", "B. Relational", "C. Object-Oriented", "D. Scalar "],
            answer: "D"
        },
        {
            question: "Q3. What is the primary key in a relational database used for? ",
            options: ["A. To uniquely identify each row in a table ", "B. To sort the rows in a table ", "C. To store large text data ", "D. To establish relationships between tables "],
            answer: "A"
        },
        {
            question: "Q4. Which SQL command is used to retrieve data from a database? ",
            options: ["A. UPDATE ", "B. SELECT", "C. INSERT ", "D. DELETE "],
            answer: "B"
        },
        {
            question: "Q5. Which of the following is a non-relational database? ",
            options: ["A. MySQL", "B. PostgreSQL ", "C. MongoDB", "D. Oracle"],
            answer: "C"
        },
        {
            question: "Q6. What is normalization in the context of databases?",
            options: ["A. The process of reducing data redundancy and dependency ", "B. The process of increasing data redundancy for faster access ", "C. The process of storing data without any structure ", "D. The process of removing data from a database "],
            answer: "A"
        },
        {
            question: "Q7. Which SQL clause is used to filter the results of a query? ",
            options: ["A. GROUP BY ", "B. ORDER BY ", "C. WHERE ", "D. HAVING"],
            answer: "C"
        },
        {
            question: "Q8. What is the purpose of a foreign key in a relational database? ",
            options: ["A. To uniquely identify each row in a table ", "B. To establish a link between two tables ", "C. To define the primary key in a table ", "D. To sort the rows in a table "],
            answer: "B"
        },
        {
            question: "Q9. Which of the following is not a data manipulation language (DML) command in SQL? ",
            options: ["A. SELECT ", "B. UPDATE ", "C. CREATE ", "D. DELETE"],
            answer: "C"
        },
        {
            question: "Q10. Which of the following is true about a primary key constraint? ",
            options: ["A. It allows NULL values", "B. It can be applied to multiple columns ", "C. It ensures the uniqueness of values in a column ", "D. It is used to establish relationships between tables"],
            answer: "C"
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

    // function submitExam() {
    //     clearInterval(timer);
    //     totalMarksElement.innerText = totalMarks;
    //     correctAnswersElement.innerText = correctAnswers;
    //     wrongAnswersElement.innerText = wrongAnswers;
    //     resultContainer.style.display = 'block';

    //     // Send exam results to PHP 
    //     const xhr = new XMLHttpRequest();
    //     xhr.open('POST', 'save_results.php', true);
    //     xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    //     xhr.onload = function () {
    //         if (xhr.status === 200) {
    //             console.log(xhr.responseText);
    //             // Redirect to new HTML file after saving results
    //             window.location.href = 'http://localhost/mtop-project/Digital_Exam.php';
    //         }
    //     };
    //     xhr.send(`totalMarks=${totalMarks}&correctAnswers=${correctAnswers}&wrongAnswers=${wrongAnswers}`);
    // }
  
    function submitExam() {
    clearInterval(timer);
    totalMarksElement.innerText = totalMarks;
    correctAnswersElement.innerText = correctAnswers;
    wrongAnswersElement.innerText = wrongAnswers;
    resultContainer.style.display = 'block';

    // Determine pass or fail
    const passThreshold = 70; // Adjust this threshold according to your grading criteria
    const examResult = (totalMarks >= passThreshold) ? "Pass" : "Fail";

    // Display the exam result
    document.getElementById('exam-result').innerText = examResult;

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
    xhr.send(`totalMarks=${totalMarks}&correctAnswers=${correctAnswers}&wrongAnswers=${wrongAnswers}&examResult=${examResult}`);
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
