<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin</title>
</head>

<body bgcolor="#0f1e3e">
   
<div>
    <br><br><br><br><br><br>
</div>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST" align = "center">
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#c1d0f0">
    <tr>
        <td>
 
        <br>
        <h1>Registration Form</h1>
        <div>
        <?php

            if ($_SERVER['REQUEST_METHOD']==="POST")
            {   
                $flag = false;
                $dataFile = "../Model/users/data.json";

                if($flag==false)
                {
                    if(file_exists($dataFile) and filesize($dataFile)>0)
                    {

                        $handle = fopen($dataFile, "r");
                        $data = fread($handle, filesize($dataFile));
                        $exploded = explode("\n",$data);
                        $arr = array();

                        for($i = 0; $i < count($exploded); $i++)
                        {
                            $decode = json_decode($exploded[$i],true);
                            array_push($arr,$decode);
                        }

                        for($j = 0; $j < count($arr); $j++)
                        {
                
                            if($arr[$j]['username'] === $_POST['username'] and !($arr[$j]['email'] === $_POST['email'] ))
                            {                    
                                echo '<span align="center"><font color="#cc0000"><b>Username already exists</b></font></span>';
                                break;
                            }
                            else if($arr[$j]['email'] === $_POST['email'] and !($arr[$j]['username'] === $_POST['username']))
                            {
                                echo '<span align="center"><font color="#cc0000"><b>Email already exists</b></font></span>';
                                break;
                            }
                            else if($arr[$j]['username'] === $_POST['username'] and $arr[$j]['email'] === $_POST['email'])
                            {
                                echo '<span align="center"><font color="#cc0000"><b>Username & email already exists</b></font></span>';
                                break;
                            }
                            if($j==count($arr)-1)
                            {
                                $flag = true;
                            }                        
                    
                        }


                    }else
                    {
                        $flag = true;
                    } 
                }
                if($flag == true)
                {    
                
                    $username = sanitize($_POST['username']);
                    $email = sanitize($_POST['email']);  
                    $fname = sanitize($_POST['fname']);  
                    $lname = sanitize($_POST['lname']);  
                    $password = sanitize($_POST['pass']);
                    $conPassword = sanitize($_POST['conPass']);
                    $que = sanitize($_POST['que']);
                    $ans = sanitize($_POST['ans']);

                if($_POST['pass']!== $_POST['conPass'])
                {
                    echo '<span align="center"><font color="#cc0000"><b>Password does not match</b></font></span>';
                }
                else if (empty($username))
                {
                    echo '<span align="center"><font color="#cc0000"><b>Please enter your username</b></font></span>';

                }
                else if(empty($email))
                {
                    echo '<span align="center"><font color="#cc0000"><b>Please enter your email</b></font></span>';
                } 
                else if(empty($fname))
                {
                    echo '<span align="center"><font color="#cc0000"><b>Please enter your firstname</b></font></span>';
                }  
                else if(empty($lname))
                {
                    echo '<span align="center"><font color="#cc0000"><b>Please enter your lastname</b></font></span>';
                }   
                else if(empty($password))
                {
                    echo '<span align="center"><font color="#cc0000"><b>Please enter your password</b></font></span>';

                }
                else if(empty($conPassword))
                {           
                    echo '<span align="center"><font color="#cc0000"><b>Please confirm your password</b></font></span>';
                }
                else if(empty($que))
                {           
                    echo '<span align="center"><font color="#cc0000"><b>Please enter a security question</b></font></span>';
                }
                else if(empty($ans))
                {           
                    echo '<span align="center"><font color="#cc0000"><b>Please write your answer</b></font></span>';
                }
                else
                {
                    $dir = "../Model/profiles/".$username."_profile";
                    mkdir($dir, 0700);
                    $hash_password = password_hash($password, PASSWORD_DEFAULT);
                    $hash_answer = password_hash($ans, PASSWORD_DEFAULT);

                    $dataHandle = fopen($dataFile,"a");
                    $profileHandle = fopen($dir.'/'.$username.".json","a");
                    $securityHandle = fopen($dir.'/'.$username."_sec.json","a");

                    $arr = array('username'=>$username,'email'=>$email,'firstname'=>$fname,'lastname'=>$lname,'password'=>$hash_password);
                    $sec = array('username'=>$username,'que'=>$que,'ans'=>$hash_answer);

                    $arr = json_encode($arr);
                    $sec = json_encode($sec);

                    fwrite($dataHandle,$arr."\n");
                    fwrite($profileHandle,"");
                    fwrite($securityHandle,$sec."\n");

                    echo '<h4 align = "center" style = "color:green">Registration Successful</h4>';
                }
            }
            }

            function sanitize($data){
            $data = trim($data);
            $data = stripcslashes($data);
            $data = htmlspecialchars($data);
            return $data;
            }

            ?>
        </div>

        <br>
        <br>

        <div>
        <span><font color="#cc0000"><b>*</b></font></span>
        <label for="username">Enter Username:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <input type="text" name="username" placeholder="Enter Your Username" value = <?php echo isset($_POST['username'])?$_POST['username']:"";?> >
        <br><br>

        <span><font color="#cc0000"><b>*</b></font></span>
        <label for="email">Enter an Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <input type="email" name="email" placeholder="Enter Your Email"  value = <?php echo isset($_POST['email'])?$_POST['email']:"";?>>
        <br><br>

        
        <span><font color="#cc0000"><b>*</b></font></span>
        <label for="fname">Enter your firstname:&nbsp;&nbsp;</label>
        <input type="text" name="fname" placeholder="Enter Your firstname" value = <?php echo isset($_POST['fname'])?$_POST['fname']:"";?> >
        <br><br>

        <span><font color="#cc0000"><b>*</b></font></span>
        <label for="lname">Enter your lastname:&nbsp;&nbsp;&nbsp;</label>
        <input type="text" name="lname" placeholder="Enter Your lastname"  value = <?php echo isset($_POST['lname'])?$_POST['lname']:"";?>>
        <br><br>

        <span><font color="#cc0000"><b>*</b></font></span>
        <label for="pass">Enter Password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <input type="password" name="pass" placeholder="Enter a password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" value = <?php echo isset($_POST['pass'])?$_POST['pass']:"";?>>
        <br><br>

        <span><font color="#cc0000"><b>*</b></font></span>
        <label for="conPass">Confirm password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <input type="password" name="conPass" placeholder="Re-enter the password"  value = <?php echo isset($_POST['conPass'])?$_POST['conPass']:"";?>>
        <br><br>

        <span><font color="#cc0000"><b>*</b></font></span>
        <label for="que">Security Question:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <input type="text" name="que" placeholder="Question to reset password"  value = <?php echo isset($_POST['que'])?$_POST['que']:"";?>>
        <br><br>

        <span><font color="#cc0000"><b>*</b></font></span>
        <label for="ans">Answer:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <input type="text" name="ans" placeholder="Answer to reset password"  value = <?php echo isset($_POST['ans'])?$_POST['ans']:"";?>>
        <br><br>
        </div> 
        <br><br>
        <input type="submit" id="submitButton" name="submit">
        <br><br>
        </form>

        <h4 align="center">Already registered?  <a href="login.php">Log In</a></h4>
        <br>

</td>   

</tr>


</table>
  
<?php include('footer.php'); ?>   

</body>

</html>