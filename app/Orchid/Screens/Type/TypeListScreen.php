<?php

namespace App\Orchid\Screens\Type;

use App\Models\Type;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class TypeListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'types' => Type::paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Types';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Create')
                ->icon('plus')
                ->route('platform.type.create')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('types', [
                TD::make('id', 'ID')->sort(),
                TD::make('title', 'Title')->sort(),
                TD::make('created_at', 'Created')->sort(),
                TD::make('updated_at', 'Last edit')->sort(),
                TD::make('Actions')
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(function (Type $type) {
                        return Link::make('Edit')
                            ->route('platform.type.edit', $type)
                            ->icon('pencil');
                    }),
            ]),
        ];
    }
}
