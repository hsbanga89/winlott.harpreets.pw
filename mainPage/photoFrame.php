<?php
session_start();
include '../common/sql/dataSqlMarriage.php';
include '../common/functions_file.php';

$result_returned = remember_user();

$prefill_email = "";
$prefill_profile_array = [
    'firstname' => "",
    'lastname' => "",
    'birthday' => "",
    'phonenumber' => "",
    'gender' => "",
    'country' => "",
    'postcode' => "",
    'statename' => "",
    'suburbname' => "",
    'streetaddress' => ""
];

$error_heading = "Error";
$error_message = "";

if (isset($result_returned)) {
    $prefill_email = $result_returned;

    function populate_profile($user_email): array
    {
        $fields_array = array();
        $get_user_details = "SELECT firstname, lastname, birthday, phonenumber, gender, country, postcode, statename, suburbname, streetaddress FROM useraccounts WHERE (useremail = '$user_email')";
        $result_set = db_connect_result($get_user_details);

        if ($result_set->num_rows == 1) {
            $profile_found = $result_set->fetch_assoc();
            while ($profile_column = $result_set->fetch_field()) {
                $column_name = $profile_column->name;

                if (!empty($profile_found[$column_name])) {
                    if ($column_name === 'birthday') {
                        $fields_array[$column_name] = date('d F Y', strtotime($profile_found[$column_name]));
                    } elseif ($column_name === 'phonenumber') {
                        if (strlen($profile_found['phonenumber']) < 10) {
                            $fields_array[$column_name] = '0' . $profile_found['phonenumber'];
                        }
                    } else {
                        $fields_array[$column_name] = $profile_found[$column_name];
                    }
                }
            }
        }
        return $fields_array;
    }

    if (!isset($_POST['profile-save-button'])) {
        $prefill_profile_array = populate_profile($prefill_email);
    }

    if (isset($_POST['change-passwd-save-btn']) && !empty($prefill_profile_array)) {
        if (!empty($_POST['current-password']) && !empty($_POST['new-password']) && !empty($_POST['repeat-password'])) {
            $current_password = inputCheck(true, $_POST['current-password']);
            $new_password = inputCheck(true, $_POST['new-password']);
            $repeat_password = inputCheck(true, $_POST['repeat-password']);

            $password_pattern = "/^[A-Z]{1}[A-Za-z0-9]{7,}$/";
            preg_match($password_pattern, $current_password, $current_password_regex_match);

            if (count($current_password_regex_match) > 0) {
                if ($current_password_regex_match[0] === $current_password) {

                    preg_match($password_pattern, $new_password, $new_password_regex_match);
                    if (count($new_password_regex_match) > 0) {
                        if ($new_password_regex_match[0] === $new_password) {

                            if ($new_password === $repeat_password) {
                                $get_user_password = "SELECT birthday, password FROM useraccounts WHERE (useremail = '$prefill_email')";
                                $result_set = db_connect_result($get_user_password);
                                $profile_found = $result_set->fetch_assoc();

                                $birthday_to_date = date('d-m-Y', strtotime($prefill_profile_array['birthday']));
                                $password_salt = $prefill_email . $birthday_to_date;

                                $old_hashed_password = hash('sha512', $current_password . $password_salt);
                                $new_hashed_password = hash('sha512', $new_password . $password_salt);

                                if ($old_hashed_password !== $profile_found['password']) {
                                    $error_message = "Incorrect Current Password";
                                } else {
                                    $update_password = "UPDATE useraccounts SET password = '$new_hashed_password' WHERE (useremail = '$prefill_email')";
                                    db_connect_result($update_password);
                                    $error_message = "Password Updated";
                                }
                            } else {
                                $error_message = "New Password DOES NOT match Repeat Password";
                            }
                        }
                    }
                }
            }
        }
    }

    if (isset($_POST['profile-save-button']) && $_POST['profile-save-button'] === 'profile-save') {
        $posted_profile_fields = array();

        foreach ($_POST as $index => $item) {
            if (!empty($item)) {
                $posted_profile_fields[$index] = inputCheck(true, $item);
            }
        }

        $get_user_details = "SELECT * FROM useraccounts WHERE (useremail = '$prefill_email')";
        $result_set = db_connect_result($get_user_details);
        $profile_found = $result_set->fetch_assoc();

        if ($result_set->num_rows === 1) {
            $all_update_fields = "";

            foreach ($posted_profile_fields as $index => $item) {
                foreach ($profile_found as $key => $value) {
                    if (substr($index, 8) === $key && $item !== $value) {
                        $all_update_fields .= substr($index, 8) . " = '" . $item . "',";
                    }
                }
            }

            $all_update_fields = substr($all_update_fields, 0, strlen($all_update_fields) - 1);
            $update_profile_query = "UPDATE useraccounts SET " . $all_update_fields . " WHERE (useremail = '$prefill_email')";
            $result_set = db_connect_result($update_profile_query);
        }
        $prefill_profile_array = populate_profile($prefill_email);
    }
} else {
    display_login_page(htmlspecialchars($_SERVER['PHP_SELF']));
}

