    <?php

    class LifePathCalculator
    {
        public static function calculate(clsCustomer $c): void
        {
            self::horizontal($c);
            self::vertical($c);
        }

        /**
         * HORIZONTAL METHOD
         * Sum all digits of day + month + year, then reduce.
         */
        private static function horizontal(clsCustomer $c): void
        {
            $sum =
                array_sum(str_split($c->getDay())) +
                array_sum(str_split($c->getMonth())) +
                array_sum(str_split($c->getYear()));

            $result = NumerologyHelper::buildLifePath($sum);

            $c->setNumber(NumerologyKeys::LIFE_PATH_H, $result);
        }

        /**
         * VERTICAL METHOD
         * Reduce each component (day / month / year) first, then add them together.
         */
        private static function vertical(clsCustomer $c): void
        {
            // reduceKeepMaster returns a NumerologyNumber → must use ->root
            $dayObj   = NumerologyHelper::reduceKeepMaster((int)$c->getDay(), [11, 22]);
            $monthObj = NumerologyHelper::reduceKeepMaster((int)$c->getMonth(), [11]);
            $yearObj  = NumerologyHelper::reduceKeepMaster((int)$c->getYear(), [11, 22, 33]);

            // Use root values for summation → do NOT add objects
            $sum =
                $dayObj->root +
                $monthObj->root +
                $yearObj->root;

            $result = NumerologyHelper::buildLifePath($sum);

            $c->setNumber(NumerologyKeys::LIFE_PATH_V, $result);
        }
    }
