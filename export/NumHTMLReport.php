    <?php

    require_once __DIR__ . '/../autoload.php';
    require('../constants.php');

    $fullName   = $_REQUEST['fullName'];
    $nickName   = $_REQUEST['nickName'];
    $dob        = $_REQUEST['dob'];
    $email      = $_REQUEST['email'];
    $phone      = $_REQUEST['telephone'];

    $objCustomer = new clsCustomer($fullName, $dob, $email, $phone, $nickName);
    //store user - wip

    //calculate numbers
    BirthdayCalculator::calculate($objCustomer);
    LifePathCalculator::calculate($objCustomer);
    PinnacleCalculator::calculate($objCustomer);
    PinnacleCalculator::calculateAges($objCustomer);
    PinnacleCalculator::calculateYears($objCustomer);
    ChallengeCalculator::calculate($objCustomer);
    LifePathPeriodCalculator::calculate($objCustomer);
    AttitudeCalculator::calculate($objCustomer);
    PersonalYearCalculator::calculate($objCustomer, 2024);
    PersonalMonthCalculator::calculate(
        $objCustomer,
        (int)date('Y'),
        (int)date('m'),
        (int)date('d')
    );
    PersonalDayCalculator::calculate(
        $objCustomer,
        (int)date('Y'),
        (int)date('m'),
        (int)date('d')
    );
    ExpressionCalculator::calculate($objCustomer);
    SoulUrgeCalculator::calculate($objCustomer);
    PersonalityCalculator::calculate($objCustomer);
    BridgeCalculator::calculate($objCustomer);
    KarmicLessonCalculator::calculate($objCustomer);
    SubconsciousConfidenceCalculator::calculate($objCustomer);
    BalanceCalculator::calculate($objCustomer);
    HiddenPassionCalculator::calculate($objCustomer);
    SecurityCalculator::calculate($objCustomer);
    InnerConflictCalculator::calculate($objCustomer);
    MaturityCalculator::calculate($objCustomer);
    KarmicDebtCalculator::calculate($objCustomer);
    $arrDebts = $objCustomer->getRaw(NumerologyKeys::KARMIC_DEBTS);
    $arrDebtValues = [];
    foreach($arrDebts as $debts):
        foreach($debts as $index => $debt):
            if($index === "display"):
                $arrDebtValues[] = $debt;
            endif;
        endforeach;
    endforeach;
    RationalThoughtCalculator::calculate($objCustomer);

    //generate template 1, export to pdf - wip

    //generate template 2, export to same pdf - wip
    ?>
    <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8" />
            <link rel="stylesheet" href="<?=BASE_URL?>main.css">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="<?=BASE_URL?>main.js"></script>
            <title>User Information Form</title>
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

            <div class="customer-container">
                <div class="number-result">
                    <h2>Customer's Information</h2>
                    <table class="customer-table">
                        <thead>
                        <tr>
                            <th><br><br></th>
                            <th><br><br></th>
                        </tr>
                        </thead>
                        <tr>
                            <td>Full Name <br>(Tên đầy đủ)</td>
                            <td><?=$fullName?></td>
                        </tr>
                        <tr>
                            <td>Short Name <br>(Tên thường gọi)</td>
                            <td><?=$nickName?></td>
                        </tr>
                        <tr>
                            <td>DOB <br>(Ngày tháng năm sinh)</td>
                            <td><?=$dob?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?=$email?></td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td><?=$phone?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="result-container">
                <div class="number-result">
                    <h2>Numerology Numbers</h2>

                    <table class="number-table">
                        <thead>
                        <tr>
                            <th style="width: 35%;">Number Name</th>
                            <th style="width: 15%;">1<br>(Vertical)</th>
                            <th style="width: 15%;">2<br>(Horizontal)</th>
                            <th style="width: 15%;">3</th>
                            <th style="width: 15%;">4</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Birthday Number <br>(Năng Lực Bẩm Sinh)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::BIRTHDAY) ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Life Path <br>(Đường đời)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::LIFE_PATH_V) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::LIFE_PATH_H) ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Pinnacles <br>(Bốn Đỉnh)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PINNACLE_1) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PINNACLE_2) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PINNACLE_3) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PINNACLE_4) ?></td>
                        </tr>
                        <tr>
                            <td>Pinnacle Pages <br>(4 Đỉnh Tuổi)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PINNACLE_AGE_1) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PINNACLE_AGE_2) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PINNACLE_AGE_3) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PINNACLE_AGE_4) ?></td>
                        </tr>
                        <tr>
                            <td>Pinnacle Years <br>(4 Đỉnh Năm)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PINNACLE_YEAR_1) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PINNACLE_YEAR_2) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PINNACLE_YEAR_3) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PINNACLE_YEAR_4) ?></td>
                        </tr>
                        <tr>
                            <td>Challenges <br>(4 Thử Thách)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::CHALLENGE_1) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::CHALLENGE_2) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::CHALLENGE_3) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::CHALLENGE_4) ?></td>
                        </tr>
                        <tr>
                            <td>Life Path Periods <br>(3 Chu Kỳ Vòng Đời)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::LIFE_PERIOD_1) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::LIFE_PERIOD_2) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::LIFE_PERIOD_3) ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Attitude <br>(Chỉ số Thái Độ)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::ATTITUDE_V) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::ATTITUDE_H) ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Personal Year <br>(Năm Cá Nhân)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PERSONAL_YEAR_H) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PERSONAL_YEAR_V) ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Personal Month <br>(Tháng Cá Nhân)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PERSONAL_MONTH)->display ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Personal Day <br>(Ngày Cá Nhân)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PERSONAL_DAY)->display ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Expression <br>(Năng Lực Tự Nhiên)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::EXPRESSION_V) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::EXPRESSION_H) ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Soul Urge/Heart's Desire <br>(Động Lực Tâm Hồn)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::SOUL_URGE_V) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::SOUL_URGE_H) ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Personality <br>(Nhân Cách)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PERSONALITY_V) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::PERSONALITY_H) ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Bridge Number <br>(Kết nối Nhân Cách với Tâm Hồn)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::BRIDGE_PERSONALITY_SOUL) ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Karmic Lessons <br>(Bài học Nghiệp Quả)</td>
                            <td><?= implode(", ", $objCustomer->getRaw(NumerologyKeys::KARMIC_LESSONS)) ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Subconscious Confidence <br>(Phản Hồi Tiềm Thức)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::SUBCONSCIOUS) ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Balance <br>(Cân Bằng)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::BALANCE_V)->display ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::BALANCE_H)->display ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Hidden Passion <br>(Nội Cảm)</td>
                            <td><?= is_array($objCustomer->getNumber(NumerologyKeys::HIDDEN_PASSION)) ? implode(", ", $objCustomer->getNumber(NumerologyKeys::HIDDEN_PASSION)) : $objCustomer->getNumber(NumerologyKeys::HIDDEN_PASSION) ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Security <br>(Bảo Mật)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::SECURITY) ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Inner Conflict <br>(Mâu thuẫn Nội Tâm)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::INNER_CONFLICT) ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Maturity Number <br>(Chỉ số Trưởng Thành)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::MATURITY_V) ?></td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::MATURITY_H) ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Karmic Debt <br>(Nợ Nghiệp)</td>
                            <td><?= implode(", ", $arrDebtValues) ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Rational Thought <br>(Tư Duy Lý Trí)</td>
                            <td><?= $objCustomer->getNumber(NumerologyKeys::RATIONAL_THOUGHT) ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </body>
    </html>