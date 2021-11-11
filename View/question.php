<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question</title>
</head>
<body bgcolor="#0f1e3e">

<div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br>
  
</div>
    <table  border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#c1d0f0">
        <tr>
            <td>
                <form action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" align="center">
                    <div align = "center">
                    <font face="ariel" size="4">
                    <br>
                    <br>
                    <br>

                    <?php 
                
                            $count = 0;
                            $username = $_COOKIE['user'];

                            $datafilename = '../Model/profiles/'.$username.'_profile/'.$username.'_sec.json';

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
                                      echo '<span> <font face="ariel" size="4">'.$arr[$j]['que'].'</font></span>';
                                      echo "<br>";                                       
                                    }
                                    else
                                    {
                                        $count++;
                                    }
                            
                                } 
                                if($count == count($arr)-1)
                                {
                                    echo '<span align="center"><font color="#cc0000" size="3"><b>Unknown Error Occured</b></font></span><br>';
                                }
                            } 

    
                        if($_SERVER['REQUEST_METHOD'] === "POST" and count($_REQUEST) > 0)
                        {
                            $count = 0;
                            $ans = $_POST['ans'];
                            $username = $_COOKIE['user'];
                            $datafilename = '../Model/profiles/'.$username.'_profile/'.$username.'_sec.json';
;

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
                        
                                    if(password_verify($ans,$arr[$j]['ans']))
                                    {  

                                        header("location:passReset.php");        
                                    }
                                    else
                                    {
                                        echo '<span align="center"><font color="#cc0000" size="3"><b>We can not verify you</b></font></span><br>';
                                    }
                                } 
                        
                            }
                        }
                        ?>

                    <br>

                     <input type="text" name="ans" placeholder="Enter answer" size="30" required autofocus>
                    <br><br><br>
                    <input type="submit" name="Login" value="Submit">
                    <br><br><br> 

                    </font>  
                    </div>
                  
                </form>         
            </td>  
        </tr>   
 </table>      
      
 <?php //include('footer.php');?>
    
</body>
</html>