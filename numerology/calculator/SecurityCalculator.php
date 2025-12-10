    <?php
    class SecurityCalculator
    {
        public static function calculate(clsCustomer $c): void
        {
            // 1) Get the full legal birth name
            $name = strtoupper($c->getFullName());

            // 2) Keep only letters A–Z
            $letters = preg_replace('/[^A-Z]/', '', $name);

            // 3) Count the number of letters
            $count = strlen($letters);   // example: NGUYEN MINH XUAN => 14

            // 4) Use special standard mapping:
            // 11, 22, 33, 13, 14, 16, 19 → X/Y
            // otherwise → single digit
            $num = NumerologyHelper::buildStandard($count, $count);

            // 5) Store the result on the customer
            $c->setNumber(NumerologyKeys::SECURITY, $num);
        }
    }
