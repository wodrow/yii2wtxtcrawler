<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-10
 * Time: 下午2:37
 */

namespace wodrow\yii2wtxtcrawler\site;


use wodrow\yii2wtxtcrawler\Tc;

class DuShuWang66 extends Tc
{
    const NAME = "读书网66";
    const DOMAIN = "www.dushu66.com";
    const HOME_URL = "https://www.dushu66.com/";

    public function crawler()
    {
        $this->ql->get($this->url);
        $this->title = $this->ql->find('title')->text();
        if ($this->show_log) var_dump($this->title);
        $list = $this->ql->rules([
            'title' => ['#list dd a', 'text'],
            'href' => ['#list dd a', 'href'],
        ])->queryData();
        $this->content = "";
        foreach ($list as $k => $v) {
            $title = $v['title'];
//            $title = mb_convert_encoding($title, 'UTF-8', 'GBK');
            $this->content .= $title . "\r\n\n";
            $this->ql->get("https://" . self::DOMAIN . $v['href']);
            $eles = $this->ql->find('#content');
            $eles->find('p:last')->remove();
            $this->content .= $eles->text() . "\r\n\n";
            if ($this->show_log) {
                var_dump($title);
                var_dump($eles->text());
            }
        }
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}