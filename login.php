<?php 
    session_start();
    require_once("connection.php");
    if(! $conn ) {
        die('Could not connect: ' . mysqli_connect_error());
    }
    if(isset($_POST['login-email'])&&isset($_POST['login-password'])
        && $_POST['login-email']!="" && $_POST['login-password']!=""){
        $tMailsResult = mysqli_query($conn, "select Email from Teacher");
        $sMailsResult = mysqli_query($conn, "select Email from Student");
        $tMails = mysqli_fetch_all($tMailsResult,MYSQLI_NUM);
        $sMails = mysqli_fetch_all($sMailsResult,MYSQLI_NUM);
        $email = $_POST['login-email'];
        $password = $_POST['login-password'];
        
        $flag=0;

        foreach($tMails as $value){
            foreach($value as $val){
                if($val==$email){
                    $flag=1;
                    $res=mysqli_query($conn, "select * from teacher where Email='".$email."' and Pass='".$password."'");
                    $passwordDB = mysqli_fetch_assoc($res);
                    $login_id = $passwordDB['T_id'];
                    $login_name = $passwordDB['T_Name'];
                    unset($_POST);
                    if($passwordDB){
                        $_SESSION['log_id'] = $login_id;
                        $_SESSION['log_name'] = $login_name;
                        $_SESSION['log_email'] = $email;
                        $_SESSION['log_pass'] = $password;
                        header("location:teacherHomePage.php");
                    }
                    else{
                        header("location:mainPage.php");
                    }
                }
            }    
        }
        foreach($sMails as $value){
            foreach($value as $val){
                if($val==$email){
                    $flag=1;
                    $res=mysqli_query($conn, "select * from student where Email='".$email."' and Pass='".$password."'");
                    $passwordDB = mysqli_fetch_assoc($res);
                    $login_id = $passwordDB['S_id'];
                    $login_name = $passwordDB['S_Name'];
                    unset($_POST);
                    if($passwordDB){
                        $_SESSION['log_id'] = $login_id;
                        $_SESSION['log_name'] = $login_name;
                        $_SESSION['log_email'] = $email;
                        $_SESSION['log_pass'] = $password;
                        header("location:studentHomePage.php");
                    }
                    else{
                        header("location:mainPage.php");
                    }
                }
            }
        }
        if($flag==0){
            header("location:mainPage.php");
        }
    }
    else{
        header("location:mainPage.php");
    }
?>