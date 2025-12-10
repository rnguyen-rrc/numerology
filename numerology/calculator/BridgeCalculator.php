    <?php
    class BridgeCalculator
    {
        public static function calculate(clsCustomer $c): void
        {
            self::personalitySoul($c);
        }

        private static function personalitySoul(clsCustomer $c): void
        {
            $personality = $c->getNumber(NumerologyKeys::PERSONALITY_V);
            $soul        = $c->getNumber(NumerologyKeys::SOUL_URGE_V);

            // An toàn: nếu thiếu 1 trong 2
            if (!$personality || !$soul) {
                return;
            }

            $p = $personality->getRoot();
            $s = $soul->getRoot();

            $bridge = abs($p - $s);

            $c->setNumber(
                NumerologyKeys::BRIDGE_PERSONALITY_SOUL,
                NumerologyNumber::fromRoot($bridge)
            );
        }
    }
