<?php
class BirthdayCalculator
{
    public static function calculate(clsCustomer $c): void
    {
        $day = (int) $c->getDay();

        $c->setNumber(
            NumerologyKeys::BIRTHDAY,
            NumerologyHelper::buildBirthday($day)
        );
    }
}
