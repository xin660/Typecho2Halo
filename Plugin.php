<?php
/**
 * Typecho 数据导出到 Halo
 *
 * @package Typecho2Halo
 * @author 公子 | irils
 * @version 1.1.0
 * @link https://www.rz.sb
 */
class Typecho2Halo_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Helper::addAction('Typecho2Halo', 'Typecho2Halo_Action');
        Helper::addPanel(1, 'Typecho2Halo/panel.php', _t('Typecho数据导出'), _t('Typecho数据导出'), 'administrator');

        return _t('插件已经激活，请设置插件以正常使用！');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate()
    {
        Helper::removeAction('Typecho2Halo');
        Helper::removePanel(1, 'Typecho2Halo/panel.php');
    }

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){}

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
}