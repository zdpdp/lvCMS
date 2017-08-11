<?php

Route::group(['namespace'=>'Home','middleware'=>'VisitHome'],function(){
    Route::get('/','IndexController@index');
    Route::get('/article/{id}','IndexController@article');
    Route::post('/addremark','IndexController@addRemark');
    Route::get('/class/{id}','IndexController@articleClass');
    Route::get('/download/{id}','IndexController@download');
});


Route::get('/admin', function () {
    return view('admin.admin');
})->middleware('Auth');


Route::post('/admin', 'Admin\IndexController@index')->middleware('Auth');

Route::group(['namespace'=>'Admin','middleware'=>['Auth','Permit']],function(){

    /*站点管理*/
    Route::group(['namespace'=>'SiteMgr'],function(){
        //基本设置
        Route::get('/siteSetting','SiteSettingController@index');
        Route::post('/admin/site/set','SiteSettingController@set');

        //友情链接
        Route::post('/friends','FriendsController@index');
        Route::post('/admin/friends/add','FriendsController@add');
        Route::post('/admin/friends/delete','FriendsController@delete');
        Route::post('/admin/friends/edit','FriendsController@edit');
        Route::post('/admin/friends/batchDelete','FriendsController@batchDelete');

    });

    /*用户管理*/
    Route::group(['namespace'=>'UserMgr'],function (){
        //角色管理
        Route::get('/role','RoleMgrController@index');
        Route::post('/admin/user/newRole','RoleMgrController@newRole');
        Route::get('/admin/user/editRolePermission','RoleMgrController@getRolePermission');
        Route::post('/admin/user/editRolePermission','RoleMgrController@editRolePemition');
        Route::post('/admin/user/deleteRole','RoleMgrController@deleteRole');
        Route::post('/admin/user/editRoleBaseInfo','RoleMgrController@editRoleBaseInfo');

        //添加用户
        Route::get('/addUser','AddUserController@index');
        Route::post('/admin/addUser/addOneUser','AddUserController@addOneUser');

       //所有用户
        Route::post('/allUser','AllUserController@index');
        Route::post('/admin/allUser/editUser','AllUserController@editUser');
        Route::post('/admin/allUser/deleteUser','AllUserController@deleteUser');
        Route::post('/admin/allUser/batchDelete','AllUserController@batchDelete');
        Route::post('/admin/allUser/batchChange','AllUserController@batchChange');
    });

    /*个人资料*/
    Route::group(['namespace'=>'PersonMgr'],function(){
        Route::get('/userInfo','PersonInfoController@index');
        Route::post('/admin/userInfo/saveBase','PersonInfoController@saveBase');
    });

    /*文章管理*/
    Route::group(['namespace'=>'ArticleMgr'],function(){
        //文章类别
        Route::post('/articleClass','ArticleClassController@index');
        Route::post('/admin/articleClass/addClass','ArticleClassController@addClass');
        Route::post('/admin/articleClass/deleteClass','ArticleClassController@deleteClass');
        Route::post('/admin/articleClass/editClass','ArticleClassController@editClass');

        //添加文章
        Route::post('/addArticle','AddArticleController@index');
        Route::post('/admin/addArticle/attach','AddArticleController@attach');
        Route::post('/admin/addArticle/public','AddArticleController@publicArticle');
        Route::post('/admin/addArticle/edit','AddArticleController@editArticle');
        Route::get('/admin/addArticle/edit','AddArticleController@getEditInfo');

        //所有文章
        Route::post('/allArticle','AllArticleController@index');
        Route::post('/admin/allArticle/delete','AllArticleController@delete');
        Route::post('/admin/allArticle/recycleBin','AllArticleController@recycleBin');
        Route::post('/admin/allArticle/back','AllArticleController@back');
        Route::post('/admin/allArticle/up','AllArticleController@up');
        Route::post('/admin/allArticle/down','AllArticleController@down');
        Route::post('/admin/allArticle/batchDelete','AllArticleController@batchDetele');
        Route::post('/admin/allArticle/batchChange','AllArticleController@batchChange');

        //评论管理
        Route::post('/remark','RemarkMgrController@index');
        Route::post('/admin/remark/reply','RemarkMgrController@reply');
        Route::post('/admin/remark/edit','RemarkMgrController@edit');
        Route::post('/admin/remark/delete','RemarkMgrController@delete');
        Route::post('/admin/remark/batchDelete','RemarkMgrController@batchDelete');




    });

    /*访问管理*/
    Route::group(['namespace'=>'VisitMgr'],function(){
        //访问统计
        Route::post('/visit','VisitCountController@index');
    });

});


Route::get('/login',function (){
    return view('auth.login');
})->name('login');

Route::post('/login', 'Auth\AuthController@login');

Route::get('/logout','Auth\AuthController@logout');