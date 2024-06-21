<?php

namespace App\Orchid\Screens\Type;

use App\Models\Type;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class TypeEditScreen extends Screen
{
    public $type;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Type $type): iterable
    {
        return [
            'type' => $type
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->type->exists ? 'Edit Type' : 'Create Type';
    }

    public function description(): ?string
    {
        return 'Type management screen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Back')->icon('arrow-left-circle')->route('platform.type.list'),
            Button::make('Save')
                ->icon('check')
                ->method('save'),
            Button::make('Delete')
                ->icon('trash')
                ->confirm('Are you sure you want to delete this type?')
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
                Input::make('type.title')
                    ->title('Title')
                    ->placeholder('Type title')
                    ->required(),
            ]),
        ];
    }

    public function save(Request $request)
    {
        $request->validate([
            'type.title' => 'required|string|max:255',
        ]);

        $this->type->fill($request->get('type'))->save();

        Alert::info('You have successfully created/updated a type.');

        return redirect()->route('platform.type.list');
    }

    public function delete()
    {
        $this->type->delete();

        Alert::info('You have successfully deleted the type.');

        return redirect()->route('platform.type.list');
    }
}
