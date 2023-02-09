<?php declare(strict_types=1);
namespace ApiManager;
class ApiManager{
    protected array $_data = array();
    protected int $_code = 0;
    protected string $_message = "";
    protected array $_date = array();
    protected bool $_time_enable = true;
    public function __construct(array $data = array()){
        return $this->init($data);
    }

    public function init(array $data = array()) : self {
        $this->_data = $data ?? array();
        $this->_date['input'] = microtime(true);
        return $this;
    }

    public function header() : void {
        header("Content-type: application/json; charset=utf-8");
    }

    public function setCode(int $code) : self {
        $this->_code = $code ?? 0;
        return $this;
    }

    public function setTimeEnable(bool $bool) : self {
        $this->_time_enable = $bool ?? false;
        return $this;
    }

    public function setMessage(string $message) : self {
        $this->_message = $message ?? "";
        return $this;
    }

    public function setData(array $data) : self {
        $this->_data = $data ?? array();
        return $this;
    }

    protected function endDate() : self {
        $this->_date['completion'] = microtime(true);
        $this->_date['processing'] = ($this->_date['completion'] - $this->_date['input']) ?? 0;
        return $this;
    }
    public function getData() : array {
        $this->endDate();
        $res["code"] = $this->_code;
        if(strlen($this->_message)!=0) $res["message"] = $this->_message;
        if(sizeof($this->_data) != 0) $res["data"] = $this->_data;
        if($this->_time_enable) $res['time'] = $this->_date;
        if(!$this->_time_enable) $res['time'] = round($this->_date['input'],4);
        return $res;
    }

    public function getJson() : string {
        return json_encode($this->getData(),JSON_UNESCAPED_UNICODE);
    }

    public function show() : void {
        echo $this->getJson();
    }

}