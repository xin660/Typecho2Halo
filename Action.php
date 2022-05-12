<?php
require_once "Parsedown.php";

class Typecho2Halo_Action extends Typecho_Widget implements Widget_Interface_Do
{
  /**
   * 导出 JSON
   *
   * @access public
   * @return void
   */
  public function doExport() {
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $comment_table = $prefix . 'comments';
    $content_table = $prefix . 'contents';
    $metas_table = $prefix . 'metas';
    $relationships_table = $prefix . 'relationships';
    $options_table = $prefix . 'options';
    $users_table = $prefix . 'users';

    $sql = "SELECT * FROM {$content_table} WHERE `type` in ('post','page')";
    $tpContent = $db->fetchAll($db->query($sql));
    
    //获取到所有的文章
    $sql = "SELECT * FROM {$content_table} WHERE `type` in ('post')";
    $tpPost = $db->fetchAll($db->query($sql));

    //获取到所有的页面
    $sql = "SELECT * FROM {$content_table} WHERE `type` in ('page')";
    $tpPage = $db->fetchAll($db->query($sql));

    //获取到所有的评论
    $sql = "SELECT * FROM {$comment_table} WHERE `status` != 'spam'";
    $tpComments = $db->fetchAll($db->query($sql));

    //获取到所有的分类
    $sql = "SELECT * FROM {$metas_table} WHERE `type` in ('category')";
    $tpCategory = $db->fetchAll($db->query($sql));

    $sql = "SELECT * FROM {$metas_table} INNER JOIN {$relationships_table} ON {$metas_table}.`mid` = {$relationships_table}.`mid` WHERE `type` in ('category')";
    $categorys = $db->fetchAll($db->query($sql));

    //获取到所有的标签
    $sql = "SELECT * FROM {$metas_table} WHERE `type` in ('tag')";
    $tpTag = $db->fetchAll($db->query($sql));

    $sql = "SELECT * FROM {$metas_table} INNER JOIN {$relationships_table} ON {$metas_table}.`mid` = {$relationships_table}.`mid` WHERE `type` in ('tag')";
    $tpTags = $db->fetchAll($db->query($sql));

    //获取到所有的设置项
    $sql = "SELECT * FROM {$options_table}";
    $tpOptions = $db->fetchAll($db->query($sql));

    //获取到所有的用户
    $sql = "SELECT * FROM {$users_table}";
    $tpUsers = $db->fetchAll($db->query($sql));

    $Parsedown = new Parsedown();
    
    $attachments = array();

    $journal_comments = array();

    $theme_settings = array();

    $photos = array();

    $posts = array();/*  */
    foreach($tpPost as $post) {
      if($post['status'] == "publish"){
        $status = "PUBLISHED";
      }else{
        $status = "DRAFT";
      }

      $summary = preg_replace('/[\x00-\xff]+/u', '', mb_substr($Parsedown->text(''. $post["text"] .''),0,500));
      $arr = array(
        "createTime" => (int)$post["created"]*1000,
        "updateTime" => (int)$post["modified"]*1000,
        "id" => (int)$post["cid"],
        "title" => $post["title"],
        "status" => $status,
        "url" => null,
        "slug" => $post["slug"],
        "editorType" => "MARKDOWN",
        "originalContent" => "",
        "formatContent" => "",
        "summary" => $summary,
        "thumbnail" => "",
        "visits" => 0,
        "disallowComment" => false,
        "password" => "",
        "template" => "",
        "topPriority" => 0,
        "likes" => 0,
        "editTime" => (int)$post["modified"]*1000,
        "metaKeywords" => null,
        "metaDescription" => null,
        "wordCount" => "",
        "version" => 1,
        "contentOfNullable" => null,
      );

      $posts[] = $arr;
    }

    $content_patch_logs = array();/*  */
    foreach($tpContent as $content) {
      if($content['status'] == "publish"){
        $status = "PUBLISHED";
      }else{
        $status = "DRAFT";
      }

      $md_content = preg_replace('/<!--markdown-->(.*?)/','${1}',$Parsedown->text(''. $content["text"] .''));
      $arr = array(
        "createTime" => strtotime("now")*1000,
        "updateTime" => strtotime("now")*1000,
        "id" => (int)$content["cid"],
        "postId" => (int)$content["cid"],
        "contentDiff" => $md_content,
        "originalContentDiff" => $md_content,
        "version" => 1,
        "status" => $status,
        "publishTime" => strtotime("now")*1000,
        "sourceId" => 0
      );

      $content_patch_logs[] = $arr;
    }

    $sheets = array();/*  */
    foreach($tpPage as $page) {
      if($page['status'] == "publish"){
        $status = "PUBLISHED";
      }else{
        $status = "DRAFT";
      }
      
      $summary = preg_replace('/[\x00-\xff]+/u', '', mb_substr($Parsedown->text(''. $page["text"] .''),0,500));
      $arr = array(
        "createTime" => (int)$page["created"]*1000,
        "updateTime" => (int)$page["modified"]*1000,
        "id" => (int)$page["cid"],
        "title" => $page["title"],
        "status" => $status,
        "url" => null,
        "slug" => $page["slug"],
        "editorType" => "MARKDOWN",
        "originalContent" => "",
        "formatContent" => "",
        "summary" => $summary,
        "thumbnail" => "",
        "visits" => 0,
        "disallowComment" => false,
        "password" => "",
        "template" => "",
        "topPriority" => 0,
        "likes" => 0,
        "editTime" => (int)$page["modified"]*1000,
        "metaKeywords" => null,
        "metaDescription" => null,
        "wordCount" => "",
        "version" => 1
      );

      $sheets[] = $arr;
    }

    $birthday = array(
      "createTime" => strtotime("now")*1000,
      "updateTime" => strtotime("now")*1000,
      "id" => 1,
      "type" => "INTERNAL",
      "key" => "birthday",
      "value" => "1652257795199"
    );
    $blog_url = Helper::options()->siteUrl;
    $blog_url = array(
      "createTime" => strtotime("now")*1000,
      "updateTime" => strtotime("now")*1000,
      "id" => 2,
      "type" => "INTERNAL",
      "key" => "blog_url",
      "value" => "http://localhost:8090"
    );
    $global_absolute_path_enabled = array(
      "createTime" => strtotime("now")*1000,
      "updateTime" => strtotime("now")*1000,
      "id" => 3,
      "type" => "INTERNAL",
      "key" => "global_absolute_path_enabled",
      "value" => "false"
    );
    $is_installed = array(
      "createTime" => strtotime("now")*1000,
      "updateTime" => strtotime("now")*1000,
      "id" => 4,
      "type" => "INTERNAL",
      "key" => "is_installed",
      "value" => "true"
    );
    
    $blog_title = Helper::options()->title;
    $blog_title = array(
      "createTime" => strtotime("now")*1000,
      "updateTime" => strtotime("now")*1000,
      "id" => 5,
      "type" => "INTERNAL",
      "key" => "blog_title",
      "value" => $blog_title
    );
    $blog_locale = array(
      "createTime" => strtotime("now")*1000,
      "updateTime" => strtotime("now")*1000,
      "id" => 6,
      "type" => "INTERNAL",
      "key" => "blog_locale",
      "value" => "zh"
    );
    $gravatar_source = array(
      "createTime" => strtotime("now")*1000,
      "updateTime" => strtotime("now")*1000,
      "id" => 7,
      "type" => "INTERNAL",
      "key" => "gravatar_source",
      "value" => "//cravatar.cn/avatar/"
    );
    $options = array(
      $birthday,
      $blog_url,
      $global_absolute_path_enabled,
      $is_installed,
      $blog_title,
      $blog_locale,
      $gravatar_source
    );/*  */

    $links = array();

    $categories = array();/*  */
    foreach($tpCategory as $categorie) {
      $arr = array(
        "createTime" => strtotime("now")*1000,
        "updateTime" => strtotime("now")*1000,
        "id" => (int)$categorie["mid"],
        "name" => $categorie["name"],
        "slugName" => null,
        "slug" => $categorie["slug"],
        "description" => $categorie["description"],
        "thumbnail" => "",
        "parentId" => (int)$categorie["parent"],
        "priority" => (int)$categorie["order"],
        "password" => null
      );

      $categories[] = $arr;
    }

    $menus1 = array(
      "createTime" => strtotime("now")*1000,
      "updateTime" => strtotime("now")*1000,
      "id" => 1,
      "name" => "首页",
      "url" => "/",
      "priority" => 1,
      "target" => "_self",
      "icon" => "",
      "parentId" => 0,
      "team" => "",
    );
    $menus2 = array(
      "createTime" => strtotime("now")*1000,
      "updateTime" => strtotime("now")*1000,
      "id" => 2,
      "name" => "文章归档",
      "url" => "/archives",
      "priority" => 2,
      "target" => "_self",
      "icon" => "",
      "parentId" => 0,
      "team" => "",
    );
    $menus3 = array(
      "createTime" => strtotime("now")*1000,
      "updateTime" => strtotime("now")*1000,
      "id" => 3,
      "name" => "默认分类",
      "url" => "/categories/default",
      "priority" => 3,
      "target" => "_self",
      "icon" => "",
      "parentId" => 0,
      "team" => "",
    );
    $menus4 = array(
      "createTime" => strtotime("now")*1000,
      "updateTime" => strtotime("now")*1000,
      "id" => 4,
      "name" => "关于页面",
      "url" => "/s/about",
      "priority" => 4,
      "target" => "_self",
      "icon" => "",
      "parentId" => 0,
      "team" => "",
    );
    $menus = array(
      $menus1,
      $menus2,
      $menus3,
      $menus4
    );/*  */

    $comment_black_list = array();
    $sheet_comments = array();

    $post_comments = array();
    foreach($tpComments as $comment) {
      $email = strtolower($comment['mail']);
      $MD5email = md5($email);

      if($comment['authorId'] == 1){
        $isAdmin = true;
      }else{
        $isAdmin = false;
      }

      if($comment['status'] == "approved"){
        $status = "PUBLISHED";
      }else{
        $status = "AUDITING";
      }
      $arr = array(
        "createTime" => (int)$comment["created"]*1000,
        "updateTime" => (int)$comment["created"]*1000,
        "id" => (int)$comment["coid"],
        "author" => $comment["author"],
        "email" => $comment["mail"],
        "ipAddress" => $comment["ip"],
        "authorUrl" => $comment["url"],
        "gravatarMd5" => $MD5email,
        "content" => $comment["text"],
        "status" => $status,
        "userAgent" => $comment["agent"],
        "isAdmin" => $isAdmin,
        "allowNotification" => true,
        "postId" => (int)$comment["cid"],
        "topPriority" => null,
        "parentId" => (int)$comment["parent"]
      );

      $post_comments[] = $arr;
    }

    $sheet_metas = array();

    $version = array();/*  */

    $journals = array();

    $tags = array();/*  */
    foreach($tpTag as $tag) {
      $arr = array(
        "createTime" => strtotime("now")*1000,
        "updateTime" => strtotime("now")*1000,
        "id" => (int)$tag["mid"],
        "name" => $tag["name"],
        "slugName" => null,
        "slug" => $tag["slug"],
        "color" => "#cfd3d7",
        "thumbnail" => ""
      );

      $tags[] = $arr;
    }

    $post_categories = array();/*  */
    $index = 0;
    foreach($categorys as $categorie) {
      $arr = array(
        "createTime" => strtotime("now")*1000,
        "updateTime" => strtotime("now")*1000,
        "id" => (int)$index++,
        "categoryId" => (int)$categorie["mid"],
        "postId" => (int)$categorie["cid"]
      );

      $post_categories[] = $arr;
    }

    $contents = array();/*  */
    foreach($tpContent as $content) {
      if($content['status'] == "publish"){
        $status = "PUBLISHED";
      }else{
        $status = "DRAFT";
      }
      $md_content = preg_replace('/<!--markdown-->(.*?)/','${1}',$Parsedown->text(''. $content["text"] .''));
      $arr = array(
        "createTime" => strtotime("now")*1000,
        "updateTime" => strtotime("now")*1000,
        "id" => (int)$content["cid"],
        "status" => $status,
        "patchLogId" => (int)$content["cid"],
        "headPatchLogId" => (int)$content["cid"],
        "content" => $md_content,
        "originalContent" => preg_replace('/<!--markdown-->(.*?)/','${1}',$content["text"])
      );

      $contents[] = $arr;
    }

    $post_tags = array();
    $index = 0;
    foreach($tpTags as $tag) {
      $arr = array(
        "createTime" => strtotime("now")*1000,
        "updateTime" => strtotime("now")*1000,
        "id" => (int)$index++,
        "tagId" => (int)$tag["mid"],
        "postId" => (int)$tag["cid"]
      );

      $post_tags[] = $arr;
    }

    $post_metas = array();

    $user = array();/*  */
    foreach($tpUsers as $users) {
      $email = strtolower($users['mail']);
      $MD5email = md5($email);
      $avatar = '//cravatar.cn/avatar/'.$MD5email.'?d=mm';

      $arr = array(
        "createTime" => (int)$users["created"]*1000,
        "updateTime" => (int)$users["created"]*1000,
        "id" => (int)$users["uid"],
        "username" => "admin",
        "nickname" => $users["screenName"],
        "password" => '$2a$10$XEV16yn2BbgPhVUadtKM0eqvIo8O4kSFJiDzybDomJ0uq99F49zue',//1234567890
        "email" => $users["mail"],
        "avatar" => $avatar,
        "description" => "",
        "expireTime" => (int)$users["logged"]*1000,
        "mfaType" => "NONE",
        "mfaKey" => null
      );

      $user[] = $arr;
    }
    
    // 备份文件名
    $fileName = 'halo-data-export-' . strtotime("now")*1000 . '.json';
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename=' . $fileName);
    echo json_encode(array(
    "attachments" => $attachments,
    "export_date" => strtotime("now")*1000,
    "journal_comments" => $journal_comments,
    "theme_settings" => $theme_settings,
    "photos" => $photos,
    "posts" => $posts,
    "content_patch_logs" => $content_patch_logs,
    "sheets" => $sheets,
    "options" => $options,
    "links" => $links,
    "categories" => $categories,
    "menus" => $menus,
    "logs" => [],
    "comment_black_list" => $comment_black_list,
    "sheet_comments" => $sheet_comments,
    "post_comments" => $post_comments,
    "sheet_metas" => $sheet_metas,
    "version" => "1.5.3",
    "journals" => $journals,
    "tags" => $tags,
    "post_categories" => $post_categories,
    "contents" => $contents,
    "post_tags" => $post_tags,
    "post_metas" => $post_metas,
    "user" => $user,

    ),JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
  }

  private function getRootId($id) {
    $parentId = $this->commentHash[$id];  
    if(!$parentId) {
      return $id;
    }

    return $this->getRootId($parentId);
  }

  /**
   * 绑定动作
   *
   * @access public
   * @return void
   */
  public function action() {
    $this->widget('Widget_User')->pass('administrator');
    $this->on($this->request->is('export'))->doExport();
  }
}
