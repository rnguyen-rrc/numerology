<?php

class clsCustomer {

    private $FullName;
    private $DOB;
    private $Email;
    private $Phone;
    private $NickName;
    private $Day;
    private $Month;
    private $Year;

    private array $Numbers = [];
    private array $raw = [];

    public function __construct($fullName, $dob, $email, $phone, $nickName = null)
    {
        $this->FullName = trim((string)$fullName);
        $this->NickName = $nickName;
        $this->DOB      = $dob;
        $this->Email    = $email;
        $this->Phone    = $phone;

        if ($dob) {
            $d = new DateTime($dob);
            $this->Day   = (int)$d->format('d');
            $this->Month = (int)$d->format('m');
            $this->Year  = (int)$d->format('Y');
        }
    }

    public function hasFullName(): bool
    {
        return $this->FullName !== '';
    }

    public function hasDOB(): bool
    {
        return $this->Day && $this->Month && $this->Year;
    }

    /* ===== getters ===== */
    public function getDay()   { return $this->Day; }
    public function getMonth() { return $this->Month; }
    public function getYear()  { return $this->Year; }
    public function getFullName(): string { return $this->FullName; }
    public function getNickName() { return $this->NickName; }

    /* ===== numbers ===== */
    public function setNumber(string $key, NumerologyNumber $num): void
    {
        $this->Numbers[$key] = $num;
    }

    public function getNumber(string $key): ?NumerologyNumber
    {
        return $this->Numbers[$key] ?? null;
    }

    public function setRaw(string $key, $value): void
    {
        $this->raw[$key] = $value;
    }

    public function getRaw(string $key)
    {
        return $this->raw[$key] ?? null;
    }
}

