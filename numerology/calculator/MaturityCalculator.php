    <?php

    class MaturityCalculator
    {
        public static function calculate(clsCustomer $c): void
        {
            self::vertical($c);
            self::horizontal($c);
        }

        /**
         * METHOD 2 – VERTICAL SUM
         * root(Life Path) + root(Expression)
         * keep 11/22/33 when adding
         */
        private static function vertical(clsCustomer $c): void
        {
            $life = $c->getNumber(NumerologyKeys::LIFE_PATH_V)
                ?? $c->getNumber(NumerologyKeys::LIFE_PATH_H);

            $expr = $c->getNumber(NumerologyKeys::EXPRESSION_V)
                ?? $c->getNumber(NumerologyKeys::EXPRESSION_H);

            if (!$life || !$expr) return;

            // root already handles 11/22/33
            $lifeRoot = $life->root;
            $exprRoot = $expr->root;

            $sum = $lifeRoot + $exprRoot;

            $num = NumerologyHelper::buildStandard($sum, $sum);

            $c->setNumber(NumerologyKeys::MATURITY_V, $num);
        }

        /**
         * METHOD 1 – HORIZONTAL SUM
         * raw(Life Path) + raw(Expression)
         */
        private static function horizontal(clsCustomer $c): void
        {
            $life = $c->getNumber(NumerologyKeys::LIFE_PATH_H)
                ?? $c->getNumber(NumerologyKeys::LIFE_PATH_V);

            $expr = $c->getNumber(NumerologyKeys::EXPRESSION_H)
                ?? $c->getNumber(NumerologyKeys::EXPRESSION_V);

            if (!$life || !$expr) return;

            // raw is the value before the slash
            $lifeRaw = (int)$life->raw;
            $exprRaw = (int)$expr->raw;

            $sumRaw = $lifeRaw + $exprRaw;

            $num = NumerologyHelper::buildStandard($sumRaw, $sumRaw);

            $c->setNumber(NumerologyKeys::MATURITY_H, $num);
        }
    }
