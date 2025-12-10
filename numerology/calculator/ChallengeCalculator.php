    <?php
    class ChallengeCalculator
    {
        public static function calculate(clsCustomer $objCustomer): void
        {
            // 1) Reduce Day / Month / Year to a single digit
            $day   = NumerologyHelper::reduceToSingle((int)$objCustomer->getDay());
            $month = NumerologyHelper::reduceToSingle((int)$objCustomer->getMonth());
            $year  = NumerologyHelper::reduceToSingle((int)$objCustomer->getYear());

            // 2) Calculate the 4 challenges
            $c1 = abs($month - $day);
            $c2 = abs($day - $year);
            $c3 = abs($c1 - $c2);
            $c4 = abs($month - $year);

            // 3) Set values on customer (NumerologyNumber)
            self::set($objCustomer, NumerologyKeys::CHALLENGE_1, $c1);
            self::set($objCustomer, NumerologyKeys::CHALLENGE_2, $c2);
            self::set($objCustomer, NumerologyKeys::CHALLENGE_3, $c3);
            self::set($objCustomer, NumerologyKeys::CHALLENGE_4, $c4);
        }

        private static function set(clsCustomer $objCustomer, string $key, int $value): void
        {
            $objCustomer->setNumber(
                $key,
                new NumerologyNumber($value, $value)
            );
        }
    }
