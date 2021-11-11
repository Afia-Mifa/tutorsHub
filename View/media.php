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
    <title>Media</title>
</head>

<body>
    <?php include("header.php"); ?>

    <?php
        $mediafile = "../Model/Media/media.json";

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

        if (isset($_POST['offer'])) {
            setcookie("username", $_POST['offer'], time() + 84600);
            header("location:offer.php");
        }

    ?>


    <table id="about" border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#0f1e3e">
        <tr>
            <td>
                <table border="0" width="85%" cellpadding="15" cellspacing="0" align="center">
                    <tr>
                        <td height="80" align="center" valign="middle" colspan="2">
                            <font face="arial" color="#ffffff" size="6">
                                Media
                            </font>
                        </td>

                    </tr>
                    <table border="1" width="85%" cellpadding="15" cellspacing="0" align="center">

                        <thead>
                            <tr>

                                <th>
                                    <font face="arial" color="#6666ff" size="4">Media Name </font>
                                </th>
                                <th>
                                    <font face="arial" color="#6666ff" size="4">Username</font>
                                </th>
                                <th>
                                    <font face="arial" color="#6666ff" size="4">Catagory</font>
                                </th>
                                <th>
                                    <font face="arial" color="#6666ff" size="4">City</font>
                                </th>
                                <th>
                                    <font face="arial" color="#6666ff" size="4">Email</font>
                                </th>
                                <th>
                                    <font face="arial" color="#6666ff" size="4">Phone</font>
                                </th>
                                <th>
                                    <font face="arial" color="#6666ff" size="4">Address</font>
                                </th>
                                <th>
                                    <font face="arial" color="#6666ff" size="4">Send Offer</font>
                                </th>

                            </tr>
                        </thead>

                        <?php

                        for ($j = 0; $j < count($arr) - 1; $j++) {
                            echo '<tr>';

                            echo '<td align="center" valign="middle">';
                            echo '<font face="arial" color="#ffffff" size="4">';
                            echo $arr[$j]['MediaName'];
                            echo '</font>';
                            echo "</td>";

                            echo '<td align="center" valign="middle">';
                            echo '<font face="arial" color="#ffffff" size="4">';
                            echo $arr[$j]['Username'];
                            echo '</font>';
                            echo "</td>";

                            echo '<td align="center" valign="middle">';
                            echo '<font face="arial" color="#ffffff" size="4">';
                            echo $arr[$j]['Catagory'];
                            echo '</font>';
                            echo "</td>";

                            echo '<td align="center" valign="middle">';
                            echo '<font face="arial" color="#ffffff" size="4">';
                            echo $arr[$j]['City'];
                            echo '</font>';
                            echo "</td>";


                            echo '<td align="center" valign="middle">';
                            echo '<font face="arial" color="#ffffff" size="4">';
                            echo $arr[$j]['Email'];
                            echo '</font>';
                            echo "</td>";


                            echo '<td align="center" valign="middle">';
                            echo '<font face="arial" color="#ffffff" size="4">';
                            echo $arr[$j]['Phone'];
                            echo '</font>';
                            echo "</td>";


                            echo '<td align="center" valign="middle">';
                            echo '<font face="arial" color="#ffffff" size="4">';
                            echo $arr[$j]['Address'];
                            echo '</font>';
                            echo "</td>";


                            echo '<td align="center" valign="middle">';
                            echo '<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="POST">';
                            echo '<input type="hidden" name="offer" value="' . $arr[$j]['Username'] . '">';
                            echo '<input type="submit" name="submit" value="Offer">';
                            echo '</form>';
                            echo "</td>";
                          
                            echo "</tr>"; 
                      
                        }

                        ?>
                    </table>
                    <tr>
                        <td height="100">
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