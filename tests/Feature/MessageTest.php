<?php

// Write test for MessageController@getMessages
use App\Broadcasting\MessageSentChannel;
use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('should return an empty array when there are no messages', function () {
    $this->actingAs($this->user)->get('/api/messages')
        ->assertStatus(200)
        ->assertJson([]);
});

// Write test for MessageController@sendMessage with invalid data
it('should return an error when the message is not provided', function () {
    $this->actingAs($this->user)->postJson('/api/messages', [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['message']);
});

// Write test for MessageController@getMessages with messages
it('should return all messages', function () {
    Message::factory()->count(3)->create(['user_id' => $this->user->id]);

    $this->actingAs($this->user)->getJson('/api/messages')
        ->assertStatus(200)
        ->assertJsonCount(3)
        ->assertJson(['status' => 'success']);
});
// Write test for MessageController@sendMessage with valid data
it('should send a message', function () {
    $this->actingAs($this->user)->postJson('/api/messages', ['message' => 'Hello World'])
        ->assertStatus(201)
        ->assertJson(['message' => 'Message sent successfully']);
});
// Write test for MessageController@sendMessage with unauthenticated user
it('should return an error when the user is not authenticated', function () {
    $this->postJson('/api/messages', ['message' => 'Hello World'])
        ->assertStatus(401)
        ->assertJson(['message' => 'Unauthenticated.']);
});
// Write test for MessageController@sendMessage with broadcast
it('should broadcast the message', function () {
    Event::fake();
    $this->actingAs($this->user)->postJson('/api/messages', ['message' => 'Hello World']);

    Event::assertDispatched(MessageSent::class);
});
// Write test for MessageController@sendMessage with created message
it('should return the created message', function () {
    $this->actingAs($this->user)->postJson('/api/messages', ['message' => 'Hello World'])
        ->assertStatus(201)
        ->assertJsonStructure(['message']);
});
// Write test for MessageController@getMessages with messages
it('should return all messages with user', function () {

    Message::factory()->count(3)->create([
        'user_id' => $this->user->id
    ]);
    $this->actingAs($this->user)->getJson('/api/messages')
        ->assertStatus(200)
        ->assertJson(['status' => 'success']);
});
// Write test for MessageSentChannel
it('should return true when the user is authenticated', function () {
    $this->actingAs($this->user);
    $channel = new MessageSentChannel();
    $result = $channel->join($this->user);
    expect($result)->toBeTrue();
});


// Write test for MessageSentChannel to see if the message was not sent to the user
it('should return false when the user is not authenticated', function () {
    $user = $this->user;

    $channel = new MessageSentChannel();
    $result = $channel->join($user, new User());
    expect($result)->toBeFalse();
});


