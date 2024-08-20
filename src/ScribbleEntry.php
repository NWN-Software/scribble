<?php

namespace Awcodes\Scribble;

use Awcodes\Scribble\Concerns\HasCustomStyles;
use Closure;
use Filament\Infolists\Components\Entry;

class ScribbleEntry extends Entry
{
    use HasCustomStyles;

    protected array|Closure|null $mergeTagsMap = null;

    protected array|Closure|null $userTagsMap = null;

    protected string $view = 'scribble::scribble-entry';

    public function mergeTagsMap(array|Closure $mergeTagsMap): static
    {
        $this->mergeTagsMap = $mergeTagsMap;

        return $this;
    }

    public function getMergeTagsMap(): array
    {
        return $this->evaluate($this->mergeTagsMap) ?? app(ScribbleManager::class)->getMergeTagsMap();
    }

    public function userTagsMap(array|Closure $userTagsMap): static
    {
        $this->userTagsMap = $userTagsMap;

        return $this;
    }

    public function getUserTagsMap(): array
    {
        return $this->evaluate($this->userTagsMap) ?? app(ScribbleManager::class)->getUserTagsMap();
    }
}
