<?php

namespace App\Orchid\Screens\Character;

use App\Models\Character;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class CharacterListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'characters' => Character::paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Characters';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create')
                ->icon('plus')
                ->route('platform.character.create')
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
            Layout::table('characters', [
                TD::make('id', 'ID')->sort(),
                TD::make('name', 'Name')->sort(),
                TD::make('anime_id', 'Anime ID')->sort(),
                TD::make('created_at', 'Created')->sort(),
                TD::make('updated_at', 'Last edit')->sort(),
                TD::make('Actions')
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(function (Character $character) {
                        return Link::make('Edit')
                            ->route('platform.character.edit', $character)
                            ->icon('pencil');
                    }),
            ]),
        ];
    }
}
