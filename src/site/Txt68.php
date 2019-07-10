<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-8
 * Time: 下午7:03
 */

namespace wodrow\yii2wtxtcrawler\site;


use QL\QueryList;
use wodrow\yii2wtxtcrawler\Tc;

class Txt68 extends Tc
{
    const NAME = "68小说网";
    const DOMAIN = "www.txt68.com";
    const HOME_URL = "http://www.txt68.com/";

    public function crawler()
    {
        $ql = $this->ql->get($this->url);
        $this->title = $ql->find('title')->text();
        if ($this->show_log)var_dump($this->title);
        $list = $ql->rules([
            'title' => ['.chapterSo>.chapterNum li>a', 'text'],
            'href' => ['.chapterSo>.chapterNum li>a', 'href'],
        ])
//            ->removeHead()
//            ->encoding('UTF-8','GBK')
            ->queryData();
        $this->content = "";
        foreach ($list as $k => $v){
            $title = $v['title'];
            $title = iconv('GBK','UTF-8',$title);
            $this->content .= $title."\r\n\n";
            $_ql = QueryList::getInstance()->get($v['href']);
            $eles = $_ql->find('#content');
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