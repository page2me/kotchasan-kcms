<?php
/*
 * @filesource index.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Chat\Index;

use \Kotchasan\Http\Request;
use \Kotchasan\Template;

/**
 * Description
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Kotchasan\View
{

  /**
   * แสดงผลห้องสนสนทนา
   *
   * @param Request $request
   * @return string
   */
  public static function render(Request $request)
  {
    if ($request->initSession()) {
      if (empty($_SESSION['chat_name'])) {
        // ร้องขอชื่อ User จาก chat API
        $user = json_decode(file_get_contents(WEB_URL.'index.php/chat/model/index/getUser'));
        // บันทึกชื่อลง session
        $_SESSION['chat_name'] = $user->name;
      }
      // View
      $view = new static;
      $view->setContents(array(
        '/{NAME}/' => $_SESSION['chat_name']
      ));
      // โหลด template หน้า main (main.html)
      $template = Template::load('chat', '', 'main');
      // คืนค่า
      return $view->renderHTML($template);
    }
  }
}