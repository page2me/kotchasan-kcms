<?php
/*
 * @filesource module.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Index\Module;

/**
 * Description
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{

  /**
   * อ่านข้อมูลโมดูลที่เลือก
   *
   * @param string $module
   * @return object|bool คืนค่าผลลัพท์ที่พบเพียงรายการเดียว ไม่พบข้อมูลคืนค่า false
   */
  public static function get($module)
  {
    $model = new static;
    // query
    $query = $model->db()->createQuery()
      ->from('site')
      ->where(array(
        array('module', $module)
      ))
      ->cacheOn();
    // คำสั่งสำหรับดู query
    // SELECT * FROM `u`.`site` WHERE `module` = 'home' LIMIT 1
    //echo $query->select()->limit(1)->text();
    return $query->first();
  }
}