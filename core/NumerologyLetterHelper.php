<?php
class NumerologyLetterHelper
{
    private const VOWELS = ['A', 'E', 'I', 'O', 'U'];

    public static function isYConsonant(array $chars, int $i): bool
    {
        $prev = $chars[$i - 1] ?? null;
        $next = $chars[$i + 1] ?? null;

        // Case 1: Y at the end of the word
        if ($next === null) {
            return true;
        }

        // Case 2: Y at the beginning of the word and followed by a vowel
        if ($i === 0 && self::isVowel($next)) {
            return true;
        }

        // Case 3: Y is between two vowels
        if ($prev && $next && self::isVowel($prev) && self::isVowel($next)) {
            return true;
        }

        // Case 4: before Y is (vowel + consonant), after Y is a vowel
        if (
            $i >= 2 &&
            self::isVowel($chars[$i - 2]) &&
            !self::isVowel($prev) &&
            self::isVowel($next)
        ) {
            return true;
        }

        return false;
    }

    public static function isYVowel(array $chars, int $i): bool
    {
        return !self::isYConsonant($chars, $i);
    }

    private static function isVowel(?string $c): bool
    {
        return $c && in_array($c, self::VOWELS, true);
    }

    public static function isConsonant(string $char): bool
    {
        return ctype_alpha($char) && !self::isVowel($char);
    }
}
