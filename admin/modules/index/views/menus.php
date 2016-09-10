<?php
/*
 * @filesource menus.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Index\Menus;

use \Kotchasan\Http\Request;
use \Kotchasan\DataTable;

/**
 * module=menus
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Kotchasan\View
{

  /**
   * ตารางรายการเมนู
   *
   * @param Request $request
   * @return string
   */
  public function render(Request $request)
  {
    // action
    $actions = array('delete' => 'Remove');
    // ตารางสมาชิก
    $table = new DataTable(array(
      'model' => 'Index\Menus\Model',
      /* เรียงลำดับข้อมูล */
      'sort' => 'order ASC',
      /* ตั้งค่าการกระทำของของตัวเลือกต่างๆ ด้านล่างตาราง ซึ่งจะใช้ร่วมกับการขีดถูกเลือกแถว */
      'action' => 'index.php/index/model/menus/action',
      'actions' => array(
        array(
          'id' => 'action',
          'class' => 'ok',
          'text' => 'ทำกับที่เลือก',
          'options' => $actions
        )
      ),
      /* รายชื่อฟิลด์ที่ query (ถ้าแตกต่างจาก Model) */
      'fields' => array(
        'order',
        'module',
        'text',
        'url',
        'target',
        'id'
      ),
      /* คอลัมน์ที่ไม่ต้องแสดงผล */
      'hideColumns' => array('id'),
      /* ส่วนหัวของตาราง และการเรียงลำดับ (thead) */
      'headers' => array(
        'order' => array(
          'text' => 'ID',
          'class' => 'center'
        ),
        'module' => array(
          'text' => 'โมดูล'
        ),
        'text' => array(
          'text' => 'ข้อความบนเมนู'
        ),
        'url' => array(
          'text' => 'ลิงค์'
        ),
        'target' => array(
          'text' => 'การเปิดหน้า',
          'class' => 'center'
        )
      ),
      /* รูปแบบการแสดงผลของคอลัมน์ (tbody) */
      'cols' => array(
        'order' => array(
          'class' => 'center'
        ),
        'target' => array(
          'class' => 'center'
        )
      ),
      /* ปุ่มแสดงในแต่ละแถว */
      'buttons' => array(
        array(
          'class' => 'icon-edit button green',
          'href' => 'index.php?module=menuwrite&amp;id=:id',
          'text' => 'แก้ไข'
        )
      ),
      /* ปุ่มเพิ่ม */
      'addNew' => array(
        'class' => 'button green icon-plus',
        'href' => 'index.php?module=menuwrite',
        'text' => 'เพิ่มเมนู'
      )
    ));
    return $table->render();
  }
}