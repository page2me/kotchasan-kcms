<?php
/*
 * @filesource antispam.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Guestbook\Antispam;

use \Kotchasan\Http\Request;
use \Kotchasan\Antispam;

/**
 * Antispam Image
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Kotchasan\View
{

  public function index(Request $request)
  {
    // session
    session_start();
    // Antispam Image
    Antispam::createImage($request->get('id')->toString());
  }
}