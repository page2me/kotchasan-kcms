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
use \Kotchasan\Orm\Recordset;

/**
 * ตารางหน้าเพจ
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Orm\Field
{
  /**
   * ชื่อตาราง
   *
   * @var string
   */
  protected $table = 'site';

  /**
   * รับค่าจาก action ของตาราง
   *
   * @param Request $request
   */
  public function action(Request $request)
  {
    // session, referer, member
    if ($request->initSession() && $request->isReferer() && Login::isMember()) {
      $action = $request->post('action')->toString();
      if ($action == 'delete') {
        // รับค่า id แยกออกเป็นแอเรย์และแปลงให้เป็นตัวเลข
        $ids = array();
        foreach (explode(',', $request->post('id')->filter('\d,')) as $item) {
          $ids[] = (int)$item;
        }
        // ลบข้อมูลด้วย Recordset
        $rs = Recordset::create(__CLASS__);
        $rs->delete(array('id', $ids), true);
      }
    }
  }

  /**
   * รับค่าจาก form
   *
   * @param Request $request
   */
  public function update(Request $request)
  {
    // session, token, member
    if ($request->initSession() && $request->isSafe() && Login::isMember()) {
      // รับค่าจากการ POST
      $save = array(
        'module' => $request->post('write_module')->username(),
        'topic' => $request->post('write_topic')->topic(),
        'detail' => $request->post('write_detail')->detail()
      );
      // รายการที่แก้ไข 0 รายการใหม่
      $id = $request->post('write_id')->toInt();
      // ตรวจสอบค่าที่ส่งมา
      $ret = array();
      // Recordset
      $rs = Recordset::create(__CLASS__);
      if ($id > 0) {
        // ตรวจสอบรายการที่แก้ไข
        $index = $rs->find($id);
      }
      if ($id > 0 && !$index) {
        $ret['alert'] = 'ไม่พบข้อมูลที่แก้ไข กรุณารีเฟรช';
      } elseif ($save['module'] == '') {
        $ret['alert'] = 'กรุณากรอก โมดูล';
        $ret['input'] = 'write_module';
      } elseif ($save['topic'] == '') {
        $ret['alert'] = 'กรุณากรอก หัวข้อ';
        $ret['input'] = 'write_topic';
      } else {
        // บันทึก
        if ($id == 0) {
          // ใหม่
          $index = \Index\Pages\Model::create();
          foreach ($save as $key => $value) {
            $index->$key = $value;
          }
          $rs->insert($index);
        } else {
          // แก้ไข
          foreach ($save as $key => $value) {
            $index->$key = $value;
          }
          $index->save();
        }
        // เคลียร์ Token
        $request->removeToken();
        // คืนค่า
        $ret['alert'] = 'บันทึกเรียบร้อย';
        $ret['location'] = 'index.php?module=pages';
      }
      // คืนค่าเป็น JSON
      echo json_encode($ret);
    }
  }
}