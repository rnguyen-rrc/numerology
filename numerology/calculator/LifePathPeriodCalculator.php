    <?php
    class LifePathPeriodCalculator
    {
        public static function calculate(clsCustomer $c): void
        {
            // Period 1: Month of birth (keep 11)
            $month = (int)$c->getMonth();
            $c->setNumber(
                NumerologyKeys::LIFE_PERIOD_1,
                NumerologyHelper::reduceKeepList($month, [11])
            );

            // Period 2: Day of birth (keep karmic and master numbers)
            $day = (int)$c->getDay();
            $c->setNumber(
                NumerologyKeys::LIFE_PERIOD_2,
                NumerologyHelper::reduceKeepList(
                    $day,
                    [11, 22, 13, 14, 16, 19]
                )
            );

            // Period 3: Year of birth (keep karmic and master numbers)
            $year = (int)$c->getYear();
            $c->setNumber(
                NumerologyKeys::LIFE_PERIOD_3,
                NumerologyHelper::reduceKeepList(
                    $year,
                    [11, 22, 13, 14, 16, 19]
                )
            );
        }
    }
