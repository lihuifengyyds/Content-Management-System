<?php 
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use App\Category;
use App\Content;

Breadcrumbs::register('home', function($breadcrumbs) {
    $breadcrumbs->push('首页', route('home'));
});

Breadcrumbs::register('category', function($breadcrumbs, $id) {
    $category = Category::find($id);
    $breadcrumbs->parent('home');
    $breadcrumbs->push($category->name, route('category', $id));
});

Breadcrumbs::register('detail', function($breadcrumbs, $posts) {
    $content = Content::find($posts['id']); 
    $breadcrumbs->parent('category',$posts['cid']); 
    $breadcrumbs->push($content->title,route('detail',$posts['id']));
});
?>