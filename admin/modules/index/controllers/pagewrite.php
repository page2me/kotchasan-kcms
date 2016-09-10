<?php
/*
 * @filesource pagewrite.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Index\Pagewrite;

use \Kotchasan\Http\Request;
use \Kotchasan\Login;
use \Kotchasan\Html;
use \Kotchasan\Orm\Recordset;

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
      if ($id > 0) {
        // ตรวจสอบรายการที่แก้ไข
        $rs = Recordset::create('Index\Pages\Model');
        $index = $rs->find($id);
      } else {
        // ใหม่
        $index = (object)array(
            'id' => 0
        );
      }
      if ($index) {
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
          'innerHTML' => '<h1 class="icon-write">'.$this->title().'</h1>'
        ));
        // แสดงตาราง
        $section->appendChild(createClass('Index\Pagewrite\View')->render($request, $index));
        // คืนค่า
        return (object)array(
            'module' => 'pages',
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
    return 'สร้าง-แก้ไข หน้าเพจ';
  }
}
