<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;

use app\History;

use Carbln\Carnon;

class ProfileController extends Controller
{
    public function add()
    {
        return view('admin.profile.create');
    }

    public function create(Request $request)
    {
        // Validationをかける
        $this->validate($request, Profile::$rules);
        $news = new Profile;
        $form = $request->all();
      
        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        // データベースに保存する
        $news->fill($form);
        $news->save();
      
        return redirect('admin/profile/create');
    }

    public function edit(Request $request)
    {
      $profile_form = Profile::find($request->id);
      if (empty($profile_form)) {
        abort(404);    
      }
        return view('admin.profile.edit', ['profile_form' => $profile_form]);
    }
    
    
    public function update(Request $request)
    {
      //Validationをかける
      $this->validate($request, Profile::$rules);

      $profile = Profile::find($request->id);
      $form = $request->all();

      // // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
      // if (isset($form['image'])) {
      //   $path = $request->file('image')->store('public/image');
      //   $profile->image_path = basename($path);
      // } else {
      //   $profile->image_path = null;
      // }

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);

      // データベースに保存する
      $profile->fill($form)->save();
      //$profile->save();

      return redirect('admin/profile/edit');

    }
}