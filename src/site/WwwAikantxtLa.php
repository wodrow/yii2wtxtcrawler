<?php
/**
 * Created by PhpStorm.
 * User: Wodro
 * Date: 2020/3/24
 * Time: 18:23
 */

namespace wodrow\yii2wtxtcrawler\site;


use wodrow\yii2wtxtcrawler\Tc;

class WwwAikantxtLa extends Tc
{
    const DOMAIN = "www.aikantxt.la";
    const NAME = self::DOMAIN;
    const HOME_URL = "https://".self::DOMAIN;

    protected $_ls = '#list dd a';
//    protected $_ls = '.listmain dd a';
//    protected $_content = '#content';
    protected $_content = '#wrapper';

    public function crawler()
    {
        $this->ql->get($this->url);
        $_uri = str_replace(self::HOME_URL, '', $this->url);
        $this->title = $this->ql->find('title')->text();
        if ($this->show_log)var_dump($this->title);
        $ls = $this->_ls;
        $list = $this->ql->rules([
            'title' => [$ls, 'text'],
            'href' => [$ls, 'href'],
        ])->queryData();
        $this->content = "";
        foreach ($list as $k => $v){
            $title = $v['title'];
            $title = mb_convert_encoding($title, 'UTF-8', 'GBK');
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
        $eles = $this->ql->find($this->_content);
        $text = $eles->text();
        if ($text == ""){
            $this->getContentByUrl($url);
        }else{
            $this->content .= $text."\r\n\n";
            if ($this->show_log){
//                var_dump($text);
            }
        }
    }
}