<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Carbon\Carbon;

class DiggingDeeperController extends Controller
{
    public function collections()
    {
    	$result = [];
 
    	/* 
    	* @var Illuminate\Database\Eloquent\Collection $eloquentCollection
    	*/
    	$eloquentCollection = BlogPost::withTrashed()->get();
    	// dd(__METHOD__, $eloquentCollection, $eloquentCollection->toArray());

    	$collection = collect($eloquentCollection->toArray());

    	/* dd(
    		get_class($eloquentCollection),
    		get_class($collection),
    		$collection
    	);*/

    	/*
    	$result['first'] = $collection->first();
    	$result['last'] = $collection->last();*/

    	/*
    	$result['where']['data'] = $collection
    		->where('category_id', 10)
    		->values()
    		->keyBy('id');

    	
    	$result['where']['count'] = $result['where']['data']->count();
    	$result['where']['isEmpty'] = $result['where']['data']->isEmpty();
    	$result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty();
    	*/
    	//dd($result);

    	// Не очень красиво
    	/*if ($result['where']['data']->count()) {
    		// код
    	}

    	// Так лучше
    	if ($result['where']['data']->isNotEmpty()) {
    		// код
    	}
    	*/

    	// Получить ПЕРВЫЙ элемент
    	/*$result['where_first'] = $collection
    		->firstWhere('created_at', '>', '2019-01-17 01:35:00');

    		dd($result);*/

    	// Базовая переменная НЕ измениться. Вернется измененная версия.
    	/*
    	$result['map']['all'] = $collection->map(function (array $item) {
    		$newItem = new \stdClass();
    		$newItem->item_id = $item['id'];
    		$newItem->item_name = $item['title'];
    		$newItem->exists = is_null($item['deleted_at']);

    		return $newItem;
    	});

    	$result['map']['not_exists'] = $result['map']['all']
    		->where('exists', '=', false);
    	dd($result);*/

    	// Базовая переменная изменится (трансформируется).
    	$collection->transform(function (array $item) {
    		$newItem = new \stdClass();
    		$newItem->item_id = $item['id'];
    		$newItem->item_name = $item['title'];
    		$newItem->exists = is_null($item['deleted_at']);
    		$newItem->created_at = Carbon::parse($item['created_at']);

    		return $newItem;
    	});
    	//dd($collection);

    	/*
    	$newItem = new \stdClass();
    	$newItem->id = 9999;

    	$newItem2 = new \stdClass();
    	$newItem2->id = 8888;*/
    	//dd($newItem, $newItem2);

    	/*
    	$collection->prepend($newItem); // элемент в начало коллекции
    	$collection->push($newItem2); // элемент в конец коллекции
    	dd($newItem, $newItem2, $collection);*/

    	/*
    	$newItemFirst = $collection->prepend($newItem)->first();  // элемент в начало коллекции
    	$newItemLast = $collection->push($newItem2)->last(); // элемент в конец коллекции
    	$pulledItem = $collection->pull(10); // выдернули элемент из коллекции
    	dd(compact('collection','newItemFirst','newItemLast','pulledItem'));*/

    	// Фильтрация. Замена orWhere()
    	/*
    	$filtered = $collection->filter(function ($item) {
    		$byDay = $item->created_at->isFriday();
    		$byDate = $item->created_at->day == 4;

    		$result = $byDay && $byDate;

    		return $result;
    	});
    	dd(compact('filtered'));*/

    	$sortedSimpleCollection = collect([5,3,1,2,4])->sort(); // ->values();
    	$sortedAscCollection = $collection->sortBy('created_at');
    	$sortedDescCollection = $collection->sortByDesc('item_id');

    	dd(compact('sortedAscCollection','sortedDescCollection'));
    }
}
