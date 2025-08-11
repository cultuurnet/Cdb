<?php

declare(strict_types=1);

/**
 * @implements Iterator<CultureFeed_Cdb_Data_Detail>
 */
abstract class CultureFeed_Cdb_Data_DetailList implements CultureFeed_Cdb_IElement, Iterator
{
    protected int $position = 0;
    /** @var array<CultureFeed_Cdb_Data_Detail> */
    protected array $details = [];

    public function add(CultureFeed_Cdb_Data_Detail $detail): void
    {
        $this->details[] = $detail;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->details[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        return isset($this->details[$this->position]);
    }

    public function getDetailByLanguage(string $language_code): ?CultureFeed_Cdb_Data_Detail
    {
        foreach ($this as $detail) {
            if ($language_code == $detail->getLanguage()) {
                return $detail;
            }
        }

        return null;
    }
}
