<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-8
 * Time: 下午3:33
 */

namespace wodrow\yii2wtxtcrawler;


use yii\base\Component;

abstract class Tc extends Component implements Api
{
    /**
     * 获取url的域名
     * @param string $url
     * @return string
     */
    public static function getDomain($url)
    {
        preg_match('/[\w+]\:\/\/([^/\]+)/isU', $url, $domain);
        return $domain[0];
    }
}