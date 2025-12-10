    <?php

    class AttitudeCalculator
    {
        public static function calculate(clsCustomer $objCustomer): void
        {
            self::horizontal($objCustomer);
            self::vertical($objCustomer);
        }

        private static function horizontal(clsCustomer $objCustomer): void
        {
            $str = $objCustomer->getDay() . $objCustomer->getMonth();
            $sum = array_sum(str_split($str));

            $num = NumerologyHelper::buildStandard($sum, $sum);
            $objCustomer->setNumber(NumerologyKeys::ATTITUDE_H, $num);
        }

        private static function vertical(clsCustomer $objCustomer): void
        {
            $day   = (int)$objCustomer->getDay();
            $month = (int)$objCustomer->getMonth();

            // 1) Day of birth: reduce to a single digit, KEEP 11 and 22
            if ($day === 11 || $day === 22) {
                $dayReduced = $day;
            } else {
                $dayReduced = self::digitSumToSingle($day);
            }

            // 2) Month of birth: reduce to a single digit, KEEP 11
            if ($month === 11) {
                $monthReduced = $month;
            } else {
                $monthReduced = self::digitSumToSingle($month);
            }

            // Example: 12/11 → day = 3, month = 11 → total = 14
            $total = $dayReduced + $monthReduced;

            // 3) Capture 11, 22, 33, 13, 14, 16, 19 → example: 14 → 14/5
            $num = NumerologyHelper::buildStandard($total, $total);

            $objCustomer->setNumber(NumerologyKeys::ATTITUDE_V, $num);
        }

        // Reduce to a single digit
        private static function digitSumToSingle(int $number): int
        {
            while ($number > 9) {
                $number = array_sum(str_split((string)$number));
            }
            return $number;
        }
    }
