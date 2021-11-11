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
    <title>Password</title>
</head>

<body bgcolor="#0f1e3e">
   
    <div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST" align = "center">
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#c1d0f0">
        <tr>
            <td>
                <br>
                <h2>Enter your password</h2>
                <div>
                <?php

                    if ($_SERVER['REQUEST_METHOD']==="POST")
                    {   
                        $flag = false;
                        $dataFile = "../Model/users/data.json";
                        $flag = false;

                        $password = sanitize($_POST['pass']);

                        if(empty($password))
                        {
                            echo '<span align="center"><font color="#cc0000"><b>Please enter your password</b></font></span>';

                        }
                        else
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
                        
                                    if($arr[$j]['username'] === $_SESSION['username'])
                                    {                    
                                        if(password_verify($password, $arr[$j]['password']))
                                        {
                                            $flag = true;                                    
                                        }
                                    }                      
                            
                                }
                                if($flag==true)
                                {
                                header("location:updateController.php");
                                }
                                else
                                {
                                    echo '<span align="center"><font color="#cc0000"><b>Passowrd Incorrect</b></font></span>';
                                }

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
                <input type="password" name="pass" placeholder="Enter a password" size="40" >
                <br><br><br>
                <input type="submit" id="submitButton" name="submit">
                <br><br>
                </form>
                <a href="../View/findAccount.php">Forgot Password?</a>
                <br>
                <br>
                <br>
            </td>   
        </tr>
    </table>
</body>

</html>