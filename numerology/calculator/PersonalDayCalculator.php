    <?php

    class PersonalDayCalculator
    {
        public static function calculate(
            clsCustomer $objCustomer,
            int $year,
            int $month,
            int $day
        ): void {
            // 1) Get the active Personal Month (birthday adjustment handled internally)
            $personalMonth = PersonalMonthCalculator::calculateRaw(
                $objCustomer,
                $year,
                $month,
                $day
            );

            // 2) Split the current day into individual digits
            $dayDigitsSum = array_sum(str_split((string)$day));

            // 3) Add Personal Month + Day
            $raw = $personalMonth + $dayDigitsSum;

            // 4) Reduce to a single digit (do NOT keep 11, 22)
            $root = NumerologyHelper::reduceToSingle($raw);

            // 5) Store the result
            $objCustomer->setNumber(
                NumerologyKeys::PERSONAL_DAY,
                NumerologyHelper::buildSimple($root)
            );
        }
    }
