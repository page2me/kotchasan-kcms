<?php
/*
 * @filesource pages.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Index\Pages;

use \Kotchasan\Http\Request;
use \Kotchasan\Login;
use \Kotchasan\Html;

/**
 * Description
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Kotchasan\Controller
{

  public function init(Request $request)
  {
    // แอดมิน
    if (Login::isMember()) {
      // แสดงผล
      $section = Html::create('section');
      // breadcrumbs
      $breadcrumbs = $section->add('div', array(
        'class' => 'breadcrumbs'
      ));
      $ul = $breadcrumbs->add('ul');
      $ul->appendChild('<li><span class="icon-documents">หน้าเพจ</span></li>');
      $ul->appendChild('<li><span>'.$this->title().'</span></li>');
      $section->add('header', array(
        'innerHTML' => '<h1 class="icon-list">'.$this->title().'</h1>'
      ));
      // แสดงตาราง
      $section->appendChild(createClass('Index\Pages\View')->render($request));
      // คืนค่า
      return (object)array(
          'module' => 'pages',
          'title' => $this->title(),
          'detail' => $section->render()
      );
    }
    // 404
    return \Index\PageNotFound\Controller::render();
  }

  /**
   * คืนค่าข้อความบนไตเติลบาร์เมื่อแสดงหน้านี้ ไปยัง Controller
   *
   * @return string
   */
  public function title()
  {
    return 'รายการหน้าเว็บเพจที่สร้างแล้ว';
  }
}