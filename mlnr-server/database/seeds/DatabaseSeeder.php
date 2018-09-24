<?php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        factory(App\Domain\Lodge::class, 3)->create()->each(
            function ($lodge) {
                factory(App\Domain\User::class, 10)->create(['lodge' => $lodge->id])->each(
                    function ($user) use ($lodge) {
                        factory(App\Domain\Article::class, 3)->create(['author' => $user->id]);
                        factory(App\Domain\Meeting::class, 10)->create(['lodge' => $lodge->id])->each(
                            function ($meeting) use ($user) {
                                factory(App\Domain\RSVP::class, 1)->create(['meeting' => $meeting->id, 'user' => $user->id]);
                            }
                        );
                    }
                );
            }
        );
        factory(App\Domain\Meeting::class, 3)->create();
        Model::reguard();
    }
}
