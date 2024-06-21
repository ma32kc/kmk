<?php

namespace App\Orchid\Screens\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CategoryEditScreen extends Screen
{
    public $category;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Category $category): iterable
    {
        return [
            'category' => $category
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->category->exists ? 'Edit Category' : 'Create Category';
    }

    public function description(): ?string
    {
        return 'Category management screen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Back')->icon('arrow-left-circle')->route('platform.category.list'),
            Button::make('Save')
                ->icon('check')
                ->method('save'),
            Button::make('Delete')
                ->icon('trash')
                ->confirm('Are you sure you want to delete this category?')
                ->method('delete'),
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
                Input::make('category.title')
                    ->title('Title')
                    ->placeholder('Category title')
                    ->required(),
            ]),
        ];
    }

    public function save(Request $request)
    {
        $request->validate([
            'category.title' => 'required|string|max:255',
        ]);

        $this->category->fill($request->get('category'))->save();

        Alert::info('You have successfully created/updated a category.');

        return redirect()->route('platform.category.list');
    }

    public function delete()
    {
        $this->category->delete();

        Alert::info('You have successfully deleted the category.');

        return redirect()->route('platform.category.list');
    }
}