<?php
include_once 'common.php';
include 'header.php';
include 'menu.php';
?>

<div class="main">
  <div class="body container">
    <div class="typecho-page-title">
      <h2><?php _e('Typecho数据导出'); ?></h2>
    </div>
    <div class="row typecho-page-main" role="form">
      <div id="dbmanager-plugin" class="col-mb-12 col-tb-8 col-tb-offset-2">
        <p>在您点击下面的按钮后，Typecho 会创建一个 JSON 文件，供您保存到计算机中。</p>
        <p>导入的时间会随着数据的增加而增加，如果文章和评论数据比较多的请耐心等待提示。</p>
        <p>使用过程中如果有问题，请到 <a href="https://github.com/iRoZhi/Typecho2Halo/issues">GitHub</a> 提出。</p>
        <p style="color:red;"> 注： 此版本仅支持 Halo 1.5.x 版本导入</p>
        <p>因为 Typecho 和 Halo 后台账号密码加密方式不一样，所以导入 Halo 成功后登录后台</p>
          <p>账号：admin</p>
          <p>密码：1234567890</p>
          <p>登录成功后建议尽快更改账号密码</p>
        <form action="<?php $options->index('/action/Typecho2Halo?export'); ?>" method="post">
        <ul class="typecho-option" id="typecho-option-item-attachmentTypes-8">
          <li>
            <label class="typecho-label">Markdown 渲染方式</label>
            <span class="multiline">
            <input name="markdown-renderer" type="radio" value="parsedown" id="markdown-parse-parsedown" checked>
            <label for="markdown-parse-parsedown">Parsedown</label>
            </span>
            <span class="multiline">
            <input name="markdown-renderer" type="radio" value="md-server" id="markdown-parse-halo">
            <label for="markdown-parse-halo">
            @halo-dev/md-server  <input type="text" class="w-50 text-s mono" name="md-server" value="http://你本地服务器ip:8000/render"></label>
            </span>
            <div class="description">
              <p style="color:blue;">选择该方式前你需要进行以下操作：<br>
              1、前往<a href="https://github.com/iRoZhi/Typecho2Halo/issues">@halo-dev/md-server</a>，下载由halo官方提供的Markdown渲染库到你本地服务器<br>
              2、解压之后打开cmd命令，依次执行 【pnpm install】、【node server.js】这两个命令运行该服务（前提得支持pnpm命令，可自行百度）<br>
              3、以上命令执行完成，检查8000端口是否放行，访问 http://你本地服务器ip:8000/render 检查是否可访问，访问时会提示（Cannot GET /render），这个不用管，因为该服务接口仅支持POST，能访问就行<br>
              </p>
              <p style="color:red;">使用开启此渲染方式前，请确认你php配置是否有禁用curl（一般默认开启）以及以上服务是否启动</p>
              <p>说明：由于 Halo 与 Typecho 渲染 Markdown 所使用的库不一样，所以可能会导致导出之后，在 Halo 中显示会有一定差异，建议有条件的可以使用 Halo 官方的 md-server。</p>
            </div>
            </li>
        </ul>
          <ul class="typecho-option typecho-option-submit" id="typecho-option-item-submit-3">
            <li>
              <button type="submit" class="primary"><?php _e('导出 Typecho JSON 文件'); ?></button>
            </li>
          </ul>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
include 'copyright.php';
include 'common-js.php';
include 'table-js.php';
include 'footer.php';
?>
