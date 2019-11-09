<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\DocumentModel
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $version
 * @property string|null $header
 * @property string|null $footer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Collaborator[] $collaborators
 * @property-read int|null $collaborators_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read mixed $author
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentModel whereFooter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentModel whereHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentModel whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentModel whereVersion($value)
 * @mixin \Eloquent
 */
class DocumentModel extends Model
{
    use SoftDeletes;

    public static $ptBrPluralName = 'Modelos de Documento';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function getAuthorAttribute()
    {
        return $this->user;
    }

    public function collaborators()
    {
        return $this->hasMany('App\Collaborator');
    }

    public function documents()
    {
        return $this->hasMany('App\Document');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
