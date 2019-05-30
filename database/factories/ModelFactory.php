<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


$factory->define(App\Models\User::class, function ($faker) {
    return [
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'token' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Icase::class, function ($faker) {
    return [
        'publish_date' => $faker->dateTime,
        'closing_date' => $faker->dateTime,
        'description' => $faker->sentence,
        'haemoglobin' => $faker->randomNumber,
        'whitecell' => $faker->randomNumber,
        'platelet' => $faker->randomNumber,
        'explanation' => $faker->sentence,
    ];
});


$factory->define(App\Slide::class, function ($faker) {
    return [
        'bucket_name' => $faker->name,
        'name' => $faker->name,
        'sampletype' => $faker->name,
        'slidename' => $faker->name,
    ];
});

$factory->define(App\Investigation::class, function ($faker) {
    return [
        'description' => $faker->sentence
    ];
});

$factory->define(App\Conclusion::class, function ($faker) {
    return [
        'description' => $faker->sentence
    ];
});

$factory->define(App\Feature::class, function ($faker) {
    return [
        'description' => $faker->sentence
    ];
});

$factory->define(App\Submission::class, function ($faker) {
    return [
    ];
});

$factory->define(App\Mcq::class, function ($faker) {
    return [
    ];
});

$factory->define(App\Choice::class, function ($faker) {
    return [
    ];
});

$factory->define(App\Answer::class, function ($faker) {
    return [
    ];
});

$factory->define(App\Emq::class, function ($faker) {
    return [
    ];
});

$factory->define(App\EmqChoice::class, function ($faker) {
    return [
    ];
});

$factory->define(App\EmqStem::class, function ($faker) {
    return [
    ];
});

$factory->define(App\EmqAnswer::class, function ($faker) {
    return [
    ];
});

$factory->define(App\UserStat::class, function ($faker) {
    return [
    ];
});


