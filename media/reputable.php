<?php

namespace Hp;

//  PROJECT HONEY POT ADDRESS DISTRIBUTION SCRIPT
//  For more information visit: http://www.projecthoneypot.org/
//  Copyright (C) 2004-2019, Unspam Technologies, Inc.
//
//  This program is free software; you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation; either version 2 of the License, or
//  (at your option) any later version.
//
//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU General Public License for more details.
//
//  You should have received a copy of the GNU General Public License
//  along with this program; if not, write to the Free Software
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
//  02111-1307  USA
//
//  If you choose to modify or redistribute the software, you must
//  completely disconnect it from the Project Honey Pot Service, as
//  specified under the Terms of Service Use. These terms are available
//  here:
//
//  http://www.projecthoneypot.org/terms_of_service_use.php
//
//  The required modification to disconnect the software from the
//  Project Honey Pot Service is explained in the comments below. To find the
//  instructions, search for:  *** DISCONNECT INSTRUCTIONS ***
//
//  Generated On: Thu, 08 Aug 2019 09:46:25 -0400
//  For Domain: happyvalleygoat.farm
//
//

//  *** DISCONNECT INSTRUCTIONS ***
//
//  You are free to modify or redistribute this software. However, if
//  you do so you must disconnect it from the Project Honey Pot Service.
//  To do this, you must delete the lines of code below located between the
//  *** START CUT HERE *** and *** FINISH CUT HERE *** comments. Under the
//  Terms of Service Use that you agreed to before downloading this software,
//  you may not recreate the deleted lines or modify this software to access
//  or otherwise connect to any Project Honey Pot server.
//
//  *** START CUT HERE ***

define('__REQUEST_HOST', 'hpr2.projecthoneypot.org');
define('__REQUEST_PORT', '80');
define('__REQUEST_SCRIPT', '/cgi/serve.php');

//  *** FINISH CUT HERE ***

interface Response
{
    public function getBody();
    public function getLines(): array;
}

class TextResponse implements Response
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getBody()
    {
        return $this->content;
    }

    public function getLines(): array
    {
        return explode("\n", $this->content);
    }
}

interface HttpClient
{
    public function request(string $method, string $url, array $headers = [], array $data = []): Response;
}

class ScriptClient implements HttpClient
{
    private $proxy;
    private $credentials;

    public function __construct(string $settings)
    {
        $this->readSettings($settings);
    }

    private function getAuthorityComponent(string $authority = null, string $tag = null)
    {
        if(is_null($authority)){
            return null;
        }
        if(!is_null($tag)){
            $authority .= ":$tag";
        }
        return $authority;
    }

    private function readSettings(string $file)
    {
        if(!is_file($file) || !is_readable($file)){
            return;
        }

        $stmts = file($file);

        $settings = array_reduce($stmts, function($c, $stmt){
            list($key, $val) = \array_pad(array_map('trim', explode(':', $stmt)), 2, null);
            $c[$key] = $val;
            return $c;
        }, []);

        $this->proxy       = $this->getAuthorityComponent($settings['proxy_host'], $settings['proxy_port']);
        $this->credentials = $this->getAuthorityComponent($settings['proxy_user'], $settings['proxy_pass']);
    }

