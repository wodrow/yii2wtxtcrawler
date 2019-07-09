<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-8
 * Time: 下午6:41
 */

namespace wodrow\yii2wtxtcrawler\site;


use QL\QueryList;
use wodrow\yii2wtxtcrawler\Tc;

class Xbqg6 extends Tc
{
    const NAME = "新笔趣阁6";
    const DOMAIN = "www.xbiquge6.com";
    const HOME_URL = "https://www.xbiquge6.com/";

    /**
     * @return array|mixed
     */
    public function crawler()
    {
        $ql = $this->ql->get($this->url);
        $this->title = $ql->find('title')->text();
        $list = $ql->rules([
            'title' => ['#list a', 'text'],
            'href' => ['#list a', 'href'],
        ])->queryData();
        $this->content = "";
        foreach ($list as $k => $v){
            $this->content .= $v['title']."\r\n";
            $_ql = QueryList::getInstance()->get("http://".self::DOMAIN.$v['href']);
            $eles = $_ql->find('#content');
            $eles->find('p:last')->remove();
            $this->content .= $eles->text()."\r\n";
        }
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}