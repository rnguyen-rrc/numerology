    <?php

    class KarmicDebtCalculator
    {
        private const DEBTS = [
            '13/4',
            '14/5',
            '16/7',
            '19/1',
        ];

        // Keys to be checked
        private const CHECK_KEYS = [
            // Life Path
            NumerologyKeys::LIFE_PATH_H,
            NumerologyKeys::LIFE_PATH_V,

            // Expression
            NumerologyKeys::EXPRESSION_H,
            NumerologyKeys::EXPRESSION_V,

            // Soul Urge
            NumerologyKeys::SOUL_URGE_H,
            NumerologyKeys::SOUL_URGE_V,

            // Personality
            NumerologyKeys::PERSONALITY_H,
            NumerologyKeys::PERSONALITY_V,

            // Birthday
            NumerologyKeys::BIRTHDAY,

            // Maturity
            NumerologyKeys::MATURITY_H,
            NumerologyKeys::MATURITY_V,
        ];

        public static function calculate(clsCustomer $c): void
        {
            $found = [];

            foreach (self::CHECK_KEYS as $key) {
                $num = $c->getNumber($key);

                if (!$num) {
                    continue;
                }

                // Always has a value: "7" or "16/7"
                $value = (string)$num;

                if (in_array($value, self::DEBTS, true)) {
                    $found[] = [
                        'key'     => $key,
                        'display' => $value
                    ];
                }
            }

            $c->setRaw(NumerologyKeys::KARMIC_DEBTS, $found);
        }
    }
