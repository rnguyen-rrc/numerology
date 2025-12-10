        <?php
        class AlphabetMapper
        {
            public static function value(string $char): int
            {
                $char = strtoupper($char);
                return ord($char) - ord('A') + 1;
            }
        }
