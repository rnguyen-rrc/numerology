    <?php

    class PersonalYearCalculator
    {
        public static function calculateRaw(clsCustomer $objCustomer, int $year): int
        {
            // Day of birth
            $day   = NumerologyHelper::reduceToSingle((int)$objCustomer->getDay());
            $month = NumerologyHelper::reduceToSingle((int)$objCustomer->getMonth());

            // Universal (world) year
            $worldYear = NumerologyHelper::reduceToSingle($year);

            // Standard VERTICAL formula
            return NumerologyHelper::reduceToSingle(
                $day + $month + $worldYear
            );
        }

        public static function calculate(
            clsCustomer $objCustomer,
            ?int $year = null,
            ?int $month = null,
            ?int $day = null
        ): void {
            // If not provided, use the current date
            if ($year === null || $month === null || $day === null) {
                $current = new DateTime();
                $year  ??= (int)$current->format('Y');
                $month ??= (int)$current->format('m');
                $day   ??= (int)$current->format('d');
            }

            // Determine the active Personal Year (based on birthday)
            $activeYear = self::getActivePersonalYear(
                $objCustomer,
                $year,
                $month,
                $day
            );

            // Calculate both methods
            self::horizontal($objCustomer, $activeYear);
            self::vertical($objCustomer, $activeYear);
        }

        /**
         * Determine the active Personal Year
         */
        private static function getActivePersonalYear(
            clsCustomer $c,
            int $year,
            int $month,
            int $day
        ): int {
            $birthDay   = (int)$c->getDay();
            $birthMonth = (int)$c->getMonth();

            // Before birthday → go back one year
            if ($month < $birthMonth || ($month == $birthMonth && $day < $birthDay)) {
                return $year - 1;
            }

            return $year;
        }

        /**
         * HORIZONTAL METHOD
         */
        private static function horizontal(clsCustomer $c, int $targetYear): void
        {
            $str = $c->getDay() . $c->getMonth() . $targetYear;
            $digits = str_split($str);

            $sum = array_sum($digits);

            // Reduce to a single digit – do not keep master numbers
            while ($sum > 9) {
                $sum = array_sum(str_split((string)$sum));
            }

            $num = NumerologyHelper::buildSimple($sum);

            $c->setNumber(NumerologyKeys::PERSONAL_YEAR_H, $num);
        }

        /**
         * VERTICAL METHOD
         */
        private static function vertical(clsCustomer $c, int $targetYear): void
        {
            $day   = self::reduceSingle((int)$c->getDay());
            $month = self::reduceSingle((int)$c->getMonth());
            $year  = self::reduceSingle($targetYear);

            $sum = $day + $month + $year;

            $sum = self::reduceSingle($sum);

            $num = NumerologyHelper::buildSimple($sum);

            $c->setNumber(NumerologyKeys::PERSONAL_YEAR_V, $num);
        }

        private static function reduceSingle(int $n): int
        {
            while ($n > 9) {
                $n = array_sum(str_split((string)$n));
            }
            return $n;
        }
    }
