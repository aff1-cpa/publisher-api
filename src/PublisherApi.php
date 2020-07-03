<?php

/**
 * This file is part of Aff1 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aff1;

class PublisherApi
{
    /**
     * @var string
     */
    private $api_key = '{YOUR_API_KEY}';
    /**
     * @var string
     */
    private $target_hash = '{TARGET_HASH}';
    /**
     * @var string
     */
    private $country_code = '{COUNTRY_CODE}';
    /**
     * @var string|null
     */
    private $data1;
    /**
     * @var string|null
     */
    private $data2;
    /**
     * @var string|null
     */
    private $data3;
    /**
     * @var string|null
     */
    private $data4;
    /**
     * @var string|null
     */
    private $clickid;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $phone;
    /**
     * @var string
     */
    private $phone2;
    /**
     * @var string
     */
    private $address;
    /**
     * @var float|null
     */
    private $price;
    /**
     * @var string|null
     */
    private $first_name;
    /**
     * @var string|null
     */
    private $last_name;
    /**
     * @var string|null
     */
    private $browser_locale;
    /**
     * @var string|null
     */
    private $state;
    /**
     * @var string|null
     */
    private $city;
    /**
     * @var string|null
     */
    private $zip_code;
    /**
     * @var string|null
     */
    private $email;
    /**
     * @var string|null
     */
    private $comment;
    /**
     * @var string|null
     */
    private $size;
    /**
     * @var string|null
     */
    private $quantity;
    /**
     * @var string|null
     */
    private $password;
    /**
     * @var string|null
     */
    private $language_code;
    /**
     * @var string|null
     */
    private $tz_name;
    /**
     * @var string|null
     */
    private $call_time_frame;
    /**
     * @var string|null
     */
    private $messenger_code;
    /**
     * @var string|null
     */
    private $sale_code;
    /**
     * @var string
     */
    private $log_file_path = '';
    /**
     * @var bool
     */
    private $enable_write_log = false;
    /**
     * @var array
     */
    private $curl_info = array();

    /**
     * Make new API lead.
     *
     * @param string $name
     * @param string $phone
     * @param string $phone2
     * @return mixed
     * @throws \Exception
     */
    public function makeOrder($name, $phone, $phone2 = '')
    {
        $this->setName($name);
        $this->setPhone($phone);
        $this->setPhone2($phone2);

        $ch = $this->getCh();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->getRequestParams()));

        $response = curl_exec($ch);
        $this->curl_info = curl_getinfo($ch);
        curl_close($ch);

        if ($this->enable_write_log) {
            $this->writeLog();
        }

        return $response;
    }

    public function makeOrderByRawRequest()
    {
        if (isset($_REQUEST['address'])) {
            $this->setAddress($_REQUEST['address']);
        }

        $phone2 = isset($_REQUEST['phone2']) ? $_REQUEST['phone2'] : '';

        return $this->makeOrder($_REQUEST['client'], $_REQUEST['phone'], $phone2);
    }

    private function getCh()
    {
        if (!extension_loaded('curl')) {
            throw new \Exception('cURL extension not found');
        }

        return curl_init('https://api.aff1.com/v2/lead.create');
    }

    private function getRequestParams()
    {
        $this->validateRequiredParameters();

        return array(
            'api_key' => $this->getApiKey(),
            'target_hash' => $this->getTargetHash(),
            'country_code' => $this->getCountryCode(),
            'name' => $this->getName(),
            'phone' => $this->getPhone(),
            'phone2' => $this->getPhone2(),
            'ip' => $this->getIp(),
            'user_agent' => empty($_SERVER['HTTP_USER_AGENT']) ? '' : $_SERVER['HTTP_USER_AGENT'],
            'referer' => empty($_SERVER['HTTP_REFERER']) ? '' : $_SERVER['HTTP_REFERER'],
            'accept_language' => empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? '' : $_SERVER['HTTP_ACCEPT_LANGUAGE'],
            'data1' => $this->getData1(),
            'data2' => $this->getData2(),
            'data3' => $this->getData3(),
            'data4' => $this->getData4(),
            'clickid' => $this->getClickid(),
            'address' => $this->getAddress(),
            'price' => $this->getPrice(),
            'custom' => isset($_REQUEST['custom']) && is_array($_REQUEST['custom']) ? $_REQUEST['custom'] : array(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'browser_locale' => $this->getBrowserLocale(),
            'state' => $this->getState(),
            'city' => $this->getCity(),
            'zip_code' => $this->getZipCode(),
            'email' => $this->getEmail(),
            'comment' => $this->getComment(),
            'size' => $this->getSize(),
            'quantity' => $this->getQuantity(),
            'password' => $this->getPassword(),
            'language_code' => $this->getLanguageCode(),
            'tz_name' => $this->getTzName(),
            'call_time_frame' => $this->getCallTimeFrame(),
            'messenger_code' => $this->getMessengerCode(),
            'sale_code' => $this->getSaleCode(),
        );
    }

    private function validateRequiredParameters()
    {
        if ($this->getApiKey() === '{YOUR_API_KEY}') {
            die('Parameter API_KEY is not set.');
        }

        if ($this->getTargetHash() === '{TARGET_HASH}') {
            die('Parameter TARGET_HASH is not set.');
        }

        if ($this->getCountryCode() === '{COUNTRY_CODE}') {
            die('Parameter COUNTRY_CODE is not set.');
        }
    }

    public function getData1()
    {
        return is_null($this->data1) ? '' : $this->data1;
    }

    public function setData1($data1)
    {
        $this->data1 = $data1;
    }

    public function getData2()
    {
        return is_null($this->data2) ? '' : $this->data2;
    }

    public function setData2($data2)
    {
        $this->data2 = $data2;
    }

    public function getData3()
    {
        return is_null($this->data3) ? '' : $this->data3;
    }

    public function setData3($data3)
    {
        $this->data3 = $data3;
    }

    public function getData4()
    {
        return is_null($this->data4) ? '' : $this->data4;
    }

    public function setData4($data4)
    {
        $this->data4 = $data4;
    }

    public function getClickid()
    {
        return is_null($this->clickid) ? '' : $this->clickid;
    }

    public function setClickid($clickid)
    {
        $this->clickid = $clickid;
    }

    public function getFirstName()
    {
        return is_null($this->first_name) ? '' : $this->first_name;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function getLastName()
    {
        return is_null($this->last_name) ? '' : $this->last_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function getBrowserLocale()
    {
        if (empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return '';
        }

        return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    }

    public function getState()
    {
        return is_null($this->state) ? '' : $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getCity()
    {
        return is_null($this->city) ? '' : $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getZipCode()
    {
        return is_null($this->zip_code) ? '' : $this->zip_code;
    }

    public function setZipCode($zip_code)
    {
        $this->zip_code = $zip_code;
    }

    public function getEmail()
    {
        return is_null($this->email) ? '' : $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getComment()
    {
        return is_null($this->comment) ? '' : $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getSize()
    {
        return is_null($this->size) ? '' : $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getQuantity()
    {
        return is_null($this->quantity) ? '' : $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getPassword()
    {
        return is_null($this->password) ? '' : $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getLanguageCode()
    {
        return is_null($this->language_code) ? '' : $this->language_code;
    }

    public function setLanguageCode($language_code)
    {
        $this->language_code = $language_code;
    }

    public function getTzName()
    {
        return is_null($this->tz_name) ? '' : $this->tz_name;
    }

    public function setTzName($tz_name)
    {
        $this->tz_name = $tz_name;
    }

    public function getCallTimeFrame()
    {
        return is_null($this->call_time_frame) ? '' : $this->call_time_frame;
    }

    public function setCallTimeFrame($call_time_frame)
    {
        $this->call_time_frame = $call_time_frame;
    }

    public function getMessengerCode()
    {
        return is_null($this->messenger_code) ? '' : $this->messenger_code;
    }

    public function setMessengerCode($messenger_code)
    {
        $this->messenger_code = $messenger_code;
    }

    public function getSaleCode()
    {
        return is_null($this->sale_code) ? '' : $this->sale_code;
    }

    public function setSaleCode($sale_code)
    {
        $this->sale_code = $sale_code;
    }

    public function getIp()
    {
        if ($this->issetXForwarderForIp() && $this->isValidXForwarderForIp()) {
            return $this->getXForwarderForIp();
        }

        if (isset($_SERVER['HTTP_CLIENTIP']) && !empty($_SERVER['HTTP_CLIENTIP'])) {
            return $_SERVER['HTTP_CLIENTIP'];
        }

        if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        }

        return '';
    }

    public function issetXForwarderForIp()
    {
        return isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']);
    }

    public function isValidXForwarderForIp()
    {
        return ip2long($this->parseXForwardedForIp()) !== false;
    }

    public function getXForwarderForIp()
    {
        if ($this->xForwardedForHasSeveralIps()) {
            return $this->parseXForwardedForIp();
        }

        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    private function xForwardedForHasSeveralIps()
    {
        return count($this->getXForwarderForIps()) > 0;
    }

    private function parseXForwardedForIp()
    {
        $ips = $this->getXForwarderForIps();
        $user_ip = reset($ips);

        return $user_ip;
    }

    private function getXForwarderForIps()
    {
        return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    }

    public function getTargetHash()
    {
        return $this->target_hash;
    }

    public function setTargetHash($target_hash)
    {
        $this->target_hash = $target_hash;
    }

    public function getApiKey()
    {
        return $this->api_key;
    }

    public function setApiKey($api_key)
    {
        $this->api_key = $api_key;
    }

    public function getCountryCode()
    {
        return $this->country_code;
    }

    public function setCountryCode($country_code)
    {
        $this->country_code = $country_code;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getPhone2()
    {
        return is_null($this->phone2) ? '' : $this->phone2;
    }

    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function enableWriteLog($enable = false, $log_file_path = '')
    {
        $this->enable_write_log = $enable;
        $this->log_file_path = $log_file_path;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return float|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    private function writeLog()
    {
        @file_put_contents(
            $this->log_file_path,
            sprintf("[%s] %s\n", date("Y-m-d H:i:s"), http_build_query($this->getRequestParams())),
            FILE_APPEND
        );
    }

    public function getCurlInfo()
    {
        return $this->curl_info;
    }
}
