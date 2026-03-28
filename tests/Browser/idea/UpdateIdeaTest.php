<?php

use App\Models\Idea;
use App\Models\User;

it('it edits an existing idea', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->fill('title', 'Some Example Title')
        ->click('@button-status-completed')
        ->fill('description', 'An example description.')
        ->fill('@new-link', 'https://laravel.com')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'Do a thing!')
        ->click('@submit-new-step-button')
        ->click('Update')
        ->assertRoute('idea.show', [$idea]);

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Some Example Title',
        'status' => 'completed',
        'description' => 'An example description.',
        'links' => [$idea->link[0], 'https://laravel.com'],
    ]);

    expect($idea->steps)->toHaveCount(1);
});
