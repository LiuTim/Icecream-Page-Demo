<?php

	header ('content-type:text/html; charset=utf-8');

	$title=$_POST['title'];
    $Sex=$_POST['Sex'];
    $name=$_POST['Cust_name'];
    $tel=$_POST['tel'];
    $guestmail=$_POST['email'];
    $Info=$_POST['info'];

    $sys_time=date('Y-m-d H:i:s');

    $mailContent = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style type="text/css">
        body{
            font-family:Arial;
            font-size: 11px;
        }
        td{
            font-family:Arial;
            font-size: 11px;
        }
        .name{background-color:#BCE774; }
        .value{background-color:#ECFBD4; }

    </style>
</head>
<body>
    <table align="center" align="center" cellpadding="5" cellspacing="2" width="100%">
                        <tr>
                            <td align="center" width="10%" class="name">訂單時間</td>
                            <td align="left" width="40%"  class="value">'.$sys_time.'</td>
                            <td align="center" width="10%" class="name">主旨</td>
                            <td align="left" width="40%"  class="value">'.$title.'</td>
                        </tr>
                         <tr>
                            <td align="center" width="10%" class="name">性別 : </td>
                            <td align="left" width="40%"  class="value">'.$Sex.'</td>
                            <td align="center" width="10%" class="name">姓名 : </td>
                            <td align="left" width="40%"  class="value">'.$name.'</td>
                        </tr>
                        <tr>
                            <td align="center" width="10%" class="name">E-Mail : </td>
                            <td align="left" width="40%"  class="value">'.$guestmail.'</td>
                            <td align="center" width="10%" class="name">Tel : </td>
                            <td align="left" width="40%"  class="value">'.$tel.'</td>
                        </tr>
                        <tr>
                            <td align="center" width="10%" class="name">Info</td>
                            <td align="left" width="40%" class="value">'.$Info.'</td>
                        </tr>
                    </table>
</body>
</html>';

$auto_reply_to_client = <<<EOD
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<style type="text/css">
#main{
    font-family: "Calibri","sans-serif";
    font-size: 16pt;
    line-height: 35px;
}
</style>
</head>

<body id="main">

<b><h3><u>Dear {$Sex} {$name}:</u></h3></b>

Thanks for visiting our website.<br />

We appreciate your completed inquiry list and we assure you of best of attention to your inquiries.<br />

Please contact our specialist if you haven’t received our response within two business days:<br />

<ul>
<li>Price enquiry and specifications of our products, please contact to: <a href="mailto:info@ancoraice.com.tw">info@ancoraice.com.tw</a></li>
<li>Regarding others main questions, please contact <a href="mailto:info@ancoraice.com.tw">info@ancoraice.com.tw</a></li>
</ul>

This message was created automatically by mail delivery <b><a href="http://www.ancoraice.com.tw/" target="_blank">Ancoraice's website</a></b>, please do not reply directly.<br />

<i>
Thanks again for visiting our website.<br />
Best regards,<br /></i>
<br /><br />

<span style="color: #548dd4;">T</span> + 886-7-3330800 | <span style="color: #c0504d;">F</span> + 886-7-3330800<br />

<a href="http://www.ancoraice.com.tw/" target="_blank">Website</a> | <a href="mailto:info@ancoraice.com.tw">E-mail</a> 

</body>
</html>
EOD;
//自動回覆客戶信件
    //echo $auto_reply_to_client;

    include("mailer/class.phpmailer.php");

    $mail             = new PHPMailer();    
    $mail->IsSMTP();
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
    $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
    $mail->CharSet    = "utf-8";
    $mail->Encoding   = "base64";

    $mail->Username   = "ancoraice@gmail.com";  
    $mail->Password   = "Ancoraice-5951";  //需要輸入gmail password
    //需要設定gmail登入和安全性，設定「允許安全性較低的應用程式存取您的帳戶」

    $mail->From       = "ancoraice@gmail.com";
    $mail->FromName   = "Ancoraice"; //可以照自己的意思輸入

    $mail->SingleTo   =true;

    $email="info@ancoraice.com.tw,tim@activa.com.tw";
    // 收件者信箱
    $srecipients = explode(",", $email); 
    // 切割逗號

    foreach ($srecipients as $srecipient){
        $mail->addAddress($srecipient);
    }  
    //explode切割後再放入到address()

    $mail->Subject    = "Ancoraice 網站 - 聯絡我們來信";

    $mail->Body       =  $mailContent;  

    $mail->IsHTML(true); // send as HTML

    if(!$mail->Send()){
    echo "寄信發生錯誤：" . $mail->ErrorInfo;
    //如果有錯誤會印出原因
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script language=javascript>
            alert("訊息送出有誤，請重試!!");
            history.go(-1);
        </script>      
    </head>
</html>
<?php
    }
    else{ 
        //echo "寄信成功";
        $mail->Body       = $auto_reply_to_client;   
        $mail->Subject    = "Thanks for asking Ancoraice.";
        $mail->addAddress($guestmail);
        $mail->Send();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script language=javascript>
            alert("您的訊息已成功送出，我們將盡速與您聯絡，謝謝！");
            location.href="index.html";
        </script>      
    </head>
</html>
<?php 
    }
    
?>