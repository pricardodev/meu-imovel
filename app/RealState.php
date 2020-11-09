<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    protected $fillable = ['title', 'user_id', 'description', 'content', 'price', 'slug', 'bedrooms', 'barthrooms', 'property_area', 'total_property', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        //Quando seguimos o padrão do laravel na criação de uma tabela pivo, não precisa informar
        //Padão: Ordem alfabética separado por _ (underline)
        return $this->belongsToMany(Category::class, 'real_state_categories');
    }

        //salva tanto na base de dados quanto tras os dados nas listagens
    public function photos() 
    {
        return $this->hasMany(RealStatePhoto::class);
    }


}
