<?php
/**
 * Created by PhpStorm.
 * User: Wodro
 * Date: 2020/3/12
 * Time: 14:31
 */

namespace wodrow\yii2wtxtcrawler\site;


use wodrow\yii2wtxtcrawler\Tc;

class WWWBiQuGeTw extends Tc
{
    const NAME = "www.biquge.tw";
    const DOMAIN = "www.biquge.tw";
    const HOME_URL = "https://".self::DOMAIN;

    public function crawler()
    {
        $this->ql->get($this->url);
        $_uri = str_replace(self::HOME_URL, '', $this->url);
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
            $href = $v['href'];
            $href = str_replace($_uri, '', $href);
            $this->ql->get($this->url.$href);
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