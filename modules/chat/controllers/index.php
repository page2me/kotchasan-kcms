<?php
/*
 * @filesource index.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Chat\Index;

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
    // คืนค่าข้อมูลโมดูล
    return (object)array(
        'module' => $module,
        'title' => 'Chat',
        'detail' => \Chat\Index\View::render($request)
    );
  }
}