<?php

namespace App\Orchid\Layouts\Anime;

use App\Models\Anime;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class AnimeListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'anime';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')->sort(),
            TD::make('name', __('Image'))
                ->render(function (Anime $anime) {
                    return "<img src='{$anime->image->url}' style='height: 50px;'>";
                }),
            TD::make('title', __('Title'))
                ->render(function (Anime $anime) {
                    return Link::make($anime->title)
                        ->route('platform.anime.edit', $anime);
                })
                ->sort(),
            TD::make('categories', __('Categories'))
                ->render(function (Anime $anime) {
                    return implode(', ', $anime->categories->pluck('title')->all());
                })
                ->sort(),
            TD::make('created_at', __('Created'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden()
                ->sort(),

            TD::make('updated_at', __('Last edit'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->sort(),
        ];
    }
}
