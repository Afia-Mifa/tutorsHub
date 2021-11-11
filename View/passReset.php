<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passowrd Reset</title>
</head>

<body bgcolor="#0f1e3e">
<div>
    <br><br><br><br><br><br><br><br><br><br><br><br>
</div>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST" align = "center">
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#c1d0f0">
        <tr>
            <td>
                <br>
                <h2>Reset Password</h2>
                <div>

                <?php
                    if ($_SERVER['REQUEST_METHOD']==="POST")
                    {   
                        $dataFile = "../Model/users/data.json";
                        $password = $_POST['pass'];
                        $conPassword = $_POST['conPass'];
                        $username =$_COOKIE['user'];
                        $email ="";
                        $fname ="";
                        $lname ="";
                        $lname ="";

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
                    
                                if($arr[$j]['username'] === $username)
                                {
                                    $email = $arr[$j]['email'];
                                    $fname = $arr[$j]['firstname'];
                                    $lname = $arr[$j]['lastname'];
                                    break;
                                }
                            }

                            if(empty($password))
                            {
                                echo '<span align="center"><font color="#cc0000"><b>Please enter a password</b></font></span>';
                                                                                        
                            }
                            else if($_POST['pass']!== $_POST['conPass'])
                            {
                                echo '<span align="center"><font color="#cc0000"><b>Password does not match</b></font></span>';
                            }
                            else
                            { 
                                $hash_password = password_hash($password, PASSWORD_DEFAULT);

                                //Remove existing data from the file
                                $data = file_get_contents("../Model/users/data.json");
                                $exploded = explode("\n",$data);
                                $userarray = array(); 
                                $newUserArray = array(); 


                                for($i=0;$i<count($exploded)-1;$i++)
                                {
                                    $decoded = json_decode($exploded[$i],true);
                                    array_push($userarray,$decoded);
                                }

                                $contents = fopen("../Model/users/data.json","w");
                                fwrite($contents,"");
                                fclose($contents);
                                $writter = fopen("../Model/users/data.json","a");

                                for($i=0;$i<count($userarray);$i++)
                                {
                                    if(!($userarray[$i]['username'] == $username))
                                    {
                                        $newUserArray = json_encode($userarray[$i]);
                                        fwrite($writter,$newUserArray."\n");
                                    }
                                }

                                $arr = array('username'=>$username,'email'=>$email,'firstname'=>$fname,'lastname'=>$lname,'password'=>$hash_password);
                                $arr = json_encode($arr);
                                fwrite($writter,$arr."\n");
                                echo '<h4 align = "center" style = "color:green">Password Updated Successfully</h4>';
                                setcookie('user','',time() - 86400);
                                fclose($writter);
                            }
                        }
                    }

                    ?>
                </div>

                <br><br>
                    <div>
                    <span><font color="#cc0000"><b>*</b></font></span>
                    <label for="pass">Password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <input type="password" name="pass" placeholder="Enter a password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 6 or more characters">
                    <br><br>

                    <span><font color="#cc0000"><b>*</b></font></span>
                    <label for="conPass">Confirm password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <input type="password" name="conPass" placeholder="Re-enter the password">
                    <br><br>
                    </div> 
                    <br><br>
                    <input type="submit" id="submitButton" name="submit">
                    <br><br>
                </form>
                <br>
                Back to<a href="../View/login.php">Login</a>
                <br><br><br>
            </td>   
        </tr>
    </table>

</body>

</html>