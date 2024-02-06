<?php
require 'inc/header/admin-header.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

require 'inc/config/mailer-config.php';

function sendMail($email, $subject, $message)
{
    //creating a new phpmailer object
    $mail = new PHPMailer(true);

    //smtp protocol to send mail
    $mail->isSMTP();

    $mail->SMTPAuth = true;

    $mail->Host = MAILHOST;
    $mail->Username = USERNAME;
    $mail->Password = PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->setFrom(SEND_FROM, SEND_FROM_NAME);
    $mail->addAddress($email);
    $mail->addReplyTo(REPLY_TO, REPLY_TO_NAME);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AltBody = $message;

    if (!$mail->send()) {
        return "Email not sent";
    } else {
        return "success";
    }
}

if (isset($_GET['id'])) {
    $messageId = $_GET['id'];
} else {
    //redirect to complaint log
    header("Location:admin-contactus.php");
}
$sql = "SELECT * FROM contactus WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$messageId]);
$complaintDetails = $stmt->fetch();
$receiverEmail = $complaintDetails->email;


if (isset($_POST['reply'])) {
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $response = filter_input(INPUT_POST, 'response', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sql = "UPDATE contactus SET response = ? , replied = ?,attendedBy = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$response, '1', $adminId, $messageId]);

    $reply = sendMail($receiverEmail, $subject, $response);
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header">
                    <div class="card-title">
                        <h4>Message Id: <?= $messageId ?></h4>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="col-12 text-center border-primary-subtle border-top-1 border-bottom-1 d-flex flex-column ">
                        <span class="fs-5 fw-semibold ">Sent by: <?php
                                                                    echo $complaintDetails->fullname;
                                                                    ?>
                        </span>
                        <span class="fs-3">
                            <?php
                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $complaintDetails->created);
                            echo $date->format('D d M, Y H:i:s');
                            ?>
                        </span>
                        <span class="fs-3">From :
                            <?= $complaintDetails->email ?>
                        </span>
                    </div>
                </div>
                <div class="col">
                    <h5><?= $complaintDetails->message ?></h5>
                </div>



                <div class="d-flex flex-row justify-content-center">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])  ?>" method="post" class="col-lg-8 col-sm-12 border border-2 rounded-2 p-4 border-cyan">
                        <?php
                        if (@$reply == "response") { ?>
                            <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
                                Message Sent Successfully!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                                Sending Failed!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php }
                        ?>
                        <h5 class="fw-semibold text-center">Respond to this message </h5>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="validationCustom03" class="form-label">Subject: </label>
                                <div class="form-group mb-0">
                                    <textarea class="message-control form-control user-text-editor" name="subject" id="emailsubject" cols="30" rows="3" placeholder="Enter email subject"></textarea>
                                </div>
                            </div>
                        </div><!-- end col-lg-12 -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="validationCustom03" class="form-label">Response: </label>
                                <div class="form-group mb-0">
                                    <textarea class="message-control form-control user-text-editor" name="response" id="jobDescription" cols="30" rows="1" placeholder="Enter response"></textarea>
                                </div>
                            </div>
                        </div><!-- end col-lg-12 -->
                        <div class="col-12 justify-content-center align-items-center d-flex">
                            <div class="btn-box mt-4">
                                <button class=" btn btn-primary border-0 align-self-center" type="submit" name="reply">Reply</button>
                            </div><!-- end btn-box -->
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php
include 'inc/footer/admin-footer.php';
?>