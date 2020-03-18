<?php
/**
 * Created by PhpStorm.
 * User: Wodro
 * Date: 2020/3/18
 * Time: 18:46
 */

namespace wodrow\yii2wtxtcrawler\site;


use wodrow\yii2wtxtcrawler\Tc;

class Www_8jzwCom extends Tc
{
    const NAME = "www.8jzw.com";
    const DOMAIN = "www.8jzw.com";
    const HOME_URL = "http://".self::DOMAIN;

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
            $this->getContentByUrl($this->url.$href);
            if ($this->show_log){
                var_dump($title);
            }
        }
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

    protected function getContentByUrl($url)
    {
        $this->ql->get($url);
        $eles = $this->ql->find('#content');
        $text = $eles->text();
        if ($text == ""){
            $this->getContentByUrl($url);
        }else{
            $this->content .= $text."\r\n\n";
            if ($this->show_log){
                var_dump($text);
            }
        }
    }
}