if (isset($error_message) && !empty($error_message)) {
    dialog_modal($error_heading, $error_message, "Close");
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
    <h4 class="text-dark">Profile</h4>
    <hr>
    <form id="profile-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="row py-2">
            <div class="col-md-4">
                <div class="dp-div">
                    <div class="avatar-upload">
                        <div class="avatar-preview">
                            <div id="image-preview">
                            </div>
                        </div>
                        <div class="custom-file input-div">
                            <input type="file" class="image-upload-input profile-editable-inputs" id="image-upload"
                                   accept=".png, .jpg, .jpeg" disabled>
                            <label class="btn btn-outline-primary image-upload-label disabled"
                                   for="image-upload"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="text-left">
                    <h5 class="text-dark my-3 my-md-0 mb-md-3">Personal Details</h5>
                </div>
                <div class="form-row form-group">
                    <div class="col-md-6">
                        <input type="text" id="profile-first-name" name="profile-firstname"
                               class="form-control mb-3 mb-md-0 profile-editable-inputs" placeholder="First Name"
                               value="<?php echo !empty($prefill_profile_array['firstname']) ? $prefill_profile_array['firstname'] : ''; ?>"
                               pattern="^[A-Za-z ,.'-]{1,30}$"
                               data-toggle="tooltip" title="No more than 30 characters, can contain A-Z a-z - . ' ,"
                               disabled>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="profile-last-name" name="profile-lastname"
                               class="form-control profile-editable-inputs" placeholder="Last Name"
                               value="<?php echo !empty($prefill_profile_array['lastname']) ? $prefill_profile_array['lastname'] : ''; ?>"
                               pattern="^[A-Za-z ,.'-]{1,30}$"
                               data-toggle="tooltip" title="No more than 30 characters, can contain A-Z a-z - . ' ,"
                               disabled>
                    </div>
                </div>
                <div class="form-row form-group">
                    <div class="col-md-6">
                        <input type="email" id="profile-email" class="form-control mb-3 mb-md-0"
                               placeholder="Email Address"
                               value="<?php echo !empty($prefill_email) ? $prefill_email : ''; ?>" disabled>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="profile-birthday" class="form-control"
                               placeholder="Date of Birth"
                               value="<?php echo !empty($prefill_profile_array['birthday']) ? $prefill_profile_array['birthday'] : ''; ?>"
                               disabled>
                    </div>
                </div>
                <div class="form-row form-group">
                    <div class="col-md-6">
                        <input type="tel" id="profile-mobile" name="profile-phonenumber"
                               class="form-control mb-3 mb-md-0 profile-editable-inputs" placeholder="Phone Number"
                               value="<?php echo !empty($prefill_profile_array['phonenumber']) ? $prefill_profile_array['phonenumber'] : ''; ?>"
                               pattern="^[0-9]{10}$" data-toggle="tooltip"
                               title="Must be 10 digits, exclude country code" disabled>
                    </div>
                    <div class="col-md-6">
                        <select disabled id="profile-gender" name="profile-gender"
                                class="form-control profile-editable-select">
                            <option value="" selected disabled
                                    hidden><?php echo !empty($prefill_profile_array['gender']) ? $prefill_profile_array['gender'] : 'Gender'; ?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Rather not say">Rather not say</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="py-2">
            <div class="text-left">
                <h5 class="text-dark mb-3">Postal Address</h5>
            </div>
            <div class="form-row form-group">
                <div class="col-md-4">
                    <select disabled id="profile-country" name="profile-country"
                            class="form-control mb-3 mb-md-0 profile-editable-select">
                        <option value="" selected disabled hidden>
                            <?php echo !empty($prefill_profile_array['country']) ? $prefill_profile_array['country'] : ''; ?>
                        </option>
                        <option value="Afganistan">Afghanistan</option>
                        <option value="Albania">Albania</option>
                        <option value="Algeria">Algeria</option>
                        <option value="American Samoa">American Samoa</option>
                        <option value="Andorra">Andorra</option>
                        <option value="Angola">Angola</option>
                        <option value="Anguilla">Anguilla</option>
                        <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Armenia">Armenia</option>
                        <option value="Aruba">Aruba</option>
                        <option value="Australia">Australia</option>
                        <option value="Austria">Austria</option>
                        <option value="Azerbaijan">Azerbaijan</option>
                        <option value="Bahamas">Bahamas</option>
                        <option value="Bahrain">Bahrain</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Barbados">Barbados</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Belgium">Belgium</option>
                        <option value="Belize">Belize</option>
                        <option value="Benin">Benin</option>
                        <option value="Bermuda">Bermuda</option>
                        <option value="Bhutan">Bhutan</option>
                        <option value="Bolivia">Bolivia</option>
                        <option value="Bonaire">Bonaire</option>
                        <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                        <option value="Botswana">Botswana</option>
                        <option value="Brazil">Brazil</option>
                        <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                        <option value="Brunei">Brunei</option>
                        <option value="Bulgaria">Bulgaria</option>
                        <option value="Burkina Faso">Burkina Faso</option>
                        <option value="Burundi">Burundi</option>
                        <option value="Cambodia">Cambodia</option>
                        <option value="Cameroon">Cameroon</option>
                        <option value="Canada">Canada</option>
                        <option value="Canary Islands">Canary Islands</option>
                        <option value="Cape Verde">Cape Verde</option>
                        <option value="Cayman Islands">Cayman Islands</option>
                        <option value="Central African Republic">Central African Republic</option>
                        <option value="Chad">Chad</option>
                        <option value="Channel Islands">Channel Islands</option>
                        <option value="Chile">Chile</option>
                        <option value="China">China</option>
                        <option value="Christmas Island">Christmas Island</option>
                        <option value="Cocos Island">Cocos Island</option>
                        <option value="Colombia">Colombia</option>
                        <option value="Comoros">Comoros</option>
                        <option value="Congo">Congo</option>
                        <option value="Cook Islands">Cook Islands</option>
                        <option value="Costa Rica">Costa Rica</option>
                        <option value="Cote DIvoire">Cote DIvoire</option>
                        <option value="Croatia">Croatia</option>
                        <option value="Cuba">Cuba</option>
                        <option value="Curaco">Curacao</option>
                        <option value="Cyprus">Cyprus</option>
                        <option value="Czech Republic">Czech Republic</option>
                        <option value="Denmark">Denmark</option>
                        <option value="Djibouti">Djibouti</option>
                        <option value="Dominica">Dominica</option>
                        <option value="Dominican Republic">Dominican Republic</option>
                        <option value="East Timor">East Timor</option>
                        <option value="Ecuador">Ecuador</option>
                        <option value="Egypt">Egypt</option>
                        <option value="El Salvador">El Salvador</option>
                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                        <option value="Eritrea">Eritrea</option>
                        <option value="Estonia">Estonia</option>
                        <option value="Ethiopia">Ethiopia</option>
                        <option value="Falkland Islands">Falkland Islands</option>
                        <option value="Faroe Islands">Faroe Islands</option>
                        <option value="Fiji">Fiji</option>
                        <option value="Finland">Finland</option>
                        <option value="France">France</option>
                        <option value="French Guiana">French Guiana</option>
                        <option value="French Polynesia">French Polynesia</option>
                        <option value="French Southern Ter">French Southern Ter</option>
                        <option value="Gabon">Gabon</option>
                        <option value="Gambia">Gambia</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Germany">Germany</option>
                        <option value="Ghana">Ghana</option>
                        <option value="Gibraltar">Gibraltar</option>
                        <option value="Great Britain">Great Britain</option>
                        <option value="Greece">Greece</option>
                        <option value="Greenland">Greenland</option>
                        <option value="Grenada">Grenada</option>
                        <option value="Guadeloupe">Guadeloupe</option>
                        <option value="Guam">Guam</option>
                        <option value="Guatemala">Guatemala</option>
                        <option value="Guinea">Guinea</option>
                        <option value="Guyana">Guyana</option>
                        <option value="Haiti">Haiti</option>
                        <option value="Hawaii">Hawaii</option>
                        <option value="Honduras">Honduras</option>
                        <option value="Hong Kong">Hong Kong</option>
                        <option value="Hungary">Hungary</option>
                        <option value="Iceland">Iceland</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="India">India</option>
                        <option value="Iran">Iran</option>
                        <option value="Iraq">Iraq</option>
                        <option value="Ireland">Ireland</option>
                        <option value="Isle of Man">Isle of Man</option>
                        <option value="Israel">Israel</option>
                        <option value="Italy">Italy</option>
                        <option value="Jamaica">Jamaica</option>
                        <option value="Japan">Japan</option>
                        <option value="Jordan">Jordan</option>
                        <option value="Kazakhstan">Kazakhstan</option>
                        <option value="Kenya">Kenya</option>
                        <option value="Kiribati">Kiribati</option>
                        <option value="Korea North">Korea North</option>
                        <option value="Korea Sout">Korea South</option>
                        <option value="Kuwait">Kuwait</option>
                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                        <option value="Laos">Laos</option>
                        <option value="Latvia">Latvia</option>
                        <option value="Lebanon">Lebanon</option>
                        <option value="Lesotho">Lesotho</option>
                        <option value="Liberia">Liberia</option>
                        <option value="Libya">Libya</option>
                        <option value="Liechtenstein">Liechtenstein</option>
                        <option value="Lithuania">Lithuania</option>
                        <option value="Luxembourg">Luxembourg</option>
                        <option value="Macau">Macau</option>
                        <option value="Macedonia">Macedonia</option>
                        <option value="Madagascar">Madagascar</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="Malawi">Malawi</option>
                        <option value="Maldives">Maldives</option>
                        <option value="Mali">Mali</option>
                        <option value="Malta">Malta</option>
                        <option value="Marshall Islands">Marshall Islands</option>
                        <option value="Martinique">Martinique</option>
                        <option value="Mauritania">Mauritania</option>
                        <option value="Mauritius">Mauritius</option>
                        <option value="Mayotte">Mayotte</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Midway Islands">Midway Islands</option>
                        <option value="Moldova">Moldova</option>
                        <option value="Monaco">Monaco</option>
                        <option value="Mongolia">Mongolia</option>
                        <option value="Montserrat">Montserrat</option>
                        <option value="Morocco">Morocco</option>
                        <option value="Mozambique">Mozambique</option>
                        <option value="Myanmar">Myanmar</option>
                        <option value="Nambia">Nambia</option>
                        <option value="Nauru">Nauru</option>
                        <option value="Nepal">Nepal</option>
                        <option value="Netherland Antilles">Netherland Antilles</option>
                        <option value="Netherlands">Netherlands (Holland, Europe)</option>
                        <option value="Nevis">Nevis</option>
                        <option value="New Caledonia">New Caledonia</option>
                        <option value="New Zealand">New Zealand</option>
                        <option value="Nicaragua">Nicaragua</option>
                        <option value="Niger">Niger</option>
                        <option value="Nigeria">Nigeria</option>
                        <option value="Niue">Niue</option>
                        <option value="Norfolk Island">Norfolk Island</option>
                        <option value="Norway">Norway</option>
                        <option value="Oman">Oman</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="Palau Island">Palau Island</option>
                        <option value="Palestine">Palestine</option>
                        <option value="Panama">Panama</option>
                        <option value="Papua New Guinea">Papua New Guinea</option>
                        <option value="Paraguay">Paraguay</option>
                        <option value="Peru">Peru</option>
                        <option value="Phillipines">Philippines</option>
                        <option value="Pitcairn Island">Pitcairn Island</option>
                        <option value="Poland">Poland</option>
                        <option value="Portugal">Portugal</option>
                        <option value="Puerto Rico">Puerto Rico</option>
                        <option value="Qatar">Qatar</option>
                        <option value="Republic of Montenegro">Republic of Montenegro</option>
                        <option value="Republic of Serbia">Republic of Serbia</option>
                        <option value="Reunion">Reunion</option>
                        <option value="Romania">Romania</option>
                        <option value="Russia">Russia</option>
                        <option value="Rwanda">Rwanda</option>
                        <option value="St Barthelemy">St Barthelemy</option>
                        <option value="St Eustatius">St Eustatius</option>
                        <option value="St Helena">St Helena</option>
                        <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                        <option value="St Lucia">St Lucia</option>
                        <option value="St Maarten">St Maarten</option>
                        <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                        <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                        <option value="Saipan">Saipan</option>
                        <option value="Samoa">Samoa</option>
                        <option value="Samoa American">Samoa American</option>
                        <option value="San Marino">San Marino</option>
                        <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                        <option value="Saudi Arabia">Saudi Arabia</option>
                        <option value="Senegal">Senegal</option>
                        <option value="Seychelles">Seychelles</option>
                        <option value="Sierra Leone">Sierra Leone</option>
                        <option value="Singapore">Singapore</option>
                        <option value="Slovakia">Slovakia</option>
                        <option value="Slovenia">Slovenia</option>
                        <option value="Solomon Islands">Solomon Islands</option>
                        <option value="Somalia">Somalia</option>
                        <option value="South Africa">South Africa</option>
                        <option value="Spain">Spain</option>
                        <option value="Sri Lanka">Sri Lanka</option>
                        <option value="Sudan">Sudan</option>
                        <option value="Suriname">Suriname</option>
                        <option value="Swaziland">Swaziland</option>
                        <option value="Sweden">Sweden</option>
                        <option value="Switzerland">Switzerland</option>
                        <option value="Syria">Syria</option>
                        <option value="Tahiti">Tahiti</option>
                        <option value="Taiwan">Taiwan</option>
                        <option value="Tajikistan">Tajikistan</option>
                        <option value="Tanzania">Tanzania</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Togo">Togo</option>
                        <option value="Tokelau">Tokelau</option>
                        <option value="Tonga">Tonga</option>
                        <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                        <option value="Tunisia">Tunisia</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Turkmenistan">Turkmenistan</option>
                        <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                        <option value="Tuvalu">Tuvalu</option>
                        <option value="Uganda">Uganda</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Arab Erimates">United Arab Emirates</option>
                        <option value="United States of America">United States of America</option>
                        <option value="Uraguay">Uruguay</option>
                        <option value="Uzbekistan">Uzbekistan</option>
                        <option value="Vanuatu">Vanuatu</option>
                        <option value="Vatican City State">Vatican City State</option>
                        <option value="Venezuela">Venezuela</option>
                        <option value="Vietnam">Vietnam</option>
                        <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                        <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                        <option value="Wake Island">Wake Island</option>
                        <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                        <option value="Yemen">Yemen</option>
                        <option value="Zaire">Zaire</option>
                        <option value="Zambia">Zambia</option>
                        <option value="Zimbabwe">Zimbabwe</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <input type="text" id="profile-street-address" name="profile-streetaddress"
                           class="form-control profile-editable-inputs" placeholder="Street Address"
                           value="<?php echo !empty($prefill_profile_array['streetaddress']) ? $prefill_profile_array['streetaddress'] : ''; ?>"
                           pattern="^[A-Za-z0-9 \/.-]{0,55}$"
                           data-toggle="tooltip" title="No more than 55 characters, can contain A-Z a-z 0-9 - . /"
                           disabled>
                </div>
            </div>
            <div class="form-row form-group">
                <div class="col-md-6">
                    <input type="text" id="profile-city-name" name="profile-suburbname"
                           class="form-control mb-3 mb-md-0 profile-editable-inputs" placeholder="City/Suburb"
                           value="<?php echo !empty($prefill_profile_array['suburbname']) ? $prefill_profile_array['suburbname'] : ''; ?>"
                           pattern="^[A-Za-z0-9 -]{0,30}$"
                           data-toggle="tooltip" title="No more than 30 characters, can contain A-Z a-z 0-9 -" disabled>
                </div>
                <div class="col-md-3">
                    <input type="text" id="profile-state-name" name="profile-statename"
                           class="form-control mb-3 mb-md-0 profile-editable-inputs" placeholder="State"
                           value="<?php echo !empty($prefill_profile_array['statename']) ? $prefill_profile_array['statename'] : ''; ?>"
                           pattern="^[A-Za-z0-9 -]{0,20}$"
                           data-toggle="tooltip" title="No more than 20 characters, can contain A-Z a-z 0-9 -" disabled>
                </div>
                <div class="col-md-3">
                    <input type="text" id="profile-zip-code" name="profile-postcode"
                           class="form-control profile-editable-inputs" placeholder="Postcode"
                           value="<?php echo !empty($prefill_profile_array['postcode']) ? $prefill_profile_array['postcode'] : ''; ?>"
                           pattern="^[0-9]{0,6}$" data-toggle="tooltip" title="No more than 6 digits" disabled>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-row">
            <div class="col-6 text-left">
                <button type="button" class="btn btn-outline-primary px-md-5 profile-password-button"
                        data-toggle="modal"
                        data-target="#change-password-modal">Change Password
                </button>
            </div>
            <div id="profile-edit-cancel-div" class="col-3 text-right">
                <button type="button" id="profile-edit-button" class="btn btn-outline-primary px-md-5"
                        value="profile-edit">Edit
                </button>
            </div>
            <div class="col-3 text-right">
                <button type="submit" value="profile-save" id="profile-save-button" name="profile-save-button"
                        class="btn btn-outline-primary px-md-5 disabled" disabled>Save
                </button>
            </div>
        </div>
    </form>

    <div class="modal fade" id="change-password-modal" tabindex="-1" role="dialog"
         aria-labelledby="change-password-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="fa fa-close" aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="modal-body px-4">
                        <div class="form-row form-group">
                            <input type="password" class="form-control" placeholder="Current Password"
                                   name="current-password"
                                   required>
                        </div>
                        <div class="form-row form-group">
                            <input type="password" class="form-control" placeholder="New Password"
                                   name="new-password" pattern="^[A-Z]{1}[A-Za-z0-9]{7,}$" data-toggle="tooltip"
                                   title="Must start with an uppercase letter, must be 8 or more characters long & can contain A-Z a-z 0-9"
                                   required>
                        </div>
                        <div class="form-row form-group">
                            <input type="password" class="form-control" placeholder="Repeat New Password"
                                   name="repeat-password" pattern="^[A-Z]{1}[A-Za-z0-9]{7,}$"
                                   data-toggle="tooltip" title="Must match password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="change-passwd-save-btn" class="btn btn-outline-primary">Save
                            changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include '../common/footer.php';
?>
<script src="/js/photoFrame.js"></script>

</body>

</html>
