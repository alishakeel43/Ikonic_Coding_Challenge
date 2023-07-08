<?php

namespace Database\Seeders;

use App\Models\Connection;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConnectionsInCommonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users->random(15) as $fromUser){
            foreach ($users->random(10) as $toUser){
                if($fromUser->id !== $toUser->id 
                && !Connection::where('sender_user_id',$toUser->id)->exists() 
                && !Connection::where('sender_user_id',$fromUser->id)->where('receiver_user_id',$toUser->id)->exists()
                ){
                    Connection::create(['sender_user_id' => $fromUser->id, 'receiver_user_id' => $toUser->id, 'status'=> 'approved']);
                }
            }
        }
    }
}
