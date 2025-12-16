<?php
namespace Database\Factories\Infrastructure\Notes\Eloquent;

use App\Domain\Notes\Entities\Note;
use App\Infrastructure\Notes\Eloquent\Note as EloquentNote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Note>
 */
class NoteFactory extends Factory
{
    protected $model = EloquentNote::class;

    public function definition(): array
    {
        return [
            'title'   => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
    }
}