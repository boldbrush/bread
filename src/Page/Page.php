<?php

declare(strict_types=1);

namespace BoldBrush\Bread\Page;

use Exception;

class Page
{
    /** @var string $title */
    protected $title;

    /** @var string $titleTag */
    protected $titleTag;

    /**
     * @param string|null $title The title appearing in the page.
     * @param string|null $titleTag The title appearing in `<title>` tag.
     */
    public function __construct(?string $title = null, ?string $titleTag = null)
    {
        $this->title = $title;
        $this->titleTag = $titleTag;
    }

    /**
     * Set the title appearing in the page.
     *
     * @var string|callable $title
     *
     * @return self
     */
    public function setTitle($title): self
    {
        if (is_callable($title)) {
            $title = $title();
        }

        if (!is_string($title)) {
            throw new Exception('Expected `$title` to be `string` type, got ' . gettype($title), 500);
        }

        $this->title = $title;

        return $this;
    }

    /**
     * Set the title appearing in `<title>` tag.
     *
     * @var string|callable $titleTag
     *
     * @return self
     */
    public function setTitleTag($titleTag): self
    {
        if (is_callable($titleTag)) {
            $titleTag = $titleTag();
        }

        if (!is_string($titleTag)) {
            throw new Exception('Expected `$titleTag` to be `string` type, got ' . gettype($titleTag), 500);
        }

        $this->titleTag = $titleTag;

        return $this;
    }

    /**
     * Get the title appearing in the page.
     *
     * @return string
     */
    public function title(): ?string
    {
        return $this->title;
    }

    /**
     * Get the title appearing in `<title>` tag.
     *
     * @return string
     */
    public function titleTag(): ?string
    {
        return $this->titleTag;
    }
}
