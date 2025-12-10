    <?php
    class PersonalMonthCalculator
    {
        public static function calculateRaw(
            clsCustomer $objCustomer,
            int $year,
            int $month,
            int $day
        ): int {
            // call calculate() or internal logic
            self::calculate($objCustomer, $year, $month, $day);

            /** @var NumerologyNumber $num */
            $num = $objCustomer->getNumber(NumerologyKeys::PERSONAL_MONTH);

            return $num->root; // ALWAYS a single digit
        }

        /**
         * Calculate Personal Month based on birthday and calendar month
         */
        public static function calculate(
            clsCustomer $objCustomer,
            int         $year,
            int         $month,
            int         $day
        ): void
        {
            // 1) Determine the active Personal Year
            $personalYear = self::resolveActivePersonalYear(
                $objCustomer,
                $year,
                $month,
                $day
            );

            // 2) STANDARD formula:
            // Personal Month = Personal Year + calendar month
            $raw = $personalYear + $month;

            // 3) Reduce to a single digit
            // (keep 11 if desired; here we use a single digit)
            $final = NumerologyHelper::reduceToSingle($raw);

            // 4) Store the result
            $objCustomer->setNumber(
                NumerologyKeys::PERSONAL_MONTH,
                NumerologyHelper::buildSimple($final)
            );
        }

        /**
         * Determine the active Personal Year based on birthday
         */
        private static function resolveActivePersonalYear(
            clsCustomer $objCustomer,
            int         $year,
            int         $month,
            int         $day
        ): int
        {
            $birthMonth = (int)$objCustomer->getMonth();
            $birthDay   = (int)$objCustomer->getDay();

            // Before birthday → use Personal Year of the previous year
            if (
                $month < $birthMonth ||
                ($month === $birthMonth && $day < $birthDay)
            ) {
                return PersonalYearCalculator::calculateRaw($objCustomer, $year - 1);
            }

            // From birthday onward
            return PersonalYearCalculator::calculateRaw($objCustomer, $year);
        }
    }
