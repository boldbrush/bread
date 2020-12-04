<?php

declare(strict_types=1);

namespace BoldBrush\Bread\Field;

use Exception;
use Illuminate\Support\Collection;

class Container
{
    public const GENERAL = 'general';

    public const BROWSE = 'browse';

    public const READ = 'read';

    public const EDIT = 'edit';

    public const ADD = 'add';

    /** @var Collection $general */
    protected $general;

    /** @var Collection $browse */
    protected $browse;

    /** @var Collection $read */
    protected $read;

    /** @var Collection $edit */
    protected $edit;

    /** @var Collection $add */
    protected $add;

    public function __construct(
        array $general = [],
        array $browse = [],
        array $read = [],
        array $edit = [],
        array $add = []
    ) {
        $this->general = collect($general);
        $this->browse = collect($browse);
        $this->read = collect($read);
        $this->edit = collect($edit);
        $this->add = collect($add);
    }

    public function for(string $for = self::GENERAL): Collection
    {
        if (
            $for !== self::GENERAL &&
            $for !== self::BROWSE &&
            $for !== self::READ &&
            $for !== self::EDIT &&
            $for !== self::ADD
        ) {
            throw new Exception("Fields for $for are not supported", 500);
        }

        $fields = array_merge($this->general->toArray(), $this->$for->toArray());

        return collect($fields);
    }

    public function setFor(Collection $fields, string $for = self::GENERAL): self
    {
        if (
            $for !== self::GENERAL &&
            $for !== self::BROWSE &&
            $for !== self::READ &&
            $for !== self::EDIT &&
            $for !== self::ADD
        ) {
            throw new Exception("Can't set fields for $for, this is not supported", 500);
        }

        $this->$for = $fields;

        return $this;
    }
}
