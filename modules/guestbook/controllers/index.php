<?php
/*
 * @filesource index.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Guestbook\Index;

use \Kotchasan\Http\Request;

/**
 * Description
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Kotchasan\Controller
{

  public function init(Request $request, $module)
  {
    // query ข้อมูล
    $index = \Guestbook\Index\Model::get($request);
    // คืนค่าข้อมูลโมดูล
    return (object)array(
        'module' => $module,
        'title' => 'สมุดเยี่ยม',
        'detail' => \Guestbook\Index\View::render($request, $index)
    );
  }
}