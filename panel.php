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
        <p>在您点击下面的按钮后，Typecho会创建一个 JSON 文件，供您保存到计算机中。</p>
        <p>导入的时间会随着数据的增加而增加，如果文章和评论数据比较多的请耐心等待提示。</p>
        <p>使用过程中如果有问题，请到 <a href="https://github.com/iRoZhi/Typecho2Halo/issues">Github</a> 提出。</p>

        <form action="<?php $options->index('/action/Typecho2Halo?export'); ?>" method="post">
          <ul class="typecho-option typecho-option-submit" id="typecho-option-item-submit-3">
            <li>
              <button type="submit" class="primary"><?php _e('导出 typecho JSON 文件'); ?></button>
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