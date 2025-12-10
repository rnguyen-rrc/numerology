<?php
class SoulUrgeCalculator
{
    public static function calculate(clsCustomer $c): void
    {
        self::horizontal($c);
        self::vertical($c);
    }

    private static function horizontal(clsCustomer $c): void
    {
        $chars = NumerologyHelper::toLetters($c->getFullName());
        $sum = 0;

        foreach ($chars as $i => $char) {
            if (NumerologyHelper::isVowelChar($chars, $i)) {
                $sum += LetterMapper::value($char);
            }
        }

        $c->setNumber(
            NumerologyKeys::SOUL_URGE_H,
            NumerologyHelper::buildExpression($sum)
        );
    }

    private static function vertical(clsCustomer $c): void
    {
        $parts = NumerologyHelper::splitWords($c->getFullName());
        $reduced = [];

        foreach ($parts as $word) {
            $chars = NumerologyHelper::toLetters($word);
            $sum = 0;

            foreach ($chars as $i => $char) {
                if (NumerologyHelper::isVowelChar($chars, $i)) {
                    $sum += LetterMapper::value($char);
                }
            }

            $reduced[] = NumerologyHelper::reduceToSingle($sum);
        }

        $total = array_sum($reduced);

        $c->setNumber(
            NumerologyKeys::SOUL_URGE_V,
            NumerologyHelper::buildExpression($total)
        );
    }

}
