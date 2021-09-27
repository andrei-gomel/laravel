<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Repositories\BlogPostRepository;
use App\Repositories\BlogCategoryRepository;
use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
//use Carbon\Carbon;

//use App\Http\Controllers\Controller;
use App\Models\BlogPost;

/**
* Управление статьями блога
*
* @package App\Http\Controllers\Blog\Admin
*/

class PostController extends BaseController
{
    /**
    * @var BlogPostRepository
    */
    private $blogPostRepository;

    /**
    * @var BlogCategoryRepository
    */
    private $blogCategoryRepository;

    /**
    * PostController Constructor
    */

    public function __construct()
    {
        parent::__construct();

        $this->blogPostRepository = app(BlogPostRepository::class);
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //$items = BlogPost::all();
        $paginator = $this->blogPostRepository->getAllWithPaginate();
        return view('blog.admin.posts.index',compact('paginator'));
        //return view('blog.admin.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //dd(__METHOD__);

        $item = new BlogPost();

        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.posts.edit', compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BlogPostCreateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogPostCreateRequest $request)
    {
        //dd(__METHOD__);

        $data = $request->input();

        $item = (new BlogPost())->create($data);

        if ($item) {
            return redirect()->route('blog.admin.posts.edit', [$item->id])
                             ->with(['success' => 'Успешно сохранено']);
        }
        else {
            return back()->withErrors(['msg' => 'Ошибка сохранения'])
                         ->withInput();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd(__METHOD__);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        //dd(__METHOD__,$id);
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)){
          abort(404);
        }

        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.posts.edit', compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BlogPostUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogPostUpdateRequest $request, $id)
    {
        //dd(__METHOD__,$request->all(),$id);
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)) {
          return back()
            ->withErrors(['msg'=>"Запись id=[{$id}] не найдена."])
            ->withInput();
        }

        $data = $request->all();

        /**********
        /*  Ушло в обсервер

        if (empty($data['slug'])) {
          $data['slug'] = Str::slug($data['title']);
        }

        if (empty($item->published_at) && $data['is_published']) {
          $data['published_at'] = Carbon::now();
        }    */

        $result = $item->update($data);

        if ($result) {
          return redirect()
            ->route('blog.admin.posts.edit', $item->id)
            ->with(['success'=>'Успешно сохранено']);
        }
        else {
          return back()
            ->withErrors(['msg'=>'Ошибка сохранения.'])
            ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        //dd(__METHOD__,$id, request()->all());
        // Софт-удаление, в БД останется.
        $result = BlogPost::destroy($id);

        // Полное удаление из БД.
        //$result = BlogPost::find($id)->forceDelete();

        if ($result) {
            return redirect()
                ->route('blog.admin.posts.index')
                ->with(['success' => "Запись id=[$id] удалена"]);
        }
        else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
}
