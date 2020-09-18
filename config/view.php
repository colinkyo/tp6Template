<?php
// +----------------------------------------------------------------------
// | 模板设置
// +----------------------------------------------------------------------

return [
    /**
    *
    *使用模板报驱动错误Driver [Think] not supported.
    *原因：
    *tp6默认只能支持PHP原生模板，但配置文件config/view.php配置使用的却是Think
    *办法一：使用tp模板进行think-view安装
    *composer require topthink/think-view
    *办法二：使用原生模板
    *到配置文件config/view.php里把'type' => 'Think'修改为'type' => 'php'
    *办法三：使用原生模板
    *return View::engine('php')->fetch();
     *
     */
    // 模板引擎类型使用Think
    'type'          => 'Think',
    // 默认模板渲染规则 1 解析为小写+下划线 2 全部转换小写 3 保持操作方法
    'auto_rule'     => 1,
    // 模板目录名
    'view_dir_name' => 'view',
    // 模板后缀
    'view_suffix'   => 'html',
    // 模板文件名分隔符
    'view_depr'     => DIRECTORY_SEPARATOR,
    // 模板引擎普通标签开始标记
    'tpl_begin'     => '{',
    // 模板引擎普通标签结束标记
    'tpl_end'       => '}',
    // 标签库标签开始标记
    'taglib_begin'  => '{',
    // 标签库标签结束标记
    'taglib_end'    => '}',
];
