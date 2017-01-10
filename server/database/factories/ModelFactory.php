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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Batch::class, function (Faker\Generator $faker) {
    return [
        'ori_num' => str_random(10),
		'py_num' => str_random(10),
    ];
});

$factory->define(App\Models\Sample::class, function (Faker\Generator $faker) {
    return [
    	'batch_id' => 1,
        'ori_num' => str_random(10),
		'py_num' => str_random(10),
    ];
});

$factory->define(App\Models\Project::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text,
        'manager' => $faker->numberBetween(1, 10)
    ];
});

$factory->define(App\Models\Task::class, function (Faker\Generator $faker) {
    return [
        'name' => str_random(10),
        'pipeline_id' => $faker->numberBetween(1, 5),
        'project_id' => $faker->numberBetween(1, 5),
        'start_time' => $faker->dateTime,
        'end_time' => $faker->dateTime
    ];
});
$factory->define(App\Models\Experiment::class, function (Faker\Generator $faker) {
    return [
        'sample_id' => $faker->numberBetween(1, 5),
        'current_step' => $faker->numberBetween(1, 8),
        'current_step_id' => $faker->numberBetween(1, 8),
        'status' => false,
        'quality' => json_encode($faker->words())
    ];
});

$factory->define(App\Models\Qc::class, function (Faker\Generator $faker) {
    return [
        'run_id' => str_random(10),
        'summary' => json_encode($faker->words()),
        'index' => json_encode($faker->words()),
        'cycle' => json_encode($faker->words()),
        'hist' => json_encode($faker->words())
    ];
});

$factory->define(App\Models\Result::class, function (Faker\Generator $faker) {
    return [
        'sample_id' => $faker->numberBetween(1, 8),
        'product' => $faker->numberBetween(1, 8),
        'major' => $faker->numberBetween(1, 8),
        'sub' => $faker->numberBetween(1, 8),
        'revision' => $faker->numberBetween(1, 8),
        'result' => json_encode($faker->words())
    ];
});