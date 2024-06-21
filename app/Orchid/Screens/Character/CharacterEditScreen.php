<?php

namespace App\Orchid\Screens\Character;

use App\Models\Anime;
use App\Models\Character;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CharacterEditScreen extends Screen
{
    public $character;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Character $character): iterable
    {
        return [
            'character' => $character,
            'types' => $character->types,
            'image' => $character->image->url ?? null,
            'anime' => $character->anime,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->character->exists ? 'Edit Character' : 'Create Character';
    }

    public function description(): ?string
    {
        return 'Character management screen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Back')->icon('arrow-left-circle')->route('platform.character.list'),
            Button::make('Save')
                ->icon('check')
                ->method('save'),
            Button::make('Delete')
                ->icon('trash')
                ->confirm('Are you sure you want to delete this character?')
                ->method('delete'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('character.name')
                    ->title('Name')
                    ->placeholder('Character name'),
                Relation::make('anime')
                    ->title('Anime')
                    ->fromModel(Anime::class, 'title')
                    ->placeholder('Attractive but mysterious title')
                    ->help('Specify a short descriptive title for this post.'),
                Relation::make('types')
                    ->title('Types')
                    ->fromModel(Type::class, 'title')
                    ->multiple()
                    ->placeholder('Attractive but mysterious title')
                    ->help('Specify a short descriptive title for this post.'),
                Picture::make('image'),
            ]),
        ];
    }

    public function save(Request $request)
    {
        if ($this->character->image) {
            Storage::disk('public')->delete($this->character->image->url);
            $this->character->image->delete();
        }
        
        if ($this->character->anime) {
            $this->character->anime()->dissociate();
        }
        $this->character->anime()->associate($request->get('anime'));
        $this->character->fill($request->get('character'))->save();
        
        $this->character->types()->sync($request->types);

        $this->character->image()->create(['url' => $request->get('image')]);

        Alert::info('You have successfully created a anime.');

        return redirect()->route('platform.character.list');
    }

    public function delete()
    {
        $this->character->delete();

        Alert::info('You have successfully deleted the character.');

        return redirect()->route('platform.character.list');
    }
}
