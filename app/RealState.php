<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    // O _(underscore) representas hypermidias, no caso que a constante irá carregar
    protected $appends = ['_links'];

    protected $table = 'real_states';
    protected $fillable = ['title', 'user_id', 'description', 'content', 'price', 'slug', 'bedrooms', 'barthrooms', 'property_area', 'total_property', 'created_at', 'updated_at'];

    // Usando o HATEOAS
    // Entregar para front-end os links de navegação mais detalhada e elaborado

    //Acessors - conceitos do Laravel
    public function getLinksAttribute()
    {
        // Por causa do elloquent eu consigo pegar dados do banco de dados quando e instanciado
        return [
            'href' => route('real-states.show', ['real_state' => $this->id]),
            'rel' => 'Imóveis'
        ];
    }

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
