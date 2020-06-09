<?php
/**
 * Created by PhpStorm
 * User: CCH
 * Date: 2020/6/9
 * Time: 11:33
 * Note: 下面接口参数只举例文本的，具体的参数自行查看接口文档；如果正常配置还报错40001，则需要把后台的秘钥按钮关闭
 */
class API{
    public $url = 'http://openapi.tuling123.com/openapi/api/v2';
    public $key = 'apikey';
    public $secret = '密钥';

    public function apiRequest($text)
    {
        /*参数*/
        $data = array(
            'reqType' => 0,
            'perception' => array(
                'inputText' => array (
                    'text' => $text
                )
            ),
            'userInfo' => array (
                'apiKey' => $this->key,
                'userId' => $this->secret,
            )
        );

        $data = json_encode($data);
        $res = $this->curl_post($this->url, $data);

        if (empty($res['results'][0])) {
            return array('code'=>0, 'msg'=>'error');
        }

        return array('code'=>1, 'msg'=>'success', 'res'=>$res['results'][0]);
    }

    function curl_post($url, $post_data = '', $timeout = 5)
    {
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_POST, 1);
        if($post_data != ''){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $contents = curl_exec($ch);
        curl_close($ch);

        $contents = json_decode($contents, true);
        return $contents;
    }
}

$res = (new API())->apiRequest($text);
var_dump($res);