    <?php

    class PersonalityCalculator
    {
        public static function calculate(clsCustomer $c): void
        {
            self::horizontal($c);
            self::vertical($c);
        }

        /* ===================================================
         * METHOD 1: HORIZONTAL SUM
         * =================================================== */
        private static function horizontal(clsCustomer $c): void
        {
            $letters = NumerologyHelper::toLetters($c->getFullName());
            $sum = 0;

            foreach ($letters as $i => $char) {

                // Standard vowels → skip
                if (in_array($char, ['A','E','I','O','U'], true)) {
                    continue;
                }

                // Letter Y
                if ($char === 'Y') {
                    if (NumerologyLetterHelper::isYConsonant($letters, $i)) {
                        $sum += LetterMapper::value('Y'); // = 7
                    }
                    continue;
                }

                // Regular consonant
                if (NumerologyLetterHelper::isConsonant($char)) {
                    $sum += LetterMapper::value($char);
                }
            }

            $c->setNumber(
                NumerologyKeys::PERSONALITY_H,
                NumerologyHelper::buildExpression($sum)
            );
        }

        /* ===================================================
         * METHOD 2: VERTICAL SUM
         * =================================================== */
        private static function vertical(clsCustomer $c): void
        {
            $words   = NumerologyHelper::splitWords($c->getFullName());
            $reduced = [];

            foreach ($words as $word) {
                $letters = NumerologyHelper::toLetters($word);
                $sumWord = 0;

                foreach ($letters as $i => $char) {

                    // Vowel → skip
                    if (in_array($char, ['A','E','I','O','U'], true)) {
                        continue;
                    }

                    // Letter Y
                    if ($char === 'Y') {
                        if (NumerologyLetterHelper::isYConsonant($letters, $i)) {
                            $sumWord += LetterMapper::value('Y');
                        }
                        continue;
                    }

                    // Regular consonant
                    if (NumerologyLetterHelper::isConsonant($char)) {
                        $sumWord += LetterMapper::value($char);
                    }
                }

                // Reduce each word (keep 11, 22, 33)
                $reducedValue = NumerologyHelper::reduceKeepMasterInt(
                    $sumWord,
                    [11,22,33]
                );

                $reduced[] = $reducedValue;
            }

            $total = array_sum($reduced);

            $c->setNumber(
                NumerologyKeys::PERSONALITY_V,
                NumerologyHelper::buildExpression($total)
            );
        }
    }