    public function request(string $method, string $uri, array $headers = [], array $data = []): Response
    {
        $options = [
            'http' => [
                'method' => strtoupper($method),
                'header' => $headers + [$this->credentials ? 'Proxy-Authorization: Basic ' . base64_encode($this->credentials) : null],
                'proxy' => $this->proxy,
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $body = file_get_contents($uri, false, $context);

        if($body === false){
            trigger_error(
                "Unable to contact the Server. Are outbound connections disabled? " .
                "(If a proxy is required for outbound traffic, you may configure " .
                "the honey pot to use a proxy. For instructions, visit " .
                "http://www.projecthoneypot.org/settings_help.php)",
                E_USER_ERROR
            );
        }

        return new TextResponse($body);
    }
}

trait AliasingTrait
{
    private $aliases = [];

    public function searchAliases($search, array $aliases, array $collector = [], $parent = null): array
    {
        foreach($aliases as $alias => $value){
            if(is_array($value)){
                return $this->searchAliases($search, $value, $collector, $alias);
            }
            if($search === $value){
                $collector[] = $parent ?? $alias;
            }
        }

        return $collector;
    }

    public function getAliases($search): array
    {
        $aliases = $this->searchAliases($search, $this->aliases);
    
        return !empty($aliases) ? $aliases : [$search];
    }

    public function aliasMatch($alias, $key)
    {
        return $key === $alias;
    }

    public function setAlias($key, $alias)
    {
        $this->aliases[$alias] = $key;
    }

    public function setAliases(array $array)
    {
        array_walk($array, function($v, $k){
            $this->aliases[$k] = $v;
        });
    }
}

abstract class Data
{
    protected $key;
    protected $value;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function key()
    {
        return $this->key;
    }

    public function value()
    {
        return $this->value;
    }
}

class DataCollection
{
    use AliasingTrait;

    private $data;

    public function __construct(Data ...$data)
    {
        $this->data = $data;
    }

    public function set(Data ...$data)
    {
        array_map(function(Data $data){
            $index = $this->getIndexByKey($data->key());
            if(is_null($index)){
                $this->data[] = $data;
            } else {
                $this->data[$index] = $data;
            }
        }, $data);
    }

    public function getByKey($key)
    {
        $key = $this->getIndexByKey($key);
        return !is_null($key) ? $this->data[$key] : null;
    }

    public function getValueByKey($key)
    {
        $data = $this->getByKey($key);
        return !is_null($data) ? $data->value() : null;
    }

    private function getIndexByKey($key)
    {
        $result = [];
        array_walk($this->data, function(Data $data, $index) use ($key, &$result){
            if($data->key() == $key){
                $result[] = $index;
            }
        });

        return !empty($result) ? reset($result) : null;
    }
}

interface Transcriber
{
    public function transcribe(array $data): DataCollection;
    public function canTranscribe($value): bool;
}

class StringData extends Data
{
    public function __construct($key, string $value)
    {
        parent::__construct($key, $value);
    }
}

class CompressedData extends Data
{
    public function __construct($key, string $value)
    {
        parent::__construct($key, $value);
    }

    public function value()
    {
        $url_decoded = base64_decode(str_replace(['-','_'],['+','/'],$this->value));
        if(substr(bin2hex($url_decoded), 0, 6) === '1f8b08'){
            return gzdecode($url_decoded);
        } else {
            return $this->value;
        }
    }
}

class FlagData extends Data
{
    private $data;

    public function setData($data)
    {
        $this->data = $data;
    }

    public function value()
    {
        return $this->value ? ($this->data ?? null) : null;
    }
}

class CallbackData extends Data
{
    private $arguments = [];

    public function __construct($key, callable $value)
    {
        parent::__construct($key, $value);
    }

    public function setArgument($pos, $param)
    {
        $this->arguments[$pos] = $param;
    }

    public function value()
    {
        ksort($this->arguments);
        return \call_user_func_array($this->value, $this->arguments);
    }
}

class DataFactory
{
    private $data;
    private $callbacks;

    private function setData(array $data, string $class, DataCollection $dc = null)
    {
        $dc = $dc ?? new DataCollection;
        array_walk($data, function($value, $key) use($dc, $class){
            $dc->set(new $class($key, $value));
        });
        return $dc;
    }

    public function setStaticData(array $data)
    {
        $this->data = $this->setData($data, StringData::class, $this->data);
    }

    public function setCompressedData(array $data)
    {
        $this->data = $this->setData($data, CompressedData::class, $this->data);
    }

    public function setCallbackData(array $data)
    {
        $this->callbacks = $this->setData($data, CallbackData::class, $this->callbacks);
    }

    public function fromSourceKey($sourceKey, $key, $value)
    {
        $keys = $this->data->getAliases($key);
        $key = reset($keys);
        $data = $this->data->getValueByKey($key);

        switch($sourceKey){
            case 'directives':
                $flag = new FlagData($key, $value);
                if(!is_null($data)){
                    $flag->setData($data);
                }
                return $flag;
            case 'email':
            case 'emailmethod':
                $callback = $this->callbacks->getByKey($key);
                if(!is_null($callback)){
                    $pos = array_search($sourceKey, ['email', 'emailmethod']);
                    $callback->setArgument($pos, $value);
                    $this->callbacks->set($callback);
                    return $callback;
                }
            default:
                return new StringData($key, $value);
        }
    }
}

class DataTranscriber implements Transcriber
{
    private $template;
    private $data;
    private $factory;

    private $transcribingMode = false;

    public function __construct(DataCollection $data, DataFactory $factory)
    {
        $this->data = $data;
        $this->factory = $factory;
    }

    public function canTranscribe($value): bool
    {
        if($value == '<BEGIN>'){
            $this->transcribingMode = true;
            return false;
        }

        if($value == '<END>'){
            $this->transcribingMode = false;
        }

        return $this->transcribingMode;
    }

    public function transcribe(array $body): DataCollection
    {
        $data = $this->collectData($this->data, $body);

        return $data;
    }

    public function collectData(DataCollection $collector, array $array, $parents = []): DataCollection
    {
        foreach($array as $key => $value){
            if($this->canTranscribe($value)){
                $value = $this->parse($key, $value, $parents);
                $parents[] = $key;
                if(is_array($value)){
                    $this->collectData($collector, $value, $parents);
                } else {
                    $data = $this->factory->fromSourceKey($parents[1], $key, $value);
                    if(!is_null($data->value())){
                        $collector->set($data);
                    }
                }
                array_pop($parents);
            }
        }
        return $collector;
    }

    public function parse($key, $value, $parents = [])
    {
        if(is_string($value)){
            if(key($parents) !== NULL){
                $keys = $this->data->getAliases($key);
                if(count($keys) > 1 || $keys[0] !== $key){
                    return \array_fill_keys($keys, $value);
                }
            }

            end($parents);
            if(key($parents) === NULL && false !== strpos($value, '=')){
                list($key, $value) = explode('=', $value, 2);
                return [$key => urldecode($value)];
            }

            if($key === 'directives'){
                return explode(',', $value);
            }

        }

        return $value;
    }
}

interface Template
{
    public function render(DataCollection $data): string;
}

class ArrayTemplate implements Template
{
    public $template;

    public function __construct(array $template = [])
    {
        $this->template = $template;
    }

    public function render(DataCollection $data): string
    {
        $output = array_reduce($this->template, function($output, $key) use($data){
            $output[] = $data->getValueByKey($key) ?? null;
            return $output;
        }, []);
        ksort($output);
        return implode("\n", array_filter($output));
    }
}

class Script
{
    private $client;
    private $transcriber;
    private $template;
    private $templateData;
    private $factory;

    public function __construct(HttpClient $client, Transcriber $transcriber, Template $template, DataCollection $templateData, DataFactory $factory)
    {
        $this->client = $client;
        $this->transcriber = $transcriber;
        $this->template = $template;
        $this->templateData = $templateData;
        $this->factory = $factory;
    }

    public static function run(string $host, int $port, string $script, string $settings = '')
    {
        $client = new ScriptClient($settings);

        $templateData = new DataCollection;
        $templateData->setAliases([
            'doctype'   => 0,
            'head1'     => 1,
            'robots'    => 8,
            'nocollect' => 9,
            'head2'     => 1,
            'top'       => 2,
            'legal'     => 3,
            'style'     => 5,
            'vanity'    => 6,
            'bottom'    => 7,
            'emailCallback' => ['email','emailmethod'],
        ]);

        $factory = new DataFactory;
        $factory->setStaticData([
            'doctype' => '<!DOCTYPE html>',
            'head1'   => '<html><head>',
            'head2'   => '<title>Polish Tributary,happyvalleygoat.farm</title></head>',
            'top'     => '<body><div align="center">',
            'bottom'  => '</div></body></html>',
        ]);
        $factory->setCompressedData([
            'robots'    => 'H4sIAAAAAAAAA7PJTS1JVMhLzE21VSrKT8ovKVZSSM7PK0nNK7FVystPLErOyCxLVbKzwacuLT8nJ79cJy8_My8ltULJDgD6EaPyVQAAAA',
            'nocollect' => 'H4sIAAAAAAAAA7PJTS1JVMhLzE21VcrL103NTczM0U3Oz8lJTS7JzM9TUkjOzytJzSuxVdJXsgMAKsBXli0AAAA',
            'legal'     => 'H4sIAAAAAAAAA61abXPbuBH-3l-BUTppMuM4ti_xS-nzjGIriTo5OZXk3OQjREISehTJgqB8vl_ffQNJyaLU9pIZRxRJEODus88-u9C117PUqNikaVno2GaLn3snPfpe6CQJ32e5S4zDw5u_XHuH_yU31_M886r0T6n5uYfHb-Z6ZdOnv6s4r5w17kit8izH55qod3M9kxFxnubwrBcf6V_v5rfrt3j-5vrt7OZlNiuLSG18yJfrmZPLeDR9-eL05F1k1KOZweHpezrrc_WUV7unMTJNiTfmfmmc8viQUxr5Kx_OSusNTwUPfRfxWY0fJ5GCQXhJL0zmeVKV07RLszpW0yUeZzleOYneeKczerKhhx7jMf912KEIdth5VT-zUm2XjhHz53bdtOGkMLGld7vkS6M8e_O5Wmk8LgsLLi-Pgi3OIocfp2SSn_DL1UW0ImPqyvOllfY2vOZgRXfYdP_idII3D72yYlDHJuZV5RnYba85vuPdS10qmk2tee0-d-AkWvtap5VR6JSTsyhcBFyLk2HQwhmzMllY-C4Iqpb9dq_HBmPjq-t4qQrtGCvaZqWnka96_6gSeM-rq8gybBheyvHngs6WFYxO9SONzpL9WCmMmxOe-f3U3IDTeOST0jHa9Jwnmxi3tjHD0Evw7I9HPcvXO41yCHjJbuAduBnu-J5XKmYoZYSslX7a735dFIyXWVUaCEE8_iZQsuDoMrzAt-FkOL0fT9jrlydRfzz9ru7H8v2n6OHDZPDPhwHdH5YPJPf_MN1BBMEf0sycOYZ8d0XYrGb_MrFXHo_dqlSLfE2vB6QG3ozpeLXbIgtZdUyYdmZe4c1z5CxlCdyGHlGWIaLfR3PGndMzDjfTcFTDEx1-83vZyjyDQOeDyr0Pinc9aILfwjqdKT0b0sZkuEx9s8C4efMSs5wDoXz54t27aH8A22ZYYkq7yJocEes0hW9np1FN5gnMXpqS3Brni8z-wbdzwqDIRM_9xjmBloR0lOW-xcUQ5W9z1zoBPivBW8wRgub9XvjVgNsvOQcqnUm-4rX8_l8zG44G2kBClLSm8pDzUtWPvc2ZQY0zCTz9nLNuqbSD5Rb0um5lZHam1JBfNJsAh4VsnWeKVu3yatGsj0ggzwSlSI-0oNXB_Pk833XeuuiSHFvWMBkDR4GwWIa3AaSpMl8ZYmgw0TDhdWa-5VJYsqx-K7H0PwHdnEWDAZMVn5wMRncvX1z8FI0-UR6eqg_jQf_2x5PRYfHxXF60V_9IKet9REmMs4h6Il8S0XAWyhv9lEGm3c_7Osa7C7-fHCgiKHrSp2PVz2jOhNeytkml0-4ME3KFs4ulL1th9mj9kpjhIvJt5gMjfR3cDvtfNpD0pU06Ns9KBfglAiqPFSon4p7E_C6kytKpI38HtgFcASm3Jxf5uHvYMgxj09v22zBSl7rDkr62ZPDOVZSaZCE8kwKPgQvpOBHK8c7OKIskRHP8XpQ-UND-rVTkkQKvpU9bQOkE2rJT7f8P0RrmoiV7fgO3fz7GSrYfIsI7We-1KpeMqYSzs81s6UlZFallSySKc4y3zkheUGzXYOHzSEOah7AkpuhwTB4CYaHDGvHNoMRA1mEW8seb1n1G3h2Wyzstp9eWgbaAiomJzLFM7gRf0VJqdi5GcMpKQYWrrWq9BWx2FvWn6nN__K1FfqPvYKKLi2hAQuzzfmq4_6imn3-gImusNR2Mf9kQEZBzSDehQGKayR9bRcJVROGRt3O0QYGmmxNSPOGJVxw_rwUOSx634Jop85A727le8gQRx-lZ7SFhouHtACx2CSlig43G7dVrtbYlg0cqMbIuVHKohZq5XL6lhBBcZXkERZduT4vhvZ9FWGQ20ki4wSiz0paJUNXFFYuyh8n-6P7r-xOOJikAVD4nM3UUgEEYDhmy3nD6helTpROqKgvR10s7szXB1xYk-fL165fhbb9tS6ibysp6Iu_MhApKqD5lwWJQmJPhvV0bdZt3J5-ibTCuNCl-vCTSTAmXE4VBesKkxCJL8QW-b6XIrCYNS3J5toWU8eAWkHIVje8mz-O9EuFCKgMg6ERcllCotsRXldl_V4aIzyi6XANjMJkORzAcxS1gh-wx6X8avJq85mNQNBRWPyxe4Z36o7v9zHZ7P2p7r4TYCsmxEZqx8FpiRcGyVrm8iMysLodOolo1Q7znWUIG11JNtB8j5Uae1mPPI2o8KSJ6zIf7Feqj1CtbDgREoqiCYnQ6Jj_dTocblQ6k3NTGTdSVVOKqVoTHzDGPUs-Rl5MjWMiq2JhN7gYVYxNTI_siwkzf2O2ACFlqUcfMHscKpTvXnVzB8CNFL0EFETfkxHXTfjMx4tkr7fbZhy9kqQ0-BHudR_1fnwNf9Dg5FbzfIQDyVm7DCFRSjxmXAaJmJDczr6E2f-UbwPh9pVkw08ywlR45qPrJyh5QIWSwjAR1n7kzNEWAkOhirEps52zh5_7jhkmo5bFBbcarr04yAK_mVZ1-eniio9tiWhrqCjRNS_2bRh-qeZjoUx_y9ng4wuMpcZKakiAYqGHjE0jvkwGrgz_LFxw8lxEkg8t30fB-tIMBDzS7FhyTQNBNfGVlR_KxtUFguqUJPID51xyrDyyGEW0dCA9wYzDlTnqfkry5_3OkdAX1ieNsit3qZbMyD_lOFYbXvA2DzbfH0DiJ7sfPLZLxtPLUA_meSY4imsbGTDEVh6c5qpvm76MjtdRu3Sw2NRhOiw2J4UKXQHrLecH0LZbQ7fY7d1eWpC1SzpPYvee81e7AUHsGBsQU6PV6QN5gb2bLTH2SVQSbbXPhxJfvIybhDZnoVOFy7sNpB3khSMTQtgmNWzjqYaQ32gj8FU5MvEaYUOs6WQUdMJGKIUBHxKOkHoNySGy17e8N1948bCnFDXWTg4ODPBomoJlAyNMyDpTfvK_CFpBOzpOqF0Kq4EhNpvdiMjh3NxhNhx_pK7M1zng7OP5B4b7FdVsvLfgGtu5J_wrUjHHMX4yVNWZ17E6It6ag5-WYdmwIjohb4ctlN4cENphKSQR1AamMlS3LoBxb_hrdj958fvhlwy_UmG1LQdKZlafOWoNkjzsy9Z6TC32yOqis8dox-wBO15Dbk1YObJJ7ySFoiFOupP1RVjSpzCS1CjHRfgUOwY5jQG7QY-0fpgNNYYDuYMV2_mvZa3I3BCG0qfMMbk1K9zDEGLLISrG3WsmJXz6f79caCJODi4Ig9bqZ4DTqydmm2KcY6diBLOsuA0cQd7SICg4NIWSqGdRp8ZLjGPHizJapiNLuNsP_wwNJykHbfJLr6BFxUFlwpvdaWa66nBpmsj3qpCmAt-lSlEitx0afuBxAyQoFFeX88aFkcn4R3Y9Y6Q7r5f9pUmgLPmmIUyU7k40-hzsh7ZL9FX4VNpN4n6uJ1EaGWkBcCrlHqSaMIpLoAFNI6xMjEcHcThbOeSsm3yaD55LtfgPoxEah6RqEG-4fpJazCRAy1Ky550VnXoVYaM9kgzPTlB3OU86B35bVy3r_qcljrQ2F5iSUEfQwMMuT4voIKZQBwPkdWxF5qpulbrqlzkPVYulFV_OVqal5s81AnprKgLg5X3kHcmDOZ1ARkQGk-WAT6QFQ5-xQ7SKowEoPe22Hw09mUeTIcAKTGyIL6Ii_bpP94R3SRlsAWx83uyqPIn7KquQ9TlTvtSzijXjUZBtGxpD6SPl2DPqbNhOmD9PBRPVHPzrOetTeElgeKoIKrkSpAO-ofuK2rQkSKw0FjyOfc8bmTlzv9XFLdM0QlrxbrH8DHViVku-1MwFMVxE8J_STWs4Z7ygTpGotCmlpY7fO5yxvIeXuL5CwzqbMv58fOMA2HYe-rKBGLlxTJOtMrUPz4aXsaZuQ9AubarBmQ84r7FE3xQhqFoO_dKBWFuoQUZDnWwVDOz6J3i8i-v3CHqIzDdGJV5pHgB63UhRkDYPZZuZSmUzE2KmUof8CnJUkVeoSKNSl1Gcz5b4iJYAsSDhN-l-0_653zWRndCUd95QrDK-K3POiWSbza7jnZqK6755jVU0_Nxf6lNtuB1-n_R8db42c81KH8S7YQagJMZxEqdGSxQgRCe7iNkvP6_K9_nnIDtPxlodw0wyPq7YgIlvNaqxuQ_wsMg6ffkZNRIaD_EjD4-9k8OBoI-d0v2HwOu-eU3i2Wn7bf86Tseh58QGpx5bouKklYmeddVOID0i7ZC9bV6Qmq8LvMTCVBMOAM-WHO9t_8tszKnM54cqOOsdFedy-eTi-w4_R7UBh53QnAt_S7_fe0g__4ACu_wdIH2uHBSgAAA',
            'style'     => 'H4sIAAAAAAAAAyXMOwqAMAwA0KsIrtbP2opj7xHbCIWSlCRDRby7g-8Ab1e7Kx4wa8MmmJ7ElcWPMcZwMZk_ueZhW1sfQArUSYHUKUq5gmE3lzGxgBUmT0wY3n35yw_3RG2aWgAAAA',
            'vanity'    => 'H4sIAAAAAAAAA22SwW7bMAyGX4VQrmuctV2AKLYxLMhQDGgTdO1hR9libK2qKFBs3Lz9ZDe9dIVAgITE7_8pqRTTeIQWvU_RtC50lVqosYzG2nPZEFvkMUty8lipxrRPHdNLsHq2Wq3Wg7PS68urRXxdq7oUzmHhaLzrQqWE4nvjGarha3yFyxzfclznrjeJC3ZdLzqRd3Y6MttsNiMxewtwZhwoiG7IWxj1wLAz_ksyIV0kZHdYt-SJ9Wy5XK6zsh49RUpOHAXN6I24I2bm97IYqXVZiP3PLpxzjwdR8MH8VVZd5HX9Nq2BnvFQqV4k6qIYhmEemf5iKz0FPEWSOXFXKGi9SalSKWJkbFV9u739sb2H3U_Y3-9-bTcPcLO72_6B_e6hLExdNvwp_CVk38_zlp7VR-LvvAE3ho-YBBn2TJJt5MHhDmUgfhqZ2dzRWbTQnOBxYk1q0zUU49MV05-o_wF0AU6KGwIAAA',
        ]);
        $factory->setCallbackData([
            'emailCallback' => function($email, $style = null){
                $value = $email;
                $display = 'style="display:' . ['none',' none'][random_int(0,1)] . '"';
                $style = $style ?? random_int(0,5);
                $props[] = "href=\"mailto:$email\"";
        
                $wrap = function($value, $style) use($display){
                    switch($style){
                        case 2: return "<!-- $value -->";
                        case 4: return "<span $display>$value</span>";
                        case 5:
                            $id = '146acl6cli8';
                            return "<div id=\"$id\">$value</div>\n<script>document.getElementById('$id').innerHTML = '';</script>";
                        default: return $value;
                    }
                };
        
                switch($style){
                    case 0: $value = ''; break;
                    case 3: $value = $wrap($email, 2); break;
                    case 1: $props[] = $display; break;
                }
        
                $props = implode(' ', $props);
                $link = "<a $props>$value</a>";
        
                return $wrap($link, $style);
            }
        ]);

        $transcriber = new DataTranscriber($templateData, $factory);

        $template = new ArrayTemplate([
            'doctype',
            'injDocType',
            'head1',
            'injHead1HTMLMsg',
            'robots',
            'injRobotHTMLMsg',
            'nocollect',
            'injNoCollectHTMLMsg',
            'head2',
            'injHead2HTMLMsg',
            'top',
            'injTopHTMLMsg',
            'actMsg',
            'errMsg',
            'customMsg',
            'legal',
            'injLegalHTMLMsg',
            'altLegalMsg',
            'emailCallback',
            'injEmailHTMLMsg',
            'style',
            'injStyleHTMLMsg',
            'vanity',
            'injVanityHTMLMsg',
            'altVanityMsg',
            'bottom',
            'injBottomHTMLMsg',
        ]);

        $hp = new Script($client, $transcriber, $template, $templateData, $factory);
        $hp->handle($host, $port, $script);
    }

    public function handle($host, $port, $script)
    {
        $data = [
            'tag1' => 'a7268b0ba204f97d27f22b99ffed2e8c',
            'tag2' => '4423c534fdf099e292b3fceadc2ccc57',
            'tag3' => '3649d4e9bcfd3422fb4f9d22ae0a2a91',
            'tag4' => md5_file(__FILE__),
            'version' => "php-".phpversion(),
            'ip'      => $_SERVER['REMOTE_ADDR'],
            'svrn'    => $_SERVER['SERVER_NAME'],
            'svp'     => $_SERVER['SERVER_PORT'],
            'sn'      => $_SERVER['SCRIPT_NAME']     ?? '',
            'svip'    => $_SERVER['SERVER_ADDR']     ?? '',
            'rquri'   => $_SERVER['REQUEST_URI']     ?? '',
            'phpself' => $_SERVER['PHP_SELF']        ?? '',
            'ref'     => $_SERVER['HTTP_REFERER']    ?? '',
            'uagnt'   => $_SERVER['HTTP_USER_AGENT'] ?? '',
        ];

        $headers = [
            "User-Agent: PHPot {$data['tag2']}",
            "Content-Type: application/x-www-form-urlencoded",
            "Cache-Control: no-store, no-cache",
            "Accept: */*",
            "Pragma: no-cache",
        ];

        $subResponse = $this->client->request("POST", "http://$host:$port/$script", $headers, $data);
        $data = $this->transcriber->transcribe($subResponse->getLines());
        $response = new TextResponse($this->template->render($data));

        $this->serve($response);
    }

    public function serve(Response $response)
    {
        header("Cache-Control: no-store, no-cache");
        header("Pragma: no-cache");

        print $response->getBody();
    }
}

Script::run(__REQUEST_HOST, __REQUEST_PORT, __REQUEST_SCRIPT, __DIR__ . '/phpot_settings.php');

