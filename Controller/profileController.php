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
    <title>Profile Update</title>
</head>
<body>
<?php include("../View/header.php");?>

<table id="about" border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#0f1e3e">

    <?php
    $username =$_SESSION['username'];
    $filename = '../Model/profiles/'.$username.'_profile/'.$username.".json";

    if(file_exists($filename) and filesize($filename)>0)
    {            
        $handle = fopen($filename, "r");
        $data = fread($handle, filesize($filename));
        $exploded = explode("\n",$data);
        $arr1 = array();

        for($i = 0; $i < count($exploded); $i++)
        {
            $decode = json_decode($exploded[$i],true);
            array_push($arr1,$decode);
        }
    }

    ?>


    <tr>
        <td>
            <table border="0" width="85%" cellpadding="10" cellspacing="0" align="center">


                <tr>
                    <td height="40" align="center" valign="middle" colspan="2">

                    <?php  
                        $username =$_SESSION['username'];
                        $filename = '../Model/profiles/'.$username.'_profile/'.$username.".json";   
                        $imagename = "";

                        if(file_exists($filename) and filesize($filename)>0)
                        {            
                            $handle = fopen($filename, "r");
                            $data = fread($handle, filesize($filename));
                            $exploded = explode("\n",$data);
                            $arr = array();

                            for($i = 0; $i < count($exploded); $i++)
                            {
                                $decode = json_decode($exploded[$i],true);
                                array_push($arr,$decode);
                            }
                        }

                                            
                        if($_SERVER['REQUEST_METHOD'] === "POST" and count($_REQUEST) > 0)
                        {                          

                            if(!empty($_FILES["fileToUpload"]["name"]))
                            {
                                
                                $target_dir = "../Model/profiles/".$username."_profile/";
                                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                $uploadOk = 1;
                                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                               
                                if(isset($_POST["submit"])) 
                                {
                                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                                        
                                    if($check !== false) 
                                    {
                                        $uploadOk = 1;
                                    } 
                                    else 
                                    {
                                        echo '<span align="center"><font color="#cc0000" size="3"><b>File is not an image</b></font></span><br>';
                                        $uploadOk = 0;
                                    }
                                }

                                if ($_FILES["fileToUpload"]["size"] > 1000000) 
                                {
                                    echo '<span align="center"><font color="#cc0000" size="3"><b>Sorry, your file is too large</b></font></span><br>';
                                    $uploadOk = 0;
                                }

                                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                                && $imageFileType != "gif" ) 
                                {
                                    echo '<span align="center"><font color="#cc0000" size="3"><b>Sorry, only JPG, JPEG, PNG & GIF files are allowed</b></font></span><br>';
                                    $uploadOk = 0;
                                }

                                if ($uploadOk == 0) 
                                {
                                    echo '<span align="center"><font color="#cc0000" size="3"><b>Sorry, the image can not be uploaded</b></font></span><br>';
                                } 
                                else 
                                {
                                   
                                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
                                    {
                                        $imagename =  htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));
                                        uploadInformation($arr);

                            
                                    } else 
                                    {
                                        echo '<span align="center"><font color="#cc0000" size="3"><b>Sorry, there was an error uploading the image</b></font></span><br>';
                                    }
                                }

                            }
                            else
                            {
                                uploadInformation($arr);                               
                            
                            }                       
                        }
                    

                        function uploadInformation($arr)
                        {
                            $bio = sanitize($_POST['bio']);
                            $edu = sanitize($_POST['edu']);  
                            $grade = sanitize($_POST['grade']);
                            $city = sanitize($_POST['city']);
                            global $username, $filename,$imagename;

                            if(strlen($_POST['bio'])>100)
                            {
                                echo '<span align="center"><font color="#cc0000" size="3"><b>Word limit max100 reached</b></font></span><br>';
                            }
                            else
                            {
                                for($i = 0; $i < count($arr); $i++)
                                {
                                    if(empty($bio) and !empty($arr[$i]['bio']))
                                    {
                                        $bio = $arr[$i]['bio'];
                                    }
                                    if(empty($edu) and !empty($arr[$i]['education']))
                                    {
                                        $edu = $arr[$i]['education'];
                                    }
                                    if(empty($grade) and !empty($arr[$i]['grade']))
                                    {
                                        $grade = $arr[$i]['grade'];
                                    }
                                    if(empty($city) and !empty($arr[$i]['city']))
                                    {
                                        $city = $arr[$i]['city'];
                                    }
                                    if(empty($imagename) and !empty($arr[$i]['image']))
                                    {
                                        $imagename = $arr[$i]['image'];
                                    }
                                }                        

                                if(empty($bio) and empty($edu) and  empty($grade) and empty($city) and empty($imagename))
                                {           
                                    
                                    header("location:../View/profile.php");  

                                }
                                else
                                {          
                                    $handle = fopen($filename,"w");
                                    $arr = array('username'=>$username,'bio'=>$bio,'education'=>$edu,'grade'=>$grade,'city'=>$city,'image'=>$imagename);
                                    $arr = json_encode($arr);
                                    fwrite($handle,$arr."\n");
                                    header("location:../View/profile.php");
                                }
                            }
                        }

                        function sanitize($data)
                        {
                        $data = trim($data);
                        $data = stripcslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                        }

                        ?>

                        <br><br><br><br><br>
                                            
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

                           <?Php
                                $noProfileImage = '../Model/res/no_profile_img.png';
                                $imagePath = empty($arr1[0]['image'])?$noProfileImage:'../Model/profiles/'.$username.'_profile/'.$arr1[0]['image'];

                                echo '<img src="'.$imagePath.'" alt="profile image" height="150" weidth="150">';
                            ?>
                               <br>
                               <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" enctype="multipart/form-data">
                               <input type="file" name=fileToUpload accept="image/*" >

                            <?php
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
                                    echo '<br><br>';
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
                                    <textarea name="bio" cols="160" rows="3" placeholder="Write about yourself"><?php echo empty($arr1[0]['bio'])?"":(isset($_POST['bio'])?$_POST['bio']:$arr1[0]['bio']); ?></textarea>
                                    <br>
                               </td>
                           </tr>
                       </table>

                    </td>
                </tr>

                <tr>
                    <td height = "100"> 
                       
                    </td>
                    <td align="left" valign="top" height = "100"> 
                       <table border="0" height ="100" width="100%" cellpadding="10" cellspacing="0" align="center"  bgcolor="#cce0ff">
                           <tr>
                           <td valign="top">                                
                                   <font face="ariel" size="4"><b>Education</b></font>    
                                   <hr>
                                   <span>Grade: </span>
                                   <select name="grade" id="grade">
                                        <?php
                                            $gradefilename = "../Model/res/gradeList.json";
                                         
                                            if(file_exists($gradefilename))
                                            {
                                                $handle = fopen($gradefilename, "r");
                                                $data = fread($handle, filesize($gradefilename));
                                                $exploded = explode("\n",$data); 
                                                $arr = array();

                                                for($i = 0; $i < count($exploded); $i++)
                                                {                                                                
                                                    $decode = json_decode($exploded[$i],true);
                                                    array_push($arr,$decode);
                                                    
                                                }
                                                
                                                for($i = 0; $i < count($arr); $i++)
                                                {                                                                
                                                    echo '<option value="'. $arr[$i]['grade'].'">';
                                                    echo  empty($arr[$i]['grade'])?"No Selection":$arr[$i]['grade'];
                                                    echo '</option>';
                                                }                                           

                                            }
                                                                        
                                        ?>
                                    </select>
                                    <br><br>
                                    <textarea name="edu" cols="160" rows="3" placeholder="Where do you currently study?"><?php echo empty($arr1[0]['education'])?"":(isset($_POST['education'])?$_POST['education']:$arr1[0]['education']); ?></textarea>
                                    <br>
                               </td>
                           </tr>
                       </table>
                    </td>
                </tr>

                <tr>
                    <td height = "100"> 
                       
                    </td>
                    <td align="left" valign="top" height = "100"> 
                    <table border="0" height ="100" width="100%" cellpadding="10" cellspacing="0" align="center"  bgcolor="#cce0ff">
                           <tr>
                           <td valign="top">                                
                                   <font face="ariel" size="4"><b>City</b></font>
                                   <hr>
                                   <select name="city" id="city">
                                        <?php
                                        $cityfilename = "../Model/res/cityList.json";
                                          if(file_exists($cityfilename))
                                          {
                                              $handle = fopen($cityfilename, "r");
                                              $data = fread($handle, filesize($cityfilename));
                                              $decode = json_decode($data,true);
                                              echo count($decode['districts']);
                                            
                                              for($i = 0; $i < count($decode['districts']); $i++)
                                              {
                                                                                                  
                                                echo '<option value="'.$decode['districts'][$i]['name'].'">';
                                                echo  empty($decode['districts'][$i]['name'])?"No selection":$decode['districts'][$i]['name'];
                                                echo '</option>';
                              
                                              }
                                          }   
                                    ?>
                                    </select>
                               </td>
                           </tr>
                       </table>
                    </td>
                </tr>

                <tr>
                    <td height="100">
                        
                    </td>
                    <td height="100" align="center" valign = "middle">
                            <input type="submit" name="submit" value="Update Profile">
                        </form>
                      
                    </td>
                </tr>

                <tr>
                    <td>
                          <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php include('../View/footer.php'); ?>

</body>
</html>