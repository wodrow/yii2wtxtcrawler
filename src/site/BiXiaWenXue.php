<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-10
 * Time: 上午10:48
 */

namespace wodrow\yii2wtxtcrawler\site;


use wodrow\yii2wtxtcrawler\Tc;

class BiXiaWenXue extends Tc
{
    const NAME = "笔下文学";
    const DOMAIN = "www.bxwx.org";
    const HOME_URL = "https://www.bxwx.org/";

    public function crawler()
    {
        $this->ql->get($this->url);
        $this->title = $this->ql->find('title')->text();
        if ($this->show_log)var_dump($this->title);
        $ls = '#list dd a';
        $list = $this->ql->rules([
            'title' => [$ls, 'text'],
            'href' => [$ls, 'href'],
        ])->queryData();
        $this->content = "";
        foreach ($list as $k => $v){
            $title = $v['title'];
//            $title = mb_convert_encoding($title, 'UTF-8', 'GBK');
            $this->content .= $title."\r\n\n";
            $this->ql->get("https://".self::DOMAIN.$v['href']);
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