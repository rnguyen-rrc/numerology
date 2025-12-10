    <?php
    class InnerConflictCalculator
    {
        public static function calculate(clsCustomer $c): void
        {
            // Prefer using vertical Life Path (most accurate)
            $lifePath = $c->getNumber(NumerologyKeys::LIFE_PATH_V)
                ?? $c->getNumber(NumerologyKeys::LIFE_PATH_H);

            // Prefer using vertical Expression
            $expression = $c->getNumber(NumerologyKeys::EXPRESSION_V)
                ?? $c->getNumber(NumerologyKeys::EXPRESSION_H);

            if (!$lifePath || !$expression) {
                return;
            }

            // 1) Get the ROOT value (already handles 11/2, 22/4, etc.)
            $lifeRoot = NumerologyHelper::getPureRoot($lifePath);
            $exprRoot = NumerologyHelper::getPureRoot($expression);

            // 2) Absolute difference
            $value = abs($lifeRoot - $exprRoot);

            // 3) Always a single digit
            $num = NumerologyHelper::buildSimple($value);

            // 4) Store the result
            $c->setNumber(NumerologyKeys::INNER_CONFLICT, $num);
        }
    }
