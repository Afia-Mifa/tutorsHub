<?php 
    session_start();
        
    if(count($_SESSION)==0)
    {
        header("location:../Controller/logout.php");
    }
?>

<?php include('header.php')?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media</title>
</head>

<body>

   <?php
        $mediafile = "../Model/offers/offers.json";

        if (file_exists($mediafile) and filesize($mediafile) > 0) {
            $handle = fopen($mediafile, "r");
            $data = fread($handle, filesize($mediafile));
            $exploded = explode("\n", $data);
            $arr = array(); 
            

            for ($i = 0; $i < count($exploded); $i++) {
                $decode = json_decode($exploded[$i], true);
                array_push($arr, $decode);
            }
        }

    ?>


    <table id="about" border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#0f1e3e">
        <tr>
            <td>
                <table border="0" width="85%" cellpadding="15" cellspacing="0" align="center">
                    <tr>
                        <td height="80" align="center" valign="middle" colspan="2">
                            <font face="arial" color="#ffffff" size="6">
                                Offer Status
                            </font>
                        </td>

                    </tr>
                    <table border="1" width="85%" cellpadding="15" cellspacing="0" align="center">

                        <thead>
                            <tr>

                                <th>
                                    <font face="arial" color="#66c2ff" size="4">Heading </font>
                                </th>
                                <th>
                                    <font face="arial" color="#66c2ff" size="4">Media Username</font>
                                </th>
                                <th>
                                    <font face="arial" color="#66c2ff" size="4">Media Email</font>
                                </th>
                                <th>
                                    <font face="arial" color="#66c2ff" size="4">Subjects</font>
                                </th>
                                <th>
                                    <font face="arial" color="#66c2ff" size="4">Days</font>
                                </th>
                                <th>
                                    <font face="arial" color="#66c2ff" size="4">Tming</font>
                                </th>
                                <th>
                                    <font face="arial" color="#66c2ff" size="4">Status</font>
                                </th>
                            </tr>
                        </thead>

                        <?php

                        for ($j = 0; $j < count($arr) - 1; $j++) {

                            if($arr[$j]['studentUsername']==$_SESSION['username'])
                            {
                                echo '<tr>';

                                echo '<td align="center" valign="middle">';
                                echo '<font face="arial" color="#ffffff" size="4">';
                                echo $arr[$j]['heading'];
                                echo '</font>';
                                echo "</td>";

                                echo '<td align="center" valign="middle">';
                                echo '<font face="arial" color="#ffffff" size="4">';
                                echo $arr[$j]['mediaUsername'];
                                echo '</font>';
                                echo "</td>";

                                echo '<td align="center" valign="middle">';
                                echo '<font face="arial" color="#ffffff" size="4">';
                                echo $arr[$j]['mediaEmail'];
                                echo '</font>';
                                echo "</td>";


                                echo '<td align="center" valign="middle">';
                                echo '<font face="arial" color="#ffffff" size="4">';
                                for($k = 0; $k < count($arr[$j]['subject']); $k++)
                                {
                                
                                
                                    echo $arr[$j]['subject'][$k].', ';
                                
                                }  
                                echo '</font>';
                                echo "</td>";

                                echo '<td align="center" valign="middle">';
                                echo '<font face="arial" color="#ffffff" size="4">';
                                for($k = 0; $k < count($arr[$j]['days']); $k++)
                                {
                                
                                
                                    echo $arr[$j]['days'][$k].', ';
                                
                                }  
                                echo '</font>';
                                echo "</td>";


                                echo '<td align="center" valign="middle">';
                                echo '<font face="arial" color="#ffffff" size="4">';
                                echo $arr[$j]['timing'];
                                echo '</font>';
                                echo "</td>";

                                echo '<td align="center" valign="middle">';
                                echo '<font face="arial" color="#33cc33" size="4">';
                                echo $arr[$j]['status'];
                                echo '</font>';
                                echo "</td>";
                            
                                echo "</tr>"; 
                            }

                        }

                        ?>
                    </table>

                    <tr>
                        <td height="400">
                            &nbsp;
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

<?php include('footer.php');?>

</body>

</html>