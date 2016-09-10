<?php
/*
 * @filesource index.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Guestbook\Index;

use \Kotchasan\Http\Request;
use \Kotchasan\Date;
use \Kotchasan\Template;
use \Kotchasan\Antispam;

/**
 * Description
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Kotchasan\View
{

  public static function render(Request $request, $index)
  {
    // session
    $request->initSession();
    // โหลด template ของรายการ (item.html)
    $listitem = Template::create('guestbook', '', 'item');
    // วนลูปแทนที่ข้อมูลลงใน template
    foreach ($index->items as $item) {
      $listitem->add(array(
        '/{ID}/' => $item->id,
        '/{DETAIL}/' => nl2br($item->detail),
        '/{NAME}/' => $item->name,
        '/{CREATE}/' => Date::format($item->create_date),
        '/{IP}/' => $item->ip
      ));
    }
    // View
    $view = new static;
    // antispam
    $antispam = new Antispam();
    // ใส่เนื้อหาลงใน View ตามที่กำหนดใน Template
    $view->setContents(array(
      // topic
      '/{TOPIC}/' => 'สมุดเยี่ยม',
      // เนื้อหา
      '/{LIST}/' => $listitem->render(),
      // แบ่งหน้า
      '/{SPLITPAGE}/' => $request->getUri()->pagination($index->totalpage, $index->page),
      // Antispam
      '/{ANTISPAM}/' => $antispam->getId()
    ));
    // โหลด template หน้า main (main.html)
    $template = Template::load('guestbook', '', 'main');
    // คืนค่า
    return $view->renderHTML($template);
  }
}