<?php
require_once 'dbh.php';
if (isset($_POST['submit'])) {
        $file = $_FILES['file'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];
        $bookSize = $_POST['bookPage'];
        $interiorColor = $_POST['interiorColor'];
        $paperType = $_POST['paperType'];
        $bindingType = $_POST['bindingType'];
        $coverFinish = $_POST['coverFinish'];
        $userEmail = $_POST['email'];
        $userName = $_POST['name'];
        $comment = $_POST['comment'];
        $pages = $_POST['pages'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $price = $_POST['finalValue'];
        $cWidth = $_POST['cWidth'];
        $cHeight = $_POST['cHeight'];
        $totalValue = $_POST['totalValue'];
        $sWidth = $_POST['sWidth'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        

        $allowed = array('pdf');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize > 5000) {
                    mkdir($phone);

                    $fileDestination = "$phone/$fileName";
                    $orderId = uniqId('', false);

                    $sql = "INSERT INTO sales_order(bookSize, interiorColor, paperType, bindingType, coverFinish, pages, filePath, customer_name, customer_mobile, customer_email, customer_address, customer_city, customer_note, base_subtotal, sales_order_id) 
                    VALUES('$bookSize', '$interiorColor', '$paperType', '$bindingType', '$coverFinish', '$pages', '$fileDestination', '$userName', $phone, '$userEmail', '$address', '$city',  '$comment', '$price', '$orderId');";
                        if(mysqli_query($conn, $sql)){
                        move_uploaded_file($fileTmpName, $fileDestination);
                        echo '<script> alert("Order placed successfully")</script>';
                        mysqli_close($conn);

                        $to = "Enter your email here";

                        $subject = 'New order from'.$userName;

                        $message = '<p>Customer\'s Name: ' .$userName. '<br>Customer\'s Email: '.$userEmail.'<br></br>Phone Number: '.$phone.'<br>Book Size: '.$bookSize.'<br>Paper Type: '.$paperType.'<br>Interior Color: '.$interiorColor.'<br>Binding Type: '.$bindingType.'<br>Pages: '.$pages.
                        '<br>Cover Finish: '.$coverFinish.'<br>File Path: '.$fileDestination.'<br>Address: '.$address.'<br>City: '.$city.'<br>Comment: '.$comment.'<br>Price: '.$price.'<br>Spine Width: '.$sWidth.'in<br>Cover Size: '.$cWidth.'in x '.$cHeight.'in </p>';
                        $message .= '<p>Here is your pdf link: </p><br>';
                        $message .= '<h4>'.$fileDestination.'</h4>';

                        $headers = "From:$userEmail \r\n";
                        $headers .= "Reply-To: ".$userEmail."\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $headers .= 'X-Mailer: PHP/' . phpversion(7.4);

                        $mail = mail($to, $subject, $message, $headers);
                        if(!$mail)
                        {
                            echo error_get_last();
                        }
                        
                        $to1 = $userEmail;

                        $subject1 = 'Hi, '.$userName.' - Your Order #'.$orderId.' has been received!';

                        $message1 = '<p style="background-color: #E9EDF6;">
                        <h3 style="text-align: center;" >Thank you for you Order!</h3>
                        <br>
                        <br>
                        Order #'.$orderId.'
                        <br>
                        Placed On '.date("h:i:sa").'
                        <br>
                        Order Note: PDF Print ('.$bookSize.')
                        <br>
                        Subtotal : Rs. '.$price.'
                        <br>
                        Shipping: Rs. 200
                        <br>
                        Total: Rs. '.$totalValue.'
                        <br>
                        Thank you
                        <br>
                        <a href="https://wbookstore.com">wbookstore.com</a>
                        <br>

                                     </p>';

                        $headers1 = "From:$userEmail \r\n";
                        $headers1 .= "Reply-To: ".$userEmail."\r\n";
                        $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $headers1 .= 'X-Mailer: PHP/' . phpversion(7.4);

                        $mail1 = mail($to1, $subject1, $message1, $headers1);
                        if(!$mail1)
                        {
                            echo error_get_last();
                        }

                        }
                    }
                } else {
                    echo '<script> alert("The file is too big. You can only upload upto 5mb!");</script>';
                }
            } else {
                echo '<script> alert("There was am error uploading your file!");</script>';
            }
       
}
 else {
        echo '<script> alert("You can\'t upload this type of file here!");</script>';
    }