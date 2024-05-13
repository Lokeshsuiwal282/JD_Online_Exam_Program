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
    <h2>Exam Notices: Paper 2</h2>
    <h2>MCA(Master of Computer Application)</h2>
    <h2>CN(Computer Networks)</h2>
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
        <h2>Exam Result-:</h2>
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
    let timeLeft = 1000; // 100 minutes

    const questionsPartA = [
        {
            question: "Q1. What does TCP/IP stand for?",
            options: ["A. Transmission Control Protocol/Internet Protocol ", "B. Transfer Control Protocol/Internet Protocol ", "C. Telecommunication Control Protocol/Internet Protocol.", "D. Transfer Connection Protocol/Internet Protocol "],
            answer: "A"
        },
        {
            question: "Q2. Which device is used to connect multiple computers in a local area network (LAN)? ",
            options: ["A. Router ", "B. Modem  ", "C. Switch ", "D. Hub "],
            answer: "C"
        },
        {
            question: "Q3. Which layer of the OSI model is responsible for logical addressing and routing?  ",
            options: ["A. Data Link Layer ", "B. Transport Layer ", "C. Network Layer ", "D. Physical Layer "],
            answer: "C"
        },
        {
            question: "Q4. What is the maximum data rate of Ethernet technology commonly used in LANs? ",
            options: ["A. 10 Mbps  ", "B. 100 Mbps ", "C. 1 Gbps ", "D. 10 Gbps  "],
            answer: "D"
        },
        {
            question: "Q5. What is the function of DNS in computer networks?  ",
            options: ["A. To translate domain names into IP addresses  ", "B. To encrypt data during transmission ", "C. To establish a secure connection between client and server ", "D. To filter incoming network traffic "],
            answer: "A"
        },
        {
            question: "Q6. Which protocol is used for sending emails over the internet? ",
            options: ["A. SMTP ", "B. HTTP", "C. FTP", "D.  TCP "],
            answer: "A"
        },
        {
            question: "Q7. Which of the following is not a type of network topology? ",
            options: ["A. Star ", "B. Ring ", "C. Mesh", "D. Linear "],
            answer: "D"
        },
        {
            question: "Q8. What is the purpose of NAT (Network Address Translation)? ",
            options: ["A. To encrypt data packets ", "B. To route packets between different networks ", "C. To translate private IP addresses to public IP addresses ", "D. To prevent unauthorized access to a network  "],
            answer: "C"
        },
        {
            question: "Q9. Which protocol is used for secure communication over a computer network?  ",
            options: ["A. HTTP", "B. FTP", "C. SSH", "D. Telnet"],
            answer: "C"
        },
        {
            question: "Q10. What is the subnet mask used for? ",
            options: ["A. To identify the network portion of an IP address ", "B. To identify the host portion of an IP address  ", "C. To convert IP addresses into domain names  ", "D. To encrypt data packets during transmission "],
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
