<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-8
 * Time: 下午3:43
 */

namespace wodrow\yii2wtxtcrawler\wiki;


use wodrow\yii2wtxtcrawler\Tc;

class Lgqm extends Tc
{
    const NAME = "临高启明wiki";
    const DOMAIN = "lgqm.huijiwiki.com";
    const HOME_URL = "http://".self::DOMAIN."/wiki/首页";

    /**
     * @return array|mixed
     */
    public function crawler()
    {
        $ql = $this->ql->get($this->url);
        $this->title = $ql->find('title')->text();
        $this->content = $ql->find("div.textIndent")->text();
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}