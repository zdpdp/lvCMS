<?php

use Illuminate\Database\Seeder;

class CmsFunctionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_function')->delete();
        
        \DB::table('cms_function')->insert(array (
            0 => 
            array (
                'id' => 1,
                'grade' => 1,
                'EnglishName' => 'UsgeMgr',
                'name' => '用户管理',
                'url' => NULL,
                'icon' => 'fa fa-user fa-fw',
                'father_id' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'grade' => 1,
                'EnglishName' => 'SiteMgr',
                'name' => '站点管理',
                'url' => NULL,
                'icon' => 'fa fa-home fa-fw',
                'father_id' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'grade' => 1,
                'EnglishName' => 'ArticleMgr',
                'name' => '文章管理',
                'url' => NULL,
                'icon' => 'fa fa-pencil-square fa-fw',
                'father_id' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'grade' => 2,
                'EnglishName' => 'PersonPage',
                'name' => '个人信息',
                'url' => '/userInfo',
                'icon' => NULL,
                'father_id' => 13,
            ),
            4 => 
            array (
                'id' => 5,
                'grade' => 2,
                'EnglishName' => 'AllUserPage',
                'name' => '所有用户',
                'url' => '/allUser',
                'icon' => NULL,
                'father_id' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'grade' => 2,
                'EnglishName' => 'AddUserPage',
                'name' => '添加用户',
                'url' => '/addUser',
                'icon' => NULL,
                'father_id' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'grade' => 2,
                'EnglishName' => 'RoleMgrPage',
                'name' => '角色管理',
                'url' => '/role',
                'icon' => NULL,
                'father_id' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'grade' => 2,
                'EnglishName' => 'AllArticlePage',
                'name' => '所有文章',
                'url' => '/allArticle',
                'icon' => NULL,
                'father_id' => 3,
            ),
            8 => 
            array (
                'id' => 9,
                'grade' => 2,
                'EnglishName' => 'AddArticlePage',
                'name' => '添加文章',
                'url' => '/addArticle',
                'icon' => NULL,
                'father_id' => 3,
            ),
            9 => 
            array (
                'id' => 10,
                'grade' => 2,
                'EnglishName' => 'ArticleClassPage',
                'name' => '文章类别',
                'url' => '/articleClass',
                'icon' => NULL,
                'father_id' => 3,
            ),
            10 => 
            array (
                'id' => 11,
                'grade' => 2,
                'EnglishName' => 'SiteSetPage',
                'name' => '常规设置',
                'url' => '/siteSetting',
                'icon' => NULL,
                'father_id' => 2,
            ),
            11 => 
            array (
                'id' => 12,
                'grade' => 3,
                'EnglishName' => 'editSiteSetting',
                'name' => '修改站点设置',
                'url' => '/admin/site/set',
                'icon' => NULL,
                'father_id' => 11,
            ),
            12 => 
            array (
                'id' => 13,
                'grade' => 1,
                'EnglishName' => 'PersonMgr',
                'name' => '个人资料',
                'url' => NULL,
                'icon' => 'fa fa-address-card-o fa-fw',
                'father_id' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'grade' => 3,
                'EnglishName' => 'addRole',
                'name' => '添加角色',
                'url' => '/admin/user/newRole',
                'icon' => NULL,
                'father_id' => 7,
            ),
            14 => 
            array (
                'id' => 15,
                'grade' => 3,
                'EnglishName' => 'grantPower',
                'name' => '角色授权',
                'url' => '/admin/user/editRolePermission',
                'icon' => NULL,
                'father_id' => 7,
            ),
            15 => 
            array (
                'id' => 16,
                'grade' => 3,
                'EnglishName' => 'deleteRole',
                'name' => '删除角色',
                'url' => '/admin/user/deleteRole',
                'icon' => NULL,
                'father_id' => 7,
            ),
            16 => 
            array (
                'id' => 17,
                'grade' => 3,
                'EnglishName' => 'editRole',
                'name' => '修改角色',
                'url' => '/admin/user/editRoleBaseInfo',
                'icon' => NULL,
                'father_id' => 7,
            ),
            17 => 
            array (
                'id' => 18,
                'grade' => 3,
                'EnglishName' => 'addOneUser',
                'name' => '添加用户',
                'url' => '/admin/addUser/addOneUser',
                'icon' => NULL,
                'father_id' => 6,
            ),
            18 => 
            array (
                'id' => 19,
                'grade' => 3,
                'EnglishName' => 'editUser',
                'name' => '编辑用户信息',
                'url' => '/admin/allUser/editUser',
                'icon' => NULL,
                'father_id' => 5,
            ),
            19 => 
            array (
                'id' => 20,
                'grade' => 3,
                'EnglishName' => 'deleteUser',
                'name' => '删除用户',
                'url' => '/admin/allUser/deleteUser',
                'icon' => NULL,
                'father_id' => 5,
            ),
            20 => 
            array (
                'id' => 21,
                'grade' => 3,
                'EnglishName' => 'editSelfInfo',
                'name' => '修改个人信息',
                'url' => '/admin/userInfo/saveBase',
                'icon' => NULL,
                'father_id' => 4,
            ),
            21 => 
            array (
                'id' => 22,
                'grade' => 3,
                'EnglishName' => 'addArticleClass',
                'name' => '添加类别',
                'url' => '/admin/articleClass/addClass',
                'icon' => NULL,
                'father_id' => 10,
            ),
            22 => 
            array (
                'id' => 23,
                'grade' => 3,
                'EnglishName' => 'deleteArticleClass',
                'name' => '删除类别',
                'url' => '/admin/articleClass/deleteClass',
                'icon' => NULL,
                'father_id' => 10,
            ),
            23 => 
            array (
                'id' => 24,
                'grade' => 3,
                'EnglishName' => 'editArticleClass',
                'name' => '修改类别',
                'url' => '/admin/articleClass/editClass',
                'icon' => NULL,
                'father_id' => 10,
            ),
            24 => 
            array (
                'id' => 25,
                'grade' => 3,
                'EnglishName' => 'postAttachMent',
                'name' => '上传附件',
                'url' => '/admin/addArticle/attach',
                'icon' => NULL,
                'father_id' => 9,
            ),
            25 => 
            array (
                'id' => 26,
                'grade' => 3,
                'EnglishName' => 'publicArticle',
                'name' => '发布文章/草稿',
                'url' => '/admin/addArticle/public',
                'icon' => NULL,
                'father_id' => 9,
            ),
            26 => 
            array (
                'id' => 27,
                'grade' => 3,
                'EnglishName' => 'editArticle',
                'name' => '编辑文章',
                'url' => '/admin/addArticle/edit',
                'icon' => NULL,
                'father_id' => 9,
            ),
            27 => 
            array (
                'id' => 28,
                'grade' => 3,
                'EnglishName' => 'deleteArticle',
                'name' => '删除文章',
                'url' => '/admin/allArticle/delete',
                'icon' => NULL,
                'father_id' => 8,
            ),
            28 => 
            array (
                'id' => 29,
                'grade' => 3,
                'EnglishName' => 'addArticleToBin',
                'name' => '文章加入回收站',
                'url' => '/admin/allArticle/recycleBin',
                'icon' => NULL,
                'father_id' => 8,
            ),
            29 => 
            array (
                'id' => 30,
                'grade' => 3,
                'EnglishName' => 'backArticleFromBin',
                'name' => '从回收站还原',
                'url' => '/admin/allArticle/back',
                'icon' => NULL,
                'father_id' => 8,
            ),
            30 => 
            array (
                'id' => 31,
                'grade' => 2,
                'EnglishName' => 'friendLinkPage',
                'name' => '友情链接',
                'url' => '/friends',
                'icon' => NULL,
                'father_id' => 2,
            ),
            31 => 
            array (
                'id' => 32,
                'grade' => 3,
                'EnglishName' => 'editFriend',
                'name' => '编辑友情链接',
                'url' => '/admin/friends/edit',
                'icon' => NULL,
                'father_id' => 31,
            ),
            32 => 
            array (
                'id' => 33,
                'grade' => 3,
                'EnglishName' => 'addFriend',
                'name' => '新增友情链接',
                'url' => '/admin/friends/add',
                'icon' => NULL,
                'father_id' => 31,
            ),
            33 => 
            array (
                'id' => 34,
                'grade' => 3,
                'EnglishName' => 'deleteFriend',
                'name' => '删除友情链接',
                'url' => '/admin/friends/delete',
                'icon' => NULL,
                'father_id' => 31,
            ),
            34 => 
            array (
                'id' => 35,
                'grade' => 2,
                'EnglishName' => 'remarkMgrPage',
                'name' => '评论管理',
                'url' => '/remark',
                'icon' => NULL,
                'father_id' => 3,
            ),
            35 => 
            array (
                'id' => 36,
                'grade' => 3,
                'EnglishName' => 'replyRemark',
                'name' => '回复评论',
                'url' => '/admin/remark/reply',
                'icon' => NULL,
                'father_id' => 35,
            ),
            36 => 
            array (
                'id' => 37,
                'grade' => 3,
                'EnglishName' => 'deleteRemark',
                'name' => '删除评论',
                'url' => '/admin/remark/delete',
                'icon' => NULL,
                'father_id' => 35,
            ),
            37 => 
            array (
                'id' => 39,
                'grade' => 3,
                'EnglishName' => 'editRemark',
                'name' => '编辑评论',
                'url' => '/admin/remark/edit',
                'icon' => NULL,
                'father_id' => 35,
            ),
            38 => 
            array (
                'id' => 40,
                'grade' => 1,
                'EnglishName' => 'VisitMgr',
                'name' => '访问管理',
                'url' => NULL,
                'icon' => 'fa  fa-sign-in  fa-fw',
                'father_id' => NULL,
            ),
            39 => 
            array (
                'id' => 41,
                'grade' => 2,
                'EnglishName' => 'VisitLogPage',
                'name' => '访问统计',
                'url' => '/visit',
                'icon' => NULL,
                'father_id' => 40,
            ),
            40 => 
            array (
                'id' => 42,
                'grade' => 3,
                'EnglishName' => 'upArticle',
                'name' => '置顶文章',
                'url' => '/admin/allArticle/up',
                'icon' => NULL,
                'father_id' => 8,
            ),
            41 => 
            array (
                'id' => 43,
                'grade' => 3,
                'EnglishName' => 'downArticle',
                'name' => '取消置顶文章',
                'url' => '/admin/allArticle/down',
                'icon' => NULL,
                'father_id' => 8,
            ),
            42 => 
            array (
                'id' => 44,
                'grade' => 3,
                'EnglishName' => 'batchDeleteUser',
                'name' => '批量删除用户',
                'url' => '/admin/allUser/batchDelete',
                'icon' => NULL,
                'father_id' => 5,
            ),
            43 => 
            array (
                'id' => 45,
                'grade' => 3,
                'EnglishName' => 'batchChangeUser',
                'name' => '批量修改用户状态',
                'url' => '/admin/allUser/batchChange',
                'icon' => NULL,
                'father_id' => 5,
            ),
            44 => 
            array (
                'id' => 46,
                'grade' => 3,
                'EnglishName' => 'batchDeleteFrendLink',
                'name' => '批量删除友情链接',
                'url' => '/admin/friends/batchDelete',
                'icon' => NULL,
                'father_id' => 31,
            ),
            45 => 
            array (
                'id' => 47,
                'grade' => 3,
                'EnglishName' => 'batchDeleteArticle',
                'name' => '批量删除文章',
                'url' => '/admin/allArticle/batchDelete',
                'icon' => NULL,
                'father_id' => 8,
            ),
            46 => 
            array (
                'id' => 48,
                'grade' => 3,
                'EnglishName' => 'batchChangeArticle',
                'name' => '批量改变文章状态',
                'url' => '/admin/allArticle/batchChange',
                'icon' => NULL,
                'father_id' => 8,
            ),
            47 => 
            array (
                'id' => 49,
                'grade' => 3,
                'EnglishName' => 'batchDeleteRemark',
                'name' => '批量删除评论',
                'url' => '/admin/remark/batchDelete',
                'icon' => NULL,
                'father_id' => 35,
            ),
        ));
        
        
    }
}