<?php
namespace Packages\StoreContext\Store\Domain\ValueObject;

use InvalidArgumentException;

class StoreAddress
{
    public function __construct(
        private readonly string $value
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException('住所は必須です。');
        }

        if (mb_strlen($this->value) > 200) {
            throw new InvalidArgumentException('住所は200文字以内で入力してください。');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}


