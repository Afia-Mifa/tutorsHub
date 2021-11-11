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
    <title>Profile</title>
</head>
<body>
    <?php include("header.php");?>
    <?php  
    $username =$_SESSION['username'];
    $filename = '../Model/profiles/'.$username.'_profile/'.$username.".json";

    if(file_exists($filename) and filesize($filename)>0)
    {            
        $handle = fopen($filename, "r");
        $data = fread($handle, filesize($filename));
        $exploded = explode("\n",$data);
        $userData = array();

        for($i = 0; $i < count($exploded); $i++)
        {
            $decode = json_decode($exploded[$i],true);
            array_push($userData,$decode);
        }
    }
    ?>

    <table id="about" border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#0f1e3e">
        <tr>
            <td>

                <table border="0" width="85%" cellpadding="10" cellspacing="0" align="center">
                    <tr>
                        <td height="50" align="center" valign="middle" colspan="2">
                            &nbsp;                                                
                        </td>
                    </tr>

                    <tr>
                        <td width="4%" height="60">
                            &nbsp;
                        </td>

                        <td align="left">
                            <table  border="0" width="100%" cellpadding="20" cellspacing="0" align="center" bgcolor="#cce0ff">
                                <tr>
                                    <td>
                                        <?php

                                        $noProfileImage = '../Model/res/no_profile_img.png';
                                        $imagePath = empty($userData[0]['image'])?$noProfileImage:'../Model/profiles/'.$username.'_profile/'.$userData[0]['image'];

                                        echo '<img src="'.$imagePath.'" alt="profile image" height="150" weidth="150">';
 
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
                                        }


                                        for($i=0;$i<count($arr)-1;$i++)
                                        {

                                            if($arr[$i]['username'] == $_SESSION['username'])
                                            {           
                                                                 
                                                echo '<br><br>';
                                                echo '<font face="arial" color="#000000" size="7">';
                                                echo $arr[$i]['firstname'].' '.$arr[$i]['lastname'];
                                                echo '</font>';
                                                echo '<br>';
                                                echo '<font face="arial" color="#3366ff" size="4">';
                                                echo '@'.$_SESSION['username'];
                                                echo '</font>';
                                                echo '<br><br>';
                                            }
                                        }
                                        ?>

                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <tr>
                        <td height = "100"> 
                           
                        </td>

                        <td align="left" valign="bottom" height = "100"> 

                           <table border="0" height ="100" width="100%" cellpadding="10" cellspacing="0" align="center"  bgcolor="#cce0ff">
                               <tr>
                                   <td valign="top">                                
                                       <font face="ariel" size="4"><b>Bio</b></font>
                                       <hr>
                                       <span><?php echo empty($userData[0]['bio'])?"":$userData[0]['bio'];?></span>
                                   </td>
                               </tr>
                           </table>

                        </td>
                    </tr>

                    <tr>
                        <td height = "100"> 
                            &nbsp;
                        </td>
                        <td align="left" valign="top" height = "100"> 

                           <table border="0" height ="100" width="100%" cellpadding="10" cellspacing="0" align="center"  bgcolor="#cce0ff">
                               <tr>
                               <td valign="top">                                
                                       <font face="ariel" size="4"><b>Education</b></font>
                                       <hr>
                                       <span><?php echo empty($userData[0]['education'])?'':(empty($userData[0]['grade'])?$userData[0]['education']:'Grade<b> '.$userData[0]['grade'].'</b>'.' at <b>'.$userData[0]['education'].'</b>');?></span>
                                </td>
                               </tr>
                           </table>

                        </td>
                    </tr>

                    <tr>
                        <td height = "100"> 
                            &nbsp;
                        </td>

                        <td align="left" valign="top" height = "100"> 

                            <table border="0" height ="100" width="100%" cellpadding="10" cellspacing="0" align="center"  bgcolor="#cce0ff">
                               <tr>
                                <td valign="top">                                
                                    <font face="ariel" size="4"><b>City</b></font>
                                    <hr>
                                    <span><?php echo empty($userData[0]['city'])?"":$userData[0]['city'];?></span>
                                </td>
                               </tr>
                           </table>

                        </td>
                        
                    </tr>

                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>

                            <table border="0" height ="100" width="100%" cellpadding="40" cellspacing="0" align="center">
                                <tr>
                                    <td height="80" align="right" valign = "middle">
                                    <form action="../Controller/profileController.php" method="GET">
                                            <input type="submit" name="editProfile" value="Edit Profile Information">
                                        </form> 
                                    </td>

                                    <td align="left" valign = "middle">
                                    <form action="../Controller/passwordController.php" method="GET">
                                            <input type="submit" name="editPass" value="Edit User Information">
                                        </form>      
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table> 

    <?php include('footer.php'); ?>

</body>
</html>