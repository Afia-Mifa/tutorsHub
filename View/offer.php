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
    <title>Offer</title>
</head>
<body  bgcolor="#0f1e3e">
<?php include('header.php');?>

    <table id="about" border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>

                <table border="0" width="85%" cellpadding="15" cellspacing="0" align="center">
                    
                    <tr>
                        <td height="80" align="center" valign="middle" colspan="2">
                            
                                <font face="arial" color="#ffffff" size="6">
                                <h4>Fill up the form with your information to send an offer</h4>
                                </font>

                                <?php
                                

                                    if ($_SERVER['REQUEST_METHOD']==="POST")
                                    {   
                                    
                                        $flag = false;
                                        if($flag==false)
                                        {
                                            $filename = '../Model/offers/offers.json';
                                            if(file_exists($filename) and filesize($filename)>0)
                                            {

                                                $handle = fopen($filename, "r");
                                                $data = fread($handle, filesize($filename));
                                                $exploded = explode("\n",$data);
                                                $arr = array();
                                                $sub = array();

                                                for($i = 0; $i < count($exploded); $i++)
                                                {
                                                    $decode = json_decode($exploded[$i],true);
                                                    array_push($arr,$decode);
                                                }

                                                for($j = 0; $j < count($arr); $j++)
                                                {
                                        
                                                    if($arr[$j]['studentUsername'] === $_POST['stdUsername'] and $arr[$j]['mediaUsername']==$_POST['medUsername'])
                                                    {                    
                                                        echo '<h3 align = "center" style = "color:red">You have already sent an offer</h3>';
                                                        break;
                                                    }
                                                    if($j==count($arr)-1)
                                                    {
                                                        $flag = true;
                                                    }                        
                                            
                                                }

                                            }
                                            else
                                            {
                                                $flag = true;

                                            } 
                                        }
                                        if($flag == true)
                                        {    
                                        
                                            $medUsername = sanitize($_POST['medUsername']);
                                            $stdUsername = sanitize($_POST['stdUsername']);
                                            $medEmail = sanitize($_POST['medEmail']);  
                                            $stdEmail = sanitize($_POST['stdEmail']);  

                                            $fname = sanitize($_POST['fname']);  
                                            $lname = sanitize($_POST['lname']);  
                                            $dob = sanitize($_POST['dob']);  
                                           

                                            $city = sanitize($_POST['city']);  
                                            $area = sanitize($_POST['area']);  
                                            $phone = sanitize($_POST['phoneNo']);

                                            $heading = sanitize($_POST['heading']);  
                                            $grade = sanitize($_POST['grade']);  
                                            $catagory = sanitize($_POST['cat']);  
                                            $salary = sanitize($_POST['salary']); 
                                            $timeStart = sanitize($_POST['timeStart']);
                                            $timeEnd = sanitize($_POST['timeEnd']);
  
                                            $postKeys = array();
                                            $postKeys = array_keys($_POST);
                                            $sub = array();   
                                            $days = array();

                                            for($j=0; $j< count($postKeys); $j++)
                                            {
                                                if($_POST[$postKeys[$j]]=="on")
                                                {
                                                    array_push($sub,$postKeys[$j]);
                                                }
                                            }

                                            for($j=0; $j< count($postKeys); $j++)
                                            {
                                                if($_POST[$postKeys[$j]]=="check")
                                                {
                                                    array_push($days,$postKeys[$j]);
                                                }
                                            }
                                            
                                            if(empty($fname))
                                            {           
                                                echo '<h3 align = "center" style = "color:red">Please enter your firstname</h3>';
                                            }
                                            else if(empty($lname))
                                            {           
                                                echo '<h3 align = "center" style = "color:red">Please enter your lastname</h3>';
                                            }
                                            else if(!isset($_POST['gender']))
                                            {           
                                                echo '<h3 align = "center" style = "color:red">Please select your gender</h3>';
                                            }
                                            else if(empty($dob))
                                            {           
                                                echo '<h3 align = "center" style = "color:red">Please select your date of birth</h3>';

                                            }
                                            else if(empty($city))
                                            {           
                                                echo '<h3 align = "center" style = "color:red">Please enter your city</h3>';
                                            }
                                            else if(empty($area))
                                            {           
                                                echo '<h3 align = "center" style = "color:red">Please enter your area</h3>';
                                            }
                                            else if(empty($phone))
                                            {           
                                                echo '<h3 align = "center" style = "color:red">Please enter your phone number</h3>';
                                            }  
                                            else if(empty($heading))
                                            {           
                                                echo '<h3 align = "center" style = "color:red">Please give a heading for your offer</h3>';
                                            }
                                            else if(empty($grade))
                                            {           
                                                echo '<h3 align = "center" style = "color:red">Please enter your grade</h3>';
                                            }
                                            else if(empty($catagory))
                                            {           
                                                echo '<h3 align = "center" style = "color:red">Please a catagory</h3>';
                                            }
                                            else if(empty($salary))
                                            {           
                                                echo '<h3 align = "center" style = "color:red">Please enter a slalary for tutor</h3>';
                                            }      
                                            else if(count($sub)<1)
                                            {
                                                echo '<h3 align = "center" style = "color:red">Minimum 1 subject must be selected</h3>';
                                            }
                                            else if(count($days)<1)
                                            {
                                                echo '<h3 align = "center" style = "color:red">Minimum 1 subject day be selected</h3>';
                                            }
                                            else if(empty($timeStart))
                                            {           
                                                echo '<h3 align = "center" style = "color:red">Please enter a starting time</h3>';
                                            }
                                            else if(empty($timeEnd))
                                            {           
                                                echo '<h3 align = "center" style = "color:red">Please enter an ending time</h3>';
                                            }                                     
                                            else
                                            {
                                                $gender = $_POST['gender'];
                                                $timing = $timeStart."-".$timeEnd;      
                                                $handle = fopen($filename,"a");
                                                $arr = array('heading'=>$heading,'studentUsername'=>$stdUsername,'studentEmail'=>$stdEmail,'mediaUsername'=>$medUsername,'mediaEmail'=>$medEmail,
                                                'firstName'=>$fname,'lastName'=>$lname,'gender'=>$gender,'dob'=>$dob,'city'=>$city,'area'=>$area,'phone'=>$phone,
                                                'subject'=>$sub,'grade'=>$grade,'catagory'=>$catagory,'salary'=>$salary,'days'=>$days,'timing'=>$timing,'status'=>'active');
                                                $arr = json_encode($arr);
                                                fwrite($handle,$arr."\n");
                                                echo '<h3 align = "center" style = "color:green">Offer Sent</h3>';
                                                echo "<br>";
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

                        </td>
                    </tr>


                    <tr>   
                        <td width="60%">
                             
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "POST" align = "center">

                                <font face="arial" color="#ffffff" size="4">
                                <div>

                                <fieldset>
                                <br>
                                <legend>Media Information</legend>
                                <label for="medUsername">Username:&nbsp;&nbsp;</label>
                                <input type="text" name="medUsername" value= "<?php echo isset($_POST['offer'])?$_POST['offer']:$_COOKIE['username'];?>" readonly>
                                <br><br>

                                <?php
                                    $mediafile = "../Model/Media/media.json";

                                    if(file_exists($mediafile) and filesize($mediafile)>0)
                                    {
                                        $handle = fopen($mediafile, "r");
                                        $data = fread($handle, filesize($mediafile));
                                        $exploded = explode("\n",$data);
                                        $media = array();
                                    
                                        for($i = 0; $i < count($exploded); $i++)
                                        {
                                            $decode = json_decode($exploded[$i],true);
                                            array_push($media,$decode);
                                        }
                                    }
                                
                                
                                    for($i=0;$i<count($media)-1;$i++)
                                    {
                                    
                                        if($media[$i]['Username']==$_COOKIE['username'])
                                        {
                                            echo '<label for="medEmail">Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>';
                                            echo '<input type="email" name="medEmail" value = "'.$media[$i]['Email'].'" readonly>';
                                            echo '<br><br>';
                                        }
                                    }
                                  

                             
                                ?>
                              
                                </fieldset>
                                <br><br>


                                <fieldset>
                                <br>
                                <legend>Profile Information</legend>

                                <label for="stdUsername">Username:&nbsp;&nbsp;</label>
                                <input type="text" name="stdUsername" value="<?php echo $_SESSION['username'];?>" readonly>
                                <br><br>

                                <?php
                                    $file = "../Model/users/data.json";

                                    if(file_exists($file) and filesize($file)>0)
                                    {
                                        $handle = fopen($file, "r");
                                        $data = fread($handle, filesize($file));
                                        $exploded = explode("\n",$data);
                                        $user = array();
                                    
                                        for($i = 0; $i < count($exploded); $i++)
                                        {
                                            $decode = json_decode($exploded[$i],true);
                                            array_push($user,$decode);
                                        }
                                    }
                                
                                
                                    for($i=0;$i<count($user)-1;$i++)
                                    {
                                    
                                        if($user[$i]['username']==$_SESSION['username'])
                                        {
            
                                            echo '<label for="stdEmail">Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>';
                                            echo '<input type="email" name="stdEmail" placeholder="Enter Your Email"  value = "'.$user[$i]['email'].'" readonly>';
                                            echo '<br><br>';
                                        }
                                    }                                
                             
                                ?>
                        
                                </fieldset>


                                <br><br>
               
                                <fieldset>
                                <legend>Personal Information</legend>
                                <br><br>

                                <div>
                                <span><font color="#cc0000"><b>*</b></font></span>
                                <label for="fname">First Name:&nbsp;&nbsp;</label>
                                <input type="text" name="fname" placeholder="Enter Your First Name" value="<?php echo !empty($_POST['fname'])?$_POST['fname']:""; ?>">
                                <br><br>

                                <span><font color="#cc0000"><b>*</b></font></span>
                                <label for="lname">*Last Name:&nbsp;&nbsp;</label>
                                <input type="text" name="lname" placeholder="Enter Your Last Name" value="<?php echo !empty($_POST['lname'])?$_POST['lname']:""; ?>">
                                <br><br>

                                <span><font color="#cc0000"><b>*</b></font></span>
                                Gender:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="gender" value = "Male"> Male
                                <input type="radio" name="gender" value = "Female">Female 
                                <br><br>
                                
                                <span><font color="#cc0000"><b>*</b></font></span>
                                <label for="dob">*Date Of Birth:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <input type="date" name="dob" value="<?php echo !empty($_POST['dob'])?$_POST['dob']:""; ?>">
                                <br><br>
                                </div>

                                </fieldset>
                                <br><br>

                                <fieldset>
                                <legend>Contact Information</legend>
                                <br>
                                <span><font color="#cc0000"><b>*</b></font></span>
                                <label for="city">City:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <input type="text" name="city" placeholder="Enter Your City" value="<?php echo !empty($_POST['city'])?$_POST['city']:""; ?>">
                                <br><br>

                                <span><font color="#cc0000"><b>*</b></font></span>
                                <label for="area">Area:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <input type="text" name="area" placeholder="Enter Your Area" value="<?php echo !empty($_POST['area'])?$_POST['area']:""; ?>">
                                <br><br>

                                <span><font color="#cc0000"><b>*</b></font></span>
                                <label for="phoneNo">Phone:&nbsp;</label>
                                <input type="tel" name="phoneNo" placeholder="Enter Your Phone Number" value="<?php echo !empty($_POST['phoneNo'])?$_POST['phoneNo']:""; ?>">
                                <br><br>
                                </fieldset>

                                <br><br>

                                <fieldset>
                                <legend>Offer Information</legend>
                                <br>

                                <span><font color="#cc0000"><b>*</b></font></span>
                                <label for="heading">Heading:&nbsp;</label>
                                <input type="text" name="heading" placeholder="Enter a heading for your offer" size="40" value="<?php echo !empty($_POST['heading'])?$_POST['heading']:"Need a tutor"; ?>">
                                <br><br><br>

                                <span><font color="#cc0000"><b>*</b></font></span>
                                <span>Choose subjects you want a tutor for:</span>
                                <br><br>

                                <?php

                                    $gradefilename = "../Model/res/subject.json";
                                    
                                    if(file_exists($gradefilename))
                                    {
                                        $handle = fopen($gradefilename, "r");
                                        $data = fread($handle, filesize($gradefilename));
                                        $exploded = explode("\n",$data); 
                                        $subject = array();

                                        for($i = 0; $i < count($exploded); $i++)
                                        {                                                                
                                            $decode = json_decode($exploded[$i],true);
                                            array_push($subject,$decode);
                                            
                                        }
                                        
                                        for($i = 1; $i < count($subject); $i++)
                                        {     
                                            echo '<input type="checkbox" id="sub" name="'.$subject[$i]['subject'].'">'; 
                                            echo '<label for="'.$i.'">'.$subject[$i]['subject'].'</label>'; 
                                            echo '&nbsp;&nbsp;&nbsp';

                                            if($i%3==0)
                                            {
                                                echo "<br>";
                                                echo "<br>";
                                            }
                                        }                                           

                                    }
                                                 
                                ?>
                                
                                
                                <br><br><br>
                                <span><font color="#cc0000"><b>*</b></font></span>
                                <span>Grade:&nbsp;</span>
                                <select name="grade" id="grade">
                                <?php
                                            $gradefilename = "../Model/res/gradeList.json";
                                         
                                            if(file_exists($gradefilename))
                                            {
                                                $handle = fopen($gradefilename, "r");
                                                $data = fread($handle, filesize($gradefilename));
                                                $exploded = explode("\n",$data); 
                                                $grade = array();

                                                for($i = 0; $i < count($exploded); $i++)
                                                {                                                                
                                                    $decode = json_decode($exploded[$i],true);
                                                    array_push($grade,$decode);
                                                    
                                                }
                                                
                                                for($i = 0; $i < count($grade); $i++)
                                                {                                                                
                                                    echo '<option value="'. $grade[$i]['grade'].'">';
                                                    echo  empty($grade[$i]['grade'])?"No Selection":$grade[$i]['grade'];
                                                    echo '</option>';
                                                }                                           

                                            }
                                                                        
                                ?>
                                </select>


                                <select name="cat">
                                    <option value="Bangla Medium">Bangla Medium</option>
                                    <option value="Bangla Medium">English Medium</option>
                                </select>
                                <br><br>

                                <label for="salary">Salary:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <input type="number" name="salary" placeholder="How much you will pay for tution?">
                                <br><br><br>
                                
                                <span><font color="#cc0000"><b>*</b></font></span>
                                <span>Choose Days you want to study:</span>
                                <br><br>

                               <?php
                                $weekfilename = "../Model/res/weekdays.json";
                                                                    
                                if(file_exists($weekfilename))
                                {
                                    $handle = fopen($weekfilename, "r");
                                    $data = fread($handle, filesize($weekfilename));
                                    $exploded = explode("\n",$data); 
                                    $days = array();

                                    for($i = 0; $i < count($exploded); $i++)
                                    {                                                                
                                        $decode = json_decode($exploded[$i],true);
                                        array_push($days,$decode);
                                        
                                    }

                                    for($i = 1; $i < count($exploded); $i++)
                                    {     
                                        echo '<input type="checkbox" id="day" name="'.$days[$i]['day'].'" value="check">'; 
                                        echo '<label for="'.$days[$i]['day'].'">'.$days[$i]['day'].'</label>'; 
                                        echo '&nbsp;&nbsp;&nbsp';

                                        if($i%3==0)
                                        {
                                            echo "<br>";
                                            echo "<br>";
                                        }
                                    } 
                                }

                                ?>
                                <br><br><br>
                                <span><font color="#cc0000"><b>*</b></font></span>
                                <label for="timeStart">Timing From:&nbsp;</label>
                                <input type="time" name="timeStart">
                                <br><br>

                                <span><font color="#cc0000"><b>*</b></font></span>
                                <label for="timeEnd">Timing Upto:&nbsp;</label>
                                <input type="time" name="timeEnd">
                                <br><br>

                                </fieldset>
                                </div>
                        
                                <br><br>

                                <input type="submit" id="submitButton" name="submit">
                                <br> 
                                </font>
                            </form>                         
                        </td>
                    </tr>

                    <tr>
                        <td height = "100">

                        

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

    <?php include('footer.php');?>

</body>
</html>