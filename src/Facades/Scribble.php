<?php

namespace Awcodes\Scribble\Facades;

use Awcodes\Scribble\ScribbleManager;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static static registerTools(array $tools)
 * @method static static registerConverterExtensions(array $extensions)
 * @method static static tools(array $tools)
 * @method static static mergeTagsMap(array | Closure $map)
 * @method static static userTagsMap(array | Closure $map)
 * @method static Collection getRegisteredTools()
 * @method static Collection getRegisteredConverterExtensions()
 * @method static Collection getTools(array|string $tools)
 * @method static array getDefaultTools()
 * @method static array getMergeTagsMap()
 * @method static array getUserTagsMap()
 *
 * @see ScribbleManager
 */
class Scribble extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ScribbleManager::class;
    }
}
