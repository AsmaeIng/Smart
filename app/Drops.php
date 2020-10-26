<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drops extends Model
{
	
	public function listesends() {

		return $this->belongsToMany(Listesends::class,'drops_has_liste');
       
	}
	public function isps() {

		return $this->belongsToMany(Isps::class,'drops_has_isps');
       
	}
	public function sips() {

		return $this->belongsToMany(Sips::class,'drops_has_sips');
       
	}
	public function servers() {

		return $this->belongsToMany(Servers::class,'drops_has_servers');
       
	}
	protected $fillable = [
		'network_id', 'offre_id', 'country_id', 'body_id', 'header_id', 'file_id', 'email_track_code'
                        ];
	protected $guarded = [];
}
