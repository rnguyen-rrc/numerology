    <?php
    class SubconsciousConfidenceCalculator
    {
        public static function calculate(clsCustomer $c): void
        {
            // Full Name is required to obtain Karmic Lessons
            if (!$c->hasFullName()) {
                return;
            }

            // Get Karmic Lessons from raw data
            $missing = $c->getRaw(NumerologyKeys::KARMIC_LESSONS);

            // If Karmic Lessons have not been calculated, do nothing
            if (!is_array($missing)) {
                return;
            }

            $count = count($missing);

            $value = 9 - $count;

            // Ensure the value is within the range 1–9
            if ($value < 1) {
                $value = 1;
            }

            $c->setNumber(
                NumerologyKeys::SUBCONSCIOUS,
                NumerologyNumber::fromRoot($value)
            );
        }
    }
