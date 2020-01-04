<?php

use Illuminate\Database\Seeder;
use App\Models\Hobby;
use App\Models\User;
use App\Models\UserFollowing;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $hobbies = ["Reading","Watching TV","Family Time","Going to Movies","Fishing","Computer","Gardening","Renting Movies","Walking","Exercise","Listening to Music","Entertaining","Hunting","Team Sports","Shopping","Traveling","Sleeping","Socializing","Sewing","Golf","Church Activities","Relaxing","Playing Music","Housework","Crafts","Watching Sports","Bicycling","Playing Cards","Hiking","Cooking","Eating Out","Dating Online","Swimming","Camping","Skiing","Working on Cars","Writing","Boating","Motorcycling","Animal Care","Bowling","Painting","Running","Dancing","Horseback Riding","Tennis","Theater","Billiards","Beach","Volunteer Work"];

        foreach ($hobbies as $hobby){
            Hobby::create([
                'name' => $hobby
            ]);
        }
        $users = factory(App\Models\User::class, 1000)->create();
        User::create([
            "name"=>"Shakthi Sachintha",
            "email"=>"shakthisachintha@gmail.com",
            "password"=>"$2y$10$8dpikdcKrbU3imjkn.jqzu8NcZJcBUDPOTYmEHcNKgkt7JGluVsE.",
            "username"=>"shakthi"
        ]);

        for ($i=1; $i <=40 ; $i++) { 
            UserFollowing::create([
                "follower_user_id"=>'1001',
                "following_user_id"=>$i,
                "allow"=>'1',
            ]);
            UserFollowing::create([
                "follower_user_id"=>$i,
                "following_user_id"=>'1001',
                "allow"=>'1',
            ]);
        }
    }
}
