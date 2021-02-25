<?php
session_start();
include 'common/functions_file.php';

$result_returned = remember_user();
?>

<!DOCTYPE html>
<html lang="en">

<?php
include 'common/header.php';
?>

<body>

<?php
include 'common/navbar.php';
?>

<div class="container outermost-div px-3 px-sm-5 text-dark">
    <h4 class="">Privacy Policy</h4>
    <hr>
    <div>
        <p>
            This Privacy Policy describes how your personal information is collected, used and shared when you visit,
            register or login to winlott.harpreets.pw (the "Site").</p>

        <strong class="lead"> PERSONAL INFORMATION WE COLLECT</strong>
        <p>
            When you visit the Site, we automatically collect certain information about your device, including
            information about your web browser, IP address, time zone, and some of the cookies that are installed on
            your device. Additionally, as you browse the Site, we collect information about the individual web pages you
            visit and the activities you take part in, what websites or search terms referred you to the Site, and
            information about how you interact with the Site. We refer to this automatically-collected information as
            “Device Information.”
        </p>
        <p>
            We collect Device Information using the following technologies:

            - “Cookies” are data files that are placed on your device or computer and often include an anonymous unique
            identifier. For more information about cookies, and how to disable cookies, visit
            http://www.allaboutcookies.org.
            - “Log files” track actions occurring on the Site, and collect data including your IP address, browser type,
            Internet service provider, referring/exit pages, and date/time stamps.
            - “Web beacons,” “tags,” and “pixels” are electronic files used to record information about how you browse
            the Site.
        </p>
        <p>
            When you register/sign up on the Site, we store certain information from you, including your name, date of
            birth, country, email address and if provided by you, your phone number, address and gender. We refer
            to this information as “Account Information.”
        </p>
        <p>
            When we talk about “Personal Information” in this Privacy Policy, we are talking both about Device
            Information and Account Information.
        </p>

        <strong class="lead">HOW DO WE USE YOUR PERSONAL INFORMATION?</strong>
        <p>
            We use the Account Information that we collect generally to prefill your profile page, and provide you with
            an overview of your stored personal information. Additionally, we use this information to communicate with
            you.
        </p>
        <p>
            We use the Device Information that we collect to help us screen for potential risk, fraud and more
            generally to improve and optimize our Site (for example, remember you as a registered user and for automatic
            sign in processes).
        </p>
        <strong class="lead"> SHARING YOUR PERSONAL INFORMATION</strong>
        <p>
            Although we do not share your personal information with any third parties deliberately, we do however use
            third-party libraries, frameworks and plugins that may or may not collect information without our knowledge.
            For example, we use "Mailjet" do provide us with email service and all emails sent to and from you and the
            Site may or may not be seen, read or stored by "Mailjet" systems. These libraries, frameworks and plugins
            provide needed functionality to the Site and cannot be excluded.
        </p>
        <p>
            All steps to secure your personal information have been taken to the developer(s) best knowledge. We are
            always working on ways to make the Site more secure and robust.
            <em>
                We do however urge you NOT to store, display or send any sensitive information on on through the Site
            </em>.
        </p>
        <p>
            Finally, we may also share your Personal Information to comply with applicable laws and regulations, to
            respond to a subpoena, search warrant or other lawful request for information we receive, or to otherwise
            protect our rights.
        </p>
        <p>
            We DO NOT use your Personal Information to provide you with any targeted advertisements or marketing
            communications.
        </p>

        <strong class="lead">DO NOT TRACK</strong>
        <p>
            Please note that we do not alter our Site’s data collection and use practices when we see a Do Not Track
            signal from your browser.
        </p>

        <strong class="lead">YOUR RIGHTS</strong>
        <p>
            The Site is developed for and intended to be used within Australia. Non-australian resident, please note
            that you are welcome to use the Site. However, your information will be stored in Australia only and
            Australian User Rights may be applied to you.
        </p>

        <strong class="lead">DATA RETENTION</strong>
        <p>
            When you use the Site, we will maintain your Personal Information for our records unless and until you ask
            us to delete this information.
        </p>

        <strong class="lead">MINORS</strong>
        <p>
            The Site is not intended for individuals under the age of 18.
        </p>

        <strong class="lead">CHANGES</strong>
        <p>
            We may update this privacy policy from time to time in order to reflect, for example, changes to our
            practices or for other operational, legal or regulatory reasons.
        </p>

        <strong class="lead">CONTACT US</strong>
        <p>
            For more information about our privacy practices, if you have questions, or if you would like to make a
            complaint, you may do so via the <a href="/mainPage/contact.php">contact form</a>.
        </p>

        <p>
            <small>Last updated on February 18, 2021</small>
        </p>
    </div>
</div>

<?php
include 'common/footer.php';
?>
<script src="/js/indexScript.js"></script>

</body>

</html>