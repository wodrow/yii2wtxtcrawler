<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-8
 * Time: 下午3:18
 */

namespace wodrow\yii2wtxtcrawler;

/**
 * Interface Api
 * @package wodrow\yii2wtxtcrawler
 */
interface Api
{
    /**
     * 爬取
     * @return mixed
     */
    public function crawler();
}