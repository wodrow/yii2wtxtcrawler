<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-9
 * Time: 上午10:49
 */

namespace wodrow\yii2wtxtcrawler\site;


use QL\QueryList;
use wodrow\yii2wtxtcrawler\Tc;

class Bqg extends Tc
{
    const NAME = "笔趣阁";
    const DOMAIN = "www.biquke.com";
    const HOME_URL = "https://www.biquke.com/";

    public function crawler()
    {
        $ql = $this->ql->get($this->url);
        $html = $ql->getHtml();
        preg_match("/\<title\>([^\<]+)\<\/title\>/", $html, $ms);
        $this->title = $ms[1];
        if ($this->show_log)var_dump($this->title);
        preg_match('/\<div\sclass\=\"box_con\"\>([\s\S]+)\<\/div\>/', $html, $ms);
        $this->ql->html($ms[1]);
        $list = $this->ql->rules([
            'title' => ['#list a', 'text'],
            'href' => ['#list a', 'href'],
        ])
//            ->encoding('UTF-8','Windows-1258')
//            ->removeHead()
            ->queryData();
        $this->content = "";
        foreach ($list as $k => $v){
            $title = $v['title'];
//            $title = iconv('GBK', 'UTF-8', $title);
            $title = mb_convert_encoding($title, 'UTF-8', 'auto');
            $this->content .= $title."\r\n\n";
            $this->ql->get($this->url.$v['href']);
            $eles = $this->ql->find('#content');
            $eles->find('p:last')->remove();
            $this->content .= $eles->text()."\r\n\n";
            if ($this->show_log){
                var_dump($title);
            }
        }
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}