<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-22
 * Time: 下午1:38
 */

namespace wodrow\yii2wtxtcrawler\site;


use wodrow\yii2wtxtcrawler\Tc;

class HuaWenZaiXian extends Tc
{
    const NAME = "华文在线";
    const DOMAIN = "www.chinesezj.com";
    const HOME_URL = "https://www.chinesezj.com/";

    public function crawler()
    {
        $this->ql->get($this->url)->encoding('UTF-8');
        $this->title = $this->ql->find('title')->text();
        $x = explode("手机版", $this->title);
        $this->title = $x[0];
        if ($this->show_log)var_dump($this->title);
        $list = $this->ql->rules([
            'title' => ['.list-charts:eq(0) li a', 'text'],
            'href' => ['.list-charts:eq(0) li a', 'href'],
        ])->queryData();
        $this->content = "";
        foreach ($list as $k => $v){
            $title = $v['title'];
//            $title = mb_convert_encoding($title, 'UTF-8', 'GBK');
            $this->content .= $title."\r\n\n";
            $this->ql->get($this->url.$v['href'])->encoding('UTF-8');
            $eles = $this->ql->find('.content-ext');
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