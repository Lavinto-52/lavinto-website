<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__.'/Exception.php';
require __DIR__.'/PHPMailer.php';
require __DIR__.'/SMTP.php';

function validateEmail($email)
{
   return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
function replaceVariables($code)
{
   foreach ($_POST as $key => $value)
   {
      if (is_array($value))
      {
         $value = implode(",", $value);
      }
      $name = "$" . $key;
      $code = str_replace($name, $value, $code);
   }
   $code = str_replace('$ipaddress', $_SERVER['REMOTE_ADDR'], $code);
   return $code;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['formid']) && $_POST['formid'] == 'layer2')
{
   $mailto = 'lavintocreativeltd@gmail.com';
   $mailfrom = isset($_POST['email']) ? $_POST['email'] : $mailto;
   $subject = 'Inquiry from the Website';
   $message = '<font style="color:#000000;font-family:Arial;font-size:16px">Values submitted from website form:<br><br>Name:$Name<br>Email:$Email<br>Phone:$Phone<br>Message:$Message</font>';
   $success_url = './Email_succes.php';
   $error_url = './Email_error.php';
   $autoresponder_from = 'lavintocreativeltd@gmail.com';
   $autoresponder_name = 'Lavinto Creatives LTD';
   $autoresponder_to = isset($_POST['Email']) ? $_POST['Email'] : $mailfrom;
   $autoresponder_subject = 'Thanks $Name. We have recieved Your Email!!';
   $autoresponder_message = '<font style="color:#000000;font-family:Arial;font-size:16px">Thanks$Name Our team Recieved Your Email.<br><br>For Your control. You have written the folowing:<br><br>Name:$Name<br>Èmail:$Email<br>Phone:$Phone<br>Message:$Message</font>';
   $eol = "\r\n";
   $error = '';
   try
   {

      $mail = new PHPMailer(true);
      $mail->IsQmail();
      $subject = replaceVariables($subject);
      $mail->Subject = stripslashes($subject);
      $mail->From = $mailfrom;
      $mail->FromName = $mailfrom;
      $mailto_array = explode(",", $mailto);
      for ($i = 0; $i < count($mailto_array); $i++)
      {
         if(trim($mailto_array[$i]) != "")
         {
            $mail->AddAddress($mailto_array[$i], "");
         }
      }
      if (!validateEmail($mailfrom))
      {
         $error .= "The specified email address (" . $mailfrom . ") is invalid!\n<br>";
         throw new Exception($error);
      }
      $mail->AddReplyTo($mailfrom);
      $mail->CharSet = 'UTF-8';
      if (!empty($_FILES))
      {
         foreach ($_FILES as $key => $value)
         {
            if (is_array($_FILES[$key]['name']))
            {
               $count = count($_FILES[$key]['name']);
               for ($file = 0; $file < $count; $file++)
               {
                  if ($_FILES[$key]['error'][$file] == 0)
                  {
                     $mail->AddAttachment($_FILES[$key]['tmp_name'][$file], $_FILES[$key]['name'][$file]);
                  }
               }
            }
            else
            {
               if ($_FILES[$key]['error'] == 0)
               {
                  $mail->AddAttachment($_FILES[$key]['tmp_name'], $_FILES[$key]['name']);
               }
            }
         }
      }
      $message = replaceVariables($message);
      $message = stripslashes($message);
      $mail->MsgHTML($message);
      $mail->IsHTML(true);
      $mail->Send();
      $mail->ClearAddresses();
      $mail->ClearAttachments();
      $mail->ClearReplyTos();
      $autoresponder_subject = replaceVariables($autoresponder_subject);
      $mail->Subject = stripslashes($autoresponder_subject);
      $mail->From = $autoresponder_from;
      $mail->FromName = $autoresponder_name;
      $mail->AddAddress($autoresponder_to, "");
      $mail->AddReplyTo($autoresponder_from);
      $autoresponder_message = replaceVariables($autoresponder_message);
      $autoresponder_message = stripslashes($autoresponder_message);
      $mail->MsgHTML($autoresponder_message);
      $mail->IsHTML(true);
      $mail->Send();
      $successcode = file_get_contents($success_url);
      $successcode = replaceVariables($successcode);
      echo $successcode;
   }
   catch (Exception $e)
   {
      $errorcode = file_get_contents($error_url);
      $replace = "##error##";
      $errorcode = str_replace($replace, $e->getMessage(), $errorcode);
      echo $errorcode;
   }
   exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>LavintoContact...............................</title>
<meta name="generator" content="WYSIWYG Web Builder 20 - https://www.wysiwygwebbuilder.com">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="fontawesome6.min.css" rel="stylesheet">
<link href="LAVINTO_CREATIVES_1.css" rel="stylesheet">
<link href="Contact.css" rel="stylesheet">
<script src="jquery-3.7.1.min.js"></script>
<script src="wb.overlay.min.js"></script>
<script>
$(document).ready(function()
{
   $('#OverlayMenu1-overlay').overlay({hideTransition:true});
   $('#OverlayMenu1').on('click', function(e)
   {
      $.overlay.toggle($('#OverlayMenu1-overlay'));
      return false;
   });
});
</script>
</head>
<body>
<div id="PageHeader1">
<div id="PageHeader1_Container">
<div id="wb_Shape1">
<img src="images/img0012.png" id="Shape1" alt="" width="271" height="76"></div>
<div id="wb_Image5">
<img src="images/Asset 20signature 2026.png" loading="lazy" id="Image5" alt="" width="279" height="77"></div>
<div id="wb_CssMenu1">
<ul id="CssMenu1" role="menubar" class="nav">
<li role="menuitem" class="nav-item firstmain"><a class="nav-link" href="./index.html" target="_self" title="Home">Home</a>
</li>
<li role="menuitem" class="nav-item"><a class="nav-link" href="./Services.html" target="_self" title="Services">Services</a>
</li>
<li role="menuitem" class="nav-item"><a class="nav-link" href="./About.html" target="_self" title="About">About</a>
</li>
<li role="menuitem" class="nav-item"><a class="nav-link active" href="./Contact.php" target="_self" title="Contact">Contact</a>
</li>
</ul>
</div>
<div id="wb_Icon2">
<a href="mailto:lavintocreativeltd@gmail.com"><div id="Icon2"><i class="fa fa-regular fa-envelope"></i></div></a></div>
<div id="wb_Icon1">
<a href="https://wa.me/0700773516"><div id="Icon1"><i class="fa fa-phone"></i></div></a></div>
<div id="wb_OverlayMenu1">
<a href="#" id="OverlayMenu1">
<span class="line"></span>
<span class="line"></span>
<span class="line"></span>
</a>
</div>
<div id="wb_Text2">
<span style="color:#FFFFFF;font-family:Arial;font-size:16px;">0700773516</span></div>
<div id="wb_Text3">
<span style="color:#FFFFFF;font-family:Arial;font-size:16px;">P.O BOX:3110-20200,Nairobi</span></div>
<div id="wb_Text1">
<span style="color:#FFFFFF;font-family:Arial;font-size:16px;">lavintocreativeltd@gmail.com&nbsp; </span></div>
</div>
</div>
<div id="container">


</div>
<div id="OverlayMenu1-overlay">
<div class="OverlayMenu1">
<ul class="drilldown-menu" role="menu">
<li><a role="menuitem" href="./index.html" title="Home" class="OverlayMenu1-effect">Home</a></li>
<li><a role="menuitem" href="./Services.html" title="Services" class="OverlayMenu1-effect">Services</a></li>
<li><a role="menuitem" href="./About.html" title="About" class="OverlayMenu1-effect">About</a></li>
<li><a role="menuitem" href="./Contact.php" title="Contact" class="OverlayMenu1-effect">Contact</a></li>
</ul>
</div>
<a class="close-button" id="OverlayMenu1-close" href="#" role="button" aria-hidden="true"><span></span></a>
</div>
<form name="Layer2" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="Layer2">
<div id="Layer2-overlay"></div>
<input type="hidden" name="formid" value="layer2">
<div id="Layer2_Container">
<div id="wb_Shape5">
<img src="images/img0003.png" id="Shape5" alt="" width="522" height="513"></div>
<div id="wb_Shape4">
<img src="images/img0007.png" id="Shape4" alt="" width="369" height="383"></div>
<div id="wb_Icon7">
<div id="Icon7"><i class="fa fa-phone"></i></div></div>
<div id="wb_Icon8">
<div id="Icon8"><i class="fa fa-regular fa-envelope"></i></div></div>
<div id="wb_Icon3">
<div id="Icon3"><i class="fa fa-map-location-dot"></i></div></div>
<div id="wb_Text4">
<span style="color:#000000;font-family:'Arial Black';font-size:17px;"><strong>Contact info</strong></span></div>
<div id="wb_Text12">
<span style="color:#000000;font-family:Arial;font-size:17px;line-height:21px;">0700 77 35 16<br>0751 396 938</span></div>
<div id="wb_Text5">
<span style="color:#000000;font-family:Arial;font-size:17px;line-height:21px;">P.O BOX 3110-20200<br>NAIROBI,KENYA</span></div>
<div id="wb_Text7">
<span style="color:#000000;font-family:Arial;font-size:17px;line-height:21px;">lavintocreativeltd@gmail.com<br>lavintodesigns@gmail.com</span></div>
<hr id="HorizontalLine1">
<div id="wb_Text11">
<span style="color:#EB2027;font-family:'Arial Black';font-size:43px;">CONTACT US</span></div>
<input type="text" id="Editbox1" name="Name" value="" spellcheck="false" placeholder="James Mkenya">
<input type="number" id="Editbox2" name="Phone" value="" spellcheck="false" placeholder="0700123456">
<input type="email" id="Editbox3" name="Email" value="" spellcheck="false" placeholder="lavintocreativeltd@gmail.com">
<div id="wb_Text13">
<span style="color:#FFFFFF;font-family:'Arial Black';font-size:43px;">Make an Inquiry</span></div>
<div id="wb_Text6">
<span style="color:#EB2027;font-family:Arial;font-size:16px;"><em>Engraving | Banners | Billboards | Stickers | Vehicle Branding | Directional Signs | Illuminated Signs | Led Signs<br>| Led Display Screen | Led Signs | 3D Acrylic Signs | ACP Signboards &amp; Corporate Gifts | Neon Signs | Retail Signs | Sign Boards | Vinyl</em></span></div>
<div id="wb_Text8">
<span style="color:#000000;font-family:Arial;font-size:16px;line-height:15px;"><em>Instant Reply</em></span></div>
<div id="wb_Text9">
<span style="color:#000000;font-family:Arial;font-size:16px;line-height:15px;"><em>Free Quotation</em></span></div>
<div id="wb_Text10">
<span style="color:#000000;font-family:Arial;font-size:16px;line-height:15px;"><em>5% dicount on first time order</em></span></div>
<div id="wb_Icon4">
<div id="Icon4"><i class="fa fa-check"></i></div></div>
<div id="wb_Icon5">
<div id="Icon5"><i class="fa fa-check"></i></div></div>
<div id="wb_Icon6">
<div id="Icon6"><i class="fa fa-check"></i></div></div>
<textarea name="Message" id="TextArea1" rows="12" cols="27" spellcheck="false" placeholder="Message"></textarea>
<input type="submit" id="Button1" name="" value="Submit">
<div id="wb_Text14">
<span style="color:#000000;font-family:Arial;font-size:16px;">Name</span></div>
<div id="wb_Text15">
<span style="color:#000000;font-family:Arial;font-size:16px;">Phone</span></div>
<div id="wb_Text16">
<span style="color:#000000;font-family:Arial;font-size:16px;">Email</span></div>
</div>
</form>
<div id="PageFooter2">
<div id="PageFooter2_Container">
<div id="wb_JavaScript1">
<div id="copyrightnotice"></div>
<script>
   var now = new Date();
   var startYear = "2023";
   var text =  "Copyright &copy; ";
   if (startYear != '')
   {
      text = text + startYear + "-";
   }
   text = text + now.getFullYear() + ", Lavinto Creatives LTD. All rights reserved.";
   var copyrightnotice = document.getElementById('copyrightnotice');
   copyrightnotice.innerHTML = text;
</script>


</div>
<div id="wb_Text17">
<span style="color:#FFFFFF;font-family:Arial;font-size:16px;"><strong>Quick Links</strong></span></div>
<div id="wb_Text18">
<span style="color:#FFFFFF;font-family:Arial;font-size:16px;"><strong>contacts</strong></span></div>
<picture id="wb_Picture1">
<img src="images/Asset 19signature 2026.png" id="Picture1" alt="" width="118" height="85">
</picture>
<div id="wb_Text19">
<span style="color:#FFFFFF;font-family:Arial;font-size:16px;"><strong>Our Services</strong></span></div>
<div id="wb_Text20">
<span style="color:#FFFFFF;font-family:Arial;font-size:16px;line-height:23px;">Vehicle Branding<br>3d &amp; 2D signages<br>Interior Branding<br>Exterior Branding</span></div>
<div id="wb_Text21">
<span style="color:#FFFFFF;font-family:Arial;font-size:16px;line-height:23px;">lavintocreativeltd@gmail.com<br>lavintodesigns@gmail.com<br>0700 773 516 / 07531 96 938<br>P.O BOX 3110-20200, NAIROBI</span></div>
<div id="wb_Text22" onclick="window.location.href='./Services.html';return false;">
<span style="color:#FFFFFF;font-family:Arial;font-size:16px;"><strong>Our Services</strong></span></div>
<div id="wb_Text23" onclick="window.location.href='./Contact.php';return false;">
<span style="color:#FFFFFF;font-family:Arial;font-size:16px;"><strong>contacts</strong></span></div>
<div id="wb_Text24" onclick="window.location.href='./About.html';return false;">
<span style="color:#FFFFFF;font-family:Arial;font-size:16px;"><strong>About</strong></span></div>
<div id="wb_Text26">
<span style="color:#FFFFFF;font-family:Arial;font-size:11px;">Welcome To LAVINTO CREATIVES&nbsp; Where Creativity Meets Strategy. We Are Result-Driven Creative Company Specializing In Graphic Design<br>And Digital Marketing Solutions That Helps<br>Brands Standout And Grow. Our Mission Is To Transform Ideas It Visually Compelling Designs That That Communicate Clearly, Connect<br>Emotionally And Deliver Real Impact</span></div>
<div id="wb_Icon15">
<a href="mailto:lavintocreativeltd@gmail.com" title="E-MAIL"><div id="Icon15"><i class="fa fa-envelope"></i></div></a></div>
<div id="wb_Icon14">
<a href="https://www.facebook.com/levis.lavinto" target="_blank"><div id="Icon14"><i class="fa fa-brands fa-facebook-square"></i></div></a></div>
<div id="wb_Icon13">
<a href="https://www.instagram.com/lavinto_designs?stkn=MXpbHVwYmZTNidg==" target="_blank"><div id="Icon13"><i class="fa fa-brands fa-instagram"></i></div></a></div>
<div id="wb_Icon12">
<a href="https://vm.tiktok.com/ZS9DUQKb6kKJQ-gQVNz/" target="_blank"><div id="Icon12"><i class="fa fa-brands fa-tiktok"></i></div></a></div>
<div id="wb_Icon11">
<a href="https://wa.me/+254700773516/" target="_blank"><div id="Icon11"><i class="fa fa-brands fa-whatsapp"></i></div></a></div>
</div>
</div>
</body>
</html>