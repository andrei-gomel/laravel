<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Database\Eloqument\Collection;

/**
* Class BlogPostRepository
*
* @package App\Repositories
*/

Class BlogPostRepository extends CoreRepository
{
	/**
	* @return string
	*/

	protected function GetModelClass()
	{
		return Model::Class;
	}

/**
* Получить список статей для вывода (Админка)
*
* @return LengthAwarePaginator;
*/
public function getAllWithPaginate()
{
    $columns = [
                'id',
                'title',
                'slug',
                'is_published',
                'published_at',
                'user_id',
                'category_id',
    ];

    $result = $this->startConditions()
              ->select($columns)
              ->orderBy('id', 'DESC')
              ->with(['category:id,title',
                      'user:id,name'])
              ->paginate(25);

    return $result;
}

/**
* Получить модель для редактирования в админке.
*
* @param int $id
*
* @return Model
*/

public function getEdit($id)
{
	return $this->startConditions()->find($id);
}
}
