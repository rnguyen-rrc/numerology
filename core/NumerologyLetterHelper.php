<?php
class NumerologyLetterHelper
{
    private const VOWELS = ['A', 'E', 'I', 'O', 'U'];

    public static function isYConsonant(array $chars, int $i): bool
    {
        $prev = $chars[$i - 1] ?? null;
        $next = $chars[$i + 1] ?? null;

        // Y at beginning
        if ($i === 0) {
            // Followed by vowel → consonant (Yolanda)
            if ($next !== null && self::isVowel($next)) {
                return true;
            }
            // Followed by consonant → vowel (Yvonne)
            return false;
        }

        // Y at end
        if ($next === null) {
            // After vowel → consonant (Mickey)
            if ($prev !== null && self::isVowel($prev)) {
                return true;
            }
            // After consonant → vowel (Barry)
            return false;
        }

        // Between two vowels → consonant
        if (self::isVowel($prev) && self::isVowel($next)) {
            return true;
        }

        // Between two consonants → vowel
        if (!self::isVowel($prev) && !self::isVowel($next)) {
            return false;
        }

        // Default (vowel+Y+consonant OR consonant+Y+vowel)
        // Numerology default: consonant
        return true;
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
