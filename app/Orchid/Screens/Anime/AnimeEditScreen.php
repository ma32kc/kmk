<?php

namespace App\Orchid\Screens\Anime;

use App\Models\Anime;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class AnimeEditScreen extends Screen
{
    /**
     * @var Anime
     */
    public $anime;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Anime $anime): array
    {
        return [
            'anime' => $anime,
            'categories' => $anime->categories,
            'image' => $anime->image->url ?? null
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->anime->exists ? 'Edit anime' : 'Creating a new anime';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Аниме";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Create post')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->anime->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->anime->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->anime->exists),
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
            Layout::rows([
                Input::make('anime.title')
                    ->title('Title')
                    ->placeholder('Attractive but mysterious title')
                    ->help('Specify a short descriptive title for this post.'),
                Relation::make('categories')
                    ->title('Categories')
                    ->fromModel(Category::class, 'title')
                    ->multiple()
                    ->placeholder('Attractive but mysterious title')
                    ->help('Specify a short descriptive title for this post.'),
                Picture::make('image'),
            ])
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Request $request)
    {
        if ($this->anime->image) {
            Storage::disk('public')->delete($this->anime->image->url);
            $this->anime->image->delete();
        }

        $this->anime->fill($request->get('anime'))->save();

        $this->anime->categories()->sync($request->categories);

        $this->anime->image()->create(['url' => $request->get('image')]);

        Alert::info('You have successfully created a anime.');

        return redirect()->route('platform.anime.list');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->anime->delete();

        Alert::info('You have successfully deleted the anime.');

        return redirect()->route('platform.anime.list');
    }
}
