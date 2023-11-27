<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mainPage.css">
    <title>Teacher Home</title>
    <style>
        .view-profile, .logout {
            font-size: 20px;
            background-color: transparent;
            border: 0px solid;
            padding: 5px;
            margin-right: 25px;
        }
        .view-profile:hover, .logout:hover {
            background-color: transparent;
            cursor: pointer;
        }
        .links {    
            position: absolute;
            right: 8%;
        }
        .logout:active{
            color: red;
        }
        .classes {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .create-class {
            margin-top: 25px;
        }
        .classes span { 
            width: 17%;
        }
        @media (max-width: 1200px){
            .links{
                right: 6%;
            }
        }
        @media (max-width: 950px){
            .classes span {
                flex: 38%;
            }
            .links{
                right: 0%;
            }
        }
        @media (max-width: 768px){
            .links{
                display: flex;
            }
        }
        @media (max-width: 600px){
            .classes span {
                flex: 80%;
            }
        }

    </style>
</head>
<body>
    <nav class="navbar">
        <span>STUDY ROOM</span>
        <span class="links">
            <button class="view-profile" id="view-profile">View Profile</button>
            <button class="logout" id="logout">Logout</button>
        </span>
    </nav><br><br>
    <div class="container">
        <div class = "teacher-home">
            <button class="create-class app-button">Create Class</button>
            <div class="classes" id="classes"></div>
        </div>
    </div>
    <?php
        session_start();
        if(!isset($_SESSION['log_email']) && $_SESSION['log_email']!=""){
            header("location:mainPage.php");
        }
        require("./connection.php");
        if(! $conn ) {
            die('Could not connect: ' . mysqli_connect_error());
        }
        $sql = "select C_id, C_Name, subject from class where T_id = 
            (select T_id from teacher where Email='".$_SESSION['log_email']."')";
        $res = mysqli_query($conn, $sql);
        $arr = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $new_arr = json_encode($arr);
        
    ?>
    <script>
        document.getElementById("view-profile").onclick = function(){
            var name='<?=$_SESSION['log_name']?>';
            var email='<?=$_SESSION['log_email']?>';
            alert("\nName: "+name +"\n\nEmail-id: "+email);
        }
        document.getElementById("logout").onclick = function(){
            var url = "logout.php";
            window.location.href = url;
        }
        document.querySelector(".create-class").onclick = function(){
            window.location.href = "createClass.php";
        }

        var classes = <?= $new_arr?>;
        classes.forEach(element => {
            var classHeading = document.createElement('h1');
            var link = document.createElement('a');
            link.textContent=element.C_Name;
            link.href = "teacherClassPage.php?class_id="+element.C_id;
            link.style.color = "#000";
            link.style.textDecoration = "none";
            classHeading.appendChild(link);
            var subName = document.createElement('h3');
            subName.textContent = element.subject;
            subName.style.color = "white";
            subName.style.fontFamily = "Arial";
            classHeading.style.fontSize = "3.5vh";
            subName.style.fontSize = "2.25vh";
            span=document.createElement('span');
            span.setAttribute("id",element.C_id);
            span.style.padding = "3%";
            span.style.margin = "2%";
            span.style.width = "12%";
            span.style.backgroundColor = "#f99245";
            span.style.borderRadius = "8px";
            classHeading.style.wordWrap = "break-word";
            subName.style.wordWrap = "break-word";
            span.appendChild(classHeading);
            span.appendChild(subName);
            document.getElementById("classes").appendChild(span);
            console.log(span);
        });
        // if(classes.length % 4 != 0){
        //     temp = classes.length % 4;
        //     x=document.getElementsByClassName("classes");
        //     for(var i = 1; i <= temp; i++ ){
        //         for(var j =0; j<x.lenght; j++){
        //             if(j == classes.length - i){
        //                 if (window.matchMedia("(max-width: 700px)").matches) {
        //                     x[j].style.width = "17%";
        //                 }
        //             }
        //         }
        //     } 
        // }
    </script>
</body>
</html>