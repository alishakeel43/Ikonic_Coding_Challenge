<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Connectors\Connector;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];




	// Send Requests of this user
	public function sendRequests()
	{
		
        return $this->belongsToMany(User::class, 'connections', 'sender_user_id', 'receiver_user_id')
		->withPivot('status')
		->wherePivot('status', 'pending');

	}

	// Received Requests of this user 
	public function receiveRequests()
	{
		return $this->belongsToMany(User::class, 'connections', 'receiver_user_id', 'sender_user_id')
		->withPivot('status')
		->wherePivot('status', 'pending');
	}

    
    //======================== functions to get sugestions attribute =========================
    
	// accessor allowing you call $user->sugestions
	public function getSuggestionsAttribute()
	{
        if ( ! array_key_exists('suggestions', $this->relations)) $this->loadSuggestions();
		return $this->getRelation('suggestions');
	}

	protected function loadSuggestions()
	{
		if ( ! array_key_exists('suggestions', $this->relations))
		{
            $connectionsAndRequests = $this->mergeConnectionsAndRequests();
            $this->setRelation('suggestions', $connectionsAndRequests);
	    }
	}

	protected function mergeConnectionsAndRequests()
	{
        $users = DB::table('users')
        ->whereNotIn('id', function ($query) {
            $query->select('id')
                ->from('users')
                ->whereIn('id', function ($query) {
                    $query->select('receiver_user_id')
                        ->from('connections')
                        ->where('sender_user_id', '=', $this->id)
                        ->union(function ($query) {
                            $query->select('sender_user_id')
                                ->from('connections')
                                ->where('receiver_user_id', '=', $this->id);
                        });
                });
            })
            ->where('id','!=',$this->id);
        return $users;
	}
    //======================== end functions to get Suggestions attribute =========================


    //======================== functions to get connections attribute =========================


	// connections that this user started
	public function connectionsOfThisUser()
	{
		
        return $this->belongsToMany(User::class, 'connections', 'sender_user_id', 'receiver_user_id')
		->withPivot('status')
		->wherePivot('status', 'approved');

	}

	// connections that this user was asked for
	public function thisUserConnectionOf()
	{
		return $this->belongsToMany(User::class, 'connections', 'receiver_user_id', 'sender_user_id')
		->withPivot('status')
		->wherePivot('status', 'approved');
	}

    
	// accessor allowing you call $user->connections
	public function getConnectionsAttribute()
	{
        if ( ! array_key_exists('connections', $this->relations)) $this->loadConnections();
		return $this->getRelation('connections');
	}

    public function connections (){
        return $this->mergeConnections();
    }

	protected function loadConnections()
	{
		if ( ! array_key_exists('connections', $this->relations))
		{
            $connections = $this->mergeConnections();
            $this->setRelation('connections', $connections);
	    }
	}

	protected function mergeConnections()
	{
        return $this->connectionsOfThisUser()->union($this->thisUserConnectionOf()
            ->select(
                'users.*',
                'connections.sender_user_id',
                'connections.receiver_user_id',
                'connections.status'));
	}

//======================== end functions to get connections attribute =========================


}
