<?php
/*
 * @filesource menuwrite.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Index\Menuwrite;

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
      // ข้อมูลที่ต้องการ
      $id = $request->get('id')->toInt();
      // Model
      $model = new \Kotchasan\Model;
      if ($id > 0) {
        // ตรวจสอบรายการที่แก้ไข
        // SELECT * FROM `u`.`menu` WHERE `id` = $id LIMIT 1
        $index = $model->db()->createQuery()->from('menu')->where($id)->first();
      } else {
        // ใหม่ query ID ถัดไป
        // SELECT 0 AS `id`, (1 + IFNULL((SELECT MAX(`order`) FROM `u`.`menu`), 0)) AS `order` LIMIT 1
        $q1 = $model->db()->createQuery()->buildNext('order', 'menu', null, 'order');
        $index = $model->db()->createQuery()->first('0 id', $q1);
      }
      if ($index) {
        // แสดงผล
        $section = Html::create('section');
        // breadcrumbs
        $breadcrumbs = $section->add('div', array(
          'class' => 'breadcrumbs'
        ));
        $ul = $breadcrumbs->add('ul');
        $ul->appendChild('<li><span class="icon-menus">เมนู</span></li>');
        $ul->appendChild('<li><span>'.$this->title().'</span></li>');
        $section->add('header', array(
          'innerHTML' => '<h1 class="icon-write">'.$this->title().'</h1>'
        ));
        // แสดงตาราง
        $section->appendChild(createClass('Index\Menuwrite\View')->render($index));
        // คืนค่า
        return (object)array(
            'module' => 'menus',
            'title' => $this->title(),
            'detail' => $section->render()
        );
      }
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
    return 'สร้าง-แก้ไข เมนู';
  }
}