    <?php

    class BalanceCalculator
    {
        public static function calculate(clsCustomer $c): void
        {
            if (!$c->getFullName()) {
                return;
            }

            self::vertical($c);
            self::horizontal($c);
        }

        /**
         * Get the first letter of each word
         * "TRAN MINH HUNG" → ['T', 'M', 'H']
         */
        private static function getInitialLetters(clsCustomer $c): array
        {
            $words   = NumerologyHelper::splitWords($c->getFullName());
            $letters = [];

            foreach ($words as $word) {
                $chars = NumerologyHelper::toLetters($word);
                if (!empty($chars)) {
                    $letters[] = $chars[0];
                }
            }

            return $letters;
        }

        /**
         * VERTICAL SUM:
         *  - T=20 → 2 (keep 11, 22)
         *  - M=13 → 4
         *  - H=8
         *  → 2 + 4 + 8 = 14 → 14/5
         */
        private static function vertical(clsCustomer $c): void
        {
            $letters = self::getInitialLetters($c);
            $sum     = 0;

            foreach ($letters as $char) {
                $value   = LetterMapper::value($char); // A=1..Z=26
                $reduced = NumerologyHelper::reduceKeepMasterInt($value, [11, 22]);
                $sum    += $reduced;
            }

            // 14 → 14/5, 17 → 17/8, ...
            $c->setNumber(
                NumerologyKeys::BALANCE_V,
                NumerologyHelper::buildStandard($sum, $sum)
            );
        }

        /**
         * HORIZONTAL SUM:
         *  - T=20
         *  - M=13
         *  - H=8
         *  → 20 + 13 + 8 = 41 → 41/5
         */
        private static function horizontal(clsCustomer $c): void
        {
            $letters = self::getInitialLetters($c);
            $raw     = 0;

            foreach ($letters as $char) {
                $raw += AlphabetMapper::value($char);
            }

            // Manually reduce to a single digit to get the root
            $root = NumerologyHelper::reduceToSingleInt($raw);

            // 41 → 41/5 (raw/root)
            $num = new NumerologyNumber(
                raw: $raw,
                root: $root,
                display: "{$raw}/{$root}"
            );

            $c->setNumber(NumerologyKeys::BALANCE_H, $num);
        }
    }
