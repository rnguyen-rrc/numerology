    <?php

    class KarmicLessonCalculator
    {
        public static function calculate(clsCustomer $c): void
        {
            $name = $c->getFullName();

            // Normalize to letters A–Z
            $letters = NumerologyHelper::toLetters($name);

            $present = [];

            foreach ($letters as $char) {
                $num = LetterMapper::value($char); // 1 → 9

                if ($num >= 1 && $num <= 9) {
                    $present[$num] = true;
                }
            }

            $missing = [];

            for ($i = 1; $i <= 9; $i++) {
                if (!isset($present[$i])) {
                    $missing[] = $i;
                }
            }

            // Do NOT use NumerologyNumber here
            // because this is a list
            $c->setRaw(
                NumerologyKeys::KARMIC_LESSONS,
                $missing
            );
        }
    }
