<?php
session_start();
include '../common/functions_file.php';
include "../common/mailjetServiceInit.php";

$result_returned = remember_user();

$response = "";
$dialog_heading = "";
$dialog_message = "";

if (isset($_POST['contact-submit']) && isset($_POST['contact-name']) && isset($_POST['contact-subject'])) {
    if (isset($_POST['contact-email']) && isset($_POST['contact-message'])) {

        $contact_name = inputCheck(false, $_POST['contact-name']);
        $contact_subject = inputCheck(false, $_POST['contact-subject']);

        $filtered_email = filter_var($_POST['contact-email'], FILTER_SANITIZE_EMAIL);
        $contact_email = inputCheck(false, $filtered_email);

        $contact_message = inputCheck(false, $_POST['contact-message']);

        $response = sendEmail($contact_email, $contact_name, $contact_subject, $contact_message);

        if ($response->success() === true) {
            $dialog_heading = "Success";
            $dialog_message = "Email sent successfully";
        } else {
            $dialog_heading = "Error";
            $dialog_message = "Something went wrong! Please be patient whilst we rectify the issue.";
        }
    }
}

if (isset($dialog_heading) && !empty($dialog_heading)) {
    if (isset($dialog_message) && !empty($dialog_message)) {
        dialog_modal($dialog_heading, $dialog_message, "Close");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php
include '../common/header.php';
?>

<body>

<?php
include '../common/navbar.php';
?>

<div class="container outermost-div px-3 px-sm-5 text-dark">
    <div class="card">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-6 d-none d-lg-flex">
                    <div class="flex-grow-1 bg-login-image"></div>
                </div>
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="text-center">
                            <h4 class="text-dark mb-4">Contact Us</h4>
                        </div>
                        <form id="contact-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                              method="post">
                            <div class="form-group">
                                <input class="form-control" type="text" id="contact-name" name="contact-name"
                                       placeholder="Your Name">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="contact-subject" name="contact-subject"
                                       placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="email" id="contact-email" name="contact-email"
                                       placeholder="Email">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" id="contact-message" name="contact-message"
                                          placeholder="Message" maxlength="700"></textarea>
                            </div>
                            <div>
                                <button class="btn btn-primary btn-block text-white" type="submit" id="contact-submit"
                                        name="contact-submit" value="contact-submit"> Submit Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include '../common/footer.php';
?>
<script src="/js/contactScript.js"></script>

</body>

</html>