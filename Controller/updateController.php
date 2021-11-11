<?php 
    session_start();
        
    if(count($_SESSION)==0)
    {
        header("location:../Controller/logout.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
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
                <h2>Edit user information</h2>
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
                        
                                    if($arr[$j]['email'] === $_POST['email'] and $arr[$j]['username']!=$_SESSION['username'])
                                    {
                                        echo '<span align="center"><font color="#cc0000"><b>Email already exists</b></font></span>';
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
                            $username = $_SESSION['username'];
                            $email = sanitize($_POST['email']);  
                            $fname = sanitize($_POST['fname']);  
                            $lname = sanitize($_POST['lname']);  
                            $password = $_POST['pass'];
                            $conPassword = $_POST['conPass'];


                            for($j = 0; $j < count($arr); $j++)
                            {
                    
                                if(empty($password) and $arr[$j]['username']===$_SESSION['username'])
                                {
                                    $hash_password = $arr[$j]['password'];
                                    break;
                                }
                            
                            } 

                            if(!empty($password))
                            {
                                $hash_password = password_hash($password, PASSWORD_DEFAULT);                        
                            }

                    
                            if(empty($email))
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
                            else if($_POST['pass']!== $_POST['conPass'])
                            {
                                echo '<span align="center"><font color="#cc0000"><b>Password does not match</b></font></span>';
                            }
                            else
                            {
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
                                    if(!($userarray[$i]['username'] ==$_SESSION['username']))
                                    {
                                        $newUserArray = json_encode($userarray[$i]);
                                        fwrite($writter,$newUserArray."\n");
                                    }
                                }

                                $arr = array('username'=>$username,'email'=>$email,'firstname'=>$fname,'lastname'=>$lname,'password'=>$hash_password);
                                $arr = json_encode($arr);
                                fwrite($writter,$arr."\n");
                                echo '<h4 align = "center" style = "color:green">Profile Updated Successfully</h4>';
                                fclose($writter);
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

                <br><br>

                <?php

                    $dataFile = "../Model/users/data.json";

                if(file_exists($dataFile) and filesize($dataFile)>0)
                {
                    $handle = fopen($dataFile, "r");
                    $data = fread($handle, filesize($dataFile));
                    $exploded = explode("\n",$data);
                    $user = array();
                    $userdata = array();

                    for($i = 0; $i < count($exploded); $i++)
                    {

                            $decode = json_decode($exploded[$i],true);
                            array_push($user,$decode);

                    }

                    for($i = 0; $i < count($exploded); $i++)
                    {
                        if($_SESSION['username']==$user[$i]['username'])
                        {                      
                                array_push($userdata,$user[$i]);
                                break; 
                        }
                    }

                    }

                ?>

                    <div>
                    <span><font color="#cc0000"><b>*</b></font></span>
                    <label for="username">Username:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <input type="text" name="username" value = "<?php echo $_SESSION['username'];?>" readonly>
                    <br><br>

                    <span><font color="#cc0000"><b>*</b></font></span>
                    <label for="email">Enter an Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <input type="email" name="email" placeholder="Enter Your Email"  value = "<?php echo empty($userdata[0]['email'])?$_POST['email']:$userdata[0]['email'];?>">
                    <br><br>

                    
                    <span><font color="#cc0000"><b>*</b></font></span>
                    <label for="fname">Firstname:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <input type="text" name="fname" placeholder="Enter Your firstname" value = "<?php echo empty($userdata[0]['firstname'])?$_POST['fname']:$userdata[0]['firstname'];?>" >
                    <br><br>

                    <span><font color="#cc0000"><b>*</b></font></span>
                    <label for="lname">Lastname:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <input type="text" name="lname" placeholder="Enter Your lastname"  value = "<?php echo empty($userdata[0]['lastname'])?$_POST['lname']:$userdata[0]['lastname'];?>">
                    <br><br>

                    <span><font color="#cc0000"><b>*</b></font></span>
                    <label for="pass">Password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <input type="password" name="pass" placeholder="Enter a password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" >
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
                Back to<a href="../View/profile.php">Profile</a>
                <br><br><br>
            </td>   
        </tr>
    </table>

</body>

</html>