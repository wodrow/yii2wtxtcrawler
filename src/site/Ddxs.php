<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-10
 * Time: 上午9:27
 */

namespace wodrow\yii2wtxtcrawler\site;


use wodrow\yii2wtxtcrawler\Tc;

class Ddxs extends Tc
{
    const NAME = "顶点小说";
    const DOMAIN = "www.23us.la";
    const HOME_URL = "https://www.23us.la/";

    public function crawler()
    {
        $this->ql->get($this->url);
        $this->title = $this->ql->find('title')->text();
        if ($this->show_log)var_dump($this->title);
        $list = $this->ql->rules([
            'title' => ['#main dd a', 'text'],
            'href' => ['#main dd a', 'href'],
        ])->queryData();
        $this->content = "";
        foreach ($list as $k => $v){
            $title = $v['title'];
//            $title = mb_convert_encoding($title, 'UTF-8', 'GBK');
            $this->content .= $title."\r\n\n";
            $href = $v['href'];
            if (strpos($href, str_replace(self::HOME_URL, "/", $this->url)) === false){
                $this->ql->get($this->url.$href);
            }else{
                $this->ql->get(substr(self::HOME_URL, 0, -1).$href);
            }

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