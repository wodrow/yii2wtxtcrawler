<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-23
 * Time: 下午12:03
 */

namespace wodrow\yii2wtxtcrawler\site;


use wodrow\yii2wtxtcrawler\Tc;

class Ba1XinZHongWen extends Tc
{
    const NAME = "八一新中文";
    const DOMAIN = "www.81xzw.com";
    const HOME_URL = "https://www.81xzw.com";

    public function crawler()
    {
        $this->ql->get($this->url);
        $this->title = $this->ql->find('title')->text();
        if ($this->show_log)var_dump($this->title);
        $list = $this->ql->rules([
            'title' => ['.mulu li a', 'text'],
            'href' => ['.mulu li a', 'href'],
        ])->queryData();
        $this->content = "";
        foreach ($list as $k => $v){
            $title = $v['title'];
//            $title = mb_convert_encoding($title, 'UTF-8', 'GBK');
            $this->content .= $title."\r\n\n";
            $this->ql->get(self::HOME_URL.$v['href']);
            $eles = $this->ql->find('#content');
            $eles->find('p:last')->remove();
            $this->content .= $eles->text()."\r\n\n";
            if ($this->show_log){
                var_dump($title);
//                var_dump($eles->text());
            }
        }
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}