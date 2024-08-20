<?php

namespace Awcodes\Scribble\Concerns;

trait HasUserTags
{
    protected ?array $userTags = [];

    public function userTags(?array $userTags): static
    {
        $this->userTags = $userTags;

        return $this;
    }

    public function getUserTags(): ?array
    {
        return $this->userTags;
    }
}
