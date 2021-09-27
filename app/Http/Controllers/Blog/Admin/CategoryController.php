<?php

namespace App\Http\Controllers\Blog\Admin;
use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use App\Repositories\BlogCategoryRepository;

/**
 * Управление категориями блога
 * Class CategoryController
 * @package App\Http\Controllers\Blog\Admin
 */

class CategoryController extends BaseController
{
    /**
     * @var BlogCategoryRepository
     */

    private $blogCategoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    public function index()
    {
        //$dsd = BlogCategory::all();
        //dd($dsd);
        //$paginator = BlogCategory::paginate(5);

        $paginator = $this->blogCategoryRepository->getAllWithPaginate(25);
        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //$item = new BlogCategory();
        //$categoryList = BlogCategory::all();
        //dd($item);

        $item = new BlogCategory();
        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Создаст объект и добавит в БД
         $item = (new BlogCategory())->create($data);

        if ($item) {
            return redirect()->route('blog.admin.categories.edit', [$item->id])
                ->with(['success'=>'Успешно сохранено']);
        }
        else {
            return back()->withErrors(['msg'=>'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();
        if(empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Создаст объект и добавит в БД
         $item = (new BlogCategory())->create($data);

        //$item = new BlogCategory($data);
         //dd($item);
         //$item->save();

         // Второй вариант
         //$item = (new BlogCategory())->create($data);

         if($item) {
             return redirect()->route('blog.admin.categories.edit', [$item->id])
                 ->with(['success'=>'Успешно сохранено']);
         }
         else {
             return back()->withErrors(['msg'=>'Ошибка сохранения'])
                 ->withInput();
         }
     }

     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param BlogCategoryRepository $categoryRepository
     * @return \Illuminate\Http\Response
     */
    public function edit($id, BlogCategoryRepository $categoryRepository)
    {
        //$item = BlogCategory::findOrFail($id);
        //$item = BlogCategory::first();
        //dd($item);
        //$categoryList = BlogCategory::all();

        $item = $this->blogCategoryRepository->getEdit($id);
        //f$item = $categoryRepository->getEdit($id);
        if (empty($item)) {
            abort(404);
        }

        $categoryList = $this->blogCategoryRepository->getForComboBox();
        //$categoryList = $categoryRepository->getForComboBox();

        return view('blog.admin.categories.edit', compact('item','categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BlogCategoryUpdateRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);

        /*$validator = \Validator::make($request->all(), $rules);
        $validateData[] = $validator->passes();
        $validateData[] = $validator->validate();
        $validateData[] = $validator->valid();
        $validateData[] = $validator->failed();
        $validateData[] = $validator->errors();
        $validateData[] = $validator->fails();

        //$validateData = $this->validate($request, $rules);
        //$validateData = $request->validate($rules);
        dd($validateData);*/

        //$item = BlogCategory::find($id);

        if(empty($item)) {
            return back()
                ->withErrors(['msg' => 'Запись id=[{$id}] не найдена.'])
                ->withInput();
        }
        $data = $request->all();

        /*
        * Ушло в обсервер

        if(empty($data['slug'])) {
            $data['slug'] = str_slug($data['title']);
        }*/

        $result = $item->fill($data)->save();
        //$result = $item->update($data);

        if ($result) {
            return redirect()
                ->route('blog.admin.categories.edit', $item -> id)
                ->with(['success'=>'Успешно сохранено']);
        }
        else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }
}
