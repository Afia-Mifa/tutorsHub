<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Account</title>
</head>
<body bgcolor="#0f1e3e">

<table  border="0"  width="100%" cellpadding="0" cellspacing="0"  bgcolor="#0f1e3e">
    <tr>
        <td> 
            <tr>
                <td>
                    <br><br><br><br><br><br><br><br><br><br><br><br>
                </td>
            </tr>
            <table  border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#c1d0f0">
                <tr>
                    <td>
                        <form action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" align="center">
                    
                            <div align = "center">
                            <font face="ariel" size="4">
                            <br><br><br>
                            <h2>Search your account</h2>

                            <?php

                                if($_SERVER['REQUEST_METHOD'] === "POST" and count($_REQUEST) > 0)
                                {
                                 
                                    $count = 0;
                                    $username = $_POST['username'];
                                    $datafilename = "../Model/users/data.json";

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
                                
                                            if($arr[$j]['username'] === $username)
                                            {  
                                                setcookie("user",$username,time()+86400);
                                                header("location:question.php");                                        
                                            }
                                            else
                                            {
                                                $count++;
                                            }
                                    
                                        } 
                                        if($count == count($arr)-1)
                                        {
                                            echo '<span align="center"><font color="#cc0000" size="3"><b>No account found with this username</b></font></span><br>';
                                        }
                                    }             
                                        
                                } 
                                ?>

                            <br>
                            <font face="ariel" size="4"> Username:&nbsp;</font>
                            <input type="text" name="username" placeholder="Enter your username" size="23" required autofocus>
                            <br><br><br>
                            <input type="submit" name="Login" value="Search">
                            <br><br>
                            </font>  
                            </div>
                        
                        </form>
                        <br><br><br>         
                    </td>  
                </tr>

                <tr>
                    <td height="100">

                    </td>
                </tr>

            </table>

        </td>   
    </tr> 

    <tr>
        <td>  
            <?php include('footer.php');?> 
        </td>
    </tr>
</table>    

    
</body>
</html>