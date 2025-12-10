    <?php

    class NumerologyHelper
    {
        private const SPECIAL = [
            11 => '11/2',
            22 => '22/4',
            33 => '33/6',
            13 => '13/4',
            14 => '14/5',
            16 => '16/7',
            19 => '19/1',
        ];
        private const VOWELS = ['A','E','I','O','U'];

        public static function buildBirthday(int $day): NumerologyNumber
        {
            $root = $day;
            while ($root > 9) {
                $root = array_sum(str_split((string)$root));
            }

            return new NumerologyNumber(
                raw: $day,
                root: $root,
                display: (string)$root
            );
        }

        public static function buildLifePath(int $sum): NumerologyNumber
        {
            $raw = $sum;

            if (isset(self::SPECIAL[$sum])) {
                [$l, $r] = explode('/', self::SPECIAL[$sum]);
                return new NumerologyNumber($raw, (int)$r, self::SPECIAL[$sum]);
            }

            while ($sum > 9) {
                $sum = array_sum(str_split((string)$sum));

                if (isset(self::SPECIAL[$sum])) {
                    [$l, $r] = explode('/', self::SPECIAL[$sum]);
                    return new NumerologyNumber($raw, (int)$r, self::SPECIAL[$sum]);
                }
            }

            return new NumerologyNumber($raw, $sum);
        }

        public static function reduceKeepMaster(int $num, array $keepList = [11,22,33,13,14,16,19]): NumerologyNumber
        {
            $raw = $num;

            while ($num > 9) {
                if (in_array($num, $keepList)) {
                    return NumerologyNumber::fromRawRoot($raw, $num);
                }
                $num = array_sum(str_split((string)$num));
            }

            // Nếu rơi vào karmic/master sau rút gọn
            if (in_array($num, $keepList)) {
                return NumerologyNumber::fromRawRoot($raw, $num);
            }

            return NumerologyNumber::fromRoot($num);
        }

        public static function reduceKeep(array $keep, int $number): int
        {
            while ($number > 9 && !in_array($number, $keep)) {
                $number = array_sum(str_split((string)$number));
            }
            return $number;
        }

        public static function getPureRoot($value): int
        {
            if ($value instanceof NumerologyNumber) {
                return $value->root;
            }

            if (is_string($value) && str_contains($value, '/')) {
                return (int) explode('/', $value)[1];
            }

            return (int)$value;
        }

        public static function buildStandard(int $raw, int $sum): NumerologyNumber
        {
            // Catch special numbers directly from the initial total
            if (isset(self::SPECIAL[$sum])) {
                [$l, $r] = explode('/', self::SPECIAL[$sum]);
                return new NumerologyNumber($raw, (int)$r, self::SPECIAL[$sum]);
            }

            // Then perform digit reduction
            while ($sum > 9) {
                $sum = array_sum(str_split((string)$sum));

                if (isset(self::SPECIAL[$sum])) {
                    [$l, $r] = explode('/', self::SPECIAL[$sum]);
                    return new NumerologyNumber($raw, (int)$r, self::SPECIAL[$sum]);
                }
            }

            // Normal case → return root number only
            return new NumerologyNumber($raw, $sum);
        }

        // used for vertical Attitude calculation
        public static function reduceKeepList(int $number, array $keep): NumerologyNumber
        {
            $raw = $number;

            if (in_array($number, $keep)) {
                return self::buildStandard($raw, $number);
            }

            while ($number > 9) {
                $number = array_sum(str_split((string)$number));
                if (in_array($number, $keep)) {
                    return self::buildStandard($raw, $number);
                }
            }

            return self::buildStandard($raw, $number);
        }

        public static function reduceToSingle(int $number): int
        {
            while ($number > 9) {
                $number = array_sum(str_split((string)$number));
            }
            return $number;
        }

        public static function buildSimple(int $value): NumerologyNumber
        {
            // ép rút về số đơn
            while ($value > 9) {
                $value = array_sum(str_split((string)$value));
            }

            return new NumerologyNumber(
                raw: $value,
                root: $value,
                display: (string)$value
            );
        }

        /**
         * Reduce to a single digit (1–9)
         * DOES NOT preserve master or karmic numbers
         */
        public static function reduceToSingleInt(int $n): int
        {
            while ($n > 9) {
                $n = array_sum(str_split((string)$n));
            }
            return $n;
        }

        /**
         * Build Expression Number from the final summed value.
         * - If the result is 11, 22, 33, 13, 14, 16, or 19 → return in X/Y format
         * - Otherwise → return a single digit (1–9)
         */

        /**
         * Split full name into words
         * Example: "VI VAN CHUNG" → ['VI', 'VAN', 'CHUNG']
         */
        public static function splitWords(string $fullName): array
        {
            $name = strtoupper(trim($fullName));
            $name = preg_replace('/[^A-Z\s]/', '', $name);
            return array_values(array_filter(explode(' ', $name)));
        }

        /**
         * Convert a word into an array of letters
         * Example: "VI" → ['V', 'I']
         */
        public static function toLetters(string $word): array
        {
            if (!$word) {
                return [];
            }

            $word = strtoupper($word);
            $word = preg_replace('/[^A-Z]/', '', $word);

            return str_split($word);
        }


        public static function buildExpression(int $sum): NumerologyNumber
        {
            $special = [
                11 => 2,
                22 => 4,
                33 => 6,
                13 => 4,
                14 => 5,
                16 => 7,
                19 => 1
            ];

            // Step 1: gradually reduce, but MUST capture 13–14–16–19
            while ($sum > 9) {

                if (isset($special[$sum])) {
                    return NumerologyNumber::fromRawRoot($sum, $special[$sum]);
                }

                $sum = array_sum(str_split((string)$sum));
            }

            // Step 2: if it is a single number, return it directly
            return NumerologyNumber::fromRoot($sum);
        }

        public static function isVowelChar(array $chars, int $index): bool
        {
            $char = $chars[$index] ?? null;

            if ($char === null) {
                return false;
            }

            // A E I O U
            if (in_array($char, ['A','E','I','O','U'], true)) {
                return true;
            }

            // Y → delegate to LetterHelper
            if ($char === 'Y') {
                return NumerologyLetterHelper::isYVowel($chars, $index);
            }

            return false;
        }

        public static function reduceKeepMasterInt(int $number, array $keep): int
        {
            while ($number > 9) {
                if (in_array($number, $keep, true)) {
                    return $number;
                }
                $number = array_sum(str_split((string)$number));
            }
            return $number;
        }
    }

