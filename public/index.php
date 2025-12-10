<?php
require('../constants.php');
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="<?=BASE_URL?>assets/main.css?">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="<?=BASE_URL?>assets/main.js"></script>
        <title>Huyen Hoc Chuyen Hoa - User Information Form</title>
    </head>

    <body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <ul>
            <li><a href="<?=BASE_URL?>public/index.php">Home</a></li>
            <li><a href="<?=BASE_URL?>public/index.php">Login</a></li>
            <li><a href="<?=BASE_URL?>public/index.php">Users</a></li>
            <li><a href="#formNumSection">Enter Reading</a></li>
        </ul>
    </nav>

    <div id="formNumSection" class="form-container">
        <h1>Numerology</h1>

        <form action="<?=BASE_URL?>export/NumHTMLReport.php" method="post">
            <div class="form-group">
                <label for="fullName">Full Name (*)</label>
                <input type="text" id="fullName" name="fullName" value="" required />
                <p class="error fullname-error">Full name can not be empty.</p>
            </div>

            <div class="form-group">
                <label for="nickName">Short Name (*)</label>
                <input type="text" id="nickName" name="nickName" value="" required />
                <p class="error nickname-error">Short name can not be empty.</p>
            </div>


            <div class="form-group inline-group">
                <div class="inline-field">
                    <label for="dob">Date of Birth (*)</label>
                    <input type="date" id="dob" name="dob" value="" required />
                    <p class="error dob-error">DOB can not be empty.</p>
                </div>

                <div class="inline-field">
                    <label for="birthtime">Time of Birth</label>
                    <input type="time" id="birthtime" name="birthtime" />
                </div>
            </div>


            <div class="form-group">
                <label for="birthplace">Place of Birth</label>
                <input type="text" id="birthplace" name="birthplace" value="" />
            </div>

            <div class="form-group inline-group">
                <div class="inline-field">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="" />
                    <p class="error email-phone-error">Both email and telephone can not be empty.</p>
                </div>

                <div class="inline-field">
                    <label for="telephone">Telephone</label>
                    <input type="tel" id="telephone" name="telephone" />
                </div>
            </div>

            <div class="buttons">
                <button type="submit" id="numCalculate">Calculate</button>
                <button type="submit" id="numToExcel">Export</button>
<!--                <input type="reset" id="numReset" value="Reset" />-->
            </div>
        </form>
    </div>

    </body>

    </html>
