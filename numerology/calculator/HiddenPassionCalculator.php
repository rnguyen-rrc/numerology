    <?php

    class HiddenPassionCalculator
    {
        public static function calculate(clsCustomer $c): void
        {
            $letters = NumerologyHelper::toLetters($c->getFullName());
            $counts = [];

            // 1) Count number frequencies
            foreach ($letters as $char) {
                $num = LetterMapper::value($char); // mapping table 1–9

                if ($num < 1 || $num > 9) continue;

                $counts[$num] = ($counts[$num] ?? 0) + 1;
            }

            if (empty($counts)) {
                $c->setNumber(
                    NumerologyKeys::HIDDEN_PASSION,
                    new NumerologyNumber(raw: null, root: null, display: '—')
                );
                return;
            }

            // 2) Find the highest frequency
            $max = max($counts);

            // 3) Get numbers with the same highest frequency
            $hidden = array_keys(
                array_filter($counts, fn($v) => $v === $max)
            );

            // 4) Set the result
            if (count($hidden) === 1) {
                $c->setNumber(
                    NumerologyKeys::HIDDEN_PASSION,
                    NumerologyNumber::fromRoot($hidden[0])
                );
            } else {
                // multiple hidden passions
                $c->setRaw(
                    NumerologyKeys::HIDDEN_PASSION,
                    $hidden   // array<int>
                );
            }
        }
    }
