    <?php
        class LetterMapper {
        private static array $map = [
            1=>['A','J','S'], 2=>['B','K','T'], 3=>['C','L','U'],
            4=>['D','M','V'], 5=>['E','N','W'], 6=>['F','O','X'],
            7=>['G','P','Y'], 8=>['H','Q','Z'], 9=>['I','R']
        ];

        public static function value(string $char): int {
            foreach (self::$map as $n => $letters) {
                if (in_array($char, $letters)) return $n;
            }
            return 0;
        }
    }

