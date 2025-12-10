    <?php

    class PinnacleCalculator
    {
        public static function calculate(clsCustomer $c): void
        {
            // Reduce day / month / year first
            $day   = NumerologyHelper::reduceKeep([11,22,33], (int)$c->getDay());
            $month = NumerologyHelper::reduceKeep([11,22,33], (int)$c->getMonth());
            $year  = NumerologyHelper::reduceKeep([11,22,33], (int)$c->getYear());

            // Pinnacle 1: Month + Day
            self::set(
                $c,
                NumerologyKeys::PINNACLE_1,
                $month + $day
            );

            // Pinnacle 2: Day + Year
            self::set(
                $c,
                NumerologyKeys::PINNACLE_2,
                $day + $year
            );

            // Pinnacle 3: P1 + P2
            $p1 = $c->getNumber(NumerologyKeys::PINNACLE_1)->raw;
            $p2 = $c->getNumber(NumerologyKeys::PINNACLE_2)->raw;

            self::set(
                $c,
                NumerologyKeys::PINNACLE_3,
                $p1 + $p2
            );

            // Pinnacle 4: Month + Year
            self::set(
                $c,
                NumerologyKeys::PINNACLE_4,
                $month + $year
            );
        }

        private static function set(clsCustomer $c, string $key, int $rawSum): void
        {
            $c->setNumber(
                $key,
                NumerologyHelper::buildStandard($rawSum, $rawSum)
            );
        }

        public static function calculateAges(clsCustomer $c): void
        {
            // Vertical Life Path (root)
            $lifePathRoot = NumerologyHelper::getPureRoot(
                $c->getNumber(NumerologyKeys::LIFE_PATH_VERTICAL)
            );

            // Age 1
            $age1 = ($lifePathRoot === 11)
                ? 25
                : 36 - $lifePathRoot;

            $c->setNumber(NumerologyKeys::PINNACLE_AGE_1, new NumerologyNumber($age1, $age1));
            $c->setNumber(NumerologyKeys::PINNACLE_AGE_2, new NumerologyNumber($age1 + 9,  $age1 + 9));
            $c->setNumber(NumerologyKeys::PINNACLE_AGE_3, new NumerologyNumber($age1 + 18, $age1 + 18));
            $c->setNumber(NumerologyKeys::PINNACLE_AGE_4, new NumerologyNumber($age1 + 27, $age1 + 27));
        }

        public static function calculateYears(clsCustomer $c): void
        {
            $yearOfBirth = (int) $c->getYear();

            $age1 = $c->getNumber(NumerologyKeys::PINNACLE_AGE_1)->raw;

            $year1 = $yearOfBirth + $age1;

            $c->setNumber(
                NumerologyKeys::PINNACLE_YEAR_1,
                new NumerologyNumber($year1, $year1)
            );
            $c->setNumber(NumerologyKeys::PINNACLE_YEAR_2, new NumerologyNumber($year1 + 9,  $year1 + 9));
            $c->setNumber(NumerologyKeys::PINNACLE_YEAR_3, new NumerologyNumber($year1 + 18, $year1 + 18));
            $c->setNumber(NumerologyKeys::PINNACLE_YEAR_4, new NumerologyNumber($year1 + 27, $year1 + 27));
        }
    }
