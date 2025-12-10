    <?php

    class ExpressionCalculator
    {
        public static function calculate(clsCustomer $c): void
        {
            if (!$c->hasFullName()) {
                return;
            }

            self::horizontal($c);
            self::vertical($c);
        }

        private static function horizontal(clsCustomer $c): void
        {
            $name = $c->getFullName();

            if (!$name || trim($name) === '') {
                return; // do not calculate if the name is missing
            }

            $letters = NumerologyHelper::toLetters($name);

            $sum = 0;
            foreach ($letters as $char) {
                $sum += LetterMapper::value($char);
            }

            $c->setNumber(
                NumerologyKeys::EXPRESSION_H,
                NumerologyHelper::buildExpression($sum)
            );
        }

        private static function vertical(clsCustomer $c): void
        {
            $parts   = NumerologyHelper::splitWords($c->getFullName());
            $reduced = [];

            foreach ($parts as $word) {
                $sum = 0;
                foreach (NumerologyHelper::toLetters($word) as $char) {
                    $sum += LetterMapper::value($char);
                }

                // Reduce to a single digit for each word only
                // (no karmic number handling at this step)
                $reduced[] = NumerologyHelper::reduceToSingle($sum);
            }

            $total = array_sum($reduced);

            $c->setNumber(
                NumerologyKeys::EXPRESSION_V,
                NumerologyHelper::buildExpression($total) // handle karmic numbers here
            );
        }
    }
