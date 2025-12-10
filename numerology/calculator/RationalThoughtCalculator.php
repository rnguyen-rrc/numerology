    <?php

    class RationalThoughtCalculator
    {
        public static function calculate(clsCustomer $c): void
        {
            $nickName = $c->getNickName();
            if (!$nickName) {
                return;
            }

            // 1) MINOR NATURAL ABILITY (nickname)
            $sumName = 0;
            foreach (NumerologyHelper::toLetters($nickName) as $ch) {
                $sumName += LetterMapper::value($ch);
            }

            // keep 11 / 22 / 33
            $minor = NumerologyHelper::reduceKeepMasterInt($sumName, [11, 22, 33]);

            // 2) DAY OF BIRTH (ID)
            $day = $c->getDay();
            $day = NumerologyHelper::reduceKeepMasterInt($day, [11, 22, 33]);

            // 3) ADD RAW VALUES
            $rawSum = $minor + $day;

            // 4) BUILD RESULT
            $result = NumerologyHelper::buildStandard($rawSum, $rawSum);

            $c->setNumber(NumerologyKeys::RATIONAL_THOUGHT, $result);
        }
    }
