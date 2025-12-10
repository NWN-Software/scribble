<?php

namespace Awcodes\Scribble;

use Awcodes\Scribble\Concerns\HasBubbleTools;
use Awcodes\Scribble\Concerns\HasCustomStyles;
use Awcodes\Scribble\Concerns\HasMergeTags;
use Awcodes\Scribble\Concerns\HasProfiles;
use Awcodes\Scribble\Concerns\HasSuggestionTools;
use Awcodes\Scribble\Concerns\HasToolbarTools;
use Awcodes\Scribble\Concerns\HasUserTags;
use Awcodes\Scribble\Utils\Converter;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasPlaceholder;
use Livewire\Component;

class ScribbleEditor extends Field
{
    use HasBubbleTools;
    use HasCustomStyles;
    use HasMergeTags;
    use HasPlaceholder;
    use HasProfiles;
    use HasSuggestionTools;
    use HasToolbarTools;
    use HasUserTags;

    protected string $view = 'scribble::scribble-editor';

    protected ?array $headingLevels = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (ScribbleEditor $component, $state): void {
            if ($state) {
                $component->state($component->modifyColorValues($state));
            }
        });

        $this->afterStateUpdated(function (ScribbleEditor $component, Component $livewire): void {
            $livewire->validateOnly($component->getStatePath());
        });

        $this->dehydrateStateUsing(function ($state) {
            if (! $state) {
                return null;
            }

            if (! is_array($state)) {
                $state = Converter::from($state)->toJson();
            }

            return $state;
        });
    }

    protected function modifyColorValues($data) 
    {
        // Handle arrays
        if (is_array($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                if ($key === 'color' && is_array($value)) {
                    // Convert color array to hex string
                    $result[$key] = $this->rgbArrayToHex($value);
                } else {
                    // Recursively process nested structures
                    $result[$key] = $this->modifyColorValues($value);
                }
            }
            return $result;
        }
        
        // Handle objects
        if (is_object($data)) {
            $result = clone $data;
            foreach ($result as $key => $value) {
                if ($key === 'color' && is_array($value)) {
                    $result->$key = rgbArrayToHex($value);
                } else {
                    $result->$key = modifyColorValues($value);
                }
            }
            return $result;
        }
        
        // Return primitive values as-is
        return $data;
    }
    
    protected function rgbArrayToHex($colorArray) {
        // Convert array with numeric keys to hex
        // Assumes array is [r, g, b] format
        $values = array_values($colorArray);
        
        $r = hexdec($values[0]);
        $g = hexdec($values[1]);
        $b = hexdec($values[2]);
        
        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }

    public function headingLevels(array $levels): static
    {
        $this->headingLevels = $levels;

        return $this;
    }

    public function getHeadingLevels(): ?array
    {
        return $this->headingLevels ?? config('scribble.globals.heading_levels');
    }
}
