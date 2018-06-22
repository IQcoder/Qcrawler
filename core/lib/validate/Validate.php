<?php
/**
 * Created by PhpStorm.
 * User: chenchangqin
 * Date: 18/6/22
 * Time: 下午3:37
 * Description:
 */

namespace Qcrawler\lib\validate;

/**
 * Class Validate
 * @package Qcrawler\lib\validate
 * @method validateInterval(array $arguments)
 * @method validateString(array $arguments)
 * @method validateRequire(array $arguments)
 */
class Validate
{

    private $object;

    public function __construct(object $object)
    {
        $this->object = $object;
    }
    
    public function validate(array $validate)
    {
        if ($validate) {
            foreach ($validate as $value) {
                list($option,$rule) = $value;
                $this->validateValue($option,$rule);
            }
        }
        return true;
    }

    /**
     * @function validateValue
     * @param $option
     * @param $rule
     * @return bool
     * @throws \Exception
     * @author chenchangqin
     * @description
     */
    private function validateValue($option,$rule)
    {
        switch ($rule) {
            case 'integer':
                $this->validateInterval($option);
                break;
            case 'require':
                $this->validateRequire($option);
                break;
            case 'string':
                $this->validateString($option);
                break;
            default:
                throw new \Exception('rule not found');
                break;
        }
        return true;
    }


    public function __call($method, $arguments)
    {
        list($arguments) = $arguments;
        if ($method == 'validateInterval') {
            foreach ($arguments as $value) {
                if (!intval($this->object->$value)) {
                    throw new \Exception("{$value} not integer");
                }
            }
        }
        if ($method == 'validateString') {
            foreach ($arguments as $value) {
                if (!strval($this->object->$value)) {
                    throw new \Exception("{$value} not string");
                }
            }
        }
        if ($method == 'validateRequire') {
            foreach ($arguments as $value) {
                if (!$this->object->$value) {
                    throw new \Exception("{$value} not set");
                }
            }
        }
    }

}