<?php

use Mpdf\Mpdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/autoload.php';
require 'vendor/autoload.php';
$link = mysqli_connect("localhost", "root", "harihari", "resume");

$mpdf = new Mpdf();
$mpdf->Bookmark('Start of the document');
$html = "<div align=\'center\' color='red'><h1>Resume</h1></div>";
$mpdf->WriteHTML($html);
$html = "<style>
h1,h2,h3,h4,h5,h6
{
    color: red;
    font-family: Lato;
}
body,p,div,li{
 font-family: Lato;
}
</style>";
$mpdf->WriteHTML($html);
$nameErr = $emailErr = $genderErr = "";
$quali10 = $quali10s = "";

$name = $email = $gender = $mytext = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $html = "Name : $name<br>";
    $mpdf->WriteHTML($html);
    $sqlfields = "(name,";
    $sqlvalues = "(' $name ',";

    $mytext3 = $_POST["mytext3"];
    $mytext2 = $_POST["mytext2"];
    $mytextl = $_POST["mytextl"];
    $mytext1 = $_POST["mytext1"];
    $mytext = $_POST["mytext"];
    $mytexts = $_POST["mytexts"];
    $myInputs = $_POST["myInputs"];


    if (!empty($_POST["email"])) {
        $email = test_input($_POST["email"]);
        $html = "Email : $email<br>";
        $mpdf->WriteHTML($html);
        $sqlfields = $sqlfields . "email,";
        $sqlvalues = $sqlvalues . "'" . $email . "',";

    }
    if (!empty($_POST["addr"])) {
        $addr = test_input($_POST["addr"]);

        $html = "Address :<br> $addr<br><hr>";
        $mpdf->WriteHTML($html);
        $sqlfields = $sqlfields . "addr,";
        $sqlvalues = $sqlvalues . "'" . $addr . "',";
    }
    if (!empty($_POST["qualiclg"])) {
        $qualiclg = test_input($_POST["qualiclg"]);
        $html = "College Qualification : $qualiclg<br>";
        $sqlfields = $sqlfields . "clgpercnet,";
        $sqlvalues = $sqlvalues . "'" . $qualiclg . "',";
    }
    if (!empty($_POST["qualiclgn"])) {
        $qualiclgn = test_input($_POST["qualiclgn"]);
        $html = "College Name : $qualiclgn<br>";
        $sqlfields = $sqlfields . "clgnam,";
        $sqlvalues = $sqlvalues . "'" . $qualiclgn . "',";
    }
    if (!empty($_POST["quali12"])) {
        $quali12 = test_input($_POST["quali12"]);
        $html = "12th College percentage : $quali12<br>";
        $sqlfields = $sqlfields . "per12,";
        $sqlvalues = $sqlvalues . "'" . $quali12 . "',";
    }
    if (!empty($_POST["quali12s"])) {
        $quali12s = test_input($_POST["quali12s"]);
        $html = "12th School Name  : $quali12s<br>";
        $sqlfields = $sqlfields . "skl12,";
        $sqlvalues = $sqlvalues . "'" . $quali12s . "',";
    }
    if (!empty($_POST["quali10"])) {
        $quali10 = test_input($_POST["quali10"]);
        $html = "10th Percentage : $quali10<br>";
        $sqlfields = $sqlfields . "per10,";
        $sqlvalues = $sqlvalues . "'" . $quali10 . "',";
    }
    if (!empty($_POST["quali10s"])) {
        $quali10s = test_input($_POST["quali10s"]);
        $html = "10th School Name : $quali10s<br>";
        $sqlfields = $sqlfields . "skl10,";
        $sqlvalues = $sqlvalues . "'" . $quali10s . "',";
    }
    if (!empty($_POST["co"])) {
        $co = test_input($_POST["co"]);

        $html = "<h3>Career Objective: </h3> $co<br><br><br>";
        $mpdf->WriteHTML($html);
        $sqlfields = $sqlfields . "career,";
        $sqlvalues = $sqlvalues . "'" . $co . "',";
    }


    $mpdf->WriteHTML("<style>
table, th, td {
    border: 1px solid black;
    align-content: center;
    align-items: center;
    alignment: center;
    align-self: center;
    border-style: solid;
}
</style>");
    $html = "<h3> Academics :</h3><table style=\"width:100%\"><tr><th>Education</th><th>Name of Institution</th><th>Percentage</th></tr>";
    $html = $html . "<tr><td>10th</td> <td>$quali10s</td><td>$quali10</td></tr>";
    $html = $html . "<tr><td>12th</td> <td>$quali12s</td><td>$quali12</td></tr>";
    $html = $html . "<tr><td>College</td> <td> $qualiclgn </td><td>$qualiclg</td></tr>";


    $html = $html . "</table>";
    $mpdf->WriteHTML($html);

    if (!empty($myInputs)) {
        $html = "<br><h3>Field Of Interest</h3>";
        $html = $html . list_convert($myInputs);
        $mpdf->WriteHTML($html);
        db_entry("fos", $myInputs);
    }

    if (!empty($mytext3)) {
        $html = "<br><h3> Projects</h3>\n";
        $html = $html . list_convert($mytext3);
        $mpdf->WriteHTML($html);
        db_entry("proj", $mytext3);

    }


    if (!empty($mytext)) {
        $html = "<br><h3>Acheivements</h3>";
        $html = $html . list_convert($mytext);
        $mpdf->WriteHTML($html);
        db_entry("achv", $mytext);

    }


    if (!empty($mytexts)) {
        $html = "<br><h3>Technical Skills</h3>";
        $html = $html . list_convert($mytexts);
        $mpdf->WriteHTML($html);
        db_entry("tech", $mytexts);

    }


    if (!empty($mytextl)) {
        $html = "<br><h3>Languages Known</h3>";
        $html = $html . list_convert($mytextl);
        $mpdf->WriteHTML($html);
        db_entry("lan", $mytextl);

    }


    if (!empty($mytext1)) {
        $html = "<br><h3>extra  Curricular activities</h3>";
        $html = $html . list_convert($mytext1);
        $mpdf->WriteHTML($html);
        db_entry("extra", $mytext1);

    }


    if (!empty($mytext2)) {
        $html = "<br><h3>Co-Curricular activities</h3>";
        $html = $html . list_convert($mytext2);
        $mpdf->WriteHTML($html);
        db_entry("cocur", $mytext2);

    }
    $sql = finish();
    if (mysqli_query($link, $sql)) {
        echo "<br>Records inserted successfully.<br>";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }

}
function finish()
{
    $temp = "INSERT INTO resume";
    $s1 = $GLOBALS['sqlfields'];
    $s2 = $GLOBALS['sqlvalues'];
    $GLOBALS['sqlfields'] = substr($s1, 0, strlen($s1) - 1);
    $GLOBALS['sqlvalues'] = substr($s2, 0, strlen($s2) - 1);
    $GLOBALS['sqlfields'] .= ")";
    $GLOBALS['sqlvalues'] .= ")";
    $temp = $temp . $GLOBALS['sqlfields'];
    $temp .= "VALUES" . $GLOBALS['sqlvalues'];
    return $temp;
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function db_entry($name, $set)
{
    $i = 0;
    foreach ($set as $x) {
        if (!empty($x)) {
            $i = $i + 1;
            $GLOBALS['sqlfields'] .= $name . $i . ",";
            $GLOBALS['sqlvalues'] .= "'" . $x . "',";


        }
    }
}

function list_convert($data)
{
    $temp = "<ul>";

    foreach ($data as $i) {
        if ($i != "") {
            $temp = $temp . "<li>" . $i . "</li>";
        }
    }
    return "</ul>" . $temp;
}


$pdf = $mpdf->Output('doc.pdf', 'S');

$mail = new PHPMailer(true);
try {

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mailtohari.ai@gmail.com';
    $mail->Password = 'hari@1998';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;


    $mail->setFrom('mailtohari.ai@gmail.com', 'HariPrasath');
    $mail->addAddress('mailtohari.ai@gmail.com');
    $mail->addAddress($email);
    $mail->addStringAttachment($pdf, 'doc.pdf');


    $mail->isHTML(true);
    $mail->Subject = 'Assignment OSS 1517110';
    $mail->Body = 'Resume is attached in this file<br>';
    $mail->AltBody = 'Resume is attached in this file';
    $mail->send();
    echo '<br>Message has been sent to  mail  specified in the resume : ' . $email;
} catch (Exception $e) {
    echo '<br>Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}

