    <?php

    class NumerologyNumber
    {
        public int $raw;
        public int $root;
        public ?string $display;

        public function __construct(int $raw, int $root, ?string $display = null)
        {
            $this->raw     = $raw;
            $this->root    = $root;
            $this->display = $display;
        }

        public function __toString(): string
        {
            // MOST IMPORTANT PART
            return $this->display ?? (string)$this->root;
        }

        /**
         * Create from formats like 13/4, 11/2, 19/1
         */
        public static function fromString(string $display): self
        {
            if (str_contains($display, '/')) {
                [$raw, $root] = explode('/', $display);
                return new self((int)$raw, (int)$root, $display);
            }

            $value = (int)$display;
            return new self($value, $value, $display);
        }

        /**
         * Create from a single number (1–9)
         */
        public static function fromRoot(int $root): self
        {
            return new self($root, $root, (string)$root);
        }

        /**
         * Create from raw + root (example: 49 → 13/4)
         */
        public static function fromRawRoot(int $raw, int $root): self
        {
            return new self($raw, $root, "{$raw}/{$root}");
        }

        public function getRoot(): int
        {
            return $this->root;
        }

        public function getRaw(): int
        {
            return $this->raw;
        }
    }
