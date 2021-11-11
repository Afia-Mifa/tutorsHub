<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body bgcolor="#0f1e3e">

<div>
    <br><br><br><br><br><br><br><br><br><br><br>
  
</div>
    <table  border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#c1d0f0">
        <tr>
            <td>
                <form action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" align="center">
            
                    <div align = "center">
                    <font face="ariel" size="4">
                    <br>
                    <h1>Log In</h1>
                    <?php

                        if($_SERVER['REQUEST_METHOD'] === "POST" and count($_REQUEST) > 0)
                        {
                            $count = 0;
                            $username = $_POST['username'];
                            $password = $_POST['password'];
                            $datafilename = "../Model/users/data.json";

                            if (empty($username))
                            {
                                echo '<span align="center"><font color="#cc0000"><b>Please enter your username</b></font></span><br>';
            
                            }
                            else if(empty($password))
                            {
                                echo '<span align="center"><font color="#cc0000"><b>Please enter your password</b></font></span><br>';
                            }
                            else
                            { 

                                if(file_exists($datafilename) and filesize($datafilename)>0)
                                {
                                    
                                    $handle = fopen($datafilename, "r");
                                    $data = fread($handle, filesize($datafilename));
                                    $exploded = explode("\n",$data);
                                    $arr = array();

                                    for($i = 0; $i < count($exploded); $i++)
                                    {
                                        $decode = json_decode($exploded[$i],true);
                                        array_push($arr,$decode);
                                    }
                                    for($j = 0; $j < count($arr)-1; $j++)
                                    {
                            
                                        if($arr[$j]['username'] === $username and  password_verify($password, $arr[$j]['password']))
                                        {   
                                            session_start();
                                            $_SESSION['username'] = $username;                 
                                            header("Location: profile.php");
                                        }
                                        else
                                        {
                                            $count++;
                                        }
                                
                                    } 
                                    if($count == count($arr)-1)
                                    {
                                        echo '<span align="center"><font color="#cc0000" size="3"><b>Incorrect username or password</b></font></span><br>';
                                    }
                                }
                                else
                                {
                                    echo '<span align="center"><font color="#cc0000" size="3"><b>Unknown error occured</b></font></span><br>';

                                }  
                            }          
                                
                        }
                        ?>

                    <br>
                    <font face="ariel" size="4"> Username:&nbsp;</font>
                     <input type="text" name="username" placeholder="Enter your username" size="23" value="<?php  echo empty($_POST['username'])?'':$_POST['username']; ?>"autofocus>
                    <br><br>
                    <font face="ariel" size="4" >Password:&nbsp;&nbsp;</font>
                    <input type="password" name="password" placeholder="Enter your password" size="23">    
                    <br><br><br>    
                    <input type="submit" name="Login" value="Log In">
                    <br><br>
                    
                    <a href="../View/findAccount.php">Forgot Password?</a>     
                    <br><br>
                    <h4>Not registered? <a href="signIn.php">Sign In</a></h4>
                    <br> 
                    </font>  
                    </div>
                  
                </form>         
            </td>  
        </tr>  
 </table>

 <footer><?php include('footer.php');?></footer>   
    
</body> 

</html>